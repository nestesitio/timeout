<?php
/**
 * timeout functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package timeout
 */

if ( ! function_exists( 'timeout_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function timeout_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on timeout, use a find and replace
	 * to change 'timeout' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'timeout', get_template_directory() . '/languages' );

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
		'primary' => esc_html__( 'Primary', 'timeout' ),
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

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	/*add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );*/

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'timeout_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'timeout_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function timeout_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'timeout_content_width', 640 );
}
add_action( 'after_setup_theme', 'timeout_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function timeout_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'timeout' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'timeout' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'timeout_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function timeout_scripts() {
	wp_enqueue_style( 'timeout-style', get_stylesheet_uri(), NULL, filemtime( get_stylesheet_directory() . '/style.css' ) );

	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', '//code.jquery.com/jquery-1.12.3.min.js', array(), "1.12.3", true);

	wp_enqueue_script( 'timeout-vendor', get_template_directory_uri() . '/js/min/vendor-min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'timeout-main', get_template_directory_uri() . '/js/main.js?'.time(), array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js?'.time(), array('jquery'), '1.0.0', true );
	wp_enqueue_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js?'.time(), array('jquery'), '1.0.0', true );
	wp_enqueue_script('imagemap', get_template_directory_uri() . '/js/imageMapResizer.min.js?'.time(), array('jquery'), '1.0.0', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'timeout_scripts' );

/*
Disable Rich Edit In Some Custom Post Types
 */
add_filter('user_can_richedit', 'disable_wyswyg_for_custom_post_type');
function disable_wyswyg_for_custom_post_type( $default ){
  global $post;
  if( $post->post_type === 'academy') return false;
  return $default;
}

/*
Disable auto p
 */
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Custom template posts for this theme.
 */
require get_template_directory() . '/inc/template-posts.php';

/**
 * Custom template admin bar for this theme.
 */
require get_template_directory() . '/inc/template-admin-bar.php';


function get_the_popular_excerptmobile(){
$excerpt = get_the_content();
$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
$excerpt = strip_shortcodes($excerpt);
$excerpt = strip_tags($excerpt);
$excerpt = substr($excerpt, 0, 500);
$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
$excerpt = $excerpt.' [...]';
return $excerpt;
}

function get_the_popular_excerpt1024(){
$excerpt = get_the_content();
$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
$excerpt = strip_shortcodes($excerpt);
$excerpt = strip_tags($excerpt);
$excerpt = substr($excerpt, 0, 80);
$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
$excerpt = $excerpt.' [...]';
return $excerpt;
}
function get_the_popular_excerpt1280(){
$excerpt = get_the_content();
$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
$excerpt = strip_shortcodes($excerpt);
$excerpt = strip_tags($excerpt);
$excerpt = substr($excerpt, 0, 120);
$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
$excerpt = $excerpt.' [...]';
return $excerpt;
}
function get_the_popular_excerpt1366(){
$excerpt = get_the_content();
$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
$excerpt = strip_shortcodes($excerpt);
$excerpt = strip_tags($excerpt);
$excerpt = substr($excerpt, 0, 180);
$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
$excerpt = $excerpt.' [...]';
return $excerpt;
}
function get_the_popular_excerpt1600(){
$excerpt = get_the_content();
$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
$excerpt = strip_shortcodes($excerpt);
$excerpt = strip_tags($excerpt);
$excerpt = substr($excerpt, 0, 220);
$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
$excerpt = $excerpt.' [...]';
return $excerpt;
}
function get_the_popular_excerpt1920(){
$excerpt = get_the_content();
$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
$excerpt = strip_shortcodes($excerpt);
$excerpt = strip_tags($excerpt);
$excerpt = substr($excerpt, 0, 260);
$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
$excerpt = $excerpt.' [...]';
return $excerpt;
}


