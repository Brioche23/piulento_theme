<?php

/**
 * Query 5 post in the Homepage
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
$context['tipo_progetto'] =   Timber::get_terms('tipo_progetto');


// Query funzionante
$args2 = array(
    'numberposts' => -1,
    'post_type' => 'progetti',
    // 'cat' => 1,
    // 'tag' => 'ambiente',
    // 'scala' => 'urbana',

);

$context['progetti'] = Timber::get_posts(['post_type' => 'progetti', 'posts_per_page' => -1]);

$context['foo']   = 'home.php';
$templates        = array('index.twig');
if (is_home()) {

    $context['progetti'] = Timber::get_posts($args2);
    array_unshift($templates, 'front-page.twig', 'page-home.twig', 'home.twig');
}

// var_dump($templates);
Timber::render($templates, $context);
