<?php
// Setup  -- Probably want to keep this stuff... 

/**
 * Hello and welcome to Base! First, lets load the PageLines core so we have access to the functions 
 */	
require_once( dirname(__FILE__) . '/setup.php' );
	
// For advanced customization tips & code see advanced file.
	//--> require_once(STYLESHEETPATH . "/advanced.php");
	
// ====================================================
// = YOUR FUNCTIONS - Where you should add your code  =
// ====================================================


// ABOUT HOOKS --------//
	// Hooks are a way to easily add custom functions and content to PageLines. There are hooks placed strategically throughout the theme 
	// so that you insert code and content with ease.


// ABOUT FILTERS ----------//

	// Filters allow data modification on-the-fly. Which means you can change something after it was read and compiled from the database,
	// but before it is shown to your visitor. Or, you can modify something a visitor sent to your database, before it is actually written there.

// FILTERS EXAMPLE ---------//

	// The following filter will add the font  Ubuntu into the font array $thefoundry.
	// This makes the font available to the framework and the user via the admin panel.

add_filter('pagelines_foundry', 'addMSFont');
add_filter('ploption_pagelines_custom_logo_url', 'customLogoUrl');
add_action('wp_enqueue_scripts', 'toukThemeEnqueue');

function addMSFont( $thefoundry ) {
	$myfont = array( 'MuseoSans' => array(
			'name' => 'MuseoSans',
			'family' => '"MuseoSans", arial, serif',
			'web_safe' => true,
			'google' => false,
			'monospace' => false
			)
		);
	return array_merge( $thefoundry, $myfont );
}

function customLogoUrl() {
    return "http://touk.pl/";
}

function toukThemeEnqueue() {
  $ss_url = get_stylesheet_directory_uri();
  wp_enqueue_script( 'touk-theme-scripts', "{$ss_url}/js/jquery.easing.1.3.js", array('jquery') );
}



//Remove description from title tag
function pagelines_filter_title( $title ) {
	global $wp_query, $s, $paged, $page;
	$sep = __( '|','pagelines' );
	$new_title = get_bloginfo( 'name' ) . ' ';
	$bloginfo_description = get_bloginfo( 'description' );
	if( is_feed() ) {
		$new_title = $title;
	} elseif ( ( is_home () || is_front_page() ) && ! empty( $bloginfo_description ) && ! $paged && ! $page ) {
//		$new_title .= $sep . ' ' . $bloginfo_description;
	} elseif ( is_category() ) {
		$new_title .= $sep . ' ' . single_cat_title( '', false );
	} elseif ( is_single() || is_page() ) {
		$new_title .= $sep . ' ' . single_post_title( '', false );
	} elseif ( is_search() ) {
		$new_title .= $sep . ' ' . sprintf( __( 'Search Results: %s','pagelines' ), esc_html( $s ) );
	} else
		$new_title .= $sep . ' ' . $title;
	if ( $paged || $page ) {
		$new_title .= ' ' . $sep . ' ' . sprintf( __( 'Page: %s', 'pagelines' ), max( $paged, $page ) );
	}
    return apply_filters( 'pagelines_meta_title', $new_title );
}
add_filter( 'wp_title', 'pagelines_filter_title' );



add_action('pagelines_head_last', 'add_description');
function add_description(){
	global $post;
	$descriptionContent = null;
	if (is_category() || is_tag()) {
		if (is_category()) {
			$descriptionContent = "Posts related to Category: " . ucfirst(single_cat_title("", FALSE));
		} elseif (is_tag()) {
			$descriptionContent = "Posts related to Tag: " . ucfirst(single_tag_title("", FALSE));
		}
	} elseif (have_posts()) {
		$meta = strip_tags($post->post_title) . " " . strip_tags($post->post_content);
		$meta = str_replace(array("\\n", "\\r", "\\t"), ' ', $meta);
		$meta = substr($meta, 0, 150);
		$descriptionContent = $meta;
	} else {
		$descriptionContent = get_bloginfo('description');
	}
	echo "<meta name='description' content='" . $descriptionContent . "'/>";
}