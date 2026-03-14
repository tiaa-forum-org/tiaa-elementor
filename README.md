# Elementor Pro Form Action for TIAA WordPress Plugin

### Description

This plugin extends **Elementor Pro** to integrate with the [TIAA WordPress Plugin](https://tiaa-forum.org/). It offers a custom form action capability that allows administrators to create user invitation workflows, sending new user invites directly to the TIAA Forum via Elementor Pro forms.

This form action was necessary since the WebHook action available in Elementor Pro only allows return values of Success or Failure and we we wanted to be able to immediately respond differently to a new member's input based on whether the the email had already been registered or if one of a few error conditions occurred.

This plugin is designed to work **in conjunction with** the [TIAA WordPress Plugin](https://tiaa-forum.org/) and assumes it is already installed and configured. For additional functionality provided by the TIAA WordPress Plugin, please refer to its documentation.

---

## Features

- **New Elementor Pro Form Action:** Adds a custom action `TIAA Invite` for Elementor Pro Forms to process invitations to the TIAA Forum.
- **Effortless User Onboarding:** Integrates directly with the TIAA Forum's backend to handle user invitations seamlessly.
- **REST API Integration:** Provides a REST endpoint for managing form submissions and connecting with the TIAA Forum.
- **Zero-Code Configuration:** Simple setup and integration via Elementor Pro's Form editor.

---

## Requirements
While these requirements make sense (the plugin won't work without close links to Elementor Pro and the TIAA-WPPlugin, specifying them in the plugin code (e.g. in tiaa-elementor-forms-invite-action.php) the automatic dependencies enforced by WordPress make it at least problematic and maybe impossible to do upgrades and configuration changes to any of the 3 plugins. 
### WordPress
- WordPress Version: **6.0** or higher
- PHP Version: **7.1.0** or higher

### Required Plugins
- [TIAA WordPress Plugin](https://tiaa-forum.org/) (refer to its documentation for setup and configuration)
- [Elementor](https://elementor.com/)
- [Elementor Pro](https://elementor.com/pro)

---

## Installation

1. Ensure **Elementor** and **Elementor Pro** are installed and activated.
2. Install and activate the **TIAA WordPress Plugin** (see the [documentation](https://tiaa-forum.org/)).
3. Download or clone this plugin to your WordPress plugins directory (typically `/wp-content/plugins`).
4. Activate this plugin via `Plugins > Installed Plugins` in your WordPress dashboard.

---

## Usage

### Add the TIAA Invite Form Action
1. Navigate to Elementor and create or edit a form.
2. In the "Actions After Submit" dropdown, add the new action called `TIAA Invite`.
3. Configure the form fields:
    - Map the **email field** to collect the email addresses of users to be invited.
    - Optionally, add custom form fields if needed for your workflow.
4. Publish the form and test submissions.

### How it Works
- When a form is submitted, this plugin triggers an API call to the TIAA WordPress Plugin's invite system.
   - The form requires an Elementor Pro `form-action` of `TIAA-invite` after submission that causes some JavaScript code to be loaded that completely bypasses the Elementor Pro Ajax API handler (e.g. fetch...)
   - In order to circumvent the normal form submission process, we need to stub out a response from the handler (always success) and let this plugin's JS respond according to the 3-4 expected responses from the TIAA-plugin for an invite request to Discourse
- The TIAA plugin processes the submission by communicating with the TIAA Forum Discourse server to send an invitations to the email address on the submitted form.
- ~~Invitation logs (if enabled) are accessible via the TIAA plugin admin panel.~~

---

## File Structure Overview

| File                                     | Functionality                                                       |
|------------------------------------------|---------------------------------------------------------------------|
| `tiaa-elementor-forms-invite-action.php` | Registers the custom Elementor Pro form action `TIAA Invite`.       |
| `form-action/tiaa-invite.php`            | Executes form actions to connect Elementor forms with the TIAA API. |
| `assets/js/form-handler.js`              | Handles REST API requests for form-related functionality.           |
| `README.md`                              | This file.                                                          |
| `LICENSE.md`                             | License boilerplate.                                                |

---

## Development & Contributions

### Prerequisites
- WordPress development environment installed and running.

### Testing
Ensure to test the plugin alongside:
- **TIAA WordPress Plugin**: Invite functionality must interact properly with its API.
- **Elementor Pro**: The `TIAA Invite` action must be available and functional.

### Contributions
We welcome contributions! Follow these steps:
1. Fork the repository.
2. Create a feature branch for your updates.
3. Submit a pull request with a descriptive explanation of changes.

---

## License

This plugin is licensed under the **GPL v2.0 or later**. See the `LICENSE.md` file for full details.

---

## Support

For issues, feature requests, or feedback, please contact the TIAA Forum Admin Platform Sub-Team via https://tiaa-forum.org/contact.
