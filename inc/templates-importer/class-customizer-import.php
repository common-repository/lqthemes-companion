<?php
/**
 * Customizer Data importer class.
 */

defined( 'ABSPATH' ) or exit;

/**
 * Customizer Data importer class.
 *
 */
class LQThemes_Customizer_Import {

	/**
	 * Instance of LQThemes_Customizer_Import
	 */
	private static $_instance = null;

	/**
	 * Instantiate LQThemes_Customizer_Import
	 */
	public static function instance() {

		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}

	/**
	 * Import customizer options.
	 */
	public function import( $options ) {

		// Update LQThemes Theme customizer settings.
		if ( is_array($options) ) {
			
			self::_import_settings( $options );
		}

	}

	/**
	 * Import LQThemes Setting's

	 */
	static public function _import_settings( $options = array() ) {
		foreach ( $options as $key => $val ) {

			if ( LQThemes_Sites_Helper::_is_image_url( $val ) ) {

				$data = LQThemes_Sites_Helper::_sideload_image( $val );

				if ( ! is_wp_error( $data ) ) {
					$options[ $key ] = $data->url;
				}
			}
		}

		// Updated settings.
		update_option( LQLTHEMES_THEME_OPTION_NAME, $options );
	}
}
