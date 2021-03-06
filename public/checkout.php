<div class="scrut">
  <div class="checkout">
    <?php if(is_object($chassis)): ?>
    <form action="<?php echo admin_url( 'admin-post.php' ) ?>" method="POST">
      <div class="row">
        <div class="col-lg-6">
          <h4 style="margin-top:0; margin-bottom:1rem;">Order Detail</h4>
          <?php 

              if(is_user_logged_in(  )) {
                $user = wp_get_current_user(  );
              } else {
                $user = new Wp_user;
              }

              require_once( __DIR__ . '/_partials/_form_checkout.php' );
            ?>
        </div>
        <div class="col-lg-6 ">
          <h4 style="margin:0;">Sumarry</h4>
          <div class="summary">
            <div class="order-item">
              <img src="<?php echo $chassis->image ?>" width="100%" />
              <strong><?php echo $chassis->chassis_no ?></strong>
              <div><?php echo $chassis->year ?></div>
              <div><?php echo $chassis->car_color ?></div>
              <div><?php echo $chassis->transmission ?></div>
              <div style="border-bottom:1px solid #ddd; margin:1rem 0;"></div>
              <div style="text-align:right;">
                <strong style="float:left;">Total</strong>
                <strong>RM <?php echo $chassis->price ?></strong>
              </div>
              <input type="hidden" name="chassis_no" value="<?php echo $chassis->chassis_no ?>">
              <input type="hidden" name="chassis_key" value="<?php echo $chassis->key ?>">
            </div>

            <div class="payment">
              <?php echo do_action('add_scrut_payment_gateway', 5, 1); ?>
            </div>
          </div>

            <input type="hidden" name="action" value="scrut-post-checkout">
            <button value="cancel" name="type">Cancel</button>
            <button name="type" value="submit" class="btn-pay">Pay Now</button>
        </div>
      </div>
    </form>




    <?php else: ?>

    <h4>No Report selected</h4>
    <a href="<?php echo get_permalink( get_page_by_path( 'scrut-check' )) ?>">&larr; Back to Check Page</a>

    <?php endif; ?>
  </div>
</div>