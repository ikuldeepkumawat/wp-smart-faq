<?php
if(!defined('ABSPATH')) exit;

function smart_faq_add_meta_box() {
    add_meta_box(
        'smart_faq_box',
        'Smart FAQs',
        'smart_faq_meta_box_callback',
        'post',
        'normal',
        'high'
    );
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
