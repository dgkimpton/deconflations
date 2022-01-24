</main>

<footer class="tail">
	<div class="tag-cloud">
		<h2 class="cloud-head">
			Common topics
		</h2>
		<?php wp_tag_cloud(["smallest" => 1.2, "largest" => 3, "unit" => "em"]); ?>
	</div>

	<div class="search">
		<form accept-charset="utf-8" method="get" action="<?= $_SERVER['PHP_SELF'] ?>" id="searchform">
			<label id="sl"><span id="slp">Not seeing what you're looking for?</span>Search</label> <input type="text" value="<?= esc_html($s) ?>" id="s" name="s" aria-labelledby="sl">
			<input type="submit" id="searchsubmit" value="" class="search-btn">
		</form>
	</div>

	<small>Design and Content &copy; Copyright Duncan Kimpton 2022</small>
</footer>
</body>

</html>
