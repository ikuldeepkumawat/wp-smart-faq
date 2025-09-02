<?php
if(!defined('ABSPATH')) exit;

function smart_faq_enqueue_styles() {
    wp_enqueue_style(
        'smart-faq-style',
        plugin_dir_url(__FILE__) . '../assets/style.css',
        array(),
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'smart_faq_enqueue_styles');

function smart_faq_enqueue_scripts() {
    wp_enqueue_script(
        'smart-faq-script',
        plugin_dir_url(__FILE__) . '../assets/script.js',
        array(),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'smart_faq_enqueue_scripts');
