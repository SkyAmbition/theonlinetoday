<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Shape
 * @since Shape 2.0
 */
?>
<!doctype html>
<html>

<head>
    <meta charset=<?php bloginfo( 'charset' ); ?>>
    <meta http-equiv=X-UA-Compatible content="IE=edge">
    <meta name=description content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title><?php
    /*
    * Print the <title> tag based on what is being viewed.
    */
    global $page, $paged;

    wp_title( '|', true, 'right' );

    // Add the blog name.
    bloginfo( 'name' );

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
    echo " | $site_description";

    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 )
    echo ' | ' . sprintf( __( 'Page %s', 'tod' ), max( $paged, $page ) );

    ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link rel=manifest href=<?php echo tml_url; ?>/manifest.json>
    <meta name=mobile-web-app-capable content=yes>
    <meta name=application-name content="Web Starter Kit">
    <link rel=icon sizes=192x192 href=<?php echo tml_url; ?>/images/touch/chrome-touch-icon-192x192.png>
    <meta name=apple-mobile-web-app-capable content=yes>
    <meta name=apple-mobile-web-app-status-bar-style content=black>
    <meta name=apple-mobile-web-app-title content="Web Starter Kit">
    <link rel=apple-touch-icon href=<?php echo tml_url; ?>/images/touch/apple-touch-icon.png>
    <meta name=msapplication-TileImage content=<?php echo tml_url; ?>/images/touch/ms-touch-icon-144x144-precomposed.png>
    <meta name=msapplication-TileColor content=#3372DF>
    <meta name=theme-color content=#3372DF>
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/scripts/html5.js" type="text/javascript"></script>
    <![endif]-->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header class="app-bar promote-layer">
        <div class=app-bar-container>
            <button class=menu><img src=<?php echo tml_url; ?>/images/hamburger.png alt=Menu></button>
            <h1 class=logo>The <strong>Online Today</strong></h1>
<!--            <h2 class="desc"><?php bloginfo( 'description' ); ?></h2>-->
            <section class=app-bar-actions>
                <div class="search"></div>
            </section>
            <div class="clear"></div>
        </div>
    </header>
    <nav class="navdrawer-container promote-layer">
        <h4>Navigation</h4>
        <div class="menu-container">
            <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
            <div class="top-search" style="display: none;">
                <?php get_search_form(); ?>
            </div>
        </div>
    </nav>
    <main>