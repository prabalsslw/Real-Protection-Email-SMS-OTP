<?php
	/**
	 * 
	 */
	class RPSO_Realpro_Admin
	{
		public function __construct() {
	        add_action( 'admin_menu', array( $this, 'rpso_create_menu_pages' ) );
	        add_action( 'admin_init', array( $this, 'rpso_initialize_settings' ));
	    }

		public function rpso_create_menu_pages() {

			global $plugin_slug;

		    add_menu_page(
		        __('Real Protection', $plugin_slug),
		        __('Real Protection', $plugin_slug),
		        'administrator',
		        'real-protection',
		        array( $this, 'rpso_menu_otp_display')
		    );

		    add_submenu_page(
		        'real-protection',
		        __('Real Protection Transactional SMS', $plugin_slug),
		        __('SMS Record', $plugin_slug),
		        'administrator',
		        'real-protection-woo-alert',
		        array( $this, 'rpso_woo_mnu_display')
		    );

		    add_submenu_page(
		        'real-protection',
		         __('Real Protection OTP Settings', $plugin_slug),
		         __('OTP Settings', $plugin_slug),
		        'administrator',
		        'real-protection-otp-settings',
		        array( $this, 'rpso_menu_otp_settings')
		    );
		}

		# Real Protection Page Content

		public function rpso_menu_otp_display() {
		?>
		    <div class="wrap">
		        <h2>Real Protection</h2>
		        <?php include_once( plugin_dir_path( __FILE__ ) . '/rpso-otp-report.php' ); ?>
		    </div>
		<?php
		}

		# Real Protection Woocommerce Record

		public function rpso_woo_mnu_display() {
		?>
		    <div class="wrap">
		        <h2>Real Protection Transactional SMS</h2>
		        <?php include_once( plugin_dir_path( __FILE__ ) . '/rpso-woo-alert-report.php' ); ?>
		    </div>
		<?php
		}

		# Settings Page Content

		public function rpso_menu_otp_settings() {
		?>
		    <div class="wrap">
		        <h2>Real Protection Settings</h2>

		        <?php settings_errors(); ?>

		        <form method="post" action="options.php">
		            <?php settings_fields( 'rpso_realpro_setting' ); ?>
		            <?php do_settings_sections( 'rpso_realpro_setting' ); ?>
		            <?php submit_button(); ?>
		        </form>

		    </div>

		<?php
		}


		# Initialize Settings
		public function rpso_initialize_settings() {
			global $plugin_slug;

		    if( false == get_option( 'rpso_realpro_setting' ) ) {
		        add_option( 'rpso_realpro_setting' );
		    }

		    # OTP Configuration Section

		    add_settings_section(
		        'otp_settings_section',
		        __('OTP Configuration', $plugin_slug),
		        array( $this, 'rpso_realpro_settings_callback'),
		        'rpso_realpro_setting'
		    );

		    add_settings_field(
		        'email_otp_disable',
		        __('Enable SMS OTP/Alert', $plugin_slug),
		        array( $this, 'rpso_otp_enable_callback'),
		        'rpso_realpro_setting',
		        'otp_settings_section'
		    );

		    add_settings_field(
		        'otp_enable',
		        __('Disable Email OTP', $plugin_slug),
		        array( $this, 'rpso_email_otp_disable_callback'),
		        'rpso_realpro_setting',
		        'otp_settings_section'
		    );

		    add_settings_field(
		        'timeout',
		        __('OTP Expiration Time', $plugin_slug),
		        array( $this, 'rpso_timeout_callback'),
		        'rpso_realpro_setting',
		        'otp_settings_section'
		    );

		    add_settings_field(
		        'from_email',
		        __('From Email', $plugin_slug),
		        array( $this, 'rpso_from_email_callback'),
		        'rpso_realpro_setting',
		        'otp_settings_section'
		    );

		    add_settings_field(
		        'otp_text',
		        __('OTP SMS Text', $plugin_slug),
		        array( $this, 'rpso_otp_text_callback'),
		        'rpso_realpro_setting',
		        'otp_settings_section'
		    );

		    # API Configuration Section

		    add_settings_section(
		        'api_settings_section',
		        __('API Configuration', $plugin_slug),
		        array( $this, 'rpso_api_settings_callback'),
		        'rpso_realpro_setting'
		    );

		    add_settings_field(
		        'get_post',
		        __('Request Method', $plugin_slug),
		        array( $this, 'rpso_api_get_post_callback'),
		        'rpso_realpro_setting',
		        'api_settings_section'
		    );

		    add_settings_field(
		        'api_url',
		        __('API URL', $plugin_slug),
		        array( $this, 'rpso_api_url_callback'),
		        'rpso_realpro_setting',
		        'api_settings_section'
		    );
		    
		    add_settings_field(
		        'api_peram',
		        __('API Parameter', $plugin_slug),
		        array( $this, 'rpso_api_peram_callback'),
		        'rpso_realpro_setting',
		        'api_settings_section'
		    );

		    # Woocommerce Configuration Section

		    add_settings_section(
		        'woo_settings_section', 
		        __('Woocommerce Alert Configuration', $plugin_slug),
		        array( $this, 'rpso_woo_settings_callback'),
		        'rpso_realpro_setting'
		    );

		    add_settings_field(
		        'otp_woo_alert',
		        __('Enable Woocommerce Alert', $plugin_slug),
		        array( $this, 'rpso_woo_enable_callback'),
		        'rpso_realpro_setting',
		        'woo_settings_section'
		    );

		    add_settings_field(
		        'woo_pending_alert',
		        __('Order Pending Alert', $plugin_slug),
		        array( $this, 'rpso_woo_pending_callback'),
		        'rpso_realpro_setting',
		        'woo_settings_section'
		    );

		    add_settings_field(
		        'woo_processing_alert',
		        __('Order Processing Alert', $plugin_slug),
		        array( $this, 'rpso_woo_processing_callback'),
		        'rpso_realpro_setting',
		        'woo_settings_section'
		    );

		    add_settings_field(
		        'woo_hold_alert',
		        __('Order On Hold Alert', $plugin_slug),
		        array( $this, 'rpso_woo_hold_callback'),
		        'rpso_realpro_setting',
		        'woo_settings_section'
		    );

		    add_settings_field(
		        'woo_fail_alert',
		        __('Order Failed Alert', $plugin_slug),
		        array( $this, 'rpso_woo_fail_callback'),
		        'rpso_realpro_setting',
		        'woo_settings_section'
		    );

		    add_settings_field(
		        'woo_cancel_alert',
		        __('Order Cancelled Alert', $plugin_slug),
		        array( $this, 'rpso_woo_cancel_callback'),
		        'rpso_realpro_setting',
		        'woo_settings_section'
		    );

		    add_settings_field(
		        'woo_complete_alert',
		        __('Order Completed Alert', $plugin_slug),
		        array( $this, 'rpso_woo_complete_callback'),
		        'rpso_realpro_setting',
		        'woo_settings_section'
		    );

		    add_settings_field(
		        'woo_refund_alert',
		        __('Refund Alert', $plugin_slug),
		        array( $this, 'rpso_woo_refund_callback'),
		        'rpso_realpro_setting',
		        'woo_settings_section'
		    );

		    add_settings_field(
		        'woo_partially_alert',
		        __('Partially Paid Alert', $plugin_slug),
		        array( $this, 'rpso_woo_partially_callback'),
		        'rpso_realpro_setting',
		        'woo_settings_section'
		    );

		    add_settings_field(
		        'woo_shipped_alert',
		        __('Order Shipped Alert', $plugin_slug),
		        array( $this, 'rpso_woo_shipped_callback'),
		        'rpso_realpro_setting',
		        'woo_settings_section'
		    );

		    add_settings_field(
		        'user_reg_alert',
		        __('User Registration Alert', $plugin_slug),
		        array( $this, 'rpso_user_reg_callback'),
		        'rpso_realpro_setting',
		        'woo_settings_section'
		    );

		    add_settings_field(
		        'order_sms_templete',
		        __('Woocommerce SMS Alert Templete', $plugin_slug),
		        array( $this, 'rpso_status_sms_templete_callback'),
		        'rpso_realpro_setting',
		        'woo_settings_section'
		    );

		    add_settings_field(
		        'user_reg_templete',
		        __('User Registration Alert Templete', $plugin_slug),
		        array( $this, 'rpso_user_reg_templete_callback'),
		        'rpso_realpro_setting',
		        'woo_settings_section'
		    );
		    
		    register_setting(
		        'rpso_realpro_setting',
		        'rpso_realpro_setting',
		        array( $this, 'rpso_sanitize_otp_settings')
		    );

		}


		####################################### OTP Settings Section Callback ######################################


		public function rpso_realpro_settings_callback() {
		    echo "<hr>";
		}

		public function rpso_otp_enable_callback() {
		    $options = get_option( 'rpso_realpro_setting' );

		    $otp_enable = get_option('otp_enable');
		    if( isset( $options['otp_enable'] ) && $options['otp_enable'] != '' ) {
		        $otp_enable = $options['otp_enable'];
		    }

		    $html = '<input type="checkbox" id="otp_enable" name="rpso_realpro_setting[otp_enable]" value="1"' . checked( 1, $otp_enable, false ) . '/>';
		    $html .= '<label for="checkbox_example">Check to enable login OTP/Alert SMS.</label>';

		    echo $html;
		}

		public function rpso_email_otp_disable_callback() {
		    $options = get_option( 'rpso_realpro_setting' );

		    $email_otp_disable = get_option('email_otp_disable');
		    if( isset( $options['email_otp_disable'] ) && $options['email_otp_disable'] != '' ) {
		        $email_otp_disable = $options['email_otp_disable'];
		    }

		    $html = '<input type="checkbox" id="email_otp_disable" name="rpso_realpro_setting[email_otp_disable]" value="1"' . checked( 1, $email_otp_disable, false ) . '/>';
		    $html .= '<label for="checkbox_example">Check to disable login Email OTP.</label><br>';
		    $html .= '<label for="checkbox_example">By default email OTP enabled, yo can disable from here.</label>';

		    echo $html;
		}

		public function rpso_timeout_callback() {
		    $options = get_option( 'rpso_realpro_setting' );

		    $timeout = 3;
		    if( isset( $options['timeout'] ) && $options['timeout'] != '' ) {
		        $timeout = $options['timeout'];
		    }

		    $html = '<input type="text" id="timeout" name="rpso_realpro_setting[timeout]" value="' . $timeout . '" /> Mins';
		    $html .= '<br><label for="timeout">OTP expiration time in min.</label>';

		    echo $html;
		}

		public function rpso_from_email_callback() {
		    $options = get_option( 'rpso_realpro_setting' );

		    $from_email = get_option('admin_email');
		    if( isset( $options['from_email'] ) && $options['from_email'] != '' ) {
		        $from_email = $options['from_email'];
		    }

		    $html = '<input type="text" id="from_email" name="rpso_realpro_setting[from_email]" value="' . $from_email . '" />';
		    $html .= '<br><label for="from_email">User will get OTP email from this email.</label>';

		    echo $html;
		}

		public function rpso_otp_text_callback() {
		    $options = get_option( 'rpso_realpro_setting' );

		    $otp_text = '{{OTP}}';
		    if( isset( $options['otp_text'] ) && $options['otp_text'] != '' ) {
		        $otp_text = $options['otp_text'];
		    }

		    $html = '<textarea id="otp_text" rows="3" cols="60" name="rpso_realpro_setting[otp_text]">' . $otp_text . '</textarea>';
		    $html .= '<br><label for="from_email">{{OTP}} is dynamic variable.</label>';

		    echo $html;
		}


####################################### API Settings Section Callback ######################################


	public function rpso_api_settings_callback() {
	    echo "<hr>";
	}

	public function rpso_api_get_post_callback() {
	    $options = get_option( 'rpso_realpro_setting' );

	    $get_post = get_option('get_post');
	    if( isset( $options['get_post'] ) && $options['get_post'] != '' ) {
	        $get_post = $options['get_post'];
	    }

	    $html = '<input type="checkbox" id="get_post" name="rpso_realpro_setting[get_post]" value="1"' . checked( 1, $get_post, false ) . '/>';
	    $html .= '<label for="checkbox_example">Enable for POST Request.</label>';

	    echo $html;
	}

	public function rpso_api_url_callback() {
	    $api_url = "";
	    $options = get_option( 'rpso_realpro_setting' );

	    if( isset( $options['api_url'] ) && $options['api_url'] != '' ) {
	        $api_url = $options['api_url'];
	    }

	    $html = '<input type="text" id="api_url" size="95" name="rpso_realpro_setting[api_url]" value="' . $api_url . '" placeholder="Ex.. https://sms.provider.com/sms/v3/api.php"/>';
	    $html .= '<br><label for="api_url">Use your SMS provider API Endpoint URL.</label>';

	    echo $html;
	}


	public function rpso_api_peram_callback() {
	    $api_peram = '';
	    $options = get_option( 'rpso_realpro_setting' );

	    if( isset( $options['api_peram'] ) && $options['api_peram'] != '' ) {
	        $api_peram = $options['api_peram'];
	    }

	    $html = '<textarea id="api_peram" rows="4" cols="98" name="rpso_realpro_setting[api_peram]" placeholder="Ex.. api_username=username&api_secret=password&api_token=token_key&sender_id=sid&smsto={{phone_number}}&unique_id={{unique_id}}">' . $api_peram . '</textarea>';
	    $html .= '<br><label style="color:blue;">Pass dynamic variable as parameter value with <b>&</b> separated.</label>';
	    $html .= '<fieldset style="border:2px solid green;width:50%;padding:10px;"><legend>Parameter:</legend>';
	    $html .= 'Parameters will be differ from Gateway API provider to provider. Use your own API Parameters but you can pass some fixed dynamic variable like {{phone_number}}.<br><br>';
	    $html .= ' <b>api_username=username&<br>
	                api_secret=password&<br>
	                api_token=token_key&<br>
	                sender_id=sid&<br>
	                smsto={{phone_number}}&<br>
	                sms_text={{sms_text}}&<br>
	                unique_id={{unique_id}}</b><br>';
	    $html .= 'Fixed dynamic variables: <b>{{phone_number}}, {{unique_id}}, {{sms_text}}</b>';
	    $html .= '</fieldset>';

	    echo $html;
	}

	################################################ Woocommerce Settings #####################################################

	public function rpso_woo_settings_callback()
	{
	    echo "<hr>";
	}

	public function rpso_woo_enable_callback() {
	    $options = get_option( 'rpso_realpro_setting' );

	    $otp_woo_alert = get_option('otp_woo_alert');
	    if( isset( $options['otp_woo_alert'] ) && $options['otp_woo_alert'] != '' ) {
	        $otp_woo_alert = $options['otp_woo_alert'];
	    }

	    $html = '<input type="checkbox" id="otp_woo_alert" name="rpso_realpro_setting[otp_woo_alert]" value="1"' . checked( 1, $otp_woo_alert, false ) . '/>';
	    $html .= '<label for="checkbox_example" style="color:green;"><b>Must enable for woocommerce transactional alert. </b></label>';

	    echo $html;
	}

	public function rpso_woo_pending_callback()
	{
	    $options = get_option( 'rpso_realpro_setting' );

	    $woo_pending_alert = get_option('woo_pending_alert');
	    if( isset( $options['woo_pending_alert'] ) && $options['woo_pending_alert'] != '' ) {
	        $woo_pending_alert = $options['woo_pending_alert'];
	    }

	    $html = '<input type="checkbox" id="woo_pending_alert" name="rpso_realpro_setting[woo_pending_alert]" value="1"' . checked( 1, $woo_pending_alert, false ) . '/>';

	    echo $html;
	}

	public function rpso_woo_processing_callback()
	{
	    $options = get_option( 'rpso_realpro_setting' );

	    $woo_processing_alert = get_option('woo_processing_alert');
	    if( isset( $options['woo_processing_alert'] ) && $options['woo_processing_alert'] != '' ) {
	        $woo_processing_alert = $options['woo_processing_alert'];
	    }

	    $html = '<input type="checkbox" id="woo_processing_alert" name="rpso_realpro_setting[woo_processing_alert]" value="1"' . checked( 1, $woo_processing_alert, false ) . '/>';

	    echo $html;
	}

	public function rpso_woo_hold_callback()
	{
	    $options = get_option( 'rpso_realpro_setting' );

	    $woo_hold_alert = get_option('woo_hold_alert');
	    if( isset( $options['woo_hold_alert'] ) && $options['woo_hold_alert'] != '' ) {
	        $woo_hold_alert = $options['woo_hold_alert'];
	    }

	    $html = '<input type="checkbox" id="woo_hold_alert" name="rpso_realpro_setting[woo_hold_alert]" value="1"' . checked( 1, $woo_hold_alert, false ) . '/>';

	    echo $html;
	}

	public function rpso_woo_fail_callback()
	{
	    $options = get_option( 'rpso_realpro_setting' );

	    $woo_fail_alert = get_option('woo_fail_alert');
	    if( isset( $options['woo_fail_alert'] ) && $options['woo_fail_alert'] != '' ) {
	        $woo_fail_alert = $options['woo_fail_alert'];
	    }

	    $html = '<input type="checkbox" id="woo_fail_alert" name="rpso_realpro_setting[woo_fail_alert]" value="1"' . checked( 1, $woo_fail_alert, false ) . '/>';

	    echo $html;
	}

	public function rpso_woo_cancel_callback()
	{
	    $options = get_option( 'rpso_realpro_setting' );

	    $woo_cancel_alert = get_option('woo_cancel_alert');
	    if( isset( $options['woo_cancel_alert'] ) && $options['woo_cancel_alert'] != '' ) {
	        $woo_cancel_alert = $options['woo_cancel_alert'];
	    }

	    $html = '<input type="checkbox" id="woo_cancel_alert" name="rpso_realpro_setting[woo_cancel_alert]" value="1"' . checked( 1, $woo_cancel_alert, false ) . '/>';

	    echo $html;
	}

	public function rpso_woo_complete_callback()
	{
	    $options = get_option( 'rpso_realpro_setting' );

	    $woo_complete_alert = get_option('woo_complete_alert');
	    if( isset( $options['woo_complete_alert'] ) && $options['woo_complete_alert'] != '' ) {
	        $woo_complete_alert = $options['woo_complete_alert'];
	    }

	    $html = '<input type="checkbox" id="woo_complete_alert" name="rpso_realpro_setting[woo_complete_alert]" value="1"' . checked( 1, $woo_complete_alert, false ) . '/>';

	    echo $html;
	}

	public function rpso_woo_refund_callback()
	{
	    $options = get_option( 'rpso_realpro_setting' );

	    $woo_refund_alert = get_option('woo_refund_alert');
	    if( isset( $options['woo_refund_alert'] ) && $options['woo_refund_alert'] != '' ) {
	        $woo_refund_alert = $options['woo_refund_alert'];
	    }

	    $html = '<input type="checkbox" id="woo_refund_alert" name="rpso_realpro_setting[woo_refund_alert]" value="1"' . checked( 1, $woo_refund_alert, false ) . '/>';

	    echo $html;
	}

	public function rpso_woo_partially_callback()
	{
	    $options = get_option( 'rpso_realpro_setting' );

	    $woo_partially_alert = get_option('woo_partially_alert');
	    if( isset( $options['woo_partially_alert'] ) && $options['woo_partially_alert'] != '' ) {
	        $woo_partially_alert = $options['woo_partially_alert'];
	    }

	    $html = '<input type="checkbox" id="woo_partially_alert" name="rpso_realpro_setting[woo_partially_alert]" value="1"' . checked( 1, $woo_partially_alert, false ) . '/>';

	    echo $html;
	}

	public function rpso_woo_shipped_callback()
	{
	    $options = get_option( 'rpso_realpro_setting' );

	    $woo_shipped_alert = get_option('woo_shipped_alert');
	    if( isset( $options['woo_shipped_alert'] ) && $options['woo_shipped_alert'] != '' ) {
	        $woo_shipped_alert = $options['woo_shipped_alert'];
	    }

	    $html = '<input type="checkbox" id="woo_shipped_alert" name="rpso_realpro_setting[woo_shipped_alert]" value="1"' . checked( 1, $woo_shipped_alert, false ) . '/>';

	    echo $html;
	}

	public function rpso_user_reg_callback()
	{
	    $options = get_option( 'rpso_realpro_setting' );

	    $user_reg_alert = get_option('user_reg_alert');
	    if( isset( $options['user_reg_alert'] ) && $options['user_reg_alert'] != '' ) {
	        $user_reg_alert = $options['user_reg_alert'];
	    }

	    $html = '<input type="checkbox" id="user_reg_alert" name="rpso_realpro_setting[user_reg_alert]" value="1"' . checked( 1, $user_reg_alert, false ) . '/>';

	    echo $html;
	}

	public function rpso_status_sms_templete_callback() {
	    $order_sms_templete = "Dear {{name}}, your order is {{status}}, Your due amount is {{amount}} {{currency}} for order id {{order_id}}.\nThank You\n".get_bloginfo('name');
	    $options = get_option( 'rpso_realpro_setting' );

	    if( isset( $options['order_sms_templete'] ) && $options['order_sms_templete'] != '' ) {
	        $order_sms_templete = $options['order_sms_templete'];
	    }

	    $html = '<textarea id="order_sms_templete" rows="4" cols="98" name="rpso_realpro_setting[order_sms_templete]" placeholder="Ex.. Dear {{name}}, your order is {{status}}, Your due amount is {{amount}} {{currency}} for order id {{order_id}} ">' . $order_sms_templete . '</textarea>';
	    $html .= '<br><label style="color:blue;">Use dynamic variable to get actual value in the SMS.</label>';

	    $html .= '<fieldset style="border:2px solid green;width:50%;padding:10px;"><legend>Dynamic Variables:</legend>';
	    $html .= 'Use fixed dynamic variables.<br><br>';
	    $html .= ' <b>{{name}} - for customer name<br>
	                {{status}} - for order status<br>
	                {{amount}} - for total amount<br>
	                {{currency}} - for currency<br>
	                {{order_id}} - for order id.<br></b>';
	    $html .= '</fieldset>';

	    echo $html;
	}

	public function rpso_user_reg_templete_callback(){
	    $user_reg_templete = "Dear {{name}}, thanks you for your interest.\nThank You\n".get_bloginfo('name');
	    $options = get_option( 'rpso_realpro_setting' );

	    if( isset( $options['user_reg_templete'] ) && $options['user_reg_templete'] != '' ) {
	        $user_reg_templete = $options['user_reg_templete'];
	    }

	    $html = '<textarea id="user_reg_templete" rows="4" cols="98" name="rpso_realpro_setting[user_reg_templete]" placeholder="Ex.. Dear {{name}}, thanks you for your interest. ">' . $user_reg_templete . '</textarea>';
	    $html .= '<br><label style="color:blue;">Use dynamic variable to get actual value in the SMS.</label>';

	    $html .= '<fieldset style="border:2px solid green;width:50%;padding:10px;"><legend>Dynamic Variables:</legend>';
	    $html .= 'Use fixed dynamic variables.<br><br>';
	    $html .= ' <b>{{name}} - for customer name<br></b>';
	    $html .= '</fieldset>';

	    echo $html;
	}


	############################################# Validate Fields ##############################################


	function rp_sanitize_otp_settings( $input ) {
	    
	    global $plugin_slug;
	    $output = array();

	    if ( isset( $input['timeout'] ) ) {
	        if ( is_numeric( $input['timeout'] ) ) {
	            $output['timeout'] = strip_tags( stripslashes( $input['timeout'] ) );
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'timeout-data-type', esc_html__( 'OTP Timeout must be numerical', $plugin_slug));
	        }
	    }

	    if ( isset( $input['from_email'] ) ) {
	        if ( is_email( $input['from_email'] ) ) {
	            $output['from_email'] = sanitize_email( $input['from_email'] );
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'email-error', esc_html__( 'From email address not valid', $plugin_slug));
	        }
	    }

	    if ( isset( $input['otp_enable'] ) ) {
	        if (  $input['otp_enable']  ) {
	            $output['otp_enable'] =  $input['otp_enable'] ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'otp-error', esc_html__( 'Enable to Login SMS OTP', $plugin_slug));
	        }
	    }

	    if ( isset( $input['email_otp_disable'] ) ) {
	        if (  $input['email_otp_disable']  ) {
	            $output['email_otp_disable'] =  $input['email_otp_disable'] ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'otp-error', esc_html__( 'Disable Email OTP', $plugin_slug));
	        }
	    }

	    if ( isset( $input['otp_text'] ) ) {
	        if (  $input['otp_text'] != "" ) {
	            $output['otp_text'] =  sanitize_textarea_field($input['otp_text']) ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'otptxt-error', esc_html__( 'Please enter dynamic variable {OTP}.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['get_post'] ) ) {
	        if (  $input['get_post']  ) {
	            $output['get_post'] =  $input['get_post'] ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'getpost-error', esc_html__( 'Enable for POST Request', $plugin_slug) );
	        }
	    }

	    if ( isset( $input['api_url'] ) ) {
	        if (  $input['api_url'] != "" ) {
	            $output['api_url'] =  esc_url($input['api_url']) ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'api-error', esc_html__( 'Please enter API Endpoint URL', $plugin_slug));
	        }
	    }

	    if ( isset( $input['api_peram'] ) ) {
	        if (  $input['api_peram'] != "" ) {
	            $output['api_peram'] =  sanitize_textarea_field($input['api_peram']) ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'otptxt-error', esc_html__( 'Please enter API Parameters', $plugin_slug) );
	        }
	    }

	    if ( isset( $input['otp_woo_alert'] ) ) {
	        if (  $input['otp_woo_alert']  ) {
	            $output['otp_woo_alert'] =  $input['otp_woo_alert'] ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'otp_woo_alert-error', esc_html__( 'Enable for woocommerce status changing alert', $plugin_slug));
	        }
	    }

	    if ( isset( $input['woo_pending_alert'] ) ) {
	        if (  $input['woo_pending_alert']  ) {
	            $output['woo_pending_alert'] =  $input['woo_pending_alert'] ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'woo_pending_alert-error', esc_html__( 'Enable for order pending alert', $plugin_slug));
	        }
	    }

	    if ( isset( $input['woo_processing_alert'] ) ) {
	        if (  $input['woo_processing_alert']  ) {
	            $output['woo_processing_alert'] =  $input['woo_processing_alert'] ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'woo_processing_alert-error', esc_html__( 'Enable for order processing alert', $plugin_slug));
	        }
	    }

	    if ( isset( $input['woo_hold_alert'] ) ) {
	        if (  $input['woo_hold_alert']  ) {
	            $output['woo_hold_alert'] =  $input['woo_hold_alert'] ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'woo_hold_alert-error', esc_html__( 'Enable for order on hold alert', $plugin_slug));
	        }
	    }

	    if ( isset( $input['woo_fail_alert'] ) ) {
	        if (  $input['woo_fail_alert']  ) {
	            $output['woo_fail_alert'] =  $input['woo_fail_alert'] ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'woo_fail_alert-error', esc_html__( 'Enable for order failed alert', $plugin_slug));
	        }
	    }

	    if ( isset( $input['woo_cancel_alert'] ) ) {
	        if (  $input['woo_cancel_alert']  ) {
	            $output['woo_cancel_alert'] =  $input['woo_cancel_alert'] ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'woo_cancel_alert-error', esc_html__( 'Enable for order cancel alert', $plugin_slug));
	        }
	    }

	    if ( isset( $input['woo_complete_alert'] ) ) {
	        if (  $input['woo_complete_alert']  ) {
	            $output['woo_complete_alert'] =  $input['woo_complete_alert'] ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'woo_complete_alert-error', esc_html__( 'Enable for order clomplete alert', $plugin_slug));
	        }
	    }

	    if ( isset( $input['woo_refund_alert'] ) ) {
	        if (  $input['woo_refund_alert']  ) {
	            $output['woo_refund_alert'] =  $input['woo_refund_alert'] ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'woo_refund_alert-error', esc_html__( 'Enable for order refund', $plugin_slug));
	        }
	    }

	    if ( isset( $input['woo_partially_alert'] ) ) {
	        if (  $input['woo_partially_alert']  ) {
	            $output['woo_partially_alert'] =  $input['woo_partially_alert'] ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'woo_partially_alert-error', esc_html__( 'Enable for order partially alert', $plugin_slug) );
	        }
	    }

	    if ( isset( $input['woo_shipped_alert'] ) ) {
	        if (  $input['woo_shipped_alert']  ) {
	            $output['woo_shipped_alert'] =  $input['woo_shipped_alert'] ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'woo_shipped_alert-error', esc_html__( 'Enable for order shipment alert', $plugin_slug));
	        }
	    }

	    if ( isset( $input['user_reg_alert'] ) ) {
	        if (  $input['user_reg_alert']  ) {
	            $output['user_reg_alert'] =  $input['user_reg_alert'] ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'user_reg_alert-error', esc_html__( 'Enable for user registration alert', $plugin_slug));
	        }
	    }

	    if ( isset( $input['order_sms_templete'] ) ) {
	        if (  $input['order_sms_templete']  ) {
	            $output['order_sms_templete'] =  sanitize_textarea_field($input['order_sms_templete']) ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'order_sms_templete-error', esc_html__( 'Enter your woocommerce alert sms templete', $plugin_slug));
	        }
	    }

	    if ( isset( $input['user_reg_templete'] ) ) {
	        if (  $input['user_reg_templete']  ) {
	            $output['user_reg_templete'] =  sanitize_textarea_field($input['user_reg_templete']) ;
	        } else {
	            add_settings_error( 'rpso_realpro_setting', 'user_reg_templete-error', esc_html__( 'Enter your user registration sms templete', $plugin_slug));
	        }
	    }


	    return apply_filters( 'rpso_realpro_setting', $output, $input );
	}


}

	new RPSO_Realpro_Admin;

	############################################## END ##################################################
?>

