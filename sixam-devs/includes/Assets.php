<?php

namespace SixAm\Devs;

/**
 * Assets handlers class
 */
class Assets {

    /**
     * Class constructor
     */
    function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );
    }

    /**
     * All available scripts
     *
     * @return array
     */
    public function get_scripts() {
        return [
            'devs-script' => [
                'src'     => SA_DEVS_ASSETS . '/js/frontend.js',
                'version' => filemtime( SA_DEVS_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'devs-enquiry-script' => [
                'src'     => SA_DEVS_ASSETS . '/js/enquiry.js',
                'version' => filemtime( SA_DEVS_PATH . '/assets/js/enquiry.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'devs-admin-script' => [
                'src'     => SA_DEVS_ASSETS . '/js/admin.js',
                'version' => filemtime( SA_DEVS_PATH . '/assets/js/admin.js' ),
                'deps'    => [ 'jquery', 'wp-util' ]
            ],
        ];
    }

    /**
     * All available styles
     *
     * @return array
     */
    public function get_styles() {
        return [
            'devs-style' => [
                'src'     => SA_DEVS_ASSETS . '/css/frontend.css',
                'version' => filemtime( SA_DEVS_PATH . '/assets/css/frontend.css' )
            ],
            'devs-admin-style' => [
                'src'     => SA_DEVS_ASSETS . '/css/admin.css',
                'version' => filemtime( SA_DEVS_PATH . '/assets/css/admin.css' )
            ],
            'devs-enquiry-style' => [
                'src'     => SA_DEVS_ASSETS . '/css/enquiry.css',
                'version' => filemtime( SA_DEVS_PATH . '/assets/css/enquiry.css' )
            ],
        ];
    }

    /**
     * Register scripts and styles
     *
     * @return void
     */
    public function register_assets() {
        $scripts = $this->get_scripts();
        $styles  = $this->get_styles();

        foreach ( $scripts as $handle => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;

            wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
        }

        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;

            wp_register_style( $handle, $style['src'], $deps, $style['version'] );
        }

        wp_localize_script( 'devs-enquiry-script', 'sixAmDevs', [
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'error'   => __( 'Something went wrong', 'sixam-devs' ),
        ] );

        wp_localize_script( 'devs-admin-script', 'sixAmDevs', [
            'nonce' => wp_create_nonce('sa-devs-admin-nonce' ),
            'confirm' => __( 'Are you sure?', 'sixam-devs' ),
            'error' => __( 'Something went wrong', 'sixam-devs' ),
        ] );
    }
}
