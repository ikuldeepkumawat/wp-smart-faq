<?php
if(!defined('ABSPATH')) exit;

function smart_faq_frontend_custom_css() {
    $custom_css = get_option('smart_faq_custom_css');
    if($custom_css){
        echo "<style>". $custom_css ."</style>";
    }
}
add_action('wp_head', 'smart_faq_frontend_custom_css');
