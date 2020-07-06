<?php


namespace App;
use App\Models\Setting;
if(! session_id()) {
  session_start();
}

class Scrut extends Ajax {

  private $errors;
  public function __construct() {
    parent::__construct();
  }

  public function table_order_sql() {
    global $wpdb;
    return "
      CREATE TABLE IF NOT EXISTS {$wpdb->prefix}scrut_report_order(
        id INT(11) PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone_number VARCHAR(100) NOT NULL,
        user_id INT(11) NOT NULL,
        transaction_number VARCHAR(100) NOT NULL,
        chassis_no INT(11) NOT NULL,
        chassis_key TEXT NOT NULL,
        created_at DATETIME NOT NULL,
        state VARCHAR(50) NOT NULL DEFAULT 'unpaid',
        price DECIMAL(10,2) NOT NULL,
        payment_id VARCHAR(100) NULL,
        payload_response LONGTEXT NULL,
        report_data LONGTEXT NULL
      );
    ";
  }

  public function activate() {
    
    global $wpdb;
    $wpdb->query( $this->table_order_sql() );


    add_option( 'scrut_general_option', serialize([
      'email' => '',
      'api_key' => '',
      'report_price' => 50
    ]) );

    add_option( 'scrut_payment_methods', serialize([
      'bank_transfer'
    ]) );


    // Create page checkout
    $my_post = [
      'post_title'    => wp_strip_all_tags( 'Scrut Account' ),
      'post_content'  => '[scrut_account]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
      'post_name'     => 'scrut-account'
    ];
    wp_insert_post( $my_post );

    // Create page Check
    $my_post = [
      'post_title'    => wp_strip_all_tags( 'Scrut Check' ),
      'post_content'  => '[scrut_check]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
      'post_name'     => 'scrut-check'
    ];
    wp_insert_post( $my_post );

    // Create page checkout
    $my_post = [
      'post_title'    => wp_strip_all_tags( 'Scrut Checkout' ),
      'post_content'  => '[scrut_checkout]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
      'post_name'     => 'scrut-checkout'
    ];
    wp_insert_post( $my_post );

    
    
  }

  public function deactivate() {
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_name = 'scrut-check';");
    $wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_name = 'scrut-checkout';");
    $wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_name = 'scrut-account';");
    $themePath = get_template_directory();
    
  }

  public function register() {
    add_filter( 'plugin_action_links_' . SCRUT__PLUGIN_PATH_NAME, [$this, 'filter_action_links'], 10, 1 );
    add_action( 'admin_menu', [$this, 'add_parent_menu']);
    add_action( 'admin_post_scrut-post-setting', [$this, 'setting_post_data'] );
    add_action( 'admin_enqueue_scripts',  [$this, 'enqueue_assets_admin']);
    add_action( 'admin_bar_menu', [$this, 'admin_bar_menu'], 100);
    add_action( 'admin_enqueue_scripts',  [$this, 'enqueue_fancyapps_plugin']);
    add_action( 'admin_post_scrut-payemnt-method-update', [$this, 'payment_method_update_post'] );
    add_action( 'init', [$this, 'add_roles'] );
    $this->register_ajax();
    
    // Public
    add_shortcode( 'scrut_check', [$this, 'scrut_shortcode_check'] );
    add_shortcode( 'scrut_checkout', [$this, 'scrut_shortcode_checkout'] );
    add_shortcode( 'scrut_account', [$this, 'scrut_shortcode_account'] );
    add_action( 'wp_enqueue_scripts', [$this, 'enqueue_assets_public'] );
    add_action( 'admin_post_nopriv_scrut-post-checkout', [$this, 'scrut_shortcode_checkout_post'] );
    add_action( 'admin_post_scrut-post-checkout', [$this, 'scrut_shortcode_checkout_post'] );
    add_action( 'admin_post_scrut-post-account', [$this, 'scrut_shortcode_account_post'] );
    add_action( 'init', [$this, 'disabled_admin_bar']);
  }

  public function register_ajax() {
    add_action( 'wp_ajax_get_report', [$this, 'get_report'] );
    add_action( 'wp_ajax_nopriv_get_report', [$this, 'get_report'] );

    add_action( 'wp_ajax_get_balance', [$this, 'get_balance'] );
    add_action( 'wp_ajax_nopriv_get_balance', [$this, 'get_balance'] );

    add_action( 'wp_ajax_get_check', [$this, 'get_check'] );
    add_action( 'wp_ajax_nopriv_get_check', [$this, 'get_check'] );

    add_action( 'wp_ajax_post_buy', [$this, 'post_buy'] );
    add_action( 'wp_ajax_nopriv_post_buy', [$this, 'post_buy'] );

    add_action( 'wp_ajax_get_view', [$this, 'get_view'] );
    add_action( 'wp_ajax_nopriv_get_view', [$this, 'get_view'] );

    add_action( 'wp_ajax_add_chart', [$this, 'add_chart'] );
    add_action( 'wp_ajax_nopriv_add_chart', [$this, 'add_chart'] );
    
  }

  public function add_roles() {
    if(!wp_roles(  )->is('customer')) {
      add_role( 'customer', 'Customer', [] );
    }
  }

  public function disabled_admin_bar() {
    if(current_user_can( 'customer' )) {
      show_admin_bar( false );
    }
  }
  
  public function admin_bar_menu ( $admin_bar ) {
    if ( ! current_user_can( 'manage_options' ) ) {
      return;
    }
    $admin_bar->add_menu([
      'id'    => 'scrut-balance',
      'title' => '<scrut-balance icon="' . plugins_url( 'admin/assets/scrut.png', SCRUT__FILE ) . '" email="' . $this->setting()->email . '" apikey="' . $this->setting()->key . '" />',
      'href'  => 'javascript:void(0);',
      'meta'  => [
        'target' => '_blank',
        'title' => __('Scrut Balance'),
      ],
    ]);
    $admin_bar->add_menu([
      'id'    => 'scrut-balance-topup',
      'title' => __('Add Credit'),
      'href'  => $this->apiurl . '/topup',
      'parent' => 'scrut-balance',
      'meta'  => [
        'target' => '_blank',
        'title' => __('Add Credit'),
      ],
    ]);
    $admin_bar->add_menu([
      'id'    => 'scrut-balance-transaction',
      'title' => __('Transaction History'),
      'href'  => $this->apiurl . '/transactions',
      'parent' => 'scrut-balance',
      'meta'  => [
        'target' => '_blank',
        'title' => __('Transaction'),
      ],
    ]);
  }
  
  public function enqueue_assets_admin() {
    wp_enqueue_script( 'scrut_admin_script', plugins_url( 'admin/assets/js/admin-scrut.js', SCRUT__FILE ), [], 1, true );
    wp_enqueue_style( 'scrut_admin_style', plugins_url( 'admin/assets/css/admin-scrut.css', SCRUT__FILE), [], 1, 'all' );

    wp_localize_script( 'scrut_admin_script', 'ajax_option', [
      'ajaxurl' => admin_url('admin-ajax.php')
    ] );
  }
  public function enqueue_assets_public() {
    wp_enqueue_script( 'scrut_public_script', plugins_url( 'public/assets/js/scrut.js', SCRUT__FILE ), [], 1, true );
    wp_enqueue_style( 'scrut_public_style', plugins_url( 'public/assets/css/scrut.css', SCRUT__FILE), [], 1, 'all' );
    wp_localize_script( 'scrut_public_script', 'ajax_option', [
      'ajaxurl' => admin_url('admin-ajax.php')
    ] );
  }

  public function enqueue_fancyapps_plugin() {
    wp_enqueue_script( 'scrut_admin_fancyapps_script', plugins_url( 'admin/assets/plugin/fancyapps/jquery.fancybox.min.js', SCRUT__FILE ), [], 1, true );
    wp_enqueue_style( 'scrut_admin_fancyapps_style', plugins_url( 'admin/assets/plugin/fancyapps/jquery.fancybox.min.css', SCRUT__FILE), [], 1, 'all' );
    wp_localize_script( 'scrut_admin_fancyapps_script', 'facyapps', ['$(`[data-fancybox="scrut-gallery"]`).fancybox();'] );
  }
  
  public function filter_action_links( $links ) {
    if( is_admin() ) {
      $links['setting'] = '<a href="' . admin_url('/admin.php?page=scrut_setting') . '">Setting</a>';
    }
    return $links;
  }

  public function add_parent_menu() {
    add_menu_page( __('Scrut', 'scrut'), __('Scrut', 'scrut'), null, 'scrut_menu', '', plugins_url( 'scrut/admin/assets/scrut.png' ), 30 );
    add_submenu_page( 'scrut_menu', __('Order'), __('Order'), 'manage_options', 'scrut_order', [$this, 'order_view'], 1 );
    add_submenu_page( 'scrut_menu', __('My Report'), __('My Report'), 'manage_options', 'scrut_report', [$this, 'my_report_view'], 2 );
    add_submenu_page( 'scrut_menu', __('Scrut Setting'), __('Setting'), 'administrator', 'scrut_setting', [$this, 'setting_view'], 3 );
  }

  public function setting_view() {

    $data = $this->setting();
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
    if(empty($_POST['report_price'])) {
      $_SESSION['report_price'][] = "Report Price is required!";
    }
    if(empty($_POST['email']) || empty($_POST['key']) || empty($_POST['report_price'])) {
      return $redirect;
    }
    
    try {
      $data = $this->setting();
      $data->update(esc_html( trim($_POST['email']) ), esc_html( trim($_POST['key']) ), esc_html( trim($_POST['report_price']) ) );
      $_SESSION['message'] = "Update has been succesfully";
      return $redirect;
    } catch (Exception $e) {
      $_SESSION['error'] = $e->getMessage();
      return $redirect;
    }

  }

  public function my_report_view() {
    $data = $this->setting();
    if(is_null($data->email) || is_null($data->key)) {
      $_SESSION['error'] = 'Please completed this data below!';
      $this->redirect(admin_url( 'admin.php?page=scrut_setting' ));
    } else {
      require_once(SCRUT__PLUGIN_DIR . '/admin/report.php');
    }

  }

  public function order_view() {
    $data = $this->setting();
    if(is_null($data->email) || is_null($data->key)) {
      $_SESSION['error'] = 'Please completed this data below!';
      $this->redirect(admin_url( 'admin.php?page=scrut_setting' ));
    } else {
      require_once(SCRUT__PLUGIN_DIR . '/admin/order.php');
    }
  }

  public function scrut_shortcode_check( $atts ) {
    $data = $this->setting();
    if(!$data) {
      die('<h1>Scrut Api Key not found</h1>');
    } else {
      require_once( SCRUT__PLUGIN_DIR . '/public/check.php');
    }
  }

  public function scrut_shortcode_checkout() {
    $data = $this->setting();
    do_action('scrut_payment_gateway_response_callback');
    if(!$data) {
      die('<h1>Scrut Api Key not found</h1>');
    } else {
      $chassis = null;
      if(isset($_SESSION['scrut_cart'])) {
        $chassis = json_decode($_SESSION['scrut_cart']);
      }
      require_once( SCRUT__PLUGIN_DIR . '/public/checkout.php');
    }
  }

  public function scrut_shortcode_account() {
    $data = $this->setting();
    if(!$data) {
      die('<h1>Scrut Api Key not found</h1>');
    } else {
      $chassis = null;
      if(isset($_SESSION['scrut_cart'])) {
        $chassis = json_decode($_SESSION['scrut_cart']);
      }

      if(is_user_logged_in(  )) {
        $user = wp_get_current_user();
        require_once( SCRUT__PLUGIN_DIR . '/public/account.php');
      } else {
        require_once( SCRUT__PLUGIN_DIR . '/public/login.php');
      }
    }
  }

  public function scrut_shortcode_account_post() {

  }

  public function scrut_shortcode_checkout_post() {
    (isset($_POST['type']) && in_array($_POST['type'], ['cancel', 'submit'])) or die('Forbidden');
    if(in_array($_POST['type'], ['cancel'])) {
      unset($_SESSION['scrut_cart']);
      $this->redirect( get_permalink( get_page_by_path( 'scrut-checkout' ) ) );
    } else if(in_array($_POST['type'], ['submit'])) {
      if(!is_user_logged_in(  )) {

        $name = explode(' ', esc_html( trim($_POST['display_name']) ));
        $firstName = $name[0];
        $lastName = ltrim(esc_html( trim($_POST['display_name']) ), $name[0]);

        $user_login = explode('@', esc_html( trim($_POST['user_email']) ));
        $user_id = wp_insert_user( [
          'user_login' => $user_login[0],
          'display_name' => esc_html( trim($_POST['display_name']) ),
          'user_pass' => esc_html( trim($_POST['user_pass']) ),
          'user_email' => esc_html( trim($_POST['user_email']) ),
          'first_name' => trim($firstName),
          'last_name' => trim($lastName),
          'role' => 'customer'
        ] );
          
        
        $user = get_user_by( 'id', $user_id );
        wp_set_current_user( $user_id, $user );
        wp_set_auth_cookie( $user_id );
        do_action( 'wp_login', $user );
        
      }

      $current_user = wp_get_current_user();

      global $wpdb;
      $wpdb->insert("{$wpdb->prefix}scrut_report_order", [
        'name' => esc_html( trim($_POST['display_name']) ),
        'email' => esc_html( trim($_POST['user_email']) ),
        'phone_number' => esc_html( trim($_POST['phone_number']) ),
        'user_id' => $current_user->ID,
        'transaction_number' => 'scrut' . SPARATOR . date('ymd') . SPARATOR . rand(1111,9999),
        'chassis_no' => esc_html( trim($_POST['chassis_no']) ),
        'chassis_key' => esc_html( trim($_POST['chassis_key']) ),
        'created_at' => date('Y-m-d h:i:s'),
        'payment_id' => esc_html( trim($_POST['payment_id']) ),
        'price' => $this->setting()->price
      ], [ '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%f', ]);
      
      do_action( 'scrut_report_order_payment_process', $wpdb->insert_id, esc_html( trim($_POST['payment_id']) ));
    }
    
  }

  public function payment_method_update_post() {
    unset($_POST['action']);
    $disabled = isset($_POST['disabled']) ? 'no' : 'yes';
    unset($_POST['disabled']);
    $params = array_merge($_POST, ['disabled' => $disabled]);
    update_option('scrut_payment_method_' . $this->request('payment_id'), serialize($params));
    $_SESSION['message'] = 'Peyment method has been updated';
    $this->redirect( admin_url('admin.php?page=scrut_setting&tab=payment&section=form&payment_id=' . $this->request('payment_id')) );
  }
  
  public function request($name, $default = null) {
    return isset($_REQUEST[$name]) ? esc_html( trim($_REQUEST[$name]) ) : $default;
  }

  public function redirect($url) {
    echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
    exit();
  }
  
}