<?php
namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class LQThemes_Slides extends Widget_Base {

	public function get_name() {
		return 'lq_slider';
	}

	public function get_title() {
		return __( 'Slider', 'lqthemes-companion' );
	}

	public function get_icon() {
		return 'eicon-slideshow';
	}

	public function get_categories() {
		return [ 'lqthemes-elements' ];
	}

	public function get_keywords() {
		return [ 'slides', 'carousel', 'image', 'title', 'slider' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'jquery-slick', 'owl-carousel' ];
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

	protected function _register_controls() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => __( 'Slides', 'lqthemes-companion' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );
		
		$repeater->start_controls_tab( 'image', [ 'label' => __( 'Image', 'lqthemes-companion' ) ] );


		$repeater->add_control(
			'slide_image',
			[
				'label' => __( 'Image', 'lqthemes-companion' ),
				'type' => Controls_Manager::MEDIA,
				
			]
		);
		$repeater->end_controls_tab();


		$repeater->start_controls_tab( 'content', [ 'label' => __( 'Content', 'lqthemes-companion' ) ] );

		$repeater->add_control(
			'heading',
			[
				'label' => __( 'Title & Description', 'lqthemes-companion' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Slide Heading', 'lqthemes-companion' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => __( 'Description', 'lqthemes-companion' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'I am slide content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'lqthemes-companion' ),
				'show_label' => false,
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'lqthemes-companion' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click Here', 'lqthemes-companion' ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'lqthemes-companion' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'lqthemes-companion' ),
			]
		);

		$repeater->add_control(
			'link_click',
			[
				'label' => __( 'Apply Link On', 'lqthemes-companion' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'slide' => __( 'Whole Slide', 'lqthemes-companion' ),
					'button' => __( 'Button Only', 'lqthemes-companion' ),
				],
				'default' => 'button',
				'conditions' => [
					'terms' => [
						[
							'name' => 'link[url]',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'style', [ 'label' => __( 'Style', 'lqthemes-companion' ) ] );

		$repeater->add_control(
			'custom_style',
			[
				'label' => __( 'Custom', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => __( 'Set custom style that will only affect this specific slide.', 'lqthemes-companion' ),
			]
		);

		$repeater->add_control(
			'horizontal_position',
			[
				'label' => __( 'Horizontal Position', 'lqthemes-companion' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'lqthemes-companion' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'lqthemes-companion' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'lqthemes-companion' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-inner .elementor-slide-content' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'left' => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right' => 'margin-left: auto',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'vertical_position',
			[
				'label' => __( 'Vertical Position', 'lqthemes-companion' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'lqthemes-companion' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'lqthemes-companion' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'lqthemes-companion' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-inner' => 'align-items: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'text_align',
			[
				'label' => __( 'Text Align', 'lqthemes-companion' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'lqthemes-companion' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'lqthemes-companion' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'lqthemes-companion' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-inner' => 'text-align: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'content_color',
			[
				'label' => __( 'Content Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-inner .elementor-slide-heading' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-inner .elementor-slide-description' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-inner .elementor-slide-button' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[
				'label' => __( 'Slides', 'lqthemes-companion' ),
				'type' => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'heading' => __( 'Slide 1 Heading', 'lqthemes-companion' ),
						'description' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'lqthemes-companion' ),
						'button_text' => __( 'Click Here', 'lqthemes-companion' ),
						'background_color' => '#833ca3',
						'slide_image' => ['url'=> LQLTHEMES_COMPANION_URL.'/assets/images/banner1.jpg' ]
					],
					[
						'heading' => __( 'Slide 2 Heading', 'lqthemes-companion' ),
						'description' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'lqthemes-companion' ),
						'button_text' => __( 'Click Here', 'lqthemes-companion' ),
						'background_color' => '#4054b2',
						'slide_image' => ['url'=> LQLTHEMES_COMPANION_URL.'/assets/images/banner2.jpg' ]
					],
					[
						'heading' => __( 'Slide 3 Heading', 'lqthemes-companion' ),
						'description' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'lqthemes-companion' ),
						'button_text' => __( 'Click Here', 'lqthemes-companion' ),
						'background_color' => '#1abc9c',
						'slide_image' => ['url'=> LQLTHEMES_COMPANION_URL.'/assets/images/banner3.jpg' ]
					],
				],
				'title_field' => '{{{ heading }}}',
			]
		);

		$this->add_responsive_control(
			'slides_height',
			[
				'label' => __( 'Height', 'lqthemes-companion' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 400,
				],
				'size_units' => [ 'px', 'vh', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .slick-slide' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => __( 'Slider Options', 'lqthemes-companion' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'navigation',
			[
				'label' => __( 'Navigation', 'lqthemes-companion' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'both',
				'options' => [
					'both' => __( 'Arrows and Dots', 'lqthemes-companion' ),
					'arrows' => __( 'Arrows', 'lqthemes-companion' ),
					'dots' => __( 'Dots', 'lqthemes-companion' ),
					'none' => __( 'None', 'lqthemes-companion' ),
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => __( 'Pause on Hover', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => __( 'Autoplay Speed', 'lqthemes-companion' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 1000,
				'condition' => [
					'autoplay' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .slick-slide-bg' => 'animation-duration: calc({{VALUE}}ms*1.2); transition-duration: calc({{VALUE}}ms)',
				],
			]
		);

		$this->add_control(
			'infinite',
			[
				'label' => __( 'Infinite Loop', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'transition',
			[
				'label' => __( 'Transition', 'lqthemes-companion' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => __( 'Slide', 'lqthemes-companion' ),
					'fade' => __( 'Fade', 'lqthemes-companion' ),
				],
			]
		);

		/*$this->add_control(
			'transition_speed',
			[
				'label' => __( 'Transition Speed (ms)', 'lqthemes-companion' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
			]
		);*/

		$this->add_control(
			'content_animation',
			[
				'label' => __( 'Content Animation', 'lqthemes-companion' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fadeInUp',
				'options' => [
					'' => __( 'None', 'lqthemes-companion' ),
					'fadeInDown' => __( 'Down', 'lqthemes-companion' ),
					'fadeInUp' => __( 'Up', 'lqthemes-companion' ),
					'fadeInRight' => __( 'Right', 'lqthemes-companion' ),
					'fadeInLeft' => __( 'Left', 'lqthemes-companion' ),
					'zoomIn' => __( 'Zoom', 'lqthemes-companion' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_slides',
			[
				'label' => __( 'Slides', 'lqthemes-companion' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[
				'label' => __( 'Content Width', 'lqthemes-companion' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ '%', 'px' ],
				'default' => [
					'size' => '66',
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .lq-widget-slider-caption-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slides_padding',
			[
				'label' => __( 'Padding', 'lqthemes-companion' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lq-widget-slider-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'slides_horizontal_position',
			[
				'label' => __( 'Horizontal Position', 'lqthemes-companion' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'lqthemes-companion' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'lqthemes-companion' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'lqthemes-companion' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'h-',
			]
		);

		$this->add_control(
			'slides_vertical_position',
			[
				'label' => __( 'Vertical Position', 'lqthemes-companion' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'center',
				'options' => [
					'top' => [
						'title' => __( 'Top', 'lqthemes-companion' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Middle', 'lqthemes-companion' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'lqthemes-companion' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'prefix_class' => 'v-',
			]
		);

		$this->add_control(
			'slides_text_align',
			[
				'label' => __( 'Text Align', 'lqthemes-companion' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'lqthemes-companion' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'lqthemes-companion' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'lqthemes-companion' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .slick-slide-inner' => 'text-align: {{VALUE}}',
				],
				'prefix_class' => 'text-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label' => __( 'Title', 'lqthemes-companion' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_spacing',
			[
				'label' => __( 'Spacing', 'lqthemes-companion' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lq-widget-slider-title:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Text Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lq-widget-slider-title' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .lq-widget-slider-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_description',
			[
				'label' => __( 'Description', 'lqthemes-companion' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'description_spacing',
			[
				'label' => __( 'Spacing', 'lqthemes-companion' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lq-widget-slider-description:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Text Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lq-widget-slider-description' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .lq-widget-slider-description',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => __( 'Button', 'lqthemes-companion' ),
				'tab' => Controls_Manager::TAB_STYLE,
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

		$this->add_control( 'button_color',
			[
				'label' => __( 'Text Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button, {{WRAPPER}} .elementor-button' => 'color: {{VALUE}}; border-color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .elementor-slide-button',
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_control(
			'button_border_width',
			[
				'label' => __( 'Border Width', 'lqthemes-companion' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button, {{WRAPPER}} .elementor-button' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'lqthemes-companion' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => __( 'Normal', 'lqthemes-companion' ) ] );


		$this->add_control(
			'button_background_color',
			[
				'label' => __( 'Background Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button, {{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label' => __( 'Border Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button, {{WRAPPER}} .elementor-button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover', [ 'label' => __( 'Hover', 'lqthemes-companion' ) ] );

		$this->add_control(
			'button_hover_text_color',
			[
				'label' => __( 'Text Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button:hover, {{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label' => __( 'Background Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button:hover, {{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button:hover, {{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label' => __( 'Navigation', 'lqthemes-companion' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_arrows',
			[
				'label' => __( 'Arrows', 'lqthemes-companion' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		/*$this->add_control(
			'arrows_position',
			[
				'label' => __( 'Arrows Position', 'lqthemes-companion' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => [
					'inside' => __( 'Inside', 'lqthemes-companion' ),
					'outside' => __( 'Outside', 'lqthemes-companion' ),
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);*/

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Arrows Size', 'lqthemes-companion' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .owl-prev:before, {{WRAPPER}} .owl-next:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label' => __( 'Arrows Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .owl-prev:before, {{WRAPPER}} .owl-next:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_dots',
			[
				'label' => __( 'Dots', 'lqthemes-companion' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		/*$this->add_control(
			'dots_position',
			[
				'label' => __( 'Dots Position', 'lqthemes-companion' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => [
					'outside' => __( 'Outside', 'lqthemes-companion' ),
					'inside' => __( 'Inside', 'lqthemes-companion' ),
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);*/

		$this->add_control(
			'dots_size',
			[
				'label' => __( 'Dots Size', 'lqthemes-companion' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 15,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .owl-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label' => __( 'Dots Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .owl-dot' => 'color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		
		wp_enqueue_script( 'owl-carousel');	
		
		$settings = $this->get_settings();

		if ( empty( $settings['slides'] ) ) {
			return;
		}

		$this->add_render_attribute( 'button', 'class', [ 'elementor-button', 'elementor-slide-button' ] );

		if ( ! empty( $settings['button_size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['button_size'] );
		}

		$slides = [];
		$slide_count = 0;

		foreach ( $settings['slides'] as $slide ) {
			
			$slide_html = '';
			$btn_attributes = '';
			$slide_attributes = '';
			$slide_element = 'div';
			$btn_element = 'div';
			$slide_url = $slide['link']['url'];
			
			

			if ( ! empty( $slide_url ) ) {
				$this->add_render_attribute( 'slide_link' . $slide_count, 'href', $slide_url );

				if ( $slide['link']['is_external'] ) {
					$this->add_render_attribute( 'slide_link' . $slide_count, 'target', '_blank' );
				}

				if ( 'button' === $slide['link_click'] ) {
					$btn_element = 'a';
					$btn_attributes = $this->get_render_attribute_string( 'slide_link' . $slide_count );
				} else {
					$slide_element = 'a';
					$slide_attributes = $this->get_render_attribute_string( 'slide_link' . $slide_count );
				}
			}
			
			
			$slide_html .= '<figure class="lq-widget-slider-item">';  
			$slide_html .= '<img src="'.esc_url($slide['slide_image']['url']).'" alt="">';
			
			$slide_html .= '<figcaption class="lq-widget-slider-caption lq-flex-box text-'.$settings['slides_text_align'].' h-'.$settings['slides_vertical_position'].' v-'.$settings['slides_horizontal_position'].'">';
			
			$slide_html .= '<div class="lq-widget-slider-caption-inner">';
			
			if ( $slide['heading'] ) {
				$slide_html .= '<h2 class="lq-widget-slider-title">' . $slide['heading'] . '</h2>';
			}
			
			if ( $slide['description'] ) {
				$slide_html .= '<div class="lq-widget-slider-description">' . $slide['description'] . '</div>';
			}
			
			if ( $slide['button_text'] ) {
				$slide_html .= '<' . $btn_element . ' ' . $btn_attributes . ' ' . $this->get_render_attribute_string( 'button' ) . '>' . $slide['button_text'] . '</' . $btn_element . '>';
			}
			
			$slide_html .= '</div>';
            $slide_html .= '</figcaption>';
            $slide_html .= '</figure>';
			
			$ken_class = '';

			
			$slide_html = '<' . $slide_element . ' ' . $slide_attributes . ' class="slick-slide-inner">' . $slide_html . '</' . $slide_element . '>';

			$slides[] = $slide_html;
			$slide_count++;
		}

		$is_rtl = is_rtl();
		$direction = $is_rtl ? 'rtl' : 'ltr';
		$show_dots = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
		$show_arrows = ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) );

		$slick_options = [
			'slidesToShow' => absint( 1 ),
			'autoplaySpeed' => absint( $settings['autoplay_speed'] ),
			'autoplay' => ( 'yes' === $settings['autoplay'] ),
			'infinite' => ( 'yes' === $settings['infinite'] ),
			'autoplayHoverPause' => ( 'yes' === $settings['pause_on_hover'] ),
			//'autoplayTimeout' => absint( $settings['transition_speed'] ),
			'nav' => $show_arrows,
			'dots' => $show_dots,
			'rtl' => $is_rtl,
			'items' => 1,
			'loop' => ( 'yes' === $settings['infinite'] ),
		];


		?>

         <div data-options='<?php echo json_encode( $slick_options ); ?>' class="lq-widget-slider owl-carousel" dir="<?php echo esc_attr( $direction ); ?>">
         
         <?php echo implode( '', $slides ); ?>
                      
              </div>
                                               
		<?php
	}

	protected function _content_template() {
		
		?>
		<#
				var isRtl       = <?php echo is_rtl() ? 'true' : 'false'; ?>,
				direction       = isRtl ? 'rtl' : 'ltr',
				navi            = settings.navigation,
				showDots        = ( 'dots' === navi || 'both' === navi ),
				showArrows      = ( 'arrows' === navi || 'both' === navi ),
				autoplay        = ( 'yes' === settings.autoplay ),
				infinite        = ( 'yes' === settings.infinite ),
				speed           = Math.abs( settings.transition_speed ),
				autoplaySpeed   = Math.abs( settings.autoplay_speed ),
				fade            = ( 'fade' === settings.transition ),
				buttonSize      = settings.button_size,
				sliderOptions = {
					"initialSlide": Math.max( 0, editSettings.activeItemIndex-1 ),
					"slidesToShow": 1,
					"autoplaySpeed": autoplaySpeed,
					"autoplay": false,
					"infinite": infinite,
					"autoplayHoverPause":true,
					"pauseOnFocus":true,
					/*"autoplayTimeout": speed,*/
					"nav": showArrows,
					"dots": showDots,
					"rtl": isRtl,
					"fade": fade,
                    "items": 1,
                    'loop' : infinite
				}
				sliderOptionsStr = JSON.stringify( sliderOptions );
                
			if ( showArrows ) {
				var arrowsClass = 'slick-arrows-' + settings.arrows_position;
			}

			if ( showDots ) {
				var dotsClass = 'slick-dots-' + settings.dots_position;
			}
            
            
		#>
        
        <div class="lq-widget-slider owl-carousel" data-options='{{ sliderOptionsStr }}' dir="{{ direction }}">
        
        <# _.each( settings.slides, function( slide ) { #>
          <figure class="lq-widget-slider-item">
          
          <img src="{{{ slide.slide_image.url }}}" alt="{{{ slide.heading }}}" >
     
              <figcaption class="lq-widget-slider-caption lq-flex-box text-{{settings.slides_text_align}} h-{{settings.slides_horizontal_position }} v-{{settings.slides_vertical_position}}">
                  <div class="lq-widget-slider-caption-inner">
                  
                  	  <# if ( slide.heading ) { #>
                      <h2 class="lq-widget-slider-title">{{{ slide.heading }}}</h2>
                      <# } #>
                      <# if ( slide.description ) { #>
                      <div class="lq-widget-slider-description">{{{ slide.description }}}</div>
                      <# } #>
                      <# if ( slide.button_text ) { #>
                          <span class="elementor-button elementor-size-sm">{{{ slide.button_text }}}</span>
                     <# } #>
                  </div>
              </figcaption>
          </figure>
          
          <# } ); #>
          
          </div>
          
 
		<?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new LQThemes_Slides );