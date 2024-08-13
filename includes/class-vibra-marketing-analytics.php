<?php

class Vibra_Marketing_Analytics {
    private $plugin_name;

    public function __construct($plugin_name) {
        $this->plugin_name = $plugin_name;
    }

    public function track_whatsapp_click() {
        $clicks = get_option($this->plugin_name . '_whatsapp_clicks', 0);
        update_option($this->plugin_name . '_whatsapp_clicks', $clicks + 1);
    }

    public function track_form_submission() {
        $submissions = get_option($this->plugin_name . '_form_submissions', 0);
        update_option($this->plugin_name . '_form_submissions', $submissions + 1);
    }

    public function get_analytics_data() {
        return array(
            'whatsapp_clicks' => get_option($this->plugin_name . '_whatsapp_clicks', 0),
            'form_submissions' => get_option($this->plugin_name . '_form_submissions', 0),
        );
    }

    public function track_installation(){
        return 0;
    }

    public function reset_analytics() {
        delete_option($this->plugin_name . '_whatsapp_clicks');
        delete_option($this->plugin_name . '_form_submissions');
    }
}