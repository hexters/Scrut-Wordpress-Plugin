<?php 

namespace App;

class Payment {

  public $gateway;

  public function __construct($gateway) {
    $this->gateway = $gateway;
    $this->gateway->id = 'bank_transfer';
    $this->gateway->title = 'Bank Transfer';
    $this->gateway->description = 'You can buy report with bank transfer';
    $this->gateway->thumbnail = 'https://banner2.cleanpng.com/20180715/cyg/kisspng-maybank-finance-money-permodalan-nasional-berhad-interior-design-logo-5b4b262dc97c16.6278887015316516298253.jpg';

    add_action( 'add_scrut_payment_gateway', [$this, 'add_scrut_payment_gateway'] );

  }

  public function add_scrut_payment_gateway() {
    scrut_payment_gateway_init($this->gateway);
  }





}