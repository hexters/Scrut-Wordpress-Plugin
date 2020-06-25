<?php
/*
Plugin Name: Scrut
Plugin URI:  https://scrut.my/
Description: Listing Personal cars form scrut.my
Version:     1.0.0
Author:      Asep
Author URI:  https://github.com/hexters
Text Domain: scrut
Domain Path: /languages
License:     GPL2
 
Scrut Listing is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Scrut Listing is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Scrut Listing. If not, see {License URI}.
*/

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define('SCRUT__VERSION', '1.0.0');
define( 'SCRUT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SCRUT__PLUGIN_PATH_NAME', plugin_basename( __FILE__ ) );
define('SCRUT__FILE', __FILE__);


require_once( dirname( __FILE__ ) . '/inc/Scrut.php' );

$scrut = new Scrut();
$scrut->register();

register_activation_hook( __FILE__, [$scrut, 'activate'] );
register_deactivation_hook( __FILE__, [$scrut, 'deactivate'] );