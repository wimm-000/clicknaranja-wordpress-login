<?php

/**
 * Plugin Name:     Cn Login Page
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     cn-login-page
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Cn_Login_Page
 */


// disable direct file access
if (!defined('ABSPATH')) {
  exit;
}

// if admin area
if (is_admin()) {
  // creamos opcione en el menu
  require_once plugin_dir_path(__FILE__) . 'admin/settings-page.php';
}


// Si es front seleccionamos los siguientes elementos para modificar estilos de la pagina de login
function my_login_stylesheet()
{
  wp_enqueue_style('custom-login', plugin_dir_url(__FILE__) . 'front/css/login.css');
  // wp_enqueue_script( 'custom-login', get_stylesheet_directory_uri() . '/style-login.js' );
  wp_add_inline_style('custom-login', ':root {
    --color__main: ' . get_option('cn_custom_login_color_principal') . ';
    --color__alt: ' . get_option('cn_custom_login_color_secundario') . ';
  }
  body.login {
    background-image: url("' . get_option('cn_custom_login_background_image') . '")
  } body.login div#login h1 a {
    background-image: url("' . get_option('cn_custom_login_logo_image') . '");
  }');
}
add_action('login_enqueue_scripts', 'my_login_stylesheet');

// Al pulsar el logo ir a la home
function my_login_logo_url()
{
  return home_url();
}

add_filter('login_headerurl', 'my_login_logo_url');

// Cambiamos el titulo de la url de la pagina de login
function my_login_logo_url_title()
{
  return 'Volver a Morales Box';
}
add_filter('login_headertitle', 'my_login_logo_url_title');
