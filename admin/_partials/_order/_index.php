<table class="wp-list-table widefat fixed striped posts" style="margin:1rem 0;">
    <thead>
      <tr>
        <th width="15%" class="manage-column sortable <?php echo $paginate->getShort('transaction_number') ?>"> <?php echo $paginate->head('transaction_number', 'Order No.') ?> </th>
        <th width="15%" class="manage-column sortable <?php echo $paginate->getShort('name') ?>"> <?php echo $paginate->head('name', 'Name') ?> </th>
        
        <th width="15%" class="manage-column sortable <?php echo $paginate->getShort('chassis_no') ?>"><?php echo $paginate->head('chassis_no', 'Chassis No.') ?></th>
        <th width="10%" class="manage-column sortable <?php echo $paginate->getShort('created_at') ?>"><?php echo $paginate->head('created_at', 'Date') ?></th>
        <th width="10%" class="manage-column sortable <?php echo $paginate->getShort('payment_name') ?>"><?php echo $paginate->head('payment_name', 'method') ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($orders as $order): ?>
        <tr>
          <td>
            <strong>
              <a href="<?php echo admin_url( 'admin.php?page=scrut_order&section=detail&id=' . $order->id ) ?>"><?php echo $order->transaction_number ?></a>
            </strong>
          </td>
          <td>
            <strong>
              <a href="<?php echo admin_url("/user-edit.php?user_id={$order->user_id}") ?>">
                <?php echo $order->name ?>
              </a>
            </strong>
            <div><?php echo $order->email ?></div>
            <div><?php echo $order->phone_number ?></div>
          </td>
          
          <td><?php echo $order->chassis_no ?></td>
          <td class="date column-date" data-colname="date">
            <?php echo ucwords($order->state ) ?> <br>
            <span title="<?php echo mysql2date( get_option( 'date_format' ), $order->created_at ) ?>"><?php echo mysql2date( get_option( 'date_format' ), $order->created_at ) ?></span>
          </td>
          
          <td><?php echo $order->payment_name ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <th class="manage-column sortable <?php echo $paginate->getShort('transaction_number') ?>"> <?php echo $paginate->head('transaction_number', 'Order No.') ?> </th>
        <th class="manage-column sortable <?php echo $paginate->getShort('name') ?>"> <?php echo $paginate->head('name', 'Name') ?> </th>
        
        <th class="manage-column sortable <?php echo $paginate->getShort('chassis_no') ?>"><?php echo $paginate->head('chassis_no', 'Chassis No.') ?></th>
        <th class="manage-column sortable <?php echo $paginate->getShort('created_at') ?>"><?php echo $paginate->head('created_at', 'Date') ?></th>
        <th class="manage-column sortable <?php echo $paginate->getShort('payment_name') ?>"><?php echo $paginate->head('payment_name', 'method') ?></th>
      </tr>
    </tfoot>
  </table>

  <div class="text-right">
    <?php echo $paginate->render(); ?>
  </div>