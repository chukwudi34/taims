## ADDED Requirements

### Requirement: Initialize Paystack checkout for a purchase
The system SHALL create a Paystack checkout session when a user initiates a payment for any purchasable item (class enrollment, video, live session, quiz).

#### Scenario: User clicks "Pay Now" on a class enrollment
- **WHEN** an authenticated user clicks "Pay Now" on a class enrollment page
- **THEN** the system creates a transaction record with status `pending`
- **AND** the system calls Paystack Initialize API with the correct amount, email, metadata (item type, item ID, user ID)
- **AND** the system returns the Paystack authorization URL to the frontend
- **AND** the frontend redirects the user to the Paystack checkout page

#### Scenario: Paystack redirects user back after successful payment
- **WHEN** Paystack redirects the user to the callback URL with a `reference` query parameter
- **THEN** the system calls Paystack Verify API to confirm the transaction status
- **AND** if verified as `success`, the system updates the transaction record to `completed`
- **AND** the system grants access to the purchased item
- **AND** the system redirects the user to the appropriate dashboard/confirmation page

#### Scenario: Paystack redirects user back after failed payment
- **WHEN** Paystack redirects the user to the callback URL and verification shows a non-success status
- **THEN** the system updates the transaction record to `failed`
- **AND** the system shows an error message to the user
- **AND** the user is given an option to retry payment

### Requirement: Handle Paystack webhook events
The system SHALL accept and process Paystack webhook events at a public endpoint without CSRF protection.

#### Scenario: Successful charge webhook received
- **WHEN** Paystack sends a `charge.success` webhook event
- **THEN** the system verifies the webhook signature using the secret key
- **AND** the system looks up the transaction by `reference`
- **AND** the system updates the transaction status to `completed` if not already completed
- **AND** the system grants access to the purchased item
- **AND** the system logs the webhook event

#### Scenario: Duplicate webhook received (idempotency)
- **WHEN** Paystack sends a duplicate `charge.success` webhook event for an already-completed transaction
- **THEN** the system SHALL NOT create duplicate access grants
- **AND** the system returns HTTP 200 OK to acknowledge receipt

### Requirement: Record all transactions
The system SHALL maintain a `transactions` table recording every payment attempt.

#### Scenario: Transaction saved on initialization
- **WHEN** a checkout is initialized
- **THEN** a record is created in `transactions` with: `reference` (unique), `user_id`, `amount`, `currency` (NGN), `status` (pending), `item_type`, `item_id`, `metadata` (JSON), `created_at`

#### Scenario: Transaction updated on completion
- **WHEN** a transaction is verified as successful
- **THEN** the `transactions` record is updated with: `status` (completed), `paystack_response` (full JSON response), `paid_at` (timestamp)

#### Scenario: Transaction marked failed
- **WHEN** verification fails or webhook indicates failure
- **THEN** the `transactions` record status is set to `failed`
- **AND** the `failure_reason` field records the error detail

### Requirement: Define pricing tiers per item type
The system SHALL support configurable pricing for classes, videos, live sessions, and quizzes via an admin panel and a `plans`/`pricing` table.

#### Scenario: Admin sets a price for a class
- **WHEN** an admin sets a price for a class in the admin panel
- **THEN** the price is stored in a `pricing` table with `item_type` (class/video/live_class/quiz), `item_id`, `amount`, `currency` (NGN), `is_active`

#### Scenario: User sees price before purchase
- **WHEN** a user views a gated item
- **THEN** the system displays the price prominently with a "Pay Now" button
- **AND** if the user already has access, the system shows "You have access" instead
