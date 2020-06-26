<?php
if(! session_id()) {
  session_start();
}
require_once( SCRUT__PLUGIN_DIR . '/models/Setting.php' );

class Scrut {

  private $errors;

  public function activate() {
    global $wpdb;
    $query = "
      CREATE TABLE IF NOT EXISTS {$wpdb->prefix}scrut_setting (
        id INT(11) NOT NULL AUTO_INCREMENT,
        email VARCHAR(200) NULL,
        api_key VARCHAR(1000) NULL,
        PRIMARY KEY (id)
      );
    ";
    $wpdb->query($query);

    $my_post = [
      'post_title'    => wp_strip_all_tags( 'Scrut Listing' ),
      'post_content'  => '[scrut_listing]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
      'post_name'     => 'scrut-listing'
    ];
    wp_insert_post( $my_post );

  }

  public function deactivate() {
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_name = 'scrut-listing';");
  }
  
  public function register() {
    add_filter( 'plugin_action_links_' . SCRUT__PLUGIN_PATH_NAME, [$this, 'filter_action_links'], 10, 1 );
    add_action( 'admin_menu', [$this, 'add_parent_menu']);
    add_action( 'admin_post_scrut-post-setting', [$this, 'setting_post_data'] );
    add_shortcode( 'scrut_listing', [$this, 'scrut_shortcode_listing'] );
    add_action( 'admin_enqueue_scripts',  [$this, 'enqueue_assets_admin']);
    add_action( 'wp_enqueue_scripts', [$this, 'enqueue_assets_public'] );
    add_action( 'admin_bar_menu', [$this, 'admin_bar_menu'], 100);
  }

  public function admin_bar_menu ( $admin_bar ) {
    if ( ! current_user_can( 'manage_options' ) ) {
      return;
    }
    $data = new Setting();
    $admin_bar->add_menu([
      'id'    => 'scrut-balance',
      'title' => '<scrut-balance icon="' . plugins_url( 'admin/assets/scrut.png', SCRUT__FILE ) . '" email="' . $data->email . '" apikey="' . $data->key . '" />',
      'href'  => 'https://scrut.my/transactions',
      'meta'  => [
        'target' => '_blank',
        'title' => __('Scrut Balance'),
      ],
    ]);
  }
  
  public function enqueue_assets_admin() {
    wp_enqueue_script( 'scrut_admin_script', plugins_url( 'admin/assets/js/admin-scrut.js', SCRUT__FILE ), [], 1, true );
    wp_enqueue_style( 'scrut_admin_style', plugins_url( 'admin/assets/css/admin-scrut.css', SCRUT__FILE), [], 1, 'all' );
  }
  public function enqueue_assets_public() {
    wp_enqueue_script( 'scrut_admin_script', plugins_url( 'public/assets/js/scrut.js', SCRUT__FILE ), [], 1, true );
    wp_enqueue_style( 'scrut_admin_style', plugins_url( 'public/assets/css/scrut.css', SCRUT__FILE), [], 1, 'all' );
  }
  
  public function filter_action_links( $links ) {
    if( is_admin() ) {
      $links['setting'] = '<a href="' . admin_url('/admin.php?page=scrut_setting') . '">Setting</a>';
    }
    return $links;
  }

  public function add_parent_menu() {
    add_menu_page( __('Scrut', 'scrut'), __('Scrut', 'scrut'), null, 'scrut_menu', '', plugins_url( 'scrut/admin/assets/scrut.png' ), 30 );
    add_submenu_page( 'scrut_menu', __('Scrut Listing'), __('Listing'), 'manage_options', 'scrut_listing', [$this, 'listing_view'], 1 );
    add_submenu_page( 'scrut_menu', __('Scrut Setting'), __('Setting'), 'administrator', 'scrut_setting', [$this, 'setting_view'], 1 );
  }

  public function setting_view() {

    $data = new Setting();
    require_once(SCRUT__PLUGIN_DIR . '/admin/setting.php');
    unset($_SESSION['email']);
    unset($_SESSION['key']);
    unset($_SESSION['message']);
    unset($_SESSION['error']);
  }
  public function setting_post_data() {
    $redirect = wp_redirect( admin_url( 'admin.php?page=scrut_setting' ));
    if(empty($_POST['email'])) {
      $_SESSION['email'][] = "Email is required!";
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $_SESSION['email'][] = "Invalid email format";
    }
    if(empty($_POST['key'])) {
      $_SESSION['key'][] = "Api Key is required!";
    }
    if(empty($_POST['email']) || empty($_POST['key'])) {
      return $redirect;
    }
    
    try {
      $data = new Setting();
      $data->update(esc_html( trim($_POST['email']) ), esc_html( trim($_POST['key']) ));
      $_SESSION['message'] = "Update has been succesfully";
      return $redirect;
    } catch (Exception $e) {
      $_SESSION['error'] = $e->getMessage();
      return $redirect;
    }

  }

  public function listing_view() {

    $data = new Setting();
    if(is_null($data->email) || is_null($data->key)) {
      $_SESSION['error'] = 'Please completed this data below!';
      $this->redirect(admin_url( 'admin.php?page=scrut_setting' ));
    } else {
      require_once(SCRUT__PLUGIN_DIR . '/admin/listing.php');
    }

  }

  public function scrut_shortcode_listing( $atts ) {
    $data = new Setting();
    if(!$data) {
      echo '<h1>Scrut Api Key not found</h1>';
    } else {
      require_once( SCRUT__PLUGIN_DIR . '/public/listing.php');
    }
  }

  public function redirect($url) {
    echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
    exit();
  }
  
}