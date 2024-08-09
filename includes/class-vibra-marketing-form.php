<?php

class Vibra_Marketing_Form {

    private $plugin_name;

    public function __construct($plugin_name) {
        $this->plugin_name = $plugin_name;
    }

    public function register_shortcode() {
        add_shortcode('vibra_contact_form', array($this, 'render_contact_form'));
    }

    public function render_contact_form() {
        ob_start();
        ?>
        <form id="vibra-contact-form" class="vibra-form" method="post">
            <div class="form-group">
                <label for="name"><?php _e('Name', 'vibra-marketing-lead-generation'); ?></label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email"><?php _e('Email', 'vibra-marketing-lead-generation'); ?></label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="message"><?php _e('Message', 'vibra-marketing-lead-generation'); ?></label>
                <textarea name="message" id="message" required></textarea>
            </div>
            <?php wp_nonce_field('vibra_contact_form', 'vibra_contact_form_nonce'); ?>
            <button type="submit"><?php _e('Submit', 'vibra-marketing-lead-generation'); ?></button>
        </form>
        <?php
        return ob_get_clean();
    }

    public function handle_form_submission() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vibra_contact_form_nonce'])) {
            if (!wp_verify_nonce($_POST['vibra_contact_form_nonce'], 'vibra_contact_form')) {
                wp_die('Invalid nonce specified', 'Error', array(
                    'response' => 403,
                    'back_link' => true,
                ));
            }

            $name = sanitize_text_field($_POST['name']);
            $email = sanitize_email($_POST['email']);
            $message = sanitize_textarea_field($_POST['message']);

            // Save to database (we'll implement this next)
            $this->save_submission($name, $email, $message);

            // Send email
            $this->send_email($name, $email, $message);

            // Redirect to thank you page or show success message
            wp_redirect(add_query_arg('vibra_form_submitted', 'true', wp_get_referer()));
            exit;
        }
    }

    private function save_submission($name, $email, $message) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'vibra_marketing_submissions';

        $wpdb->insert(
            $table_name,
            array(
                'name' => $name,
                'email' => $email,
                'message' => $message,
                'created_at' => current_time('mysql'),
            ),
            array('%s', '%s', '%s', '%s')
        );
    }

    private function send_email($name, $email, $message) {
        $options = get_option($this->plugin_name);
        $to = $options['form_recipient_email'] ?? get_option('admin_email');
        $subject = sprintf(__('New contact form submission from %s', 'vibra-marketing-lead-generation'), $name);
        $body = sprintf(__("Name: %s\nEmail: %s\nMessage: %s", 'vibra-marketing-lead-generation'), $name, $email, $message);
        
        wp_mail($to, $subject, $body);
    }
}