<?php
/**
 * Plugin Name: Vibra Marketing Lead Generation & Tracking
 * Plugin URI: https://vibra.marketing/
 * Description: A powerful plugin for lead generation and tracking through WhatsApp and contact forms.
 * Version: 1.0.0
 * Author: Vibra Digital (Diego Lerma)
 * Author URI: https://diegolerma.info
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: vibra-marketing-lead-generation
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('VIBRA_MARKETING_VERSION', '1.0.0');
define('VIBRA_MARKETING_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('VIBRA_MARKETING_PLUGIN_URL', plugin_dir_url(__FILE__));


/**
 * The code that runs during plugin activation.
 */
function activate_vibra_marketing() {
    require_once VIBRA_MARKETING_PLUGIN_DIR . 'includes/class-vibra-activator.php';
    Vibra_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_vibra_marketing() {
    require_once VIBRA_MARKETING_PLUGIN_DIR . 'includes/class-vibra-deactivator.php';
    Vibra_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_vibra_marketing');
register_deactivation_hook(__FILE__, 'deactivate_vibra_marketing');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require VIBRA_MARKETING_PLUGIN_DIR . 'includes/class-vibra-marketing.php';

function vibra_marketing_load_textdomain() {
    load_plugin_textdomain('vibra-marketing-lead-generation', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

add_action('plugins_loaded', 'vibra_marketing_load_textdomain');

/**
 * Begins execution of the plugin.
 */
function run_vibra_marketing() {
    $plugin = new Vibra_Marketing();
    $plugin->run();
}

run_vibra_marketing();