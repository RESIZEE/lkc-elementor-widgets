<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor News Ticker Widget
 *
 * Elementor widget that displays card-like teams read from teams custom
 * post type with number of cards defined by the user.
 *
 */
class News_Ticker_Widget extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve News ticker widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     */
    public function get_name(): string
    {
        return 'news-ticker';
    }

    /**
     * Get widget title.
     *
     * Retrieve News ticker widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     */
    public function get_title(): string
    {
        return esc_html__('News Ticker', 'lkc-elementor-widgets');
    }

    /**
     * Get widget icon.
     *
     * Retrieve News ticker widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     */
    public function get_icon(): string
    {
        return 'eicon-posts-ticker';
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
        return array('news', 'post', 'ticker');
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

        $this->add_control(
            'number_of_news',
            array(
                'label' => esc_html__('Number of news', 'lkc-elementor-widgets'),
                'type' => Controls_Manager::NUMBER,
                'placeholder' => esc_html__('#', 'lkc-elementor-widgets'),
                'default' => '10',
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
        $settings = $this->get_settings_for_display();

        echo '<div class="news-ticker-container">';

            echo '<div class="news-ticker__title">';
            echo '<h5>'.__('Новости', 'resize').'</h5>';
            echo '</div>';

            echo '<div class="news-ticker__wrap">';
                echo '<div class="news-ticker__ticker">';
                foreach ($this->get_news($settings['number_of_news']) as $news) {
                    $this->card_html(
                        $news['news_title'],
                        $news['news_permalink']
                    );
                }
                echo '</div>';
            echo '</div>';
        echo '</div>';

    }


	/**
	 * Echos HTML needed to create single card.
	 *
	 * @param string $news_title
	 * @param string $news_permalink
	 *
	 * @return void
	 */
    private function card_html(string $news_title, string $news_permalink)
    {
        echo ' <div class="news-ticker__item">';
        echo '<a href="'. $news_permalink .'">'. $news_title .' <span class="news-ticker__item-read-more">'.__('сазнај више...', 'resize').'</span></a>';
        echo '</div>';
    }

    /**
     * Returns array of News categories.
     *
     * @param int $number
     *
     * @return array
     */
    private function get_news(int $number = 0): array
    {
        $args = array(
            'post_type' => 'post',
            'numberposts' => $number,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $news = [];

        foreach (get_posts($args) as $post) {
            $news[] = [
                'news_title' => $post->post_title,
                'news_permalink' => get_permalink($post->ID)
            ];
        }

        return $news;

    }
}
