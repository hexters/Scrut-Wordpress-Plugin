<?php 
  
function add_scrut_payment_gateway() {
  do_action('add_scrut_payment_gateway', 5, 1);
}

function scrut_payment_gateway_init(ScrutPaymentGateway $gateway) {
  echo $gateway->render();
}