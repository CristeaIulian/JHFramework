class SelectorAjaxComponent {

	static mount(referenceObject, textboxType) {

		var _error = false;

		if ($(referenceObject)[0] == undefined) {
			console.warn('Cannot build component.', 'You need to pass as argument the DOM object that execute the operation.');
			_error = true;
		}

		if ($(referenceObject).attr('data-id') == undefined) {
			console.warn('Cannot build component.', 'data-id attribute is not specified. Value must be the id that you want to delete.');
			_error = true;
		}

		if ($(referenceObject).attr('data-field') == undefined) {
			console.warn('Cannot build component.', 'data-field attribute is not specified. Value must be the field destination');
			_error = true;
		}

		if ($(referenceObject).attr('data-save-path') == undefined) {
			console.warn('Cannot build component.', 'data-save-path attribute is not specified. Value must be the QueryString without the ID param');
			_error = true;
		}

		if ($(referenceObject).attr('data-load-path') == undefined) {
			console.warn('Cannot build component.', 'data-load-path attribute is not specified. Value must be the QueryString from where you want to retrieve data for selector.');
			_error = true;
		}

		if (_error) {
			return false;
		}

		if (this._editorActive == undefined || this._editorActive === false) {

			this.setDefault();

			this._editorActive 			= true;

			this._editor.proto.onblur 	= 'SelectorComponent.save();',

			this._editor.object = '<select ';

			for (var key of Object.keys(this._editor.proto)) {
				this._editor.object += key + '="' + this._editor.proto[key] + '" ';
			}

			this._editor.object += '>';

			var thisClass = this;

			AjaxService.call(config.webpath + $(referenceObject).attr('data-load-path'), 'get', function(response) {
				
				for (var el in response['data']) {
					thisClass._editor.object += '<option value="' + response['data'][el]['id'] + '"' + (($(referenceObject).attr('data-selected-id') == response['data'][el]['id']) ? 'selected="selected"' : '') + '>' + response['data'][el]['name'] + '</option>';
				}

				thisClass._editor.object += '</select>';

				$(referenceObject).html(thisClass._editor.object);

				thisClass._editor.domObject = referenceObject;
			})
		}
	}

	static setDefault() {

		this._editor = {
			domObject: null,
			recordId: null,
			proto: {
				id: 		'selectorEditor',
				onchange: 	'',
				onblur: 	'',
				class: 		'form-control',
			},
			object: null,
		}
	}

	static save() {

		var _newValue 	= $('#' + this._editor.proto.id).val();

		var _newText 	= $('#' + this._editor.proto.id)[0].selectedOptions[0].text;

		var thisClass 	= this;

		var _requestData = {id:$(this._editor.domObject).attr('data-id'), [$(this._editor.domObject).attr('data-field')]: _newValue};

		AjaxService.call(config.webpath + $(this._editor.domObject).attr('data-save-path'), 'post', function(response) {

			if (response.success) {
				$(thisClass._editor.domObject).html(_newText);
				$(thisClass._editor.domObject).attr('data-selected-id', _newValue);
			}

			if (typeof $(thisClass._editor.domObject).attr('data-validation') != 'undefined') {

				var _isValid = ValidationService.check($(thisClass._editor.domObject));
				
				if (_isValid !== true) {
					$(thisClass._editor.domObject).addClass('validateDanger');
					$(thisClass._editor.domObject).attr('title', _isValid); // TODO :: must mount tooltip
				} else {
					$(thisClass._editor.domObject).removeClass('validateDanger');
					$(thisClass._editor.domObject).removeAttr('title');
				}
			}

			NotifierComponent.show(response.message, (response.success) ? 'success' : 'danger');

			thisClass._editorActive = false;

		}, _requestData);
	}
}