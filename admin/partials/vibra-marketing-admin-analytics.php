<?php
$analytics = new Vibra_Marketing_Analytics($this->plugin_name);
$data = $analytics->get_analytics_data();

// Handle reset action
if (isset($_POST['reset_analytics']) && check_admin_referer('vibra_reset_analytics')) {
    $analytics->reset_analytics();
    $data = $analytics->get_analytics_data(); // Refresh data after reset
    echo '<div class="notice notice-success"><p>' . __('Analytics have been reset.', 'vibra-marketing-lead-generation') . '</p></div>';
}
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <div class="analytics-dashboard">
        <div class="analytics-card">
            <h2><?php _e('WhatsApp Clicks', 'vibra-marketing-lead-generation'); ?></h2>
            <p class="analytics-number"><?php echo esc_html($data['whatsapp_clicks']); ?></p>
        </div>
        <div class="analytics-card">
            <h2><?php _e('Form Submissions', 'vibra-marketing-lead-generation'); ?></h2>
            <p class="analytics-number"><?php echo esc_html($data['form_submissions']); ?></p>
        </div>
    </div>
    
    <form method="post">
        <?php wp_nonce_field('vibra_reset_analytics'); ?>
        <input type="submit" name="reset_analytics" class="button button-secondary" value="<?php _e('Reset Analytics', 'vibra-marketing-lead-generation'); ?>">
    </form>
</div>