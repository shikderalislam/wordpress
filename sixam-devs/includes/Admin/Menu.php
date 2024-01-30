<?php

namespace SixAm\Devs\Admin;

/**
 * The Menu handler class
 */
class Menu {

    public $addressbook;

    /**
     * Initialize the class
     */
    function __construct( $addressbook ) {
        $this->addressbook = $addressbook;

        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function admin_menu() {
        $parent_slug = 'sixam-devs';
        $capability = 'manage_options';
        $hook = add_menu_page( __( 'sixAm Devs', 'sixam-devs' ), __( '6am-devs', 'sixam-devs' ), $capability, $parent_slug, [ $this->addressbook, 'plugin_page' ], 'dashicons-welcome-learn-more' );
        add_submenu_page( $parent_slug, __( 'Address Book', 'sixam-devs' ), __( 'Address Book', 'sixam-devs' ), $capability, $parent_slug, [ $this->addressbook, 'plugin_page' ] );
        add_submenu_page( $parent_slug, __( 'Settings', 'sixam-devs' ), __( 'Settings', 'sixam-devs' ), $capability, 'sixam-devs-settings', [ $this, 'settings_page' ] );

        // Add a new submenu "Contact"
        add_submenu_page( $parent_slug, __( 'Contact', 'sixam-devs' ), __( 'Contact', 'sixam-devs' ), $capability, 'sixam-devs-contact', [ $this, 'contact_page' ] );


        add_action( 'admin_head-' . $hook, [ $this, 'enqueue_assets' ] );
    }

    /**
     * Handles the settings page
     *
     * @return void
     */
    public function settings_page() {
        echo '<h2> Settings Page </h2>';
    }
    /**
     * Handles the contact page
     *
     * @return void
     */
    public function contact_page() {
        echo '<h2> Contact Page </h2>';
    }
    /**
     * Enqueue scripts and styles
     *
     * @return void
     */
    public function enqueue_assets() {
        wp_enqueue_style( 'devs-admin-style' );
        wp_enqueue_script( 'devs-admin-script' );
    }
}
