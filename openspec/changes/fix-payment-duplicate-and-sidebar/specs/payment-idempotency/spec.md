## ADDED Requirements

### Requirement: Backend prevents duplicate pending transactions
The `PaymentController::checkout()` method SHALL check for an existing `pending` transaction with the same `(user_id, item_type, item_id)` before creating a new one. If a valid pending transaction exists, it SHALL reuse that transaction's Paystack authorization URL instead of initializing a new one.

#### Scenario: Same user purchases same item while first payment is pending
- **WHEN** user calls `/payment/checkout` with `item_type=live_class` and `item_id=1`
- **AND** a `pending` Transaction already exists for the same user and `item_type=live_class`, `item_id=1`
- **AND** the existing transaction's Paystack reference is still valid
- **THEN** the system SHALL NOT create a new Transaction record
- **THEN** the system SHALL return the existing transaction's `authorization_url`

#### Scenario: Expired pending transaction is replaced
- **WHEN** user calls `/payment/checkout` with `item_type=live_class` and `item_id=1`
- **AND** a `pending` Transaction exists but its Paystack reference has expired
- **THEN** the system SHALL mark the existing transaction as `failed`
- **THEN** the system SHALL create a new Transaction with a fresh reference

### Requirement: Database has partial unique index on pending transactions
A partial unique index SHALL exist on `transactions(user_id, item_type, item_id)` WHERE `status = 'pending'` to prevent duplicate pending records at the database level.

#### Scenario: Duplicate pending insert is rejected by database
- **WHEN** a second `INSERT` is attempted for `(user_id, item_type, item_id)` while a `pending` record already exists
- **THEN** the database SHALL reject the insert with a constraint violation

### Requirement: Checkout is wrapped in a database transaction
The checkout logic SHALL be wrapped in `DB::transaction()`. If the Paystack API call fails after the Transaction record is created, the record SHALL be rolled back.

#### Scenario: Paystack API fails after transaction creation
- **WHEN** `Transaction::create()` succeeds
- **AND** `PaystackService::initializeTransaction()` throws an exception
- **THEN** the Transaction record SHALL be rolled back
- **THEN** the user SHALL receive an error response

### Requirement: Thread-safe status transition
The `callback()` and `webhook()` methods SHALL use atomic updates with a `WHERE status = 'pending'` condition to prevent double-processing in race conditions.

#### Scenario: Callback and webhook race to complete the same transaction
- **WHEN** both `callback()` and `webhook()` execute simultaneously for the same transaction
- **AND** both attempt `WHERE reference = X AND status = 'pending'` update
- **THEN** only one SHALL succeed in updating status to `completed`
- **THEN** the second SHALL see status already changed and return early

### Requirement: Transaction references use UUIDs
Transaction references SHALL be generated using `Str::uuid()` instead of `uniqid()`.

#### Scenario: Reference generation
- **WHEN** a new Transaction is created
- **THEN** its `reference` SHALL be a UUID string starting with `TXN-` prefix

### Requirement: Paystack popup callback verifies transaction before UI refresh
When the Paystack popup fires its success callback, the frontend SHALL call the server to verify the transaction before refreshing the item list. This ensures `has_access` is `true` when the UI re-renders.

#### Scenario: User completes payment in Paystack popup
- **WHEN** the Paystack popup `callback` fires after successful payment
- **THEN** the frontend SHALL send a GET request to `/payment/callback?reference=XXX`
- **THEN** the server SHALL verify the transaction with Paystack API and update status to `completed`
- **THEN** the frontend SHALL call `fetchLiveClassData()` / `fetchRecordedVideos()`
- **THEN** the item SHALL have `has_access = true`
- **THEN** the Pay button SHALL be replaced with "Join Class" or "Access granted"

#### Scenario: Payment callback returns HTML — handled gracefully
- **WHEN** the frontend calls `/payment/callback` via AJAX
- **THEN** the HTML response SHALL be ignored (the side effect of status update is what matters)
- **THEN** no error SHALL be thrown to the user

#### Scenario: Payment verification fails
- **WHEN** the server verifies the transaction with Paystack and it fails
- **THEN** the frontend SHALL show an error toast: "Payment verification failed. Contact support."
- **THEN** the Pay button SHALL remain visible so the user can retry

### Requirement: Frontend buttons lock during payment flow
Payment buttons SHALL remain disabled from the moment the user clicks Pay until either the Paystack payment flow completes and redirects back, or an explicit error occurs.

#### Scenario: User clicks Pay while already paying
- **WHEN** the Pay button is clicked
- **THEN** the button SHALL become disabled immediately
- **WHEN** the user clicks the disabled button again
- **THEN** no additional `/payment/checkout` request SHALL be sent

#### Scenario: Button re-enables on Paystack error
- **WHEN** the Paystack popup encounters an error or is closed without completion
- **THEN** the button SHALL re-enable so the user can retry
- **WHEN** the user retries
- **THEN** the existing pending transaction SHALL be reused (per backend idempotency)
