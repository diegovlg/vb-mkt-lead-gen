<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Vibra_Marketing
 * @subpackage Vibra_Marketing/includes
 */
class Vibra_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
        // Create necessary database tables
        self::create_tables();

        // Set default options
        self::set_default_options();

        // Any other activation tasks...
    }

    /**
     * Create necessary database tables.
     */
    private static function create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $table_name = $wpdb->prefix . 'vibra_marketing_submissions';

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            message text NOT NULL,
            created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Set default options for the plugin.
     */
    private static function set_default_options() {
        $default_options = array(
            'whatsapp_number' => '',
            'whatsapp_message' => 'Hello, I have a question about your services.',
            'whatsapp_button_color' => '#25D366',
            'form_recipient_email' => get_option('admin_email'),
        );

        foreach ($default_options as $option_name => $option_value) {
            if (false === get_option('vibra_marketing_' . $option_name)) {
                add_option('vibra_marketing_' . $option_name, $option_value);
            }
        }
    }
}