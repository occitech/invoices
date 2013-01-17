<?php
	$title = __d('invoices', 'Invoice Settings');
	$this->set('title_for_layout', $title);
?>
<div class="invoiceSettings index">
	<div class="page-header">
		<h1><?= $title; ?></h1>
	</div>

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
					<?php echo $this->Html->link(__d('invoices', 'Edit'), array('action' => 'edit', $invoiceSetting['InvoiceSetting']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php echo $this->element('paging'); ?>
</div>
<div class="actions">
	<h3><?= __d('invoices', 'Actions'); ?></h3>
	<ul>
		<li>
			<?= $this->Html->link(
				__d('invoices', 'List invoice'),
				array('controller' => 'invoices', 'action' => 'index')
			); ?>
		</li>
	</ul>
</div>