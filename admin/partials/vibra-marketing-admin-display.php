<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://vibramarketing.com
 * @since      1.0.0
 *
 * @package    Vibra_Marketing
 * @subpackage Vibra_Marketing/admin/partials
 */
?>

<div class="wrap">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    
    <?php settings_errors(); // Esto mostrará los mensajes de error o éxito ?>

    <form method="post" name="vibra_marketing_options" action="options.php">
    <?php
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
        $options = get_option($this->plugin_name);
    ?>

    <h3><?php esc_html_e('WhatsApp Button Settings', 'vibra-marketing-lead-generation'); ?></h3>
    <table class="form-table" role="presentation">
        <tr>
            <th scope="row">
                <label for="<?php echo $this->plugin_name; ?>-form_page">
                    <?php esc_html_e('Add form to page', 'vibra-marketing-lead-generation'); ?>
                </label>
            </th>
            <td>
                <?php
                $pages = get_pages();
                $selected_page = $options['form_page'] ?? '';
                ?>
                <select name="<?php echo $this->plugin_name; ?>[form_page]" id="<?php echo $this->plugin_name; ?>-form_page">
                    <option value=""><?php esc_html_e('Select a page', 'vibra-marketing-lead-generation'); ?></option>
                    <?php foreach ($pages as $page): ?>
                        <option value="<?php echo $page->ID; ?>" <?php selected($selected_page, $page->ID); ?>>
                            <?php echo esc_html($page->post_title); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="description"><?php esc_html_e('Select a page to automatically add the contact form to.', 'vibra-marketing-lead-generation'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="<?php echo $this->plugin_name; ?>-whatsapp_country">
                    <?php esc_html_e('Country', 'vibra-marketing-lead-generation'); ?>
                </label>
            </th>
            <td>
                <select name="<?php echo $this->plugin_name; ?>[whatsapp_country]" id="<?php echo $this->plugin_name; ?>-whatsapp_country">
                    <?php
                    $countries = $this->get_country_codes();
                    $selected_country = $options['whatsapp_country'] ?? '';
                    foreach ($countries as $code => $name) {
                        echo '<option value="' . esc_attr($code) . '" ' . selected($selected_country, $code, false) . '>' . esc_html($name) . ' (+' . esc_html($code) . ')</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="<?php echo $this->plugin_name; ?>-whatsapp_number">
                    <?php esc_html_e('WhatsApp Number', 'vibra-marketing-lead-generation'); ?>
                </label>
            </th>
            <td>
                <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-whatsapp_number" 
                    name="<?php echo $this->plugin_name; ?>[whatsapp_number]"
                    value="<?php echo $options['whatsapp_number'] ?? ''; ?>" />
                <p class="description"><?php esc_html_e('Enter your WhatsApp number without the country code', 'vibra-marketing-lead-generation'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="<?php echo $this->plugin_name; ?>-whatsapp_message">
                    <?php esc_html_e('Default Message', 'vibra-marketing-lead-generation'); ?>
                </label>
            </th>
            <td>
                <textarea class="large-text" id="<?php echo $this->plugin_name; ?>-whatsapp_message" 
                    name="<?php echo $this->plugin_name; ?>[whatsapp_message]"><?php echo $options['whatsapp_message'] ?? ''; ?></textarea>
                <p class="description"><?php esc_html_e('Enter the default message for WhatsApp chat', 'vibra-marketing-lead-generation'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="<?php echo $this->plugin_name; ?>-whatsapp_button_color">
                    <?php esc_html_e('Button Color', 'vibra-marketing-lead-generation'); ?>
                </label>
            </th>
            <td>
                <input type="color" id="<?php echo $this->plugin_name; ?>-whatsapp_button_color" 
                    name="<?php echo $this->plugin_name; ?>[whatsapp_button_color]"
                    value="<?php echo $options['whatsapp_button_color'] ?? '#25D366'; ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="<?php echo $this->plugin_name; ?>-whatsapp_button_text">
                    <?php esc_html_e('Button Text', 'vibra-marketing-lead-generation'); ?>
                </label>
            </th>
            <td>
                <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-whatsapp_button_text" 
                    name="<?php echo $this->plugin_name; ?>[whatsapp_button_text]"
                    value="<?php echo $options['whatsapp_button_text'] ?? 'Chat on WhatsApp'; ?>" />
            </td>
        </tr>
    </table>

    <h3><?php esc_html_e('Form Settings', 'vibra-marketing-lead-generation'); ?></h3>
    <table class="form-table" role="presentation">
        <tr>
            <th scope="row">
                <label for="<?php echo $this->plugin_name; ?>-form_recipient_email">
                    <?php esc_html_e('Recipient Email', 'vibra-marketing-lead-generation'); ?>
                </label>
            </th>
            <td>
                <input type="email" class="regular-text" id="<?php echo $this->plugin_name; ?>-form_recipient_email" 
                    name="<?php echo $this->plugin_name; ?>[form_recipient_email]"
                    value="<?php echo $options['form_recipient_email'] ?? ''; ?>" />
                <p class="description"><?php esc_html_e('Enter the email address where form submissions should be sent', 'vibra-marketing-lead-generation'); ?></p>
            </td>
        </tr>
    </table>

    <?php submit_button('Save Settings', 'primary', 'submit', true); ?>

    </form>
</div>