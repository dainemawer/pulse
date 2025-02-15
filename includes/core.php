<?php
/**
 * Core plugin functionality.
 *
 * @package TenUpPlugin
 */

namespace PulsePlugin\Core;

use TenupFramework\ModuleInitialization;

function setup() {
	add_action( 'init', 'PulsePlugin\Core\i18n' );
	add_action( 'init', 'PulsePlugin\Core\init', apply_filters( 'pulse_plugin_init_priority', 8 ) );

	// Add Tracking Script
	add_action( 'admin_enqueue_scripts', 'PulsePlugin\Core\admin_styles' );
}

/**
 * Registers the default textdomain.
 *
 * @return void
 */
function i18n() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'pulse-plugin' );
	load_textdomain( 'pulse-plugin', WP_LANG_DIR . '/pulse-plugin/pulse-plugin-' . $locale . '.mo' );
	load_plugin_textdomain( 'pulse-plugin', false, plugin_basename( PULSE_PLUGIN_PATH ) . '/languages/' );
}

/**
 * Enqueue admin styles.
 *
 * @return void
 */
function admin_styles( $hook ) {

	$allowed_pages = [ 'settings_page_pulse-settings', 'toplevel_page_rum-dashboard' ];

	if ( in_array( $hook, $allowed_pages ) ) {
		wp_enqueue_style(
			'pulse-admin',
			PULSE_PLUGIN_DIST_URL . '/admin.css',
			[],
			'1.0'
		);
	}
}

/**
 * Initializes the plugin and fires an action other plugins can hook into.
 *
 * @return void
 */
function init() {
	do_action( 'pulse_plugin_before_init' );

	if ( ! class_exists( '\TenupFramework\ModuleInitialization' ) ) {
		add_action(
			'admin_notices',
			function () {
				$class = 'notice notice-error';

				printf(
					'<div class="%1$s"><p>%2$s</p></div>',
					esc_attr( $class ),
					wp_kses_post( __( 'Please ensure the <a href="https://github.com/10up/wp-framework"><code>10up/wp-framework</code></a> composer package is installed.', 'tenup-plugin' ) )
				);
			}
		);
		return;
	}

	ModuleInitialization::instance()->init_classes( PULSE_PLUGIN_INC );
	do_action( 'pulse_plugin_init' );
}

/**
 * Activate the plugin
 *
 * @return void
 */
function activate() {
	// First load the init scripts in case any rewrite functionality is being loaded
	init();
	flush_rewrite_rules();
}

/**
 * Deactivate the plugin
 *
 * Uninstall routines should be in uninstall.php
 *
 * @return void
 */
function deactivate() {
}
