( function( $ ) {
	"use strict";

	$( document ).on( 'ready', function() {

		// Show/hide header options
		var headerField          	= $( '#butterbean-control-lqthemes_display_header .buttonset-input' ),
			headerMainSettings   	= $( '#butterbean-control-lqthemes_header_style' );

		if ( $( '#butterbean-control-lqthemes_display_header #butterbean_lqthemes_mb_settings_setting_lqthemes_display_header_off' ).is( ':checked' ) ) {
			headerMainSettings.hide();
		} else {
			headerMainSettings.show();
		}

		headerField.change( function () {

			if ( $( this ).val() === 'off' ) {
				headerMainSettings.hide();
			} else {
				headerMainSettings.show();
			}

		} );

		// Show/hide custom header template field
		var headerStyleField        = $( '#butterbean-control-lqthemes_header_style select' ),
			headerStyleFieldVal  	= headerStyleField.val(),
			customHeaderSetting 	= $( '#butterbean-control-lqthemes_custom_header_template' );

		customHeaderSetting.hide();

		if ( headerStyleFieldVal === 'custom' ) {
			customHeaderSetting.show();
		}

		if ( $( '#butterbean-control-lqthemes_display_header #butterbean_lqthemes_mb_settings_setting_lqthemes_display_header_off' ).is( ':checked' ) ) {
			customHeaderSetting.hide();
		}

		headerField.change( function () {

			if ( $( this ).val() === 'off' ) {
				customHeaderSetting.hide();
			} else {
				var headerStyleFieldVal = headerStyleField.val();

				if ( headerStyleFieldVal === 'custom' ) {
					customHeaderSetting.show();
				}
			}

		} );

		headerStyleField.change( function () {

			customHeaderSetting.hide();

			if ( $( this ).val() == 'custom' ) {
				customHeaderSetting.show();
			}

		} );

		// Show/hide left menu for center header style
		var leftMenuSetting = $( '#butterbean-control-lqthemes_center_header_left_menu' );

		leftMenuSetting.hide();

		if ( headerStyleFieldVal === 'center' ) {
			leftMenuSetting.show();
		}

		if ( $( '#butterbean-control-lqthemes_display_header #butterbean_lqthemes_mb_settings_setting_lqthemes_display_header_off' ).is( ':checked' ) ) {
			leftMenuSetting.hide();
		}

		headerField.change( function () {

			if ( $( this ).val() === 'off' ) {
				leftMenuSetting.hide();
			} else {
				var headerStyleFieldVal = headerStyleField.val();

				if ( headerStyleFieldVal === 'center' ) {
					leftMenuSetting.show();
				}
			}

		} );

		headerStyleField.change( function () {

			leftMenuSetting.hide();

			if ( $( this ).val() == 'center' ) {
				leftMenuSetting.show();
			}

		} );

	

		// Show/hide breadcrumbs options
		var breadcrumbsField        = $( '#butterbean-control-lqthemes_disable_breadcrumbs .buttonset-input' ),
			breadcrumbsSettings   	= $( '#butterbean-control-lqthemes_breadcrumbs_color, #butterbean-control-lqthemes_breadcrumbs_separator_color, #butterbean-control-lqthemes_breadcrumbs_links_color, #butterbean-control-lqthemes_breadcrumbs_links_hover_color' );

		if ( $( '#butterbean-control-lqthemes_disable_breadcrumbs #butterbean_lqthemes_mb_settings_setting_lqthemes_disable_breadcrumbs_off' ).is( ':checked' ) ) {
			breadcrumbsSettings.hide();
		} else {
			breadcrumbsSettings.show();
		}

		breadcrumbsField.change( function () {

			if ( $( this ).val() === 'off' ) {
				breadcrumbsSettings.hide();
			} else {
				breadcrumbsSettings.show();
			}

		} );

	} );

} ) ( jQuery );