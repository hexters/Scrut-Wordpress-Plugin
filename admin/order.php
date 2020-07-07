<div class="wrap scrut" id="scrut-admin-order">
  <h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>

  <?php $this->pre_html(json_encode($orders, JSON_PRETTY_PRINT)); ?>

  <div class="text-right">
    <?php echo $paginate->render(); ?>
  </div>
</div>

