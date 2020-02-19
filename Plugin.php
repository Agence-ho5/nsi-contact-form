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

namespace Nsi\ContactForm;

use Nsi\Helpers\Hookable;

class Plugin extends Hookable {

  const PLUGIN_NAME = "nsi_contact_form";

  /**
   * Déclare l'ensemble des hooks utilisés par la classe
   */
  protected static function hooks() {
    add_action( 'after_setup_theme', function () {\Carbon_Fields\Carbon_Fields::boot();} );
    register_activation_hook( __FILE__, [get_called_class(), 'onActivation'] );
  }

  /**
   * Opérations à réaliser lors de l'activation du plugin
   */
  public static function onActivation() {
    do_action( static::PLUGIN_NAME . '_activation' );
  }
}
Plugin::getInstance();