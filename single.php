<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Tod
 * @since Tod 1.0
 */
 
get_header(); ?>
<div class="g-wide--3 g-medium--half">
        <div id="primary" class="content-area">
            <div id="content" class="site-content" role="main">
 
            <?php while ( have_posts() ) : the_post(); ?>
 
                
 
                <?php get_template_part( 'content', 'single' ); ?>
 
                <?php tod_content_nav( 'nav-below' ); ?>
 
                <?php
                    // If comments are open or we have at least one comment, load up the comment template
                    if ( comments_open() || '0' != get_comments_number() )
                        comments_template( '', true );
                ?>
 
            <?php endwhile; // end of the loop. ?>
 
            </div><!-- #content .site-content -->
        </div><!-- #primary .content-area -->
 </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>