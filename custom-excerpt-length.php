<?php
/*
Plugin Name: Custom Excerpt Length
Plugin URI: None for now
Description: A plugin that allows you to adjust the length of entry excerpts.
Version: 1.0
Author: Daniel Lyszczek
Author URI: https://daniellyszczek.com/
License: GPL2
*/

// Plugin code

// Plugin language detection
function cel_load_textdomain() {
    load_plugin_textdomain('custom-excerpt-length', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'cel_load_textdomain');


// Adding excerpt length option
function cel_add_excerpt_length_option() {
    add_settings_section(
        'cel_settings_section',
        __('Excerpt Length', 'custom-excerpt-length'),
        'cel_settings_section_callback',
        'reading'
    );

    add_settings_field(
        'cel_excerpt_length',
        __('Excerpt Length (in words)', 'custom-excerpt-length'),
        'cel_excerpt_length_callback',
        'reading',
        'cel_settings_section'
    );

    register_setting('reading', 'cel_excerpt_length');
}
add_action('admin_init', 'cel_add_excerpt_length_option');

// Displaying settings section
function cel_settings_section_callback() {
    echo __('Set the length of post excerpts:', 'custom-excerpt-length');
}

// Displaying text field for excerpt length
function cel_excerpt_length_callback() {
    $excerpt_length = get_option('cel_excerpt_length', 55);
    echo '<input type="number" min="1" step="1" name="cel_excerpt_length" value="' . $excerpt_length . '" />';
}

// Applying custom excerpt length
function cel_custom_excerpt_length($length) {
    if (is_admin()) {
        return $length;
    }

    $excerpt_length = get_option('cel_excerpt_length', 55);
    return $excerpt_length;
}
add_filter('excerpt_length', 'cel_custom_excerpt_length', 999);


?>
