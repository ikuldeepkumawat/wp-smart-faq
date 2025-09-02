<?php
if(!defined('ABSPATH')) exit;

function smart_faq_menu() {
    add_menu_page(
        'Smart FAQ',
        'Smart FAQ',
        'manage_options',
        'smart-faq',
        'smart_faq_settings_page',
        'dashicons-editor-help',
        20
    );

    add_submenu_page(
        'smart-faq',
        'Custom CSS',
        'Custom CSS',
        'manage_options',
        'smart-faq-css',
        'smart_faq_custom_css_page'
    );
}
add_action('admin_menu', 'smart_faq_menu');
