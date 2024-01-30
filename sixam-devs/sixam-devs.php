<?php
/**
 * Plugin Name: DevsBoilerplate
 * Description: A boilerplate plugin for sixam intern developer
 * Plugin URI: https://6amtech.com
 * Author: 6amtech
 * Author URI: https://6amtech.com
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ali_devsboilerplate
 */

use SixAm\Devs\Admin;
use SixAm\Devs\Ajax;
use SixAm\Devs\API;
use SixAm\Devs\Assets;
use SixAm\Devs\Frontend;
use SixAm\Devs\Installer;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class SixAm_devs {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0';

    /**
     * Class constructor
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initializes a singleton instance
     *
     * @return DevsBoilerplate
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'SA_DEVS_VERSION', self::version );
        define( 'SA_DEVS_FILE', __FILE__ );
        define( 'SA_DEVS_PATH', __DIR__ );
        define( 'SA_DEVS_URL', plugins_url( '', SA_DEVS_FILE ) );
        define( 'SA_DEVS_ASSETS', SA_DEVS_URL . '/assets' );
        define( 'DBP_TEXT_DOMAIN', 'ali_devsboilerplate' );//added text domain
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        new Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Ajax();
        }

        if ( is_admin() ) {
            new Admin();
        } else {
            new Frontend();
        }

        new API();
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $this->create_contacts_table();
        $installer = new Installer();
        $installer->run();
    }

    /**
     * Create the "contacts" table in the database if not exists
     */
    private function create_contacts_table()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'contacts';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(50) NOT NULL,
            email varchar(50) NOT NULL,
            phone varchar(15) NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
/**
 * Initializes the main plugin
 *
 * @return DevsBoilerplate
 */
function sdevsboilerplate() {
    return DevsBoilerplate::init();
}

// kick-off the plugin
devsboilerplate();

function set_menu_icon() {
    add_menu_page(
        'DevsBoilerplate',
        '6am-devs',
        'manage_options',
        'devsboilerplate',
        [$this, 'admin_page'],
        'dashicons-admin-generic', // Set the Dashicon here
        20
    );
}
function admin_page() {
    // Your admin page content goes here
}

/**
 * Enqueue Bootstrap CSS and JS for the admin panel
 */
function enqueue_bootstrap() {
    if ( is_admin() ) {
        // Enqueue Bootstrap CSS
        wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'assets/bootstrap.min.css', array(), '5.3.0' );

        // Enqueue Bootstrap JS 
        wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . 'assets/bootstrap.bundle.min.js', array( 'jquery' ), '5.3.0', true );
    }
}
add_action( 'admin_enqueue_scripts', 'enqueue_bootstrap' );
