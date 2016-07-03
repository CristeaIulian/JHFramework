describe('NotifierComponent', function() {

	afterEach(function(){
		$('.NotifierComponent').remove();
	})

	describe('Notifier toast', function() {
		it('should add to DOM', function() {
			
			NotifierComponent.show('This is a test', 'success');

			expect($('.NotifierComponent').html()).toBeDefined();
		});
	});
});