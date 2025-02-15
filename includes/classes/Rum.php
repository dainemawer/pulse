<?php
/**
 * This file contains hooks and functions that override the behavior of WP Core.
 *
 * @package PulsePlugin
 */

namespace PulsePlugin;

use TenupFramework\Module;
use TenupFramework\ModuleInterface;

class Rum implements ModuleInterface {

	use Module;

	/**
	 * Used to alter the order in which classes are initialized.
	 *
	 * @var int The priority of the module.
	 */
	public $load_order = 5;

	/**
	 * Checks whether the Module should run within the current context.
	 *
	 * @return bool
	 */
	public function can_register(): bool {
		return true;
	}

	/**
	 * Connects the Module with WordPress using Hooks and/or Filters.
	 *
	 * @return void
	 */
	public function register(): void {
		add_action( 'wp_head', [ $this, 'add_tracking_script' ] );
	}

	public function add_tracking_script() {
		$api_key = get_option( 'pulse_api_key', '' );
		$site_id = get_option( 'pulse_site_id', '' );
		$enabled = get_option( 'pulse_enabled', '' );

		if ( empty( $api_key ) || empty( $site_id ) && ! $enabled ) {
			return;
		}

		wp_enqueue_script(
			'pulse',
			PULSE_PLUGIN_DIST_URL . 'pulse.js',
			[],
			'1.0',
			true
		);

		wp_localize_script( 'pulse', 'PULSE', [
			'apiKey'     => esc_attr( $api_key ),
			'siteId'     => esc_attr( $site_id ),
			'backendUrl' => esc_url( 'https://pulsetracking.com/api/rum' ),
		] );
	}
}
