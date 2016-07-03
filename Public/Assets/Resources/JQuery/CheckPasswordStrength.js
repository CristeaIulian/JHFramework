/* global CheckPasswordStrength */
/**
 * @preserve jQuery CheckPasswordStrength plugin v0.0.1
 * @homepage http://www.memobit.ro
 * (c) 2016, Iulian Cristea.
 */
/*global document,window,jQuery*/
(function ( $ ) {
 
    $.fn.CheckPasswordStrength = function( options ) {
 
		var check_password = function(object) {

			$(object).after('<div class="alert alert-danger" style="margin-bottom:0px;padding: 5px 10px 5px 10px;">Pass Strength: weak</div>');
			$(object).next().after('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">0%</div></div>');

			$(object).bind('keyup', function(){

				var _scoring = 0;

				_scoring = (object.val().length > 2) ? _scoring += 10 : _scoring;
				_scoring = (object.val().length > 6) ? _scoring += 20 : _scoring;

				for (var i=0; i < object.val().length; i++){
					_scoring = ('~`!@#$%^&*()_-+={[}]|\\:;"\'<,>.?/'.indexOf(object.val().substr(i, 1)) != -1) ? _scoring += 15 : _scoring;
				}
				
				for (var i=0; i < object.val().length; i++) {
					_scoring = ('0123456789'.indexOf(object.val().substr(i, 1)) != -1) ? _scoring += 8 : _scoring;
				}

				if (_scoring > 100){
					_scoring = 100;
				}

				_scoring = (_scoring > 100) ? 100 : _scoring;

				switch (true){
					case (_scoring < 20):
						_strength = 'very weak';
						_label = 'danger';
						break;
					case _scoring < 40:
						_strength = 'weak';
						_label = 'warning';
						break;
					case _scoring < 60:
						_strength = 'normal';
						_label = 'warning';
						break;
					case _scoring < 80:
						_strength = 'strong';
						_label = 'success';
						break;
					case _scoring == 100:
						_strength = 'very strong';
						_label = 'success';
						break;
				}

				$(object).next().html('Pass Strength: ' + _strength);
				$(object).next().removeClass('alert-danger').removeClass('alert-warning').removeClass('alert-success').addClass('alert-' + _label);
				$(object).next().css('font-weight', (_scoring == 100) ? '900' : '100');

				$(object).next().next().find('.progress-bar').css('width', _scoring + '%');
				$(object).next().next().find('.progress-bar').html(_scoring + '%');
				$(object).next().next().find('.progress-bar').removeClass('progress-bar-danger').removeClass('progress-bar-warning').removeClass('progress-bar-success').addClass('progress-bar-' + _label);
			});
		};
 
		return check_password(this, options);
    };
 
}( jQuery ));