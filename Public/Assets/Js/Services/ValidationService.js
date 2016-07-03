class ValidationService {

	static check(object) {

		var _isValid 			= true;
		var _error 				= null;
		var _validationRules 	= $(object).attr('data-validate').split(',');

		switch ($(object)[0].tagName) {
			case 'INPUT':
			case 'TEXTAREA':
			case 'SELECT':
				var _objectValue = $(object).val();
				break;
			default:
				var _objectValue = $(object).html();
				break;
		}

		_validationRules.forEach( ruleSet => {

			ruleSet = (ruleSet.indexOf(':') != -1) ? ruleSet.split(':') : ruleSet;

			switch (ruleSet[0]) {
				case 'mandatory':
					if (($(object)[0].tagName != 'SELECT' && _objectValue == '') || ($(object)[0].tagName == 'SELECT' && _objectValue == '0')) {
						_isValid 	= false;
						_error 		= 'This field is mandatory.';
					}
					break;
				case 'minlength':
					if (_objectValue != '') {
						if (_objectValue.length < ruleSet[1]) {
							_isValid 	= false;
							_error 		= 'Minimum length should be ' + ruleSet[1];
						}
					}
					break;
				case 'maxlength':
					if (_objectValue != '') {
						if (_objectValue.length > ruleSet[1]) {
							_isValid 	= false;
							_error 		= 'Maximum length should be ' + ruleSet[1];
						}
					}
					break;
				case 'min':
					if (_objectValue != '') {
						if (_objectValue < ruleSet[1]) {
							_isValid 	= false;
							_error 		= 'Minimum value should be ' + ruleSet[1];
						}
					}
					break;
				case 'max':
					if (_objectValue != '') {
						if (_objectValue > ruleSet[1]) {
							_isValid 	= false;
							_error 		= 'Maximum value should be ' + ruleSet[1];
						}
					}
					break;
				case 'email':
					if (_objectValue != '') {
						var emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

						if (!emailPattern.test(_objectValue)) {
							_isValid 	= false;
							_error 		= 'Must contain a valid email address.';
						}
						break;
					}
				case 'ip':
					if (_objectValue != '') {

						if (!/^(([1-9]?\d|1\d\d|2[0-4]\d|25[0-5])(\.(?!$)|$)){4}$/.test(_objectValue)) {
							_isValid 	= false;
							_error 		= 'Must contain a valid IP address.';
						}
						break;
					}
			}
		});

		if (_isValid === true) {
			$(object).removeAttr('title').removeClass('validateDanger');
		} else {
			$(object).attr('title', _error).addClass('validateDanger');
		}

		return (_isValid === true) ? _isValid : _error;
	}
}