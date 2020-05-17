<?php
/**
 * Plugin Name: Real Protection Email/SMS OTP
 * Plugin URI: https://prabalsslw.github.io
 * Description: Real Protection, 2 step Verification for WordPress login and woocommerce transaction alert.
 * Version: 2.0.0
 * Stable tag: 2.0.0
 * Author: Prabal Mallick
 * Author URI: https://prabalsslw.wixsite.com/prabal
 * WC tested up to: 4.1.0
 * License: GPL2
**/

	if ( ! defined( 'WPINC' ) ) {
		die('Are you supposed to be here?');
	}

	global $rpso_db_version;
	global $plugin_slug;

	$rpso_db_version = '2.0';
	$plugin_slug = 'rpso_realpro';

	$options = get_option( 'rpso_realpro_setting' );

	// echo "<pre>";
	// print_r($options);
	// echo "</pre>";exit;

	/**
	 * Load the default settings
	 */

	require_once __DIR__.'/admin/rpso-realpro-admin.php';
	require_once __DIR__.'/templete/rpso-registration-field.php';
	require_once __DIR__.'/class/class-rpso-rewrite-rules-login.php';
	require_once __DIR__.'/templete/rpso-login-process.php';

	use Realpro\Rewrite\Rules\RPSO_Rewrite_Rules_Login;


	add_action('plugins_loaded', array(RPSO_Rewrite_Rules_Login::get_instance(), 'setup'));


	register_activation_hook( __FILE__, 'rpso_realpro_active' );

	function rpso_realpro_active() {

		require_once plugin_dir_path( __FILE__ ) . 'include/rpso-realpro-init.php';
		rpso_realpro_init::rpso_realpro_install();
	}

	/**
	 * Hook to check plugin updates
	 */
	add_action( 'plugins_loaded', 'rpso_realpro_update_db_check' );

	function rpso_realpro_update_db_check() {

		global $rpso_db_version;
		if ( get_site_option( 'rpso_db_version' ) != $rpso_db_version ) {
			rpso_realpro_active();
		}
	}


	function rpso_realpro_plugin_links($links) {
	    $pluginLinks = array(
	                    'settings' => '<a href="'. esc_url(admin_url('admin.php?page=real-protection-otp-settings')) .'">Settings</a>',
	                    'docs'     => '<a href="https://prabalsslw.github.io/RP-OTP-Woocommerce/">Docs</a>',
	                    'support'  => '<a href="mailto:prabalsslw@gmail.com">Support</a>'
	                );

	    $links = array_merge($links, $pluginLinks);

	    return $links;
	}

	$plugin = plugin_basename(__FILE__); 
	add_filter("plugin_action_links_$plugin", 'rpso_realpro_plugin_links' );


	# Load Plugin Admin CSS
	function rpso_load_custom_admin_style() {
	        wp_register_style( 'real-protection', plugin_dir_url( __FILE__ ) . 'admin/css/style.css', false, '1.0.0' );
	        wp_enqueue_style( 'real-protection' );
	}

	add_action( 'admin_enqueue_scripts', 'rpso_load_custom_admin_style' );