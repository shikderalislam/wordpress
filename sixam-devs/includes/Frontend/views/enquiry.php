<div class="sadevs-enquiry-form" id="sadevs-enquiry-form">

    <form action="" method="post">

        <div class="form-row">
            <label for="name"><?php _e( 'Name', 'sixam-devs' ); ?></label>

            <input type="text" id="name" name="name" value="" required>
        </div>

        <div class="form-row">
            <label for="email"><?php _e( 'E-Mail', 'sixam-devs' ); ?></label>

            <input type="email" id="email" name="email" value="" required>
        </div>

        <div class="form-row">
            <label for="message"><?php _e( 'Message', 'sixam-devs' ); ?></label>

            <textarea name="message" id="message" required></textarea>
        </div>

        <div class="form-row">

            <?php wp_nonce_field( 'sa-dv-enquiry-form' ); ?>

            <input type="hidden" name="action" value="sa_devs_enquiry">
            <input type="submit" name="send_enquiry" value="<?php esc_attr_e( 'Send Enquiry', 'sixam-devs' ); ?>">
        </div>

    </form>
</div>
