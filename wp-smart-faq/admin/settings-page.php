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
                submit_button("Save Settings");
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
                    setTimeout(() => msg.remove(), 500);
                });
            }, 1000);
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

    register_setting('smart_faq_options_group', 'smart_faq_count', [
        'sanitize_callback' => 'absint', // sirf number save hoga
        'default' => 3
    ]);

    register_setting('smart_faq_options_group', 'smart_faq_autogen', [
        'sanitize_callback' => function($val){ return $val ? 1 : 0; },
        'default' => 1 // default enabled
    ]);

    register_setting('smart_faq_options_group', 'smart_faq_heading', [
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'FAQs' // Default text
    ]);

    if (isset($_POST['option_page']) && $_POST['option_page'] === 'smart_faq_options_group') {
        add_settings_error(
            'smart_faq_messages',
            'smart_faq_message',
            'Settings saved successfully!',
            'updated'
        );
    }
});


function smart_faq_settings_init() {
    register_setting("smart_faq_options_group", "smart_faq_api_key");
    register_setting("smart_faq_options_group", "smart_faq_count");
    register_setting("smart_faq_options_group", "smart_faq_autogen");

    add_settings_section("smart_faq_section", "", null, "smart-faq");

    add_settings_field(
        "smart_faq_api_key",
        "Gemini API Key",
        "smart_faq_api_key_callback",
        "smart-faq",
        "smart_faq_section"
    );

    add_settings_field(
        "smart_faq_count",
        "Number of FAQs",
        "smart_faq_count_callback",
        "smart-faq",
        "smart_faq_section"
    );

     add_settings_field(
        "smart_faq_autogen",
        "Auto Generate FAQs",
        "smart_faq_autogen_callback",
        "smart-faq",
        "smart_faq_section"
    );

    add_settings_field(
        'smart_faq_heading',
        'FAQ Section Heading',
        'smart_faq_heading_callback',
        'smart-faq',
        'smart_faq_section'
    );
}
add_action("admin_init", "smart_faq_settings_init");

function smart_faq_api_key_callback() {
    $value = get_option("smart_faq_api_key");
    echo '<input type="text" name="smart_faq_api_key" value="' . esc_attr($value) . '" style="width:400px;" />';
}

function smart_faq_count_callback() {
    $value = get_option("smart_faq_count", 3);
    echo '<input type="number" name="smart_faq_count" value="' . esc_attr($value) . '" min="1" max="10" style="width:100px;" />';
}

function smart_faq_autogen_callback() {
    $value = get_option("smart_faq_autogen", 1);
    echo '<label><input type="checkbox" name="smart_faq_autogen" value="1" ' . checked(1, $value, false) . ' /> Enable AI Auto-Generate</label>';
}

function smart_faq_heading_callback() {
    $value = get_option('smart_faq_heading', 'FAQs');
    echo '<input type="text" name="smart_faq_heading" value="' . esc_attr($value) . '" style="width:300px;" />';
}
