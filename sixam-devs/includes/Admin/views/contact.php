<?php

namespace SixAm\Devs\Admin;

use SixAm\Devs\Traits\Form_Error;

/**
 * Contact Handler class
 */
class Contact {

    use Form_Error;

    /**
     * Plugin page handler
     *
     * @return void
     */
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ( $action ) {
            case 'new':
                $template = __DIR__ . '/views/contact-new.php';
                break;

            case 'edit':
                $contact  = sa_dv_get_contact( $id );
                $template = __DIR__ . '/views/contact-edit.php';
                break;

            default:
                $template = __DIR__ . '/views/contact-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Handle the form
     *
     * @return void
     */
    public function form_handler() {
        if ( ! isset( $_POST['submit_contact'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'new-contact' ) ) {
            wp_die( 'Are you cheating?' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Are you cheating?' );
        }

        $id           = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
        $name         = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
        $mobile_number = isset( $_POST['mobile_number'] ) ? sanitize_text_field( $_POST['mobile_number'] ) : '';

        if ( empty( $name ) ) {
            $this->errors['name'] = __( 'Please provide a name', 'sixam-devs' );
        }

        if ( empty( $mobile_number ) ) {
            $this->errors['mobile_number'] = __( 'Please provide a mobile number.', 'sixam-devs' );
        }

        if ( ! empty( $this->errors ) ) {
            return;
        }

        $args = [
            'name'          => $name,
            'mobile_number' => $mobile_number,
        ];

        if ( $id ) {
            $args['id'] = $id;
        }

        $insert_id = sa_dv_insert_contact( $args );

        if ( is_wp_error( $insert_id ) ) {
            wp_die( $insert_id->get_error_message() );
        }

        if ( $id ) {
            $redirected_to = admin_url( 'admin.php?page=sixam-devs-contact&action=edit&contact-updated=true&id=' . $id );
        } else {
            $redirected_to = admin_url( 'admin.php?page=sixam-devs-contact&inserted=true' );
        }

        wp_redirect( $redirected_to );
        exit;
    }

    /**
     * Delete a contact
     *
     * @return void
     */
    public function delete_contact() {
        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'sa-devs-contact-nonce' ) ) {
            wp_die( 'Are you cheating?' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Are you cheating?' );
        }

        $id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;

        if ( sa_dv_delete_contact( $id ) ) {
            $redirected_to = admin_url( 'admin.php?page=sixam-devs-contact&contact-deleted=true' );
        } else {
            $redirected_to = admin_url( 'admin.php?page=sixam-devs-contact&contact-deleted=false' );
        }

        wp_redirect( $redirected_to );
        exit;
    }
}
