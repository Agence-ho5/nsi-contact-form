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

namespace Nsi\ContactForm\Widgets;

use Carbon_Fields\Field;
use Carbon_Fields\Widget;
use Nsi\ContactForm\PostTypes\ContactFormPostType;

class ContactFormWidget extends Widget {
  const WIDGET_NAME = 'nsi_contact_form';
  public function __construct() {
    $this->setup( static::WIDGET_NAME, __( "NSI Formulaire de contact", 'agenceho5' ), __( "Affiche un formulaire de contact", 'agenceho5' ), [
      Field::Make( 'text', 'title', "Titre du widget" ),
      Field::Make( 'select', 'form', "Formulaire à afficher" )
        ->set_options( $this->getFormsPosts() )
        ->set_help_text( sprintf( '%s <a href="%s">%s</a>', "Si la liste ci-dessus est vide, vous devriez d'abord", add_query_arg( array( 'post_type' => ContactFormPostType::POST_TYPE ), admin_url( 'post-new.php' ) ), "créer un formulaire ici" ) )
        ->set_required( true ),
    ], static::WIDGET_NAME );
  }

  protected function getFormsPosts() {
    $posts  = get_posts( ['post_type' => ContactFormPostType::POST_TYPE, 'posts_per_page' => -1] );
    $return = [];
    foreach ( $posts as $post ) {
      $return[$post->ID] = $post->post_title;
    }
    return $return;
  }

  public function front_end( $args, $instance ) {
    if ( $instance['title'] ) {
      echo $args['before_title'];
      echo $instance['title'];
      echo $args['after_title'];
    }
    $divid = static::WIDGET_NAME . '_container-' . $args['widget_id'];
    echo '<div id="' . $divid . '" class="' . static::WIDGET_NAME . '_container" data-formid="' . $instance['form'] . '"></div>';
  }
}
add_action( 'widgets_init', function () {register_widget( __NAMESPACE__ . '\ContactFormWidget' );} );