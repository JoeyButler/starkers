<ul class="dynamic-sidebar">
    <?php dynamic_sidebar( 'primary-widget-area' ) ?>
</ul>

<?php get_search_form(); ?>
	
<h3><?php _e( 'Archives', 'twentyten' ); ?></h3>
<ul>
	<?php wp_get_archives( 'type=monthly' ); ?>
</ul>
