<div class="invoiceSettings index">
	<h2><?php echo __d('invoices', 'Invoice Settings');?></h2>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $this->Paginator->sort('name', __d('invoices', 'Name'));?></th>
			<th><?php echo $this->Paginator->sort('value', __d('invoices', 'Value'));?></th>
			<th class="actions"><?php echo __d('invoices', 'Actions');?></th>
		</tr>
		<?php foreach ($invoiceSettings as $invoiceSetting): ?>
			<tr>
				<td><?php echo h($invoiceSetting['InvoiceSetting']['name']); ?>&nbsp;</td>
				<td><?php echo nl2br(h($invoiceSetting['InvoiceSetting']['value'])); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__d('invoices', 'View'), array('action' => 'view', $invoiceSetting['InvoiceSetting']['id'])); ?>
					<?php echo $this->Html->link(__d('invoices', 'Edit'), array('action' => 'edit', $invoiceSetting['InvoiceSetting']['id'])); ?>
					<?php echo $this->Form->postLink(__d('invoices', 'Delete'), array('action' => 'delete', $invoiceSetting['InvoiceSetting']['id']), null, __d('invoices' ,'Are you sure you want to delete # %s?', $invoiceSetting['InvoiceSetting']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php echo $this->element('paging'); ?>
</div>