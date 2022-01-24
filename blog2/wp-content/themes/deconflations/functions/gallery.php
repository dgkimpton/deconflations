<?php

namespace dgk;

require_once 'utils.php';
require_once 'non-dynamic-object.php';

final class Image extends NonDynamicObject
{
	public $src;
	public $width;
	public $height;

	function __construct($id, $type)
	{
		$image = wp_get_attachment_image_src($id, $type);
		$imageRelative = make_relative($image[0]);
		$this->src = $imageRelative;
		$this->width = $image[1];
		$this->height = $image[2];
	}
}

final class GalleryItem extends NonDynamicObject
{
	public $id;
	public $title;
	public $thumb;
	public $large;
	public $full;
	public $link;
	public $description;
	public $caption;

	function __construct($data)
	{
		$this->id = $data->ID;
		$this->title = $data->post_title;

		$this->description = $data->post_content;
		$this->caption = isset($data->post_excerpt) && $data->post_excerpt != ''
			? $data->post_excerpt
			: get_metadata('post', $data->ID, '_wp_attachment_image_alt', true);

		$this->thumb = new Image($data->ID,  'thumbnail');
		$this->large = new Image($data->ID,  'large');
		$this->full = new Image($data->ID,  'full');
	}
}

function findGalleryItems($id)
{
	return array_map(
		function ($item) {
			return new GalleryItem($item);
		},
		get_children([
			'post_type' => 'attachment',
			'posts_per_page' => -1,
			'post_parent' => $id,
			'order' => 'ASC',
			'orderby' => 'menu_order'
		])
	);
}

function gallery()
{
	global $dgk;
	ob_start();

	if (!is_search()) {
?>
		<ul class="gallery-items">
			<?php
			foreach (findGalleryItems($dgk->pageId) as $i) {
				$thumb = $i->thumb;
				$full = $i->full;
				$large = $i->large;
			?>
				<li class="gallery-item" data-id="<?= $i->id; ?>" data-img="<?= $large->src; ?>" data-width="<?= $large->width; ?>" data-height="<?= $large->height; ?>">
					<a href="<?= $full->src; ?>">
						<figure>
							<img src="<?= $thumb->src; ?>" width="<?= $thumb->width; ?>" height="<?= $thumb->height; ?>" alt="link to full sized image" loading="lazy">

							<figcaption class="caption"><?= $i->caption; ?></figcaption>
						</figure>
					</a>
					<blockquote class="description"><?= $i->description; ?></blockquote>
				</li>
			<?php
			}
			?>

		</ul>
	<?php
	} else {
	?>
		<div class="search-hint">image gallery</div>
<?php
	}
	return ob_get_clean();
}
