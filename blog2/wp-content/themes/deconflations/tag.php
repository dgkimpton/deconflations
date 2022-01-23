<?php
require 'functions/common_data.php';

get_header();
?>
<h2 class="page-title">Posts with the topic <?= get_queried_object()->name ?></h2>
<?php
global $wp_query;
$dgk->list_posts($wp_query);
get_footer();
