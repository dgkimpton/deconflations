<?php
global $blackStyle, $activeTab;

function GenerateTab($displayText, $page, $url)
{
	global $activeTab;

	?><li class="tab" <?php if ($activeTab == $page) echo ' id="activeTab"';?>><a class="tabLink" href='<?php echo $url?>'><?php echo $displayText?></a></li><?php
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(''); if (function_exists('is_tag') and is_tag()) { ?>
<?php } if (is_archive()) { ?>
<?php } elseif (is_search()) { ?>
<?php echo $s; } if ( !(is_404()) and (is_search()) or (is_single()) or (is_page()) or (function_exists('is_tag') and is_tag()) or (is_archive()) ) { ?>
<?php _e(' | '); ?>
<?php } ?>
<?php bloginfo('name'); ?></title>

<script src="<?php bloginfo('template_url'); ?>/js/jquery-1.5.js" type="text/javascript"></script>
<script type="text/javascript">
var $j = jQuery.noConflict();
</script>
<script src="<?php bloginfo('template_url'); ?>/js/tap.js" type="text/javascript" ></script>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style<?php if(isset($blackStyle) && $blackStyle) {echo '_dark';} ?>.php" type="text/css" media="screen" />

<link rel="SHORTCUT ICON" href="http://deconflations.com/favicon.ico"/>
<?php wp_head(); ?>

</head>
<body onload="toggleBG();" id='body'>
<!-- Begin Header -->
<div id="header">
	<div class="headerContent">
		<a href="<?php echo get_option('home'); ?>/"><img src="<?php bloginfo('template_url'); ?>/deconflations.png"
		                                                  title="<?php bloginfo('name'); ?>"
		                                                  alt="<?php bloginfo('name'); ?>"
		                                                  id="logo" /></a>

		<div id="tagline">
			<?php bloginfo('description'); ?>
		</div>

		<div id="search">
			<form
				accept-charset="utf-8"
				method="get"
				action="<?php echo $_SERVER['PHP_SELF']; ?>"
				id="searchform">
		    	<input type="text" value="<?php echo wp_specialchars($s, 1); ?>" id="s" name="s" onkeyup="toggleBG();">
				<input type="submit" id="searchsubmit" value="">
			</form>
		</div>

		<div class="headerTags"><a href="<?php echo get_option('home'); ?>/wp-rss2.php"><img src="<?php bloginfo('template_url'); ?>/rss-feed.png" /></a></div>
	</div>
</div>
<div id="navBar">
	<div id="tab-bar">
		<ul>
			<?php GenerateTab('Blog', 'index', get_option('home')); ?>
			<?php GenerateTab('Galleries', 'gallery', get_category_link(get_cat_ID('gallery'))); ?>
			<?php GenerateTab('About', 'about', get_option('home').'/about/'); ?>
		</ul>
	</div>
</div>
<!-- End Header -->
