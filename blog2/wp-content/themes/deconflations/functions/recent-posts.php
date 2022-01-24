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
		'category_name' => $a['category'],
		'paged' => get_query_var('page', 1)
	]);

	ob_start();

	if (!is_search()) {
		$dgk->list_posts($postQuery);
	} else {
?>
		<div class="search-hint">Posts in the category "<?= $a['category'] ?>"</div>
<?php
	}

	return ob_get_clean();
}
