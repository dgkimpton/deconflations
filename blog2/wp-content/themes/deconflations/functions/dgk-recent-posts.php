<?php

namespace dgk;

function recent_posts($params)
{
	global $dgk_in_recent_posts, $more;

	$a = shortcode_atts([
		'category' => ''
	], $params);

	if ($a['category'] == '') {
		return "[[unknown category]]";
	}

	$postQuery = new \WP_Query([
		'category_name' => $a['category']
	]);

	ob_start();
?>
	<ul class="posts">
		<?php
		$dgk_in_recent_posts = true;
		$is_first_non_sticky = true;
		while ($postQuery->have_posts()) {
			$postQuery->the_post();

			$normal_more = $more;
			$more = (is_sticky() || $is_first_non_sticky) ? 1 : $normal_more;
		?>
			<li class="post-container"><?php get_template_part('post'); ?></li>
		<?php
			$more = $normal_more;

			if (!is_sticky()) {
				$is_first_non_sticky = false;
			}
		};
		$dgk_in_recent_posts = false;
		?>
	</ul>
<?php
	wp_reset_postdata();

	return ob_get_clean();
}
