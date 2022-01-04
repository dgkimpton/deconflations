<?php
$blackStyle = true;
$activeTab = 'gallery';

get_header();

$galleryLink = get_category_link(get_cat_ID('gallery'));
?>
<script src="<?php bloginfo('template_url'); ?>/js/prototype.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_url'); ?>/js/scriptaculous.js?load=effects" type="text/javascript"></script>
<script src="<?php bloginfo('template_url'); ?>/js/tapgallery.js" type="text/javascript"></script>

<div class="gallery" id='gallery'>
    <h2 class="galleryTitle" id='galleryTitle'><a href="<?php echo $galleryLink; ?>">Galleries</a> > <?php single_cat_title(); ?></h2>
    <div class="galleryDescription"><?php echo category_description(get_query_var('cat')); ?> </div>
    <div id='TapGallery'>
		<div id="previousImageLink" class="galleryPreviousLink">Previous<br />&lt;--</div>
		<div id="nextImageLink" class="galleryNextLink">Next<br />--&gt;</div>
    </div>
    <div id="TapDescription"></div>
</div>

<script type="text/javascript">
var gallery = new Gallery(  'TapGallery',
                            'TapDescription',
                            'previousImageLink',
                            'nextImageLink',
                            700,
                            50,
                            50);

<?php
$args = array(
    'post_type' => 'attachment',
    'cat' => get_query_var('cat'),
    'numberposts' => -1,
    'order' => 'DESC'
);
foreach(get_posts($args) as $media)
{
	$desc = str_replace('"', '', $media->post_excerpt);
	$desc = str_replace('\r\n', '<br />', $desc);
    echo 'gallery.AddImage("'.$media->guid.'", "'.$desc.'");'."\n";
}

?>

gallery.ShowFirst();

$j(document).ready(function() {
	$j("a").bind("click", function(){
		new Effect.Morph('body', {style: 'background-color: #F8FAFE', duration: 1});
		new Effect.Morph('footer', {style: 'background-color: #fff', duration: 1});
		new Effect.Morph('terminator', {style: 'background-color: #fff', duration: 1});
	});
})
</script>

<?php

get_footer(); ?>
