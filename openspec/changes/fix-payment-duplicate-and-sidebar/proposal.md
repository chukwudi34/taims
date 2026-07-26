## Why

The payment system creates duplicate transaction records when users pay for the same item multiple times (via button re-clicks or retries), and role-based sidebar navigation is broken on the live server — all user types see the same menu items regardless of their role.

## What Changes

- Add idempotency guard in `PaymentController::checkout()` to prevent duplicate pending transactions for the same user+item
- Fix frontend payment buttons so they don't re-enable before the Paystack flow completes
- Add database-level unique constraint on `(user_id, item_type, item_id, status)` to prevent duplicates at the schema level
- Wrap payment checkout in a database transaction with rollback on Paystack failure
- Replace `uniqid()` with `Str::uuid()` for transaction references
- Rebuild compiled assets on the live server to reflect sidebar role filtering
- Ensure `user_type_id` is always populated for existing users missing it

## Capabilities

### New Capabilities
- `payment-idempotency`: Prevent duplicate transaction records via backend guard, frontend lock, and database constraint
- `sidebar-role-filtering`: Ensure the sidebar correctly filters navigation items by user role on all environments

### Modified Capabilities
(no existing specs to modify)

## Impact

- `app/Http/Controllers/PaymentController.php` — checkout logic, reference generation
- `app/Http/Controllers/DigitalClassController.php` — access checks (minor)
- `app/Models/Transaction.php` — guarded/fillable refinement
- `database/migrations/` — new migration for unique constraint
- `resources/js/components/PaymentModal.vue` — button disable logic
- `resources/js/Pages/Client/DigitalClass/RecordedVideos/Videos.vue` — button disable logic
- `resources/js/Pages/Client/DigitalClass/StudentLiveClass/Index.vue` — button disable logic
- `resources/js/Pages/BaseLayouts/Sidebar.vue` — confirm filtering is correct
- `resources/js/Pages/BaseLayouts/Navbar.vue` — confirm filtering is correct
- `resources/js/shared/sidebarNav.js` — confirm role arrays are correct
- Live server: re-run `npm run production` to deploy fresh JS build
