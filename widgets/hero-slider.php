<?php

namespace Elementor;

use Lkc\Helpers\Program\Event;
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
        echo '<div class="hero-slider-controls">';
        echo '</div>';
        echo '<div class="hero-slider-container">';
        foreach ($events as $event) {
            $this->card_html($event);
        }
        echo '</div>';
    }

    /**
     * @param $event
     *
     * @return void
     */
    private function card_html($event): void
    {
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

    /**
     * @param int $number_of_slides
     *
     * @return array
     * @throws \Exception
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
            $events[] = new Event($event_object);
        }

        return $events;
    }
}
