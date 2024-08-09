<?php

class Vibra_Marketing_Public {

    private $plugin_name;
    private $version;

    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vibra-marketing-public.css', array(), $this->version, 'all' );
    }

    public function enqueue_scripts() {
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vibra-marketing-public.js', array( 'jquery' ), $this->version, false );
    }

    public function display_whatsapp_button() {
        $options = get_option($this->plugin_name);
        $whatsapp_country = $options['whatsapp_country'] ?? '';
        $whatsapp_number = $options['whatsapp_number'] ?? '';
        $whatsapp_message = $options['whatsapp_message'] ?? '';
        $button_color = $options['whatsapp_button_color'] ?? '#25D366';
        $button_text = $options['whatsapp_button_text'] ?? 'Chat on WhatsApp';

        if (empty($whatsapp_number)) {
            return;
        }

        $full_number = $whatsapp_country . $whatsapp_number;
        $whatsapp_url = 'https://api.whatsapp.com/send?phone=' . $full_number . '&text=' . urlencode($whatsapp_message);

        $button_html = '<a href="' . esc_url($whatsapp_url) . '" class="vibra-whatsapp-button" target="_blank" rel="noopener noreferrer" style="background-color: ' . esc_attr($button_color) . ';">';
        $button_html .= '<svg viewBox="0 0 24 24" width="24" height="24"><path fill="#ffffff" d="M12 2C6.49 2 2 6.49 2 12C2 14.53 2.86 16.84 4.28 18.65L2.92 21.66L5.93 20.3C7.54 21.39 9.68 22 12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2ZM12 20C10.07 20 8.24 19.39 6.7 18.27L6.48 18.13L4.64 18.92L5.43 17.08L5.29 16.86C4.17 15.32 3.56 13.49 3.56 11.56C3.56 7.38 7.38 3.56 11.56 3.56C15.74 3.56 19.56 7.38 19.56 11.56C19.56 15.74 15.74 19.56 11.56 19.56V20H12ZM16.81 14.3C16.65 14.22 15.32 13.56 15.18 13.5C15.04 13.44 14.93 13.42 14.83 13.58C14.73 13.74 14.21 14.36 14.13 14.46C14.05 14.56 13.96 14.58 13.81 14.5C13.66 14.42 12.78 14.13 11.73 13.19C10.91 12.45 10.37 11.54 10.29 11.38C10.21 11.22 10.29 11.14 10.36 11.07C10.43 11 10.51 10.89 10.59 10.8C10.67 10.71 10.69 10.64 10.75 10.54C10.81 10.44 10.79 10.35 10.75 10.28C10.71 10.21 10.17 8.87 10.03 8.55C9.89 8.24 9.75 8.28 9.66 8.27C9.57 8.26 9.46 8.26 9.36 8.26C9.26 8.26 9.1 8.3 8.96 8.46C8.82 8.62 8.11 9.28 8.11 10.62C8.11 11.96 9.13 13.25 9.26 13.35C9.39 13.45 10.37 14.94 11.84 15.54C13.31 16.14 13.31 15.92 13.71 15.88C14.11 15.84 15.23 15.23 15.37 14.84C15.51 14.46 15.51 14.14 15.47 14.08C15.43 14.02 15.33 13.98 15.17 13.9L16.81 14.3Z"/></svg>';
        $button_html .= '<span>' . esc_html($button_text) . '</span>';
        $button_html .= '</a>';

        echo $button_html;
    }

    public function add_whatsapp_button_to_footer() {
        $this->display_whatsapp_button();
    }

    public function add_form_to_page($content) {
        $options = get_option($this->plugin_name);
        $form_page = $options['form_page'] ?? '';

        if ($form_page && is_page($form_page)) {
            $form = new Vibra_Marketing_Form($this->plugin_name);
            $content .= $form->render_contact_form();
        }

        return $content;
    }
}