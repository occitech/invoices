<?php if (!empty($invoice['Invoice']['payment_type'])) : ?>
<p class="mode-payment">
	<?php printf(__d('invoices', 'Payment mode: %s', true), $invoice['Invoice']['payment_type']); ?>
</p>
<?php endif; ?>