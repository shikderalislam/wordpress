<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e( 'Address Book', 'sixam-devs' ); ?></h1>

    <a href="<?php echo admin_url( 'admin.php?page=sixam-devs&action=new' ); ?>" class="page-title-action"><?php _e( 'Add New', 'sixam-devs' ); ?></a>

    <?php if ( isset( $_GET['inserted'] ) ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'Address has been added successfully!', 'sixam-devs' ); ?></p>
        </div>
    <?php } ?>

    <?php if ( isset( $_GET['address-deleted'] ) && $_GET['address-deleted'] == 'true' ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'Address has been deleted successfully!', 'sixam-devs' ); ?></p>
        </div>
    <?php } ?>

    <form action="" method="post">
        <?php
        $table = new \SixAm\Devs\Admin\Address_List();
        $table->prepare_items();
        $table->search_box( 'search', 'search_id' );
        $table->display();
        ?>
    </form>
</div>
