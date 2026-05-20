<?php
/**
 * Plugin Name: Divi Product Category Menu
 * Description: Adds a Divi 4 module for WooCommerce product category menus with optional builder-managed custom items.
 * Version: 1.0.0
 * Author: GitHub Copilot
 * Text Domain: divi-product-category-menu
 *
 * @package DiviProductCategoryMenu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DPCM_VERSION', '1.0.0' );
define( 'DPCM_FILE', __FILE__ );
define( 'DPCM_PATH', plugin_dir_path( __FILE__ ) );
define( 'DPCM_URL', plugin_dir_url( __FILE__ ) );

require_once DPCM_PATH . 'includes/class-dpcm-plugin.php';

/**
 * Return the plugin singleton.
 *
 * @return DPCM_Plugin
 */
function dpcm() {
	return DPCM_Plugin::instance();
}

dpcm();
