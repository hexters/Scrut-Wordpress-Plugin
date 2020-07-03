<div class="wrap">
<?php $tab = isset($_GET['tab']) ? $_GET['tab'] : 'general' ?>
<nav class="nav-tab-wrapper wp-clearfix" aria-label="Secondary menu">
  <a href="<?php echo admin_url('admin.php?page=scrut_setting&tab=general') ?>" class="nav-tab <?php echo $tab == 'general' ? 'nav-tab-active' : '' ?>" aria-current="page">General</a>
  <a href="<?php echo admin_url('admin.php?page=scrut_setting&tab=payment') ?>" class="nav-tab <?php echo $tab == 'payment' ? 'nav-tab-active' : '' ?>" aria-current="page">Payment</a>
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
  ?>

  
  
</div>

