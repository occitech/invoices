<?php
/**
 * Displays the details (lines + prices) of an invoice
 *
 * @param array $invoice Non empty invoice list with invoices lines
 */
	$totalExclTaxes = 0;
	$totalInclTaxes = 0;
	$totalTva = array();
	$stylePrice = 'style="text-align: right;"';
?>
<table cellpadding="0" cellspacing="0" class="table" id="invoices-table">
	<thead>
		<tr>
			<th><?php echo __d('invoices', 'Product'); ?></th>
			<th <?php echo $stylePrice; ?>><?php echo __d('invoices', 'Price'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($invoice['InvoiceLine'] as $invoiceLine) : ?>
			<?php
				$priceInclTaxes = $invoiceLine['excl_tax_price'] + $invoiceLine['tva_price'];
				$totalExclTaxes += $invoiceLine['excl_tax_price'];
				$totalInclTaxes += $priceInclTaxes;
				if (empty($totalTva[strval($invoiceLine['tva_rate'])])) {
					$totalTva[strval($invoiceLine['tva_rate'])] = $invoiceLine['tva_price'];
				} else {
					$totalTva[strval($invoiceLine['tva_rate'])] += $invoiceLine['tva_price'];
				}
			?>
			<tr>
				<td>
					<?php echo $invoiceLine['product_name']; ?>
				</td>
				<td <?php echo $stylePrice; ?>>
					<?php echo $this->InvoiceDecorator->price($priceInclTaxes); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<th><b><?php echo __d('invoices', 'Total Excl. Taxes'); ?></b></th>
			<th <?php echo $stylePrice; ?>><?php echo $this->InvoiceDecorator->price($totalExclTaxes); ?></th>
		</tr>
		<?php foreach ($totalTva as $rate => $total) : ?>
			<tr>
				<?php $rate = trim(number_format($invoiceLine['tva_rate'], 10), '0'); ?>
				<th><b><?php echo __d('invoices', 'TVA %s%%', $rate * 100); ?></b></th>
				<th <?php echo $stylePrice; ?>><?php echo $this->InvoiceDecorator->price($total); ?></th>
			</tr>
		<?php endforeach; ?>
		<tr>
			<th><b><?php echo __d('invoices', 'Total Incl. Taxes'); ?></b></th>
			<th <?php echo $stylePrice; ?>><?php echo $this->InvoiceDecorator->price($totalInclTaxes); ?></th>
		</tr>
	</tfoot>
</table>