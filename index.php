<?php

/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$context          = Timber::context();
$context['posts'] = new Timber\PostQuery();
$context['categories'] =  Timber::get_terms('categories');
$context['tags'] =  Timber::get_terms('tags');
$context['attivita'] =   Timber::get_terms('attivita');
$context['scala'] =   Timber::get_terms('scala');

//	Query funzionante
$args2 = array(
	'numberposts' => 5,
	'post_type' => 'progetti',
	// 'cat' => 1,
	// 'tag' => 'ambiente',
	// 'scala' => 'urbana',

);

$context['progetti'] = Timber::get_posts(['post_type' => 'progetti', 'posts_per_page' => -1]);
$context['libri'] = Timber::get_posts(['post_type' => 'libri', 'posts_per_page' => -1]);

$context['foo']   = 'miao';
$templates        = array('index.twig');
if (is_home()) {
	array_unshift($templates, 'front-page.twig', 'home.twig');
}
Timber::render($templates, $context);
