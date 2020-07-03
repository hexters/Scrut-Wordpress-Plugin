<?php 
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();

delete_option( 'scrut_general_option' );
delete_option( 'scrut_payment_methods' );
