<div class="scrut">
  <?php if(is_object($chassis)): ?>
  <table width="100%" class="table-result">
    <tbody>
      <tr>
        <td width="25%"><img src="<?php echo $chassis->image ?>"></td>
        <td width="75%" style="text-align:left;">
          <strong><?php echo $chassis->chassis_no ?></strong>
          <div><?php echo $chassis->year ?></div>
          <div><?php echo $chassis->car_color ?></div>
          <div><?php echo $chassis->transmission ?></div>
          <div><?php echo $chassis->car_grade ?></div>
        </td>
      </tr>
    </tbody>
  </table>
    
    

  <form action="<?php echo admin_url( 'admin-post.php' ) ?>" method="POST">
    <input type="hidden" name="action" value="scrut-post-checkout">
    
      <button value="cancel" name="type">Cancel</button> 
      <button name="type" value="submit">Submit</button>
    
  </form>

  <?php else: ?>

    <h4>No Report selected</h4>
    <a href="<?php echo get_permalink( get_page_by_path( 'scrut-check' )) ?>">&larr; Back to Check Page</a>

  <?php endif; ?>
</div>