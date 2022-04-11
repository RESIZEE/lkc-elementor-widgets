<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor News Widget
 *
 * Elementor widget that displays card-like teams read from teams custom
 * post type with number of cards defined by the user.
 *
 */
class News_Widget extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve News widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     */
    public function get_name(): string
    {
        return 'news';
    }

    /**
     * Get widget title.
     *
     * Retrieve News widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     */
    public function get_title(): string
    {
        return esc_html__('News', 'lkc-elementor-widgets');
    }

    /**
     * Get widget icon.
     *
     * Retrieve News widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     */
    public function get_icon(): string
    {
        return 'eicon-single-post';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the News widget belongs to.
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
     * Retrieve the list of keywords the News widget belongs to.
     *
     * @return array Widget keywords.
     * @since 1.0.0
     * @access public
     */
    public function get_keywords(): array
    {
        return array('news', 'post', 'review');
    }

    /**
     * Register News widget controls.
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

        $this->end_controls_section();

        $this->start_controls_section(
            'news-image',
            array(
                'label' => esc_html__('Images', 'lkc-elementor-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'news-image-dimensions',
            [
                'label' => esc_html__('Image Height', 'lkc-elementor-widgets'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 200,
                ],
                'selectors' => [
                    '{{WRAPPER}} .news-widget__image' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ],
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'news-title',
            array(
                'label' => esc_html__('Title', 'lkc-elementor-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'news-title',
                'selector' => '{{WRAPPER}} .news-widget__title',
            ]
        );

        $this->add_control(
            'news-image_color',
            array(
                'label' => esc_html__('Color', 'lkc-elementor-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .news-widget__title' => 'color: {{VALUE}}',
                ],
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'news-excerpt',
            array(
                'label' => esc_html__('Excerpt', 'lkc-elementor-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'news-excerpt',
                'selector' => '{{WRAPPER}} .news-widget__excerpt',
            ]
        );

        $this->add_control(
            'news-excerpt_color',
            array(
                'label' => esc_html__('Color', 'lkc-elementor-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .news-excerpt' => 'color: {{VALUE}}',
                ],
            )
        );
        $this->end_controls_section();
    }

    /**
     * Render News widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        echo '<div class="news-widget">';
        echo '<div class="news-widget-container">';

        foreach ($this->get_news() as $new) {
            $this->card_html(
                $new['photo'],
                $new['news_excerpt'],
                $new['news_title'],
                $new['news_permalink']
            );
        }

        echo '</div>';
        echo '<div class="news-widget__arrows"><div class="news-widget__count"><span class="current"></span> / <span class="total"></span></div></div>';
        echo '</div>';

    }


    /**
     * Echos HTML needed to create single card.
     *
     * @param $photo
     * @param $news_excerpt
     * @param $news_title
     * @param $news_permalink
     *
     * @return void
     */
    private function card_html($photo, $news_excerpt, $news_title, $news_permalink)
    {
        echo '<div class="news-widget-card">';
        echo '<a href="' . $news_permalink . '"><img src="' . $photo . '" class="news-widget__image"></a>';
        echo '<p class="news-widget__title">' . $news_title . '</p>';
        echo '<div class="news-widget-description-container">';
        echo '<p class="news-widget__excerpt">' . wp_trim_words($news_excerpt, 20) . '</p>';
        echo '<a href="' . $news_permalink . '" class="news-widget__read_more">PROČITAJ VIŠE <i class="fa-solid fa-arrow-right-long"></i></a>';
        echo '</div>';
        echo '</div>';
    }

    /**
     * Returns array of News categories.
     *
     * @param int $number
     *
     * @return array
     */
    private function get_news(): array
    {
        $args = array(
            'post_type' => 'post',
            'numberposts' => 12,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $news = [];

        foreach (get_posts($args) as $post) {
            $news[] = [
                'photo' => wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), 'medium'),
                'news_title' => $post->post_title,
                'news_excerpt' => $post->post_content,
                'news_permalink' => get_permalink($post->ID)
            ];
        }

        return $news;

    }

}
