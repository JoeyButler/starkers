<?php
/**
 * The loop that displays a page.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-page.php.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.1
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<?php if ( is_front_page() ) { ?>
					<h2><?php the_title(); ?></h2>
				<?php } else { ?>
					<h1><?php the_title(); ?></h1>
				<?php } ?>

						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'twentyten' ), 'after' => '' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '|', '' ); ?>
				
				<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>
