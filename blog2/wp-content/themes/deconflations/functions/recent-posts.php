<?php

namespace dgk;

require 'common_data.php';

function recent_post_listing($category)
{
	global $dgk;

	ob_start();

	$dgk->list_posts(
		new \WP_Query([
			'category_name' => $category,
			'paged' => get_query_var('page', 1)
		])
	);

	return ob_get_clean();
}

function recent_posts($params)
{
	$a = shortcode_atts(['category' => ''], $params);

	if ($a['category'] == '') {
		return "[[unknown category]]";
	}

	$category = $a['category'];

	return is_search()
		? '<div class="search-hint">posts in the category "' . $category . '"</div>'
		: recent_post_listing($category);
}
