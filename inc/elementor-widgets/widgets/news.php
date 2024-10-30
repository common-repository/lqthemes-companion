<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LQThemes_Widget_Latest_News extends Widget_Base {

  public function get_categories() {
		return [ 'lqthemes-elements' ];
	}
	
   public function get_name() {
      return 'lqthemes-latest-news-1';
   }

   public function get_title() {
      return __( 'Latest News', 'lqthemes-companion' );
   }

   public function get_icon() { 
        return 'eicon-wordpress';
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

      $this->add_control(
         'section_blog_posts',
         [
            'label' => __( 'Blog Posts', 'lqthemes-companion' ),
            'type' => Controls_Manager::SECTION,
         ]
      );
	  
	  $this->add_control(
         'category',
         [
            'label' => __( 'Category', 'lqthemes-companion' ),
            'type' => Controls_Manager::SELECT,
            'default' => 0,
            'section' => 'section_blog_posts',
            'options' => $category_array
         ]
      );
	  
	   $this->add_control(
         'list_style',
         [
            'label' => __( 'List Style', 'lqthemes-companion' ),
            'type' => Controls_Manager::SELECT,
            'default' => 1,
            'section' => 'section_blog_posts',
            'options' => [
			   0 => __( '== Select ==', 'lqthemes-companion' ),
			   1 => __( 'List', 'lqthemes-companion' ),
               2 => __( 'Slider', 'lqthemes-companion' ),
            ]
         ]
      );
	  
	   $this->add_control(
         'item_style',
         [
            'label' => __( 'Item Style', 'lqthemes-companion' ),
            'type' => Controls_Manager::SELECT,
            'default' => 1,
            'section' => 'section_blog_posts',
            'options' => [
			   1 => __( '1', 'lqthemes-companion' ),
               2 => __( '2', 'lqthemes-companion' ),
               3 => __( '3', 'lqthemes-companion' ),
            ]
         ]
      );

      $this->add_control(
         'posts_per_page',
         [
            'label' => __( 'Number of Posts', 'lqthemes-companion' ),
            'type' => Controls_Manager::SELECT,
            'default' => 6,
            'section' => 'section_blog_posts',
            'options' => [
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
	  
	   $this->add_control(
         'columns',
         [
            'label' => __( 'Columns', 'lqthemes-companion' ),
			'description' => __( 'List style only.', 'lqthemes-companion' ),
            'type' => Controls_Manager::SELECT,
            'default' => 3,
            'section' => 'section_blog_posts',
            'options' => [
			   1 => __( '1', 'lqthemes-companion' ),
               2 => __( '2', 'lqthemes-companion' ),
               3 => __( '3', 'lqthemes-companion' ),
               4 => __( '4', 'lqthemes-companion' ),
              
            ],
			'condition' => [
					'style' => '1',
				],
         ]
      );
	  
	  
	  $this->start_controls_section(
			'section_design_layout',
			[
				'label' => __( 'Color', 'lqthemes-companion' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'font_color',
			[
				'label' => __( 'Color', 'lqthemes-companion' ),
				'description' => __( 'Item style 3 only.', 'lqthemes-companion' ),
				'separator' => 'before',
				'default' => '#fff',
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lq-widget-news-item.style3 .lq-news-title, {{WRAPPER}}.lq-widget-news-item.style3 .lq-news-meta, {{WRAPPER}} .lq-widget-news-item.style3 .lq-news-meta a' => 'color: {{VALUE}};',
					'condition' => [
					'style' => '3',
				],
				],
				
			]
		);
	$this->end_controls_section();

   }

   protected function render( $instance = [] ) {

      // get our input from the widget settings.

		$settings = $this->get_settings();
		$post_count = ! empty( $settings['posts_per_page'] ) ? (int)$settings['posts_per_page'] : 6;
		$columns    = ! empty( $settings['columns'] ) ? $settings['columns'] : '3';
		$item_style = ! empty( $settings['item_style'] ) ? $settings['item_style'] : '1';
		$list_style = ! empty( $settings['list_style'] ) ? $settings['list_style'] : '1';
		$category = ! empty( $settings['category'] ) ? $settings['category'] : '0';
		

      ?>
      
<?php if( $list_style == '2' ): ?>
<div class="lq-widget-news-wrap owl-carousel owl-theme">
<?php else:?>
<div class="lq-widget-news-wrap col-<?php echo absint($columns); ?>">
<?php endif;?>
             
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
    
    
   <?php echo $this->get_item($item_style); ?>
            
	<?php endwhile; ?>

	<?php wp_reset_postdata(); ?>

<?php endif; ?>
                  
              </div>

<?php

   }
   
  protected function get_item( $style ){
	   
	   $item = '';
	   $image = '';
	   $category_items = '';
	   $link = get_permalink();
	   $title = get_the_title();
	   // image
	   if( has_post_thumbnail() ){
			$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
			if( $style == '2' )
				$image = '<figure class="darken"><a href="'.esc_url($link).'"><img src="'.esc_url($featured_img_url).'" alt=""></a></figure>';
			else
				$image = '<figure><a href="'.esc_url($link).'"><img src="'.esc_url($featured_img_url).'" alt=""></a></figure>';
		}else{
			$style = 1;
		}
	   // category
	   $categories = get_the_category();
	   $separator = ' ';
	   $output = '';
	   if ( ! empty( $categories ) ) {
		  $category_items .= '<div class="lq-news-categories">';
		  foreach( $categories as $category ) {
			  $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'lqthemes-companion' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
		  }
	  	$category_items .= trim( $output, $separator );
	  	$category_items .= ' </div>';
      }
	  // title
	  $title = '<h4 class="lq-news-title"><a href="'.esc_url($link).'">'.esc_attr($title).'</a></h4>';
	  
	  // meta
	  $meta = '<div class="lq-news-meta">
				<span class="lq-news-date">
					 <i class="fa fa-calendar-o"></i> <a href="'.get_month_link(get_the_time('Y'), get_the_time('m')).'"><time class="entry-date published" datetime="'.get_post_time('c', true).'">'.get_the_date().'</time></a>
					</span></div>';
	  
				

	  $item .= '<div class="lq-widget-news-item style'.absint($style).'">';
	  
	  $item .= $image;
	  $item .= '<div class="lq-widget-news-item-info">';
	  $item .= $category_items;
	  $item .= $title;
	  $item .= $meta;
	  $item .= '</div></div>';
		
	  return $item;
		   
	 }
	   
	
   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new LQThemes_Widget_Latest_News );
