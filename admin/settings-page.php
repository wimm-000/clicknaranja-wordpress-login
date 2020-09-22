<?php
// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

// Añade una opcion en el settings del administrador                    

// add sub-level administrative menu
function cn_login_add_sublevel_menu()
{

    add_submenu_page(
        'options-general.php', // Colocamos la opcion en ajustes
        'Modificar diseño se la pagina de login de la pagina de login',
        'Custom login',
        'manage_options',
        'cn-custom-login',
        'cn_login_display_settings_page'
    );
}
add_action('admin_menu', 'cn_login_add_sublevel_menu');

// display the plugin settings page
function cn_login_display_settings_page()
{

    // check if user is allowed access
    if (!current_user_can('manage_options')) return;
    // Añadimos el js
    wp_enqueue_media();
    wp_enqueue_script('cn_custom_login', plugins_url('js/admin.js', __FILE__), array('jquery'));
    //Añadimos el css
    wp_enqueue_style('cn_custom_login_stules',  plugins_url('css/admin.css', __FILE__));
    // Si se ha enviado el form gestionamos el envio
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['updated'] === 'true') {
        handle_form();
    }
?>

    <div class="cncl">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post">
            <input type="hidden" name="updated" value="true" />
            <?php wp_nonce_field('cn_custom_login_update', 'cn_custom_login_form'); ?>
            <ul>
                <li>
                    <h3>Logotipo</h3>
                    <div class="cncl__content">
                        <figure class="cncl__image-logo-container">
                            <img class="cncl__thumbnail-logo" src="<?php echo get_option('cn_custom_login_logo_image'); ?>" width="100" height="100" alt="">
                            <a class="cncl__remove-logo">X</a>
                        </figure>
                        <div class="cncl__fields">
                            <input id="logo_image" type="hidden" name="logo_image" value="<?php echo get_option('cn_custom_login_logo_image'); ?>" />
                            <p class="cncl__logo-image-path"><?php echo get_option('cn_custom_login_logo_image'); ?></p>
                            <input id="upload_logo_image_button" type="button" class="button-primary" value="Seleccionar Logo de cabecera" />
                        </div>
                    </div>
                </li>

                <li class="cncl__fieldset">
                    <h3>Imagen de fondo</h3>
                    <div class="cncl__content">
                        <figure class="cncl__image-container">
                            <img class="cncl__thumbnail" src="<?php echo get_option('cn_custom_login_background_image'); ?>" width="100" height="100" alt="">
                            <a class="cncl__remove">X</a>
                        </figure>
                        <div class="cncl__fields">
                            <input id="background_image" type="hidden" name="background_image" value="<?php echo get_option('cn_custom_login_background_image'); ?>" />
                            <p class="cncl__image-path"><?php echo get_option('cn_custom_login_background_image'); ?></p>
                            <input id="upload_image_button" type="button" class="button-primary" value="Seleccionar Imagen de fondo" />
                        </div>
                    </div>
                </li>
                <li class="cncl__fieldset">

                    <h3>Color pricipal</h3>
                    <div class="cncl__fields">
                        <input id="color_principal" type="text" name="color_principal" value="<?php echo get_option('cn_custom_login_color_principal'); ?>" />
                    </div>
                    <p class="cncl__image-path">Introduce el color hexadecimal con almohadilla</p>

                </li>
                <li class="cncl__fieldset">
                    <h3>Color secundario</h3>

                    <div class="cncl__fields">
                        <input id="color_secundario" type="text" name="color_secundario" value="<?php echo get_option('cn_custom_login_color_secundario'); ?>" />
                    </div>
                    <p class="cncl__image-path">Introduce el color hexadecimal con almohadilla</p>
                </li>
            </ul>
            <?php submit_button() ?>
        </form>
    </div>

    <?php

}

// Si se envia el formulario gestionamos el form
function handle_form()
{
    if (
        // comprobamos nonce
        !isset($_POST['cn_custom_login_form']) ||
        !wp_verify_nonce($_POST['cn_custom_login_form'], 'cn_custom_login_update')
    ) { ?>
        <div class="error">
            <p>El nonce no es correcto. Por favor intentalo otra vez</p>
        </div>
    <?php
        exit;
    } else {
        // Handle our form data
        // sanitizamos información
        $background_image = sanitize_text_field($_POST['background_image']);
        $logo_image = sanitize_text_field($_POST['logo_image']);
        $color_principal = sanitize_text_field($_POST['color_principal']);
        $color_secundario = sanitize_text_field($_POST['color_secundario']);
        update_option('cn_custom_login_background_image', $background_image);
        update_option('cn_custom_login_logo_image', $logo_image);
        update_option('cn_custom_login_color_principal', $color_principal);
        update_option('cn_custom_login_color_secundario', $color_secundario);
    ?>
        <div class="updated">
            <p>Los cambios se han guardado correctamente</p>
        </div>
<?php
    }
}
