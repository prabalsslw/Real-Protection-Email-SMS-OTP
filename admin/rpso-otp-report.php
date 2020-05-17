<?php
#-------------
# Login attempt & OTP sending history.
#-------------


global $wpdb;
$table_name = $wpdb->prefix . "rpso_realpro_otpsms";
$logins = $wpdb->get_results(
    "
    SELECT *
    FROM $table_name
    ORDER BY id DESC
    "
);

?>

<table class="wp-list-table widefat fixed pages">
    <thead>
        <tr>
            <th scope="col" class="manage-column column-text" style=""><span>User</span></th>
            <th scope="col" class="manage-column column-date" style="">Login Time</th>
            <th scope="col" class="manage-column column-date" style=""><span>IP Address</span></th>
            <th scope="col" class="manage-column column-text" style=""><span>Login Status</span></th>
            <th scope="col" class="manage-column column-text" style=""><span>OTP Resent</span></th>
            <th scope="col" class="manage-column column-text" style=""><span>SMS API Response</span></th>
        </tr>
    </thead>

    <tfoot>
        <tr>
            <th scope="col" class="manage-column column-text" style=""><span>User</span></th>
            <th scope="col" class="manage-column column-date" style="">Login Time</th>
            <th scope="col" class="manage-column column-text" style=""><span>IP Address</span></th>
            <th scope="col" class="manage-column column-text" style=""><span>Login Status</span></th>
            <th scope="col" class="manage-column column-text" style=""><span>OTP Resent</span></th>
            <th scope="col" class="manage-column column-text" style=""><span>SMS API Response</span></th>
        </tr>
    </tfoot>

    <tbody id="the-list">
        <?php
        foreach ( $logins as $login ) {
            $user_info = get_userdata( $login->user_id );
            switch ($login->login_status) {
                case 0:
                    $login_status = "<span class='rp-status-default'>Not logged in</span>";
                    break;
                case 1:
                    $login_status = "<span class='rp-status-success'>Logged in</span>";
                    break;
                case 2:
                    $login_status = "<span class='rp-status-failed'>OTP Failed</span>";
                    break;
                case 3:
                    $login_status = "<span class='rp-status-warning'>Timed out</span>";
                    break;
                case 4:
                    $login_status = "<span class='rp-status-failed'>IP match failed</span>";
                    break;
            }
        ?>
        <tr class="alternate">
            <td><strong><?php echo $user_info->user_login; ?></strong> (<?php echo $user_info->user_email; ?>)</td>
            <td><?php echo $login->login_time; ?></td>
            <td><?php echo $login->user_ip; ?></td>
            <td><?php echo $login_status; ?></td>
            <td><?php echo $login->otp_sent_limit; ?></td>
            <td><?php print_r(unserialize($login->sms_ref_id)); ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>