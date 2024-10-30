<?php
namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class LQThemes_Countdown extends Widget_Base {

	public function get_name() {
		return 'lq_countdown';
	}

	public function get_title() {
		return __( 'Countdown', 'lqthemes-companion' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}
	
	public function get_categories() {
		return [ 'lqthemes-elements' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_countdown',
			[
				'label' => __( 'Countdown', 'lqthemes-companion' ),
			]
		);

		$this->add_control(
			'due_date',
			[
				'label' => __( 'Due Date', 'lqthemes-companion' ),
				'type' => Controls_Manager::DATE_TIME,
				'default' => date( 'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ),
				/* translators: %s: Time zone. */
				'description' => sprintf( __( 'Date set according to your timezone: %s.', 'lqthemes-companion' ), Utils::get_timezone_string() ),
			]
		);

		/*$this->add_control(
			'label_display',
			[
				'label' => __( 'View', 'lqthemes-companion' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'block' => __( 'Block', 'lqthemes-companion' ),
					'inline' => __( 'Inline', 'lqthemes-companion' ),
				],
				'default' => 'block',
				'prefix_class' => 'elementor-countdown--label-',
			]
		);*/

		$this->add_control(
			'show_days',
			[
				'label' => __( 'Days', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'lqthemes-companion' ),
				'label_off' => __( 'Hide', 'lqthemes-companion' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_hours',
			[
				'label' => __( 'Hours', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'lqthemes-companion' ),
				'label_off' => __( 'Hide', 'lqthemes-companion' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_minutes',
			[
				'label' => __( 'Minutes', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'lqthemes-companion' ),
				'label_off' => __( 'Hide', 'lqthemes-companion' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_seconds',
			[
				'label' => __( 'Seconds', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'lqthemes-companion' ),
				'label_off' => __( 'Hide', 'lqthemes-companion' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_labels',
			[
				'label' => __( 'Show Label', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'lqthemes-companion' ),
				'label_off' => __( 'Hide', 'lqthemes-companion' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'custom_labels',
			[
				'label' => __( 'Custom Label', 'lqthemes-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'show_labels!' => '',
				],
			]
		);

		$this->add_control(
			'label_days',
			[
				'label' => __( 'Days', 'lqthemes-companion' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Days', 'lqthemes-companion' ),
				'placeholder' => __( 'Days', 'lqthemes-companion' ),
				'condition' => [
					'show_labels!' => '',
					'custom_labels!' => '',
					'show_days' => 'yes',
				],
			]
		);

		$this->add_control(
			'label_hours',
			[
				'label' => __( 'Hours', 'lqthemes-companion' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Hours', 'lqthemes-companion' ),
				'placeholder' => __( 'Hours', 'lqthemes-companion' ),
				'condition' => [
					'show_labels!' => '',
					'custom_labels!' => '',
					'show_hours' => 'yes',
				],
			]
		);

		$this->add_control(
			'label_minutes',
			[
				'label' => __( 'Minutes', 'lqthemes-companion' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Minutes', 'lqthemes-companion' ),
				'placeholder' => __( 'Minutes', 'lqthemes-companion' ),
				'condition' => [
					'show_labels!' => '',
					'custom_labels!' => '',
					'show_minutes' => 'yes',
				],
			]
		);

		$this->add_control(
			'label_seconds',
			[
				'label' => __( 'Seconds', 'lqthemes-companion' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Seconds', 'lqthemes-companion' ),
				'placeholder' => __( 'Seconds', 'lqthemes-companion' ),
				'condition' => [
					'show_labels!' => '',
					'custom_labels!' => '',
					'show_seconds' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => __( 'Boxes', 'lqthemes-companion' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'container_width',
			[
				'label' => __( 'Container Width', 'lqthemes-companion' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 600,
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ '%', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .lq-widget-countdown' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'box_background_color',
			[
				'label' => __( 'Background Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-countdown-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'selector' => '{{WRAPPER}} .elementor-countdown-item',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'box_border_radius',
			[
				'label' => __( 'Border Radius', 'lqthemes-companion' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-countdown-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'box_spacing',
			[
				'label' => __( 'Space Between', 'lqthemes-companion' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .elementor-countdown-item:not(:first-of-type)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
					'body:not(.rtl) {{WRAPPER}} .elementor-countdown-item:not(:last-of-type)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .elementor-countdown-item:not(:first-of-type)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .elementor-countdown-item:not(:last-of-type)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
				],
			]
		);

		$this->add_responsive_control(
			'box_padding',
			[
				'label' => __( 'Padding', 'lqthemes-companion' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-countdown-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'lqthemes-companion' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_digits',
			[
				'label' => __( 'Digits', 'lqthemes-companion' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'digits_color',
			[
				'label' => __( 'Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lq-widget-countdown-number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'digits_typography',
				'selector' => '{{WRAPPER}} .lq-widget-countdown-number',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'heading_label',
			[
				'label' => __( 'Label', 'lqthemes-companion' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => __( 'Color', 'lqthemes-companion' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lq-widget-countdown-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'selector' => '{{WRAPPER}} .lq-widget-countdown-title',
				'scheme' => Scheme_Typography::TYPOGRAPHY_2,
			]
		);

		$this->end_controls_section();
	}

	private function get_strftime( $instance ) {
		$string = '';
		if ( $instance['show_days'] ) {
			$string .= $this->render_countdown_item( $instance, 'label_days', 'lq-countdown-days' );
		}
		if ( $instance['show_hours'] ) {
			$string .= $this->render_countdown_item( $instance, 'label_hours', 'lq-countdown-hours' );
		}
		if ( $instance['show_minutes'] ) {
			$string .= $this->render_countdown_item( $instance, 'label_minutes', 'lq-countdown-minutes' );
		}
		if ( $instance['show_seconds'] ) {
			$string .= $this->render_countdown_item( $instance, 'label_seconds', 'lq-countdown-seconds' );
		}

		return $string;
	}

	private $_default_countdown_labels;

	private function _init_default_countdown_labels() {
		$this->_default_countdown_labels = [
			'label_months' => __( 'Months', 'lqthemes-companion' ),
			'label_weeks' => __( 'Weeks', 'lqthemes-companion' ),
			'label_days' => __( 'Days', 'lqthemes-companion' ),
			'label_hours' => __( 'Hours', 'lqthemes-companion' ),
			'label_minutes' => __( 'Minutes', 'lqthemes-companion' ),
			'label_seconds' => __( 'Seconds', 'lqthemes-companion' ),
		];
	}

	public function get_default_countdown_labels() {
		if ( ! $this->_default_countdown_labels ) {
			$this->_init_default_countdown_labels();
		}

		return $this->_default_countdown_labels;
	}

	private function render_countdown_item( $instance, $label, $part_class ) {
		
		
																
		$string = '<div class="lq-widget-countdown-item"><span class="lq-widget-countdown-item-inner "><div class="lq-widget-countdown-number ' . $part_class . '"></div></span>';

		if ( $instance['show_labels'] ) {
			$default_labels = $this->get_default_countdown_labels();
			$label = ( $instance['custom_labels'] ) ? $instance[ $label ] : $default_labels[ $label ];
			$string .= ' <h3 class="lq-widget-countdown-title">' . $label . '</h3>';
		}

		$string .= '</div>';

		return $string;
	}

	protected function render() {
		$instance  = $this->get_settings();
		$due_date  = $instance['due_date'];
		$string    = $this->get_strftime( $instance );

		// Handle timezone ( we need to set GMT time )
		$gmt = get_gmt_from_date( $due_date . ':00' );

		$due_date = strtotime( $gmt );
		$due_date = date('Y/m/d H:i:s', $due_date );
		$now = date('Y/m/d H:i:s', time());
		?>
        <div class="lq-widget-countdown" data-date="<?php echo $due_date; ?>" data-now="<?php echo $now; ?>"> <div class="lq-list-md-4">
			<?php echo $string; ?>
		</div></div>
		<?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new LQThemes_Countdown );