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

namespace Nsi\ContactForm\Blocks;

use Carbon_Fields\Block;
use Carbon_Fields\Field;
use Nsi\ContactForm\Plugin;
use Nsi\ContactForm\PostTypes\ContactFormPostType;
use Nsi\Helpers\Block as B;

class ContactFormBlock extends B {
  const BLOCK_NAME = Plugin::PLUGIN_NAME;

  /**
   * Init gutenberg block
   */
  public static function registerBlock() {
    Block::make( __( 'Formulaire de contact' ) )
      ->set_icon( 'feedback' )
      ->set_description( "Affiche un formulaire de contact" )
      ->add_fields( static::getFields( [
        Field::Make( 'select', 'form', "Formulaire à afficher" )
          ->set_options( ContactFormPostType::getFormsPosts() )
          ->set_help_text( sprintf( '%s <a href="%s">%s</a>', "Si la liste ci-dessus est vide, vous devriez d'abord", add_query_arg( array( 'post_type' => ContactFormPostType::POST_TYPE ), admin_url( 'post-new.php' ) ), "créer un formulaire ici" ) )
          ->set_required( true ),
      ] ) )
      ->set_category( 'agence-ho5', 'Agence ho5', 'smiley' )
      ->set_keywords( ['formulaires', 'contacts'] )
      ->set_render_callback( apply_filters( static::BLOCK_NAME . '-render', [get_called_class(), 'renderBlock'] ) );
  }

  /**
   * Render the block on front page (or in admin in viewer mode)
   * this render can be updated by remplacing this function by a new callback to call in this filter :
   * @see hoohk nsi_slider-render
   * @param array $fields       : Fields value list
   * @param array attributes    : attributes lists (like className)
   * @param array inner_blocks  : Inner blocks in case the block can contain other blocks
   */
  public static function renderBlock( $fields = null, $attributes = null, $inner_blocks = null ) {
    echo '<div class="' . Plugin::PLUGIN_NAME . '_container" data-formid="' . $fields['form'] . '"></div>';
  }
}
ContactFormBlock::getInstance();