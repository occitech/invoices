<?php
/**
 * Displays a list of invoices
 *
 * @param array $invoices Non empty invoices list with invoices lines
 */
?>
<ul>
	<?php foreach ($invoices as $invoice) : ?>
	<li>
		<div class="setting">
			<div class="setting-description">
				<h3><?php echo ucfirst(strftime("%B %Y", strtotime($invoice['Invoice']['created']))); ?></h3>
				<p><?php echo $invoice['InvoiceLine'][0]['product_name'] ?></p>
			</div>
			<div>
				<?php
					echo $this->Html->link(
						'Donwload the pdf',
						array(
							'plugin' => 'invoices',
							'controller' => 'invoices',
							'action' => 'view',
							'ext' => 'pdf',
							$invoice['Invoice']['id']
						),
						array('target' => '_blank')
					);
				?>
			</div>
			<div>
				<?php
					echo $this->Html->link(
						'See the invoice',
						array(
							'plugin' => 'invoices',
							'controller' => 'invoices',
							'action' => 'view',
							$invoice['Invoice']['id']
						),
						array('target' => '_blank')
					);
				?>
			</div>
		</div>
	</li>
	<?php endforeach; ?>
</ul>
<?php echo $this->element('paging', array('plugin' => 'invoices')); ?>