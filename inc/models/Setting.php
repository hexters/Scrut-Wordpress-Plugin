<?php 

  namespace App\Models;

  class Setting {

    public $email;
    public $key;

    public function __construct() {
      $data = $this->get_setting();
      if($data) {
        $this->email = $data->email;
        $this->key = $data->api_key;
      }
    }
    
    private function get_setting() {
      try {
        global $wpdb;
        return $wpdb->get_row("SELECT email, api_key FROM {$wpdb->prefix}scrut_setting LIMIT 1");
      } catch (\Exception $e) {
        return null;
      }
    }

    public function update($email, $key) {
      global $wpdb;
      $data['email'] = esc_html( trim($email) );
      $data['api_key'] = esc_html( trim($key) );
      if($this->get_setting()) {
        return $wpdb->query("UPDATE {$wpdb->prefix}scrut_setting SET email = '" . $data['email'] . "', api_key = '" . $data['api_key'] . "' WHERE id > 0;");
      } else {
        return $wpdb->insert("{$wpdb->prefix}scrut_setting", $data);
      }
    }

  }