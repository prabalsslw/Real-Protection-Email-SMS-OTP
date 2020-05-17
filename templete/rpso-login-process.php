<?php 

# Validate login with OTP

class RPSO_Login_Process
{

    public function __construct()
    {
        add_filter( 'authenticate', array($this, 'rpso_auth_login') , 30, 3 );
        add_action( 'login_head', array($this, 'rpso_modify_html') );
    }

    # Validate login with OTP

    function rpso_auth_login ( $user, $username, $password ) 
    {
        if ( is_wp_error( $user ) ) 
        {
            return $user;
        } 
        else 
        {
            global $wpdb;
            $table_name = $wpdb->prefix . "rpso_realpro_otpsms";

            $rpso_settings = get_option( 'rpso_realpro_setting' );

            if ( !isset( $rpso_settings['timeout'] ) || '' == $rpso_settings['timeout'] ) {
                $rpso_settings['timeout'] = 3;
            }

            $user_id = sanitize_key( $user->ID );

            $login_attempt = $wpdb->get_row( $wpdb->prepare(
                "
                    SELECT *
                    FROM $table_name
                    WHERE user_id = %d AND login_status = 0
                ",
                $user_id
            ) );

            if ( NULL === $login_attempt ) 
            {
                $user_hash = md5( $user->ID . time() );
                $user_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
                $wpdb->insert(
                    $table_name,
                    array(
                        'user_id' => $user_id,
                        'user_obj' => serialize($user),
                        'auth_token' => $user_hash,
                        'login_time' => current_time( 'mysql' ),
                        'user_ip' => $user_ip,
                    )
                );

                wp_redirect( home_url() . "/verify-login/" . $user_hash . "/");
            } 
            elseif ( ( current_time( 'timestamp' ) - strtotime( $login_attempt->login_time ) ) > $rpso_settings['timeout'] * MINUTE_IN_SECONDS ) 
            {
                $wpdb->update(
                    $table_name,
                    array(
                        'login_status' => 3
                    ),
                    array( 'auth_token' => $login_attempt->auth_token ),
                    array(
                        '%d'
                    ),
                    array( '%s' )
                );

                $user_hash = md5( $user->ID . time() );
                $user_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
                $wpdb->insert(
                    $table_name,
                    array(
                        'user_id' => $user_id,
                        'user_obj' => serialize($user),
                        'auth_token' => $user_hash,
                        'login_time' => current_time( 'mysql' ),
                        'user_ip' => $user_ip,
                    )
                );

                wp_redirect( home_url() . "/verify-login/" . $user_hash . "/");
            } 
            else 
            {
                wp_redirect( home_url() . "/verify-login/" . $login_attempt->auth_token . "/");
            }

            exit;
        }
    }


    # Display error message on login page
    public function rpso_modify_html() {
        $rpso_error = isset($_GET['rpso_error']) ? esc_html__($_GET['rpso_error']) : '';
        // if (rpso_error_code_sanitize($_GET['rpso_error'])) {
        //     $rpso_error = esc_html__($_GET['rpso_error']);
        // }
        // else
        // {
        //     $rpso_error = '';
        // }

        if ( $rpso_error != '' ) {
            $login_error = get_query_var( 'rpso_error' );
            switch ( $rpso_error ) {
                case 401:
                    $message = '<strong>ERROR</strong>: Session timed out!';
                    break;
                case 402:
                    $message = '<strong>ERROR</strong>: IP does not match!';
                    break;
                case 601:
                    $message = '<strong>ERROR</strong>: You have exceeded OTP limit!';
                    break;
                default:
                    $message = '<strong>ERROR</strong>: Session timed out!';
            }
            add_filter( 'login_message', create_function( '', "return '<div id=\"login_error\">$message</div>';" ) );
        }
    }
    
}

new RPSO_Login_Process;
?>