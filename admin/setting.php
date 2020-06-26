<div class="wrap">
  <h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>
  <?php if(array_key_exists('message', $_SESSION)): ?>  
    <div class="updated notice is-dismissible">
      <p><?php echo $_SESSION['message'] ?></p>
      <button class="notice-dismiss" type="button"></button>
    </div>
  <?php endif; ?>
  <?php if(array_key_exists('error', $_SESSION)): ?>
    <div class="error notice is-dismissible">
      <p><?php echo $_SESSION['error'] ?></p>
    </div>
  <?php endif; ?>
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
          <input type="text" placeholder="xxxxxxxx-xxxx-xxxxx-xxxxx-xxxxxxxx" name="key" value="<?php echo $data->key ?>" id="key" class="regular-text" required>
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
    </table>
    
    <button class="button button-primary">Save Change</button>
    <input type="hidden" name="action" value="scrut-post-setting">

  </form>
  
</div>

