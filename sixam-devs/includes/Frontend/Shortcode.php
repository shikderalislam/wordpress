<?php

namespace SixAm\Devs\Frontend;

/**
 * Shortcode handler class
 */
class Shortcode {

    /**
     * Initializes the class
     */
    function __construct() {
        add_shortcode( 'sixam-devs', [ $this, 'render_shortcode' ] );
    }

    /**
     * Shortcode handler class
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function render_shortcode( $atts, $content = '' ) {
        wp_enqueue_script( 'devs-script' );
        wp_enqueue_style( 'devs-style' );

        return '<div class="devs-shortcode">Hello from Shortcode</div>';
    }
}
