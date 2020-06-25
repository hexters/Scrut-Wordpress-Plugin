<?php 
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();

global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}scrut_setting;");
$wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_name = 'scrut-listing';");