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

use Nsi\ContactForm\Plugin;
use Nsi\Helpers\Hookable;

class Assets extends Hookable {
  //Tableau de l'ensemble des variables JS
  static $js_vars = [];

  /**
   * Déclare l'ensemble des hooks appelés dans la classe
   */
  public static function hooks() {
    static::setJSVar( 'ajax_url', admin_url( 'admin-ajax.php' ) );
    Assets::setJsVar( 'widget_class', Plugin::PLUGIN_NAME . '_container' );

    //actions
    add_action( 'wp_enqueue_scripts', [get_called_class(), 'enqueue_scripts'] );
  }

  /**
   * Inclus les scripts nécessaires dans le thème
   */
  public static function enqueue_scripts() {
    if ( carbon_get_theme_option( Plugin::PLUGIN_NAME . "recaptcha_enable" ) && carbon_get_theme_option( Plugin::PLUGIN_NAME . "recaptcha_public" ) && carbon_get_theme_option( Plugin::PLUGIN_NAME . "recaptcha_private" ) ) {
      wp_enqueue_script( Plugin::PLUGIN_NAME . 'google-recaptcha-js', "https://www.google.com/recaptcha/api.js?render=" . carbon_get_theme_option( Plugin::PLUGIN_NAME . "recaptcha_public" ) );
      static::setJSVar( "recaptcha_public", carbon_get_theme_option( Plugin::PLUGIN_NAME . "recaptcha_public" ) );
    }

    //Javascript
    wp_register_script( Plugin::PLUGIN_NAME . '-js', static::url( 'scripts/main.js' ), ['jquery', 'react', 'react-dom'], true );
    wp_localize_script( Plugin::PLUGIN_NAME . '-js', Plugin::PLUGIN_NAME, static::$js_vars );
    wp_enqueue_script( Plugin::PLUGIN_NAME . '-js' );

    //Styles
    wp_enqueue_style( Plugin::PLUGIN_NAME . '-css', static::url( 'styles/main.css' ) );
  }

  /**
   * Retourne l'URL du fichier asset passé en paramètre (dans le dossier dist)
   * @param string filename : Nom du fichier pour lequel on recherche le path
   * @return string : chemin serveur du fichier dans le répertoire dist du theme
   * @TODO : Rédiriger cette fonction pour obtenir un chemin absolut avec les fonction wordpress
   */
  public static function url( $filename ) {
    return plugins_url( '../../dist/', __FILE__ ) . static::getCompiledFilename( $filename );

  }

  /**
   * Retourne le chemin sur le serveur d'accès au fichier passé en paramètre (dans le dossier dist)
   * @param string filename : Nom du fichier pour lequel on recherche le path
   * @return string : chemin serveur du fichier dans le répertoire dist du theme
   * @TODO : Rédiriger cette fonction pour obtenir un chemin absolut avec les fonction wordpress
   */
  public static function path( $filename ) {
    return 'dist/' . static::getCompiledFilename( $filename );
  }

  /**
   * Retourne le nom du fichier compiler à partir du nom de fichier d'asset original
   * @param string : Nom du fichier d'asset original
   * @return string : nom du fichier compilé dans dist
   * @TODO : Rendre cette fonction fonctionnelle
   */
  protected static function getCompiledFilename( $filename ) {
    if ( file_exists( plugin_dir_path( __FILE__ ) . '../../dist/assets.json' ) ) {
      $files = json_decode( file_get_contents( plugin_dir_path( __FILE__ ) . '../../dist/assets.json' ), true );
      if ( isset( $files[$filename] ) ) {
        return $files[$filename];
      }
      return false;
    }
    return $filename;
  }

  /**
   * Définie la valeur d'une variable JS
   * @param string $key : Nom de la variable javascript
   * @param mixed $value : Valeur de la vaiable javascript
   */
  public static function setJSVar( $key, $value ) {
    static::$js_vars[$key] = $value;
  }

}
Assets::getInstance();