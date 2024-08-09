<?php
global $wpdb;
$table_name = $wpdb->prefix . 'vibra_marketing_submissions';
$submissions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($submissions as $submission): ?>
                <tr>
                    <td><?php echo esc_html($submission->id); ?></td>
                    <td><?php echo esc_html($submission->name); ?></td>
                    <td><?php echo esc_html($submission->email); ?></td>
                    <td><?php echo esc_html($submission->message); ?></td>
                    <td><?php echo esc_html($submission->created_at); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>