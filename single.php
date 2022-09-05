<?php

/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context         = Timber::context();
$timber_post     = Timber::get_post();
// $cat     = Timber::get_terms();
$context['post'] = $timber_post;

// $cat = $timber_post->category_name;
if ($timber_post->post_type == 'progetti') {
	$categories = $timber_post->terms('category');
	$first_cat = reset($categories);
	$cat = $first_cat->id;
	// var_dump($timber_post->ID);
	$args2 = array(
		'numberposts' => 3,
		'post_type' => 'progetti',
		'cat' => $cat,
		'post__not_in' => array($timber_post->ID),
		// 'tag' => 'ambiente',
		// 'scala' => 'urbana',
	);
	$args3 = array(
		'numberposts' => 3,
		'post_type' => 'progetti',
		'post__not_in' => array($timber_post->ID),

	);

	$context['progetti_single'] = Timber::get_posts($args2);
	$context['last_3'] = Timber::get_posts($args3);
}


if (post_password_required($timber_post->ID)) {
	Timber::render('single-password.twig', $context);
} else {
	Timber::render(array('single-' . $timber_post->post_type . '.twig', 'single-' . $timber_post->slug . '.twig', 'single.twig'), $context);
}
