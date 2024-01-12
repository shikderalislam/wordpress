<?php
/*
Plugin Name: Scroll to Top Button
Description: Adds a button to smoothly scroll to the top of the page.
Version: 1.0
Author: Al Islam
*/

// Plugin code will go here
function enqueue_scroll_to_top_scripts() {
    wp_enqueue_style('scroll-to-top-style', plugins_url('assets/css/style.css', __FILE__));
    wp_enqueue_script('scroll-to-top-script', plugins_url('assets/js/script.js', __FILE__), array('jquery'), '1.0', true);
  }
  
  add_action('wp_enqueue_scripts', 'enqueue_scroll_to_top_scripts');
  function add_scroll_to_top_button() {
    echo '<button id="scroll-to-top">&#9650;</button>';
  }
  
  add_action('wp_footer', 'add_scroll_to_top_button');
  