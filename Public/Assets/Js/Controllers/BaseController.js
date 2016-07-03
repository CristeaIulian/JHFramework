class BaseController {

	constructor() {
		this.showPresetMessage();
		this.handleAddButton();
		this.attachDatagridEvents();
		this.handleValidation();
		this.handleProfileDialog();
	}

	showPresetMessage() {

		if (typeof _message != 'undefined'){
			NotifierComponent.show(_message, _message_type);
		}
	}

	attachDatagridEvents() {

		$('[data-grid]').addClass('data-grid mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp');

		$('[data-grid] thead').find('[data-record="info"]').hide();

		$('[data-grid] tbody').find('[data-object="text-input"]').each(function(){
			TextboxEditorComponent.mount($(this));
		});

		$('[data-grid] tbody').find('[data-object="button-on-off"]').each(function(){
			ButtonOnOffComponent.mount($(this));
		});

		$('[data-grid] tbody').find('[data-object="button-delete"]').each(function(){
			ButtonDeleteComponent.mount($(this));
		});

		$('[data-grid] tbody').find('[data-object="select"]').each(function(){
			SelectComponent.mount($(this));
		});

		this.mountNoRecords();
	}

	mountNoRecords() {
		if ($('[data-grid] tbody').html().trim() == '') {
			$('[data-grid] tbody').append('<tr data-record="no"><td colspan="' + $('[data-grid] thead tr:first-child th').length + '" class="tac fb">There are no records.</td></tr>');
		}
	}

	removeNoRecords() {
		$('[data-grid] tbody [data-record="no"]').remove();
	}

	handleAddButton() {

		var thisClass = this;

		$('[data-grid] thead').find('[data-record="new"]').hide();


		
		$('body').find('[data-button="add-new-record"]')
			.html('<button class="addButton mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--primary"><i class="material-icons">add</i></button>')
			.bind('click', function() {

				AjaxService.call(config.webpath + $('[data-grid] thead').find('[data-record="new"]').attr('data-save-path'), 'post', function(response) {

					$('[data-grid] tbody').prepend($('[data-grid] thead').find('[data-record="new"]').clone());

					$('[data-grid] tbody').find('[data-record="new"]').attr('data-id', response.newId).removeAttr('data-save-path');

					$('[data-grid] tbody').find('[data-record="new"]').find('[data-object="label-id"]').html(response.newId);

					$('[data-grid] tbody').find('[data-record="new"]').find('[data-object="text-input"]').each(function(){
						TextboxEditorComponent.mount($(this));
					});

					$('[data-grid] tbody').find('[data-record="new"]').find('[data-object="button-on-off"]').each(function(){
						ButtonOnOffComponent.mount($(this));
					});

					$('[data-grid] tbody').find('[data-record="new"]').find('[data-object="button-delete"]').each(function(){
						ButtonDeleteComponent.mount($(this));
					});

					$('[data-grid] tbody').find('[data-record="new"]').find('[data-object="select"]').each(function(){
						SelectComponent.mount($(this));
					});

					componentHandler.upgradeDom();

					$('[data-grid] tbody').find('[data-record="new"]')
						.attr('data-record', 'existing')
						.prepend('<td></td>')
						.show();

					thisClass.removeNoRecords();

					NotifierComponent.show(response.message, (response.success) ? 'success' : 'danger');
				});
			});
	}

	handleValidation() {
		$('[data-grid] tbody').find('[data-validate]').each(function() {
			ValidationService.check($(this));
		});
	}

	handleProfileDialog() {

		var dialog = document.querySelector('#profileDialog');

		var showDialogButton = document.querySelector('[data-modal-opener="myProfile"]');

		if (! dialog.showModal) {
			dialogPolyfill.registerDialog(dialog);
		}
		showDialogButton.addEventListener('click', function() {
			dialog.showModal();
		});
		dialog.querySelector('.discard').addEventListener('click', function() {
			dialog.close();
		});

		dialog.querySelector('.update').addEventListener('click', function() {


			$('#userProfilePasswordAlert').remove(); // if exists
			$('#userProfilePasswordRepeatAlert').remove(); // if exists

			if ($('#window_user_password').val() == '') {
				$('#window_user_password').parent().append('<div class="alert alert-danger" id="userProfilePasswordAlert" role="alert">Password must not be empty.</div>');
			}

			if ($('#window_user_password_repeat').val() == '') {
				$('#window_user_password_repeat').parent().append('<div class="alert alert-danger" id="userProfilePasswordRepeatAlert" role="alert">Password repeat must not be empty.</div>');
			}

			if ($('#window_user_password').val() == '' || $('#window_user_password_repeat').val() == '') {
				return false;
			}

			if ($('#window_user_password').val() != $('#window_user_password_repeat').val()) {
				$('#window_user_password_repeat').parent().append('<div class="alert alert-danger" id="userProfilePasswordRepeatAlert" role="alert">Password repeat must match password.</div>');
				return false;
			}


			AjaxService.call(config.webpath + 'Users/ProfileExec', 'post', function(response) {

				NotifierComponent.show(response.message, (response.success) ? 'success' : 'danger');

				dialog.close();

			}, { password:$('#window_user_password').val() });

			return false;
		});
	}
}