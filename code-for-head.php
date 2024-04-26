<?php
/*
Plugin Name: PixelPioneerPro Custom Codes
Description: Dodatak za implementaciju dodatnih kodova u <head> zaglavlje stranice.
Version: 1.0
Author: Nemanja Falb
Website: https://pixelpioneerpro.net
*/

// Dodajemo link ka podešavanjima u meniju
function pixelpioneerpro_custom_codes_menu() {
    add_options_page( 'Custom Codes Settings', 'Custom Codes', 'manage_options', 'pixelpioneerpro-custom-codes', 'pixelpioneerpro_custom_codes_page' );
}
add_action( 'admin_menu', 'pixelpioneerpro_custom_codes_menu' );

// Kreiramo stranicu za podešavanja
function pixelpioneerpro_custom_codes_page() {
    ?>
    <div class="wrap">
        <h2>PixelPioneerPro Custom Codes</h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'pixelpioneerpro_custom_codes_group' ); ?>
            <?php do_settings_sections( 'pixelpioneerpro-custom-codes' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Kreiramo polja za unos kodova
function pixelpioneerpro_custom_codes_fields() {
    add_settings_section( 'pixelpioneerpro_custom_codes_section', 'Dodatni Kodovi', 'pixelpioneerpro_custom_codes_section_callback', 'pixelpioneerpro-custom-codes' );

    add_settings_field( 'analytics_code', 'Google Analytics Kod', 'analytics_code_callback', 'pixelpioneerpro-custom-codes', 'pixelpioneerpro_custom_codes_section' );
    register_setting( 'pixelpioneerpro_custom_codes_group', 'analytics_code' );

    add_settings_field( 'console_code', 'Google Konzola Kod', 'console_code_callback', 'pixelpioneerpro-custom-codes', 'pixelpioneerpro_custom_codes_section' );
    register_setting( 'pixelpioneerpro_custom_codes_group', 'console_code' );

    add_settings_field( 'custom_code', 'Dodatni Kod', 'custom_code_callback', 'pixelpioneerpro-custom-codes', 'pixelpioneerpro_custom_codes_section' );
    register_setting( 'pixelpioneerpro_custom_codes_group', 'custom_code' );
}
add_action( 'admin_init', 'pixelpioneerpro_custom_codes_fields' );

// Callback funkcije za prikaz polja za unos
function pixelpioneerpro_custom_codes_section_callback() {
    echo 'Unesite željene kodove ispod:';
}

function analytics_code_callback() {
    $analytics_code = get_option( 'analytics_code' );
    echo '<textarea name="analytics_code" rows="5" cols="50">' . esc_attr( $analytics_code ) . '</textarea>';
}

function console_code_callback() {
    $console_code = get_option( 'console_code' );
    echo '<textarea name="console_code" rows="5" cols="50">' . esc_attr( $console_code ) . '</textarea>';
}

function custom_code_callback() {
    $custom_code = get_option( 'custom_code' );
    echo '<textarea name="custom_code" rows="5" cols="50">' . esc_attr( $custom_code ) . '</textarea>';
}

// Implementacija kodova u <head> zaglavlje
function pixelpioneerpro_custom_codes_output() {
    $analytics_code = get_option( 'analytics_code' );
    $console_code = get_option( 'console_code' );
    $custom_code = get_option( 'custom_code' );

    if ( !empty( $analytics_code ) ) {
        echo '<!-- Google Analytics Code -->' . $analytics_code . PHP_EOL;
    }

    if ( !empty( $console_code ) ) {
        echo '<!-- Google Konzola Code -->' . $console_code . PHP_EOL;
    }

    if ( !empty( $custom_code ) ) {
        echo '<!-- Dodatni Code -->' . $custom_code . PHP_EOL;
    }
}
add_action( 'wp_head', 'pixelpioneerpro_custom_codes_output' );

// Notifikacija nakon instaliranja dodatka
function pixelpioneerpro_custom_codes_install_notice() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p>Uspešno ste instalirali dodatak. Možete uneti svoj custom kod, kod od analitike ili konzole klikom <a href="<?php echo admin_url('options-general.php?page=pixelpioneerpro-custom-codes'); ?>">ovde</a>. Za podršku za WordPress i održavanje, posetite <a href="https://pixelpioneerpro.net/">ovu stranicu</a>.</p>
    </div>
    <?php
}
add_action( 'admin_notices', 'pixelpioneerpro_custom_codes_install_notice' );
