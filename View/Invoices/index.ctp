<?php
	$title = __d('invoices', 'All Invoices');
	$this->set('title_for_layout', $title);
?>
<div class="invoices page index">
	<div class="page-header">
		<h1><?= $title; ?></h1>
	</div>

	<?php echo $this->Partial->render('search_form') ?>

	<?php if (empty($invoices)) : ?>
		<div class="message call-to-action">
			<p>
				<?= __d('invoices', 'No invoices match your criteria.'); ?>
			</p>
		</div>
	<?php else : ?>
		<table cellpadding="0" cellspacing="0" class="table">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('created', __d('invoices', 'Date'));?></th>
					<th><?php echo $this->Paginator->sort('global_price', __d('invoices', 'Total Incl. Taxes'));?></th>
					<th class="actions"><?php echo __d('invoices', 'Actions');?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($invoices as $invoice) : ?>
				<tr>
					<td>
						<?php echo ucwords(strftime(
							__d('invoices', '%B %d %Y'),
							strtotime($invoice['Invoice']['created'])
						)); ?>&nbsp;
					</td>
					<td><?php echo $this->InvoiceDecorator->price($invoice['Invoice']['global_price']); ?>&nbsp;</td>
					<td class="actions">
						<?php
							$viewUrl = array(
								'controller' => 'invoices',
								'action' => 'view',
								$invoice['Invoice']['id']
							);
							echo $this->Html->link(
								__d('invoices', 'Download (PDF)', true),
								$viewUrl + array('ext' => 'pdf'),
								array('target' => '_blank')
							) .
							$this->Html->link(
								__d('invoices', 'See', true),
								$viewUrl,
								array('target' => '_blank')
							)
						?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php echo $this->element('paging'); ?>
	<?php endif; ?>
</div>