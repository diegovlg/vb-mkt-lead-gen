<?php

class Vibra_Marketing_Subscription {
    private $plugin_name;

    public function __construct($plugin_name) {
        $this->plugin_name = $plugin_name;
    }

    public function register_shortcode() {
        add_shortcode('vibra_subscription_form', array($this, 'render_subscription_form'));
    }

    public function render_subscription_form() {
        ob_start();
        ?>
        <form id="vibra-subscription-form" class="vibra-form" method="post">
            <div class="form-group">
                <label for="email"><?php _e('Email', 'vibra-marketing-lead-generation'); ?></label>
                <input type="email" name="email" id="email" required>
            </div>
            <?php wp_nonce_field('vibra_subscription_form', 'vibra_subscription_form_nonce'); ?>
            <button type="submit"><?php _e('Subscribe', 'vibra-marketing-lead-generation'); ?></button>
        </form>
        <?php
        return ob_get_clean();
    }

    public function handle_subscription() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vibra_subscription_form_nonce'])) {
            if (!wp_verify_nonce($_POST['vibra_subscription_form_nonce'], 'vibra_subscription_form')) {
                wp_die('Invalid nonce specified', 'Error', array(
                    'response' => 403,
                    'back_link' => true,
                ));
            }

            $email = sanitize_email($_POST['email']);

            if (!is_email($email)) {
                wp_die('Invalid email address', 'Error', array(
                    'response' => 400,
                    'back_link' => true,
                ));
            }

            $this->save_subscription($email);

            wp_redirect(add_query_arg('vibra_subscribed', 'true', wp_get_referer()));
            exit;
        }
    }

    private function save_subscription($email) {
        $subscriptions = get_option($this->plugin_name . '_subscriptions', array());
        if (!in_array($email, $subscriptions)) {
            $subscriptions[] = $email;
            update_option($this->plugin_name . '_subscriptions', $subscriptions);
        }
    }
}