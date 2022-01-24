<?php
if (is_search()) {
?>
	<h2 class="not-found">No Results</h2>
	<blockquote class="not-found">
		Search returned no results when querying for "<?= esc_html($_GET['s']) ?>"<br /><br /><br /><br />
		Maybe pick something from the menu, or try a different search.
	</blockquote>
<?php
} else {
?>
	<h2 class="not-found">Not Found</h2>
	<blockquote class="not-found">
		Huh... apparently there's nothing to see here.<br /><br />
		Maybe pick something from the menu, or try a search.
	</blockquote>
<?php
}
