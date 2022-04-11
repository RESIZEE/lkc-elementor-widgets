<?php

namespace Elementor;

use Lkc\Helpers\Program\Event;

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
		return 'eicon-calendar';
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
			echo "<a href=\"$event->permalink\" style=\"background: url('$event->img_url')\" class=\"event-repertoire-card event-border--{$event->program->slug}\">";
			$event->time_sticker();
			echo '<div class="event-repertoire-card__program-sticker">';
			$event->program->program_sticker();
			echo '</div>';
			$event->name_and_location();
			echo '</a>';
		endforeach;
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Returns array of four latest events.
	 *
	 * @return Event[]
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
			$events[] = new Event( $event_object );
		}

		return $events;
	}
}
