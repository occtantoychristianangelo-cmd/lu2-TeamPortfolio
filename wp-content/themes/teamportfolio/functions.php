<?php
/**
 * TeamPortfolio functions and definitions.
 */

function teamportfolio_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));

    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'teamportfolio'),
        )
    );
}
add_action('after_setup_theme', 'teamportfolio_setup');

function teamportfolio_enqueue_assets() {
    $theme_directory = get_template_directory();
    $style_version = file_exists($theme_directory . '/css/style.css') ? filemtime($theme_directory . '/css/style.css') : wp_get_theme()->get('Version');
    $home_version = file_exists($theme_directory . '/css/homesection.css') ? filemtime($theme_directory . '/css/homesection.css') : wp_get_theme()->get('Version');
    $motion_version = file_exists($theme_directory . '/js/motion.js') ? filemtime($theme_directory . '/js/motion.js') : wp_get_theme()->get('Version');

    wp_enqueue_style('teamportfolio-style', get_template_directory_uri() . '/css/style.css', array(), $style_version);
    wp_enqueue_style('teamportfolio-home', get_template_directory_uri() . '/css/homesection.css', array('teamportfolio-style'), $home_version);
    wp_enqueue_script('teamportfolio-motion', get_template_directory_uri() . '/js/motion.js', array(), $motion_version, true);
}
add_action('wp_enqueue_scripts', 'teamportfolio_enqueue_assets');

function teamportfolio_front_page_title($title) {
    if (is_front_page()) {
        return __('LU2 Portfolio | Team & Projects', 'teamportfolio');
    }

    return $title;
}
add_filter('pre_get_document_title', 'teamportfolio_front_page_title');

function teamportfolio_social_metadata() {
    if (!is_front_page()) {
        return;
    }

    $title = __('LU2 Portfolio | Team & Projects', 'teamportfolio');
    $description = __('Meet the LU2 team and explore BotiTea, a drinks-focused shop management system, and Resto Freeno restaurant operations.', 'teamportfolio');
    $url = home_url('/');
    $image = get_the_post_thumbnail_url(get_queried_object_id(), 'full');

    echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";

    if ($image) {
        echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
    }
}
add_action('wp_head', 'teamportfolio_social_metadata', 2);

function teamportfolio_primary_menu_fallback() {
    echo '<ul class="menu">';
    echo '<li><a href="' . esc_url(home_url('/#home')) . '">' . esc_html__('Home', 'teamportfolio') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/#projects')) . '">' . esc_html__('Projects', 'teamportfolio') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/#games')) . '">' . esc_html__('Games', 'teamportfolio') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/#team')) . '">' . esc_html__('Team', 'teamportfolio') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/#contact')) . '">' . esc_html__('Contact', 'teamportfolio') . '</a></li>';
    echo '</ul>';
}
