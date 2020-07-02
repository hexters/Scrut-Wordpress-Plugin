<?php 

class ScrutPaymentGateway {
  
  public $title;

  public function render() {
    return $this->html();
  }

  public function html() {
    extract([
      'title' => $this->title
    ]);
    require( SCRUT__PLUGIN_DIR . './public/payment_widget.php' );
  }

}