<?php
$activeTab = 'gallery';

get_header();  ?>

  <div class="post">
    <h2 class="postTitle">Photo Galleries</h2>
	<div class="postContent">
		<ul style="list-style: none;">

<?php
		$args = array( 'hide_empty' => '0', 'child_of' => get_cat_ID('gallery'),'orderby' => 'name', 'order' => 'ASC');
		$categories=  get_categories($args);
		foreach ($categories as $category) {
			$args = array(
				'post_type' => 'attachment',
				'cat' => $category->cat_ID,
				'numberposts' => -1
			);
			$images = get_posts($args);

			echo '<li class="galleryItem"><a href='.get_category_link($category->cat_ID).'>'.$category->cat_name.'</a> <small>['.count($images).' images]</small></li>';
		}
 ?>
		</ul>
	</div>
</div>

<?php get_footer(); ?>
