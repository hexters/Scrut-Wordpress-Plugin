<?php 
  $option = unserialize(get_option('scrut_payment_method_' . $this->id, serialize([])));
  $options = (Array) unserialize(get_option('scrut_payment_methods', serialize([])));
?>

<div>
  <a style="float:left;margin-right:1rem;margin-top:-.3rem;" href="<?php echo admin_url( '/admin.php?page=scrut_setting&tab=payment' ) ?>" class="button button-default">&larr; back</a>
  <h3> <?php echo $this->title ?> </h3>
</div>

<form action="<?php echo admin_url( '/admin-post.php' ) ?>" method="post">
  <table class="form-table">
    <tbody>
      <?php foreach($fields as $key => $field): ?>
        <tr>
          <th>
            <label for="<?php echo $key ?>"><?php echo @$field['title'] ?></label>
            <?php if(@$field['required']): ?>
              <span class="text-red">*</span>
            <?php endif; ?>
          </th>
          <td>
            <input 
              <?php echo (@$option['disabled'] == 'no') && in_array($this->id, $options) ? 'checked' : '' ?>
              value="<?php echo @$option[$key] ?>"
              type="<?php echo @$field['type'] ?>" 
              placeholder="<?php echo @$field['placeholder'] ?>" 
              name="<?php echo $key ?>" 
              id="<?php echo $key ?>" 
              class="regular-text <?php echo @$field['class'] ?>"
              <?php echo @$field['required'] == true ? 'required' : '' ?>
            />
            <label for="<?php echo $key ?>"><?php echo @$field['label'] ?></label>
            <p class="description"><?php echo @$field['description'] ?></p>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <button type="submit" class="button button-primary">Submit</button>
  <input type="hidden" name="action" value="scrut-payemnt-method-update">
  <input type="hidden" name="payment_id" value="<?php echo $this->id ?>">
</form>