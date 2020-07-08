<div class="wrap scrut" id="scrut-admin-order">
  <h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>

  <?php 
    $page = isset($_GET['section']) ? $_GET['section'] : 'index';
    switch($page): 
      case"detail":
        $id = $this->request('id', 0);
        $detail = $detail->whereID($id);
        if($detail) {
          require_once( SCRUT__PLUGIN_DIR . '/admin/_partials/_order/_detail.php' );
        } else {
          require_once( SCRUT__PLUGIN_DIR . '/admin/_partials/_order/_notFound.php' );
        }
      break;
      default: 
        require_once( SCRUT__PLUGIN_DIR . '/admin/_partials/_order/_index.php' );
    endswitch; 
  ?>
</div>

