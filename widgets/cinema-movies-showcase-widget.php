<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Cinema Movies Showcase Widget
 *
 * Elementor widget that displays movie cards. Movies are fetched from https://bioskoplkc.rs API and
 * three latest movies are display using this widget.
 *
 */
class Cinema_Movies_Showcase_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Cinema Movies Showcase widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_name(): string {
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
	public function get_title(): string {
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
	public function get_icon(): string {
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
	public function get_categories(): array {
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
	public function get_keywords(): array {
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
		$movies = $this->get_three_latest_movies();

		echo '<div class="cinema-movies-showcase-container">';
		echo ' <div class="cinema-movies-showcase-wrapper">';
		foreach ( $movies as $movie ):
			echo '<div>';
			echo "<a href=\"$movie->permalink\" target=\"_blank\" style=\"background: url('$movie->img_url')\" class=\"cinema-movies-showcase-card\">";
			echo '<div class="cinema-movies-showcase-card__overlay"></div>';
			echo "<h3 class=\"cinema-movies-showcase-card__title\">$movie->post_title</h3>";
			echo '</a>';
			echo '</div>';
		endforeach;
		echo '</div>';
		echo '</div>';
	}


	/**
	 * Returns array of three latest movies fetched from 'https://bioskoplkc.rs' API.
	 *
	 * @return array
	 */
	private function get_three_latest_movies(): array {
		$response = wp_remote_get( 'https://bioskoplkc.rs/wp-json/cinema/v1/latest-movies' );
		$data     = wp_remote_retrieve_body( $response );

		return json_decode( $data );
	}
}
