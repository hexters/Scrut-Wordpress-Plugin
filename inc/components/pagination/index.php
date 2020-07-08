<div class="scrut-pagination">
  Total <?php echo $this->total ?>
  <?php if($this->total > $this->getPerPage()): ?>
    Page <?php echo $this->getCurrentPage() ?> of <?php echo $this->totalPage() ?>
    <ul>
      <?php if(!$this->isFirstPage()): ?>
        <li>
          <a href="<?php echo $this->prev() ?>">&lsaquo;</a>
        </li>
        <li>
          <a href="<?php echo $this->firstPage() ?>">&laquo;</a>
        </li>
        <li>
          <span>...</span>
        </li>
      <?php else: ?>
        <li>
          <span>&lsaquo;</span>
        </li>
        <li>
          <span>&laquo;</span>
        </li>
      <?php endif; ?>
      <?php for($i = $this->pageStart(); $i <= $this->totalShowing(); $i++): ?>
        <?php if($this->showing_page_link): ?>
          <li class="<?php echo $this->isCurrentPage($i) ? 'current-page' : '' ?>">
            <a href="<?php echo $this->link($i); ?>"><?php echo $i; ?></a>
          </li>
        <?php endif; ?>
      <?php endfor; ?>
      <?php if(!$this->isLastPage()): ?>
        <li>
          <span>...</span>
        </li>
        <li>
          <a href="<?php echo $this->lastPage() ?>">&raquo;</a>
        </li>
        <li>
          <a href="<?php echo $this->next() ?>">&rsaquo;</a>
        </li>
      <?php else: ?>
        <li>
          <span>&raquo;</span>
        </li>
        <li>
          <span>&rsaquo;</span>
        </li>
      <?php endif; ?>
    </ul>
  <?php endif; ?>
</div>