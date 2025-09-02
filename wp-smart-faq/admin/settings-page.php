<?php
if(!defined('ABSPATH')) exit;

function smart_faq_settings_page() {
    ?>
    <div class="wrap">
        <h1>Smart FAQ Generator</h1>
        <?php settings_errors('smart_faq_messages'); ?>
        <form method="post" action="options.php">
            <?php
                settings_fields("smart_faq_options_group");
                do_settings_sections("smart-faq");
                submit_button("Save API Key");
            ?>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const messages = document.querySelectorAll('.notice');
        if(messages.length){
            setTimeout(() => {
                messages.forEach(msg => {
                    msg.style.transition = "opacity 0.5s";
                    msg.style.opacity = 0;
                    setTimeout(() => msg.remove(), 500); // fade out ke baad remove
                });
            }, 1000); // 3 second ke baad hide
        }
    });
    </script>
    <?php
}

// Option save hook
add_action('admin_init', function() {
    register_setting('smart_faq_options_group', 'smart_faq_api_key', [
        'sanitize_callback' => 'sanitize_text_field',
        'default' => ''
    ]);

    // Agar form submit hua hai
    if (isset($_POST['option_page']) && $_POST['option_page'] === 'smart_faq_options_group') {
        add_settings_error(
            'smart_faq_messages', // slug
            'smart_faq_message', // unique ID
            'API Key saved successfully!', // message
            'updated' // type: 'updated' = green, 'error' = red
        );
    }
});


function smart_faq_settings_init() {
    register_setting("smart_faq_options_group", "smart_faq_api_key");

    add_settings_section("smart_faq_section", "", null, "smart-faq");

    add_settings_field(
        "smart_faq_api_key",
        "Gemini API Key",
        "smart_faq_api_key_callback",
        "smart-faq",
        "smart_faq_section"
    );

    // Register custom CSS setting here too (optional)
    register_setting("smart_faq_css_group", "smart_faq_custom_css");
}
add_action("admin_init", "smart_faq_settings_init");

function smart_faq_api_key_callback() {
    $value = get_option("smart_faq_api_key");
    echo '<input type="text" name="smart_faq_api_key" value="' . esc_attr($value) . '" style="width:400px;" />';
}
