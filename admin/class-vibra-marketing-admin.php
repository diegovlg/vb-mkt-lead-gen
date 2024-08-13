<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://vibramarketing.com
 * @since      1.0.0
 *
 * @package    Vibra_Marketing
 * @subpackage Vibra_Marketing/admin
 */

class Vibra_Marketing_Admin {

    private $plugin_name;
    private $version;

    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vibra-marketing-admin.css', array(), $this->version, 'all' );
    }

    public function enqueue_scripts() {
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vibra-marketing-admin.js', array( 'jquery' ), $this->version, false );
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            'Vibra Marketing Settings', 
            'Vibra Marketing', 
            'manage_options', 
            $this->plugin_name, 
            array($this, 'display_plugin_setup_page'),
            'dashicons-megaphone',
            81
        );
        add_submenu_page(
            $this->plugin_name,
            'Form Submissions',
            'Submissions',
            'manage_options',
            $this->plugin_name . '-submissions',
            array($this, 'display_submissions_page')
        );
        add_submenu_page(
            $this->plugin_name,
            'Analytics',
            'Analytics',
            'manage_options',
            $this->plugin_name . '-analytics',
            array($this, 'display_analytics_page')
        );
        add_submenu_page(
            $this->plugin_name,
            'Newsletter Subscription',
            'Newsletter',
            'manage_options',
            $this->plugin_name . '-newsletter',
            array($this, 'display_newsletter_page')
        );
        add_submenu_page(
            $this->plugin_name,
            'Mailchimp Settings',
            'Mailchimp Settings',
            'manage_options',
            $this->plugin_name . '-mailchimp',
            array($this, 'display_mailchimp_settings_page')
        );
    }

    public function display_plugin_setup_page() {
        include_once( 'partials/vibra-marketing-admin-display.php' );
    }
    public function display_analytics_page() {
        include_once 'partials/vibra-marketing-admin-analytics-display.php';
    }
    public function options_update() {
        register_setting(
            $this->plugin_name, 
            $this->plugin_name, 
            array(
                'sanitize_callback' => array($this, 'validate'),
                'default' => array()
            )
        );

        // Agregar acción para mostrar el mensaje de éxito
        add_action('admin_notices', array($this, 'settings_update_notice'));
    }

    public function validate($input) {
        $valid = array();

        $valid['whatsapp_country'] = sanitize_text_field($input['whatsapp_country']);
        //$valid['whatsapp_number'] = sanitize_text_field($input['whatsapp_number']);
        $valid['whatsapp_number'] = preg_replace('/[^0-9]/', '', $input['whatsapp_number']);
        $valid['whatsapp_message'] = sanitize_textarea_field($input['whatsapp_message']);
        $valid['whatsapp_button_color'] = sanitize_hex_color($input['whatsapp_button_color']);
        $valid['whatsapp_button_text'] = sanitize_text_field($input['whatsapp_button_text']);
        $valid['form_recipient_email'] = sanitize_email($input['form_recipient_email']);

         // Establecer una opción transitoria para indicar que las opciones se han actualizado
        set_transient('vibra_marketing_settings_updated', true, 5);

        return $valid;
    }

    public function add_action_links( $links ) {
        $settings_link = array(
            '<a href="' . admin_url( 'admin.php?page=' . $this->plugin_name ) . '">' . __('Settings', 'vibra-marketing-lead-generation') . '</a>',
        );
        return array_merge( $settings_link, $links );
    }

    public function settings_update_notice() {
        if (get_transient('vibra_marketing_settings_updated')) {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php _e('¡Configuración guardada con éxito!', 'vibra-marketing-lead-generation'); ?></p>
            </div>
            <?php
            delete_transient('vibra_marketing_settings_updated');
        }
    }

    public function display_submissions_page() {
        include_once 'partials/vibra-marketing-admin-submissions-display.php';
    }

    public function display_newsletter_page() {
        include_once 'partials/vibra-marketing-admin-newsletter-display.php';
    }
/*
    public function handle_admin_subscription() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vibra_admin_subscribe_nonce'])) {
            if (!wp_verify_nonce($_POST['vibra_admin_subscribe_nonce'], 'vibra_admin_subscribe')) {
                wp_die('Security check failed', 'Error', array(
                    'response' => 403,
                    'back_link' => true,
                ));
            }

            $admin_email = sanitize_email($_POST['admin_email']);
            
            if (!is_email($admin_email)) {
                add_settings_error(
                    'vibra_admin_subscription',
                    'invalid_email',
                    'Please enter a valid email address.',
                    'error'
                );
            } else {
                // Here you would typically send this email to your newsletter service
                // For now, we'll just save it in an option
                $subscribed_admins = get_option('vibra_subscribed_admins', array());
                if (!in_array($admin_email, $subscribed_admins)) {
                    $subscribed_admins[] = $admin_email;
                    update_option('vibra_subscribed_admins', $subscribed_admins);
                    add_settings_error(
                        'vibra_admin_subscription',
                        'subscription_success',
                        'You have successfully subscribed to the Vibra Marketing newsletter!',
                        'success'
                    );
                } else {
                    add_settings_error(
                        'vibra_admin_subscription',
                        'already_subscribed',
                        'This email is already subscribed to the newsletter.',
                        'info'
                    );
                }
            }
        }
    }
*/
    public function handle_admin_subscription() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vibra_admin_subscribe_nonce'])) {
            if (!wp_verify_nonce($_POST['vibra_admin_subscribe_nonce'], 'vibra_admin_subscribe')) {
                wp_die('Security check failed', 'Error', array(
                    'response' => 403,
                    'back_link' => true,
                ));
            }

            $admin_email = sanitize_email($_POST['admin_email']);
            
            if (!is_email($admin_email)) {
                add_settings_error(
                    'vibra_admin_subscription',
                    'invalid_email',
                    'Please enter a valid email address.',
                    'error'
                );
            } else {
                $mailchimp_settings = get_option($this->plugin_name . '_mailchimp_settings');
                $mailchimp = new Vibra_Marketing_Mailchimp($mailchimp_settings['api_key'], $mailchimp_settings['list_id']);
                
                if ($mailchimp->subscribe($admin_email)) {
                    add_settings_error(
                        'vibra_admin_subscription',
                        'subscription_success',
                        'You have successfully subscribed to the Vibra Marketing newsletter!',
                        'success'
                    );
                } else {
                    add_settings_error(
                        'vibra_admin_subscription',
                        'subscription_failed',
                        'Subscription failed. Please try again later or contact support.',
                        'error'
                    );
                }
            }
        }
    }
    
    public function display_mailchimp_settings_page() {
        include_once 'partials/vibra-marketing-admin-mailchimp-settings.php';
    }

    public function register_mailchimp_settings() {
        register_setting($this->plugin_name . '_mailchimp', $this->plugin_name . '_mailchimp_settings', array($this, 'validate_mailchimp_settings'));
        
        add_settings_section(
            $this->plugin_name . '_mailchimp_section',
            'Mailchimp Settings',
            array($this, 'mailchimp_section_callback'),
            $this->plugin_name . '-mailchimp'
        );

        add_settings_field(
            'mailchimp_api_key',
            'Mailchimp API Key',
            array($this, 'mailchimp_api_key_callback'),
            $this->plugin_name . '-mailchimp',
            $this->plugin_name . '_mailchimp_section'
        );

        add_settings_field(
            'mailchimp_list_id',
            'Mailchimp List ID',
            array($this, 'mailchimp_list_id_callback'),
            $this->plugin_name . '-mailchimp',
            $this->plugin_name . '_mailchimp_section'
        );
    }

    public function validate_mailchimp_settings($input) {
        $valid = array();
        $valid['api_key'] = sanitize_text_field($input['api_key']);
        $valid['list_id'] = sanitize_text_field($input['list_id']);
        return $valid;
    }

    public function mailchimp_section_callback() {
        echo '<p>Enter your Mailchimp API key and List ID to enable newsletter subscriptions.</p>';
    }

    public function mailchimp_api_key_callback() {
        $options = get_option($this->plugin_name . '_mailchimp_settings');
        echo '<input type="text" id="mailchimp_api_key" name="' . $this->plugin_name . '_mailchimp_settings[api_key]" value="' . esc_attr($options['api_key'] ?? '') . '" class="regular-text">';
    }

    public function mailchimp_list_id_callback() {
        $options = get_option($this->plugin_name . '_mailchimp_settings');
        echo '<input type="text" id="mailchimp_list_id" name="' . $this->plugin_name . '_mailchimp_settings[list_id]" value="' . esc_attr($options['list_id'] ?? '') . '" class="regular-text">';
    }

    public function get_country_codes() {
        return array(
            '51' => 'PE - Perú',
            '1' => 'US - Estados Unidos',
            '1' => 'CA - Canadá',
            '52' => 'MX - México',
            '55' => 'BR - Brasil',
            '54' => 'AR - Argentina',
            '57' => 'CO - Colombia',
            '56' => 'CL - Chile',
            '58' => 'VE - Venezuela',
            '593' => 'EC - Ecuador',
            '53' => 'CU - Cuba',
            '591' => 'BO - Bolivia',
            '506' => 'CR - Costa Rica',
            '507' => 'PA - Panamá',
            '598' => 'UY - Uruguay',
            '34' => 'ES - España',
            '49' => 'DE - Alemania',
            '33' => 'FR - Francia',
            '39' => 'IT - Italia',
            '44' => 'GB - Reino Unido',
            '7' => 'RU - Rusia',
            '380' => 'UA - Ucrania',
            '48' => 'PL - Polonia',
            '40' => 'RO - Rumania',
            '31' => 'NL - Países Bajos',
            '32' => 'BE - Bélgica',
            '30' => 'GR - Grecia',
            '351' => 'PT - Portugal',
            '46' => 'SE - Suecia',
            '47' => 'NO - Noruega',
            '86' => 'CN - China',
            '91' => 'IN - India',
            '81' => 'JP - Japón',
            '82' => 'KR - Corea del Sur',
            '62' => 'ID - Indonesia',
            '90' => 'TR - Turquía',
            '63' => 'PH - Filipinas',
            '66' => 'TH - Tailandia',
            '84' => 'VN - Vietnam',
            '972' => 'IL - Israel',
            '60' => 'MY - Malasia',
            '65' => 'SG - Singapur',
            '92' => 'PK - Pakistán',
            '880' => 'BD - Bangladés',
            '966' => 'SA - Arabia Saudita',
            '20' => 'EG - Egipto',
            '27' => 'ZA - Sudáfrica',
            '234' => 'NG - Nigeria',
            '254' => 'KE - Kenia',
            '212' => 'MA - Marruecos',
            '213' => 'DZ - Argelia',
            '256' => 'UG - Uganda',
            '233' => 'GH - Ghana',
            '237' => 'CM - Camerún',
            '225' => 'CI - Costa de Marfil',
            '221' => 'SN - Senegal',
            '255' => 'TZ - Tanzania',
            '249' => 'SD - Sudán',
            '218' => 'LY - Libia',
            '216' => 'TN - Túnez',
            '61' => 'AU - Australia',
            '64' => 'NZ - Nueva Zelanda',
            '679' => 'FJ - Fiji',
            '675' => 'PG - Papúa Nueva Guinea',
            '676' => 'TO - Tonga',
            '98' => 'IR - Irán',
            '964' => 'IQ - Iraq',
            '962' => 'JO - Jordania',
            '961' => 'LB - Líbano',
            '965' => 'KW - Kuwait',
            '971' => 'AE - Emiratos Árabes Unidos',
            '968' => 'OM - Omán',
            '974' => 'QA - Catar',
            '973' => 'BH - Bahrein',
            '967' => 'YE - Yemen'
        );
    }
}