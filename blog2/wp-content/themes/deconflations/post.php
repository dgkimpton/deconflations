<?php
global $more, $open;

if (is_search()) {
?>
	<div class="post">
		<a href="<?= get_permalink(get_the_ID()) ?>" class="permalink search-result">
			<span class="post-title"><?php the_title() ?></span>
		</a>
		<?php the_content(__('continue reading...')); ?>
	</div>
<?php
} else {
?>
	<details <?= $open ? 'open' : '' ?> class="post">
		<summary class="post-title">
			<?php the_title(); ?>
		</summary>
		<div class="post-content">
			<?php the_content(__('continue reading...')); ?>
		</div>

		<a href="<?= get_permalink(get_the_ID()) ?>" class="permalink">permalink</a>
		<small class="posted">posted: <?php the_time('F Y'); ?></small>

		<?php
		$tags = get_the_tag_list('<li class="tag">', "</li>\n<li class=\"tag\">", "</li>\n");

		if ($tags && !is_wp_error($tags)) {
		?>
			<div class="tags">
				<span class="see-also">see&nbsp;also</span>
				<ul class="tag-list">
					<?= $tags ?>
				</ul>
			</div>
		<?php
		}
		?>
	</details>
<?php
}
