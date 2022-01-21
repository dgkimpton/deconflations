<?php
global $more, $dgk_in_recent_posts;
?>
<details <?= $more ? 'open' : '' ?> class="post">
	<summary>
		<?php the_title(); ?>
	</summary>

	<?php the_content(__('continue reading...')); ?>

	<a href="<?php echo get_permalink(get_the_ID()); ?>" class="permalink">permalink</a>
	<small class="posted">posted: <?php the_time('F Y'); ?></small>
</details>
