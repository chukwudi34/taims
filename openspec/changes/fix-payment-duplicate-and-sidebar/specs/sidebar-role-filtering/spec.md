## ADDED Requirements

### Requirement: Sidebar filters navigation items by user role
The sidebar SHALL display only navigation items whose `roles` array includes the authenticated user's `user_type_id`. Items with `roles: null` SHALL be visible to all user types.

#### Scenario: Admin user sees admin-only menu items
- **WHEN** a user with `user_type_id = 3` (admin) is authenticated
- **THEN** the sidebar SHALL display items with `roles: [3]` (Class Manager, Curriculum, Assessment Setup, Payment Pricing, Transactions, Manage Users)
- **THEN** the sidebar SHALL display items with `roles: null` (Dashboard, Live Class, Recorded Video, Attendance, Profile)
- **THEN** the sidebar SHALL NOT display items with `roles: [2]` (Assessment Quiz, My Purchases)

#### Scenario: Learner user sees only learner-accessible items
- **WHEN** a user with `user_type_id = 2` (learner) is authenticated
- **THEN** the sidebar SHALL display items with `roles: [2]` (Assessment Quiz, My Purchases)
- **THEN** the sidebar SHALL display items with `roles: null` (Dashboard, Live Class, Recorded Video, Attendance, Profile)
- **THEN** the sidebar SHALL NOT display items with `roles: [3]` or `roles: [1, 3]`

#### Scenario: Instructor user sees combined items
- **WHEN** a user with `user_type_id = 1` (instructor) is authenticated
- **THEN** the sidebar SHALL display items with `roles: [1, 3]` (Assessment Bank)
- **THEN** the sidebar SHALL display items with `roles: null` (Dashboard, Live Class, Recorded Video, Attendance, Profile)
- **THEN** the sidebar SHALL NOT display items with `roles: [3]` (admin-only) or `roles: [2]` (learner-only)

### Requirement: Mobile sidebar respects same filtering
The mobile sidebar (`b-sidebar` in `Navbar.vue`) SHALL use the identical filtering logic as the desktop sidebar.

#### Scenario: Learner on mobile sees learner menu
- **WHEN** a learner views the site on a mobile device (< 768px)
- **AND** opens the mobile sidebar via the hamburger icon
- **THEN** the mobile sidebar SHALL display the same filtered items as the desktop sidebar would for that user

### Requirement: Users have non-null user_type_id
All user records in the database SHALL have a non-null `user_type_id` value.

#### Scenario: Backfill null user_type_id
- **WHEN** a user exists with `user_type_id IS NULL`
- **THEN** an Artisan command or migration SHALL set the default `user_type_id` based on the `user_types` table registration data, or default to `2` (learner)

### Requirement: Compiled JS assets reflect latest source
The production JS bundle on the live server SHALL be rebuilt from the latest source files.

#### Scenario: Deploy fresh build
- **WHEN** `npm run production` completes
- **THEN** the compiled `public/js/app.js` SHALL include the current `sidebarNav.js` with correct role arrays and filtering logic
