<?php
/**
* Template Name: Landing Full Blank
* Description: Template for a custom landing page page that is full width and blank with default elements.
*/

// this removes the site header
remove_action( 'genesis_header', 'genesis_do_header' );

// This removes the site navigation
remove_theme_support( 'genesis-menus' );

// This removes breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// This removes the primary sidebar
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

// This removes my custom Top Wrap sidebar


// Removes the site footer
remove_action( 'genesis_after_header', 'cg_top_wrap_widgets' );

// This removes the site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

genesis();

