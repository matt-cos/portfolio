<?php
/**
 * Matt Portfolio functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Matt_Portfolio
 */

if ( ! function_exists( 'matt_portfolio_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function matt_portfolio_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Matt Portfolio, use a find and replace
		 * to change 'matt_portfolio' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'matt_portfolio', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'matt_portfolio' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'matt_portfolio_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'matt_portfolio_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function matt_portfolio_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'matt_portfolio_content_width', 640 );
}
add_action( 'after_setup_theme', 'matt_portfolio_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function matt_portfolio_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'matt_portfolio' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'matt_portfolio' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'matt_portfolio_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function matt_portfolio_scripts() {
	// wp_enqueue_style( 'matt_portfolio-style', get_stylesheet_uri() );
	wp_enqueue_style( 'matt_portfolio-style', get_template_directory_uri() . '/dist/css/style.min.css', array(), '87687687686');
	wp_enqueue_style( 'fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:300|Playfair+Display:700' );

	// wp_enqueue_script( 'matt_portfolio-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '87687687686', true );
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'matt_portfolio-navigation', get_template_directory_uri() . '/dist/js/scripts.min.js', array('jquery'), '87687687686', true );

	wp_enqueue_script( 'matt_portfolio-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '87687687686', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'matt_portfolio_scripts' );

// Register Custom Post Type Portfolio Item
// Post Type Key: portfolioitem
function create_portfolioitem_cpt() {

	$labels = array(
		'name' => __( 'Portfolio Items', 'Post Type General Name', 'textdomain' ),
		'singular_name' => __( 'Portfolio Item', 'Post Type Singular Name', 'textdomain' ),
		'menu_name' => __( 'Portfolio Items', 'textdomain' ),
		'name_admin_bar' => __( 'Portfolio Item', 'textdomain' ),
		'archives' => __( 'Portfolio Item Archives', 'textdomain' ),
		'attributes' => __( 'Portfolio Item Attributes', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Portfolio Item:', 'textdomain' ),
		'all_items' => __( 'All Portfolio Items', 'textdomain' ),
		'add_new_item' => __( 'Add New Portfolio Item', 'textdomain' ),
		'add_new' => __( 'Add New', 'textdomain' ),
		'new_item' => __( 'New Portfolio Item', 'textdomain' ),
		'edit_item' => __( 'Edit Portfolio Item', 'textdomain' ),
		'update_item' => __( 'Update Portfolio Item', 'textdomain' ),
		'view_item' => __( 'View Portfolio Item', 'textdomain' ),
		'view_items' => __( 'View Portfolio Items', 'textdomain' ),
		'search_items' => __( 'Search Portfolio Item', 'textdomain' ),
		'not_found' => __( 'Not found', 'textdomain' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
		'featured_image' => __( 'Featured Image', 'textdomain' ),
		'set_featured_image' => __( 'Set featured image', 'textdomain' ),
		'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
		'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
		'insert_into_item' => __( 'Insert into Portfolio Item', 'textdomain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Portfolio Item', 'textdomain' ),
		'items_list' => __( 'Portfolio Items list', 'textdomain' ),
		'items_list_navigation' => __( 'Portfolio Items list navigation', 'textdomain' ),
		'filter_items_list' => __( 'Filter Portfolio Items list', 'textdomain' ),
	);
	$args = array(
		'label' => __( 'Portfolio Item', 'textdomain' ),
		'description' => __( '', 'textdomain' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-book-alt',
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'custom-fields', ),
		'taxonomies' => array('Expertise', ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => false,
		'hierarchical' => true,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'page',
	);
	register_post_type( 'portfolio', $args );

}
add_action( 'init', 'create_portfolioitem_cpt', 0 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

