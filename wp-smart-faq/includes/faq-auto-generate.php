<?php
// Auto-generate FAQs on post save
function smart_faq_generate_gemini($post_id, $post, $update) {
    // Skip revisions
    if ( wp_is_post_revision($post_id) ) return;

    $api_key = get_option("smart_faq_api_key"); 
    if(!$api_key) return;

    $title   = $post->post_title;
    $content = strip_tags($post->post_content);

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent";

    $body = json_encode([
        "contents" => [[
            "parts" => [[
                "text" => "Generate 3 FAQs (Q&A format, SEO friendly) for this post titled: $title. Content: $content"
            ]]
        ]]
    ]);

    $response = wp_remote_post($url, [
        'headers' => [
            'Content-Type' => 'application/json',
            'X-goog-api-key' => $api_key
        ],
        'body' => $body
    ]);

    if ( is_wp_error($response) ) return;

    $data = json_decode(wp_remote_retrieve_body($response), true);

    // Extract FAQs from Gemini response
    $faqs_raw = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

    if($faqs_raw){
        update_post_meta($post_id, '_smart_faq', $faqs_raw);
    }
}

// Hook into save_post
add_action('save_post', 'smart_faq_generate_gemini', 10, 3);