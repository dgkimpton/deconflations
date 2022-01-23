<?php

namespace dgk;

require 'common_data.php';

function recent_posts($params)
{
	global $dgk;

	$a = shortcode_atts([
		'category' => ''
	], $params);

	if ($a['category'] == '') {
		return "[[unknown category]]";
	}

	$postQuery = new \WP_Query([
		'category_name' => $a['category']
	]);

	ob_start();
	$dgk->list_posts($postQuery);
	return ob_get_clean();
}
