<?php
require 'functions/common_data.php';
get_header();
if (!$dgk->isTabPage) {
?>
	<h2 class="page-title"><?= $post->post_title; ?></h2>
<?php
}

global $more;
$more = 1;
the_content();
get_footer();