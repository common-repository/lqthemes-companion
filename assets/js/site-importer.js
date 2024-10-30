(function($){
	
	var LQThemesSSEImport = {
		complete: {
			posts: 0,
			media: 0,
			users: 0,
			comments: 0,
			terms: 0,
		},

		updateDelta: function (type, delta) {
			this.complete[ type ] += delta;

			var self = this;
			requestAnimationFrame(function () {
				self.render();
			});
		},
		updateProgress: function ( type, complete, total ) {
			var text = complete + '/' + total;

			if( 'undefined' !== type && 'undefined' !== text ) {
				total = parseInt( total, 10 );
				if ( 0 === total || isNaN( total ) ) {
					total = 1;
				}
				var percent = parseInt( complete, 10 ) / total;
				var progress     = Math.round( percent * 100 ) + '%';
				var progress_bar = percent * 100;
			}
		},
		render: function () {
			var types = Object.keys( this.complete );
			var complete = 0;
			var total = 0;

			for (var i = types.length - 1; i >= 0; i--) {
				var type = types[i];
				this.updateProgress( type, this.complete[ type ], this.data.count[ type ] );

				complete += this.complete[ type ];
				total += this.data.count[ type ];
			}

			this.updateProgress( 'total', complete, total );
		}
	};
	var LQThemesImporter = {
	
		customizer_data : '',
		wxr_url         : '',
		options_data    : '',
		widgets_data    : '',

		init: function()
		{
			this._bind();
		},
		_bind:function(){
			$( document ).on('click' , '.lqthemes-import-site', LQThemesImporter._importDemo);
			$( document ).on('click' , '.lqthemes-import-wxr', LQThemesImporter._importPrepareXML);
			$( document ).on('click' , '.lqthemes-import-options', LQThemesImporter._importSiteOptions);
			$( document ).on('click' , '.lqthemes-import-widgets', LQThemesImporter._importWidgets);
			$( document ).on('click' , '.lqthemes-sites-import-done', LQThemesImporter._importEnd);
			
			},
		_importDemo:function(){
			
			if( ! confirm(  lqlthemesSiteImporter.i18n.s0 ) ) {
				return;
			}
			var wrap = $('.lqthemes-theme-info.active');
			LQThemesImporter.site = wrap.data('site-slug');
			LQThemesImporter.wxr_url = wrap.data('site-wxr');
			LQThemesImporter.options_data = wrap.data('site-options');
			LQThemesImporter.customizer_data = wrap.data('site-customizer');
			LQThemesImporter.widgets_data = wrap.data('site-widgets');
			if ( $( '.active .lqthemes-installable' ).length || $( '.active .lqthemes-activate' ).length ) {

				LQThemesImporter.checkAndInstallPlugins();
			} else {
				LQThemesImporter._importCustomizerSettings();
			}
			
			},
		/**
		 * 1. Import Customizer Options.
		 */
		_importCustomizerSettings: function( event ) {

			$.ajax({
				url  : lqthemes_companion_admin.ajaxurl,
				type : 'POST',
				dataType: 'json',
				data : {
					action          : 'lqthemes-sites-import-customizer-settings',
					customizer_data : LQThemesImporter.customizer_data,
				},
				beforeSend: function() {
					$('.lqthemes-theme-info').append('<div class="import-return-info">'+lqlthemesSiteImporter.i18n.s1+'</div>');
					$('.lqthemes-import-site').text( lqlthemesSiteImporter.i18n.s1 );
				},
			})
			.fail(function( jqXHR ){
				
				$('.lqthemes-import-site').text( lqlthemesSiteImporter.i18n.s2 );
				$('.import-return-info').text( lqlthemesSiteImporter.i18n.s2 );
		    })
			.done(function ( customizer_data ) {

				// 1. Fail - Import Customizer Options.
				if( false === customizer_data.success ) {
					$('.lqthemes-theme-info').append('<div class="import-return-info notice-error">'+customizer_data.data+'</div>');
					$('.lqthemes-theme-info').append('<div class="import-return-info notice-error">'+lqlthemesSiteImporter.i18n.s2+'</div>');
					$('.lqthemes-import-site').text( lqlthemesSiteImporter.i18n.s2 );
				} else {
					
					// 1. Pass - Import Customizer Options.
					$('.lqthemes-import-site').text( lqlthemesSiteImporter.i18n.s3 );
					$('.lqthemes-theme-info').append('<div class="import-return-info notice-success">'+lqlthemesSiteImporter.i18n.s3+'</div>');
					
					$('.lqthemes-import-site').removeClass( 'lqthemes-import-site' ).addClass('lqthemes-import-wxr lqthemes-sites-import-customizer-settings-done');

					$(document).trigger( 'lqthemes-sites-import-customizer-settings-done' );
					$( ".lqthemes-import-wxr" ).trigger( "click" );
				}
			});
		},
		
		/**
		 * 2. Prepare XML Data.
		 */
		_importPrepareXML: function( event ) {

			$.ajax({
				url  : lqthemes_companion_admin.ajaxurl,
				type : 'POST',
				dataType: 'json',
				data : {
					action  : 'lqthemes-sites-import-wxr',
					wxr_url : LQThemesImporter.wxr_url,
				},
				beforeSend: function() {
					$('.lqthemes-theme-info').append('<div class="import-return-info">'+lqlthemesSiteImporter.i18n.s4+'</div>');
					$('.lqthemes-import-wxr').text( lqlthemesSiteImporter.i18n.s4 );
				},
			})
			.fail(function( jqXHR ){
				
				$('.lqthemes-theme-info').append('<div class="import-return-info notice-error">'+jqXHR.status + ' ' + jqXHR.responseText+'</div>');
		    })
			.done(function ( xml_data ) {

				// 2. Fail - Prepare XML Data.
				if( false === xml_data.success ) {
					
					$('.lqthemes-theme-info').append('<div class="import-return-info notice-error">'+lqlthemesSiteImporter.i18n.s5+'</div>');
					$('.lqthemes-theme-info').append('<div class="import-return-info notice-error">'+xml_data.data+'</div>');
					
					
				} 
					
					// 2. Pass - Prepare XML Data.
					// Import XML though Event Source.
					LQThemesSSEImport.data = xml_data.data;
					LQThemesSSEImport.render();
					
					$('.lqthemes-theme-info').append('<div class="import-return-info">'+lqlthemesSiteImporter.i18n.s6_1+'</div>');
					$('.lqthemes-import-wxr').text( lqlthemesSiteImporter.i18n.s6 );
										
					var evtSource = new EventSource( LQThemesSSEImport.data.url );
					evtSource.onmessage = function ( message ) {
						var data = JSON.parse( message.data );
						switch ( data.action ) {
							case 'updateDelta':
									LQThemesSSEImport.updateDelta( data.type, data.delta );
								break;

							case 'complete':
								evtSource.close();

								// 2. Pass - Import XML though "Source Event".
								$('.lqthemes-import-wxr').text( lqlthemesSiteImporter.i18n.s7 );
								$('.lqthemes-theme-info').append('<div class="import-return-info notice-success">'+lqlthemesSiteImporter.i18n.s7+'</div>');
								
								$('.lqthemes-import-wxr').removeClass( 'lqthemes-import-wxr' ).addClass('lqthemes-import-options lqthemes-sites-import-xml-done');
								
								$(document).trigger( 'lqthemes-sites-import-xml-done' );
								
								$( ".lqthemes-import-options" ).trigger( "click" );
								
								

								break;
						}
					};
					evtSource.addEventListener( 'log', function ( message ) {
						var data = JSON.parse( message.data );
						if( data.level !== 'warning' ){
							$('.lqthemes-theme-info').append( "<p class='import-return-info'>" + data.level + ': ' + data.message + "</p>" );
						}
					});	
					
			});
		},
		
		/**
		 * 3. Import Site Options.
		 */
		_importSiteOptions: function( event ) {

			$.ajax({
				url  : lqthemes_companion_admin.ajaxurl,
				type : 'POST',
				dataType: 'json',
				data : {
					action       : 'lqthemes-sites-import-options',
					options_data : LQThemesImporter.options_data,
				},
				beforeSend: function() {
					$('.lqthemes-theme-info').append('<div class="import-return-info">'+lqlthemesSiteImporter.i18n.s8+'</div>');
					$('.lqthemes-import-options').text( lqlthemesSiteImporter.i18n.s8 );
				},
			})
			.fail(function( jqXHR ){
				$('.lqthemes-theme-info').append('<div class="import-return-info notice-error">'+jqXHR.status + ' ' + jqXHR.responseText+'</div>');
				$('.lqthemes-import-options').text( lqlthemesSiteImporter.i18n.s9 );
		    })
			.done(function ( options_data ) {

				// 3. Fail - Import Site Options.
				if( false === options_data.success ) {
					$('.lqthemes-theme-info').append('<div class="import-return-info notice-error">'+lqlthemesSiteImporter.i18n.s9+'</div>');
					$('.lqthemes-import-options').text( lqlthemesSiteImporter.i18n.s9 );

				} else {

					// 3. Pass - Import Site Options.
					$('.lqthemes-theme-info').append('<div class="import-return-info notice-success">'+ lqlthemesSiteImporter.i18n.s10 +'</div>');
					$('.lqthemes-import-options').text( lqlthemesSiteImporter.i18n.s10 );
					
					$('.lqthemes-import-options').removeClass( 'lqthemes-import-options' ).addClass('lqthemes-import-widgets lqthemes-sites-import-options-done');
					$(document).trigger( 'lqthemes-sites-import-options-done' );
					$( ".lqthemes-import-widgets" ).trigger( "click" );
				}
			});
		},
		
		/**
		 * 4. Import Widgets.
		 */
		_importWidgets: function( event ) {

			$.ajax({
				url  : lqthemes_companion_admin.ajaxurl,
				type : 'POST',
				dataType: 'json',
				data : {
					action       : 'lqthemes-sites-import-widgets',
					widgets_data : LQThemesImporter.widgets_data,
				},
				beforeSend: function() {
					$('.lqthemes-theme-info').append('<div class="import-return-info">'+lqlthemesSiteImporter.i18n.s11+'</div>');
					$('.lqthemes-import-widgets').text( lqlthemesSiteImporter.i18n.s11 );
				},
			})
			.fail(function( jqXHR ){
				//$('.lqthemes-theme-info').append('<div class="import-return-info">'+lqlthemesSiteImporter.i18n.s11+'</div>');
				$('.lqthemes-theme-info').append('<div class="import-return-info notice-error">'+jqXHR.status + ' ' + jqXHR.responseText+'</div>');
				$('.lqthemes-import-widgets').text( lqlthemesSiteImporter.i18n.s12 );

		    })
			.done(function ( widgets_data ) {

				// 4. Fail - Import Widgets.
				if( false === widgets_data.success ) {
					$('.lqthemes-import-widgets').text( lqlthemesSiteImporter.i18n.s12 );
					$('.lqthemes-theme-info').append('<div class="import-return-info notice-error">'+widgets_data.data+'</div>');

				} else {
					
					// 4. Pass - Import Widgets.
					$('.lqthemes-theme-info').append('<div class="import-return-info notice-success">'+lqlthemesSiteImporter.i18n.s13+'</div>');
					$('.lqthemes-import-widgets').removeClass( 'lqthemes-import-widgets' ).addClass('lqthemes-sites-import-done lqthemes-sites-import-widgets-done');
					$(document).trigger( 'lqthemes-sites-import-widgets-done' );	
					$( ".lqthemes-sites-import-done" ).trigger( "click" );				
				}
			});
		},
		
		_importEnd: function( event ) {

			$('.lqthemes-sites-import-done').text( lqlthemesSiteImporter.i18n.s14 );
			$('.lqthemes-theme-info').append('<div class="import-return-info notice-success">'+lqlthemesSiteImporter.i18n.s14_1+'</div>');
			$('.lqthemes-import-button').removeClass( 'lqthemes-sites-import-done' );
		},
		checkAndInstallPlugins:function () {
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
								LQThemesImporter.activatePlugin( response.activateUrl, plugin );
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
						LQThemesImporter.activatePlugin( activateUrl, plugin );
					}
				}
			);
		}
	},

	activatePlugin: function ( activationUrl, plugin ) {
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
						$( '.lqthemes-import-site' ).trigger( 'click' );
					}
				}
			}
		);
	}

	}
	
	$(function(){
		LQThemesImporter.init();
	});
	
})(jQuery);