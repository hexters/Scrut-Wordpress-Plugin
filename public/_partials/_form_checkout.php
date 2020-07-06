<?php if( ! is_user_logged_in(  ) ): ?>
  <div class="scrut-error">
    <p>You must be registered to buy this report</p>
  </div>
<?php endif; ?>
<div class="form-group">
  <label for="display_name">Full Name <span class="text-danger">*</span></label>
  <div><input type="text" class="form-control" name="display_name" value="<?php echo $user->display_name ?>" id="display_name" required></div>
</div>

<div class="form-group">
  <label for="user_email">Email Address <span class="text-danger">*</span></label>
  <div><input type="text" class="form-control" name="user_email" id="user_email" value="<?php echo $user->user_email ?>" required></div>
</div>

<div class="form-group">
  <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
  <div><input type="text" class="form-control" name="phone_number" id="phone_number" required></div>
</div>

<?php if( ! is_user_logged_in(  ) ): ?>
  <div class="form-group">
    <label for="password">Password <span class="text-danger">*</span></label>
    <div><input type="password" class="form-control" name="user_pass" id="password" required></div>
  </div>
  <div>Do you have an account, <a href="<?php echo get_permalink( get_page_by_path( 'scrut-account' ) ) ?>">Login?</a></div>
<?php endif; ?>