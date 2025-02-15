<?php
/**
 * Plugin Name:       Pulse
 * Description:       RUM Performance Tracker is a lightweight and efficient Real User Monitoring (RUM) plugin designed to track Core Web Vitals directly from your WordPress site. This plugin collects Largest Contentful Paint (LCP), Cumulative Layout Shift (CLS), and Interaction to Next Paint (INP) to provide real-time performance insights inside your WordPress dashboard.
 * Version:           0.1.0
 * Requires at least: 6.4
 * Tested up to:      6.4
 * Requires PHP:      8.2
 * Author:            Daine Mawer
 * Author URI:        https://dainemawer.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pulse-performance
 * Domain Path:       /languages
 * Update URI:        https://github.com/dainemawer/pulse
 *
 * @package           PulsePlugin
 */

 if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'PULSE_PLUGIN_VERSION', '0.1.0' );
define( 'PULSE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PULSE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'PULSE_PLUGIN_INC', PULSE_PLUGIN_PATH . 'includes/' );
define( 'PULSE_PLUGIN_DIST_URL', PULSE_PLUGIN_URL . 'assets/dist/' );
define( 'PULSE_PLUGIN_DIST_PATH', PULSE_PLUGIN_PATH . 'assets/dist/' );

// Require Composer autoloader if it exists.
if ( file_exists( PULSE_PLUGIN_PATH . 'vendor/autoload.php' ) ) {
	require_once PULSE_PLUGIN_PATH . 'vendor/autoload.php';
}

// Include files.
require_once PULSE_PLUGIN_INC . '/core.php';

// Activation/Deactivation.
register_activation_hook( __FILE__, '\PulsePlugin\Core\activate' );
register_deactivation_hook( __FILE__, '\PulsePlugin\Core\deactivate' );

PulsePlugin\Core\setup();
