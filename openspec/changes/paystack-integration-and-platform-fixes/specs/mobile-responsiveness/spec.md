## ADDED Requirements

### Requirement: All data tables must be horizontally scrollable on mobile
Every `<table>` element in the admin Vue pages SHALL be wrapped in a Bootstrap `table-responsive` class container to enable horizontal scrolling on small screens.

#### Scenario: User views a table on a mobile device
- **WHEN** a user opens any page containing a data table on a screen < 768px wide
- **THEN** the table is wrapped in a `div.table-responsive`
- **AND** the user can horizontally scroll to see all columns
- **AND** no content is cut off or overlaps

### Requirement: Dashboard stat cards must stack responsively
The dashboard stat cards SHALL display in a responsive grid: 4 columns on desktop, 2 columns on tablet, 1 column on mobile.

#### Scenario: User views dashboard on tablet
- **WHEN** a user opens the dashboard on a 768px–991px wide screen
- **THEN** the stat cards are arranged in a 2-column grid (2 rows x 2 columns for 4 cards)

#### Scenario: User views dashboard on mobile phone
- **WHEN** a user opens the dashboard on a screen < 576px wide
- **THEN** the stat cards stack vertically in a single column

### Requirement: Large stat numbers must scale down on mobile
Dashboard stat numbers using the `f_s_60` class SHALL be reduced to 32px on screens < 576px.

#### Scenario: Mobile user sees dashboard stat numbers
- **WHEN** a user views the dashboard on a screen < 576px wide
- **THEN** stat numbers are displayed at a maximum of 32px font size

### Requirement: Sidebar navigation must be consolidated
The sidebar navigation menu SHALL be defined in a single data structure shared between the desktop sidebar (Sidebar.vue) and the mobile offcanvas sidebar (Navbar.vue) to eliminate duplication.

#### Scenario: Navigation items are maintained in one place
- **WHEN** a new navigation item needs to be added
- **THEN** it is added to a single nav items array/mixin
- **AND** both the desktop sidebar and mobile sidebar render from the same data source

### Requirement: Viewport must allow user zoom
The viewport meta tag SHALL NOT use `maximum-scale=1.0` to allow users to pinch-zoom for accessibility.

#### Scenario: User pinch-zooms on mobile
- **WHEN** a user pinches to zoom on a mobile device
- **THEN** the browser allows zooming
- **AND** no `maximum-scale` restriction prevents it
