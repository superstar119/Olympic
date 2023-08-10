<?php
/**
 * Theme functions and definitions
 *
 * @package ThriveThemeChild
 */

 /**
  * Load child theme css and optional scripts
  *
  * @return void
  */

require_once('templates/shortcode/feed-archieve.php');

function thrive_theme_child_enqueue_scripts() {
	wp_enqueue_style( 'olympic-child-style', get_stylesheet_directory_uri() . '/assets/css/style.css', null, '1.0.0' );

	wp_enqueue_script( 'olympic-child-script', get_stylesheet_directory_uri() . '/assets/js/main.js', null, '1.0.0' );
}

add_action( 'wp_enqueue_scripts', 'thrive_theme_child_enqueue_scripts', 10 );
