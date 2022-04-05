<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Testimonials Widget
 *
 * Elementor widget that displays card-like testimonials read from testimonial custom
 * post type with number of cards defined by the user.
 *
 */
class Cinema_Movies_Showcase extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Cinema Movies Showcase widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_name() {
		return 'cinema-movies-showcase';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Cinema Movies Showcase widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_title() {
		return esc_html__( 'Cinema Movies Showcase', 'lkc-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Cinema Movies Showcase widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Cinema Movies Showcase widget belongs to.
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
	 * Retrieve the list of keywords the Cinema Movies Showcase widget belongs to.
	 *
	 * @return array Widget keywords.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_keywords() {
		return array( 'movies', 'movie', 'cinema' );
	}

	/**
	 * Register Cinema Movies Showcase widget controls.
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
				'label' => esc_html__( 'Content', 'resize' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'number_of_testimonials',
			array(
				'label'       => esc_html__( 'Number of testimonials', 'resize' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => esc_html__( '#', 'resize' ),
				'default'     => '4',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render Cinema Movies Showcase widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		echo '<div class="row">';

		foreach ( $this->get_testimonials( $settings['number_of_testimonials'] ) as $testimonial ) {
			$this->card_html(
				$testimonial['full_name'],
				$testimonial['content'],
				$testimonial['photo']
			);
		}

		echo '</div>';

	}


	/**
	 * Echos HTML needed to create single card.
	 *
	 * @param $name
	 * @param $content
	 * @param $photo
	 *
	 * @return void
	 */
	private function card_html( $name, $content, $photo ) {
		echo '<div class="testimonials-widget-card-container col-md-6 col-12">';
		echo '<div class="testimonials-widget-card">';
		echo '<div class="testimonials-widget-card__left-side">';
		echo '<img src="' . $photo . '" alt="Image of ' . $name . '" class="testimonials-widget-card__image">';
		echo '</div>';
		echo '<div class="testimonials-widget-card__right-side">';
		echo '<p class="testimonials-widget-card__content">' . $content . '</p>';
		echo '<span class="testimonials-widget-card__name">' . $name . '</span>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Returns array of WooCommerce categories.
	 *
	 * @param $number
	 *
	 * @return array
	 */
	private function get_testimonials( $number = 0 ) {
		$args = array(
			'post_type'   => "testimonial",
			'numberposts' => $number,
			'orderby'     => 'date',
		);

		$testimonials = [];

		foreach ( get_posts( $args ) as $post ) {
			$photo_id = $post->photo;

			$testimonials[] = [
				'full_name' => $post->full_name,
				'content'   => wp_trim_words( $post->content , 20 ),
				'photo'     => wp_get_attachment_image_url( $photo_id, 'medium' ) ??
				               plugins_url( '/assets/img/show-all-placeholder.svg', RESIZE_PLUGIN_FILE ),
			];
		}

		return $testimonials;

	}

}
