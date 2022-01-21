<?php
require 'functions/common_data.php';
get_header();

if (!$dgk->isTabPage) {
	# if it is a tab page the tab link serves as the title, but if it isn't a top
	# level tab page then there would be no heading, so add one
?>
	<h2 class="page-title"><?= $post->post_title; ?></h2>
<?php
}

global $more;
$more = 1;
the_content();

?>
<small class="posted">posted: <?php the_time('F Y'); ?></small>
<?php
get_footer();
