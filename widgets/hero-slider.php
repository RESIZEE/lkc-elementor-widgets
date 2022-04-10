<?php

namespace Elementor;

use Lkc\Helpers\Program\Program;
use stdClass;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor Hero Slider Widget
 *
 * Elementor widget that displays four last events in form of a card.
 *
 */
class Hero_Slider_Widget extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve Hero Slider widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     */
    public function get_name(): string
    {
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
    public function get_title(): string
    {
        return esc_html__('Hero Slider', 'lkc-elementor-widgets');
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
    public function get_icon(): string
    {
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
    public function get_categories(): array
    {
        return array('lkc');
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
    public function get_keywords(): array
    {
        return array('event', 'events', 'slider');
    }

    /**
     * Register Hero Slider widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            array(
                'label' => esc_html__('Content', 'lkc-elementor-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'number_of_slides',
            array(
                'label' => esc_html__('Number of slides', 'lkc-elementor-widgets'),
                'type' => Controls_Manager::NUMBER,
                'placeholder' => esc_html__('#', 'lkc-elementor-widgets'),
                'default' => '10',
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
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $events = $this->get_latest_events($settings['number_of_slides']);

        echo '<div class="hero-slider-container">';
        foreach ($events as $event) {
            $this->card_html(
                $event->name,
                $event->permalink,
                $event->img_url,
                $event->location,
                $event->time,
                $event->date,
                $event->program,
                $event->excerpt,
            );
        }
        echo '</div>';
    }

    /**
     * @param $name
     * @param $permalink
     * @param $image
     * @param $location
     * @param $time
     * @param $date
     * @param $program
     * @param $excerpt
     *
     * @return void
     */
    private function card_html($name, $permalink, $image, $location, $time, $date, $program, $excerpt): void
    {
        echo ' <div class="hero-slider-wrapper">';
            echo '<div class="hero-slider-image">';
                echo '<a href="' . $permalink . '" target="_blank" class="hero-slider-link">';
                    echo '<img src="' . $image . '">';
                echo '</a>';
            echo '</div>';

            echo '<div class="hero-slider-info">';
                echo '<a href="' . $permalink . '" target="_blank" class="hero-slider-link">';
                    echo '<h2>' . $name . '</h2>';
                        echo '<div class="hero-slider-info__program" style="width: 200px">';
                            echo $program->program_sticker();
                        echo '</div>';
                    echo '<p class="hero-slider-info__location"><i class="fas fa-map-marker-alt"></i> ' . $location . '</p>';
                    echo '<p class="hero-slider-info__excerpt">'. $excerpt .'</p>';
                    echo '<p class="hero-slider-info__date-time">'.$date->format('d. F Y.').' u '. $time->format('H.i').'h</p>';
                echo '</a>';
            echo '</div>';
        echo '</div>';
    }

    /**
     * Returns array of four latest events.
     * @param int $number_of_slides
     * @return array
     */
    private function get_latest_events(int $number_of_slides): array
    {
        $events = [];
        $args = array(
            'post_type' => 'event',
            'post_status' => 'publish',
            'order' => 'DESC',
            'orderby' => 'publish_date',
            'posts_per_page' => $number_of_slides,
        );

        $event_objects = get_posts($args);
        foreach ($event_objects as $event_object) {
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
            $event->excerpt = $event_object->post_excerpt ?: wp_trim_words($event_object->post_content, 25);

            $event->location = $location;
            $event->date = new \DateTime($event_object->date_of_event);

            $event->time = new \DateTime($event_object->time_of_event);



            $events[] = $event;
        }

        return $events;
    }


    /**
     * Returns HTML for program sticker.
     *
     * @param stdClass $program
     *
     * @return void
     */
    private function program_sticker(stdClass $program): void
    {
        $program_icon_class = $this->program_icon_class($program->slug);

        echo "<div class=\"hero-slider-info__program-sticker event-repertoire-card__program-sticker--$program->slug\">";
        echo '<i class="fas fa-chevron-right"></i>';
        echo "<span class=\"hero-slider-info__program-sticker__title\">$program->name</span>";
        echo "<i class=\"fas $program_icon_class\"></i>";
        echo '</div>';
    }

    /**
     * Returns class needed for specific program.
     *
     * @param string $program_slug
     *
     * @return string
     */
    private function program_icon_class(string $program_slug): string
    {
        return match ($program_slug) {
            'dramski-program' => 'fa-theater-masks',
            'deciji-program' => 'fa-child',
            'muzicki-program' => 'fa-music',
            'knjizevni-program' => 'fa-book-open',
            default => 'fa-question'
        };
    }
}
