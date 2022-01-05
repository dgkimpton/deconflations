<?php global $dgk;

$dgk->preload->load_font($dgk->make_font_uri('play-v12-latin-regular.woff2'));
$dgk->preload->load_font($dgk->make_font_uri('play-v12-latin-700.woff2'));
$dgk->preload->load_style($dgk->make_style_uri('index.css'));
$dgk->preload->load_image($dgk->make_image_uri('offsite.png'));

$dgk->preload->send_all();

function injectFont($fontName, $fontWeight, $fontStyle, $fontFileName)
{
	global $dgk;
?>
	@font-face {
	font-family: '<?= $fontName ?>';
	font-style: <?= $fontStyle ?>;
	font-weight: <?= $fontWeight ?>;
	src: url(<?= $dgk->make_font_uri($fontFileName . '.eot') ?>);
	src: local(''),
	url(<?= $dgk->make_font_uri($fontFileName . '.eot?#iefix') ?>) format('embedded-opentype'),
	url(<?= $dgk->make_font_uri($fontFileName . '.woff2') ?>) format('woff2'),
	url(<?= $dgk->make_font_uri($fontFileName . '.woff') ?>) format('woff'),
	url(<?= $dgk->make_font_uri($fontFileName . '.ttf') ?>) format('truetype'),
	url(<?= $dgk->make_font_uri($fontFileName . '.svg#Play') ?>) format('svg');
	}
<?php
}

?>
<!DOCTYPE html>
<html lang="<?= $dgk->blog->language ?>">

<head>
	<meta charset="<?= $dgk->blog->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Want to see the source? https://github.com/dgkimpton/deconflations -->

	<?php
	# Get the darkmode set ASAP to minimise solid color flashes during page load 
	?>

	<style>
		@media (prefers-color-scheme: dark) {
			:root {
				background-color: #121212;
				color: #CACACA;
			}
		}

		@media (prefers-color-scheme: light) {
			:root {
				background-color: #FEFEFE;
				color: grey;
			}
		}

		<?php

		# setup the bits that can't be done without php - this avoids us having to also
		# use php to generate the css files

		# see https://google-webfonts-helper.herokuapp.com/fonts/play?subsets=latin

		injectFont('Play', 400, 'normal', 'play-v12-latin-regular');
		injectFont('Play', 700, 'normal', 'play-v12-latin-700');

		?>.offsite {
			background: url(<?= $dgk->make_image_uri('offsite.png') ?>) no-repeat right center;
		}
	</style>

	<!-- <link rel="preconnect" href="<?= $gfontApiUri ?>" crossorigin>
	<link rel="preconnect" href="<?= $gfontStaticUri ?>" crossorigin>
	<link rel="preload" href="<?= $mainFontUri ?>" as="font" type="font/woff2" crossorigin> -->

	<title><?= $dgk->title ?></title>
	<link rel="stylesheet" href="<?= $dgk->make_style_uri('index.css') ?>">
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
