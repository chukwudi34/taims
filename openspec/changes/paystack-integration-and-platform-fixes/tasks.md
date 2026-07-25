## 1. Bug Fixes — Models & Database

- [x] 1.1 Fix `recorded_videos` migration — change `topic_id` FK reference from `topics` (non-existent) to `subject_topics`
- [x] 1.2 Fix `Question` model — restore `belongsTo Quiz` relationship (currently commented out)
- [x] 1.3 Fix `Answer` model — add `belongsTo User` and `belongsTo Option` relationships
- [x] 1.4 Add `$casts` to `Option` model — cast `is_correct` to `boolean`
- [x] 1.5 Add `belongsTo State` relationship on `StateLga` model and `hasMany StateLga` on `State` model

## 2. Mobile Responsiveness

- [x] 2.1 Add `table-responsive` wrapper to all Vue tables missing it (Quiz/Bank/Index, ManageSubjects, ManageTopics)
- [x] 2.2 Fix dashboard stat card grid — change `col-lg-3` to `col-lg-3 col-md-6 col-sm-12` across all 6 cards
- [x] 2.3 Add responsive font-size override for `f_s_60` class — reduce to 32px on screens < 576px
- [x] 2.4 Consolidate sidebar nav items into shared `resources/js/shared/sidebarNav.js` — both Sidebar.vue and Navbar.vue use computed filter over the same array; sidebar made scrollable with `overflow-y: auto`; navbar responsive overrides added for mobile
- [x] 2.5 Remove `maximum-scale=1.0` from viewport meta tag in app.blade.php
- [x] 2.6 Create `_responsive_overrides.scss` and import it into `app.scss` — add targeted overrides for any remaining overflow/overlap issues found during mobile testing
- [ ] 2.7 Audit remaining Vue pages for missing responsive grid classes and fix

## 3. Missing Modules — Attendance

- [x] 3.1 Create `attendance_records` migration
- [x] 3.2 Create `AttendanceRecord` model with relationships
- [x] 3.3 Rewrite `AttendanceController` — implement all methods
- [x] 3.4 Add attendance routes
- [x] 3.5 Build `Attendance/TeacherLiveClass.vue`
- [x] 3.6 Build `Attendance/StudentHistory.vue`
- [x] 3.7 Build `Attendance/AdminReport.vue`
- [x] 3.8 Replace placeholder in `Attendance/Index.vue`

## 4. Missing Modules — Profile

- [x] 4.1 Create `ProfileController`
- [x] 4.2 Add profile routes
- [x] 4.3 Build `Profile/Index.vue`
- [x] 4.4 Add avatar upload handling

## 5. Missing Modules — Chat

- [x] 5.1 Create `chat_messages` migration
- [x] 5.2 Create `ChatMessage` model
- [x] 5.3 Create `ChatController`
- [x] 5.4 Add chat API routes
- [x] 5.5 Replace static chat popup in `Layout.vue`
- [x] 5.6 Build ChatWidget.vue
- [x] 5.7 Add contact roster to ChatWidget

## 6. Paystack — Database & Config

- [x] 6.1 Implement Paystack API via Guzzle (PaystackService)
- [x] 6.2 Add Paystack env vars to `.env.example`
- [x] 6.3 Add Paystack config to `config/services.php`
- [x] 6.4 Create `transactions` migration
- [x] 6.5 Create `pricing` migration
- [x] 6.6 Create `Transaction` model
- [x] 6.7 Create `Pricing` model

## 7. Paystack — Checkout Flow

- [x] 7.1 Create `PaymentController` — implement `checkout()`, `callback()`, `webhook()`
- [x] 7.2 Create `PaystackService` — `initializeTransaction()`, `verifyTransaction()`, `verifyWebhookSignature()`
- [x] 7.3 Add payment routes (checkout auth, callback, webhook no-CSRF)
- [x] 7.4 Add Paystack webhook route to CSRF exception
- [x] 7.5 Build checkout flow (create transaction, call Paystack, return redirect)
- [x] 7.6 Build callback handler (verify transaction, update status, grant access)
- [x] 7.7 Build webhook handler (verify signature, process charge.success, idempotency)

## 8. Paystack — Access Control Middleware

- [x] 8.1 Create `HasAccess` middleware
- [x] 8.2 Apply `access:quiz` middleware to `start_quiz` route
- [x] 8.3 Add helper methods to User model

## 9. Paystack — Purchase History (User)

- [x] 9.1 Create `PurchaseController`
- [x] 9.2 Add route: `GET /purchases`
- [x] 9.3 Build `Purchases/Index.vue`
- [x] 9.4 Build `PaymentModal.vue`

## 10. Paystack — Admin Payment Config

- [x] 10.1 Create `AdminPaymentController`
- [x] 10.2 Add admin payment routes
- [x] 10.3 Build `Admin/Payment/Pricing.vue`
- [x] 10.4 Build `Admin/Payment/Transactions.vue`
- [x] 10.5 Add sidebar links for admin payment pages

## 11. Security — Role Authorization

- [x] 11.1 Create `RoleMiddleware`
- [x] 11.2 Register middleware in Kernel
- [x] 11.3 Apply `role:3` middleware to admin route group
- [ ] 11.4 Replace frontend-only role checks with server-side middleware

## 12. Cleanup & Code Quality

- [x] 12.1 No vendor directory exists — N/A
- [x] 12.2 Marked legacy auth controllers with `@deprecated` comment
- [ ] 12.3 Clean up commented code in models (Question.php duplicate options method, unused imports)
- [x] 12.4 All assets compiled successfully (npm run dev) — CSS + JS bundles built with no errors
