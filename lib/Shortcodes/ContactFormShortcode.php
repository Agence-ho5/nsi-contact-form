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

namespace Nsi\ContactForm\Shortcodes;

use Nsi\ContactForm\Plugin;
use Nsi\ContactForm\PostTypes\ContactFormPostType;
use Nsi\Helpers\Hookable;

class ContactFormShortcode extends Hookable {
  /**
   * Declare Hooks
   */
  public static function hooks() {
    add_shortcode( Plugin::PLUGIN_NAME, [get_called_class(), 'render'] );
  }

  public static function render( $atts ) {
    $post = get_posts( [
      'post_type'      => ContactFormPostType::POST_TYPE,
      'posts_per_page' => 1,
      'p'              => intval( $atts['id'] ),
    ] );
    if ( !empty( $post ) ) {
      return '<div class="' . Plugin::PLUGIN_NAME . '_container" data-formid="' . $post[0]->ID . '"></div>';
    }
  }
}
ContactFormShortcode::getInstance();