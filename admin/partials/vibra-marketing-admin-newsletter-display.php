<?php
$current_user = wp_get_current_user();
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <?php settings_errors('vibra_admin_subscription'); ?>

    <div class="vibra-newsletter-box">
        <h2><?php _e('Subscribe to Vibra Marketing Newsletter', 'vibra-marketing-lead-generation'); ?></h2>
        <p><?php _e('Get the latest news, updates, and KPI improvement recommendations for your Vibra Marketing plugin!', 'vibra-marketing-lead-generation'); ?></p>
        
        <form method="post" action="">
            <?php wp_nonce_field('vibra_admin_subscribe', 'vibra_admin_subscribe_nonce'); ?>
            <div class="form-group">
                <label for="admin_email"><?php _e('Your Email:', 'vibra-marketing-lead-generation'); ?></label>
                <input type="email" id="admin_email" name="admin_email" value="<?php echo esc_attr($current_user->user_email); ?>" required>
            </div>
            <p class="description"><?php _e('We respect your privacy. Your email will only be used to send plugin-related updates and recommendations.', 'vibra-marketing-lead-generation'); ?></p>
            <input type="submit" class="button button-primary" value="<?php _e('Subscribe', 'vibra-marketing-lead-generation'); ?>">
        </form>
    </div>
</div>