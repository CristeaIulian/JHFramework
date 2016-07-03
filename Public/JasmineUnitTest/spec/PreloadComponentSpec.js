describe('PreloadComponent', function() {

	describe('Preload', function() {
		it('should add to DOM', function() {

			PreloadComponent.show();

			expect($('#preload_fader').html()).toBeDefined();
			expect($('#preload_loader').html()).toBeDefined();
		});

		it('should remove from DOM', function() {
	
			PreloadComponent.hide(true);

			expect($('#preload_fader').html()).toBeUndefined();
			expect($('#preload_loader').html()).toBeUndefined();
		});
	});
});