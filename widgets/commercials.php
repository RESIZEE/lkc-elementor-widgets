<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Commercials Widget
 *
 * Elementor widget that display commercials as slideshow
 *
 */
class Commercials_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Commercials widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'commercials';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Commercials widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Commercials', 'lkc-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Commercials widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-slider-3d';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Commercials widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories(): array {
		return array( 'lkc' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the Commercials' widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords(): array {
		return array( 'elementor', 'commercial', 'commercials' );
	}


	/**
	 * Register Commercial widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'lkc-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'commercial_title', [
				'label'       => esc_html__( 'Title', 'lkc-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Commercial Title', 'lkc-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'commercial_link', [
				'label'       => esc_html__( 'Link', 'lkc-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'lkc-elementor-widgets' ),
				'default'     => [
					'url'               => '',
					'is_external'       => true,
					'custom_attributes' => '',
				],
				'show_label'  => true,
			]
		);

		$repeater->add_control(
			'commercial_image', [
				'label'   => esc_html( 'Choose Commercial' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'commercials',
			[
				'label'       => esc_html__( 'Commercials', 'lkc-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'commercial_title' => esc_html__( 'Commercial 1', 'lkc-elementor-widgets' ),
					],
					[
						'commercial_title' => esc_html__( 'Commercial 2', 'lkc-elementor-widgets' ),
					],
					[
						'commercial_title' => esc_html__( 'Commercial 3', 'lkc-elementor-widgets' ),
					],
					[
						'commercial_title' => esc_html__( 'Commercial 4', 'lkc-elementor-widgets' ),
					],
				],
				'title_field' => '{{{ commercial_title }}}',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'cards-style',
			array(
				'label' => esc_html__( 'Commercials', 'lkc-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'commercials-dimensions',
			[
				'label'      => esc_html__( 'Commercials Height', 'lkc-elementor-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 150,
				],
				'selectors'  => [
					'{{WRAPPER}} .commercials-widget__img-container' => 'height: {{SIZE}}{{UNIT}};',
				],
			],
		);
		$this->end_controls_section();
	}

	/**
	 * Render Commercials widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		echo '<div class="commercials-widget carousel slide" data-bs-ride="carousel">';
		echo '<div class="carousel-inner">';

		foreach ( $settings['commercials'] as $index => $item ) {
			$this->commercials_html(
				$item['commercial_link']['url'],
				$item['commercial_image']['url'],
				$index
			);
		}

		echo '</div>';
		echo '</div>';
	}


	/**
	 * Echos HTML needed to create single card.
	 *
	 * @param string $commercial_link
	 * @param string $commercial_image
	 * @param int $index
	 *
	 * @return void
	 */
	private function commercials_html( string $commercial_link, string $commercial_image, int $index ) {
		if ( $index === 0 ) {
			echo '<div class="carousel-item active">';
		} else {
			echo '<div class="carousel-item">';
		}
		echo '<a href="' . $commercial_link . '" target="_blank"><img class="commercials-widget__img-container" src="' . $commercial_image . '"></a>';
		echo '</div>';
	}
}

