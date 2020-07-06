<tr>
  <td class="text-center">
    <img src="<?php echo $this->thumbnail ?>" width="30">
  </td>
  <td class="text-left">
    <a href="<?php echo admin_url( 'admin.php?page=scrut_setting&tab=payment&section=form&payment_id=' . $this->id ) ?>">
      <strong><?php echo $this->title ?></strong>
    </a>
  </td>
  <td class="text-center">
    <input type="checkbox" name="payment_status[<?php echo $this->id ?>]">
  </td>
  <td class="text-center"><?php echo $this->id ?></td>
</tr>