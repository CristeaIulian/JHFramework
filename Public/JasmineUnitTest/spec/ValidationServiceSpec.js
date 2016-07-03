describe('ValidationService', function() {

	beforeEach(function(){
		$('body').append('<input type="text" id="testObject" value="" />');
		$('body').append('<input type="text" id="testTextareaObject" value="" />');
		$('body').append('<select id="testSelectObject"><option value="0">00</option><option value="1">11</option></select>');
	});

	afterEach(function(){
		$('#testObject').remove();
		$('#testTextareaObject').remove();
		$('#testSelectObject').remove();
	});

	describe('object types', function() {
		describe('input text', function() {
			it('should not pass empty', function() {
				$('#testObject').attr('data-validate', 'mandatory').val('something');
				expect(ValidationService.check($('#testObject'))).toBeTruthy();
			});

			it('should be falsy when empty', function() {
				$('#testObject').attr('data-validate', 'mandatory');
				expect(ValidationService.check($('#testObject'))).not.toBe(true);
			});

			it('should check multiples', function() {
				$('#testObject').val('something').attr('data-validate', 'mandatory,minlength:3');
				expect(ValidationService.check($('#testObject'))).toBeTruthy();
			});
		});

		describe('select', function(){
			it('should not pass empty', function() {
				$('#testSelectObject').attr('data-validate', 'mandatory');
				$('#testSelectObject')[0].selectedIndex = 1;
				expect(ValidationService.check($('#testSelectObject'))).toBe(true);
			});

			it('should be falsy when empty', function() {
				$('#testSelectObject').attr('data-validate', 'mandatory');
				expect(ValidationService.check($('#testSelectObject'))).not.toBe(true);
			});
		});

		describe('textarea', function(){
			it('should not pass empty', function() {
				$('#testTextareaObject').attr('data-validate', 'mandatory').val('something');
				expect(ValidationService.check($('#testTextareaObject'))).toBeTruthy();
			});

			it('should be falsy when empty', function() {
				$('#testTextareaObject').attr('data-validate', 'mandatory');
				expect(ValidationService.check($('#testTextareaObject'))).not.toBe(true);
			});
		});
	});

	describe('rules', function() {

		describe('minlength', function(){
			it('should have at least 3 characters', function() {
				$('#testObject').val('something').attr('data-validate', 'minlength:3');
				expect(ValidationService.check($('#testObject'))).toBeTruthy();
			});

			it('should have exact 3 characters', function() {
				$('#testObject').val('something').attr('data-validate', 'minlength:3');
				expect(ValidationService.check($('#testObject'))).toBeTruthy();
			});

			it('should fail if has under 3 characters', function() {
				$('#testObject').val('so').attr('data-validate', 'minlength:3');
				expect(ValidationService.check($('#testObject'))).not.toBe(true);
			});
		});

		describe('maxlength', function(){
			it('should have at most 3 characters', function() {
				$('#testObject').val('so').attr('data-validate', 'maxlength:3');
				expect(ValidationService.check($('#testObject'))).toBeTruthy();
			});

			it('should have exact 3 characters', function() {
				$('#testObject').val('som').attr('data-validate', 'maxlength:3');
				expect(ValidationService.check($('#testObject'))).toBeTruthy();
			});

			it('should fail if has over 3 characters', function() {
				$('#testObject').val('something').attr('data-validate', 'maxlength:3');
				expect(ValidationService.check($('#testObject'))).not.toBe(true);
			});
		});

		describe('min', function(){
			it('should be at least 12', function() {
				$('#testObject').val('12').attr('data-validate', 'min:3');
				expect(ValidationService.check($('#testObject'))).toBeTruthy();
			});

			it('should be exactly 3', function() {
				$('#testObject').val('3').attr('data-validate', 'min:3');
				expect(ValidationService.check($('#testObject'))).toBeTruthy();
			});

			it('should NOT be under 2', function() {
				$('#testObject').val('2').attr('data-validate', 'min:3');
				expect(ValidationService.check($('#testObject'))).not.toBe(true);
			});
		});

		describe('max', function(){
			it('should be at most 12', function() {
				$('#testObject').val('12').attr('data-validate', 'max:30');
				expect(ValidationService.check($('#testObject'))).toBeTruthy();
			});

			it('should be exactly 30', function() {
				$('#testObject').val('30').attr('data-validate', 'max:30');
				expect(ValidationService.check($('#testObject'))).toBeTruthy();
			});

			it('should NOT be over 32', function() {
				$('#testObject').val('32').attr('data-validate', 'max:30');
				expect(ValidationService.check($('#testObject'))).not.toBe(true);
			});
		});

		describe('email', function(){
			it('should match mail@domain.ext', function() {
				$('#testObject').val('mail@domain.ext').attr('data-validate', 'email');
				expect(ValidationService.check($('#testObject'))).toBeTruthy();
			});

			it('should match firstname.lastname@domain.ext', function() {
				$('#testObject').val('firstname.lastname@domain.ext').attr('data-validate', 'email');
				expect(ValidationService.check($('#testObject'))).toBeTruthy();
			});

			it('should not match something', function() {
				$('#testObject').val('something').attr('data-validate', 'email');
				expect(ValidationService.check($('#testObject'))).not.toBe(true);
			});

			it('should not match mail@something', function() {
				$('#testObject').val('mail@something').attr('data-validate', 'email');
				expect(ValidationService.check($('#testObject'))).not.toBe(true);
			});

			it('should not match mail@', function() {
				$('#testObject').val('mail@').attr('data-validate', 'email');
				expect(ValidationService.check($('#testObject'))).not.toBe(true);
			});

			it('should not match mail.something.ext', function() {
				$('#testObject').val('mail.something.ext').attr('data-validate', 'email');
				expect(ValidationService.check($('#testObject'))).not.toBe(true);
			});
		});

		describe('ip', function(){
			it('should match 127.0.0.0', function() {
				$('#testObject').val('127.0.0.0').attr('data-validate', 'ip');
				expect(ValidationService.check($('#testObject'))).toBeTruthy();
			});

			it('should not match 256.344.553.32', function() {
				$('#testObject').val('256.344.553.32').attr('data-validate', 'ip');
				expect(ValidationService.check($('#testObject'))).not.toBe(true);
			});

			it('should not match something', function() {
				$('#testObject').val('something').attr('data-validate', 'ip');
				expect(ValidationService.check($('#testObject'))).not.toBe(true);
			});

			it('should not match 127.9.5', function() {
				$('#testObject').val('127.9.5').attr('data-validate', 'ip');
				expect(ValidationService.check($('#testObject'))).not.toBe(true);
			});

			it('should not match 23.33', function() {
				$('#testObject').val('23.33').attr('data-validate', 'ip');
				expect(ValidationService.check($('#testObject'))).not.toBe(true);
			});

			it('should not match 344543', function() {
				$('#testObject').val('344543').attr('data-validate', 'ip');
				expect(ValidationService.check($('#testObject'))).not.toBe(true);
			});
		});
	});
});