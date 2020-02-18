<?php
/***
 *                                       _           _____
 *                                      | |         |  ___|
 *      __ _  __ _  ___ _ __   ___ ___  | |__   ___ |___ \
 *     / _` |/ _` |/ _ \ '_ \ / __/ _ \ | '_ \ / _ \    \ \
 *    | (_| | (_| |  __/ | | | (_|  __/ | | | | (_) /\__/ /
 *     \__,_|\__, |\___|_| |_|\___\___| |_| |_|\___/\____/
 *            __/ |
 *           |___/
 *
 *           >> https://agenceho5.com
 */
/**
 * Plugin Name: NSI Contact Form
 * Description: Permet la gestion des formulaires de contact dans wordpress
 * Version: 1.0.0
 * Author: Fabien LEGE
 * Author URI: https://agenceho5.com
 * Requires at least: 4.0
 * Text Domain: agenceho5
 * Domain Path: /languages
 */

require_once __DIR__ . "/Plugin.php";

/*foreach ( ['Tools', 'Shortcodes', 'Widgets', 'Blocks'] as $folder ) {
foreach ( array_reverse( glob( __DIR__ . '/lib/' . $folder . '/*.php' ) ) as $file ) {
require_once $file;
}
}*/

foreach ( array_reverse( glob( __DIR__ . '/lib/*', GLOB_ONLYDIR ) ) as $folder ) {
  foreach ( array_reverse( glob( __DIR__ . '/lib/' . basename( $folder ) . '/*.php' ) ) as $file ) {
    //echo $file . '<br>';
    require_once $file;
  }

}
