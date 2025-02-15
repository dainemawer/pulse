<?php
/**
 * This file contains hooks and functions that override the behavior of WP Core.
 *
 * @package PulsePlugin
 */

namespace PulsePlugin;

use TenupFramework\Module;
use TenupFramework\ModuleInterface;

class Settings implements ModuleInterface {

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
		add_action( 'admin_menu', [ $this, 'add_settings_page' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
	}

	public function add_settings_page() {
		add_options_page(
			__( 'Pulse Settings', 'pulse-performance' ),
			__( 'Pulse Settings', 'pulse-performance' ),
			'manage_options',
			'pulse-settings',
			[ $this, 'pulse_settings_page' ]
		);
	}

	public function register_settings() {
		register_setting( 'pulse-settings-group', 'pulse_api_key' );
		register_setting( 'pulse-settings-group', 'pulse_site_id' );
		register_setting( 'pulse-settings-group', 'pulse_enabled' );
	}

	public function pulse_settings_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Pulse Settings', 'pulse-performance' ); ?></h1>
			<p>
				<?php esc_html_e( 'The Pulse settings page allows you to configure and manage your site’s Real User Monitoring (RUM) integration. By entering your Supabase API Key, you enable the collection of Core Web Vitals data, including:', 'pulse-performance' ); ?>
			</p>

			<form method="post" action="options.php">
				<?php settings_fields( 'pulse-settings-group' ); ?>
				<?php do_settings_sections( 'pulse-settings-group' ); ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'API Key', 'pulse-performance' ); ?></th>
						<td><input type="text" name="pulse_api_key" value="<?php echo esc_attr( get_option( 'pulse_api_key' ) ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Site ID', 'pulse-performance' ); ?></th>
						<td><input type="text" name="pulse_site_id" value="<?php echo esc_attr( get_option( 'pulse_site_id' ) ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Enable Pulse', 'pulse-performance' ); ?></th>
						<td><input type="checkbox" name="pulse_enabled" value="1" <?php checked( 1, get_option( 'pulse_enabled' ), true ); ?> /></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}
