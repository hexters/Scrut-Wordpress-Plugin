<tr>
  <td class="text-left">
    <a href="<?php echo admin_url( 'admin.php?page=scrut_setting&tab=payment&section=form&payment_id=' . $this->id ) ?>">
      <strong><?php echo $this->title ?></strong>
    </a>
  </td>
  <td class="text-center">
  <?php echo in_array($this->id, $this->actives) ? 'Enabled' : 'Disabled' ?>
  </td>
  <td class="text-left"><?php echo $this->description ?></td>
  <td class="text-right">
  <a class="button button-default" href="<?php echo admin_url( 'admin.php?page=scrut_setting&tab=payment&section=form&payment_id=' . $this->id ) ?>">Set Up</a>
</td>
</tr>