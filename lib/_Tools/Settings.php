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

namespace Nsi\ContactForm\Tools;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Nsi\ContactForm\Plugin;
use Nsi\ContactForm\PostTypes\ContactFormPostType;
use Nsi\Helpers\Hookable;

class Settings extends Hookable {
  public static function hooks() {
    add_filter( 'carbon_fields_register_fields', [get_called_class(), 'settingPage'], 2 );
  }

  public static function settingPage() {
    Container::Make( "theme_options", "Paramètres" )
      ->set_page_parent( "edit.php?post_type=" . ContactFormPostType::POST_TYPE )
      ->add_fields( [
        Field::make( 'checkbox', Plugin::PLUGIN_NAME . 'recaptcha_enable', __( "Activer Google re-Captcha", 'agenceho5' ) )->set_help_text( sprintf( __( 'Vous pouvez générer les clès d\'API nécessaire depuis la page <a href="%s" target="_blank">Google re-Captcha</a>', 'agenceho5' ), "https://www.google.com/recaptcha/admin/create" ) ),
        Field::make( 'text', Plugin::PLUGIN_NAME . 'recaptcha_public', __( 'Clé publique Google re-captcha', 'agenceho5' ) )->set_required( true )->set_conditional_logic( [[
          'field' => Plugin::PLUGIN_NAME . 'recaptcha_enable',
          'value' => true,
        ]] ),
        Field::make( 'text', Plugin::PLUGIN_NAME . 'recaptcha_private', __( 'Clé privée Google re-captcha', 'agenceho5' ) )->set_required( true )->set_conditional_logic( [[
          'field' => Plugin::PLUGIN_NAME . 'recaptcha_enable',
          'value' => true,
        ]] ),
      ] );
  }
}
Settings::getInstance();