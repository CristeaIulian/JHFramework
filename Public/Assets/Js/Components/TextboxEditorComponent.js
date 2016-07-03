class TextboxEditorComponent {

	static mount(referenceObject) {

		var _dataId 		= $(referenceObject).closest('[data-id]', document.getElementById('tr')).attr('data-id');
		var _dataSavePath 	= $(referenceObject).closest('[data-save-path]', document.getElementById('tbody')).attr('data-save-path');
		var _dataField 		= $(referenceObject).attr('data-field');
		var _dataValue		= (typeof $(referenceObject).attr('data-value') != 'undefined') ? $(referenceObject).attr('data-value') : '';
		var _dataValidation	= (typeof $(referenceObject).attr('data-validation') != 'undefined') ? $(referenceObject).attr('data-validation') : '';
		var _dataObjectType	= (typeof $(referenceObject).attr('data-object-type') != 'undefined') ? $(referenceObject).attr('data-object-type') : 'text';

		if (!this.check(referenceObject, _dataId, _dataField, _dataSavePath)) {
			return false;
		}

		switch (_dataObjectType) {
			case 'text':
			default:
				$(referenceObject).html('\
					<input type="text" value="' + _dataValue + '" ' + ((_dataValidation != '') ? 'data-validate="' + _dataValidation + '"' : '') + ' />\
					<label>' + _dataValue + '</label>\
				');
				break;
			case 'password':
				$(referenceObject).html('\
					<input type="password" value="" ' + ((_dataValidation != '') ? 'data-validate="' + _dataValidation + '"' : '') + ' />\
					<label>******</label>\
				');
				break;
		}

		this.applyMaterialDesign(referenceObject);
		this.mountSaveEvent(referenceObject, _dataId, _dataField, _dataSavePath, _dataValidation);
	}

	static mountSaveEvent(referenceObject, _dataId, _dataField, _dataSavePath, _dataValidation) {

		$(referenceObject).find('input[type="text"],input[type="password"]').bind('blur', function() {

			var thisInput = this;

			var _requestData = {id:_dataId, [_dataField]: $(thisInput).val()};

			AjaxService.call(config.webpath + _dataSavePath, 'post', function(response) {

				if (response.success) {
					$(thisInput).next().html('');
				}

				if (_dataValidation != '') {
					ValidationService.check($(thisInput));
				}

				NotifierComponent.show(response.message, (response.success) ? 'success' : 'danger');

				$(thisInput).next().html($(thisInput).val());
				// $(thisInput).val('');

			}, _requestData);

		});
	}

	static check(referenceObject, _dataId, _dataField, _dataSavePath) {

		var _componentOK = true;

		if (_dataId == undefined) {
			console.warn('Missing data-id attribute from "tr" tag. Value must be the id that you want to control.');
			_componentOK = false;
		}

		if (_dataField == undefined) {
			console.warn('Missing data-field attribute. Value must be the field destination');
			_componentOK = false;
		}

		if (_dataSavePath == undefined) {
			console.warn('Missing data-save-path attribute from "tbody" tag. Value must be the QueryString without the ID param');
			_componentOK = false;
		}

		return _componentOK;
	}

	static applyMaterialDesign(referenceObject, rowIndex, columnIndex) {

		window.MaterialDesignIndex = (typeof window.MaterialDesignIndex == 'undefined') ? 0 : window.MaterialDesignIndex + 1;

		$(referenceObject).addClass('mdl-textfield mdl-js-textfield mdl-textfield--floating-label');
		$(referenceObject).find('input[type="text"],input[type="password"]').attr('id', 'md_' + window.MaterialDesignIndex).addClass('mdl-textfield__input');
		$(referenceObject).find('label').attr('for', 'md_' + window.MaterialDesignIndex).addClass('mdl-textfield__label');
	}
}