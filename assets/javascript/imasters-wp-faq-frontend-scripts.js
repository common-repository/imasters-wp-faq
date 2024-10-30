// JavaScript Document

( function($) {

	$( function($) {
		
		FAQ.answer_faq();
		FAQ.answer_show();
		
	});

	FAQ = {
	
		answer_faq: function() {
			
			$('.imasters-wp-faq-listing dd').hide();
		},
		
		answer_show : function() {

			$('.imasters-wp-faq-listing dt').click( function() {
				$(this).next().toggle();
			});
		}
	}
	
})(jQuery);