## ADDED Requirements

### Requirement: Teacher can create an attendance session for a live class
The system SHALL allow teachers to create an attendance record linked to a live class session they created.

#### Scenario: Teacher starts attendance for a live class
- **WHEN** a teacher navigates to the attendance page for a specific live class
- **THEN** the system shows a list of all students enrolled in that class
- **AND** the teacher can mark each student as Present, Absent, or Excused
- **AND** the teacher can submit the attendance record

#### Scenario: Attendance saved successfully
- **WHEN** the teacher submits the attendance record
- **THEN** the system saves each student's attendance status to the `attendance_records` table
- **AND** the teacher sees a success confirmation

### Requirement: Student can view their attendance history
The system SHALL allow students to view their own attendance record across all live classes.

#### Scenario: Student views attendance history
- **WHEN** a student navigates to the attendance page
- **THEN** the system displays a table with: Date, Live Class topic, Subject, Status (Present/Absent/Excused)
- **AND** the table shows a percentage attendance rate (e.g., "85% attendance")

### Requirement: Admin can view attendance reports
The system SHALL allow admins to view attendance statistics across all classes and teachers.

#### Scenario: Admin views class attendance report
- **WHEN** an admin selects a class from the attendance report page
- **THEN** the system shows aggregate attendance statistics per student (name, total sessions, present count, absent count, percentage)
- **AND** the admin can export the report as CSV
