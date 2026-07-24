## ADDED Requirements

### Requirement: User can view purchase history
The system SHALL display a paginated list of all the user's past transactions.

#### Scenario: User views their purchases
- **WHEN** a user navigates to their purchase history page
- **THEN** the system displays a table with columns: Date, Item purchased, Amount (NGN), Status (successful/pending/failed), Reference
- **AND** the table is sorted by most recent first
- **AND** successful transactions show a "View Receipt" button
- **AND** failed transactions show a "Retry Payment" button
