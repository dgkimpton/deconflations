<?php global $more;

$more = ($more == 1 || is_single());

if (is_single()) {
?>
	<h2><?php the_title(); ?></h2>
<?php
} else { ?>
	<details <?= $more ? 'open' : '' ?> class="post">
		<summary>
			<?php the_title(); ?>
		</summary>
	<?php
}

the_content(__('continue reading...')); ?>

	<a href="<?php echo get_permalink(get_the_ID()); ?>" class="permalink">permalink</a>
	<small class="posted">posted: <?php the_time('F Y'); ?></small>
	<?php
	if (!is_single()) { ?>
	</details>
<?php
	}
