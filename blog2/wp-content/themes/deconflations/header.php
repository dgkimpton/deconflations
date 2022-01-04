<?php
global $dgk;

function merge_title_elements($elements)
{
	return implode(" | ", $elements);
}

function build_the_title()
{
	global $dgk;
	global $post;
	$name = get_bloginfo('name');

	if (is_404() || $dgk->missing_posts) {
		return merge_title_elements(["Not Found", $name]);
	}

	if (is_archive()) {
		return merge_title_elements([get_the_title(), "archived", $name]);
	}
	if (is_search()) {
		return merge_title_elements(["search", $name]);
	}
	if (is_tag()) {
		return merge_title_elements([get_the_tags()[0], $name]);
	}
	return merge_title_elements([$post->post_title, $name]);
}
?>
<!DOCTYPE html>
<html lang="<?= get_bloginfo('language'); ?>">

<head>
	<meta charset="<?= get_bloginfo('charset'); ?>">
	<title><?= build_the_title(); ?></title>
</head>

<body>
	<header class="branding">
		<h1>
			<a href="<?= home_url(); ?>"><?= get_bloginfo('name'); ?></a>
		</h1>
		<h2><?= get_bloginfo('description'); ?></h2>
	</header>
	<nav class="tabs">
		<?php
		#Note: the tab-separator is only included for when the css fails to load`
		echo implode(
			'<span class="tab-separator" aria-hidden="true"> | </span>' . "\n\t\t",
			array_map(
				function ($tab) use (&$dgk) {
					$link = dcon_make_relative(get_permalink($tab));
					$text = $tab->post_title;
					$classes = ($dgk->pageId == $tab->ID) ? 'tab current-tab' : 'tab';
					return '<a href="' . $link . '" class="' . $classes . '">' . $text . '</a>';
				},
				$dgk->top_level_pages
			)
		);
		?>

	</nav>
	<main>
