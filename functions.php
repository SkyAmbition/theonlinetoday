<?php

/**
 * TOD functions and definitions
 *
 * @package Tod
 * @since Tod 1.0
 */
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Tod 1.0
 */
if (!isset($content_width))
    $content_width = 654; /* pixels */


if (!function_exists('tod_setup')):

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     *
     * @since Tod 1.0
     */
    function tod_setup() {

        /**
         * Custom template tags for this theme.
         */
        require( get_template_directory() . '/inc/template-tags.php' );

        /**
         * Custom functions that act independently of the theme templates
         */
        require( get_template_directory() . '/inc/tweaks.php' );

        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         * If you're building a theme based on Tod, use a find and replace
         * to change 'tod' to the name of your theme in all the template files
         */
        load_theme_textdomain('tod', get_template_directory() . '/languages');

        /**
         * Add default posts and comments RSS feed links to head
         */
        add_theme_support('automatic-feed-links');

        /**
         * Enable support for the Aside Post Format
         */
        add_theme_support('post-formats', array('aside'));

        /**
         * This theme uses wp_nav_menu() in one location.
         */
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'tod'),
        ));
    }

endif; // tod_setup
add_action('after_setup_theme', 'tod_setup');

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Tod 1.0
 */
function tod_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Primary Widget Area', 'tod' ),
        'id' => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',
    ) );
 
    register_sidebar( array(
        'name' => __( 'Secondary Widget Area', 'tod' ),
        'id' => 'sidebar-2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',
    ) );
}
add_action( 'widgets_init', 'tod_widgets_init' );

define('tml_url', get_template_directory_uri());

/**
 * Enqueue scripts and styles
 */
function tod_scripts() {
    wp_enqueue_style('style', get_stylesheet_uri());

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    //wp_enqueue_script( 'navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
    wp_enqueue_script('jquery', get_template_directory_uri() . '/scripts/jquery-1.11.3.min.js', '', '113', true);
    if (is_singular() && wp_attachment_is_image()) {
        wp_enqueue_script('keyboard-image-navigation', get_template_directory_uri() . '/scripts/keyboard-image-navigation.js', array('jquery'), '20120202');
    }
    wp_enqueue_script('main_script', get_template_directory_uri() . '/scripts/main.min.js', array('jquery'), '42.0', true);
}

add_action('wp_enqueue_scripts', 'tod_scripts');


if (!function_exists('tod_posted_on')) :

    /**
     * Prints HTML with meta information for the current post-date/time and author.
     *
     * @since Tod 1.0
     */
    function tod_posted_on() {
        printf(__('Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'tod'), esc_url(get_permalink()), esc_attr(get_the_time()), esc_attr(get_the_date('c')), esc_html(get_the_date()), esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_attr(sprintf(__('View all posts by %s', 'tod'), get_the_author())), esc_html(get_the_author())
        );
    }

endif;

/**
 * Returns true if a blog has more than 1 category
 *
 * @since Tod 1.0
 */
function tod_categorized_blog() {
    if (false === ( $all_the_cool_cats = get_transient('all_the_cool_cats') )) {
        // Create an array of all the categories that are attached to posts
        $all_the_cool_cats = get_categories(array(
            'hide_empty' => 1,
                ));

        // Count the number of categories that are attached to the posts
        $all_the_cool_cats = count($all_the_cool_cats);

        set_transient('all_the_cool_cats', $all_the_cool_cats);
    }

    if ('1' != $all_the_cool_cats) {
        // This blog has more than 1 category so tod_categorized_blog should return true
        return true;
    } else {
        // This blog has only 1 category so tod_categorized_blog should return false
        return false;
    }
}

/**
 * Flush out the transients used in tod_categorized_blog
 *
 * @since tod 1.0
 */
function tod_category_transient_flusher() {
    // Like, beat it. Dig?
    delete_transient('all_the_cool_cats');
}

add_action('edit_category', 'tod_category_transient_flusher');
add_action('save_post', 'tod_category_transient_flusher');
