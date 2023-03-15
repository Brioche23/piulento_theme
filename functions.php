<?php

/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($composer_autoload)) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

//hook into the init action and call create_book_taxonomies when it fires

add_action('init', 'create_attivita_hierarchical_taxonomy', 0);
add_action('init', 'create_scala_hierarchical_taxonomy', 0);
add_action('init', 'create_progetto_hierarchical_taxonomy', 0);

//create a custom taxonomy name it subjects for your posts

function create_attivita_hierarchical_taxonomy()
{

	// Add new taxonomy, make it hierarchical like categories
	//first do the translations part for GUI

	$labels = array(
		'name' => _x('Attività', 'taxonomy general name'),
		'singular_name' => _x('Attività', 'taxonomy singular name'),
		'search_items' =>  __('Cerca Attività'),
		'all_items' => __('Tutte le attività'),
		'parent_item' => __('Parent'),
		'parent_item_colon' => __('Parent:'),
		'edit_item' => __('Edit Attività'),
		'update_item' => __('Aggiorna Attività'),
		'add_new_item' => __('Aggiungi Attività'),
		'new_item_name' => __('Nuovo Nome Attività'),
		'menu_name' => __('Attività'),
	);

	// Now register the taxonomy
	register_taxonomy('attivita', array('progetti'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_in_rest' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'attivita'),
	));
}

function create_scala_hierarchical_taxonomy()
{

	// Add new taxonomy, make it hierarchical like categories
	//first do the translations part for GUI

	$labels = array(
		'name' => _x('Scala', 'taxonomy general name'),
		'singular_name' => _x('Scala', 'taxonomy singular name'),
		'search_items' =>  __('Cerca Scala'),
		'all_items' => __('Tutte le Scala'),
		'parent_item' => __('Parent'),
		'parent_item_colon' => __('Parent:'),
		'edit_item' => __('Edit Scala'),
		'update_item' => __('Aggiorna Scala'),
		'add_new_item' => __('Aggiungi Scala'),
		'new_item_name' => __('Nuovo Nome Scala'),
		'menu_name' => __('Scala'),
	);

	// Now register the taxonomy
	register_taxonomy('scala', array('progetti'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_in_rest' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'scala'),
	));
}

function create_progetto_hierarchical_taxonomy()
{

	// Add new taxonomy, make it hierarchical like categories
	//first do the translations part for GUI

	$labels = array(
		'name' => _x('Incarico', 'taxonomy general name'),
		'singular_name' => _x('Incarico', 'taxonomy singular name'),
		'search_items' =>  __('Cerca Incarico'),
		'all_items' => __('Tutte gli incarichi'),
		'parent_item' => __('Parent'),
		'parent_item_colon' => __('Parent:'),
		'edit_item' => __('Edit Incarico'),
		'update_item' => __('Aggiorna Incarico'),
		'add_new_item' => __('Aggiungi Incarico'),
		'new_item_name' => __('Nuovo Nome Incarico'),
		'menu_name' => __('Incarico'),
	);

	// Now register the taxonomy
	register_taxonomy('tipo_progetto', array('progetti'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_in_rest' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'tipo_progetto'),
	));
}

// array of filters (field key => field name)
$GLOBALS['query_filters'] = array(
	1 => 'cat',
	2 => 'attivita',
	3 => 'tag',
	4 => 'scala',
	5 => 'anno',
	6 => 'tipo_progetto',
);

/**
 * Adding custom options pages for
 * Header
 * Footer
 * Alessandro
 * Diana
 */
if (function_exists('acf_add_options_page')) {

	acf_add_options_page();
	acf_add_options_sub_page('Generali');
	acf_add_options_sub_page('Header');
	acf_add_options_sub_page('Footer');
	acf_add_options_sub_page('Alessandro');
	acf_add_options_sub_page('Diana');
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if (!class_exists('Timber')) {

	add_action(
		'admin_notices',
		function () {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function ($template) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array('templates', 'views');

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site
{
	/** Add timber support. */
	public function __construct()
	{
		add_action('after_setup_theme', array($this, 'theme_supports'));
		add_filter('timber/context', array($this, 'add_to_context'));
		add_filter('timber/twig', array($this, 'add_to_twig'));
		add_action('init', array($this, 'register_post_types'));
		add_action('init', array($this, 'register_taxonomies'));
		parent::__construct();
	}
	/** This is where you can register custom post types. */
	public function register_post_types()
	{
		register_post_type(
			'Progetti',
			// CPT Options
			array(
				'labels' 			=> array(
					'name' 			=> __('Progetti'),
					'singular_name' => __('Progetto')
				),
				'public' 			=> true,
				'has_archive' 		=> true,
				'rewrite' 			=> array('slug' => 'progetti'),
				'show_in_rest' 		=> true,
				'taxonomies' 		=> array('category', 'post_tag'),
				'supports'          => array('title', 'excerpt', 'thumbnail', 'revisions', 'custom-fields',),

			)
		);
		register_post_type(
			'Libri',
			array(
				'labels' 			=> array(
					'name' 			=> __('Libri'),
					'singular_name' => __('Libro')
				),
				'public' 			=> true,
				'has_archive' 		=> true,
				'rewrite' 			=> array('slug' => 'libri'),
				'show_in_rest' 		=> true,
				'taxonomies' 		=> array(),
				'supports'          => array('title', 'excerpt', 'thumbnail', 'revisions', 'custom-fields',),

			)
		);
	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies()
	{
	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context($context)
	{
		$context['foo']   = 'fuffa';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';

		// Menus
		$context['menu'] = new \Timber\Menu('navbar');
		$context['footer'] = new \Timber\Menu('footer');

		// Options
		$context['options'] = get_fields('option');

		$context['site']  = $this;

		//For the logo
		$custom_logo_url = wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full');
		$context['custom_logo_url'] = $custom_logo_url;

		return $context;
	}

	public function theme_supports()
	{
		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		// Custom Logo
		add_theme_support('custom-logo');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support('menus');
	}

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo($text)
	{
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig($twig)
	{

		$twig->addFunction(new Timber\Twig_Function('add_script', function () {

			wp_register_script(
				'script',
				get_template_directory_uri() . '/static/site.js',
				[],
				'0.01'
			);
			wp_register_script('cookieyes', 'https://cdn-cookieyes.com/client_data/1add2a2058dd2af19cba2e6f/script.js', null, null, true);
			wp_register_script('lottie', 'https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js', null, null, true);
			wp_register_script('lazysizes', 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js', null, null, true);
			wp_register_script('swiper', 'https://unpkg.com/swiper@8/swiper-bundle.min.js', null, null, true);
			wp_register_script('alpine_plugin', 'https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js', null, null, true);
			wp_register_script('alpine', 'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js', null, null, true);
			// wp_register_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.2/gsap.min.js', null, null, true);
			// wp_register_script('barba', 'https://unpkg.com/@barba/core', null, null, true);
			wp_register_script('mixitup', get_template_directory_uri() . '/static/mixitup.min.js', null, null, true);


			wp_enqueue_script('script');
			wp_enqueue_script('cookieyes');
			wp_enqueue_script('lottie');
			wp_enqueue_script('lazysizes');
			wp_enqueue_script('swiper');
			wp_enqueue_script('alpine_plugin');
			wp_enqueue_script('alpine');
			// wp_enqueue_script('gsap');
			// wp_enqueue_script('barba');
			wp_enqueue_script('mixitup');
		}));

		$twig->addExtension(new Twig\Extension\StringLoaderExtension());
		// $twig->addFilter(new Twig\TwigFilter('myfoo', array($this, 'myfoo')));

		$twig->addFunction(new \Twig\TwigFunction('get_page_url', function ($query = [], $append = true) {
			$tmp = $append ? $_GET : [];
			foreach ($query as $key => $value) $tmp[$key] = $value;

			return '?' . http_build_query($tmp);
		}));

		return $twig;
	}
}
wp_enqueue_style('swiper_css', 'https://unpkg.com/swiper@8/swiper-bundle.min.css');
wp_enqueue_style('hamburgers', get_template_directory_uri() . '/static/src/hamburgers/dist/hamburgers.css');
new StarterSite();
