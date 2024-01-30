<?php

namespace SixAm\Devs;

/**
 * Ajax handler class
 */
class Ajax {

    /**
     * Class constructor
     */
    function __construct() {
        add_action( 'wp_ajax_sa_devs_enquiry', [ $this, 'submit_enquiry'] );
        add_action( 'wp_ajax_nopriv_sa_devs_enquiry', [ $this, 'submit_enquiry'] );

        add_action( 'wp_ajax_sa-devs-delete-contact', [ $this, 'delete_contact'] );
    }

    /**
     * Handle Enquiry Submission
     *
     * @return void
     */
    public function submit_enquiry() {

        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'sa-devs-enquiry-form' ) ) {
            wp_send_json_error( [
                'message' => __( 'Nonce verification failed!', 'sixam-devs' )
            ] );
        }

        wp_send_json_success([
            'message' => __( 'Enquiry has been sent successfully!', 'sixam-devs' )
        ]);
    }

    /**
     * Handle contact deletion
     *
     * @return void
     */
    public function delete_contact() {
        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'sa-devs-admin-nonce' ) ) {
            wp_send_json_error( [
                'message' => __( 'Nonce verification failed!', 'sixam-devs' )
            ] );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( [
                'message' => __( 'No permission!', 'sixam-devs' )
            ] );
        }

        $id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;
        sa_dv_delete_address( $id );

        wp_send_json_success();
    }
}
