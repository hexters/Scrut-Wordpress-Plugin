<?php
  $section = isset($_GET['section']) ? $_GET['section'] : 'lists';
  switch($section) {
    case"form":
      require_once( SCRUT__PLUGIN_DIR . '/admin/_partials/_payment_form.php' );
      break;
    default:
      require_once( SCRUT__PLUGIN_DIR . '/admin/_partials/_payment_list.php' );
  }

?>