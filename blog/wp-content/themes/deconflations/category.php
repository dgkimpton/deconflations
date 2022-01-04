<?php
if(is_category($category)) {
	if(get_query_var('cat') == get_cat_ID('gallery'))
	{
		include_once('galleryIndex.php');
		die();
	}
	else if (cat_is_ancestor_of(get_cat_ID('gallery'), get_query_var('cat')))
	{
		include_once('galleryTemplate.php');
		die();
	}
}

die('Not a valid category');
?>