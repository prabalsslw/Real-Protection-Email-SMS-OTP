<?php
#-------------------
# Woocommerce alert history
#-------------------


global $wpdb;
$table_name = $wpdb->prefix . "rpso_realpro_woosms";
$record = $wpdb->get_results(
    "
    SELECT *
    FROM $table_name
    ORDER BY id DESC
    "
);

?>

<form id="logins-filter" action="" method="get">
    <table class="wp-list-table widefat fixed pages">
        <thead>
            <tr>
                <th scope="col" class="manage-column column-text" style=""><span>User Name</span></th>
                <th scope="col" class="manage-column column-date" style="">Delivery Time</th>
                <th scope="col" class="manage-column column-date" style=""><span>IP Address</span></th>
                <th scope="col" class="manage-column column-text" style=""><span>SMS Type</span></th>
                <th scope="col" class="manage-column column-text" style=""><span>Phone Number</span></th>
                <th scope="col" class="manage-column column-text" style=""><span>SMS API Response</span></th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th scope="col" class="manage-column column-text" style=""><span>User Name</span></th>
                <th scope="col" class="manage-column column-date" style="">Delivery Time</th>
                <th scope="col" class="manage-column column-date" style=""><span>IP Address</span></th>
                <th scope="col" class="manage-column column-text" style=""><span>SMS Type</span></th>
                <th scope="col" class="manage-column column-text" style=""><span>Phone Number</span></th>
                <th scope="col" class="manage-column column-text" style=""><span>SMS API Response</span></th>
            </tr>
        </tfoot>

        <tbody id="the-list">
            <?php
            foreach ( $record as $value ) {
                $user_info = get_userdata( $value->user_id );
            ?>
            <tr class="alternate">
                <td><strong><?php echo $user_info->user_login; ?></strong> (<?php echo $user_info->user_email; ?>)</td>
                <td><?php echo $value->sending_time; ?></td>
                <td><?php echo $value->user_ip; ?></td>
                <td><?php echo $value->sms_type; ?></td>
                <td><?php echo $value->phone_no; ?></td>
                <td><?php print_r(unserialize($value->sms_ref_id)); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</form>