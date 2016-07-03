class AjaxService {

	static call(url, method, callback, data) {

		if (typeof url == 'undefined'){
			console.warn('URL cannot be empty');
			return false;
		}

		if (['GET', 'POST', 'PUT', 'PATCH', 'DELETE'].indexOf(method.toUpperCase()) != -1) {
			var _method = (typeof method == 'undefined') ? 'GET' : method;
		} else {
			console.error('Unknown method ' + method);
			return false;
		}

		switch (method.toUpperCase()){
			case 'GET':
				var _message = 'Loading...';
				break;
			case 'POST':
			case 'PUT':
			case 'PATCH':
				var _message = 'Saving...';
				break;
			case 'DELETE':
				var _message = 'Deleting...';
				break;
			default:
				var _message = undefined;
				break;
		}

		if (config.debug) {
			console.info('Ajax call: ' + url);
		}

		PreloadComponent.show(_message);
		
		$.ajax({
		    url: url,
		    type: _method,
			data: data,
		    success: function(response) {
		    	if (typeof callback != 'undefined'){
		    		callback(response);
		    	}
		    	if (config.debug) {
		    		console.info('Ajax success');
		    	}
		    },
		    error: function(response) {
		    	console.warn(response);
		    },
		    complete: function() {
		    	PreloadComponent.hide(true);
		    },
		});	
	};
}