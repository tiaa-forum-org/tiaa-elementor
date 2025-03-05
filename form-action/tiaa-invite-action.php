<?php
/**
 * Utility Class for TIAA Invite Form Action.
 *
 * Provides helper methods and shared functionality for the Elementor Forms/TIAA Invite Form Action plugin.
 * This file is not a standalone plugin but is used as part of the main plugin functionality.
 *
 * @package ElementorFormsTIAAInvite
 * @since 0.0.3
 */

// Exit if accessed directly to ensure security.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use ElementorPro\Modules\Forms\Classes\Action_Base;
use ElementorPro\Modules\Forms\Classes\Ajax_Handler;
use ElementorPro\Modules\Forms\Classes\Form_Record;

/**
 * Elementor form tiaa-invite.
 *
 * Custom ElementorPro form action supporting invites to tiaa-forum.org
 *
 * @since 0.0.3
 */
class Tiaa_Invite_After_Submit extends Action_Base {
//	use TIAAPlugin\lib\PluginUtil; // necessary to get tiaa-plugin constants and logging

	/**
	 * Get action name.
	 *
	 * Retrieves the name of the custom Elementor form action.
	 * This name is used internally to reference this action.
	 *
	 * @since 0.0.3
	 * @access public
	 * @return string The name of the action.
	 */
	public function get_name(): string {
		return 'tiaa';
	}

	/**
	 * Get action label.
	 *
	 * Retrieves the label of the custom Elementor form action.
	 * This label appears in the Elementor user interface.
	 *
	 * @since 0.0.3
	 * @access public
	 * @return string The label of the action displayed in the UI.
	 */
	public function get_label(): string {
		return esc_html( 'TiaaInvite');
	}

	/**
	 * Register action controls.
	 *
	 * Registers custom settings and controls for the TiaaInvite action.
	 * Allows customization of action-specific parameters through the Elementor interface.
	 *
	 * @since 0.0.3
	 * @access public
	 * @param Widget_Base $form The form widget instance that settings are applied to.
	 * @return void
	 */
	public function register_settings_section( $form ): void {

		$form->start_controls_section(
			'section_tiaa_invite',
			[
				'label' => esc_html( 'TiaaInvite' ),
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);

		$form->add_control(
			'tiaa_timeout',
			[
				'label' => esc_html( 'Fetch timeout time (ms)'),
				'type' => Controls_Manager::NUMBER,
				'placeholder' => '5000',
				'description' => esc_html( 'Enter timout value for fetch'),
			]
		);

		$form->end_controls_section();

	}

	/**
	 * Run action.
	 *
	 * Executes the TiaaInvite action after a form submission. Validates the form submission
	 * for the action and processes the submitted data.
	 *
	 * This can include sending API requests, validating inputs, or invoking
	 * an external system (e.g., Discourse).
	 *
	 * @since 0.0.3
	 * @access public
	 * @param Form_Record  $record       The form record instance containing submitted data.
	 * @param Ajax_Handler $ajax_handler The Ajax handler instance for handling responses.
	 * @return void
	 */
	public function run( $record, $ajax_handler ): void {
		// TODO - need to make sure this works 		self::log_debug('Into tiaa-invite::run');
		// Ensure the form submission is for your specific action
		$actions_array = $record->get_form_settings( 'submit_actions' );
		if ( ! in_array('tiaa', $actions_array, true ) ) {
			return;
		}
		/**
		 * This block of code handles error processing in the server rather than in the browser where
		 * we've chosen to handle them. We may want to change our minds about this as the features
		 * mature...
		 */
		/*
		// Collect form data
		$raw_fields = $record->get( 'fields' );
		$fields = [];
		$timeout = 30; // Default timeout value

		foreach ( $raw_fields as $id => $field ) {
			$fields[ $id ] = $field['value'];

			// Check for the 'timeout' hidden form field and override the default value
			if ( $id === 'timeout' && is_numeric( $field['value'] ) ) {
				$timeout = intval( $field['value'] );
			}
		}

		// Define webhook URL
		$webhook_url = site_url( TIAA_HOOK_NAMESPACE . '/invite' );

		// Make the HTTP request to the webhook with dynamic timeout
		$response = wp_remote_post( $webhook_url, [
			'headers' => [
				'Content-Type' => 'application/json',
			],
			'body'    => wp_json_encode( $fields ),
			'timeout' => $timeout, // Use the dynamic timeout value here
		]);

		if ( is_wp_error( $response ) ) {
			// Handle request failure in PHP
			$ajax_handler->add_response_data( 'tiaa_result', 'error' );
			$ajax_handler->add_response_data( 'tiaa_message', 'An error occurred while sending the invite. Please try again.' );
			$ajax_handler->is_success = true;
		}


		// Extract response and process based on response codes
		$response_code = wp_remote_retrieve_response_code( $response );
		$response_body = wp_remote_retrieve_body( $response );
		$response_data = json_decode( $response_body, true );

		if ( $response_code === 200 && isset( $response_data['status'] ) ) {
			switch ( $response_data['status'] ) {
				case 'success':
					$ajax_handler->add_response_data( 'tiaa_result', 'success' );
					$ajax_handler->add_response_data( 'tiaa_message', 'Invite sent successfully! Thank you!' );
					break;
				case 'ignored':
					$ajax_handler->add_response_data( 'tiaa_result', 'ignored' );
					$ajax_handler->add_response_data( 'tiaa_message', 'Invite ignored. No action taken.' );
					break;
				case 'duplicate':
					$ajax_handler->add_response_data( 'tiaa_result', 'duplicate' );
					$ajax_handler->add_response_data( 'tiaa_message', 'Duplicate email detected. This invite has already been sent.' );
					break;
				default:
					$ajax_handler->add_response_data( 'tiaa_result', 'error' );
					$ajax_handler->add_response_data( 'tiaa_message', 'An unknown error occurred. Please contact support.' );
			}
		} else {
			$ajax_handler->add_response_data( 'tiaa_result', 'error code: ' . $response_code );
			$ajax_handler->add_response_data( 'tiaa_message', 'An error occurred. Please try again.' );
		}*/
		// TODO - for now, just return true for Elementor's purposes but we handle the  REST interface
		// in the javascript interface
		$ajax_handler->is_success = true;
	}
// TODO - current incarnation of this feature does this in the browser
/*
	// Helpers to add inline JS to manipulate divs
	private function add_success_script( $div_id, $message ) {
		echo '<script>
            document.addEventListener("DOMContentLoaded", function () {
                const successDiv = document.getElementById("' . esc_js($div_id) . '");
                if (successDiv) {
                    successDiv.style.display = "block";
                    successDiv.innerText = "' . esc_js($message) . '";
                }
            });
        </script>';
	}

	private function add_error_script( $div_id, $message ) {
		echo '<script>
            document.addEventListener("DOMContentLoaded", function () {
                const errorDiv = document.getElementById("' . esc_js($div_id) . '");
                if (errorDiv) {
                    errorDiv.style.display = "block";
                    errorDiv.innerText = "' . esc_js($message) . '";
                }
            });
        </script>';
	}*/

	/**
	 * On export.
	 *
	 * Clears form settings/fields when exporting.
	 *
	 * @since 0.0.3
	 * @access public
	 * @param array $element
	 */
	public function on_export( $element ): array {

		unset(
			$element['tiaa_timeout']
		);

		return $element;

	}

}