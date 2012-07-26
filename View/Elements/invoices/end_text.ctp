<?php if (!empty($invoice['Invoice']['payment_type'])) : ?>
<p class="mode-payment">
	<?php printf(__d('invoices', 'Payment mode: %s', $invoice['Invoice']['payment_type'])); ?>
</p>
<?php endif; ?>