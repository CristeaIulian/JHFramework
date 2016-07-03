class PreloadComponent {

	static show(message) {

		if (typeof message == 'undefined'){
			message = 'Loading ...';
		}

		$('body').append('\
			<div id="preload_fader" style="position:fixed; width:100%; height:100%; background-color:#000000; opacity:0.3;z-index:10000; top: 0; left: 0;"></div>\
			<div id="preload_loader" style="position:fixed; background-color:#ffffff;z-index:10001; top: 50%; margin-top:-35px; height:70px; left: 50%; margin-left:-200px; width:400px; padding:24px; border-radius:5px; border:3px double #999999;">\
				' + message + '<br />\
				<div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>\
			</div>\
		');

		componentHandler.upgradeDom();
	}

	static hide(hideInstant) {

		if (typeof hideInstant !== 'undefined' && hideInstant) {

			$('#preload_fader').remove();
			$('#preload_loader').remove();

		} else {

			$('#preload_fader').fadeOut('slow', function(){
				$('#preload_fader').remove();
			});
			$('#preload_loader').fadeOut('slow', function(){
				$('#preload_loader').remove();
			});
		}
	}
}