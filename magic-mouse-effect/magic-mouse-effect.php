<?php
/*
Plugin Name: Magic Mouse Effect
Description: Adds a magical mouse effect to your website.
Version: 1.0
Author: Your Name
*/

// Enqueue the required styles and scripts
function magic_mouse_enqueue_scripts() {
    // Enqueue FontAwesome for the star icon
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css');

    // Enqueue the custom CSS file
    wp_enqueue_style('magic-mouse-style', plugins_url('style.css', __FILE__));

    // Enqueue the JavaScript file
    wp_enqueue_script('magic-mouse-script', plugins_url('script.js', __FILE__), array('jquery'), null, true);
}

// Add the enqueue function to the wp_enqueue_scripts action hook
add_action('wp_enqueue_scripts', 'magic_mouse_enqueue_scripts');
