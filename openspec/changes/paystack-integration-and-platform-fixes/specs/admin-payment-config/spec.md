## ADDED Requirements

### Requirement: Admin can set and update prices for classes
The system SHALL allow admins to set, edit, and remove prices on classes through an admin interface.

#### Scenario: Admin sets a price for a class
- **WHEN** an admin navigates to the Class Manager page
- **AND** clicks "Set Price" on a class
- **AND** enters an amount in NGN
- **THEN** the system saves the price in the `pricing` table with `item_type` = "class", `item_id` = class ID, `amount`
- **AND** the class now shows a price badge in the class listing

#### Scenario: Admin removes a price from a class (makes it free)
- **WHEN** an admin clicks "Remove Price" on a class that has a price set
- **THEN** the system sets the pricing record to `is_active` = false
- **AND** the class becomes free to access

### Requirement: Admin can set prices for recorded videos
The system SHALL allow admins to set per-video prices in the recorded video management page.

#### Scenario: Admin sets price for a video
- **WHEN** an admin edits a recorded video
- **AND** fills in a "Price (NGN)" field
- **THEN** the system saves the price in the `pricing` table with `item_type` = "video", `item_id` = video ID, `amount`

### Requirement: Admin can set prices for live classes
The system SHALL allow admins to set per-session prices when creating or editing live class schedules.

#### Scenario: Admin sets price during live class creation
- **WHEN** an admin creates or edits a live class schedule
- **AND** fills in a "Session Price (NGN)" field
- **THEN** the price is stored in the live_class record or `pricing` table

### Requirement: Admin can set prices for quizzes
The system SHALL allow admins to set prices for premium quiz banks.

#### Scenario: Admin sets price for a quiz
- **WHEN** an admin edits a quiz in the Assessment Bank
- **AND** fills in a "Quiz Price (NGN)" field
- **THEN** the price is stored in the `pricing` table
- **AND** students will see a "Purchase Quiz" prompt before attempting it

### Requirement: Admin can view all transactions
The system SHALL provide an admin-only transaction log listing all payments across the platform.

#### Scenario: Admin views transaction log
- **WHEN** an admin navigates to the Transactions page
- **THEN** the system shows a searchable, paginated table with: Reference, User, Item (type + name), Amount, Status, Date
- **AND** the admin can filter by status (completed/pending/failed) and date range
- **AND** the admin can click a transaction to see full details including Paystack response data
