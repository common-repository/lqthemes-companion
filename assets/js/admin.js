(function( $ ) {
	
	// Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('.wp-color-picker').wpColorPicker();
    });
	
	// Handle sidebar collapse in preview.
	$( '.lqthemes-template-preview' ).on(
		'click', '.collapse-sidebar', function () {
			event.preventDefault();
			var overlay = $( '.lqthemes-template-preview' );
			if ( overlay.hasClass( 'expanded' ) ) {
				overlay.removeClass( 'expanded' );
				overlay.addClass( 'collapsed' );
				return false;
			}

			if ( overlay.hasClass( 'collapsed' ) ) {
				overlay.removeClass( 'collapsed' );
				overlay.addClass( 'expanded' );
				return false;
			}
		}
	);

	// Handle responsive buttons.
	$( '.lqthemes-responsive-preview' ).on(
		'click', 'button', function () {
			$( '.lqthemes-template-preview' ).removeClass( 'preview-mobile preview-tablet preview-desktop' );
			var deviceClass = 'preview-' + $( this ).data( 'device' );
			$( '.lqthemes-responsive-preview button' ).each(
				function () {
					$( this ).attr( 'aria-pressed', 'false' );
					$( this ).removeClass( 'active' );
				}
			);

			$( '.lqthemes-responsive-preview' ).removeClass( $( this ).attr( 'class' ).split( ' ' ).pop() );
			$( '.lqthemes-template-preview' ).addClass( deviceClass );
			$( this ).addClass( 'active' );
		}
	);
	
	$(window).load(function(){
		// init Isotope
	  var $grid = $('.lqthemes-template-browser').isotope({
		// options
	  });
	  // filter items on button click
	  $('.templates-nav').on( 'click', 'li', function() {
		var filterValue = $(this).attr('data-filter');
		$('.templates-nav li').removeClass('active');
		$(this).addClass('active');
		$grid.isotope({ filter: filterValue });
	  });
		
	});
	

	// Hide preview.
	$( '.close-full-overlay' ).on(
		'click', function () {
			$( '.lqthemes-template-preview .lqthemes-theme-info.active' ).removeClass( 'active' );
			$( '.lqthemes-template-preview' ).hide();
			$( '.lqthemes-template-frame' ).attr( 'src', '' );
			$('body.lqthemes-companion_page_lqthemes-template').css({'overflow-y':'auto'});
		}
	);
			
	
	// Open preview routine.
	$( '.lqthemes-preview-template' ).on(
		'click', function () {
			$('.import-return-info').remove();
			var templateSlug = $( this ).data( 'template-slug' );
			var previewUrl = $( this ).data( 'demo-url' );
			$( '.lqthemes-template-frame' ).attr( 'src', previewUrl );
			$( '.lqthemes-theme-info.' + templateSlug ).addClass( 'active' );
			setupImportButton();
			$( '.lqthemes-template-preview' ).fadeIn();
			$('body.lqthemes-companion_page_lqthemes-template').css({'overflow-y':'hidden'});
		}
	);
	
	$(document).on('click', '.lqthemes-preview-site',
		 function () {
			$('.import-return-info').remove();
			var siteSlug = $( this ).data( 'site-slug' );
			var previewUrl = $( this ).data( 'demo-url' );
			$( '.lqthemes-template-frame' ).attr( 'src', previewUrl );
			$( '.lqthemes-theme-info.' + siteSlug ).addClass( 'active' );
			setupImportSiteButton();
			$( '.lqthemes-template-preview' ).fadeIn();
			$('body.lqthemes-companion_page_lqthemes-template').css({'overflow-y':'hidden'});
		}
	);
	
	
	$( '.lqthemes-next-prev .next-theme' ).on(
				'click', function () {
					var active = $( '.lqthemes-theme-info.active' ).removeClass( 'active' );
					if ( active.next() && active.next().length ) {
						active.next().addClass( 'active' );
					} else {
						active.siblings( ':first' ).addClass( 'active' );
					}
					changePreviewSource();
					setupImportButton();
				}
			);
			$( '.lqthemes-next-prev .previous-theme' ).on(
				'click', function () {
					var active = $( '.lqthemes-theme-info.active' ).removeClass( 'active' );
					if ( active.prev() && active.prev().length ) {
						active.prev().addClass( 'active' );
					} else {
						active.siblings( ':last' ).addClass( 'active' );
					}
					changePreviewSource();
					setupImportButton();
				}
			);

			// Change preview source.
			function changePreviewSource() {
				var previewUrl = $( '.lqthemes-theme-info.active' ).data( 'demo-url' );
				$( '.lqthemes-template-frame' ).attr( 'src', previewUrl );
			}
	
	function setupImportButton() {
		var installable = $( '.active .lqthemes-installable' );
		if ( installable.length > 0 ) {
			$( '.wp-full-overlay-header .lqthemes-import-template' ).text( lqthemes_companion_admin.i18n.t1 );
		} else {
			$( '.wp-full-overlay-header .lqthemes-import-template' ).text( lqthemes_companion_admin.i18n.t2 );
		}
		var activeTheme = $( '.lqthemes-theme-info.active' );
		var button = $( '.wp-full-overlay-header .lqthemes-import-template' );
		$( button ).attr( 'data-template-file', $( activeTheme ).data( 'template-file' ) );
		$( button ).attr( 'data-template-title', $( activeTheme ).data( 'template-title' ) );
		$( button ).attr( 'data-template-slug', $( activeTheme ).data( 'template-slug' ) );
		
		if($( activeTheme ).data( 'template-file' ) == '' ){
				$('.lqthemes-buy-now').show();
				$('.lqthemes-import-template').hide();
				if($( activeTheme ).data( 'purchase-url' ) != '' ){
					$('.lqthemes-buy-now').attr('href', $( activeTheme ).data( 'purchase-url' ) );
					if($( activeTheme ).data( 'button-text' ) != '' ){
						$('.lqthemes-buy-now span').text( $( activeTheme ).data( 'button-text' ) );
					}
				}
			}else{
				$('.lqthemes-buy-now').hide();
				$('.lqthemes-import-template').show();
				}
	}
	
	function setupImportSiteButton() {
		var installable = $( '.active .lqthemes-installable' );
		
		$('.lqthemes-import-button').addClass('lqthemes-import-site');
		if ( installable.length > 0 ) {
			$( '.wp-full-overlay-header .lqthemes-import-site' ).text( lqthemes_companion_admin.i18n.t3 );
		} else {
			$( '.wp-full-overlay-header .lqthemes-import-site' ).text( lqthemes_companion_admin.i18n.t4 );
		}
		var activeTheme = $( '.lqthemes-theme-info.active' );
		var button = $( '.wp-full-overlay-header .lqthemes-import-site' );
		$( button ).attr( 'data-demo-url', $( activeTheme ).data( 'demo-url' ) );
		$( button ).attr( 'data-site-wxr', $( activeTheme ).data( 'site-wxr' ) );
		$( button ).attr( 'data-site-title', $( activeTheme ).data( 'site-title' ) );
		$( button ).attr( 'data-site-slug', $( activeTheme ).data( 'site-slug' ) );
		
		$( button ).attr( 'data-template-slug', $( activeTheme ).data( 'template-slug' ) );
		$( button ).attr( 'data-site-options', $( activeTheme ).data( 'site-options' ) );
		$( button ).attr( 'data-site-widgets', $( activeTheme ).data( 'site-widgets' ) );
		$( button ).attr( 'data-site-customizer', $( activeTheme ).data( 'site-customizer' ) );
							 
		
		if($( activeTheme ).data( 'site-wxr' ) == '' ){
				$('.lqthemes-buy-now').show();
				$('.lqthemes-import-site').hide();
				if($( activeTheme ).data( 'purchase-url' ) != '' ){
					$('.lqthemes-buy-now').attr('href', $( activeTheme ).data( 'purchase-url' ) );
					if($( activeTheme ).data( 'button-text' ) != '' ){
						$('.lqthemes-buy-now span').text( $( activeTheme ).data( 'button-text' ) );
					}
				}
					
			}else{
				$('.lqthemes-buy-now').hide();
				$('.lqthemes-import-site').show();
				$( activeTheme ).find('.hide-in-pro').hide();
				}
	}
	
	
	// Handle import click.
	$( '.wp-full-overlay-header' ).on(
		'click', '.lqthemes-import-template', function () {
			$( this ).addClass( 'lqthemes-import-queue updating-message lqthemes-updating' ).html( '' );
			$( '.lqthemes-template-preview .close-full-overlay, .lqthemes-next-prev' ).remove();
			var template_url = $( this ).data( 'template-file' );
			var template_name = $( this ).data( 'template-title' );
			var template_slug = $( this ).data( 'template-slug' );
			
			if ( $( '.active .lqthemes-installable' ).length || $( '.active .lqthemes-activate' ).length ) {

				checkAndInstallPlugins();
			} else {
				$.ajax(
					{
						url: lqthemes_companion_admin.ajaxurl,
						beforeSend: function ( xhr ) {
							$( '.lqthemes-import-queue' ).addClass( 'lqthemes-updating' ).html( '' );
							xhr.setRequestHeader( 'X-WP-Nonce', lqthemes_companion_admin.nonce );
						},
						// async: false,
						data: {
							template_url: template_url,
							template_name: template_name,
							template_slug: template_slug,
							action: 'lqthemes_import_elementor'
						},
					//	dataType:"json",
						type: 'POST',
						success: function ( data ) {
							console.log( 'success' );
							console.log( data );
							$( '.lqthemes-updating' ).replaceWith( '<span class="lqthemes-done-import"><i class="dashicons-yes dashicons"></i></span>' );
							var obj = $.parseJSON( data );
							
							location.href = obj.redirect_url;
						},
						error: function ( error ) {
							console.log( 'error' );
							console.log( error );
						},
						complete: function() {
							$( '.lqthemes-updating' ).replaceWith( '<span class="lqthemes-done-import"><i class="dashicons-yes dashicons"></i></span>' );
						}
					}, 'json'
				);
			}
		}
	);

	function checkAndInstallPlugins() {
		var installable = $( '.active .lqthemes-installable' );
		var toActivate = $( '.active .lqthemes-activate' );
		if ( installable.length || toActivate.length ) {

			$( installable ).each(
				function () {
					var plugin = $( this );
					$( plugin ).removeClass( 'lqthemes-installable' ).addClass( 'lqthemes-installing' );
					$( plugin ).find( 'span.dashicons' ).replaceWith( '<span class="dashicons dashicons-update" style="-webkit-animation: rotation 2s infinite linear; animation: rotation 2s infinite linear; color: #ffb227 "></span>' );
					var slug = $( this ).find( '.lqthemes-install-plugin' ).attr( 'data-slug' );
					
					if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
						  wp.updates.requestFilesystemCredentials( event );
		  
						  $document.on( 'credential-modal-cancel', function() {
							  var $message = $( '.install-now.lqthemes-installing' );
		  
							  $message
								  .removeClass( 'lqthemes-installing' )
								  .text( wp.updates.l10n.installNow );
		  
							  wp.a11y.speak( wp.updates.l10n.updateCancel, 'polite' );
						  } );
					  }
					  
					wp.updates.installPlugin(
						{
							slug: slug,
							success: function ( response ) {
								activatePlugin( response.activateUrl, plugin );
							}
						}
					);
				}
			);

			$( toActivate ).each(
				function () {
						var plugin = $( this );
						var activateUrl = $( plugin ).find( '.activate-now' ).attr( 'href' );
					if (typeof activateUrl !== 'undefined') {
						activatePlugin( activateUrl, plugin );
					}
				}
			);
		}
	}

	function activatePlugin( activationUrl, plugin ) {
		$.ajax(
			{
				type: 'GET',
				url: activationUrl,
				beforeSend: function() {
					$( plugin ).removeClass( 'lqthemes-activate' ).addClass( 'lqthemes-installing' );
					$( plugin ).find( 'span.dashicons' ).replaceWith( '<span class="dashicons dashicons-update" style="-webkit-animation: rotation 2s infinite linear; animation: rotation 2s infinite linear; color: #ffb227 "></span>' );
					$( plugin ).find( '.activate-now' ).removeClass('activate-now  button-primary').addClass('button-activatting button-secondary').text('Activating').attr('href','#');
				},
				success: function () {
					$( plugin ).find( '.dashicons' ).replaceWith( '<span class="dashicons dashicons-yes" style="color: #34a85e"></span>' );
					$( plugin ).find( '.button-activatting' ).text('Activated');
					$( plugin ).removeClass( 'lqthemes-installing' );
				},
				complete: function() {
					if ( $( '.active .lqthemes-installing' ).length === 0 ) {
						$( '.lqthemes-import-queue' ).trigger( 'click' );
					}
				}
			}
		);
	}
	
	
     
})( jQuery );