<?php 

class ScrutOrder {

  public $id = 0;

  public function whereID($id) {
    global $wpdb;
    $sql = "SELECT * FROM {$wpdb->prefix}scrut_report_order WHERE id = " . $id;
    $query = $wpdb->get_row($sql);
    return $query;
  }

}