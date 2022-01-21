<?php

namespace dgk;

require_once 'utils.php';
require_once 'non-dynamic-object.php';

final class Thumbnail extends NonDynamicObject
{
	public $src;
	public $width;
	public $height;
	public $alt;

	private function __construct($src, $width, $height, $alt)
	{
		$this->src = $src;
		$this->width = $width;
		$this->height = $height;
		$this->alt = $alt;
	}

	static function New($data)
	{
		$thumb = wp_get_attachment_image_src($data->ID, 'thumbnail');
		$thumbRelative = make_relative($thumb[0]);
		$src = $thumbRelative;
		$width = $thumb[1];
		$height = $thumb[2];

		return new Thumbnail($src, $width, $height, "random image from the gallery");
	}

	static function Empty()
	{
		global $dgk;

		return new Thumbnail($dgk->make_image_uri('missing-gallery.png'), 64, 64, "gallery has no images");
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
		$this->link = get_the_permalink($data->ID);

		$attachements = get_children([
			'post_parent' => $data->ID,
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
		]);

		$this->size = $imageCount = count($attachements);
		if ($this->size > 0) {
			$thumbIdx = rand(0, $imageCount - 1);
			$randomThumb = array_at($attachements, $thumbIdx);

			$this->thumb = Thumbnail::New($randomThumb);
		} else {
			$this->thumb = Thumbnail::Empty();
		}
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
				<a href="<?= $g->link ?>" title="link to the image gallery called <?= $g->title ?>">
					<img src="<?= $g->thumb->src; ?>" width="<?= $g->thumb->width; ?>" height="<?= $g->thumb->height; ?>" alt="<?= $g->thumb->alt ?>">
					<span class="gallery-name"><?= $g->title ?></span>
					<span class="gallery-size"> [ <?= $g->size ?> <?= $imageText ?>]</span>
				</a>
			</li>
		<?php
		}
		?>
	</ul>
<?php
	return ob_get_clean();
}
