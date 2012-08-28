<?php
/**
 * Partial to render a search form for invoices
 */
	echo $this->Html->css('/Invoices/vendors/jquery-ui-1.8.23.custom/css/ui-lightness/jquery-ui-1.8.23.custom');
	$this->Html->script('/Invoices/js/View/Invoices/search', array('inline' => false));
	$this->Html->script('/Invoices/vendors/jquery-ui-1.8.23.custom/i18n/jquery.ui.datepicker-fr', array('inline' => false));
	$this->Html->script('/Invoices/vendors/jquery-ui-1.8.23.custom/jquery-ui-1.8.23.custom.min', array('inline' => false));
?>
<?= $this->Form->create('Invoice', array(
	'inputDefaults' => array('preset' => 'search', 'label' => false),
	'class' => 'search-form'
)) ?>
<fieldset class="well">
	<?=
		/* TODO add a datepicker and remove format from label */
		$this->Form->dateInput('created', array(
			'class' => 'input-medium date',
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