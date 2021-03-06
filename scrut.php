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
 
Scrut is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Scrut is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Scrut. If not, see {License URI}.
*/

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

if( ! file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	echo 'PHP Library not found!';
	exit;
}

define( 'SCRUT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SCRUT__PLUGIN_PATH_NAME', plugin_basename( __FILE__ ) );
define('SCRUT__FILE', __FILE__);
if(! defined('SPARATOR')) {
	define('SPARATOR', '/');
}

require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
require_once( dirname( __FILE__ ) . '/inc/models/ScrutOrder.php' );
require_once( dirname( __FILE__ ) . '/inc/abstract/ScrutPaymentGateway.php' );

use App\Scrut;
use App\Payment;

$scrut = new Scrut();
$scrut->register();
$payment = new Payment();

register_activation_hook( __FILE__, [$scrut, 'activate'] );
register_deactivation_hook( __FILE__, [$scrut, 'deactivate'] );