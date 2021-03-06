<?php

namespace Elementor;

use Lkc\Helpers\Program\Event;
use Lkc\Helpers\Program\Program;
use stdClass;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Hero Slider Widget
 *
 * Elementor widget that displays four last events in form of a card.
 *
 */
class Hero_Slider_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Hero Slider widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_name(): string {
		return 'hero-slider';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Hero Slider widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_title(): string {
		return esc_html__( 'Hero Slider', 'lkc-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Hero Slider widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_icon(): string {
		return 'eicon-slider-push';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Hero Slider widget belongs to.
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
	 * Retrieve the list of keywords the Hero Slider widget belongs to.
	 *
	 * @return array Widget keywords.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_keywords(): array {
		return array( 'event', 'events', 'slider' );
	}

	/**
	 * Register Hero Slider widget controls.
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

		$this->add_control(
			'number_of_events',
			array(
				'label'       => esc_html__( 'Number of events', 'lkc-elementor-widgets' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => esc_html__( '#', 'lkc-elementor-widgets' ),
				'default'     => '5',
			)
		);

		$this->add_control(
			'number_of_news',
			array(
				'label'       => esc_html__( 'Number of news', 'lkc-elementor-widgets' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => esc_html__( '#', 'lkc-elementor-widgets' ),
				'default'     => '5',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render Hero Slider widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$events   = $this->get_latest_events( $settings['number_of_events'] );
		$news     = $this->get_latest_news( $settings['number_of_news'] );
		echo '<div class="hero-slider-controls">';
		echo '</div>';
		echo '<div class="hero-slider-container">';
		foreach ( $events as $event ) {
			$this->card_html( $event );
		}
		foreach ( $news as $news_object ) {
			$this->card_html_news(
				$news_object['news_title'],
				$news_object['news_excerpt'],
				$news_object['news_permalink'],
				$news_object['news_image'],
			);
		}
		echo '</div>';
	}

	/**
	 * @param Event $event
	 *
	 * @return void
	 */
	private function card_html( Event $event ): void {
		echo ' <div class="hero-slider-wrapper">';
		echo '<div class="hero-slider-image">';
		echo '<a href="' . $event->permalink . '" class="hero-slider-link">';
		echo '<img src="' . $event->img_url . '">';
		echo '</a>';
		echo '</div>';

		echo '<div class="hero-slider-info">';
		echo '<div class="hero-slider-info__program" style="width: 200px">';
		echo $event->program->program_sticker();
		echo '</div>';
		echo '<a href="' . $event->permalink . '" target="_blank" class="hero-slider-link">';
		echo '<div class="hero-slider-info__top">';
		echo '<h2>' . $event->name . '</h2>';
		echo '<p class="hero-slider-info__location"><i class="fas fa-map-marker-alt"></i> ' . $event->location . '</p>';
		echo '</div>';
		echo '<p class="hero-slider-info__excerpt">' . $event->excerpt . '</p>';
		echo '<p class="hero-slider-info__date-time">' . $event->day . '. ' . $event->get_month_long_name() . ' ' . $event->year . '. u ' . $event->time . 'h</p>';
		echo '</a>';
		echo '</div>';
		echo '</div>';
	}

	private function card_html_news( string $title, string $excerpt, string $permalink, string $image ): void {
		echo ' <div class="hero-slider-wrapper">';
		echo '<div class="hero-slider-image">';
		echo '<a href="' . $permalink . '" class="hero-slider-link">';
		echo '<img src="' . $image . '">';
		echo '</a>';
		echo '</div>';

		echo '<div class="hero-slider-info">';
		echo '<div class="hero-slider-info__program" style="width: 120px">';
		echo "<div class=\"program-sticker\">";
		echo '<i class="fas fa-chevron-right"></i>';
		echo '<span class="program-sticker__title">'.__('??????????????','resize').'</span>';
		echo "<i class=\"fa-solid fa-newspaper\"></i>";
		echo '</div>';
		echo '</div>';
		echo '<a href="' . $permalink . '" target="_blank" class="hero-slider-link">';
		echo '<div class="hero-slider-info__top">';
		echo '<h2>' . $title . '</h2>';
		echo '</div>';
		echo '<p class="hero-slider-info__excerpt">' . $excerpt . '</p>';
		echo '</a>';
		echo '</div>';
		echo '</div>';
	}

	/**
	 * @param int $number_of_events
	 *
	 * @return array
	 * @throws \Exception
	 */
	private function get_latest_events( int $number_of_events ): array {
		$events = [];
		$args   = array(
			'post_type'   => 'event',
			'post_status' => 'publish',

            'meta_query'     => array(
                'order_by_date_clause' => array(
                    'key'     => 'date_of_event',
                    'compare' => '>=',
                    'value'   => date( 'Y-m-d' ),
                    'type'    => 'DATE',
                ),
                'order_by_time_clause' => array(
                    'key'     => 'time_of_event',
                    'compare' => 'EXISTS',
                    'type'    => 'TIME',
                ),
            ),
			'orderby'    => array(
				'order_by_date_clause' => 'ASC',
				'order_by_time_clause' => 'ASC',
			),

			'posts_per_page' => $number_of_events,
		);

		$event_objects = get_posts( $args );

		foreach ( $event_objects as $event_object ) {
			$events[] = new Event( $event_object );
		}

		return $events;
	}


	/**
	 * @param int $number_of_news
	 *
	 * @return array
	 */
	private function get_latest_news( int $number_of_news ): array {
		$news = [];
		$args = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'meta_key'       => 'hero_news',
			'meta_value'     => true,
			'orderby'        => 'publish_date',
			'order'          => 'DESC',
			'posts_per_page' => $number_of_news,
		);

		foreach ( get_posts( $args ) as $news_object ) {
			$news[] = [
				'news_title'     => $news_object->post_title,
				'news_permalink' => get_permalink( $news_object->ID ),
				'news_image'     => get_the_post_thumbnail_url( $news_object ) ?: plugins_url( '/assets/img/placeholder.png', LKC_PLUGIN_FILE ),
				'news_excerpt'   => $news_object->post_excerpt ?: wp_trim_words( $news_object->post_content, 25 ),
			];
		}

		return $news;
	}
}
