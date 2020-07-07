<?php 

namespace App;
use \ScrutPaymentGateway;

class Payment extends ScrutPaymentGateway {

  public function __construct() {
    parent::__construct();

    $this->id = 'bank_transfer';
    $this->title = 'Bank Transfer';
    $this->description = 'Take payments in person via BACS. More commonly known as direct bank/wire transfer';
  }

  public function init_form_fields() {
    return [
      'disabled' => [
        'title' => __('Disabled/Enabled', 'scrut'),
        'label' => __('Bank Transfer', 'scrut'),
        'type' => 'checkbox',
        'placeholder' => '',
        'description' => null,
        'class' => '',
        'required' => false,
        'default_value' => 'no'
      ],
      
      'bank_name' => [
        'title' => __('Bank Name', 'scrut'),
        'type' => 'text',
        'placeholder' => __('Bank Name', 'scrut'),
        'description' => '',
        'class' => '',
        'required' => true,
      ],

      'bank_account_name' => [
        'title' => __('Bank Account Name', 'scrut'),
        'type' => 'text',
        'placeholder' => __('Bank Account Name', 'scrut'),
        'description' => '',
        'class' => '',
        'required' => true,
      ],

      'bank_account_number' => [
        'title' => __('Bank Account Number', 'scrut'),
        'type' => 'text',
        'placeholder' => __('Bank Account Number', 'scrut'),
        'description' => '',
        'class' => '',
        'required' => true,
      ],

      'confirmation_phone_number' => [
        'title' => __('Phone Confirmation', 'scrut'),
        'type' => 'text',
        'placeholder' => __('Phone Number Confirmation', 'scrut'),
        'description' => '',
        'class' => '',
        'required' => true,
      ],

      'confirmation_email' => [
        'title' => __('Email Confirmation', 'scrut'),
        'type' => 'text',
        'placeholder' => __('Email Confirmation', 'scrut'),
        'description' => '',
        'class' => '',
        'required' => false,
      ],

      'description' => [
        'title' => __('Description', 'scrut'),
        'type' => 'textarea',
        'placeholder' => __('Description', 'scrut'),
        'description' => '',
        'class' => '',
        'default_value' => 'Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be accepted until the funds have cleared in our account.',
      ],
    ];
  }

  public function proccess_payment( $order_id ) {
    return $this->redirect_to_callback([
      'status' => 'success',
      'order_id' => $order_id
    ]);
  }

  public function payment_callback_proccess() {
    if(!in_array($this->request('payment_id'), ['bank_transfer']))
      return;

    if(!$this->request('order_id'))
      return;
    
    $order = $this->orders->whereID($this->request('order_id'));
    require_once( SCRUT__PLUGIN_DIR . '/public/payment/bank_transfer_thank_you.php' );
    
    exit();
  }
  
}