<?php if ( post_password_required() ) : ?>
	<p><?php _e( 'This post is password protected. Enter the password to view any comments.', 'twentyten' ); ?></p>
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php if ( have_comments() ) : ?>

	<h3 id="comments-title">
	<?php
    	printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'twentyten' ),
    	    number_format_i18n( get_comments_number() ), '' . get_the_title() . '' ); 
	    ?>
	</h3>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
    	<?php previous_comments_link( __( '&larr; Older Comments', 'twentyten' ) ); ?>
    	<?php next_comments_link( __( 'Newer Comments &rarr;', 'twentyten' ) ); ?>
    <?php endif; ?>

	<ol>
		<?php wp_list_comments( array( 'callback' => 'twentyten_comment' ) ); ?>
	</ol>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
    	<?php previous_comments_link( __( '&larr; Older Comments', 'twentyten' ) ); ?>
    	<?php next_comments_link( __( 'Newer Comments &rarr;', 'twentyten' ) ); ?>
    <?php endif; ?>

<?php else : ?>
    
    <?php if ( ! comments_open() ) : ?>
	    <p><?php _e( 'Comments are closed.', 'twentyten' ); ?></p>
    <?php endif; ?>
    
<?php endif; ?>

<?php comment_form(); ?>
