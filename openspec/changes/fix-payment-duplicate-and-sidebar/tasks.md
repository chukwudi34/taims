## 1. Backend Payment Idempotency

- [x] 1.1 Add pending-transaction reuse check in `PaymentController::checkout()` — query existing `(user_id, item_type, item_id, status=pending)` before creating
- [x] 1.2 Handle expired pending transactions — mark as `failed` and create fresh when Paystack reference is invalid
- [x] 1.3 Replace `uniqid()` with `Str::uuid()` for transaction references in `checkout()`
- [x] 1.4 Wrap `checkout()` logic in `DB::transaction()` with rollback on Paystack failure
- [x] 1.5 Make callback and webhook status transitions atomic using `where('status', 'pending')`

## 2. Database Constraint

- [x] 2.1 Create a migration to add a partial unique index on `transactions(user_id, item_type, item_id)` WHERE `status = 'pending'`
- [x] 2.2 Add cleanup logic for any existing duplicate pending records before applying the index
- [x] 2.3 Update `Transaction` model `$guarded = []` to explicit `$fillable` allow-list for security

## 3. Frontend Button Locking & Verification

- [x] 3.1 Fix `PaymentModal.vue` — move `loading = false` out of `finally`, keep locked until redirect or explicit error
- [x] 3.2 Fix `Videos.vue` — move `paying = false` out of `finally`, keep locked until Paystack popup completes or errors
- [x] 3.3 Fix `StudentLiveClass/Index.vue` — same fix as Videos.vue for the `paying` flag
- [x] 3.4 Fix `Videos.vue` — in Paystack popup `callback`, call `GET /payment/callback?reference=XXX` to verify transaction before calling `fetchRecordedVideos()`
- [x] 3.5 Fix `StudentLiveClass/Index.vue` — same verification call in the popup `callback` before `fetchLiveClassData()`
- [x] 3.6 Handle verification failure in both popup callbacks — show error toast, keep Pay button visible for retry

## 4. Sidebar Role Filtering (Live Server)

- [x] 4.1 Create an Artisan command `users:backfill-user-type` to set `user_type_id` for any users where it's null (default to learner `2`)
- [x] 4.2 Verify `sidebarNav.js` role arrays are correct for all 14 nav items
- [x] 4.3 Verify `Sidebar.vue` computed property uses `$page.props.auth?.user?.user_type_id` correctly
- [x] 4.4 Verify `Navbar.vue` mobile sidebar uses identical filtering logic
- [ ] 4.5 Run `npm run production` and deploy fresh compiled JS assets to live server **(deploy step)**
- [ ] 4.6 Test sidebar on all 3 user types (admin, instructor, learner) on the live server **(deploy step)**
