<?php
/**
 * Generic pagination element to allow the developer to have a more homogeneous markup
 *
 * @param PaginatorHelper $Paginator Custom paginator helper
 */
?>
<?php
	if (empty($Paginator) || !is_a($Paginator, 'PaginatorHelper')) :
		$Paginator = $this->Paginator;
	endif;
?>
<?php if ($Paginator->hasNext() || $Paginator->hasPrev()): ?>
	<div class="paging">
		<?php echo $Paginator->prev(__d('invoices', '< prev', true), array(), null, array('class' => 'disabled'));?>
		<?php echo $Paginator->numbers(array('separator' => ' '));?>
		<?php echo $Paginator->next(__d('invoices', 'next >', true), array(), null, array('class' => 'disabled'));?>
	</div>
<?php endif; ?>