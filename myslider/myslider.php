<?php
/*
* Plugin Name: My-slider
* Description: Slider for homepage
* Author: Al Islam
* Version: 1.0.0
* Text-Domain: alis
*/

// Register custom post type
function alis_register_cpt() {
    $labels = array(
        'name' => 'My Slider',
    );

    $args = array(
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
    );

    register_post_type('my-slider', $args);
}
add_action('init', 'alis_register_cpt');

// Shortcode to display the slider
function alis_shortcode_register() {
    $args = array(
        'post_type' => 'my-slider',
        'posts_per_page' => -1,
    );
    $query = new WP_Query($args);
    $html = '
    <script>
    jQuery(document).ready(function($) {
        $(".my-slider").slick(); // Initialize the slick slider
    });
    </script>
  
    <div class="my-slider">';
    while ($query->have_posts()) : $query->the_post();
        $html .= '<h2>' . get_the_title() . '</h2>';
    endwhile;
    wp_reset_query();
    $html .= '</div>';
    return $html;
}
add_shortcode('my_slider', 'alis_shortcode_register');

// Enqueue assets (slick.css and slick.min.js)
function alis_add_assets() {
    $plugin_dir_url = plugin_dir_url(__FILE__);
    wp_enqueue_style('slick', $plugin_dir_url . 'assets/css/slick.css');
    wp_enqueue_script('slick', $plugin_dir_url . 'assets/js/slick.min.js', ['jquery'], '1.8.1', true);
}
add_action('wp_enqueue_scripts', 'alis_add_assets');
