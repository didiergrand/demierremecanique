<?php
/**
 * Demierre Entretien et Mécanique functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Demierre_mecanique
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function demierre_mecanique_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Demierre Entretien et Mécanique, use a find and replace
		* to change 'demierre-mecanique' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'demierre-mecanique', get_template_directory() . '/languages' );

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


	//* Add support for custom header
	add_theme_support( 'custom-header', array(
		'header-text' => false,
		'height' => 800,
		'width' => 1400,
	) );



	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'demierre-mecanique' ),
		)
	);






	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'demierre_mecanique_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'demierre_mecanique_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function demierre_mecanique_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'demierre_mecanique_content_width', 640 );
}
add_action( 'after_setup_theme', 'demierre_mecanique_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function demierre_mecanique_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar', 'demierre-mecanique' ),
		'id'            => 'sidebar-footer',
		'description'   => esc_html__( 'Add widgets here.', 'demierre-mecanique' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar 2', 'demierre-mecanique' ),
		'id'            => 'sidebar-footer-secondary',
		'description'   => esc_html__( 'Add widgets here.', 'demierre-mecanique' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Right sidebar', 'demierre-mecanique' ),
		'id'            => 'sidebar-right',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'demierre_mecanique_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function demierre_mecanique_scripts() {
	wp_enqueue_style( 'demierre-mecanique-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'demierre-mecanique-style', 'rtl', 'replace' );

	wp_enqueue_script( 'demierre-mecanique-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'demierre-mecanique-header-carousel', get_template_directory_uri() . '/js/header-carousel.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'demierre_mecanique_scripts' );

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

/**
 * Limit posts on homepage to 3.
 */
function demierre_mecanique_limit_homepage_posts( $query ) {
	if ( ! is_admin() && $query->is_main_query() ) {
		if ( is_home() || is_front_page() ) {
			$query->set( 'posts_per_page', 3 );
		}
	}
}
add_action( 'pre_get_posts', 'demierre_mecanique_limit_homepage_posts' );

/**
 * Custom Post Type: Produits + Taxonomie catégorie (URL: /produits/{categorie}/{slug}).
 */
function demierre_mecanique_register_produits() {
	$labels = array(
		'name'                  => __( 'Produits', 'demierre-mecanique' ),
		'singular_name'         => __( 'Produit', 'demierre-mecanique' ),
		'menu_name'             => __( 'Produits', 'demierre-mecanique' ),
		'name_admin_bar'        => __( 'Produit', 'demierre-mecanique' ),
		'add_new'               => __( 'Ajouter un produit', 'demierre-mecanique' ),
		'add_new_item'         => __( 'Ajouter un nouveau produit', 'demierre-mecanique' ),
		'new_item'              => __( 'Nouveau produit', 'demierre-mecanique' ),
		'edit_item'            => __( 'Modifier le produit', 'demierre-mecanique' ),
		'view_item'            => __( 'Voir le produit', 'demierre-mecanique' ),
		'all_items'            => __( 'Tous les produits', 'demierre-mecanique' ),
		'search_items'        => __( 'Rechercher parmi les produits', 'demierre-mecanique' ),
		'not_found'            => __( 'Aucun produit trouvé.', 'demierre-mecanique' ),
		'not_found_in_trash'  => __( 'Aucun produit trouvé dans la corbeille.', 'demierre-mecanique' ),
	);

	// CPT.
	register_post_type(
		'produits',
		array(
			'labels'             => $labels,
			'public'             => true,
			'show_in_rest'       => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-cart',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'has_archive'        => true,
			'rewrite'            => array(
				// IMPORTANT: keep this slug different from the taxonomy base (/produits/{categorie}/)
				// to avoid conflicts on term archives.
				'slug'       => 'produits-item',
				'with_front' => false,
			),
		)
	);

	// Taxonomie catégorie (termes affichés en /produits/{terme}/).
	register_taxonomy(
		'categorie-produit',
		'produits',
		array(
			'labels'            => array(
				'name'          => __( 'Catégories produits', 'demierre-mecanique' ),
				'singular_name' => __( 'Catégorie produit', 'demierre-mecanique' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_in_rest'      => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'rewrite'           => array(
				'slug'       => 'produits',
				'with_front' => false,
			),
		)
	);
}
add_action( 'init', 'demierre_mecanique_register_produits' );

/**
 * Permalink single produits: /produits/{categorie}/{post_slug}/
 */
function demierre_mecanique_produits_post_type_link( $permalink, $post ) {
	if ( ! $post || $post->post_type !== 'produits' ) {
		return $permalink;
	}

	$terms = wp_get_post_terms(
		$post->ID,
		'categorie-produit',
		array(
			'orderby' => 'term_order',
			'order'   => 'ASC',
			'number'  => 1,
			'fields'  => 'slugs',
		)
	);

	if ( empty( $terms ) ) {
		return $permalink;
	}

	$categorie_slug = $terms[0];
	return home_url( user_trailingslashit( 'produits/' . $categorie_slug . '/' . $post->post_name ) );
}
add_filter( 'post_type_link', 'demierre_mecanique_produits_post_type_link', 10, 2 );

/**
 * Rewrite: /produits/{categorie_slug}/{post_slug}
 */
function demierre_mecanique_produits_add_rewrite_rules() {
	add_rewrite_rule(
		'^produits/([^/]+)/([^/]+)/?$',
		'index.php?post_type=produits&produits_cat_slug=$matches[1]&categorie-produit=$matches[1]&name=$matches[2]',
		'top'
	);
}
add_action( 'init', 'demierre_mecanique_produits_add_rewrite_rules' );

function demierre_mecanique_produits_query_vars( $vars ) {
	$vars[] = 'produits_cat_slug';
	return $vars;
}
add_filter( 'query_vars', 'demierre_mecanique_produits_query_vars' );

/**
 * Applique la taxonomie sur la requête quand l'URL contient /produits/{categorie}/{slug}.
 */
function demierre_mecanique_produits_pre_get_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	$post_type = $query->get( 'post_type' );
	if ( empty( $post_type ) ) {
		return;
	}

	if ( is_array( $post_type ) ) {
		if ( ! in_array( 'produits', $post_type, true ) ) {
			return;
		}
	} elseif ( $post_type !== 'produits' ) {
		return;
	}

	$cat_slug = get_query_var( 'produits_cat_slug' );
	if ( empty( $cat_slug ) ) {
		return;
	}

	$query->set(
		'tax_query',
		array(
			array(
				'taxonomy' => 'categorie-produit',
				'field'    => 'slug',
				'terms'    => array( $cat_slug ),
			),
		)
	);
}
add_action( 'pre_get_posts', 'demierre_mecanique_produits_pre_get_posts' );

/**
 * Flush des rewrites une seule fois.
 * Astuce: si tu modifies les slugs, re-sauvegarder Permaliens dans WP.
 */
function demierre_mecanique_produits_maybe_flush_rewrites() {
	$rewrite_version = '3';
	$saved_version   = get_option( 'demierre_mecanique_produits_rewrite_version' );

	if ( $saved_version !== $rewrite_version ) {
		flush_rewrite_rules();
		update_option( 'demierre_mecanique_produits_rewrite_version', $rewrite_version );
	}
}
add_action( 'init', 'demierre_mecanique_produits_maybe_flush_rewrites', 20 );
