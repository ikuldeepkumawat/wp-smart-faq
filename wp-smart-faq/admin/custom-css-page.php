<?php
if(!defined('ABSPATH')) exit;

function smart_faq_custom_css_page() {
    // Check if form is submitted and nonce is valid
    if (isset($_POST['smart_faq_custom_css'])) {
        update_option('smart_faq_custom_css', wp_kses_post($_POST['smart_faq_custom_css']));
        // Show a transient flag to trigger notice
        set_transient('smart_faq_css_saved', true, 5); // 5 seconds
    }
    ?>
    <div class="wrap">
        <h1>Smart FAQ - Custom CSS</h1>
        <?php
        // Display message if saved
        if (get_transient('smart_faq_css_saved')) {
            echo '<div id="smart-faq-css-message" class="notice notice-success is-dismissible">
                    <p>Custom CSS saved successfully!</p>
                  </div>';
            delete_transient('smart_faq_css_saved'); // delete right after showing
        }
        ?>
        <form method="post" action="">
            <?php
                settings_fields("smart_faq_css_group");
                do_settings_sections("smart-faq-css");
                $custom_css = get_option('smart_faq_custom_css');
            ?>
            <textarea name="smart_faq_custom_css" style="width:100%;height:300px;"><?php echo esc_textarea($custom_css); ?></textarea>
            <?php submit_button("Save CSS"); ?>
        </form>
    </div>

    <script>
        // Hide message after 1 second
        document.addEventListener("DOMContentLoaded", function(){
            const msg = document.getElementById("smart-faq-css-message");
            if(msg){
                setTimeout(()=> {
                    msg.style.transition = "opacity 0.5s";
                    msg.style.opacity = 0;
                    setTimeout(()=> msg.remove(), 500);
                }, 1000);
            }
        });
    </script>
    <?php
}
