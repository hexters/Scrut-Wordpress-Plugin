<?php 

class ScrutPaymentGateway {
  
  public $id;
  public $title;
  public $description;
  public $thumbnail;

  public function render() {
    return $this->html();
  }

  public function html() {
    if(!in_array($this->id, $this->options())) {
      return;
    }

    extract([
      'id' => $this->id,
      'title' => $this->title,
      'description' => $this->description,
      'thumbnail' => $this->thumbnail,
    ]);
    require( SCRUT__PLUGIN_DIR . './public/payment_widget.php' );
  }

  private function options() {
    return unserialize(get_option( 'scrut_payment_methods', serialize([]) ));
  }

}