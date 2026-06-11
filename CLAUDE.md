# tiaa-elementor — Claude Code Context
# Last updated: 2026-06-10

## What This Is

Elementor Pro extensions for tiaa-forum.org. Current version: 0.0.9. Two features:

1. **Discourse Invite form action** — custom "TIAA Invite" submit action for
   Elementor Pro forms; POSTs to tiaa-wpplugin's REST API to send Discourse invites
2. **Clickable Loop Grid cards** — makes entire Loop Grid cards clickable site-wide

Part of the tiaa-v3 project. See umbrella context at `../CLAUDE.md`.

> **Upgrade note:** This plugin supersedes `tiaa-elementor-forms-invite-action`.
> That older plugin must be **deactivated and removed** before activating this one.

---

## File Structure

```
tiaa-elementor/
├── tiaa-elementor.php          ← entry point; registers both features
├── form-action/
│   └── tiaa-invite-action.php  ← Elementor Pro form action class
├── loop-grid/
│   └── clickable-cards.php     ← Loop Grid click handler
└── assets/
    └── js/
        └── form-handler.js     ← front-end invite form submission (enqueued on demand)
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

- No build step; JS is plain ES5 (no bundler)
- `form-handler.js` version is set via `filemtime()` — cache-busted automatically on file change
- Activate only after `tiaa-elementor-forms-invite-action` is removed