<?php
/*
Plugin Name: Animated Scroll Bar
Plugin URI: https://www.softbeez.com/
Description: Adds an animated scroll bar to your website.
Version: 1.0
Author: Al Islam
Requires at least: 5.2
License: GPLv2 or later
Requires PHP: 5.3
*/
function enqueue_animated_scroll_assets() {
    // Enqueue JavaScript
    wp_enqueue_script('animated-scroll-bar', plugins_url('/js/animated-scroll-bar.js', __FILE__), array('jquery'), '1.0', true);

    // Enqueue CSS
    wp_enqueue_style('animated-scroll-bar-style', plugins_url('/css/animated-scroll-bar.css', __FILE__), array(), '1.0');
}

add_action('wp_enqueue_scripts', 'enqueue_animated_scroll_assets');

