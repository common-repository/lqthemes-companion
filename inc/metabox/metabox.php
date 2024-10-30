<?php
/**
 * Adds custom metabox
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// The Metabox class
if ( ! class_exists( 'Lqthemes_Post_Metabox' ) ) {

	/**
	 * Main ButterBean class.  Runs the show.
	 *
	 * @access public
	 */
	final class Lqthemes_Post_Metabox {

		private $post_types;
		private $default_control;
		private $custom_control;

		/**
		 * Register this class with the WordPress API
		 *
		 */
		private function setup_actions() {

			// Capabilities
			$capabilities = apply_filters( 'lqthemes_main_metaboxes_capabilities', 'manage_options' );

			// Post types to add the metabox to
			$this->post_types = apply_filters( 'lqthemes_main_metaboxes_post_types', array(
				'post',
				'page',
				'product',
				'elementor_library',
			) );

			// Default butterbean controls
			$this->default_control = array(
				'select',
				'color',
				'image',
				'text',
				'number',
				'textarea',
			);

			// Custom butterbean controls
			$this->custom_control = array(
				'buttonset' 		=> 'Lqthemes_ButterBean_Control_Buttonset',
				'range' 			=> 'Lqthemes_ButterBean_Control_Range',
				'media' 			=> 'Lqthemes_ButterBean_Control_Media',
				'rgba-color' 		=> 'Lqthemes_ButterBean_Control_RGBA_Color',
				'multiple-select' 	=> 'Lqthemes_ButterBean_Control_Multiple_Select',
				'editor' 			=> 'Lqthemes_ButterBean_Control_Editor',
				'typography' 		=> 'Lqthemes_ButterBean_Control_Typography',
				'iconpicker' 		=> 'Lqthemes_ButterBean_Control_Iconpicker',
			);

			// Overwrite default controls
			add_filter( 'butterbean_pre_control_template', array( $this, 'default_control_templates' ), 10, 2 );

			// Register custom controls
			add_filter( 'butterbean_control_template', array( $this, 'custom_control_templates' ), 10, 2 );

			// Register new controls types
			add_action( 'butterbean_register', array( $this, 'register_control_types' ), 10, 2 );
			
			

			if ( current_user_can( $capabilities ) ) {

				// Register fields
				add_action( 'butterbean_register', array( $this, 'register' ), 10, 2 );

				// Register fields for the posts
				add_action( 'butterbean_register', array( $this, 'posts_register' ), 10, 2 );

				// Load scripts and styles.
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			}

			// Body classes
			add_filter( 'body_class', array( $this, 'body_class' ) );

			// Left sidebar
			add_filter( 'lqthemes_get_second_sidebar', array( $this, 'get_second_sidebar' ) );

			// Sidebar
			add_filter( 'lqthemes_get_sidebar', array( $this, 'get_sidebar' ) );

			// Display top bar
			add_filter( 'lqthemes_display_top_bar', array( $this, 'display_top_bar' ) );

			// Display header
			add_filter( 'lqthemes_display_header', array( $this, 'display_header' ) );

			// Custom menu
			add_filter( 'lqthemes_custom_menu', array( $this, 'custom_menu' ) );

			// Header style
			add_filter( 'lqthemes_header_style', array( $this, 'header_style' ) );

			// Left custom menu for center geader style
			add_filter( 'lqthemes_center_header_left_menu', array( $this, 'left_custom_menu' ) );

			// Custom header template
			add_filter( 'lqthemes_custom_header_template', array( $this, 'custom_header_template' ) );

			// Custom logo
			add_filter( 'get_custom_logo', array( $this, 'custom_logo' ) );

			// getustom logo ID for the retina function
			add_filter( 'lqthemes_custom_logo', array( $this, 'custom_logo_id' ) );

			// Custom retina logo
			add_filter( 'lqthemes_retina_logo', array( $this, 'custom_retina_logo' ) );

			// Custom logo max width
			add_filter( 'lqthemes_logo_max_width', array( $this, 'custom_logo_max_width' ) );

			// Custom logo max width tablet
			add_filter( 'lqthemes_logo_max_width_tablet', array( $this, 'custom_logo_max_width_tablet' ) );

			// Custom logo max width mobile
			add_filter( 'lqthemes_logo_max_width_mobile', array( $this, 'custom_logo_max_width_mobile' ) );

			// Custom logo max height
			add_filter( 'lqthemes_logo_max_height', array( $this, 'custom_logo_max_height' ) );

			// Custom logo max height tablet
			add_filter( 'lqthemes_logo_max_height_tablet', array( $this, 'custom_logo_max_height_tablet' ) );

			// Custom logo max height mobile
			add_filter( 'lqthemes_logo_max_height_mobile', array( $this, 'custom_logo_max_height_mobile' ) );

			// Display page header
			add_filter( 'lqthemes_display_page_header', array( $this, 'display_page_header' ) );

			// Display page header heading
			add_filter( 'lqthemes_display_page_header_heading', array( $this, 'display_page_header_heading' ) );

			// Page header style
			add_filter( 'lqthemes_page_header_style', array( $this, 'page_header_style' ) );

			// Page header title
			
			add_filter( 'lqthemes_title', array( $this, 'page_header_title' ) );
			
			add_filter( 'lqt_display_titlebar', array( $this, 'display_titlebar' ) );
			add_filter( 'lqt_custom_menu', array( $this, 'custom_menu' ) );
			

			// Page header subheading
			add_filter( 'lqthemes_post_subheading', array( $this, 'page_header_subheading' ) );

			// Display breadcrumbs
			add_filter( 'lqthemes_display_breadcrumbs', array( $this, 'display_breadcrumbs' ) );

			// Page header background image
			add_filter( 'lqthemes_page_header_background_image', array( $this, 'page_header_bg_image' ) );
			
			// Page header background color
			add_filter( 'lqthemes_post_title_font_color', array( $this, 'page_header_font_color' ) );

			// Page header background color
			add_filter( 'lqthemes_post_title_background_color', array( $this, 'page_header_bg_color' ) );

			// Page header background image position
			add_filter( 'lqthemes_post_title_bg_image_position', array( $this, 'page_header_bg_image_position' ) );
			add_filter( 'lqthemes_post_title_bg_image_attachment', array( $this, 'page_header_bg_image_attachment' ) );
			add_filter( 'lqthemes_post_title_bg_image_repeat', array( $this, 'page_header_bg_image_repeat' ) );
			add_filter( 'lqthemes_post_title_bg_image_size', array( $this, 'page_header_bg_image_size' ) );

			// Page header height
			add_filter( 'lqthemes_post_title_height', array( $this, 'page_header_height' ) );

			// Page header background opacity
			add_filter( 'lqthemes_post_title_bg_overlay', array( $this, 'page_header_bg_opacity' ) );

			// Page header background overlay color
			add_filter( 'lqthemes_post_title_bg_overlay_color', array( $this, 'page_header_bg_overlay_color' ) );

			// Display footer widgets
			add_filter( 'lqthemes_display_footer_widgets', array( $this, 'display_footer_widgets' ) );

			// Display footer bottom
			add_filter( 'lqthemes_display_footer_bottom', array( $this, 'display_footer_bottom' ) );
			
			// sidebar
			add_filter( 'lqthemes_page_sidebar_layout', array( $this, 'lqthemes_post_layout' ) );
			add_filter( 'lqthemes_page_sidebar', array( $this, 'lqthemes_page_sidebar' ) );

			

		}

		/**
		 * Load scripts and styles
		 *
		 */
		public function enqueue_scripts( $hook ) {

			// Only needed on these admin screens
			if ( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' ) {
				return;
			}

			// Get global post
			global $post;

			// Return if post is not object
			if ( ! is_object( $post ) ) {
				return;
			}

			// Post types scripts
			$post_types_scripts = apply_filters( 'lqthemes_metaboxes_post_types_scripts', $this->post_types );

			// Return if wrong post type
			if ( ! in_array( $post->post_type, $post_types_scripts ) ) {
				return;
			}

			$min = ( SCRIPT_DEBUG ) ? '' : '.min';

			// Default style
			wp_enqueue_style( 'hoocompanion-butterbean', plugins_url( '/controls/assets/css/butterbean'. $min .'.css', __FILE__ ) );

			// Default script.
			wp_enqueue_script( 'hoocompanion-butterbean', plugins_url( '/controls/assets/js/butterbean'. $min .'.js', __FILE__ ), array( 'butterbean' ), '', true );

			// Metabox script
			wp_enqueue_script( 'hoocompanion-metabox-script', plugins_url( '/assets/js/metabox.min.js', __FILE__ ), array( 'jquery' ), LQLTHEMES_COMPANION_VER, true );

			// Enqueue the select2 script, I use "hoocompanion-select2" to avoid plugins conflicts
			wp_enqueue_script( 'hoocompanion-select2', plugins_url( '/controls/assets/js/select2.full.min.js', __FILE__ ), array( 'jquery' ), false, true );

			// Enqueue the select2 style
			wp_enqueue_style( 'select2', plugins_url( '/controls/assets/css/select2.min.css', __FILE__ ) );

			// Enqueue color picker alpha
			wp_enqueue_script( 'wp-color-picker-alpha', plugins_url( '/controls/assets/js/wp-color-picker-alpha.js', __FILE__ ), array( 'wp-color-picker' ), false, true );

		}
		
		

		/**
		 * Registers control types
		 *
		 */
		public function register_control_types( $butterbean ) {
			$controls = $this->custom_control;

			foreach ( $controls as $control => $class ) {

				require_once( LQLTHEMES_COMPANION_DIR. '/inc/metabox/controls/'. $control .'/class-control-'. $control .'.php' );
				$butterbean->register_control_type( $control, $class );

			}
		}

		/**
		 * Get custom control templates
		 *
		 */
		public function default_control_templates( $located, $slug ) {
			$controls = $this->default_control;

			foreach ( $controls as $control ) {

				if ( $slug === $control ) {
					return LQLTHEMES_COMPANION_DIR . '/inc/metabox/controls/'. $control .'/template.php';
				}

			}

			return $located;
		}

		/**
		 * Get custom control templates
		 *
		 */
		public function custom_control_templates( $located, $slug ) {
			$controls = $this->custom_control;

			foreach ( $controls as $control => $class ) {

				if ( $slug === $control ) {
					return LQLTHEMES_COMPANION_DIR . '/inc/metabox/controls/'. $control .'/template.php';
				}

			}

			return $located;
		}

		/**
		 * Registration callback
		 *
		 */
		public function register( $butterbean, $post_type ) {

			// Post types to add the metabox to
			$post_types = $this->post_types;

			
			$brand = apply_filters( 'lqthemes_theme_branding',  esc_html__( 'Page Settings', 'lqthemes-companion' ) );

			// Register managers, sections, controls, and settings here.
			$butterbean->register_manager(
		        'lqthemes_mb_settings',
		        array(
		            'label'     => $brand ,
		            'post_type' => $post_types,
		            'context'   => 'normal',
		            'priority'  => 'high'
		        )
		    );
						
			$manager = $butterbean->get_manager( 'lqthemes_mb_settings' );
			
			
			
			$manager->register_section(
		        'lqthemes_mb_main',
		        array(
		            'label' => esc_html__( 'Main', 'lqthemes-companion' ),
		            'icon'  => 'dashicons-admin-generic'
		        )
		    );
			
			$manager->register_control(
		        'lqthemes_header_transparent', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_main',
		            'type'    		=> 'buttonset',
		            'label'   		=> esc_html__( 'Header Transparent', 'lqthemes-companion' ),
		            'description'   => '',
					'default'       => 'default',
					'choices' 		=> array(
						'default' 	=> esc_html__( 'Default', 'lqthemes-companion' ),
						'1' 	=> esc_html__( 'Enable', 'lqthemes-companion' ),
						'-1' 		=> esc_html__( 'Disable', 'lqthemes-companion' ),
					),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_header_transparent', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_key',
		            'default' 			=> 'default',
		        )
		    );
			
			$manager->register_control(
		        'lqthemes_post_layout', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_main',
		            'type'    		=> 'select',
		            'label'   		=> esc_html__( 'Content Layout', 'ocean-extra' ),
		            'description'   => esc_html__( 'Select your custom layout.', 'ocean-extra' ),
					'choices' 		=> array(
						'' 				=> esc_html__( 'Default', 'ocean-extra' ),
						'right' => esc_html__( 'Right Sidebar', 'ocean-extra' ),
						'left' 	=> esc_html__( 'Left Sidebar', 'ocean-extra' ),
						'no' 	=> esc_html__( 'Full Width', 'ocean-extra' ),
					),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_post_layout', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_key',
		        )
		    );
		
			$manager->register_control(
		        'lqthemes_sidebar', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_main',
		            'type'    		=> 'select',
		            'label'   		=> esc_html__( 'Sidebar', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Select your custom sidebar.', 'lqthemes-companion' ),
					'choices' 		=> $this->helpers( 'widget_areas' ),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_sidebar', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_key',
		        )
		    );
			
			/*$manager->register_control(
		        'lqthemes_second_sidebar', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_main',
		            'type'    		=> 'select',
		            'label'   		=> esc_html__( 'Second Sidebar', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Select your custom second sidebar.', 'lqthemes-companion' ),
					'choices' 		=> $this->helpers( 'widget_areas' ),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_second_sidebar', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_key',
		        )
		    );*/
			
			$manager->register_section(
		        'lqthemes_mb_shortcodes',
		        array(
		            'label' => esc_html__( 'Shortcodes', 'lqthemes-companion' ),
		            'icon'  => 'dashicons-editor-code'
		        )
		    );
		
			$manager->register_control(
		        'lqthemes_shortcode_before_top_bar', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_shortcodes',
		            'type'    		=> 'text',
		            'label'   		=> esc_html__( 'Shortcode Before Top Bar', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Add your shortcode to be displayed before the top bar.', 'lqthemes-companion' ),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_shortcode_before_top_bar', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_text_field',
		        )
		    );
		
			$manager->register_control(
		        'lqthemes_shortcode_after_top_bar', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_shortcodes',
		            'type'    		=> 'text',
		            'label'   		=> esc_html__( 'Shortcode After Top Bar', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Add your shortcode to be displayed after the top bar.', 'lqthemes-companion' ),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_shortcode_after_top_bar', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_text_field',
		        )
		    );
		
			$manager->register_control(
		        'lqthemes_shortcode_before_header', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_shortcodes',
		            'type'    		=> 'text',
		            'label'   		=> esc_html__( 'Shortcode Before Header', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Add your shortcode to be displayed before the header.', 'lqthemes-companion' ),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_shortcode_before_header', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_text_field',
		        )
		    );
		
			$manager->register_control(
		        'lqthemes_shortcode_after_header', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_shortcodes',
		            'type'    		=> 'text',
		            'label'   		=> esc_html__( 'Shortcode After Header', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Add your shortcode to be displayed after the header.', 'lqthemes-companion' ),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_shortcode_after_header', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_text_field',
		        )
		    );
			
		
			$manager->register_control(
		        'lqthemes_shortcode_before_footer_widgets', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_shortcodes',
		            'type'    		=> 'text',
		            'label'   		=> esc_html__( 'Shortcode Before Footer Widgets', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Add your shortcode to be displayed before the footer widgets.', 'lqthemes-companion' ),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_shortcode_before_footer_widgets', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_text_field',
		        )
		    );
		
			$manager->register_control(
		        'lqthemes_shortcode_after_footer_widgets', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_shortcodes',
		            'type'    		=> 'text',
		            'label'   		=> esc_html__( 'Shortcode After Footer Widgets', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Add your shortcode to be displayed after the footer widgets.', 'lqthemes-companion' ),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_shortcode_after_footer_widgets', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_text_field',
		        )
		    );
		
			$manager->register_control(
		        'lqthemes_shortcode_before_footer_bottom', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_shortcodes',
		            'type'    		=> 'text',
		            'label'   		=> esc_html__( 'Shortcode Before Footer Bottom', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Add your shortcode to be displayed before the footer bottom.', 'lqthemes-companion' ),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_shortcode_before_footer_bottom', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_text_field',
		        )
		    );
		
			$manager->register_control(
		        'lqthemes_shortcode_after_footer_bottom', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_shortcodes',
		            'type'    		=> 'text',
		            'label'   		=> esc_html__( 'Shortcode After Footer Bottom', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Add your shortcode to be displayed after the footer bottom.', 'lqthemes-companion' ),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_shortcode_after_footer_bottom', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_text_field',
		        )
		    );
			
			$manager->register_section(
		        'lqthemes_mb_menu',
		        array(
		            'label' => esc_html__( 'Menu', 'lqthemes-companion' ),
		            'icon'  => 'dashicons-menu'
		        )
		    );
			
			$manager->register_control(
		        'lqthemes_header_custom_menu', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_menu',
		            'type'    		=> 'select',
		            'label'   		=> esc_html__( 'Main Navigation Menu', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Choose which menu to display on this page/post.', 'lqthemes-companion' ),
					'choices' 		=> $this->helpers( 'menus' ),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_header_custom_menu', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_key',
		        )
		    );

			$manager->register_section(
		        'lqthemes_mb_title_bar',
		        array(
		            'label' => esc_html__( 'Title Bar', 'lqthemes-companion' ),
		            'icon'  => 'dashicons-admin-tools'
		        )
		    );
			
			$manager->register_control(
		        'lqthemes_disable_title', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_title_bar',
		            'type'    		=> 'buttonset',
		            'label'   		=> esc_html__( 'Display Page Title Bar', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Enable or disable the page title.', 'lqthemes-companion' ),
					'choices' 		=> array(
						'default' 	=> esc_html__( 'Default', 'lqthemes-companion' ),
						'1' 	=> esc_html__( 'Enable', 'lqthemes-companion' ),
						'' 		=> esc_html__( 'Disable', 'lqthemes-companion' ),
					),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_disable_title', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_key',
		            'default' 			=> 'default',
		        )
		    );
			
			$manager->register_control(
		        'lqthemes_post_title_font_color', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_title_bar',
		            'type'    		=> 'color',
		            'label'   		=> esc_html__( 'Font Color', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Select a hex color code, ex: #333', 'lqthemes-companion' ),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_post_title_font_color', // Same as control name.
		        array(
		            'sanitize_callback' => 'butterbean_maybe_hash_hex_color',
					'default' 			=> '',
		        )
		    );
			
			
			$manager->register_control(
		        'lqthemes_post_title_background_color', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_title_bar',
		            'type'    		=> 'color',
		            'label'   		=> esc_html__( 'Background Color', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Select a hex color code, ex: #333', 'lqthemes-companion' ),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_post_title_background_color', // Same as control name.
		        array(
		            'sanitize_callback' => 'butterbean_maybe_hash_hex_color',
					'default' 			=> '',
		        )
		    );
			
			$manager->register_control(
		        'lqthemes_post_title_background', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_title_bar',
		            'type'    		=> 'image',
		            'label'   		=> esc_html__( 'Background Image', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Select a custom image for your main title.', 'lqthemes-companion' ),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_post_title_background', // Same as control name.
		        array(
		        	'sanitize_callback' => 'sanitize_key',
		        )
		    );

		    $manager->register_control(
		        'lqthemes_post_title_bg_image_position', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_title_bar',
		            'type'    		=> 'select',
		            'label'   		=> esc_html__( 'Position', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Select your background image position.', 'lqthemes-companion' ),
					'choices' 		=> array(
						'' 					=> esc_html__( 'Default', 'lqthemes-companion' ),
						'top left' 			=> esc_html__( 'Top Left', 'lqthemes-companion' ),
						'top center' 		=> esc_html__( 'Top Center', 'lqthemes-companion' ),
						'top right'  		=> esc_html__( 'Top Right', 'lqthemes-companion' ),
						'center left' 		=> esc_html__( 'Center Left', 'lqthemes-companion' ),
						'center center' 	=> esc_html__( 'Center Center', 'lqthemes-companion' ),
						'center right' 		=> esc_html__( 'Center Right', 'lqthemes-companion' ),
						'bottom left' 		=> esc_html__( 'Bottom Left', 'lqthemes-companion' ),
						'bottom center' 	=> esc_html__( 'Bottom Center', 'lqthemes-companion' ),
						'bottom right' 		=> esc_html__( 'Bottom Right', 'lqthemes-companion' ),
					),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_post_title_bg_image_position', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_text_field',
		        )
		    );

		    $manager->register_control(
		        'lqthemes_post_title_bg_image_attachment', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_title_bar',
		            'type'    		=> 'select',
		            'label'   		=> esc_html__( 'Attachment', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Select your background image attachment.', 'lqthemes-companion' ),
					'choices' 		=> array(
						'' 			=> esc_html__( 'Default', 'lqthemes-companion' ),
						'scroll' 	=> esc_html__( 'Scroll', 'lqthemes-companion' ),
						'fixed' 	=> esc_html__( 'Fixed', 'lqthemes-companion' ),
					),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_post_title_bg_image_attachment', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_key',
		        )
		    );

		    $manager->register_control(
		        'lqthemes_post_title_bg_image_repeat', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_title_bar',
		            'type'    		=> 'select',
		            'label'   		=> esc_html__( 'Repeat', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Select your background image repeat.', 'lqthemes-companion' ),
					'choices' 		=> array(
						'' 			=> esc_html__( 'Default', 'lqthemes-companion' ),
						'no-repeat' => esc_html__( 'No-repeat', 'lqthemes-companion' ),
						'repeat' 	=> esc_html__( 'Repeat', 'lqthemes-companion' ),
						'repeat-x' 	=> esc_html__( 'Repeat-x', 'lqthemes-companion' ),
						'repeat-y' 	=> esc_html__( 'Repeat-y', 'lqthemes-companion' ),
					),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_post_title_bg_image_repeat', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_key',
		        )
		    );

		    $manager->register_control(
		        'lqthemes_post_title_bg_image_size', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_title_bar',
		            'type'    		=> 'select',
		            'label'   		=> esc_html__( 'Size', 'lqthemes-companion' ),
		            'description'   => esc_html__( 'Select your background image size.', 'lqthemes-companion' ),
					'choices' 		=> array(
						'' 			=> esc_html__( 'Default', 'lqthemes-companion' ),
						'auto' 		=> esc_html__( 'Auto', 'lqthemes-companion' ),
						'cover' 	=> esc_html__( 'Cover', 'lqthemes-companion' ),
						'contain' 	=> esc_html__( 'Contain', 'lqthemes-companion' ),
					),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_post_title_bg_image_size', // Same as control name.
		        array(
		            'sanitize_callback' => 'sanitize_key',
		        )
		    );
			
			
		}

		/**
		 * Registration callback
		 *
		 */
		public function posts_register( $butterbean, $post_type ) {

			// Return if it is not Post post type
			if ( 'post' != $post_type ) {
				return;
			}

			// Gets the manager object we want to add sections to.
			$manager = $butterbean->get_manager( 'lqthemes_mb_settings' );
						
			$manager->register_section(
		        'lqthemes_mb_video',
		        array(
		            'label' => esc_html__( 'Video', 'lqthemes-companion' ),
		            'icon'  => 'dashicons-format-video'
		        )
		    );

		   $manager->register_control(
		        'lqthemes_video_url', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_video',
		            'type'    		=> 'text',
		            'label'   		=> esc_html__( 'YouTube or Vimeo Video URL', 'lqthemes-companion' ),
		            'description'   => '',
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_video_url', // Same as control name.
		        array(
		            'sanitize_callback' => 'esc_url_raw',
		        )
		    );
			
			 $manager->register_control(
		        'lqthemes_video_height', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_video',
		            'type'    		=> 'text',
		            'label'   		=> esc_html__( 'Video Iframe Height', 'lqthemes-companion' ),
		            'description'   => '',
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_video_height', // Same as control name.
		        array(
		            'sanitize_callback' => 'absint',
					'default'   => '400',
		        )
		    );
			
			$manager->register_control(
		        'lqthemes_video_autoplay', // Same as setting name.
		        array(
		            'section' 		=> 'lqthemes_mb_video',
		            'type'    		=> 'buttonset',
		            'label'   		=> esc_html__( 'AutoPlay', 'lqthemes-companion' ),
		            'description'   => '',
					'choices' 		=> array(
						'0' 		=> esc_html__( 'No', 'lqthemes-companion' ),
						'1' 	=> esc_html__( 'Yes', 'lqthemes-companion' ),
					),
		        )
		    );
			
			$manager->register_setting(
		        'lqthemes_video_autoplay', // Same as control name.
		        array(
		            'sanitize_callback' => 'absint',
		            'default' 			=> '0',
		        )
		    );
			
			

		}

		/**
		 * Sanitize function for integers
		 */
		public function sanitize_absint( $value ) {
			return $value && is_numeric( $value ) ? absint( $value ) : '';
		}

		/**
		 * Helpers
		 */
		public static function helpers( $return = NULL ) {

			// Return array of WP menus
			if ( 'menus' == $return ) {
				$menus 		= array( esc_html__( 'Default', 'lqthemes-companion' ) );
				$get_menus 	= get_terms( 'nav_menu', array( 'hide_empty' => true ) );
				foreach ( $get_menus as $menu) {
					$menus[$menu->slug] = $menu->name;
				}
				return $menus;
			}

			// Header template
			elseif ( 'library' == $return ) {
				$templates 		= array( esc_html__( 'Select a Template', 'lqthemes-companion' ) );
				$get_templates 	= get_posts( array( 'post_type' => 'lqthemes_library', 'numberposts' => -1, 'post_status' => 'publish' ) );

			    if ( ! empty ( $get_templates ) ) {
			    	foreach ( $get_templates as $template ) {
						$templates[ $template->ID ] = $template->post_title;
				    }
				}

				return $templates;
			}

			// Title styles
			elseif ( 'title_styles' == $return ) {
				return apply_filters( 'lqthemes_title_styles', array(
					''                 => esc_html__( 'Default', 'lqthemes-companion' ),
					'default'          => esc_html__( 'Default Style', 'lqthemes-companion' ),
					'centered'         => esc_html__( 'Centered', 'lqthemes-companion' ),
					'centered'         => esc_html__( 'Centered', 'lqthemes-companion' ),
					'centered-minimal' => esc_html__( 'Centered Minimal', 'lqthemes-companion' ),
					'background-image' => esc_html__( 'Background Image', 'lqthemes-companion' ),
					'solid-color'      => esc_html__( 'Solid Color and White Text', 'lqthemes-companion' ),
				) );
			}

			// Widgets
			elseif ( 'widget_areas' == $return ) {
				global $wp_registered_sidebars;
				$widgets_areas = array( esc_html__( 'Default', 'lqthemes-companion' ) );
				$get_widget_areas = $wp_registered_sidebars;
				if ( ! empty( $get_widget_areas ) ) {
					foreach ( $get_widget_areas as $widget_area ) {
						$name = isset ( $widget_area['name'] ) ? $widget_area['name'] : '';
						$id = isset ( $widget_area['id'] ) ? $widget_area['id'] : '';
						if ( $name && $id ) {
							$widgets_areas[$id] = $name;
						}
					}
				}
				return $widgets_areas;
			}

		}

		/**
		 * Body classes
		 */
		public function body_class( $classes ) {
			
			// Disabled margins
			if ( 'on' == get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_disable_margins', true )
				&& ! is_search() ) {
				$classes[] = 'no-margins';
			}

			return $classes;

		}
		
		 // display titlebar
		function display_titlebar( $titlebar ){
			
		   $display_titlebar = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_disable_title', true );
		   
		  if( !$display_titlebar || $display_titlebar == 'default' )
		  	$display_titlebar = $titlebar;
			
		   if( $display_titlebar == 'enable' )
			  $display_titlebar = 1;
		  if( $display_titlebar == 'on' )
			  $display_titlebar = '';
		 
		  	
	  
		   return $display_titlebar;
		  }
		  
	/**
	 * Custom menu
	 *
	 */
	public function custom_menu( $menu ) {
			
		if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_header_custom_menu', true ) ) {
			$menu = $meta;
		}
			return $menu;


	}
	
	/**
	 * Get custom sidebar layout
	 *
	 */
	function lqthemes_post_layout( $layout ){
		
		if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_layout', true ) ) {
			$layout = $meta;
		}

		return $layout;
		}
		
		/**
	 * Get custom sidebar
	 *
	 */
	function lqthemes_page_sidebar( $sidebar ){
		
		if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_sidebar', true ) ) {
			$sidebar = $meta;
		}

		return $sidebar;
		}
		
		

		/**
		 * Returns the correct second sidebar ID
		 *
		 */
		public function get_second_sidebar( $sidebar ) {
			
			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_second_sidebar', true ) ) {
				$sidebar = $meta;
			}

			return $sidebar;

		}

		/**
		 * Returns the correct sidebar ID
		 *
		 */
		public function get_sidebar( $sidebar ) {
			
			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_sidebar', true ) ) {
				$sidebar = $meta;
			}

			return $sidebar;

		}

		/**
		 * Display top bar
		 *
		 */
		public function display_top_bar( $return ) {
			
			// Check meta
			$meta = LqlhemesCompanion::post_id() ? get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_display_top_bar', true ) : '';

			// Check if disabled
			if ( 'on' == $meta ) {
				$return = true;
			} elseif ( 'off' == $meta ) {
				$return = false;
			}

			return $return;

		}

		/**
		 * Display header
		 *
		 */
		public function display_header( $return ) {
			
			// Check meta
			$meta = LqlhemesCompanion::post_id() ? get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_display_header', true ) : '';

			// Check if disabled
			if ( 'on' == $meta ) {
				$return = true;
			} elseif ( 'off' == $meta ) {
				$return = false;
			}

			return $return;

		}


		/**
		 * Header style
		 *
		 */
		public function header_style( $style ) {
			
			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_header_style', true ) ) {
				$style = $meta;
			}

			return $style;

		}

		/**
		 * Left custom menu for center geader style
		 *
		 */
		public function left_custom_menu( $menu ) {
			
			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_center_header_left_menu', true ) ) {
				$menu = $meta;
			}
			
			return $menu;

		}

		/**
		 * Custom header template
		 *
		 */
		public function custom_header_template( $template ) {
			
			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_custom_header_template', true ) ) {
				$template = $meta;
			}

			return $template;

		}

		/**
		 * Custom logo
		 *
		 */
		public function custom_logo( $html ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_custom_logo', true ) ) {

				$html = '';

				// We have a logo. Logo is go.
				if ( $meta ) {

					$custom_logo_attr = array(
						'class'    => 'custom-logo',
						'itemprop' => 'logo',
					);

					/*
					 * If the logo alt attribute is empty, get the site title and explicitly
					 * pass it to the attributes used by wp_get_attachment_image().
					 */
					$image_alt = get_post_meta( $meta, '_wp_attachment_image_alt', true );
					if ( empty( $image_alt ) ) {
						$custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
					}

					/*
					 * If the alt attribute is not empty, there's no need to explicitly pass
					 * it because wp_get_attachment_image() already adds the alt attribute.
					 */
					$html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
						esc_url( home_url( '/' ) ),
						wp_get_attachment_image( $meta, 'full', false, $custom_logo_attr )
					);

				}

			}

			return $html;

		}

		/**
		 * Custom logo ID
		 *
		 */
		public function custom_logo_id( $logo_url ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_custom_logo', true ) ) {
				$logo_url = $meta;
			}

			return $logo_url;

		}

		/**
		 * Custom retina logo
		 *
		 */
		public function custom_retina_logo( $logo_url ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_custom_retina_logo', true ) ) {
				$logo_url = $meta;

				// Generate image URL if using ID
				if ( is_numeric( $logo_url ) ) {
					$logo_url = wp_get_attachment_image_src( $logo_url, 'full' );
					$logo_url = $logo_url[0];
				}
			}

			return $logo_url;

		}

		/**
		 * Custom logo max width
		 *
		 */
		public function custom_logo_max_width( $width ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_custom_logo_max_width', true ) ) {
				$width = $meta;
			}

			return $width;

		}

		/**
		 * Custom logo max width tablet
		 */
		public function custom_logo_max_width_tablet( $width ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_custom_logo_tablet_max_width', true ) ) {
				$width = $meta;
			}

			return $width;

		}

		/**
		 * Custom logo max width mobile
		 *
		 */
		public function custom_logo_max_width_mobile( $width ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_custom_logo_mobile_max_width', true ) ) {
				$width = $meta;
			}

			return $width;

		}

		/**
		 * Custom logo max height
		 *
		 */
		public function custom_logo_max_height( $height ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_custom_logo_max_height', true ) ) {
				$height = $meta;
			}

			return $height;

		}

		/**
		 * Custom logo max height tablet
		 *
		 */
		public function custom_logo_max_height_tablet( $height ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_custom_logo_tablet_max_height', true ) ) {
				$height = $meta;
			}

			return $height;

		}

		/**
		 * Custom logo max height mobile
		 *
		 */
		public function custom_logo_max_height_mobile( $height ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_custom_logo_mobile_max_height', true ) ) {
				$height = $meta;
			}

			return $height;

		}

		/**
		 * Menu links color
		 *
		 */
		public function menu_link_color( $color ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_menu_link_color', true ) ) {
				$color = $meta;
			}

			return $color;

		}

		/**
		 * Menu links color: hover
		 *
		 */
		public function menu_link_color_hover( $color ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_menu_link_color_hover', true ) ) {
				$color = $meta;
			}

			return $color;

		}

		/**
		 * Menu links color: current menu item
		 *
		 */
		public function menu_link_color_active( $color ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_menu_link_color_active', true ) ) {
				$color = $meta;
			}

			return $color;

		}

		/**
		 * Menu links background
		 *
		 */
		public function menu_link_background( $color ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_menu_link_background', true ) ) {
				$color = $meta;
			}

			return $color;

		}

		/**
		 * Menu links background: hover
		 *
		 */
		public function menu_link_hover_background( $color ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_menu_link_hover_background', true ) ) {
				$color = $meta;
			}

			return $color;

		}

		/**
		 * Menu links background: current menu item
		 */
		public function menu_link_active_background( $color ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_menu_link_active_background', true ) ) {
				$color = $meta;
			}

			return $color;

		}

		/**
		 * Social menu links background color
		 *
		 */
		public function menu_social_links_bg( $color ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_menu_social_links_bg', true ) ) {
				$color = $meta;
			}

			return $color;

		}

		/**
		 * Social menu hover links background color
		 *
		 */
		public function menu_social_hover_links_bg( $color ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_menu_social_hover_links_bg', true ) ) {
				$color = $meta;
			}

			return $color;

		}

		/**
		 * Social menu links color
		 *
		 */
		public function menu_social_links_color( $color ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_menu_social_links_color', true ) ) {
				$color = $meta;
			}

			return $color;

		}

		/**
		 * Social menu hover links color
		 *
		 */
		public function menu_social_hover_links_color( $color ) {

			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_menu_social_hover_links_color', true ) ) {
				$color = $meta;
			}

			return $color;

		}

		/**
		 * Display page header
		 *
		 */
		public function display_page_header( $return ) {
			
			// Check meta
			$meta = LqlhemesCompanion::post_id() ? get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_disable_title', true ) : '';

			// Check if enabled or disabled
			if ( 'enable' == $meta ) {
				$return = true;
			} elseif ( 'on' == $meta ) {
				$return = false;
			}

			return $return;

		}

		/**
		 * Display page header heading
		 *
		 */
		public function display_page_header_heading( $return ) {
			
			// Check meta
			$meta = LqlhemesCompanion::post_id() ? get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_disable_heading', true ) : '';

			// Check if enabled or disabled
			if ( 'enable' == $meta ) {
				$return = true;
			} elseif ( 'on' == $meta ) {
				$return = false;
			}

			return $return;

		}

		/**
		 * Page header style
		 *
		 */
		public function page_header_style( $style ) {
			
			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_style', true ) ) {
				$style = $meta;
			}

			return $style;

		}

		/**
		 * Page header title
		 */
		public function page_header_title( $title ) {
			
			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title', true ) ) {
				$title = $meta;
			}

			return $title;

		}

		/**
		 * Page header subheading
		 *
		 */
		public function page_header_subheading( $subheading ) {
			
			if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_subheading', true ) ) {
				$subheading = $meta;
			}

			return $subheading;

		}

		/**
		 * Display breadcrumbs
		 *

		 */
		public function display_breadcrumbs( $return ) {
			
			// Check meta
			$meta = LqlhemesCompanion::post_id() ? get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_disable_breadcrumbs', true ) : '';

			// Check if enabled or disabled
			if ( 'on' == $meta ) {
				$return = true;
			} elseif ( 'off' == $meta ) {
				$return = false;
			}

			return $return;

		}
		
		/**
		 * Title font color
		 *

		 */
		public function page_header_font_color( $font_color ) {

				if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_font_color', true ) ) {
					$font_color = $meta;
				}

			return $font_color;

		}


		/**
		 * Title background color
		 *

		 */
		public function page_header_bg_color( $bg_color ) {

				if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_background_color', true ) ) {
					$bg_color = $meta;
				}

			return $bg_color;

		}

		/**
		 * Title background image
		 *

		 */
		public function page_header_bg_image( $bg_img ) {

				if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_background', true ) ) {
					$bg_img = $meta;
				}

			return $bg_img;

		}

		/**
		 * Title background image position
		 *

		 */
		public function page_header_bg_image_position( $bg_img_position ) {

				if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_bg_image_position', true ) ) {
					$bg_img_position = $meta;
				}

			return $bg_img_position;

		}

		/**
		 * Title background image attachment
		 *

		 */
		public function page_header_bg_image_attachment( $bg_img_attachment ) {

			if ( 'background-image' == get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_style', true ) ) {
				if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_bg_image_attachment', true ) ) {
					$bg_img_attachment = $meta;
				}
			}

			return $bg_img_attachment;

		}

		/**
		 * Title background image repeat
		 *

		 */
		public function page_header_bg_image_repeat( $bg_img_repeat ) {

			if ( 'background-image' == get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_style', true ) ) {
				if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_bg_image_repeat', true ) ) {
					$bg_img_repeat = $meta;
				}
			}

			return $bg_img_repeat;

		}

		/**
		 * Title background image size
		 *

		 */
		public function page_header_bg_image_size( $bg_img_size ) {

			if ( 'background-image' == get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_style', true ) ) {
				if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_bg_image_size', true ) ) {
					$bg_img_size = $meta;
				}
			}

			return $bg_img_size;

		}

		/**
		 * Title height
		 *

		 */
		public function page_header_height( $title_height ) {

			if ( 'background-image' == get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_style', true ) ) {
				if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_height', true ) ) {
					$title_height = $meta;
				}
			}

			return $title_height;

		}

		/**
		 * Title background opacity
		 *

		 */
		public function page_header_bg_opacity( $opacity ) {

			if ( 'background-image' == get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_style', true ) ) {
				if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_bg_overlay', true ) ) {
					$opacity = $meta;
				}
			}

			return $opacity;

		}

		/**
		 * Title background overlay color
		 *

		 */
		public function page_header_bg_overlay_color( $overlay_color ) {

			if ( 'background-image' == get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_style', true ) ) {
				if ( $meta = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_post_title_bg_overlay_color', true ) ) {
					$overlay_color = $meta;
				}
			}

			return $overlay_color;

		}

		/**
		 * Display footer widgets
		 *

		 */
		public function display_footer_widgets( $return ) {
			
			// Check meta
			$meta = LqlhemesCompanion::post_id() ? get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_display_footer_widgets', true ) : '';

			// Check if disabled
			if ( 'on' == $meta ) {
				$return = true;
			} elseif ( 'off' == $meta ) {
				$return = false;
			}

			return $return;

		}

		/**
		 * Display footer bottom
		 *

		 */
		public function display_footer_bottom( $return ) {
			
			// Check meta
			$meta = LqlhemesCompanion::post_id() ? get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_display_footer_bottom', true ) : '';

			// Check if disabled
			if ( 'on' == $meta ) {
				$return = true;
			} elseif ( 'off' == $meta ) {
				$return = false;
			}

			return $return;

		}


		/**
		 * Returns the instance.
		 *

		 * @access public
		 * @return object
		 */
		public static function get_instance() {
			static $instance = null;
			if ( is_null( $instance ) ) {
				$instance = new self;
				$instance->setup_actions();
			}
			return $instance;
		}

		/**
		 * Constructor method.
		 *

		 * @access private
		 * @return void
		 */
		private function __construct() {}

	}

	Lqthemes_Post_Metabox::get_instance();

}