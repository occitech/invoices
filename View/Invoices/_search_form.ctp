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
		$this->Form->dateInput('created', array(
			'class' => 'input-medium',
			'placeholder' => __d('invoices', 'Date'),
			'prepend' => '<i class="icon-calendar"></i>',
			'append' => '',
			'type' => 'text'
		))
	?>
	<?php
		if($isAdminArea) :
			echo $this->Form->iconizedInput('client_name', array(
				'class' => 'input-medium',
				'placeholder' => __d('invoices', 'Client name'),
				'prepend' => '<i class="icon-user"></i>'
			));
		endif;
	?>
	<?=
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