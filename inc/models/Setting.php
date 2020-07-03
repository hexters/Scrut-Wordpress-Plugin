<?php 

  namespace App\Models;

  class Setting {

    public $email;
    public $key;
    public $price;

    public function __construct() {
      $data = $this->get_setting();
      if($data) {
        $this->email = $data['email'];
        $this->key = $data['api_key'];
        $this->price = $data['report_price'];
      }
    }
    
    private function get_setting() {
      try {
        global $wpdb;
        $setting = get_option('scrut_general_option');
        return unserialize($setting);
      } catch (\Exception $e) {}
      return null;
    }

    public function update($email, $key, $price) {
      global $wpdb;
      $data['email'] = esc_html( trim($email) );
      $data['api_key'] = esc_html( trim($key) );
      $data['report_price'] = esc_html( trim($price) );
      update_option( 'scrut_general_option', serialize($data) );
    }

  }