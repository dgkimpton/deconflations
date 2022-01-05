<?php
require 'functions/common_data.php';
get_header();

if (is_page()) {
	if ($dgk->isTabPage) {
?>
		<h2 class="page-title"><?= $post->post_title; ?></h2>
<?php
	}
	global $more;
	$more = 1;
	the_content();
} else if (have_posts()) {
	while (have_posts()) {
		the_post();
		global $more;
		$normal_more = $more;
		$more = is_sticky() ? 1 : $normal_more;
		get_template_part('post');
		$more = $normal_more;
	};
} else {
	get_template_part('no_content');
}
get_footer();
