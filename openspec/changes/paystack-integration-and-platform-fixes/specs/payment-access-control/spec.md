## ADDED Requirements

### Requirement: Gate class enrollment behind payment
The system SHALL only allow students to access a class if they have an active payment or subscription for that class.

#### Scenario: Student attempts to view class content without payment
- **WHEN** a student who has not paid for a class attempts to view its content (subjects, topics, live classes, recorded videos)
- **THEN** the system shows a "Purchase Access" page with the class price and a "Pay Now" button
- **AND** the student cannot access any class-specific resources

#### Scenario: Student with active payment accesses class
- **WHEN** a student who has paid for a class attempts to access its content
- **THEN** the system allows full access to all subjects, topics, live classes, and recorded videos within that class

### Requirement: Gate premium recorded videos behind payment
The system SHALL only allow users to view premium recorded videos if they have purchased that video, have class-level access, or have an active subscription.

#### Scenario: User attempts to view a premium video without payment
- **WHEN** a user clicks on a premium recorded video
- **THEN** the system shows a "Purchase Video" overlay with the price
- **AND** the video player is disabled until payment is confirmed

#### Scenario: User who purchased the video views it
- **WHEN** a user who has purchased a specific video clicks to view it
- **THEN** the video plays without any payment prompt

### Requirement: Gate live class sessions behind payment
The system SHALL require payment before a user can join or schedule a live class session.

#### Scenario: Student attempts to join unpaid live class
- **WHEN** a student clicks "Join" on a live class they have not paid for
- **THEN** the system shows a "Pay to Join" prompt with the session price
- **AND** the student is redirected to checkout upon confirmation

#### Scenario: Student with access joins live class
- **WHEN** a student who has paid for the live class clicks "Join"
- **THEN** the system redirects them to the meeting URL

### Requirement: Gate premium quiz bank behind payment
The system SHALL require payment before a user can take a premium quiz or assessment.

#### Scenario: Student attempts to take a premium quiz without payment
- **WHEN** a student clicks "Start Quiz" on a premium quiz
- **THEN** the system shows a "Purchase Quiz" prompt with the price
- **AND** the quiz does not start until payment is confirmed

#### Scenario: Student with access takes premium quiz
- **WHEN** a student who has paid for the quiz clicks "Start Quiz"
- **THEN** the quiz begins normally
