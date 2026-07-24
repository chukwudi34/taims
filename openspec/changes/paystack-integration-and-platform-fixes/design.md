## Context

TAIMS runs on Laravel 9 + Vue 2 (Inertia.js) + Bootstrap 4 + MySQL. The app currently has zero payment infrastructure despite Flutterwave SDK being loaded in layouts. Several modules are stubs (Attendance, Profile, Chat). The custom CSS (11k+ lines) has responsive media queries but coverage is inconsistent across Vue pages. The database has minor FK reference errors and several models lack Eloquent relationships.

The app serves three user roles (student/learner=2, instructor/teacher=1, admin=3) in a Nigerian educational context. All monetary values will be in NGN.

## Goals / Non-Goals

**Goals:**
- Integrate Paystack as the sole payment gateway — checkout, verify, webhook
- Gate content access (classes, videos, live sessions, quizzes) behind payment verification
- Provide user purchase history dashboard with transaction history and receipts
- Provide admin pricing configuration panel
- Build full Attendance module (create sessions, mark attendance, view history)
- Build full Profile module (edit info, change password, upload avatar)
- Build functional Chat widget (real-time messaging via polling or Pusher)
- Fix all identified DB/model bugs (FK references, missing relationships, cast issues)
- Make all admin Vue pages fully responsive on mobile devices
- Add server-side role authorization middleware
- Reduce page weight by removing unused vendor assets

**Non-Goals:**
- No multi-gateway support (Paystack only for now)
- No subscription plans or recurring billing (one-time purchases only)
- No SMS or push notifications for chat
- No offline/PWA support
- No migration from Bootstrap to Tailwind (keep Bootstrap 4)
- No full CSS rewrite — targeted responsive overrides only

## Decisions

### Paystack SDK: server-side API via Guzzle over JS popup checkout
The Paystack standard checkout (redirect) model is simpler and more secure than the JS popup. Users are redirected to Paystack, then back to a callback URL. The server verifies the transaction before granting access. No PCI scope concerns.

Alternatives considered: Flutterwave (SDK already loaded in layouts but no PHP backend package, and user specifically chose Paystack). Paystack.js popup is an option for a smoother UX but adds frontend complexity.

### Access control: middleware gates per resource
Each gated resource type (Class, Video, LiveClass, Quiz) will have a middleware or policy that checks if the authenticated user has an active payment/access for that item. This keeps access logic at the route/controller level rather than sprinkled in views.

### One-time purchase model
All payments are one-time. Pay-per-class enrollment grants permanent access to that class. Pay-per-video, pay-per-live-session, and pay-per-quiz grant access to the specific item. No recurring billing or subscription plans.

### Attendance: tracking via existing LiveClass + new attendance table
Attendance is tied to LiveClass sessions. Teacher marks which students attended. A new `attendance_records` table links user → live_class → status (present/absent/excused). Recorded videos get a simpler "watched" boolean.

### Chat: polling-based MVP over Pusher
Real Pusher integration adds cost and complexity. For MVP, chat will use short-polling (every 5s) via a simple messages API. This can be upgraded to WebSockets/Pusher later without changing the data model.

### Responsive: targeted CSS overrides in a new `_responsive_overrides.scss`
Instead of rewriting the 11k-line style.css, we create a single `_responsive_overrides.scss` file imported into `app.scss`. This keeps changes isolated and revertable. Each override targets a specific page/component.

### Role authorization: custom RoleMiddleware
A simple `RoleMiddleware` checks `$request->user()->user_type_id` against allowed role IDs. Applied to route groups. This replaces the current frontend-only role hiding.

## Risks / Trade-offs

**[Risk] Paystack webhook delivery reliability** → Implement idempotency keys on webhook handler; log all webhook events for manual reconciliation

**[Risk] Chat polling creates DB load at scale** → Mitigation: add indexes on `chat_messages` (sender_id, receiver_id, created_at); upgrade to Pusher if polling becomes bottleneck

**[Risk] Responsive overrides may conflict with existing CSS specificity** → Use `_responsive_overrides.scss` with precise selectors; test on actual mobile devices; use `!important` sparingly only where needed to override inline styles

**[Risk] Role middleware may break existing routes** → Add middleware incrementally per route group; test each role's flow before moving to next

**[Risk] Paystack transaction verification race condition** → Use webhook as source of truth for transaction status; callback URL is for UX only; always re-verify status server-side before granting access

## Migration Plan

1. **Phase 1 — Bug fixes & model corrections**: Fix FK references, add relationships, cast fixes. Safe to deploy independently.
2. **Phase 2 — Responsive audit**: Add responsive overrides, fix tables, fix dashboard grid. Visual changes only, low risk.
3. **Phase 3 — Missing modules**: Build Attendance, Profile, Chat in parallel. Each is independent.
4. **Phase 4 — Payment**: Database migrations, Paystack integration, access control middleware, billing portal, admin config. Highest risk — tested in staging first.
5. **Phase 5 — Cleanup**: Remove dead code, unused assets, legacy controllers.

**Rollback**: Database migrations for payment tables are reversible (`down()` method). For access-control middleware, comment out the middleware calls in routes. Platform continues working without Paystack — gated content becomes free if Paystack env vars are missing.

## Open Questions

- Should recorded videos support individual purchase, or only via class enrollment?
- Should quizzes be purchased individually or only as part of class enrollment?
- Chat: store messages in DB only, or also send email notifications for offline users?
- Should the existing Flutterwave script be removed from layouts, or kept for future use?
