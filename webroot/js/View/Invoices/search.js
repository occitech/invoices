$(document).ready(function(){
	var dateInputSelector = '.date:not(.hasDatepicker)';
	$.datepicker.setDefaults($.datepicker.regional['fr']);

	$(dateInputSelector).each(function(){
		var $self = $(this),
			altFieldSelector = '[name="' + $self.attr('name').replace('[fake_', '[') + '"]';

		$self.attr('name','');
		if ($(altFieldSelector).val()) {
			$self.val($.datepicker.formatDate('dd/mm/yy', new Date($(altFieldSelector).val())));
		}

		$self.datepicker({altField: $(altFieldSelector), altFormat: 'yy-mm-dd'});
	});
});