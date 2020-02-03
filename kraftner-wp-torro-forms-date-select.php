<?php
/**
 * Plugin initialization file
 *
 * @package KraftnerWpTorroFormsDateSelect
 * @since 1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: Kraftner WP Torro Forms Date Select
 * Plugin URI:  https://kraftner.com
 * Description: Plugin for Torro Forms that adds a date field made from selects.
 * Version:     0.0.7
 * Author:      Thomas Kräftner
 * Author URI:  https://kraftner.com
 * License:     GNU General Public License v2 (or later)
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: kraftner-wp-torro-forms-date-select
 * Domain Path: /languages/
 * Tags:        extension, torro forms, forms, form builder, api
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the extension.
 *
 * To retrieve the extension instance from the outside, third-party developers
 * have to call `torro()->extensions()->get( 'kraftner_wp_torro_forms_date_select' )`.
 *
 * @since 1.0.0
 *
 * @param Torro_Forms $torro Main plugin instance.
 * @return bool|WP_Error True on success, error object on failure.
 */
function kraftner_wp_torro_forms_date_select_load( $torro ) {
	// Require main extension class file. All other classes will be autoloaded.
	require_once dirname( __FILE__ ) . '/src/extension.php';

	// Use a string here for the extension class name so that this file can be parsed by PHP 5.2.
	$class_name = 'Kraftner\KraftnerWpTorroFormsDateSelect\Extension';

	// Store the main extension file.
	$main_file = __FILE__;

	// Determine the relative basedir (will be empty unless a must-use plugin).
	$basedir_relative = '';
	$file             = wp_normalize_path( $main_file );
	$mu_plugin_dir    = wp_normalize_path( WPMU_PLUGIN_DIR );
	if ( preg_match( '#^' . preg_quote( $mu_plugin_dir, '#' ) . '/#', $file ) && file_exists( $mu_plugin_dir . '/kraftner-wp-torro-forms-date-select.php' ) ) {
		$basedir_relative = 'kraftner-wp-torro-forms-date-select/';
	}

	$result = $torro->extensions()->register( 'kraftner_wp_torro_forms_date_select', $class_name, $main_file, $basedir_relative );

	if ( is_wp_error( $result ) ) {
		$method = get_class( $torro->extensions() ) . '::register()';
		$torro->error_handler()->doing_it_wrong( $method, $result->get_error_message(), null );
	}

	return $result;
}

if ( function_exists( 'torro_load' ) ) {
	torro_load( 'kraftner_wp_torro_forms_date_select_load' );
} else {
	add_action( 'torro_loaded', 'kraftner_wp_torro_forms_date_select_load', 10, 1 );
}
