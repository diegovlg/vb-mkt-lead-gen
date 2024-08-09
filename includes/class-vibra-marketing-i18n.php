<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://vibramarketing.com
 * @since      1.0.0
 *
 * @package    Vibra_Marketing
 * @subpackage Vibra_Marketing/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Vibra_Marketing
 * @subpackage Vibra_Marketing/includes
 * @author     Vibra Marketing Team
 */
class Vibra_Marketing_i18n {

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            'vibra-marketing-lead-generation',
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );

    }

}