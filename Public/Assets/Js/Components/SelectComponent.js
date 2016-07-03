class SelectComponent {

	static mount(referenceObject) {

		var _dataId 		= $(referenceObject).closest('[data-id]', document.getElementById('tr')).attr('data-id');
		var _dataSavePath 	= $(referenceObject).closest('[data-save-path]', document.getElementById('tbody')).attr('data-save-path');
		var _dataField 		= $(referenceObject).attr('data-field');
		var _dataValue		= (typeof $(referenceObject).attr('data-value') != 'undefined') ? $(referenceObject).attr('data-value') : '';
		var _dataValidation	= (typeof $(referenceObject).attr('data-validation') != 'undefined') ? $(referenceObject).attr('data-validation') : '';

		if (!this.check(referenceObject, _dataId, _dataField, _dataSavePath)) {
			return false;
		}

		var _newSelect = '<select class="form-control" ' + (_dataValidation != '' ? 'data-validate="' + _dataValidation + '"' : '') + '>';

		_newSelect += '<option value="0">-- select --</option>';

		var _dataJson = $('[data-grid] thead [data-record="info"] [data-model="' + _dataField + '"]').html();

		if (typeof _dataJson != 'undefined') {

			_dataJson = $.parseJSON(_dataJson);

			for (var el in _dataJson) {
				_newSelect += '<option value="' + _dataJson[el].id + '" ' + (_dataValue == _dataJson[el].id ? 'selected="selected"' : '') + '>' + _dataJson[el].name + '</option>';
			}
		}

		_newSelect += '</select>';

		$(referenceObject).html(_newSelect);

		this.mountSaveEvent(referenceObject, _dataId, _dataField, _dataSavePath, _dataValidation);
	}

	static mountSaveEvent(referenceObject, _dataId, _dataField, _dataSavePath, _dataValidation) {

		$(referenceObject).find('select').bind('change', function() {

			var _requestData = {id:_dataId, [_dataField]: $(this).val()};

			var thisSelect = this;

			AjaxService.call(config.webpath + _dataSavePath, 'post', function(response) {

				if (!response.success) {
					if (typeof response.messageDetails != 'undefined') {
						console.warn(response.messageDetails);
					}
				}

				if (_dataValidation != '') {
					ValidationService.check($(thisSelect));
				}

				NotifierComponent.show(response.message, (response.success) ? 'success' : 'danger');

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
}