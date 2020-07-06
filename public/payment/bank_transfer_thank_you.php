<?php 
  $option = unserialize(get_option('scrut_payment_method_' . $this->id, []));
?>

<div style="min-height:800px;">

  <h1>Thank You</h1>
  <p>
    Your order number is <strong>#<?php echo $order->transaction_number ?></strong>.
  </p>
  <p>
    Please make your payment to:
    <address>
      <strong>Bank Name</strong>
      <div><?php echo @$option['bank_name'] ?></div>
      <strong>Bank Account Name</strong>
      <div><?php echo @$option['bank_account_name'] ?></div>
      <strong>Bank Account Number</strong>
      <div><?php echo @$option['bank_account_number'] ?></div>
    </address>
  </p>

  <p>Once you make a payment, Please confirm you payment to <a href="tel:<?php echo @$option['confirmation_phone_number'] ?>"><?php echo @$option['confirmation_phone_number'] ?></a> <?php echo isset($option['confirmation_email']) ? 'or ' . $option['confirmation_email'] : null ?></p>
  <hr>
  <a href="<?php echo get_permalink( get_page_by_path( 'scrut-account' )) ?>"> Go to Account Page &rarr;</a>

</div>