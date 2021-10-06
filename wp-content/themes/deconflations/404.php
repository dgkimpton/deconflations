<?php get_header(); ?>

<div class="post">
	<h2 class="center" style="color: red;">Doh ... Not Found</h2>
	<p class="center">Holy batman we couldn't find what you were looking for... maybe the mice ate it.</p>
	<p class="center">Maybe you could go hunting for it (search, top right) or just begin again with the newest stuff by clicking the logo above.</p>
	<p class="center">Enjoy finding more interesting content.</p>
</div>

<?php
if (isset($_SERVER['HTTP_REFERER'])) {
	$failuremess = A user tried to go to $website".$_SERVER['REQUEST_URI']." and received a 404 (page not found) error. ";
	$failuremess .= "They came from ".$_SERVER['HTTP_REFERER'];
	mail($adminemail, "Bad Link To ".$_SERVER['REQUEST_URI'],
        $failuremess, "From: $websitename"); }?>
<?php get_footer(); ?>