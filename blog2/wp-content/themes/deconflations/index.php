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

	while (have_posts()) {
		the_post();
		global $more;
		$normal_more = $more;
		$more = is_sticky() ? 1 : $normal_more;
		get_template_part('post');
		$more = $normal_more;
	};

	get_footer();
} else {

	get_header();
	get_template_part('no_content');
	get_footer();
}
