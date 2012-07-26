<?php
/**
 * Partial to render a search form for invoices
 */
?>
<?= $this->Form->create('Invoice', array(
	'inputDefaults' => array('preset' => 'search', 'label' => false),
	'class' => 'search-form'
)) ?>
<fieldset class="well">
	<?=
		/* TODO add a datepicker and remove format from label */
		$this->Form->iconizedInput('created', array(
			'class' => 'input-medium',
			'placeholder' => __d('invoices', 'Date (YYYY-mm-dd)'),
			'prepend' => '<i class="icon-calendar"></i>',
			'type' => 'text'
		)) .
		$this->Form->iconizedInput('client_name', array(
			'class' => 'input-medium',
			'placeholder' => __d('invoices', 'Client name'),
			'prepend' => '<i class="icon-user"></i>'
		)) .
		$this->Form->iconizedInput('min_price', array(
			'class' => 'input-mini',
			'min' => 0,
			'placeholder' => __d('invoices', 'Min.'),
			'prepend' => __d('invoices', 'Price €'),
			'type' => 'number',
		)) .
		$this->Form->input('max_price', array(
			'class' => 'input-mini',
			'min' => 0,
			'placeholder' => __d('invoices', 'Max.'),
			'type' => 'number'
		)) .
		$this->Form->submit(__d('invoices', 'Search'), array('div' => false))
	?>
</fieldset>
<?= $this->Form->end() ?>