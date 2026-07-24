## Why

TAIMS is an educational platform with no monetization layer, several incomplete modules (Attendance, Profile, Chat), responsiveness gaps that hurt mobile users, and code-level bugs (broken FK references, missing Eloquent relationships, dead code). This change monetizes the platform via Paystack, fixes critical bugs, completes placeholder modules, and makes the entire app mobile-responsive.

## What Changes

**Paystack Payment Integration**
- Pay-per-class access (students pay to enroll in a class tier)
- Premium recorded video content behind a paywall (pay-per-view)
- Paid live class sessions (one-time fee per session)
- Paid assessments / premium quiz banks
- Payment webhook handling, transaction history, and user purchase history
- Pricing configuration via admin panel

**System-Wide Bug Fixes**
- Fix `recorded_videos.topic_id` FK reference from non-existent `topics` to `subject_topics`
- Fix `Question` model — restore commented-out `belongsTo Quiz` relationship
- Fix `Answer` model — add missing Eloquent relationships (`user()`, `option()`)
- Cast `Option.is_correct` to boolean
- Add relationships to `State`, `StateLga` models

**Complete Missing Modules**
- Build Attendance module (teacher marks attendance per live/recorded class; student views history)
- Build Profile page (edit personal info, change password, upload avatar, view activity)
- Build functional Chat widget (real-time messaging between students and instructors)

**Mobile Responsiveness**
- Add `table-responsive` wrappers to all tables lacking them
- Fix dashboard card grid — add `col-md-6` and `col-sm-12` breakpoints
- Add responsive font-size overrides for `f_s_60` and other hardcoded sizes
- Consolidate dual sidebar nav into single source of truth
- Remove `maximum-scale=1.0` from viewport meta
- Audit all Vue pages for missing responsive grid classes

**Code Quality & Security**
- Add role-based authorization middleware to enforce server-side access control
- Remove unused vendor JS/CSS assets from layout
- Remove dead legacy auth controllers (or mark unused)
- Clean up unused/commented code in models and views

## Capabilities

### New Capabilities
- `payment-paystack`: Paystack payment gateway integration — checkout, webhooks, transaction records, pricing plans
- `payment-access-control`: Gating content (classes, videos, live sessions, quizzes) behind payment verification
- `purchase-history`: User purchase history dashboard showing past transactions and receipts
- `attendance-module`: Complete attendance tracking for live and recorded classes
- `profile-module`: User profile management — edit info, change password, avatar upload
- `chat-messaging`: Real-time messaging between students and instructors
- `mobile-responsiveness`: Full responsive audit and fixes across all admin Vue pages
- `admin-payment-config`: Admin panel for configuring pricing and viewing all transactions

### Modified Capabilities
<!-- No existing specs to modify. -->

## Impact

- **New PHP package**: `unicodeveloper/laravel-paystack` or direct Paystack API via Guzzle
- **New database tables**: `transactions`, `pricing`, `attendance_records`, `chat_messages`
- **New controllers**: `PaymentController`, `AttendanceController` (rewrite), `ProfileController`, `ChatController`
- **New Vue pages**: Purchase history, attendance views, profile editor, chat widget
- **Modified models**: `User` (add `Billable`-like fields?), `Classes` (add pricing), `RecordedVideo` (add price/tier), `LiveClass` (add price), `Quiz` (add price/tier)
- **Routes added**: Payment webhook, checkout, attendance CRUD, profile CRUD, chat endpoints
- **CSS**: Major cleanup of 11k-line style.css; responsive overrides added
- **Accessibility**: `maximum-scale=1.0` removed
