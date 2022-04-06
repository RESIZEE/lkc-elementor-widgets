<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Card Preview Widget
 *
 * Elementor widget that inserts flexible number of cards which can display products or categories from WooCommerce
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

		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'lkc-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_responsive_control(
			'card_height',
			[
				'label'      => esc_html__( 'Card Image Height', 'lkc-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
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
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => '240',
				],
				'selectors'  => [
					'{{WRAPPER}} .product-category-widget-card__image' => 'height: {{SIZE}}{{UNIT}};',
				],
			],
		);

		$this->add_control(
			'number_of_cards',
			array(
				'label'       => esc_html__( 'Number of cards', 'lkc-elementor-widgets' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => esc_html__( '#', 'lkc-elementor-widgets' ),
				'default'     => '3',
			)
		);

		$this->add_control(
			'card_type',
			[
				'label'   => esc_html__( 'Card type', 'lkc-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'products',
				'options' => array(
					'products'   => esc_html__( 'Products', 'lkc-elementor-widgets' ),
					'categories' => esc_html__( 'Categories', 'lkc-elementor-widgets' ),
				),
			]
		);

		$this->add_control(
			'product_category',
			array(
				'label'     => esc_html__( 'Choose product category', 'lkc-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => array_key_first( $this->get_woocommerce_categories_for_select_element() ),
				'options'   => $this->get_woocommerce_categories_for_select_element(),
				'condition' => array(
					'card_type' => 'products',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'show_all_section',
			array(
				'label' => esc_html__( 'Show all card', 'lkc-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_all_card',
			array(
				'label'   => esc_html__( 'Add show all card', 'lkc-elementor-widgets' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_all_title',
			array(
				'label'       => esc_html__( 'Title', 'lkc-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => esc_html__( 'Title for show all card', 'lkc-elementor-widgets' ),
				'default'     => 'Show all',
				'condition'   => array(
					'show_all_card' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_all_img',
			array(
				'label'     => esc_html__( 'Choose image', 'lkc-elementor-widgets' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => plugins_url( '/assets/img/placeholder.png', LKC_PLUGIN_FILE ),
				),
				'condition' => array(
					'show_all_card' => 'yes',
				),
			)
		);

		$this->end_controls_section();

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
				'selector' => '{{WRAPPER}} .product-category-widget-card__title',
			]
		);

		$this->add_control(
			'card_title_color',
			array(
				'label'     => esc_html__( 'Color', 'lkc-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} .product-category-widget-card__title' => 'color: {{VALUE}}',
				],
			)
		);

		$this->add_control(
			'card_title_hover_color',
			array(
				'label'     => esc_html__( 'Color on hover', 'lkc-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} .product-category-widget-card:hover p' => 'color: {{VALUE}}',
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
		$settings         = $this->get_settings_for_display();
		$display_products = $settings['card_type'] === 'products';

		if ( $display_products ) {
			$posts = $this->get_woocommerce_products( $settings['product_category'], $settings['number_of_cards'] );
		} else {
			$posts = $this->get_woocommerce_categories( $settings['number_of_cards'] );
		}

		echo '<div class="row">';
		foreach ( $posts as $post ) {
			$this->card_html( $post['name'], $post['permalink'], $post['image_url'] );
		}
		if ( $settings['show_all_card'] === 'yes' ) {
			$show_all_permalink = $display_products ?
				get_term_link( $settings['product_category'], 'product_cat' ) :
				get_permalink( wc_get_page_id( 'shop' ) );

			$this->card_html(
				$settings['show_all_title'],
				$show_all_permalink,
				$settings['show_all_img']['url']
			);
		}
		echo '</div>';

	}

	/**
	 * Echos HTML needed to create single card.
	 *
	 * @param $name
	 * @param $permalink
	 * @param $image_url
	 *
	 * @return void
	 */
	private function card_html( $name, $permalink, $image_url ) {
		echo '<div class="product-category-widget-card col-6 col-md-3">';

		echo '<a href="' . $permalink . '">';
		echo '<div class="product-category-widget-card__image-wrapper">';
		echo '<img src="' . $image_url . '" alt="' . $name . '" class="product-category-widget-card__image">';
		echo '</div>';
		echo '<p class="product-category-widget-card__title">' . $name . '</p>';
		echo '</a>';

		echo '</div>';
	}

	/**
	 * Generates key value pairs which will be used in select HTML element as options property.
	 *
	 * @return void
	 */
	private function test() {
	}
}
