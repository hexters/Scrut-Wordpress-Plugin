<?php 

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
      global $wpdb;
      return $wpdb->get_row("SELECT email, api_key FROM {$wpdb->prefix}scrut_setting LIMIT 1");
    }

    public function update($email, $key) {
      global $wpdb;
      $data['email'] = $email;
      $data['api_key'] = $key;
      if($this->get_setting()) {
        return $wpdb->update("{$wpdb->prefix}scrut_setting", $data, ['id' => 1]);
      } else {
        return $wpdb->insert("{$wpdb->prefix}scrut_setting", $data);
      }
    }

  }