<?php if( ! is_user_logged_in(  ) ): ?>
  <div class="scrut-error">
    <p>You must be registered to buy this report</p>
  </div>
<?php endif; ?>
<div class="form-group">
  <label for="display_name">Full Name <span class="text-danger">*</span></label>
  <input type="text" name="display_name" value="<?php echo $user->display_name ?>" id="display_name" required>
</div>

<div class="form-group">
  <label for="user_email">Email Address <span class="text-danger">*</span></label>
  <input type="text" name="user_email" id="user_email" value="<?php echo $user->user_email ?>" required>
</div>

<div class="form-group">
  <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
  <input type="text" name="phone_number" id="phone_number" required>
</div>

<?php if( ! is_user_logged_in(  ) ): ?>
  <div class="form-group">
    <label for="password">Password <span class="text-danger">*</span></label>
    <input type="password" name="user_pass" id="password" required>
  </div>
  <div>Do you have an account, <a href="<?php echo get_permalink( get_page_by_path( 'scrut-account' ) ) ?>">Login?</a></div>
<?php endif; ?>