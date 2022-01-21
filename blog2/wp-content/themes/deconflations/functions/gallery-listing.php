<?php

namespace dgk;

require_once 'utils.php';
require_once 'non-dynamic-object.php';

final class Thumbnail extends NonDynamicObject
{
	public $src;
	public $width;
	public $height;

	function __construct($data)
	{
		$thumb = wp_get_attachment_image_src($data->ID, 'thumbnail');
		$thumbRelative = make_relative($thumb[0]);
		$this->src = $thumbRelative;
		$this->width = $thumb[1];
		$this->height = $thumb[2];
	}
}

final class Gallery extends NonDynamicObject
{
	public $title;
	public $size;
	public $thumb;
	public $link;

	function __construct($data)
	{
		$this->title = $data->post_title;

		$attachements = get_children([
			'post_parent' => $data->ID,
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
		]);

		$this->size = $imageCount = count($attachements);
		$thumbIdx = rand(0, $imageCount - 1);
		$randomThumb = array_at($attachements, $thumbIdx);

		$this->thumb = new Thumbnail($randomThumb);
		$this->link = get_the_permalink($data->ID);
	}

	public function isPlural()
	{
		return $this->size != 1;
	}
}

function findGalleries($rootId)
{
	return array_map(
		function ($child) {
			return new Gallery($child);
		},
		get_children([
			'post_type' => 'page',
			'posts_per_page' => -1,
			'post_parent' => $rootId,
			'order' => 'ASC',
			'orderby' => 'menu_order'
		])
	);
}


function gallery_listing()
{
	global $dgk;

	ob_start();
?>
	<ul class="galleries">
		<?php
		foreach (findGalleries($dgk->pageId) as $g) {
			$imageText = $g->isPlural() ? 'images' : 'image';
		?>
			<li class="gallery">
				<a href="<?= $g->link ?>" title="link to the <?= $g->title ?> image gallery">
					<img src="<?= $g->thumb->src; ?>" width="<?= $g->thumb->width; ?>" height="<?= $g->thumb->height; ?>" alt="random image from the <?= $g->title ?> gallery">
					<span class="gallery-name"><?= $g->title ?></span>
				</a>
				<span class="gallery-size"> [ <?= $g->size ?> <?= $imageText ?>]</span>
			</li>
		<?php
		}
		?>
	</ul>
<?php
	return ob_get_clean();
}
