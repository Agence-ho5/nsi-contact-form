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

namespace Nsi\ContactForm\PostTypes;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Nsi\ContactForm\Plugin;
use Nsi\ContactForm\Tools\Assets;
use Nsi\Helpers\Hookable;

class ContactFormPostType extends Hookable {

  const POST_TYPE = "nsicontactform";

  protected static $allowedMimeTypes = array(
    'application/msword',
    'application/pdf',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/x-pdf',
    'application/vnd.pdf',
    'text/pdf',
    'image/jpg',
    'image/jpeg',
    'image/png',
    'image/gif',
  );

  /**
   * Déclare l'ensemble des hooks appelés dans la classe
   */
  public static function hooks() {
    add_action( 'init', [get_called_class(), 'declarePostTypes'], 0 );
    add_filter( 'carbon_fields_register_fields', [get_called_class(), 'fieldsSetup'], 2 );
    add_action( 'wp_ajax_' . Plugin::PLUGIN_NAME . '_post', [get_called_class(), 'postForm'] );
    add_action( 'wp_ajax_nopriv_' . Plugin::PLUGIN_NAME . '_post', [get_called_class(), 'postForm'] );
    add_filter( 'manage_' . static::POST_TYPE . '_posts_columns', [get_called_class(), 'postTypeColumns'] );

    add_action( 'manage_' . static::POST_TYPE . '_posts_custom_column', [get_called_class(), 'postTypeCustomColumns'], 10, 2 );
  }

  /**
   * Déclare tous les post_types déclaré dans le fichier de configuration du thème config/post_types.json
   * @see https://github.com/agence-ho5/base/docs/configs/post_types.md for overriding and configuration doc
   */
  public static function declarePostTypes() {
    $args = [
      'supports'            => ['title'],
      'menu_icon'           => 'dashicons-feedback',
      'menu_position'       => '99',
      'show_in_nav_menus'   => false,
      'exclude_from_search' => true,
      'public'              => false,
    ];
    $labels = array(
      'name'                  => _x( 'Formulaires de contact', 'Post Type General Name', 'agenceho5' ),
      'singular_name'         => _x( 'Formulaire de contact', 'Post Type Singular Name', 'agenceho5' ),
      'menu_name'             => __( 'Formulaires de contact', 'agenceho5' ),
      'name_admin_bar'        => __( 'Formulaires de contact', 'agenceho5' ),
      'archives'              => __( 'Tout voir', 'agenceho5' ),
      'attributes'            => __( 'Attributs', 'agenceho5' ),
      'parent_item_colon'     => __( 'Formulaire de contact' . ' Parent', 'agenceho5' ),
      'all_items'             => __( 'Formulaires de contact', 'agenceho5' ),
      'add_new_item'          => __( 'Ajouter ' . 'un formulaire', 'agenceho5' ),
      'add_new'               => __( 'Ajouter', 'agenceho5' ),
      'new_item'              => __( 'Nouveau', 'agenceho5' ),
      'edit_item'             => __( 'Modifier ' . 'un formulaire', 'agenceho5' ),
      'update_item'           => __( 'Mettre à jour', 'agenceho5' ),
      'view_item'             => __( 'Voir', 'agenceho5' ),
      'view_items'            => __( 'Voir les ' . 'formulaires', 'agenceho5' ),
      'search_items'          => __( 'Rechercher ' . 'un formulaire', 'agenceho5' ),
      'not_found'             => __( 'Aucun ' . 'formulaire', 'agenceho5' ),
      'not_found_in_trash'    => __( 'Aucun ' . 'formulaire' . ' dans la corbeille', 'agenceho5' ),
      'featured_image'        => __( 'Image', 'agenceho5' ),
      'set_featured_image'    => __( 'Définir le l\'image', 'agenceho5' ),
      'remove_featured_image' => __( 'Retirer le l\'image', 'agenceho5' ),
      'use_featured_image'    => __( 'Définir un l\'image', 'agenceho5' ),
      'insert_into_item'      => __( 'Insérer', 'agenceho5' ),
      'uploaded_to_this_item' => __( 'Télécharger', 'agenceho5' ),
      'items_list'            => __( 'Liste des ' . 'formulaires', 'agenceho5' ),
      'items_list_navigation' => __( 'Items list navigation', 'agenceho5' ),
      'filter_items_list'     => __( 'Filter items list', 'agenceho5' ),
    );

    new \Nsi\Helpers\PostType( static::POST_TYPE, __( "Nom du formulaire de contact", 'agenceho5' ), $args, $labels );
    Assets::setJsVar( 'fields_rest_route', get_rest_url( null, 'wp/v2/' . static::POST_TYPE . '/' ) );

    register_rest_field( static::POST_TYPE, 'fields', ['get_callback' => [get_called_class(), 'getRestFields']] );
  }

  /**
   * Ajoute un champ "Fields" à l'API rest du post type nsicontactform
   */
  public static function getRestFields( $post ) {
    return array_merge( carbon_get_post_meta( $post['id'], 'fields' ), [
      [
        'uuid'       => Plugin::PLUGIN_NAME . '_nonce',
        'name'       => null,
        'value'      => wp_create_nonce( Plugin::PLUGIN_NAME . '_post' ),
        'type'       => 'hidden',
        'required'   => true,
        'attributes' => [],
        'choices'    => [],
      ],
      [
        'uuid'       => sha1( Plugin::PLUGIN_NAME . '_form_id' ),
        'name'       => null,
        'value'      => $post['id'],
        'type'       => 'hidden',
        'required'   => true,
        'attributes' => [],
        'choices'    => [],
      ],
      [
        'uuid'       => 'action',
        'name'       => null,
        'value'      => Plugin::PLUGIN_NAME . '_post',
        'type'       => 'hidden',
        'required'   => true,
        'attributes' => [],
        'choices'    => [],
      ],
    ] );
  }

  /**
   * Register special fields
   */
  public static function fieldsSetup() {
    Container::make( 'post_meta', __( 'Configuration du formulaire', 'agenceho5' ) )
      ->where( 'post_type', '=', static::POST_TYPE )
      ->add_tab( __( "Formulaire", 'agenceho5' ), [
        Field::make( 'complex', 'fields', __( 'Champs du formulaire', 'agenceho5' ) )
          ->add_fields( [
            Field::Make( 'uuid', 'uuid', '' ),
            Field::make( 'text', 'name', __( 'Nom du champ', 'agenceho5' ) )->set_required( true )->set_width( 40 ),
            Field::make( 'select', 'type', __( 'Type de champ', 'agenceho5' ) )->set_width( 40 )->set_options( [
              'text'     => __( "Texte", 'agenceho5' ),
              'email'    => __( "Adresse email", 'agenceho5' ),
              'textarea' => __( "Texte multiligne", 'agenceho5' ),
              'select'   => __( "Liste déroulante", 'agenceho5' ),
              'checkbox' => __( "Choix multiples", 'agenceho5' ),
              'radio'    => __( "Choix uniques", 'agenceho5' ),
              'file'     => __( "Fichier", 'agenceho5' ),
              'button'   => __( "Bouton", 'agenceho5' ),
            ] ),
            Field::make( 'checkbox', 'required', __( "Ce champ est obligatoire", 'agenceho5' ) )->set_width( 20 ),
            Field::make( 'complex', 'choices', __( 'Choix disponibles', 'agenceho5' ) )->set_conditional_logic( [[
              'field'   => 'type',
              'value'   => ['select', 'checkbox', 'radio'],
              'compare' => 'IN',
            ]] )
              ->add_fields( [
                Field::make( 'text', 'name', __( 'Intitulé du choix', 'agenceho5' ) )->set_required( true ),
              ] ),
            Field::make( 'complex', 'attributes', __( 'Attributs complémentaires', 'agenceho5' ) )
              ->add_fields( [
                Field::make( 'text', 'name', __( 'Attribut', 'agenceho5' ) )->set_required( true )->set_width( 50 ),
                Field::make( 'text', 'content', __( 'Valeur de l\'attribut', 'agenceho5' ) )->set_width( 50 ),
              ] )
              ->set_help_text( __( "L'utilisation de cette option est réservée aux experts. Elle vous permet notament de définir des attributs personnalisés comme placeholder, style, class,..." ) ),
          ] ),
      ] )
      ->add_tab( __( "Traitement", 'agenceho5' ), [
        Field::make( 'text', 'destinataire', __( 'Email du destinataire', 'agenceho5' ) )->set_required( true ),
        Field::make( 'text', 'replyto', __( 'Répondre à', 'agenceho5' ) ),
        Field::make( 'checkbox', 'copy', __( "Envoyer une copie à l'expéditeur", 'agenceho5' ) ),
        Field::make( 'text', 'subject', __( 'Sujet du mail', 'agenceho5' ) ),
        Field::make( 'rich_text', 'message', __( 'Contenu du message à envoyer', 'agenceho5' ) )->set_required( true ),
      ] );
  }

  /**
   * Interprète la requette ajax post du formulaire
   */
  public static function postForm() {
    $values = $_POST;
    //wp_send_json_success( $_FILES );exit;
    // Vérification du wp_nonce
    if ( !wp_verify_nonce( $values[Plugin::PLUGIN_NAME . '_nonce'], Plugin::PLUGIN_NAME . '_post' ) ) {
      wp_send_json_error( [
        'title'   => __( "Une erreur est survenue", 'agenceho5' ),
        'message' => __( "Nous n'avons pas pu soumettre votre message car la clé de vérification du formulaire est incorecte. Essayez d'actualiser la page et de recommencer", 'agenceho5' ),
        'type'    => 'danger',
      ] );
      die();
    }

    //Vérification de reCaptcha si actif
    if ( carbon_get_theme_option( Plugin::PLUGIN_NAME . "recaptcha_enable" ) && carbon_get_theme_option( Plugin::PLUGIN_NAME . "recaptcha_public" ) && carbon_get_theme_option( Plugin::PLUGIN_NAME . "recaptcha_private" ) ) {
      // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
      $ch = curl_init();

      curl_setopt( $ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify' );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
      curl_setopt( $ch, CURLOPT_POST, 1 );
      curl_setopt( $ch, CURLOPT_POSTFIELDS, "secret=" . carbon_get_theme_option( Plugin::PLUGIN_NAME . "recaptcha_private" ) . "&response=" . $values['recaptcha_response'] );

      $headers   = array();
      $headers[] = 'Content-Type: application/x-www-form-urlencoded';
      curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

      $result = curl_exec( $ch );
      curl_close( $ch );
      if ( json_decode( $result )->success != true ) {
        wp_send_json_error( [
          'title'   => __( "Une erreur est survenue", 'agenceho5' ),
          'message' => __( "Le jeton Antispam est incorrect. Actualiser la page peut résoudre le problème.", 'agenceho5' ),
          'type'    => 'danger',
        ] );
        die();
      }
    }

    //vérification du post_id et récupération des champs
    if ( !isset( $values[sha1( Plugin::PLUGIN_NAME . '_form_id' )] ) || !intval( $values[sha1( Plugin::PLUGIN_NAME . '_form_id' )] ) ) {
      wp_send_json_error( [
        'title'   => __( "Une erreur est survenue", 'agenceho5' ),
        'message' => __( "Nous n'avons pas pu soumettre votre message car les données transmises au serveur sont incomplètes.", 'agenceho5' ),
        'type'    => 'danger',
      ] );
      die();
    }

    $allowedMimeTypes = apply_filters( 'nsi-cf/allowed-mime-types', static::$allowedMimeTypes, $values[sha1( Plugin::PLUGIN_NAME . '_form_id' )] );

    foreach ( carbon_get_post_meta( intval( $values[sha1( Plugin::PLUGIN_NAME . '_form_id' )] ), 'fields' ) as $field ) {
      //Vérifications particulières
      if ( $field['required'] && empty( $values[$field['uuid']] ) ) {
        wp_send_json_error( [
          'title'   => __( "Une erreur est survenue", 'agenceho5' ),
          'message' => sprintf( __( "Le champ %s ne peut pas être vide. merci de le renseigner", 'agenceho5' ), $field['name'] ),
          'type'    => 'danger',
        ] );
        die();
      }
      switch ( $field['type'] ) {
      case 'email':
        if ( !filter_var( $values[$field['uuid']], FILTER_VALIDATE_EMAIL ) ) {
          wp_send_json_error( [
            'title'   => __( "Une erreur est survenue", 'agenceho5' ),
            'message' => sprintf( __( "Le champ %s doit contenir une adresse email valide.", 'agenceho5' ), $field['name'] ),
            'type'    => 'danger',
          ] );
          die();
        }
        break;
      case 'file':
        if ( isset( $_FILE[$field['uuid']] ) ) {
          if ( $_FILES[$field['uuid']]['error'] !== UPLOAD_ERR_OK ) {
            wp_send_json_error( [
              'title'   => __( "Une erreur est survenue", 'agenceho5' ),
              'message' => sprintf( __( "L'erreur suivante est survenue avec le fichier que vous avez choisi : %s", 'agenceho5' ), $_FILES[$field['uuid']]['error'] ),
              'type'    => 'danger',
            ] );
            die();
          }
          $finfo = finfo_open( FILEINFO_MIME_TYPE );
          $mime  = finfo_file( $finfo, $_FILES[$field['uuid']]['tmp_name'] );
          finfo_close( $finfo );
          if ( !in_array( $mime, $allowedMimeTypes ) ) {
            wp_send_json_error( [
              'title'   => __( "Une erreur est survenue", 'agenceho5' ),
              'message' => sprintf( __( "Le format du fichier %s que vous avez choisi n'est pas autorisé", 'agenceho5' ), $_FILES[$field['uuid']]['name'] ),
              'type'    => 'danger',
            ] );
            die();
          }
        }
        break;
      }
    }

    //Envoie du message
    $message = carbon_get_post_meta( intval( $values[sha1( Plugin::PLUGIN_NAME . '_form_id' )] ), 'message' );
    $message .= "\n\n==========\n\n";
    $message .= "Message envoyé depuis la page " . $_SERVER['HTTP_REFERER'] . "\n";

    foreach ( carbon_get_post_meta( intval( $values[sha1( Plugin::PLUGIN_NAME . '_form_id' )] ), 'fields' ) as $field ) {
      switch ( $field['type'] ) {
      case 'checkbox':
      case 'radio':
        $message .= $field['name'] . " : " . implode( ', ', array_keys( array_filter( $values[$field['uuid']], function ( $el ) {return $el == 'true';} ) ) ) . "\n";
        break;
      case 'button':
        break;
      case 'file':
        if ( isset( $_FILES[$field['uuid']] ) ) {
          $extension = pathinfo( $_FILES[$field['uuid']]['name'], PATHINFO_EXTENSION );
          $newName   = sha1_file( $_FILES[$field['uuid']]['tmp_name'] ) . '.' . $extension;
          move_uploaded_file( $_FILES[$field['uuid']]['tmp_name'], wp_upload_dir( 'nsif/' . date( 'y' ) )['path'] . '/' . $newName );
          $message .= $field['name'] . " : " . wp_upload_dir( 'nsif/' . date( 'y' ) )['url'] . '/' . $newName;
        }
        break;
      default:
        $message .= $field['name'] . " : " . str_replace( 'undefined', '', $values[$field['uuid']] ) . "\n";
      }
    }

    $to      = carbon_get_post_meta( intval( $values[sha1( Plugin::PLUGIN_NAME . '_form_id' )] ), 'destinataire' );
    $subject = carbon_get_post_meta( intval( $values[sha1( Plugin::PLUGIN_NAME . '_form_id' )] ), 'subject' );
    $headers = [];
    if ( !empty( carbon_get_post_meta( intval( $values[sha1( Plugin::PLUGIN_NAME . '_form_id' )] ), 'replyto' ) ) ) {
      $headers['Reply-To'] = carbon_get_post_meta( intval( $values[sha1( Plugin::PLUGIN_NAME . '_form_id' )] ), 'button' );
    }
    if ( wp_mail( $to, $subject, $message, $headers ) ) {
      wp_send_json_success( [
        'title'   => __( "Message envoyé", 'agenceho5' ),
        'message' => __( "Votre message a bien été transmis à notre équipe. nous vous répondrons dans les plus brefs délais.", 'agenceho5' ),
        'type'    => 'success',
      ] );
    } else {
      wp_send_json_error( [
        'title'   => __( "Une erreur est survenue", 'agenceho5' ),
        'message' => __( "Une erreur innatendue est survenue et votre message n'a pas pû être envoyé. Si le problème persiste, merci de nous contacter directement par mail ou téléphone.", 'agenceho5' ),
        'type'    => 'danger',
      ] );
    }
    exit;
  }

  /**
   * Déclare les colones supplémentaires pour ce type de post
   */
  public static function postTypeColumns( $columns ) {
    $date = $columns['date'];
    unset( $columns['date'] );
    $columns['shortcode'] = __( 'Shortcode', 'agenceho5' );
    $columns['date']      = $date;

    return $columns;
  }

  /**
   * Affiche les colones personnalisées pour ce type de post
   */
  public static function postTypeCustomColumns( $column, $post_id ) {
    switch ( $column ) {
    case 'shortcode':
      echo '<input type="text" readonly id="' . static::POST_TYPE . '_shortcode_' . $post_id . '" value=\'[' . Plugin::PLUGIN_NAME . ' id="' . $post_id . '"]\'><a href="#" onclick="(function(event){document.getElementById(\'' . static::POST_TYPE . '_shortcode_' . $post_id . '\').select();document.execCommand(\'copy\'); event.target.outerHTML = \'' . __( "Copié !", 'agenceho5' ) . '\'; return false;})(event); return false;" title="' . __( "Copier", 'agenceho5' ) . '"><i class="dashicons dashicons-admin-page"></i></a>';
    }
  }

  /**
   * Return all available Contact Form posts
   */
  public static function getFormsPosts() {
    $posts  = get_posts( ['post_type' => ContactFormPostType::POST_TYPE, 'posts_per_page' => -1] );
    $return = [0 => __( "Sélectionnez...", 'agenceho5' )];
    foreach ( $posts as $post ) {
      $return[$post->ID] = $post->post_title;
    }
    return $return;
  }
}
ContactFormPostType::getInstance();
