<div class="wrap" id="scrut-admin-report">
  <h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>
  
  <?php if(isset($_GET['detail'])): ?>
    <scrut-admin-report-detail report="<?php echo $_GET['detail'] ?>" assets="<?php echo plugins_url( '/assets', SCRUT__FILE ) ?>" />
  <?php else: ?>
    <scrut-admin-report-index assets="<?php echo plugins_url( '/assets', SCRUT__FILE ) ?>" />
  <?php endif; ?>

</div>