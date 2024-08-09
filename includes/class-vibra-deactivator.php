<?php

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Vibra_Marketing
 * @subpackage Vibra_Marketing/includes
 */
class Vibra_Deactivator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate() {
        // Cleanup tasks, if any
        // Note: We're not deleting the database table or options here
        // in case the user reactivates the plugin and wants to keep their data.
        // Consider adding an uninstall.php file for complete data removal if needed.

        // Optionally, you could add code here to remove any scheduled events, 
        // clear any caches, or perform other cleanup tasks.

        // For example:
        // wp_clear_scheduled_hook('vibra_marketing_hourly_event');
    }
}