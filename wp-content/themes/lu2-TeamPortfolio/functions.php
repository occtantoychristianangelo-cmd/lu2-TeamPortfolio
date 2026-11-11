
<?php

function myportfolio_theme_styles() {
    wp_enqueue_style(
        'myportfolio-style',
        get_stylesheet_uri(),
        array(),
        '1.0.0'
    );
}

add_action('wp_enqueue_scripts', 'myportfolio_theme_styles');
