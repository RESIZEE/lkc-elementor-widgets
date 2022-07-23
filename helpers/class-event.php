<?php

namespace Lkc\Helpers\Program;

use WP_Post;

class Event {

	public string $img_url;
	public string $name;
	public string $permalink;
	public ?string $location;
	public string $excerpt;
	public string $day;
	private string $month;
	public string $year;
	public string $time;
	public Program $program;

	public function __construct( WP_Post $event_object ) {
		$event_terms = get_the_terms( $event_object, 'program' );
		// Getting random index of an term so we can display different one each time.
		$random_terms_index = is_array( $event_terms ) ? rand( 0, count( $event_terms ) - 1 ) : 0;
		$program_name       = $event_terms ? $event_terms[ $random_terms_index ]->name : __('Некатегоризовано', 'lkc-elementor-widgets');
		$program_slug       = $event_terms ? $event_terms[ $random_terms_index ]->slug : 'none';
		$this->program      = new Program( $program_name, $program_slug );

		$location_field_object = get_field_object( 'location', $event_object->ID ) ?: [];
		$location_field_key    = array_key_exists( 'value', $location_field_object ) ? $location_field_object['value'] : '';
		$location              = array_key_exists( 'choices', $location_field_object ) ? $location_field_object['choices'][ $location_field_key ] : '';

		$this->img_url   = get_the_post_thumbnail_url( $event_object ) ?: plugins_url( '/assets/img/placeholder.png', LKC_PLUGIN_FILE );
		$this->name      = $event_object->post_title;
		$this->permalink = get_permalink( $event_object );
		$this->location  = $location;
		$this->excerpt   = $event_object->post_excerpt ?: wp_trim_words( $event_object->post_content, 25 );

		$date_object = $event_object->date_of_event ? new \DateTime( $event_object->date_of_event ) : '';
		$this->day   = $date_object ? $date_object->format( 'd' ) : '';
		$this->month = $date_object ? $date_object->format( 'm' ) : '';
		$this->year  = $date_object ? $date_object->format( 'Y' ) : '';

		$time_object = $event_object->time_of_event ? new \DateTime( $event_object->time_of_event ) : '';
		$this->time  = $time_object ? $time_object->format( 'H.i' ) : '';
	}

	/**
	 * Getter method for month property
	 *
	 * @return string
	 */
	public function get_month_number(): string {
		return $this->month;
	}

	/**
	 * Getter method for month short name of month property.
	 *
	 * @return string
	 */
	public function get_month_short_name(): string {
		return $this->get_month_name( $this->month, true );
	}

	/**
	 * Getter method for month long name of month property.
	 *
	 * @return string
	 */
	public function get_month_long_name(): string {
		return $this->get_month_name( $this->month, false );
	}

	private function get_month_name( string $month_number, bool $short ): string {
		$monthIndex = (int) $month_number;

		return $short ?
			array(
				1  => __( 'Јан', 'lkc-elementor-widgets' ),
				2  => __( 'Феб', 'lkc-elementor-widgets' ),
				3  => __( 'Мар', 'lkc-elementor-widgets' ),
				4  => __( 'Апр', 'lkc-elementor-widgets' ),
				5  => __( 'Мај', 'lkc-elementor-widgets' ),
				6  => __( 'Јун', 'lkc-elementor-widgets' ),
				7  => __( 'Јул', 'lkc-elementor-widgets' ),
				8  => __( 'Авг', 'lkc-elementor-widgets' ),
				9  => __( 'Сеп', 'lkc-elementor-widgets' ),
				10 => __( 'Окт', 'lkc-elementor-widgets' ),
				11 => __( 'Нов', 'lkc-elementor-widgets' ),
				12 => __( 'Дец', 'lkc-elementor-widgets' ),
			)[ $monthIndex ]
			:
			array(
				1  => __( 'Јануар', 'lkc-elementor-widgets' ),
				2  => __( 'Фебруар', 'lkc-elementor-widgets' ),
				3  => __( 'Март', 'lkc-elementor-widgets' ),
				4  => __( 'Април', 'lkc-elementor-widgets' ),
				5  => __( 'Мај', 'lkc-elementor-widgets' ),
				6  => __( 'Јун', 'lkc-elementor-widgets' ),
				7  => __( 'Јул', 'lkc-elementor-widgets' ),
				8  => __( 'Август', 'lkc-elementor-widgets' ),
				9  => __( 'Септембар', 'lkc-elementor-widgets' ),
				10 => __( 'Октобар', 'lkc-elementor-widgets' ),
				11 => __( 'Новембар', 'lkc-elementor-widgets' ),
				12 => __( 'Децембар', 'lkc-elementor-widgets' ),
			)[ $monthIndex ];
	}

	/**
	 * Returns HTML for time sticker.
	 *
	 * @return void
	 */
	public function time_sticker(): void {
		echo '<div class="time-sticker">';

		echo '<div class="time-sticker__date-wrapper">';
		echo "<span class=\"time-sticker__date-wrapper__month\">{$this->get_month_short_name()}</span>";
		echo "<span class=\"time-sticker__date-wrapper__day\">$this->day</span>";
		echo "</div>";
		echo '<div class="time-sticker__time-wrapper">';
		echo '<i class="far fa-clock"></i>';
		echo "<span>{$this->time}h</span>";
		echo "</div>";

		echo '</div>';
	}

	/**
	 * Returns HTML for name and location of a event.
	 *
	 * @return void
	 */
	public function name_and_location(): void {
		echo '<div class="name-location">';

		echo "<p class=\"name-location__name\">$this->name</p>";
		echo "<p class=\"name-location__location\"><i class=\"fas fa-map-marker-alt\"></i> $this->location</p>";

		echo '</div>';
	}
}