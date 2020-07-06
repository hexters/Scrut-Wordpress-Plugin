<div class="wrap scrut">
<h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>

<?php if(array_key_exists('message', $_SESSION)): ?>  
  <div class="updated notice is-dismissible">
    <p><?php echo $_SESSION['message'] ?></p>
    <button class="notice-dismiss" type="button"></button>
  </div>
<?php endif; ?>
<?php if(array_key_exists('error', $_SESSION)): ?>
  <div class="error notice is-dismissible">
    <p><?php echo $_SESSION['error'] ?></p>
  </div>
<?php endif; ?>

<?php $tab = isset($_GET['tab']) ? $_GET['tab'] : 'general' ?>
<nav class="nav-tab-wrapper wp-clearfix" aria-label="Secondary menu">
  <a href="<?php echo admin_url('admin.php?page=scrut_setting&tab=general') ?>" class="nav-tab <?php echo $tab == 'general' ? 'nav-tab-active' : '' ?>" aria-current="page">General</a>
  <a href="<?php echo admin_url('admin.php?page=scrut_setting&tab=payment') ?>" class="nav-tab <?php echo $tab == 'payment' ? 'nav-tab-active' : '' ?>" aria-current="page">Payments</a>
</nav>

  <?php 
    if(isset($_GET['tab'])):
      switch($_GET['tab']):
        case"payment":
          require_once(SCRUT__PLUGIN_DIR . '/admin/_partials/_payment.php');
        break;
        default:
          require_once(SCRUT__PLUGIN_DIR . '/admin/_partials/_general.php');
      endswitch;
    else: 
      require_once(SCRUT__PLUGIN_DIR . '/admin/_partials/_general.php');
    endif;

    unset($_SESSION['scrut_payment_notif']);
  ?>
  
</div>

