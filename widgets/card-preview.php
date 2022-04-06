<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Card Preview Widget
 *
 * Elementor widget that inserts flexible number of cards which can display simple linked images or linked videos
 *
 */
class Card_Preview_Widgets extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Card Preview widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_name() {
		return 'card-preview';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Card Preview widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_title() {
		return esc_html__( 'Multiple Card Like Preview', 'lkc-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Card Preview widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_icon() {
		return 'eicon-product-categories';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Card Preview widget belongs to.
	 *
	 * @return array Widget categories.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_categories() {
		return array( 'lkc' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the Card Preview widget belongs to.
	 *
	 * @return array Widget keywords.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_keywords() {
		return array( 'woocommerce', 'cards', 'preview', 'card', 'showcase' );
	}

	/**
	 * Register Card Preview widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		/**
		 * Default display settings for all cards section
		 */
		$this->start_controls_section(
			'card_display',
			array(
				'label' => esc_html__( 'Card Display', 'lkc-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'card_type',
			[
				'label'   => esc_html__( 'Card type', 'lkc-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'image',
				'options' => array(
					'image' => esc_html__( 'Image', 'lkc-elementor-widgets' ),
					'video' => esc_html__( 'Video', 'lkc-elementor-widgets' ),
				),
			]
		);
		// When image selected
		$this->add_responsive_control(
			'image_card_height',
			[
				'label'      => esc_html__( 'Card Image Height', 'lkc-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'vh' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'vh' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => '240',
				),
				'selectors'  => array(
					'{{WRAPPER}} .card-preview-card' => 'max-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'card_type' => 'image',
				),
			],
		);
		$this->add_responsive_control(
			'image_card_width',
			[
				'label'      => esc_html__( 'Card Image Width', 'lkc-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'vh' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'vh' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => '240',
				),
				'selectors'  => array(
					'{{WRAPPER}} .card-preview-card' => 'max-width: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'card_type' => 'image',
				),
			],
		);
		// When video selected
		$this->add_responsive_control(
			'video_card_height',
			[
				'label'      => esc_html__( 'Card Video Height', 'lkc-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'vh' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'vh' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => '240',
				),
				'selectors'  => array(
					'{{WRAPPER}} .card-preview-card-wrapper' => 'max-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .card-preview-card'         => 'height: 100%;',
				),
				'condition'  => array(
					'card_type' => 'video',
				),
			],
		);
		$this->add_responsive_control(
			'video_card_width',
			[
				'label'      => esc_html__( 'Card Video Width', 'lkc-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'vh' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
					'vh' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => '240',
				),
				'selectors'  => array(
					'{{WRAPPER}} .card-preview-card-wrapper' => 'max-width: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .card-preview-card'         => 'width: 100%;',
				),
				'condition'  => array(
					'card_type' => 'video',
				),
			],
		);
		$this->end_controls_section();

		/**
		 * Content for card #1 section
		 */
		$this->start_controls_section(
			'content_card_1',
			array(
				'label' => esc_html__( 'Content Card #1', 'lkc-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'card_title_1',
			array(
				'label'       => esc_html__( 'Card Title', 'lkc-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Type card title here', 'lkc-elementor-widgets' ),
			)
		);
		// When image selected
		$this->add_control(
			'background_image_url_1',
			array(
				'label'     => esc_html__( 'Choose image', 'lkc-elementor-widgets' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => plugins_url( '/assets/img/placeholder.png', LKC_PLUGIN_FILE ),
				),
				'condition' => array(
					'card_type' => 'image',
				),
			)
		);
		$this->add_control(
			'image_card_link_1',
			array(
				'label'       => esc_html__( 'Image Link', 'lkc-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'lkc-elementor-widgets' ),
				'default'     => [
					'url'               => '#',
					'is_external'       => true,
					'nofollow'          => true,
					'custom_attributes' => '',
				],
				'condition'   => array(
					'card_type' => 'image',
				),
			)
		);
		// When video selected
		$this->add_control(
			'video_url_1',
			array(
				'label'       => esc_html__( 'Video URL', 'lkc-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'lkc-elementor-widgets' ),
				'default'     => [
					'url'               => '#',
					'is_external'       => true,
					'nofollow'          => true,
					'custom_attributes' => '',
				],
				'condition'   => array(
					'card_type' => 'video',
				),
			)
		);
		$this->end_controls_section();

		/**
		 * Content for card #2 section
		 */
		$this->start_controls_section(
			'content_card_2',
			array(
				'label' => esc_html__( 'Content Card #2', 'lkc-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'card_title_2',
			array(
				'label'       => esc_html__( 'Card Title', 'lkc-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Type card title here', 'lkc-elementor-widgets' ),
			)
		);
		// When image selected
		$this->add_control(
			'background_image_url_2',
			array(
				'label'     => esc_html__( 'Choose image', 'lkc-elementor-widgets' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => plugins_url( '/assets/img/placeholder.png', LKC_PLUGIN_FILE ),
				),
				'condition' => array(
					'card_type' => 'image',
				),
			)
		);
		$this->add_control(
			'image_card_link_2',
			array(
				'label'       => esc_html__( 'Image Link', 'lkc-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'lkc-elementor-widgets' ),
				'default'     => [
					'url'               => '#',
					'is_external'       => true,
					'nofollow'          => true,
					'custom_attributes' => '',
				],
				'condition'   => array(
					'card_type' => 'image',
				),
			)
		);
		// When video selected
		$this->add_control(
			'video_url_2',
			array(
				'label'       => esc_html__( 'Video URL', 'lkc-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'lkc-elementor-widgets' ),
				'default'     => [
					'url'               => '#',
					'is_external'       => true,
					'nofollow'          => true,
					'custom_attributes' => '',
				],
				'condition'   => array(
					'card_type' => 'video',
				),
			)
		);
		$this->end_controls_section();

		/**
		 * Content for card #3 section
		 */
		$this->start_controls_section(
			'content_card_3',
			array(
				'label' => esc_html__( 'Content Card #3', 'lkc-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'card_title_3',
			array(
				'label'       => esc_html__( 'Card Title', 'lkc-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Type card title here', 'lkc-elementor-widgets' ),
			)
		);
		// When image selected
		$this->add_control(
			'background_image_url_3',
			array(
				'label'     => esc_html__( 'Choose image', 'lkc-elementor-widgets' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => plugins_url( '/assets/img/placeholder.png', LKC_PLUGIN_FILE ),
				),
				'condition' => array(
					'card_type' => 'image',
				),
			)
		);
		$this->add_control(
			'image_card_link_3',
			array(
				'label'       => esc_html__( 'Image Link', 'lkc-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'lkc-elementor-widgets' ),
				'default'     => [
					'url'               => '#',
					'is_external'       => true,
					'nofollow'          => true,
					'custom_attributes' => '',
				],
				'condition'   => array(
					'card_type' => 'image',
				),
			)
		);
		// When video selected
		$this->add_control(
			'video_url_3',
			array(
				'label'       => esc_html__( 'Video URL', 'lkc-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'lkc-elementor-widgets' ),
				'default'     => [
					'url'               => '#',
					'is_external'       => true,
					'nofollow'          => true,
					'custom_attributes' => '',
				],
				'condition'   => array(
					'card_type' => 'video',
				),
			)
		);
		$this->end_controls_section();


		/**
		 * Style section
		 */
		$this->start_controls_section(
			'style_section',
			array(
				'label' => esc_html__( 'Card Title', 'lkc-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'card_content_typography',
				'selector' => '{{WRAPPER}} p.card-preview-card__title',
			]
		);
		$this->add_control(
			'card_title_color',
			array(
				'label'     => esc_html__( 'Color', 'lkc-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} p.card-preview-card__title' => 'color: {{VALUE}}',
				],
			)
		);
		$this->add_control(
			'card_title_hover_color',
			array(
				'label'     => esc_html__( 'Color on hover', 'lkc-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .card-preview-card:hover .card-preview-card__title, .card-preview-card__title:hover' => 'color: {{VALUE}} !important',
				],
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Render Card Preview widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$is_image_card = $settings['card_type'] === 'image';

		echo '<div class="card-preview-container">';
		echo ' <div class="card-preview-wrapper">';

		for ( $i = 1; $i <= 3; $i ++ ) {
			if ( $is_image_card ) {
				$this->image_card_html( $settings["image_card_link_$i"]['url'], $settings["background_image_url_$i"]['url'], $settings["card_title_$i"] );
			} else {
				$this->video_card_html( $settings["video_url_$i"]['url'], plugins_url( '/assets/img/placeholder.png', LKC_PLUGIN_FILE ), $settings["card_title_$i"] );
			}
		}
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Echos HTML needed to create single video preview card.
	 *
	 * @return void
	 */
	private function video_card_html( $video_url, $background_img_url, $card_title ) {
		$play_button_img_url = plugins_url( '/assets/img/play-button.png', LKC_PLUGIN_FILE );

		echo ' <div class="card-preview-card-wrapper">';

		echo "<a href=\"$video_url\" style=\"background: url('$background_img_url')\" class=\"card-preview-card\">";
		echo "<img src=\"$play_button_img_url\" class=\"card-preview-card__play_img_overlay\" alt=\"Play button\"/>";
		echo '</a>';

		echo "<a href=\"$video_url\">";
		echo "<p class=\"card-preview-card__title\">$card_title</p>";
		echo '</a>';

		echo '</div>';
	}

	/**
	 * Echos HTML needed to create single video preview card.
	 *
	 * @return void
	 */
	private function image_card_html( $image_card_link, $background_img_url, $card_title ) {
		echo "<a href=\"$image_card_link\" style=\"background: url('$background_img_url')\" class=\"card-preview-card\">";
		echo "<p class=\"card-preview-card__title\">$card_title</p>";
		echo '</a>';
	}
}
