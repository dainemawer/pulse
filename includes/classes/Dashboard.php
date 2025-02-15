<?php
/**
 * This file contains hooks and functions that override the behavior of WP Core.
 *
 * @package PulsePlugin
 */

namespace PulsePlugin;

use TenupFramework\Module;
use TenupFramework\ModuleInterface;

class Dashboard implements ModuleInterface {

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
		add_action( 'admin_menu', [ $this, 'add_dashboard_page' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_dashboard_assets'] );
	}

	public function enqueue_dashboard_assets( $hook ) {

		if ( $hook !== 'toplevel_page_rum-dashboard' ) {
            return;
        }

		wp_enqueue_script(
            'pulse-dashboard-app',
            PULSE_PLUGIN_URL . '/app/dist/main.js', // Ensure this path is correct
            [],
            '1.0',
            true
        );
	}

	/**
     * Register the admin menu for the dashboard.
     */
    public function add_dashboard_page() {
        add_menu_page(
            __( 'Pulse', 'pulse-plugin' ),
            __( 'Pulse', 'pulse-plugin' ),
            'manage_options',
            'rum-dashboard',
            [ $this, 'render_dashboard_page' ],
            'dashicons-chart-line',
            2
        );
    }

	/**
     * Render the dashboard page.
     */
    public function render_dashboard_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('Pulse RUM Reports', 'pulse-plugin'); ?></h1>
            <p><?php _e('Track real user performance data collected from your website.', 'pulse-plugin'); ?></p>

            <div id="rum-dashboard">
                <p><?php _e('Loading performance data...', 'pulse-plugin'); ?></p>
            </div>
        </div>
        <?php
    }
}
