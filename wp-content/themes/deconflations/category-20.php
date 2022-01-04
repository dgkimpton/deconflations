<?php get_header(); 

if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
	
<div class="about">
	<h2 class="singlePostTitle"><?php the_title(); ?></h2> 
	<div class="postContent">
		<?php the_content(); ?>
	</div>
</div>

<?php 
endwhile; else: ?>
<br/>
<p>Sorry, no posts matched your criteria.</p>
<br/>
<?php endif; 


get_footer(); ?>