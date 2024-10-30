<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LQThemes_Widget_Posts extends Widget_Base {
	
	public function get_script_depends() {
		return [ 'imagesloaded','masonry' ];
	}
	
  public function get_categories() {
		return [ 'lqthemes-elements' ];
	}
	
   public function get_name() {
      return 'lqthemes-posts';
   }

   public function get_title() {
      return __( 'Posts', 'lqthemes-companion' );
   }

   public function get_icon() { 
        return 'eicon-post-list';
   }

   protected function _register_controls() {
	  
	  
	  $categories = get_categories( array(
		  'orderby' => 'name',
		  'parent'  => 0
	  ) );
	  
	  $category_array = array('0' => __( 'All', 'lqthemes-companion' ));

	  foreach ( $categories as $category ) {
		 $category_array[$category->slug] = $category->name;
	  }
	
     $this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'lqthemes-companion' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
	  
	  $this->add_control(
         'category',
         [
            'label' => __( 'Category', 'lqthemes-companion' ),
            'type' => Controls_Manager::SELECT,
            'default' => 0,
            'options' => $category_array
         ]
      );
	  
	  
      $this->add_control(
         'posts_per_page',
         [
            'label' => __( 'Number of Posts', 'lqthemes-companion' ),
            'type' => Controls_Manager::SELECT,
            'default' => 3,
            'options' => [
				1 => __( '1', 'lqthemes-companion' ),
               2 => __( '2', 'lqthemes-companion' ),
               3 => __( '3', 'lqthemes-companion' ),
               4 => __( '4', 'lqthemes-companion' ),
               5 => __( '5', 'lqthemes-companion' ),
			   6 => __( '6', 'lqthemes-companion' ),
			   7 => __( '7', 'lqthemes-companion' ),
			   8 => __( '8', 'lqthemes-companion' ),
			   9 => __( '9', 'lqthemes-companion' ),
			   10 => __( '10', 'lqthemes-companion' ),
			   11 => __( '11', 'lqthemes-companion' ),
			   12 => __( '12', 'lqthemes-companion' ),
            ]
         ]
      );
	  
	  $this->end_controls_section();
	  
		 $this->start_controls_section(
			'section_design_layout',
			[
				'label' => __( 'Layout', 'lqthemes-companion' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
         'layout',
         [
            'label' => __( 'Layout', 'lqthemes-companion' ),
            'type' => Controls_Manager::SELECT,
            'default' => 1,
            'options' => [
			   0 => __( '== Select ==', 'lqthemes-companion' ),
			   1 => __( 'Grid', 'lqthemes-companion' ),
               2 => __( 'Carousel', 'lqthemes-companion' ),
            ]
         ]
      );
	  
	  
	  $this->add_control(
			'masonry',
			[
				'label' => __( 'Masonry', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'lqthemes-companion' ),
				'label_on' => __( 'On', 'lqthemes-companion' ),
				'return_value' => '1',
				'default' => '0',
				'separator' => 'before',
				'condition' => [
					'layout' => '1',
				],
			]
		);
		
		$this->add_control(
			'navigation',
			[
				'label' => __( 'Navigation', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'lqthemes-companion' ),
				'label_on' => __( 'On', 'lqthemes-companion' ),
				'return_value' => '1',
				'default' => '0',
				'separator' => 'before',
				'condition' => [
					'layout' => '2',
				],
			]
		);
		
		$this->add_control(
			'autoplay',
			[
				'label' => __( 'AutoPlay', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'lqthemes-companion' ),
				'label_on' => __( 'On', 'lqthemes-companion' ),
				'return_value' => '1',
				'default' => '0',
				'separator' => 'before',
				'condition' => [
					'layout' => '2',
				],
			]
		);
		
		$this->add_control(
			'loop',
			[
				'label' => __( 'Loop', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'lqthemes-companion' ),
				'label_on' => __( 'On', 'lqthemes-companion' ),
				'separator' => 'before',
				'return_value' => '1',
				'default' => '0',
				'condition' => [
					'layout' => '2',
				],
			]
		);
		
		$this->add_control(
			'dots',
			[
				'label' => __( 'Carousel Dots', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'lqthemes-companion' ),
				'label_on' => __( 'On', 'lqthemes-companion' ),
				'separator' => 'before',
				'return_value' => '1',
				'default' => '0',
				'condition' => [
					'layout' => '2',
				],
			]
		);
		
		$this->add_control(
         'columns',
         [
            'label' => __( 'Columns', 'lqthemes-companion' ),
			'description' => '',
            'type' => Controls_Manager::SELECT,
            'default' => 3,
            'options' => [
			   1 => __( '1', 'lqthemes-companion' ),
               2 => __( '2', 'lqthemes-companion' ),
               3 => __( '3', 'lqthemes-companion' ),
               4 => __( '4', 'lqthemes-companion' ),
			   5 => __( '5', 'lqthemes-companion' ),
			   6 => __( '6', 'lqthemes-companion' ),
              
            ],
	
         ]
      );
	  
	   $this->add_control(
         'item_style',
         [
            'label' => __( 'Item Style', 'lqthemes-companion' ),
            'type' => Controls_Manager::SELECT,
            'default' => 1,
            'options' => [
			   1 => __( 'Blog Style 1', 'lqthemes-companion' ),
               2 => __( 'Blog Style 2', 'lqthemes-companion' ),
               3 => __( 'Blog Style 3', 'lqthemes-companion' ),
            ]
         ]
      );
	  
	 $this->add_control(
			'boxed',
			[
				'label' => __( 'Boxed?', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'lqthemes-companion' ),
				'label_on' => __( 'On', 'lqthemes-companion' ),
				'return_value' => '1',
				'default' => '0',
				'separator' => 'before',
				'condition' => [
					'item_style' => array('1', '2'),
				],
			]
		);
		
		
		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'lqthemes-companion' ),
				'description' => __( 'Post Item Background Color', 'lqthemes-companion' ),
				'separator' => 'before',
				'default' => '#fff',
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lq-widget-post-item-inner' => 'background-color: {{VALUE}};',
					
				],
				'condition' => [
					'boxed' => '1',
				],
				
			]
		);
	
	$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'lqthemes-companion' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lq-widget-blog-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'boxed' => '1',
				],
			]
		);
		
	$this->add_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => __( 'Box Shadow', 'lqthemes-companion' ),
				'selector' => '{{WRAPPER}} .lq-widget-blog-item-inner',
				'condition' => [
					'boxed' => '1',
				],
			]
		);	  

	$this->end_controls_section();
	
	 $this->start_controls_section(
			'section_design_blog_info',
			[
				'label' => __( 'Blog Info', 'lqthemes-companion' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
	// title	
	$this->add_control(
			'display_title',
			[
				'label' => __( 'Display Title?', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'lqthemes-companion' ),
				'label_on' => __( 'On', 'lqthemes-companion' ),
				'return_value' => '1',
				'default' => '1',
				'separator' => 'before',
			]
		);
	
	$this->add_control(
			'title_spacing',
			[
				'label' => __( 'Title Spacing', 'lqthemes-companion' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '0',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lq-widget-post-title' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'display_title' => '1',
				],
			]
		);
	
	$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lq-widget-post-title' => 'color: {{VALUE}};',
				],
				'default' => '#333',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'condition' => [
					'display_title' => '1',
				],
			]
		);
	
	$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .lq-widget-post-title',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'condition' => [
					'display_title' => '1',
				],
			]
		);
	
	// Excerpt	
	$this->add_control(
			'display_excerpt',
			[
				'label' => __( 'Display Excerpt?', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'lqthemes-companion' ),
				'label_on' => __( 'On', 'lqthemes-companion' ),
				'return_value' => '1',
				'default' => '1',
				'separator' => 'before',
			]
		);
	
	$this->add_control(
			'excerpt_spacing',
			[
				'label' => __( 'Excerpt Spacing', 'lqthemes-companion' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '0',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lq-widget-post-description' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'display_excerpt' => '1',
				],
			]
		);
	
	$this->add_control(
			'excerpt_color',
			[
				'label' => __( 'Excerpt Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lq-widget-post-description' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'condition' => [
					'display_excerpt' => '1',
				],
			]
		);
	
	$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .lq-widget-post-description',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'condition' => [
					'display_excerpt' => '1',
				],
			]
		);
		
	// meta data
	$this->add_control(
			'display_categories',
			[
				'label' => __( 'Display Categories?', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'lqthemes-companion' ),
				'label_on' => __( 'On', 'lqthemes-companion' ),
				'return_value' => '1',
				'default' => '1',
				'separator' => 'before',
			]
		);
		
	$this->add_control(
			'display_author',
			[
				'label' => __( 'Display Author?', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'lqthemes-companion' ),
				'label_on' => __( 'On', 'lqthemes-companion' ),
				'return_value' => '1',
				'default' => '1',
				'separator' => 'before',
			]
		);
	$this->add_control(
			'display_date',
			[
				'label' => __( 'Display Date?', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'lqthemes-companion' ),
				'label_on' => __( 'On', 'lqthemes-companion' ),
				'return_value' => '1',
				'default' => '1',
				'separator' => 'before',
			]
		);
		
	$this->add_control(
			'display_fancy_categories',
			[
				'label' => __( 'Enable Fancy Categories?', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'lqthemes-companion' ),
				'label_on' => __( 'On', 'lqthemes-companion' ),
				'return_value' => '1',
				'default' => '1',
				'separator' => 'before',
			]
		);
	
	$this->add_control(
			'fancy_categories_color',
			[
				'label' => __( 'Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lq-widget-post-category-fancy a' => 'color: {{VALUE}};',
				],
				'default' => '#fff',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'condition' => [
					'display_fancy_categories' => '1',
				],
			]
		);
	
	$this->add_control(
			'display_read_more',
			[
				'label' => __( 'Display Read More Button?', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'lqthemes-companion' ),
				'label_on' => __( 'On', 'lqthemes-companion' ),
				'return_value' => '1',
				'default' => '1',
				'separator' => 'before',
			]
		);
		
	$this->end_controls_section();
	
	// button
		
	$this->start_controls_section(
			'section_readmore_button',
			[
				'label' => __( 'Button', 'lqthemes-companion' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
				],
				'default' => '#ffffff',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],

			]
		);
		
		$this->add_control(
			'button_color',
			[
				'label' => __( 'Button Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
				],
				'default' => '#818a91',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
	
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => __( 'Text', 'lqthemes-companion' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Read More', 'lqthemes-companion' ),
				'placeholder' => __( 'Read More', 'lqthemes-companion' ),
			]
		);

		$this->add_control(
			'button_size',
			[
				'label' => __( 'Size', 'lqthemes-companion' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => self::get_button_sizes(),
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label' => __( 'Icon', 'lqthemes-companion' ),
				'type' => Controls_Manager::ICON,
				'label_block' => true,
				'default' => '',
			]
		);

		$this->add_control(
			'button_icon_indent',
			[
				'label' => __( 'Icon Spacing', 'lqthemes-companion' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'button_icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_css_id',
			[
				'label' => __( 'Button ID', 'lqthemes-companion' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'title' => __( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'lqthemes-companion' ),
				'label_block' => false,
				'description' => __( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'lqthemes-companion' ),
				'separator' => 'before',

			]
		);

		$this->end_controls_section();
		

   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

		$settings = $this->get_settings_for_display();
		
		$post_count = ! empty( $settings['posts_per_page'] ) ? (int)$settings['posts_per_page'] : 6;
		$columns    = ! empty( $settings['columns'] ) ? $settings['columns'] : '3';
		$item_style = ! empty( $settings['item_style'] ) ? $settings['item_style'] : '1';
		$layout = ! empty( $settings['layout'] ) ? $settings['layout'] : '1';
		$category = ! empty( $settings['category'] ) ? $settings['category'] : '0';
		
		$masonry = ! empty( $settings['masonry'] ) ? $settings['masonry'] : '0';
		$nav = ! empty( $settings['navigation'] ) ? $settings['navigation'] : '0';
		$autoplay = ! empty( $settings['autoplay'] ) ? $settings['autoplay'] : '0';
		$loop = ! empty( $settings['loop'] ) ? $settings['loop'] : '0';
		$dots = ! empty( $settings['dots'] ) ? $settings['dots'] : '0';
				
		$uniq_id = uniqid('lq-posts-carousel-');
		
		$item_wrap_class = 'lq-widget-post style'.absint($item_style);
		
		if( $layout == '2' )
			$item_wrap_class .= ' lq-widget-post-carousel ';
		else
			$item_wrap_class .= ' lq-list-md-'.absint($columns);
		
		if( $masonry == '1' ): 
			$item_wrap_class .= ' masonry-loop';
		 endif;

      ?>
  
<div class="elementor-widget">
 <div class="elementor-widget-container">    
	<div class="<?php echo esc_attr($item_wrap_class); ?>">
    <?php
	if( $layout == '2' ){
		echo '<div id="'.esc_attr($uniq_id).'" class="owl-carousel" >';
	}
		
	?>     
<?php 
// the query
$args = array(
  'post_type'=>'post',
  'posts_per_page' => $post_count,
  'ignore_sticky_posts' => 1,
  'post_status' => array( 'publish' ),
  'category_name' => $category
);
$the_query = new \WP_Query( $args ); ?>

<?php if ( $the_query->have_posts() ) : ?>

	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
    
    
   <?php echo $this->get_item( $item_style, $masonry, $settings ); ?>
            
	<?php endwhile; ?>

	<?php wp_reset_postdata(); ?>

<?php endif; ?>  
      <?php
	if( $layout == '2' ){
		echo '</div>';
	}
		
	?>            
	</div>
</div>

<script>
		
jQuery(document).ready(function($) {
<?php if( $layout == '2' ): ?>
	$("#<?php echo $uniq_id;?>").owlCarousel({
		items: <?php echo absint($columns); ?>,
		nav:  <?php echo absint($nav); ?>,
		loop: <?php echo absint($loop); ?>,
		autoplay: <?php echo absint($autoplay); ?>,
		dots: <?php echo absint($dots); ?>,
		responsiveClass: true,
		margin: 20,
		autoplayTimeout: 3500
	});
<?php endif;?>
<?php if( $masonry == '1' ): ?>
	var $container = $('.masonry-loop');            
	  $container.imagesLoaded(function(){                 
		 $container.masonry({
			itemSelector: '.masonry-entry',
			isAnimated: true,                
		 });
	  });
<?php endif;?>		
   });

</script>
</div>

<?php

   }
   
  protected function get_item( $item_style, $masonry, $settings ){  
 
	   $item = '';
	   $image = '';
	   $category_items = '';
	   $link = get_permalink();
	   $title = get_the_title();
	   $display_title =  isset( $settings['display_title'] ) ? $settings['display_title'] : '1';
	   $display_excerpt =  isset( $settings['display_excerpt'] ) ? $settings['display_excerpt'] : '1';
	   
	   $display_categories =  isset( $settings['display_categories'] ) ? $settings['display_categories'] : '1';
	   $display_author =  isset( $settings['display_author'] ) ? $settings['display_author'] : '1';
	   $display_date =  isset( $settings['display_date'] ) ? $settings['display_date'] : '1';
	   $display_fancy_categories =  isset( $settings['display_fancy_categories'] ) ? $settings['display_fancy_categories'] : '1';
	   $display_read_more =  isset( $settings['display_read_more'] ) ? $settings['display_read_more'] : '1';
	   
	   //button
	   $button_text =  isset( $settings['button_text'] ) ? $settings['button_text'] : '';
	   $button_size =  isset( $settings['button_size'] ) ? $settings['button_size'] : 'sm';
	   $button_icon =  isset( $settings['button_icon'] ) ? $settings['button_icon'] : '';
	   $button_css_id =  isset( $settings['button_css_id'] ) ? $settings['button_css_id'] : '';
	   
	   
	   // image
	   if( has_post_thumbnail() ){
			$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
			if( $item_style == '2' )
				$image = '<div class="lq-widget-post-figure figure-link"><a href="'.esc_url($link).'"><img src="'.esc_url($featured_img_url).'" alt=""></a></div>';
			else
				$image = '<div class="lq-widget-post-figure figure-link"><a href="'.esc_url($link).'"><img src="'.esc_url($featured_img_url).'" alt=""></a></div>';
		}else{
			$item_style = 1;
		}
		
		// category
	   $categories = get_the_category();
	   $separator = ' ';
	   $output = '';
	   $category_items_array = array();
	   if ( ! empty( $categories ) ) {

		  foreach( $categories as $category ) {
			  $cat_item = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'lqthemes-companion' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
			  $output .= $cat_item;
			  $category_items_array[] = $cat_item;
		  }
	  	$category_items .= trim( $output, $separator );

      }
	  
	  $item_class = 'post lq-widget-post-item post-'.get_the_ID();
	  
	  if( $masonry == '1' )
	  	$item_class .= ' masonry-entry';
	   
		$item .= '<article class="'.esc_attr( $item_class ).'">
					  <div class="lq-widget-post-item-inner">
						  <figure>
							  '.$image.'
							  
							 '.($item_style == '3'? '<div class="lq-overlay lq-flex-box dark cap-show">':'').'
							  
							  <figcaption class="lq-widget-post-caption text-left">
							  
							  '.($display_fancy_categories == '1'?'<div class="lq-widget-post-category-fancy">'.$category_items.'</div>':'').'
							  	  
								'.($display_title == '1'?'<h3 class="entry-title lq-widget-post-title"><a href="'.esc_url($link).'">'.esc_attr($title).'</a></h3>':'').'
								  
								  <div class="entry-meta lq-widget-post-meta">
								  
								  '.($display_date == '1'?'<a class="entry-date">
										  <i class="fa fa-calendar-o"></i> <time class="entry-date published" datetime="'.get_post_time('c', true).'">'.get_the_date().'</time>
									  </a>':'').'
									  
									'.($display_categories == '1'?'<span class="entry-category"><i class="fa fa-file-o"></i> '.implode(', ', $category_items_array).'</span>':'').'
									  
									  '.($display_author == '1'? '<span class="entry-author author vcard" rel="author"><i class="fa fa-user-o"></i> '.__( 'By', 'lqthemes-companion' ).' <span class="fn"> '.get_the_author_posts_link().'</span></span>':'').'
									 
								  </div>
								 
								  '.($display_excerpt == '1'?'<div class="lq-widget-post-description">'.get_the_excerpt().'</div>':'').'
								  
								  '.($display_read_more == '1'?'<a href="'.get_the_permalink().'" role="button" class="lq-widget-post-more">
								  
								  	   
								  '.($button_text != ''?'<span id="'.esc_attr($button_css_id).'" class="elementor-button elementor-size-'.esc_attr($button_size).'">'.esc_attr($button_text).' <i class="elementor-align-icon-right fa fa-'.esc_attr($button_icon).'"></i></span>':'').'
								  
								 
								  
</a>':'').'
								  
							  </figcaption>
							  
							  '.($item_style == '3'? '</div>':'').'
							  
						  </figure>
					  </div>
				  </article>';


		
	  return $item;
		   
	 }
	   
	public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'lqthemes-companion' ),
			'sm' => __( 'Small', 'lqthemes-companion' ),
			'md' => __( 'Medium', 'lqthemes-companion' ),
			'lg' => __( 'Large', 'lqthemes-companion' ),
			'xl' => __( 'Extra Large', 'lqthemes-companion' ),
		];
	}
	
   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new LQThemes_Widget_Posts );
