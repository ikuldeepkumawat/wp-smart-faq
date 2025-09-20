<?php
if(!defined('ABSPATH')) exit;

function smart_faq_add_meta_box() {
    $screens = array('post', 'product'); // Post aur Product dono ke liye

    foreach($screens as $screen){
        add_meta_box(
            'smart_faq_box',                   // ID
            'Smart FAQs',                      // Title
            'smart_faq_meta_box_callback',     // Callback function
            $screen,                           // Post type (post & product)
            'normal',                          // Context
            'high'                             // Priority
        );
    }
}
add_action('add_meta_boxes', 'smart_faq_add_meta_box');

function smart_faq_meta_box_callback($post){
    $faqs = get_post_meta($post->ID, '_smart_faq', true);
    ?>
    <textarea style="width:100%;height:200px;" name="smart_faq_content"><?php echo esc_textarea($faqs); ?></textarea>
    <p>Modify or delete FAQs manually if needed.</p>
    <?php
}

function smart_faq_save_meta_box($post_id){
    if(isset($_POST['smart_faq_content'])){
        update_post_meta($post_id, '_smart_faq', sanitize_textarea_field($_POST['smart_faq_content']));
    }
}
add_action('save_post', 'smart_faq_save_meta_box');
