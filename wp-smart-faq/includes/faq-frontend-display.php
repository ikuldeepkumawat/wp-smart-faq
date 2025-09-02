<?php
function smart_faq_display($content) {
    if ( is_singular('post') || ( function_exists('is_product') && is_product() ) ) {
        $faqs_raw = get_post_meta(get_the_ID(), '_smart_faq', true);
        if($faqs_raw){
            $lines = preg_split("/\r\n|\n|\r/", $faqs_raw);
            $faq_html = "<div class='smart-faq'><h3>FAQs</h3><ul>";

            $schema = array("@context"=>"https://schema.org","@type"=>"FAQPage","mainEntity"=>array());
            $current_q = '';

            foreach($lines as $line){
                $line = trim($line);
                if(empty($line)) continue;

                // Remove Markdown ** and * characters
                $line = preg_replace('/^\*+\s*/','',$line);
                $line = preg_replace('/^\**\s*/','',$line);

                // Detect Q:
                if(preg_match('/^Q[:]?/i', $line)){
                    $current_q = preg_replace('/^Q[:]?/i','',$line);
                }
                // Detect A:
                elseif(preg_match('/^A[:]?/i', $line) && $current_q){
                    $answer = preg_replace('/^A[:]?/i','',$line);
                    $faq_html .= "<li style='cursor:pointer;margin-bottom:10px;'><strong>".esc_html($current_q)."</strong><p style='display:none;margin-top:5px;'>".esc_html($answer)."</p></li>";

                    $schema['mainEntity'][] = array(
                        "@type"=>"Question",
                        "name"=> $current_q,
                        "acceptedAnswer"=>array("@type"=>"Answer","text"=>$answer)
                    );

                    $current_q = '';
                }
            }

            $faq_html .= "</ul></div>";

            $content .= $faq_html;
        }
    }
    return $content;
}
add_filter('the_content', 'smart_faq_display');