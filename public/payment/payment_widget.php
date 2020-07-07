<?php 
  $option = unserialize(get_option('scrut_payment_method_' . $this->id, serialize([])));
?>
<table class="table-list-payment">
  <tr>
    <td width="20%" valign="middle" style="text-align:center;">
      <input type="radio" data-scrut="payment-method" name="payment_id" value="<?php echo $id ?>" id="payment_<?php echo $id ?>" required>
    </td>
    <td>
      <label for="payment_<?php echo $id ?>">
        <strong><?php echo $title ?></strong>
      </label>
    </td>
    <td width="20%">
      <?php if($thumbnail): ?>
        <img src="<?php echo $thumbnail ?>" width="100">
      <?php endif; ?>
    </td>
  </tr>
</table>
<?php if(isset($option['description'])): ?>
  <div class="scrut-paymnet-method-description" data-scrut="payment-method-description-<?php echo $id ?>">
    <p><?php echo $option['description'] ?></p>
  </div>
<?php endif; ?>