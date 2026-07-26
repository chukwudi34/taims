## Context

TAIMS uses Paystack for payment processing. The `checkout()` endpoint in `PaymentController` creates a `Transaction` record on every call without checking for existing pending transactions for the same user+item. Frontend payment buttons re-enable in the `finally` block after the checkout API responds, allowing users to click Pay multiple times before the Paystack popup completes. This produces duplicate `pending` and even `completed` transaction records.

The sidebar uses role-based filtering via a `roles` array in `sidebarNav.js`. The filtering logic in `Sidebar.vue` and `Navbar.vue` is correct, but the live server has stale compiled JS assets that don't include the filtering feature.

## Goals / Non-Goals

**Goals:**
- Eliminate duplicate `Transaction` records for the same `(user_id, item_type, item_id)` combination
- Ensure the checkout button cannot be double-clicked to submit multiple requests
- Guard against race conditions between the Paystack callback and webhook
- Make the sidebar correctly filter menu items by `user_type_id` on all environments
- Add a database-level constraint as a safety net

**Non-Goals:**
- Adding new payment gateways (Flutterwave is loaded but not implemented — out of scope)
- Building a full subscription/billing system
- Redesigning the payment UI (only fixing the button lock)
- Adding payment to items that are currently free (classes, etc.)
- Responsive design fixes (separate change needed)

## Decisions

### Decision 1: Backend idempotency via pending-transaction reuse
Instead of creating a new Transaction on every `/payment/checkout` call, first query for an existing `pending` Transaction with the same `(user_id, item_type, item_id)`. If found, return its existing Paystack authorization URL. If it has expired or failed, create a fresh one.

- **Alternative considered:** Relying solely on the frontend button disable — rejected because API-level protection is needed against network retries and race conditions.
- **Alternative considered:** UUID idempotency key — unnecessary complexity; the business key `(user, item_type, item_id)` is sufficient for this domain.

### Decision 2: Database-level unique partial index
Add a partial unique index on `(user_id, item_type, item_id)` WHERE `status = 'pending'`. This prevents duplicate pending records at the database level as a safety net.

- **Alternative considered:** Unique constraint on all statuses — rejected because multiple `failed` records are acceptable (each represents a distinct failed attempt).
- **Alternative considered:** Application-level check only — rejected because defense-in-depth is cheap here.

### Decision 3: Verify transaction in Paystack popup callback before UI refresh
The Paystack popup `callback` fires client-side immediately after payment confirmation, but the server-side webhook may not have arrived yet. Without explicit verification, `fetchLiveClassData()` returns `has_access = false`, and the Pay button remains visible despite a successful payment.

**Solution:** In the popup `callback`, call `GET /payment/callback?reference=XXX` (the existing verification endpoint) before refreshing the list. The `/payment/callback` route currently returns HTML (for the redirect flow), but the side effect of calling Paystack's verify API and updating the DB is what matters. The HTML response is simply discarded in the AJAX context.

- **Alternative considered:** Polling/retry loop — more complex, adds latency, user sees button flash.
- **Alternative considered:** Server-Sent Events / WebSocket push — overkill for this use case.
- **Alternative considered:** Making the frontend optimistically set `has_access = true` — risky; could grant access before payment is confirmed.

### Decision 4: Frontend button lock during entire payment flow
Move the button `loading` flag reset from the `finally` block to only after the Paystack callback redirect completes (or on explicit error). For the iframe flow, keep `paying = true` until the Paystack popup closes with a success/failure outcome.

- **Alternative considered:** Server-side token-based lock — overkill for preventing accidental double-clicks.

### Decision 5: Replace `uniqid()` with `Str::uuid()`
Use Laravel's `Str::uuid()` for transaction references. `uniqid()` without `more_entropy` is timestamp-based and theoretically collidable under high concurrency.

### Decision 6: Wrap checkout in a database transaction
Wrap the checkout logic in `DB::transaction()` so that if the Paystack initialization API call fails after the Transaction is created, the record is rolled back instead of leaving orphaned `pending` records.

### Decision 7: Sidebar fix = recompile + seed data check
The sidebar Vue logic is already correct. The live server fix is:
1. Re-run `npm run production` to compile fresh assets
2. Verify that all users in the database have a non-null `user_type_id`
3. Add an Artisan command or migration to backfill any users with null `user_type_id`

## Risks / Trade-offs

| Risk | Mitigation |
|------|-----------|
| [High] Reusing a pending transaction whose Paystack session has expired | Before reusing, verify the Paystack reference is still valid, or mark it `failed` and create a new one |
| [Medium] Race condition between callback + webhook on the same transaction | Use atomic `where('status', 'pending')->update(...)` instead of read-then-write |
| [Low] Frontend button still re-enabled if user closes browser tab during Paystack redirect | Acceptable — the backend idempotency guard protects against duplicates |
| [Low] The partial unique index could collide with existing duplicate records in production | The migration must clean up duplicates before applying the index, or use `CREATE UNIQUE INDEX ... WHERE ...` that allows existing duplicates |
