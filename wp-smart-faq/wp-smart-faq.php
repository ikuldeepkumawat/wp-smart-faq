<?php
/**
 * Plugin Name: Smart FAQ Generator
 * Description: Auto-generate FAQs with Schema Markup for posts & WooCommerce products using Google Gemini API.
 * Version: 1.0
 * Author: Kuldeep Kumawat
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Admin includes
require_once plugin_dir_path(__FILE__) . 'admin/menu.php';
require_once plugin_dir_path(__FILE__) . 'admin/settings-page.php';
require_once plugin_dir_path(__FILE__) . 'admin/custom-css-page.php';
require_once plugin_dir_path(__FILE__) . 'admin/meta-box.php';

// Frontend includes
require_once plugin_dir_path(__FILE__) . 'includes/frontend.php';
require_once plugin_dir_path(__FILE__) . 'includes/enqueue.php';

// Load FAQ Generator
require_once plugin_dir_path(__FILE__) . 'includes/faq-generator.php';

