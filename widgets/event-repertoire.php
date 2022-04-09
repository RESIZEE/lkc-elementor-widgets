<?php

namespace Elementor;

use Lkc\Helpers\Program\Program;
use stdClass;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Event Repertoire Widget
 *
 * Elementor widget that displays four last events in form of a card.
 *
 */
class Event_Repertoire_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Event Repertoire widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_name(): string {
		return 'event-repertoire';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Event Repertoire widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_title(): string {
		return esc_html__( 'Event Repertoire', 'lkc-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Event Repertoire widget icon.
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
	 * Retrieve the list of categories the Event Repertoire widget belongs to.
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
	 * Retrieve the list of keywords the Event Repertoire widget belongs to.
	 *
	 * @return array Widget keywords.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_keywords(): array {
		return array( 'event', 'events', 'repertoire' );
	}

	/**
	 * Register Event Repertoire widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {}

	/**
	 * Render Event Repertoire widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$events = $this->get_four_latest_events();

		echo '<div class="event-repertoire-container">';
		echo ' <div class="event-repertoire-wrapper">';
		foreach ( $events as $event ):
			echo "<a href=\"$event->permalink\" target=\"_blank\" style=\"background: url('$event->img_url')\" class=\"event-repertoire-card event-repertoire-card--{$event->program->getSlug()}\">";
			$this->time_sticker( $event->date, $event->time );
			echo '<div class="event-repertoire-card__program-sticker">';
			$event->program->program_sticker();
			echo '</div>';
			$this->event_name_and_location( $event );
			echo '</a>';
		endforeach;
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Returns array of four latest events.
	 *
	 * @return array
	 */
	private function get_four_latest_events(): array {
		$events = [];
		$args   = array(
			'post_type'      => 'event',
			'post_status'    => 'publish',
			'order'          => 'DESC',
			'orderby'        => 'publish_date',
			'posts_per_page' => 4,
		);

		$event_objects = get_posts( $args );

		foreach ( $event_objects as $event_object ) {
			$event = new stdClass();

			$event_terms = get_the_terms( $event_object, 'program' );
			// Getting random index of an term so we can display different one each time.
			$random_terms_index = is_array( $event_terms ) ? rand( 0, count( $event_terms ) - 1 ) : 0;
			$program_name       = $event_terms ? $event_terms[ $random_terms_index ]->name : 'Nekategorizovano';
			$program_slug       = $event_terms ? $event_terms[ $random_terms_index ]->slug : 'none';
			$event->program     = new Program( $program_name, $program_slug );

			$location_field_object = get_field_object( 'location', $event_object->ID ) ?: [];
			$location_field_key    = array_key_exists( 'value', $location_field_object ) ? $location_field_object['value'] : '';
			$location              = array_key_exists( 'choices', $location_field_object ) ? $location_field_object['choices'][ $location_field_key ] : '';

			$event->img_url   = get_the_post_thumbnail_url( $event_object ) ?: plugins_url( '/assets/img/placeholder.png', LKC_PLUGIN_FILE );
			$event->name      = $event_object->post_title;
			$event->permalink = get_permalink( $event_object );

			$event->location = $location;
			$date_object     = $event_object->date_of_event ? new \DateTime( $event_object->date_of_event ) : '';
			$event->date     = [
				'day'   => $date_object ? $date_object->format( 'd' ) : '',
				'month' => $date_object ? $this->get_short_month_name( $date_object->format( 'm' ) ) : '',
			];
			$time_object     = $event_object->time_of_event ? new \DateTime( $event_object->time_of_event ) : '';
			$event->time     = $time_object ? $time_object->format( 'H.i' ) : '';

			$events[] = $event;
		}

		return $events;
	}

	private function get_short_month_name( string $month_number ): string {
		return array(
			1  => 'Jan',
			2  => 'Feb',
			3  => 'Mar',
			4  => 'Apr',
			5  => 'Maj',
			6  => 'Jun',
			7  => 'Jul',
			8  => 'Avg',
			9  => 'Sep',
			10 => 'Okt',
			11 => 'Nov',
			12 => 'Dec',
		)[ (int) $month_number ];
	}

	/**
	 * Returns HTML for time sticker.
	 *
	 * @param array $date
	 * @param string $time
	 *
	 * @return void
	 */
	private function time_sticker( array $date, string $time ): void {
		echo '<div class="event-repertoire-card__time-sticker">';

		echo '<div class="event-repertoire-card__time-sticker__date-wrapper">';
		echo "<span class=\"event-repertoire-card__time-sticker__date-wrapper__month\">{$date['month']}</span>";
		echo "<span class=\"event-repertoire-card__time-sticker__date-wrapper__day\">{$date['day']}</span>";
		echo "</div>";
		echo '<div class="event-repertoire-card__time-sticker__time-wrapper">';
		echo '<i class="far fa-clock"></i>';
		echo "<span>{$time}h</span>";
		echo "</div>";

		echo '</div>';
	}

	/**
	 * Returns HTML for name and location of a event.
	 *
	 * @param stdClass $event
	 *
	 * @return void
	 */
	private function event_name_and_location( stdClass $event ): void {
		echo '<div class="event-repertoire-card__name_location">';

		echo "<h3 class=\"event-repertoire-card__name_location__name\">$event->name</h3>";
		echo "<p class=\"event-repertoire-card__name_location__location\"><i class=\"fas fa-map-marker-alt\"></i> $event->location</p>";

		echo '</div>';
	}
}
