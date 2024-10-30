<?php
/*
	Plugin Name: LQThemes Companion
	Description: LQThemes templates importer.
	Author: LQThemes
	Author URI: https://lqthemes.com/
	Version: 1.0.5
	Text Domain: lqthemes-companion
	Domain Path: /languages
	License: GPL v2 or later
*/

defined('ABSPATH') or die("No script kiddies please!");

define( 'LQLTHEMES_COMPANION_DIR',  plugin_dir_path( __FILE__ ) );
define( 'LQLTHEMES_COMPANION_URL',  plugins_url( '', __FILE__ ) );
define( 'LQLTHEMES_COMPANION_VER',  '1.0.5' );


require_once LQLTHEMES_COMPANION_DIR.'inc/widget-recent-posts.php';
require_once LQLTHEMES_COMPANION_DIR.'inc/LQThemes_Taxonomy_Images.php';
require_once LQLTHEMES_COMPANION_DIR.'inc/templates-importer/templates-importer.php';

require_once LQLTHEMES_COMPANION_DIR.'inc/templates-importer/class-sites-helper.php';
require_once LQLTHEMES_COMPANION_DIR.'inc/templates-importer/class-customizer-import.php';
require_once LQLTHEMES_COMPANION_DIR.'inc/templates-importer/wxr-importer/class-lqthemes-wxr-importer.php';
require_once LQLTHEMES_COMPANION_DIR.'inc/templates-importer/class-site-options-import.php';
require_once LQLTHEMES_COMPANION_DIR.'inc/templates-importer/class-widgets-importer.php';
require_once LQLTHEMES_COMPANION_DIR.'inc/templates-importer/sites-importer.php';

require_once 'inc/elementor-widgets/elementor-widgets.php';

if (!class_exists('LqlhemesCompanion')){

	class LqlhemesCompanion{	
		public $slider = array();
		public function __construct($atts = NULL)
		{

			$theme = wp_get_theme();
			$prefix = 'lqthemes_';
			
			$option_name = $theme->get( 'Template' );
			if( $option_name == '' )
				$option_name = $theme->get( 'TextDomain' );
			
			define( 'LQLTHEMES_THEME_OPTION_NAME', sanitize_title($option_name) );

			register_activation_hook( __FILE__, array(&$this ,'plugin_activate') );
			add_action( 'plugins_loaded', array(&$this, 'plugins_loaded' ) );
			add_action( 'admin_menu', array(&$this ,'plugin_menu') );
			add_action( 'switch_theme', array(&$this ,'plugin_activate') );
			add_action( 'wp_enqueue_scripts',  array(&$this , 'enqueue_scripts' ));
			add_action( 'admin_enqueue_scripts',  array(&$this , 'enqueue_admin_scripts' ));
			add_action( 'wp_footer', array( $this, 'gridlist_set_default_view' ) );			
			add_action('init', array(&$this , 'init') );
			add_action( 'init',  array(&$this ,'post_template_part') );
			add_action('lqt_header_classes', array(&$this , 'header_classes') );			
			
			//add_action( 'customize_controls_init', array( &$this,'customize_controls_enqueue') );

		}
		
	
	function init(){
		
		require_once( LQLTHEMES_COMPANION_DIR .'/inc/metabox/controls/typography/webfonts.php' );
		require_once( LQLTHEMES_COMPANION_DIR .'/inc/metabox/butterbean/butterbean.php' );
		require_once( LQLTHEMES_COMPANION_DIR .'/inc/metabox/metabox.php' );
		require_once( LQLTHEMES_COMPANION_DIR .'/inc/metabox/shortcodes.php' );
		require_once( LQLTHEMES_COMPANION_DIR .'/inc/metabox/gallery-metabox/gallery-metabox.php' );
		
	}
	
	/**
   * Custom header classes
  */
	function header_classes( $classes ){
		
		$header_transparent = get_post_meta( LqlhemesCompanion::post_id(), 'lqthemes_header_transparent', true );
		if( $header_transparent == '1' ){
			$classes .= ' transparent';
			}
		
		return $classes;
		
		}
	

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 */
	function customize_controls_enqueue(){
		//wp_enqueue_script( 'lqthemes_companion_customizer_controls',  plugins_url('/assets/js/customizer.js', __FILE__), '', '1.0.0', true );
			
	}
	
  /**
	 * Gets and returns url body using wp_remote_get
	 *
	 */
	public static function get_remote( $url ) {

		// Get data
		$response = wp_remote_get( $url );

		// Check for errors
		if ( is_wp_error( $response ) or ( wp_remote_retrieve_response_code( $response ) != 200 ) ) {
			return false;
		}

		// Get remote body val
		$body = wp_remote_retrieve_body( $response );

		// Return data
		if ( ! empty( $body ) ) {
			return $body;
		} else {
			return false;
		}
	}
	/**
   * Get post id
  */
  public static function post_id() {

	  // Default value
	  $id = '';

	  // If singular get_the_ID
	  if ( is_singular() ) {
		  $id = get_the_ID();
	  }

	  // Get ID of WooCommerce product archive
	  elseif ( class_exists( 'WooCommerce' ) && is_shop() ) {
		  $shop_id = wc_get_page_id( 'shop' );
		  if ( isset( $shop_id ) ) {
			  $id = $shop_id;
		  }
	  }

	  // Posts page
	  elseif ( is_home() && $page_for_posts = get_option( 'page_for_posts' ) ) {
		  $id = $page_for_posts;
	  }

	  // Apply filters
	  $id = apply_filters( 'lqthemes_post_id', $id );

	  // Sanitize
	  $id = $id ? $id : '';

	  // Return ID
	  return $id;

  }
  
	function plugin_activate( $network_wide ) {
	
	
	}
		
	public static function plugins_loaded() {
		
		load_plugin_textdomain( 'lqthemes-companion', false,  basename( dirname( __FILE__ ) ) . '/languages' );
	}
	
	/**
	 * Enqueue admin scripts
	*/
	function enqueue_admin_scripts()
	{
		wp_enqueue_style( 'wp-color-picker' );
		
		$theme = LQLTHEMES_THEME_OPTION_NAME;
		
		if(isset($_GET['page']) && $_GET['page']=='lqthemes-templates'){
			wp_enqueue_script( 'plugin-install' );
			wp_enqueue_script( 'updates' );
		}
		
		wp_enqueue_style( 'lqthemes-companion-admin', plugins_url('assets/css/admin.css', __FILE__));
		
		
		if(isset($_GET['page']) && ($_GET['page']=='lqthemes-templates' || $_GET['page']=='lqthemes-sites' || $_GET['page']=='lqthemes-companion' )){
			wp_enqueue_script( 'jquery-isotope-pkgd', plugins_url('assets/vendor/isotope.pkgd.js', __FILE__), array('jquery' ), '' , true);
			
			wp_enqueue_script( 'lqthemes-companion-admin', plugins_url('assets/js/admin.js', __FILE__),array('jquery', 'wp-util', 'updates','wp-color-picker' ), LQLTHEMES_COMPANION_VER, true);
		}
	
		if(isset($_GET['page']) && ( $_GET['page']=='lqthemes-sites' || $_GET['page']=='lqthemes-companion' )){
			wp_enqueue_script( 'lqthemes-site-importer', plugins_url('assets/js/site-importer.js', __FILE__),array('jquery', 'wp-util', 'updates','wp-color-picker' ),'',true);
			wp_localize_script( 'lqthemes-site-importer', 'lqlthemesSiteImporter',
				array(
					'ajaxurl' => admin_url('admin-ajax.php'),
					'nonce' => wp_create_nonce( 'wp_rest' ),
					'i18n' =>array(
						's0' => __( "Executing Demo Import will make your site similar as preview. Please bear in mind -\n\n1. It is recommended to run import on a fresh WordPress installation.\n\n2. Importing site does not delete any pages or posts. However, it can overwrite your existing content.\n\n", 'lqthemes-companion' ),					
						's1'=> __( 'Importing Customizer...', 'lqthemes-companion' ),
						's2'=> __( 'Import Customizer Failed', 'lqthemes-companion' ),
						's3'=> __( 'Customizer Imported', 'lqthemes-companion' ),
						's4'=> __( 'Preparing WXR Data...', 'lqthemes-companion' ),
						's5'=> __( 'Import WXR Failed', 'lqthemes-companion' ),
						's6'=> __( 'Importing WXR...', 'lqthemes-companion' ),
						's6_1'=> __( 'Importing Media, Pages, Posts...', 'lqthemes-companion' ),
						's7'=> __( 'WXR Successfully imported!', 'lqthemes-companion' ),
						's8'=> __( 'Importing Theme Options...', 'lqthemes-companion' ),
						's9'=> __( 'Importing Options Failed', 'lqthemes-companion' ),
						's10'=> __( 'Theme Options Successfully imported!', 'lqthemes-companion' ),
						's11'=> __( 'Importing Widgets...', 'lqthemes-companion' ),
						's12'=> __( 'Import Widgets Failed', 'lqthemes-companion' ),
						's13'=> __( 'Widgets Successfully imported!', 'lqthemes-companion' ),
						's14'=> __( 'Site import complete!', 'lqthemes-companion' ),
						's14_1'=> sprintf(__( 'Site import complete! <a href="%s" target="_blank">Visit your website</a>', 'lqthemes-companion' ), esc_url( home_url( '/' ) )),
						  ),
				) );
		}
		
		wp_localize_script( 'lqthemes-companion-admin', 'lqthemes_companion_admin',
				array(
					'ajaxurl' => admin_url('admin-ajax.php'),
					'nonce' => wp_create_nonce( 'wp_rest' ),
					'i18n' =>array('t1'=> __( 'Install and Import', 'lqthemes-companion' ),'t2'=> __( 'Import', 'lqthemes-companion' ),'t3'=> __( 'Install and Import Site', 'lqthemes-companion' ),'t4'=> __( 'Import Site', 'lqthemes-companion' ) ),
				) );

	if( strstr($theme,'-pro') ){
		$custom_css = '.lqthemes-free, .'.$theme.'-free{ display:none;}';
		wp_add_inline_style( 'lqthemes-companion-admin', wp_filter_nohtml_kses($custom_css) );
	}
	
	}
	
	/**
	 * Enqueue front scripts
	*/
	
	function enqueue_scripts()
	{
	
		global $post;
		$custom_css = '';
		$postid = isset($post->ID)?$post->ID:0;
		if(is_home()){
			$postid = get_option( 'page_for_posts' );
			}
		
		$theme = LQLTHEMES_THEME_OPTION_NAME;
		$prefix = '_lqthemes_';
		
		$i18n = array();
		
		wp_enqueue_script( 'owl-carousel', plugins_url('assets/vendor/owl-carousel/js/owl.carousel.min.js', __FILE__), array( 'jquery' ), null, false);
		wp_enqueue_script( 'jquery-cookie', plugins_url('assets/vendor/jquery.cookie.min.js', __FILE__), array( 'jquery' ), null, false);
		
		wp_enqueue_script( 'lqthemes-companion-front', plugins_url('assets/js/front.js', __FILE__),array('jquery'),LQLTHEMES_COMPANION_VER,false);
		
		if( defined('ELEMENTOR_VERSION') ){
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_enqueue_script( 'lqthemes-elementor', plugins_url('assets/js/elementor.js', __FILE__), array('jquery'), LQLTHEMES_COMPANION_VER, true);
		}
		}
	
		wp_enqueue_style( 'owl-carousel', plugins_url('assets/vendor/owl-carousel/css/owl.carousel.css', __FILE__));
		wp_enqueue_style( 'lqthemes-companion-front', plugins_url('assets/css/front.css', __FILE__));
		wp_enqueue_style( 'lqthemes-companion-element', plugins_url('assets/css/element.css', __FILE__));
		
		$i18n = array(
			'i1'=> __('Please fill out all required fields.','cactus-companion' ),
			'i2'=> __('Please enter your name.','cactus-companion' ),
			'i3'=> __('Please enter valid email.','cactus-companion' ),
			'i4'=> __('Please enter subject.','cactus-companion' ),
			'i5'=> __('Message is required.','cactus-companion' ),
			);
		
		wp_localize_script( 'lqthemes-companion-front', 'lqthemes_params', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'i18n' => $i18n,
		'plugins_url' => plugins_url('', __FILE__)
	)  );
		
		if($custom_css!='')
			wp_add_inline_style( 'lqthemes-companion-element', wp_filter_nohtml_kses($custom_css) );

	}
	
	
	public static function replaceStar($str, $start, $length = 0){
	  $i = 0;
	  $star = '';
	  if($start >= 0) {
	   if($length > 0) {
		$str_len = strlen($str);
		$count = $length;
		if($start >= $str_len) {
		 $count = 0;
		}
	   }elseif($length < 0){
		$str_len = strlen($str);
		$count = abs($length);
		if($start >= $str_len) {
		 $start = $str_len - 1;
		}
		$offset = $start - $count + 1;
		$count = $offset >= 0 ? abs($length) : ($start + 1);
		$start = $offset >= 0 ? $offset : 0;
	   }else {
		$str_len = strlen($str);
		$count = $str_len - $start;
	   }
	  }else {
	   if($length > 0) {
		$offset = abs($start);
		$count = $offset >= $length ? $length : $offset;
	   }elseif($length < 0){
		$str_len = strlen($str);
		$end = $str_len + $start;
		$offset = abs($start + $length) - 1;
		$start = $str_len - $offset;
		$start = $start >= 0 ? $start : 0;
		$count = $end - $start + 1;
	   }else {
		$str_len = strlen($str);
		$count = $str_len + $start + 1;
		$start = 0;
	   }
	  }
	 
	  while ($i < $count) {
	   $star .= '*';
	   $i++;
	  }
	 
	  return substr_replace($str, $star, $start, $count);
	}
	/**
	 * Admin menu
	*/
	function plugin_menu() {
		
		add_menu_page( __( 'LQThemes Companion', 'lqthemes-companion' ), __( 'LQThemes', 'lqthemes-companion' ), 'manage_options', 'lqthemes-companion', array( 'LQThemesSiter', 'render_sites_page' ), '', '40' );
			
		add_submenu_page( 'lqthemes-companion',__( 'LQThemes Sites Directory', 'lqthemes-companion' ), __( 'Demo Sites Importer', 'lqthemes-companion' ), 'manage_options', 'lqthemes-sites',
			  array( 'LQThemesSiter', 'render_sites_page' )
		  );
		  
		add_submenu_page( 'lqthemes-companion',__( 'LQThemes Templates Directory', 'lqthemes-companion' ), __( 'Templates Importer', 'lqthemes-companion' ), 'manage_options', 'lqthemes-templates',
			  array( 'LQThemesTemplater', 'render_admin_page' )
		  );
		 		
		  add_submenu_page( 'lqthemes-companion',__( 'LQThemes Theme License', 'lqthemes-companion' ), __( 'LQThemes License', 'lqthemes-companion' ), 'manage_options', 'lqthemes-license',
				array( 'LqlhemesCompanion', 'license' )
			);
		
		add_submenu_page( 'lqthemes-companion',__( 'Template Parts', 'lqthemes-companion' ), __( 'Template Parts', 'lqthemes-companion' ), 'manage_options', 'edit.php?post_type=lq_template_part' );

		add_action( 'admin_init', array(&$this,'register_mysettings') );
	}
	
	/**
	 * Register settings
	*/
	function register_mysettings() {
		register_setting( 'lqthemes-settings-group', 'lqthemes_companion_options', array(&$this,'text_validate') );
	}
	
	static function license(){
		
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'lqthemes-companion' ) );
		}
		?>
		
        <form method="post" class="lqthemes-license-box" action="<?php echo admin_url('options.php');?>">

		<?php
			settings_fields( 'lqthemes-settings-group' );
			$options     = get_option('lqthemes_companion_options',LqlhemesCompanion::default_options());
			$lqthemes_companion_options = wp_parse_args($options,LqlhemesCompanion::default_options());
			
			
		?>
		<div class="wrap">

          <div class="license">
          <p><?php _e( 'Activate to unlock Pro site demos and templates.', 'lqthemes-companion' );?></p>
          <?php if($lqthemes_companion_options['license_key'] == '' ):?>
		<p><?php _e( 'LQThemes License Key', 'lqthemes-companion' );?>: <input size="50" name="lqthemes_companion_options[license_key]" value="<?php echo $lqthemes_companion_options['license_key'];?>" type="text" /></p>
		<p></p>
        <?php
		
		else:
		$lqthemes_companion_options['license_key'] = LqlhemesCompanion::replaceStar($lqthemes_companion_options['license_key'],10,8);
		?>
        <p><?php _e( 'LQThemes License Key', 'lqthemes-companion' );?>: <input size="50" disabled="disabled" name="lqthemes_companion_options[license_key_hide]" value="<?php echo $lqthemes_companion_options['license_key'];?>" type="text" /><input size="50" type="hidden" name="lqthemes_companion_options[license_key]" value="" type="text" /></p>
		<p></p>
        
        <?php endif;?>
		 
		   </div>
			<p class="submit">
            <?php if($lqthemes_companion_options['license_key'] == '' ):?>
			<input type="submit" class="button-primary" value="<?php _e('Active','lqthemes-companion');?>" />
            <?php	else:?>
            <input type="submit" class="button-primary" value="<?php _e('Deactivate','lqthemes-companion');?>" />
		 <?php endif;?>
			</p>
		</div>
        </form>
		
	<?php	}
	
	
	function gridlist_set_default_view() {
				
				$default = apply_filters( 'lqthemes_glt_default','grid' );
				
				?>
					<script>
					jQuery(document).ready(function($) {
						if ($.cookie( 'gridcookie' ) == null) {
					    	$( '.archive .post-wrap ul.products' ).addClass( '<?php echo $default; ?>' );
					    	$( '.gridlist-toggle #<?php echo $default; ?>' ).addClass( 'active' );
					    }
					});
					</script>
				<?php
			}
	
	
	public static function get_query_args( $control_id, $settings ) {
		$defaults = array(
			$control_id . '_post_type' => 'post',
			$control_id . '_posts_ids' => array(),
			'orderby' => 'date',
			'order' => 'desc',
			'posts_per_page' => 3,
			'offset' => 0,
		);

		$settings = wp_parse_args( $settings, $defaults );

		$post_type = $settings[ $control_id . '_post_type' ];

		if ( 'current_query' === $post_type ) {
			$current_query_vars = $GLOBALS['wp_query']->query_vars;

			/**
			 * Current query variables.
			 *
			 * Filters the query variables for the current query.
			 *
			 * @param array $current_query_vars Current query variables.
			 */
			$current_query_vars = apply_filters( 'elementor_pro/query_control/get_query_args/current_query', $current_query_vars );

			return $current_query_vars;
		}

		$query_args = array(
			'orderby' => $settings['orderby'],
			'order' => $settings['order'],
			'ignore_sticky_posts' => 1,
			'post_status' => 'publish', // Hide drafts/private posts for admins
		);

		if ( 'by_id' === $post_type ) {
			$query_args['post_type'] = 'any';
			$query_args['posts_per_page'] = -1;

			$query_args['post__in']  = $settings[ $control_id . '_posts_ids' ];

			if ( empty( $query_args['post__in'] ) ) {
				// If no selection - return an empty query
				$query_args['post__in'] = array('0');
			}
		} else {
			$query_args['post_type'] = $post_type;
			$query_args['posts_per_page'] = $settings['posts_per_page'];
			$query_args['tax_query'] = array();

			if ( 0 < $settings['offset'] ) {
				/**
				 * Due to a WordPress bug, the offset will be set later, in $this->fix_query_offset()
				 * @see https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
				 */
				$query_args['offset_to_fix'] = $settings['offset'];
			}

			$taxonomies = get_object_taxonomies( $post_type, 'objects' );

			foreach ( $taxonomies as $object ) {
				$setting_key = $control_id . '_' . $object->name . '_ids';

				if ( ! empty( $settings[ $setting_key ] ) ) {
					$query_args['tax_query'][] = array(
						'taxonomy' => $object->name,
						'field' => 'term_id',
						'terms' => $settings[ $setting_key ],
					);
				}
			}
		}

		if ( ! empty( $settings[ $control_id . '_authors' ] ) ) {
			$query_args['author__in'] = $settings[ $control_id . '_authors' ];
		}

		if ( ! empty( $settings['exclude'] ) ) {
			$post__not_in = array();
			if ( in_array( 'current_post', $settings['exclude'] ) ) {
				if ( Utils::is_ajax() && ! empty( $_REQUEST['post_id'] ) ) {
					$post__not_in[] = $_REQUEST['post_id'];
				} elseif ( is_singular() ) {
					$post__not_in[] = get_queried_object_id();
				}
			}

			if ( in_array( 'manual_selection', $settings['exclude'] ) && ! empty( $settings['exclude_ids'] ) ) {
				$post__not_in = array_merge( $post__not_in, $settings['exclude_ids'] );
			}

			$query_args['post__not_in'] = $post__not_in;
		}

		return $query_args;
	}
	/**
	 * Set default options
	*/
	
	public static function default_options(){

		$return = array(
			'license_key' => '',

		);
		
		return $return;
		
		}
	 function post_template_part() {
		$labels = array(
		  'name'               => _x( 'Template Part', 'Template Part','lqthemes-companion' ),
		  'singular_name'      => _x( 'Template Part', 'Template Part','lqthemes-companion' ),
		  'add_new'            => _x( 'Add Template Part', 'New Template Part','lqthemes-companion' ),
		  'add_new_item'       => __( 'Add Template Part','lqthemes-companion' ),
		  'edit_item'          => __( 'Eddit Template Part','lqthemes-companion' ),
		  'new_item'           => __( 'New Template Part','lqthemes-companion' ),
		  'all_items'          => __( 'All Template Parts' ,'lqthemes-companion' ),
		  'view_item'          => __( 'View Template Part','lqthemes-companion' ),
		  'search_items'       => __( 'Search Template Part','lqthemes-companion' ),
		  'not_found'          => __( 'Not found','lqthemes-companion' ),
		  'not_found_in_trash' => __( 'Not found in trash','lqthemes-companion' ),
		  'parent_item_colon'  => '',
		  'menu_name'          => 'Template Part'
		);
		$args = array(
		  'labels'        => $labels,
		  'public' 					=> true,
			'hierarchical'          	=> false,
			'show_ui'               	=> true,
			'show_in_menu' 				=> false,
			'show_in_nav_menus'     	=> false,
			'can_export'            	=> true,
			'exclude_from_search'   	=> true,
			'capability_type' 			=> 'post',
			'rewrite' 					=> false,
			'supports' 					=> array( 'title', 'editor', 'author', 'elementor' ),
		);
		register_post_type( 'lq_template_part', $args );
	  }

		}
	
	new LqlhemesCompanion;
}