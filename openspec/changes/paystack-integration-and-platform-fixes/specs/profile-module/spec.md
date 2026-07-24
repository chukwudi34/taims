## ADDED Requirements

### Requirement: User can view their profile
The system SHALL display the authenticated user's profile information.

#### Scenario: User views profile page
- **WHEN** an authenticated user navigates to their profile page
- **THEN** the system displays: first name, last name, email, phone, gender, date of birth, address, state/LGA, class (for students), parent email (for students)
- **AND** the user's avatar/profile image is displayed

### Requirement: User can edit profile information
The system SHALL allow users to update their editable profile fields.

#### Scenario: User updates name and phone
- **WHEN** a user edits their first name, last name, and phone number
- **AND** clicks "Save Changes"
- **THEN** the system validates the input
- **AND** updates the user record in the database
- **AND** shows a success toast notification

### Requirement: User can change their password
The system SHALL allow users to change their password by providing current and new passwords.

#### Scenario: User changes password successfully
- **WHEN** a user enters their current password, a new password, and confirmation
- **AND** clicks "Change Password"
- **THEN** the system validates that the current password matches
- **AND** checks that new password meets minimum requirements (8+ characters)
- **AND** updates the password
- **AND** shows a success message

#### Scenario: User enters wrong current password
- **WHEN** a user enters an incorrect current password
- **THEN** the system shows an error: "Current password is incorrect"
- **AND** the password is not changed

### Requirement: User can upload an avatar image
The system SHALL allow users to upload a profile photo.

#### Scenario: User uploads new avatar
- **WHEN** a user selects an image file (jpg, png, webp) under 2MB
- **THEN** the system uploads the image to storage
- **AND** updates the user's `image` field with the file path
- **AND** displays the new avatar immediately

#### Scenario: User uploads an oversized image
- **WHEN** a user selects an image file larger than 2MB
- **THEN** the system shows an error: "Image must be under 2MB"
- **AND** the avatar is not updated
