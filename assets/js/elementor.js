jQuery(document).ready(function($) {

	var lqSlider = function (){
		if($('.lq-widget-slider').length){
		
		$('.lq-widget-slider').each(function(index, element) {
			var slider_options = $(this).data('options');
            $(this).owlCarousel(slider_options);
        });
		
		}
	}	
	
	if( 'undefined' != typeof elementorFrontend ){
	  elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function( $scope ) {
		  lqSlider();
	  } );
	}
	
	
});

