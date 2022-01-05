<?php global $dgk; ?>
<!DOCTYPE html>
<html lang="<?= $dgk->blog->language ?>">

<head>
	<meta charset="<?= $dgk->blog->charset ?>">
	<title><?= $dgk->title ?></title>
</head>

<body>
	<header class="branding">
		<h1>
			<a href="<?= $dgk->blog->url ?>"><?= $dgk->blog->name ?></a>
		</h1>
		<h2><?= $dgk->blog->tagline ?></h2>
	</header>
	<nav class="tabs">
		<?php
		#Note: the tab-separator is only included for when the css fails to load`
		echo implode(
			'<span class="tab-separator" aria-hidden="true"> | </span>' . "\n\t\t",
			array_map(
				function ($tab) {
					$classes = $tab->isCurrent ? 'tab current-tab' : 'tab';
					return '<a href="' . $tab->link . '" class="' . $classes . '">' . $tab->displayText . '</a>';
				},
				$dgk->blog->tabs
			)
		);
		?>

	</nav>
	<main>
