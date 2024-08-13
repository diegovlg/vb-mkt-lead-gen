<?php

class Vibra_Marketing_Mailchimp {
    private $api_key;
    private $list_id;

    public function __construct($api_key, $list_id) {
        $this->api_key = $api_key;
        $this->list_id = $list_id;
    }

    public function subscribe($email) {
        $api_endpoint = 'https://' . substr($this->api_key, strpos($this->api_key, '-') + 1) . '.api.mailchimp.com/3.0/lists/' . $this->list_id . '/members/';

        $data = json_encode([
            'email_address' => $email,
            'status'        => 'subscribed',
        ]);

        $response = wp_remote_post($api_endpoint, [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode('user:' . $this->api_key),
                'Content-Type'  => 'application/json',
            ],
            'body' => $data,
        ]);

        if (is_wp_error($response)) {
            return false;
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);

        return isset($body['id']);
    }
}