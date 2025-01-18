<?php
/*
Plugin Name: PixelPioneerPro Custom Codes
Plugin URI: https://pixelpioneerpro.net
Description: Plugin for implementing additional code in the <head> section of the page.
Version: 1.0
Requires at least: 5.8
Requires PHP: 5.6.20
Author: Nemanja Falb
License: GPLv2 or later
Copyright 2023-2024 Automattic, Inc.
*/
// Nova tura
// Add link to settings in the menu
function pixelpioneerpro_custom_codes_menu() {
    add_options_page( 'Custom Codes Settings', 'Custom Codes', 'manage_options', 'pixelpioneerpro-custom-codes', 'pixelpioneerpro_custom_codes_page' );
}
add_action( 'admin_menu', 'pixelpioneerpro_custom_codes_menu' );

// Create settings page
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

// Create fields for code input
function pixelpioneerpro_custom_codes_fields() {
    add_settings_section( 'pixelpioneerpro_custom_codes_section', 'Additional Codes', 'pixelpioneerpro_custom_codes_section_callback', 'pixelpioneerpro-custom-codes' );

    add_settings_field( 'analytics_code', 'Google Analytics Code', 'analytics_code_callback', 'pixelpioneerpro-custom-codes', 'pixelpioneerpro_custom_codes_section' );
    register_setting( 'pixelpioneerpro_custom_codes_group', 'analytics_code' );

    add_settings_field( 'console_code', 'Google Console Code', 'console_code_callback', 'pixelpioneerpro-custom-codes', 'pixelpioneerpro_custom_codes_section' );
    register_setting( 'pixelpioneerpro_custom_codes_group', 'console_code' );

    add_settings_field( 'custom_code', 'Additional Code', 'custom_code_callback', 'pixelpioneerpro-custom-codes', 'pixelpioneerpro_custom_codes_section' );
    register_setting( 'pixelpioneerpro_custom_codes_group', 'custom_code' );
}
add_action( 'admin_init', 'pixelpioneerpro_custom_codes_fields' );

// Callback functions to display input fields
function pixelpioneerpro_custom_codes_section_callback() {
    echo 'Enter desired codes below:';
}

function analytics_code_callback() {
    $analytics_code = get_option( 'analytics_code' );
    echo '<textarea name="analytics_code" rows="5" cols="50">' . esc_textarea( $analytics_code ) . '</textarea>';
}

function console_code_callback() {
    $console_code = get_option( 'console_code' );
    echo '<textarea name="console_code" rows="5" cols="50">' . esc_textarea( $console_code ) . '</textarea>';
}

function custom_code_callback() {
    $custom_code = get_option( 'custom_code' );
    echo '<textarea name="custom_code" rows="5" cols="50">' . esc_textarea( $custom_code ) . '</textarea>';
}

// Implement codes in the <head> section
function pixelpioneerpro_custom_codes_output() {
    $analytics_code = get_option( 'analytics_code' );
    $console_code = get_option( 'console_code' );
    $custom_code = get_option( 'custom_code' );

    if ( !empty( $analytics_code ) ) {
        echo '<!-- Google Analytics Code -->' . $analytics_code . PHP_EOL;
    }

    if ( !empty( $console_code ) ) {
        echo '<!-- Google Console Code -->' . $console_code . PHP_EOL;
    }

    if ( !empty( $custom_code ) ) {
        echo '<!-- Additional Code -->' . $custom_code . PHP_EOL;
    }
}
add_action( 'wp_head', 'pixelpioneerpro_custom_codes_output' );

// Notification after installing the plugin
function pixelpioneerpro_custom_codes_install_notice() {
    if ( ! get_option( 'pixelpioneerpro_custom_codes_install_notice_dismissed' ) ) {
        ?>
        <div id="pixelpioneerpro-custom-codes-notice" class="notice notice-success is-dismissible">
            <p>You have successfully installed the plugin. You can enter your custom code, analytics code, or console code <a href="<?php echo admin_url('options-general.php?page=pixelpioneerpro-custom-codes'); ?>">here</a>. For WordPress support and maintenance, visit <a href="https://pixelpioneerpro.net/">this page</a>.</p>
        </div>
        <script>
            jQuery(document).on('click', '#pixelpioneerpro-custom-codes-notice .notice-dismiss', function() {
                jQuery.ajax({
                    url: ajaxurl,
                    data: {
                        action: 'pixelpioneerpro_custom_codes_notice_dismissed'
                    }
                });
            });
        </script>
        <?php
    }
}
add_action( 'admin_notices', 'pixelpioneerpro_custom_codes_install_notice' );

// Dismiss notification
function pixelpioneerpro_custom_codes_notice_dismissed() {
    update_option( 'pixelpioneerpro_custom_codes_install_notice_dismissed', true );
    die;
}
add_action( 'wp_ajax_pixelpioneerpro_custom_codes_notice_dismissed', 'pixelpioneerpro_custom_codes_notice_dismissed' );

?>
