<?php
require 'functions/common_data.php';


if (is_page()) {
	if (!$dgk->isTabPage) {

		get_template_part('single');
	} else {

		get_header();
		the_content();
		get_footer();
	}
} else if (have_posts()) {

	get_header();
	if (is_search()) {
		echo "<h2>Search Results</h2>";
	}
	global $wp_query;
	$dgk->list_posts($wp_query);
	get_footer();
} else {

	get_header();
	get_template_part('no_content');
	get_footer();
}
