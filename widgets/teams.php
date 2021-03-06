<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Teams Widget
 *
 * Elementor widget that displays card-like teams read from teams custom
 * post type with number of cards defined by the user.
 *
 */
class Teams_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Teams widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_name(): string {
		return 'teams';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Teams widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_title(): string {
		return esc_html__( 'Teams', 'lkc-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Teams widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_icon(): string {
		return 'eicon-person';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Teams widget belongs to.
	 *
	 * @return array Widget categories.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_categories(): array {
		return array( 'lkc' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the Teams widget belongs to.
	 *
	 * @return array Widget keywords.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_keywords(): array {
		return array( 'teams', 'team', 'review' );
	}

	/**
	 * Register Teams widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'teams-image',
			array(
				'label' => esc_html__( 'Images', 'lkc-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'teams-image-dimensions',
			[
				'label'      => esc_html__( 'Card Height', 'lkc-elementor-widgets' ),
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
					'size' => 270,
				],
				'selectors'  => [
					'{{WRAPPER}} .teams-widget-card__image' => 'height: {{SIZE}}{{UNIT}};',
				],
			],
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'teams-full_name',
			array(
				'label' => esc_html__( 'Full Name', 'lkc-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'teams-full_name',
				'selector' => '{{WRAPPER}} .teams-widget-card__full_name',
			]
		);

		$this->add_control(
			'teams-full_name_color',
			array(
				'label'     => esc_html__( 'Color', 'dwply-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} .teams-widget-card__full_name' => 'color: {{VALUE}}',
				],
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'teams-job_title',
			array(
				'label' => esc_html__( 'Job Title', 'lkc-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'teams-job_title',
				'selector' => '{{WRAPPER}} .teams-widget-card__job_title',
			]
		);

		$this->add_control(
			'teams-job_title_color',
			array(
				'label'     => esc_html__( 'Color', 'lkc-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} .teams-widget-card__job_title' => 'color: {{VALUE}}',
				],
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'teams-email',
			array(
				'label' => esc_html__( 'Email', 'lkc-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'teams-email',
				'selector' => '{{WRAPPER}} .teams-widget-card__email',
			]
		);

		$this->add_control(
			'teams-email_color',
			array(
				'label'     => esc_html__( 'Color', 'lkc-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} .teams-widget-card__email' => 'color: {{VALUE}}',
				],
			)
		);
		$this->end_controls_section();

	}

	/**
	 * Render Teams widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		echo '<div class="teams-widget">';
		echo '<div class="teams-widget-container row">';

		foreach ( $this->get_teams() as $team ) {
			$this->card_html(
				$team['full_name'],
				$team['job_title'],
				$team['email'],
				$team['slug'],
				$team['image']
			);
		}

		echo '</div>';
		echo '</div>';

	}


	/**
	 * Echos HTML needed to create single card.
	 *
	 * @param string $full_name
	 * @param string $job_title
	 * @param string $email
	 * @param string $slug
	 * @param string $image
	 *
	 * @return void
	 */

	private function card_html( string $full_name, string $job_title, string $email, string $slug, string $image ) {
		echo "<div id=\"$slug\" class=\"col-sm-6 col-xl-3\">";
		echo '<div class="teams-widget-card">';
		echo "<img src=\"$image\" alt=\"Image of $full_name\" class=\"teams-widget-card__image\">";
		echo "<h2 class=\teams-widget-card__full_name\">$full_name</h2>";
		echo "<p class=\"teams-widget-card__job_title\">$job_title</p>";
		echo "<i class=\"fa-solid fa-envelope\"></i><a href=\"mailto:$email\" class=\"teams-widget-card__email\">&nbsp;$email</a>";
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Returns array of WooCommerce categories.
	 *
	 * @return array
	 */
	private function get_teams(): array {
		$args = array(
			'post_type'   => "team",
			'numberposts' => - 1,
			'orderby'     => 'menu_order',
			'order'       => 'ASC',
		);

		$replace = array(
			"??" => "A", "??" => "B", "??" => "V", "??" => "G",
			"??" => "D", "??" => "Dj", "??" => "E", "??" => "Z",
			"??" => "Z", "??" => "I", "??" => "J", "??" => "K",
			"??" => "L", "??" => "LJ","??" => "M", "??" => "N",
			"??" => "NJ","??" => "O", "??" => "P", "??" => "R",
			"??" => "S", "??" => "T", "??" => "C",
			"??" => "U", "??" => "F", "??" => "H", "??" => "C",
			"??" => "C", "??" => "DZ","??" => "S", "??" => "a",
			"??" => "b", "??" => "v", "??" => "g", "??" => "d",
			"??" => "??", "??" => "e", "??" => "z", "??" => "z",
			"??" => "i", "??" => "j", "??" => "k", "??" => "l",
			"??" => "lj","??" => "m", "??" => "n", "??" => "nj",
			"??" => "o", "??" => "p", "??" => "r", "??" => "s",
			"??" => "t", "??" => "c", "??" => "u",
			"??" => "f", "??" => "h", "??" => "c", "??" => "c",
			"??" => "dz", "??" => "s",
			"????" => "Nja", "????" => "Nje", "????" => "Nji",
			"????" => "Njo", "????" => "Nju", "????" => "Lja",
			"????" => "Lje", "????" => "Lji", "????" => "Ljo",
			"????" => "Lju", "????" => "Dza", "????" => "Dze",
			"????" => "Dzi", "????" => "Dzo", "????" => "Dzu",
		);

		$teams = [];

		foreach ( get_posts( $args ) as $post ) {
			$photo_id = $post->image;

			$teams[] = [
				'full_name' => $post->post_title,
				'job_title' => $post->job_title,
				'email'     => $post->email,
				'slug'     =>  sanitize_title(strtr($post->post_title, $replace)),
				'image'     => wp_get_attachment_image_url( $photo_id, 'medium' ) ?: plugins_url( '/assets/img/teams_placeholder.png', LKC_PLUGIN_FILE ),
			];
		}

		return $teams;

	}

}
