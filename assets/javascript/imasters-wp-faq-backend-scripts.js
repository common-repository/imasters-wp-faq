// JavaScript Document

( function($) {

	$( function($) {
				
		FAQ.answer_faq();
                FAQ.faq_uninstall_button();
	});

	FAQ = {
                answer_faq: function() {
			
			$('.faq-answer').hide();

		},
		
		answer_show : function( topic_id ) {
			$('#answer-to-topic-' + topic_id).toggle();
		},

                faq_uninstall_button : function() {
                    var button = $('input[name="do"]');
                    var checkbox = $('#uninstall_faq_yes');
                    button.hide();
                    checkbox.attr( 'checked', '' ).click(function() {
                        var is_checked = checkbox.attr( 'checked' );
                        if ( is_checked )
                            button.fadeIn();
                        else
                            button.fadeOut();
                    })
                }
	}

})(jQuery);