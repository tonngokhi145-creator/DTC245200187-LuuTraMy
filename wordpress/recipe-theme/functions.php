<?php

function recipe_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form'));
}

add_action('after_setup_theme', 'recipe_theme_setup');

function recipe_load_styles() {
    wp_enqueue_style(
        'recipe-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );
}

add_action('wp_enqueue_scripts', 'recipe_load_styles');
