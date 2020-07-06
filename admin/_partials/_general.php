<form action="admin-post.php" method="post">
  <table class="form-table">
    <tr>
      <th><label for="email">Scrut Email <span style="color:red;">*</span></label></th>
      <td>
        <input type="email" placeholder="Scrut Email Account" name="email" id="email" value="<?php echo $data->email ?>" class="regular-text" required>
        <?php if(array_key_exists('email', $_SESSION)): ?>  
          <?php foreach($_SESSION['email'] as $error): ?>
            <div style="color:red;"><?php echo $error ?></div>
          <?php endforeach; ?>
          <?php endif; ?>
      </td>
    </tr>
    <tr>
      <th><label for="key">API Key <span style="color:red;">*</span></label></th>
      <td>
        <input type="password" placeholder="xxxxxxxx-xxxx-xxxxx-xxxxx-xxxxxxxx" name="key" value="<?php echo $data->key ?>" id="key" class="regular-text" required>
        <?php if(array_key_exists('key', $_SESSION)): ?>  
          <?php foreach($_SESSION['key'] as $error): ?>
            <div style="color:red;"><?php echo $error ?></div>
          <?php endforeach; ?>
        <?php endif; ?>
        <p class="description">
          <em>Get Api key in <a target="_blank" href="https://scrut.my/account"> account setting page</a> and put the API key above.</em>
        </p>
      </td>
    </tr>
    <tr>
      <th><label for="report_price">Report Price (RM) <span style="color:red;">*</span></label></th>
      <td>
        <input type="number" step="00.1" placeholder="Report Price" name="report_price" id="report_price" value="<?php echo $data->price ?>" class="regular-text" required>
        <?php if(array_key_exists('email', $_SESSION)): ?>  
          <?php foreach($_SESSION['email'] as $error): ?>
            <div style="color:red;"><?php echo $error ?></div>
          <?php endforeach; ?>
          <?php endif; ?>
      </td>
    </tr>
  </table>
  
  <button class="button button-primary">Save Change</button>
  <input type="hidden" name="action" value="scrut-post-setting">

</form>