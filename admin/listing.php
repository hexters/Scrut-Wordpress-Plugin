<div class="wrap" id="scrut-admin-app">
  <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
  <scrut-admin-listing email="<?php echo $data->email ?>" apikey="<?php echo $data->key ?>" />
</div>