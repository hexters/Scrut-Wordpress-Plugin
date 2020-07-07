<?php 

abstract class ScrutPaymentGateway {
  
  public $id;
  public $title;
  public $description;
  public $thumbnail;
  public $orders;
  public $actives = [];

  public static $UNPAID = 'unpaid';
  public static $PROCCESS = 'process';
  public static $PAID = 'paid';

  abstract public function proccess_payment( $order_id );
  
  abstract public function init_form_fields( );
  
  /**
   * Payment callback from 3rd party return teh payment to /scrut-checkout
   *
   * @return void
   */
  abstract public function payment_callback_proccess();

  public function __construct() {
    $this->orders = new ScrutOrder();
    $this->actives = (Array) unserialize(get_option('scrut_payment_methods', serialize([])));
    
    add_action( 'add_scrut_payment_gateway', [$this, 'add_scrut_payment_gateway'] );
    add_action( 'scrut_report_order_payment_process', [$this, 'current_proccess_payment'], 5, 2 );
    add_action( 'scrut_payment_gateway_response_callback', [$this, 'page_payment_callback_proccess'] );
    add_action( 'scrut_admin_setting_list',[$this, 'scrut_admin_setting_list'] );
    add_action( 'scrut_admin_setting_form',[$this, 'admin_setting_form'] );
  }

  public function redirect_to_callback($params = []) {
    $query = http_build_query( array_merge($params, ['payment_id' => $this->id]) );
    $url = get_permalink( get_page_by_path( 'scrut-checkout' ) ) . '?' . $query;
    echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
    exit();
  }

  public function settings($arg = null) {
    $option = (Array) unserialize(get_option('scrut_payment_method_' . $this->id, serialize([])));
    if($arg) {
      return isset($option[$arg]) ? $option[$arg] : null;
    }
    return $option;
  }

  public function scrut_admin_setting_list() {
    $payment_option = unserialize(get_option('scrut_payment_methods'));
    require( SCRUT__PLUGIN_DIR . '/admin/payment/admin_setting_list.php' );
  }

  public function admin_setting_form() {

    if(!$this->request('payment_id')){
      echo 'Payment method not found!';
      exit();
    }

    if(!in_array($this->request('payment_id'), [$this->id]))
      return;

    if(!is_array($this->init_form_fields())){
      echo 'Format fields is wrong!';
      exit();
    }

    $fields = $this->init_form_fields();
    require_once( SCRUT__PLUGIN_DIR . '/admin/payment/admin_setting_form.php' );
  }

  public function add_scrut_payment_gateway() {
    $this->render();
  }

  public function current_proccess_payment($order_id, $payment_id) {
    if(! ($this->id == $payment_id) ) {
      return;
    }
    $this->proccess_payment( $order_id );
    
    exit;
  }

  public function page_payment_callback_proccess() {

    $this->payment_callback_proccess();
    
  }

  public function render() {
    if(!in_array($this->id, $this->options())) {
      return;
    }

    extract([
      'id' => $this->id,
      'title' => $this->title,
      'description' => $this->description,
      'thumbnail' => $this->thumbnail,
    ]);
    require( SCRUT__PLUGIN_DIR . './public/payment/payment_widget.php' );
  }
  
  public function request($name, $default = null) {
    return isset($_REQUEST[$name]) ? trim($_REQUEST[$name]) : $default;
  }
  
  private function options() {
    return unserialize(get_option( 'scrut_payment_methods', serialize([]) ));
  }

}