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
    wp_enqueue_style('teamportfolio-style', get_template_directory_uri() . '/css/style.css', array(), wp_get_theme()->get('Version'));
    wp_enqueue_style('teamportfolio-home', get_template_directory_uri() . '/css/homesection.css', array('teamportfolio-style'), wp_get_theme()->get('Version'));
    wp_enqueue_script('teamportfolio-motion', get_template_directory_uri() . '/js/motion.js', array(), wp_get_theme()->get('Version'), true);
}
add_action('wp_enqueue_scripts', 'teamportfolio_enqueue_assets');

function teamportfolio_primary_menu_fallback() {
    echo '<ul class="menu">';
    echo '<li><a href="' . esc_url(home_url('/#home')) . '">' . esc_html__('Home', 'teamportfolio') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/#projects')) . '">' . esc_html__('Projects', 'teamportfolio') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/#team')) . '">' . esc_html__('Team', 'teamportfolio') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/#contact')) . '">' . esc_html__('Contact', 'teamportfolio') . '</a></li>';
    echo '</ul>';
}
