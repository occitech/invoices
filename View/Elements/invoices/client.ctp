<div class="client" style="text-align: right;">
	<span class="name"><?php echo h($invoice['Invoice']['client_name']); ?></span><br />
	<?php if (!empty($invoice['Invoice']['client_company'])) : ?>
		<span class="name"><?php echo h($invoice['Invoice']['client_company']); ?></span><br />
	<?php endif; ?>
	<span class="address"><?php echo nl2br(h($invoice['Invoice']['client_address']));?></span>
</div>