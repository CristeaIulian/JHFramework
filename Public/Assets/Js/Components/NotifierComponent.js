class NotifierComponent {

	static show(message, messageType) {

		if (['success', 'warning', 'info', 'danger'].indexOf(messageType) == -1) { // TODO :: not used messageType
			messageType = 'info';
		}

		if (document.querySelector('.NotifierComponent') == null) {
			
			var _notifier = '\
				<div aria-live="assertive" aria-atomic="true" aria-relevant="text" class="mdl-snackbar mdl-js-snackbar NotifierComponent">\
				    <div class="mdl-snackbar__text"></div>\
				    <button type="button" class="mdl-snackbar__action"></button>\
				</div>\
			';

			$('body').append(_notifier);

			componentHandler.upgradeDom();
		}

		document.querySelector('.NotifierComponent').MaterialSnackbar.showSnackbar({message: message});
	};
}