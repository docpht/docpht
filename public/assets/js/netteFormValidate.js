function showErrors(errors, focus)
{
	errors.forEach(function(error) {
		if (error.message) {
			$(error.element).closest('tr').addClass('has-error').find('.error').remove();
			$('<span class=error>').text(error.message).insertAfter(error.element);
		}

		if (focus && error.element.focus) {
			error.element.focus();
			focus = false;
		}
	});
}

function removeErrors(elem)
{
	if ($(elem).is('form')) {
		$('.has-error', elem).removeClass('has-error');
		$('.error', elem).remove();
	} else {
		$(elem).closest('tr').removeClass('has-error').find('.error').remove();
	}
}

Nette.showFormErrors = function(form, errors) {
	removeErrors(form);
	showErrors(errors, true);
};