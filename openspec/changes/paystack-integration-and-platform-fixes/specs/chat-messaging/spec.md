## ADDED Requirements

### Requirement: Student can send a message to their instructor
The system SHALL allow students to send a message to any instructor assigned to their class.

#### Scenario: Student sends a message
- **WHEN** a student types a message in the chat widget and clicks Send
- **THEN** the system saves the message to `chat_messages` with: `sender_id` (student), `receiver_id` (instructor), `message` (text), `created_at`
- **AND** the message appears in the chat window immediately

### Requirement: Instructor can reply to a student
The system SHALL allow instructors to reply to messages from students.

#### Scenario: Instructor replies to a student message
- **WHEN** an instructor selects a student from the chat roster and sends a message
- **THEN** the system saves the message with sender_id = instructor, receiver_id = student
- **AND** the message appears in the chat window

### Requirement: Chat widget shows unread message count
The system SHALL display a badge with the count of unread messages.

#### Scenario: User has unread messages
- **WHEN** a user has messages where `read_at` is null and they are the receiver
- **THEN** the chat widget icon shows a badge with the unread count

#### Scenario: User reads messages
- **WHEN** a user opens the chat widget
- **THEN** all unread messages addressed to them are marked as read (read_at = now)
- **AND** the unread badge count resets to zero

### Requirement: Chat polls for new messages
The system SHALL periodically fetch new messages to enable near-real-time communication.

#### Scenario: Chat widget polls for messages
- **WHEN** the chat widget is open
- **THEN** the frontend polls GET /api/chat/messages every 5 seconds
- **AND** new messages are appended to the chat window
- **AND** the polling stops when the widget is closed
