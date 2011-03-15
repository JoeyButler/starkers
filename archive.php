<?php get_header(); ?>

<?php if( have_posts() ) the_post(); ?>

	<h1>
		<?php if ( is_day() ) : ?>
			<?php printf( __( 'Daily Archives: %s', 'twentyten' ), get_the_date() ); ?>
		<?php elseif ( is_month() ) : ?>
			<?php printf( __( 'Monthly Archives: %s', 'twentyten' ), get_the_date('F Y') ); ?>
		<?php elseif ( is_year() ) : ?>
			<?php printf( __( 'Yearly Archives: %s', 'twentyten' ), get_the_date('Y') ); ?>
		<?php elseif ( is_category() ) : ?>
			<?php printf( __( 'Category Archives: %s', 'twentyten' ), '' . single_cat_title( '', false ) . '' ); ?>
		<?php elseif ( is_tag() ) : ?>
			<?php printf( __( 'Tag Archives: %s', 'twentyten' ), '' . single_tag_title( '', false ) . '' ); ?>
		<?php else : ?>
			<?php _e( 'Blog Archives', 'twentyten' ); ?>
		<?php endif; ?>
	</h1>

	<?php rewind_posts(); ?>
	<?php get_template_part( 'loop', 'archive' ); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
