class ButtonOnOffComponent {

	static mount(referenceObject) {

		var _dataId 		= $(referenceObject).closest('[data-id]', document.getElementById('tr')).attr('data-id');
		var _dataSavePath 	= $(referenceObject).closest('[data-save-path]', document.getElementById('tbody')).attr('data-save-path');
		var _dataField 		= $(referenceObject).attr('data-field');
		var _dataChecked	= (typeof $(referenceObject).attr('data-checked') != 'undefined') ? $(referenceObject).attr('data-checked') : '';

		if (!this.check(referenceObject, _dataId, _dataField, _dataSavePath)) {
			return false;
		}

		$(referenceObject).html('\
			<label>\
				<input type="checkbox" ' + ((_dataChecked) ? 'checked="checked"' : '') + ' />\
				<span class="mdl-switch__label"></span>\
			</label>\
		');

		this.applyMaterialDesign(referenceObject);
		this.mountSaveEvent(referenceObject, _dataId, _dataField, _dataSavePath);
	}

	static mountSaveEvent(referenceObject, _dataId, _dataField, _dataSavePath) {

		$(referenceObject).find('input[type="checkbox"]').bind('change', function() {

			var _requestData = {id:_dataId, [_dataField]: $(this).prop('checked') ? "1" : "0"};

			AjaxService.call(config.webpath + _dataSavePath, 'post', function(response) {

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

	static applyMaterialDesign(referenceObject, rowIndex, columnIndex) {

		window.MaterialDesignIndex = (typeof window.MaterialDesignIndex == 'undefined') ? 0 : window.MaterialDesignIndex + 1;

		$(referenceObject).find('label').attr('for', 'md_' + window.MaterialDesignIndex).addClass('mdl-switch mdl-js-switch mdl-js-ripple-effect');
		$(referenceObject).find('input[type="checkbox"]').attr('id', 'md_' + window.MaterialDesignIndex).addClass('mdl-switch__input');
		$(referenceObject).find('span').addClass('mdl-switch__label');
	}
}