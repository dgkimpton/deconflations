<?php
global $dgk;
final class DGK
{
	public $pageId;
	public $top_level_pages;
	public $is_current_tab;
	public $missing_posts;

	public function __set($name, $value)
	{
		throw new Exception("Cannot add new property \$$name to instance of " . __CLASS__);
	}
	public function __get($name)
	{
		throw new Exception($name . ' does not exist in foo');
	}
}

$dgk = new DGK();

$dgk->pageId = get_the_ID();
$dgk->missing_posts = !have_posts();

$dgk->top_level_pages = get_pages([
	'sort_column' => 'menu_order',
	'child_of'  => 0,
	'parent' => 0,
	'hierarchical' => false
]);

$dgk->is_current_tab = false;
foreach ($dgk->top_level_pages as $available_page) {
	if ($dgk->pageId === $available_page->ID) {
		$dgk->is_current_tab = true;
		break;
	}
}

get_header();
if (is_page()) {
	if ($dgk->is_current_tab) {
?>
		<h2 class="page-title"><?= get_the_title(); ?></h2>
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
