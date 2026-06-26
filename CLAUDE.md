# tiaa-elementor — Claude Code Context
# Last updated: 2026-06-25

## What This Is

Elementor Pro extensions for tiaa-forum.org. Current version: 0.0.9. Three features:

1. **Discourse Invite form action** — custom "TIAA Invite" submit action for
   Elementor Pro forms; POSTs to tiaa-wpplugin's REST API to send Discourse invites
2. **Clickable Loop Grid cards** — makes entire Loop Grid cards clickable site-wide
3. **Member/anon CSS utility classes** — sitewide stylesheet providing `.tiaa-member-only`
   and `.tiaa-anon-only` classes toggled by the `tiaa-member` body class

Part of the tiaa-v3 project. See umbrella context at `../CLAUDE.md`.

> **Upgrade note:** This plugin supersedes `tiaa-elementor-forms-invite-action`.
> That older plugin must be **deactivated and removed** before activating this one.

---

## File Structure

```
tiaa-elementor/
├── tiaa-elementor.php          ← entry point; registers all features
├── form-action/
│   └── tiaa-invite-action.php  ← Elementor Pro form action class
├── loop-grid/
│   └── clickable-cards.php     ← Loop Grid click handler
└── assets/
    ├── js/
    │   └── form-handler.js     ← front-end invite form submission (enqueued on demand)
    └── css/
        └── tiaa-elementor.css  ← member/anon utility classes (enqueued sitewide)
```

---

## Feature 1: Discourse Invite Form Action

### How it works

1. Editor adds the 'TIAA Invite' action to a form widget's "Actions After Submit"
2. On page render, if any form widget on the page uses the `tiaa` action,
   `form-handler.js` is enqueued (footer, demand-only — not on every page)
3. Script is localized with `tiaaPluginData`:
   - `apiUrl`: `/tiaa_wpplugin/v1/invite`
   - `nonce`: WP REST nonce (`wp_rest`)
4. On form submit, `form-handler.js` POSTs to `tiaa-wpplugin`'s REST endpoint,
   which calls the Discourse invite API

### Dependencies

- Requires **Elementor Pro** (uses `elementor_pro/forms/actions/register` hook)
- Requires **tiaa-wpplugin** to be active (provides the REST endpoint)
- Script dependency: `wp-api-fetch`

### Adding the invite form to a page

Use Elementor Pro form widget → Actions After Submit → select "TIAA Invite".
The form fields and field mapping are configured in `tiaa-invite-action.php`.

---

## Feature 2: Clickable Loop Grid Cards

Loaded unconditionally on all front-end pages (`loop-grid/clickable-cards.php`
required directly from the main plugin file). Makes every Loop Grid card's
entire area clickable by finding the first link inside each card and extending
its click target to the card container.

No Elementor Pro requirement for this feature.

---

## Feature 3: Member/Anon CSS Utility Classes

`assets/css/tiaa-elementor.css` is enqueued sitewide via `wp_enqueue_scripts`.
Provides two utility classes for template authors:

| Class | Behaviour |
|---|---|
| `.tiaa-member-only` | Hidden by default; shown when `body.tiaa-member` is present |
| `.tiaa-anon-only` | Visible by default; hidden when `body.tiaa-member` is present |

The `tiaa-member` body class is set by **tiaa-wpplugin** (`TiaaHooks::add_member_body_class`,
v0.0.8+) whenever the `tiaa_member` cookie is present — covering all three visitor states:

- **Anonymous** — no cookie → `tiaa-member` absent → `.tiaa-member-only` hidden
- **Returning member** (logged out) — cookie present → `tiaa-member` on body → `.tiaa-member-only` shown
- **Logged-in member** — cookie present → same as above

Add these classes to any Elementor element via **Advanced → CSS Classes**. Use Elementor's
built-in login-state conditions for targeting currently-logged-in users specifically.

No Elementor Pro requirement for this feature.

---

## Code Style

- Procedural PHP at the plugin root; class-based in `form-action/`
- WordPress coding standards
- Docblock author: `Lew Grothe, TIAA Admin Platform sub-team`
- Docblock email: `info@tiaa-forum.org`
- Docblock URL: `https://tiaa-forum.org/contact`
- Conventional commits: `feat:`, `fix:`, `chore:`
- Dates: YYYY-MM-DD

---

## Deployment Notes

- No build step; JS is plain ES5 and CSS is plain CSS (no bundler)
- `form-handler.js` version is set via `filemtime()` — cache-busted automatically on file change
- `tiaa-elementor.css` version is set via `TIAA_ELEMENTOR_VERSION` constant — bump the constant when the CSS changes
- Activate only after `tiaa-elementor-forms-invite-action` is removed