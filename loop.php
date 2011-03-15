<?php if ( ! have_posts() ) : ?>

	<h1><?php _e( 'Not Found', 'twentyten' ); ?></h1>
	<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyten' ); ?></p>
	<?php get_search_form(); ?>

<?php else: ?>

<?php while ( have_posts() ) : the_post(); ?>

	<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<?php twentyten_posted_on(); ?>
	<?php if ( count( get_the_category() ) ) : ?>
		<p class="categories"><?php printf( __( 'Posted in %2$s', 'twentyten' ), '', get_the_category_list( ', ' ) ); ?></p>
    <?php endif; ?>
	<?php the_content( __( 'Read More.', 'twentyten' ) ); ?>
    
    <?php $tags_list = get_the_tag_list( '', ', ' ); ?>
	<?php if ( $tags_list ): ?>
		<p class="tags"><?php printf( __( 'Tagged %2$s', 'twentyten' ), '', $tags_list ); ?></p>
	<?php endif; ?>

	<?php comments_popup_link( __( 'Leave a comment', 'twentyten' ), __( '1 Comment', 'twentyten' ), __( '% Comments', 'twentyten' ) ); ?>
	<?php edit_post_link( __( 'Edit', 'twentyten' ), '|', '' ); ?>
	<?php comments_template( '', true ); ?>

<?php endwhile; ?>

<?php if (  $wp_query->max_num_pages > 1 ) : ?>
	<?php next_posts_link( __( '&larr; Older posts', 'twentyten' ) ); ?>
	<?php previous_posts_link( __( 'Newer posts &rarr;', 'twentyten' ) ); ?>
<?php endif; ?>
