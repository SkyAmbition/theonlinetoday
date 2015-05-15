<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Tod
 * @since Tod 1.0
 */
if (!function_exists('tod_content_nav')):

    /**
     * Display navigation to next/previous pages when applicable
     *
     * @since Tod 1.0
     */
    function tod_content_nav($nav_id) {
        global $wp_query, $post;

        // Don't print empty markup on single pages if there's nowhere to navigate.
        if (is_single()) {
            $previous = ( is_attachment() ) ? get_post($post->post_parent) : get_adjacent_post(false, '', true);
            $next = get_adjacent_post(false, '', false);

            if (!$next && !$previous){
                return;
            }
        }

        // Don't print empty markup in archives if there's only one page.
        if ($wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() )){
            return;
        }
        $nav_class = 'site-navigation paging-navigation';
        if (is_single()){
            $nav_class = 'site-navigation post-navigation';
        }
        ?>
        <nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
            <h1 class="assistive-text"><?php _e('Post navigation', 'tod'); ?></h1>

        <?php if (is_single()) : // navigation links for single posts  ?>

                <?php previous_post_link('<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x('&larr;', 'Previous post link', 'tod') . '</span> %title'); ?>
                <?php next_post_link('<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x('&rarr;', 'Next post link', 'tod') . '</span>'); ?>

            <?php elseif ($wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() )) : // navigation links for home, archive, and search pages ?>

                <?php if (get_next_posts_link()) : ?>
                    <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'tod')); ?></div>
                <?php endif; ?>

                <?php if (get_previous_posts_link()) : ?>
                    <div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'tod')); ?></div>
                <?php endif; ?>

            <?php endif; ?>

        </nav><!-- #<?php echo $nav_id; ?> -->
        <?php
    }


endif; // tod_content_nav


if ( ! function_exists( 'tod_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Tod 1.0
 */
function tod_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
    ?>
    <li class="post pingback">
        <p><?php _e( 'Pingback:', 'tod' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'tod' ), ' ' ); ?></p>
    <?php
            break;
        default :
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment">
            <footer>
                <div class="comment-author vcard">
                    <?php echo get_avatar( $comment, 40 ); ?>
                    <?php printf( __( '%s <span class="says">says:</span>', 'tod' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
                </div><!-- .comment-author .vcard -->
                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <em><?php _e( 'Your comment is awaiting moderation.', 'tod' ); ?></em>
                    <br />
                <?php endif; ?>
 
                <div class="comment-meta commentmetadata">
                    <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
                    <?php
                        /* translators: 1: date, 2: time */
                        printf( __( '%1$s at %2$s', 'tod' ), get_comment_date(), get_comment_time() ); ?>
                    </time></a>
                    <?php edit_comment_link( __( '(Edit)', 'tod' ), ' ' );
                    ?>
                </div><!-- .comment-meta .commentmetadata -->
            </footer>
 
            <div class="comment-content"><?php comment_text(); ?></div>
 
            <div class="reply">
                <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div><!-- .reply -->
        </article><!-- #comment-## -->
 
    <?php
            break;
    endswitch;
}
endif; // ends check for tod_comment()