<?php
	
/**
* Plugin Name: Shop Extra — WooCommerce Extras
* Description: A lightweight plugin to enhance your WooCommerce & Business site.
* Author: Arya Dhiratara
* Author URI: https://dhiratara.me/
* Version: 1.0.9
* Requires at least: 5.8
* Requires PHP: 7.4
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: shop-extra
*/

namespace ShopExtra;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

define('SHOPEXTRA_NAME', 'ShopExtra — WooCommerce Extras');
define('SHOPEXTRA_DESCRIPTION', 'A lightweight plugin to enhance your WooCommerce & Business site');
define('SHOPEXTRA_SHORT_NAME', 'ShopExtra');
define('SHOPEXTRA_HANDLER', 'shop-extra');
define('SHOPEXTRA_VERSION', '1.0.9');
define("SHOPEXTRA_DIR", plugin_dir_path(__FILE__));
define("SHOPEXTRA_ASSETS_URL", plugin_dir_url(__FILE__) . 'assets/');
define("SHOPEXTRA_PUBLIC_URL", plugin_dir_url(__FILE__) . 'public/');
define("SHOPEXTRA_CLASSES_DIR", plugin_dir_path(__FILE__) . 'includes/classes/');
define("SHOPEXTRA_FUNCTIONS_URL", plugin_dir_url(__FILE__) . 'includes/functions/');
define("SHOPEXTRA_FUNCTIONS_DIR", plugin_dir_path(__FILE__) . 'includes/functions/');
define("SHOPEXTRA_LIBRARY_DIR", plugin_dir_path(__FILE__) . 'includes/library/');
define("SHOPEXTRA_BASENAME", plugin_basename(__FILE__));
define("SHOPEXTRA_ASSETS_DIR", SHOPEXTRA_DIR . 'assets/');

include_once(SHOPEXTRA_DIR . 'includes/classes/Loader.php');
include_once(SHOPEXTRA_DIR . 'includes/Functions.php');

global $SHOPEXTRA;

function SHOPEXTRA()
    {
        global $SHOPEXTRA;

        $SHOPEXTRA = SHOPEXTRA_Loader::getInstance();

        return $SHOPEXTRA;
}

SHOPEXTRA();

function shopextra_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url( 'options-general.php?page=shop-extra' ) ) );
    }
}
spl_autoload_register('ShopExtra\shopextra_autoloader');

function shopextra_autoloader($class) {
    $class = str_replace('ShopExtra\\', '', $class);
    $file = SHOPEXTRA_CLASSES_DIR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}
add_action('activated_plugin', 'ShopExtra\shopextra_activation_redirect');