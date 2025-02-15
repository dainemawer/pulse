<?php
/**
 * This file contains hooks and functions that override the behavior of WP Core.
 *
 * @package PulsePlugin
 */

namespace PulsePlugin;

use TenupFramework\Module;
use TenupFramework\ModuleInterface;

class Widget implements ModuleInterface {

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
		add_action( 'wp_dashboard_setup', [ $this, 'register_dashboard_widget' ]);
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_dashboard_assets' ]);
	}

	public function enqueue_dashboard_assets( $hook ) {

		if ( $hook !== 'index.php' ) {
			return;
		}

		wp_enqueue_script('react');
    	wp_enqueue_script('react-dom');

		wp_enqueue_script(
            'pulse-widget',
            PULSE_PLUGIN_DIST_URL . '/widget.js',
            ['react', 'react-dom'],
            '1.0',
            true
        );
	}

	/**
     * Register a custom dashboard widget.
     */
	public function register_dashboard_widget() {
        wp_add_dashboard_widget(
            'rum_dashboard_widget',
            __('Pulse Overview', 'pulse-plugin'),
            [ $this, 'render_dashboard_widget' ]
        );
    }

	/**
     * Display the dashboard widget.
     */
    public function render_dashboard_widget() {
        ?>
        <div id="pulse-dashboard-widget">
            <p><?php _e('Loading performance metrics...', 'rum-performance-tracker'); ?></p>
        </div>
        <!-- <script type="module" src="<?php // echo plugin_dir_url(__FILE__) . '../assets/dist/dashboard-widget.js'; ?>"></script> -->
        <?php
    }

}
