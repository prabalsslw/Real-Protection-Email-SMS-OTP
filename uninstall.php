<?php 
/*
 * Removes options from database when plugin is deleted.
 *  
 *
 */

# if uninstall not called from WordPress exit

	if (!defined('WP_UNINSTALL_PLUGIN' ))
	    exit();

	global $wpdb, $wp_version;

	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}rpso_realpro_otpsms" );
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}rpso_realpro_woosms" );

	delete_option("rpso_db_version");
	delete_option('rpso_realpro_setting');

	wp_cache_flush();

?>