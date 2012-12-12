<div class="compagny">
	<span class="name"><?php echo nl2br(h($invoiceSettings['name'])); ?></span><br />
	<span class="address"><?php echo nl2br(h($invoiceSettings['address'])); ?></span><br />
	<span class="vat"><?php
		echo __d('invoices', 'Intra VAT: %s', h($invoiceSettings['vat']));
	?></span><br />
	<span class="siret"><?php
		echo __d('invoices', 'SIRET: %s', h($invoiceSettings['siret']));
	?></span>
</div>