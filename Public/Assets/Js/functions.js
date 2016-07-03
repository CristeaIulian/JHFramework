var init = function() {
	setTooltips();
	set_datetimepickers();

	if (jQuery().CheckPasswordStrength) {
		$('#window_user_password').CheckPasswordStrength();
	}

	mountFilters();

	router();
};

var Controller = null;

var router = function() {
	if (typeof _controllerName != 'undefined') {
		switch (_controllerName) {
			case 'AccessRights':
				Controller = new AccessRightsController();
				break;
			case 'WhiteListIPs':
				Controller = new WhiteListIpsController();
				break;
			case 'Dashboard':
				Controller = new DashboardController();
				break;
			case 'Users':
				Controller = new UsersController();
				break;
			case 'Logs':
				Controller = new LogsController();
				break;
			case 'Articles':
				Controller = new ArticlesController();
				break;
			default:
				console.error('Unknown Controller Name.');
				break;
		}
	} else {
		console.warn('Controller Name is not defined.');
	}
}

var mountFilters = function() {

	$('.filterField').bind('keyup', function(event) {

		if (event.keyCode == 13) {

			var _data = [];

			$('body').find('.filterField').each(function(){
				
				_data[_data.length] = {name:$(this).attr('name'), value: $(this).val()}
			})

			var _requestData = {data:_data, section: _filterSection};

			ajaxCall(config.webpath + 'Index/Filter', 'post', function(response) {

				console.log(response);
				if (response.status == 'success') {
					document.location.reload();
				}

			}, _requestData);
		} 
	});
}

var setTooltips = function() {
	$('.tooltip-top').tooltip({
		placement:'top'
	});
	$('.tooltip-right').tooltip({
		placement:'right'
	});
	$('.tooltip-bottom').tooltip({
		placement:'bottom'
	});
	$('.tooltip-left').tooltip({
		placement:'left'
	});
};

var set_datetimepickers = function() {
	if (jQuery().datetimepicker) {
		$( ".datetimepicker" ).datetimepicker({
			format: 'Y-m-d H:i:s'
		});
	}

	if (jQuery().datepicker) {
		$( ".datepicker" ).datepicker({
			dateFormat: 'yy-mm-dd'
		});
	}
};

$(document).ready(function() {
    init();
});