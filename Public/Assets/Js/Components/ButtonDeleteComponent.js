class ButtonDeleteComponent {

	static mount(referenceObject) {

		var _dataId 		= $(referenceObject).closest('[data-id]', document.getElementById('tr')).attr('data-id');
		var _dataSavePath 	= $(referenceObject).attr('data-save-path');

		if (!this.check(referenceObject, _dataId, _dataSavePath)) {
			return false;
		}

		$(referenceObject).html('<button><i class="material-icons">delete</i></button>');

		this.applyMaterialDesign(referenceObject);
		this.mountSaveEvent(referenceObject, _dataId, _dataSavePath);
	}

	static mountSaveEvent(referenceObject, _dataId, _dataSavePath) {

		var thisClass = this;

		$(referenceObject).find('button').bind('click', function() {
			
			var _deleteDialog = '\
				<dialog class="mdl-dialog deleteConfirmationDialog" style="width:400px;">\
					<h4 class="mdl-dialog__title">Delete Confirmation</h4>\
					<div class="mdl-dialog__content">\
						<p>Are you sure you want to delete this record? The operation cannot be un-done.</p>\
					</div>\
					<div class="mdl-dialog__actions">\
						<button type="button" class="mdl-button agree">DELETE</button>\
						<button type="button" class="mdl-button close">CANCEL</button>\
					</div>\
				</dialog>\
			';

			$('body').append(_deleteDialog);

			var dialog = document.querySelector('.deleteConfirmationDialog');

			if (!dialog.showModal) {
				dialogPolyfill.registerDialog(dialog);
			}

			dialog.showModal();

			dialog.querySelector('.close').addEventListener('click', function() {
				dialog.close();
				$('.deleteConfirmationDialog').remove();
			});

			dialog.querySelector('.agree').addEventListener('click', function() {
				AjaxService.call(config.webpath + _dataSavePath  + '/' + _dataId, 'DELETE', function(response) {
					$(referenceObject).parent().parent().remove(); // TODO :: how can you be sure you need to go up 2 levels? // try closest instead
					NotifierComponent.show(response.message, (response.success) ? 'success' : 'danger');

					thisClass.mountNoRecords();
				});

				dialog.close();

				$('.deleteConfirmationDialog').remove();
			});
		});
	}

	static check(referenceObject, _dataId, _dataSavePath) {

		var _componentOK = true;

		if (_dataId == undefined) {
			console.warn('Missing data-id attribute from "tr" tag. Value must be the id that you want to control.');
			_componentOK = false;
		}

		if (_dataSavePath == undefined) {
			console.warn('Missing data-save-path attribute from "tbody" tag. Value must be the QueryString without the ID param');
			_componentOK = false;
		}

		return _componentOK;
	}

	static applyMaterialDesign(referenceObject, rowIndex, columnIndex) {
		$(referenceObject).find('button').addClass('mdl-button mdl-js-button mdl-button--icon mdl-button--accent');
	}

	static mountNoRecords() {
		if ($('[data-grid] tbody').html().trim() == '') {
			$('[data-grid] tbody').append('<tr data-record="no"><td colspan="' + $('[data-grid] thead tr:first-child th').length + '" class="tac fb">There are no records.</td></tr>');
		}
	}

	static removeNoRecords() {
		$('[data-grid] tbody [data-record="no"]').remove();
	}
}