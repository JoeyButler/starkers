<?php
	$form =
	'<form method="get"  accept-charset="utf-8" class="blog-search" action="/">
		<input type="text" class="text" value="' . esc_attr(apply_filters('the_search_query', get_search_query())) . '" name="s" />
		<input type="submit" value="Search" class="submit" />
		<div class="clear">&nbsp;</div>
	</form>';
	
	echo apply_filters('get_search_form', $form);
?>