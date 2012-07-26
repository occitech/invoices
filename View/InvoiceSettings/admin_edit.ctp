<div class="invoiceSettings form">
<?php echo $this->Form->create('InvoiceSetting');?>
	<fieldset>
		<legend><?php echo __d('invoices', 'Edit Invoice Setting'); ?></legend>
		<?php echo $this->Form->input('value'); ?>
	</fieldset>
	<?php echo $this->Form->end(__d('invoices', 'Update'));?>
</div>
<div class="actions">
	<h3><?php echo __d('invoices', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('invoices', 'List Invoice Settings'), array('action' => 'index'));?></li>
	</ul>
</div>
