<?php
$activeTab = 'about';

get_header();


$postArgs=array();
$postArgs['category_name'] ='about';

query_posts(array_merge($postArgs, $wp_query->query));

$first = true;
 if ( have_posts() ) :
?>
<?php previous_posts_link('<div class="navLinks" align="left">&lt;-- read newer posts</div>'); ?>

<?php
    while ( have_posts() ) : the_post(); ?>

<!-- Begin Post -->
<div class="post">
	  <h2 class="postTitle"
  	  onclick="togglePost(<?php the_ID(); ?>);" >
      <?php the_title(); ?>
      <div class="clickPrompt"
		   id="click_prompt_<?php the_ID(); ?>" <?php
	if($first)
		echo 'style="display: none;"';
	?>>Click to expand</div>
		   <!--echo get_permalink(ID);-->
  </h2>

	<div class="content" id="post_<?php the_ID(); ?>" <?php
	if($first)
		echo 'style="display: block;"';
	?>>
		<div class="postContent">
			<?php the_content(); ?>
		</div>

		<div class="commentForm">
			<?php if ( comments_open() ) :?>

				<!-- Comment form -->
				<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
					<p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
				<?php else : ?>

					<?php if ( is_user_logged_in() ) : ?>
						<p class="loggedInUser">Not <?php echo $user_identity; ?>? please <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php _e('Log out of this account') ?>">logout now</a>&nbsp;</p>
						<p class="commentPrompt"><?php echo $user_identity; ?> your thoughts are valuable... post your thoughts on this topic...</p>
							<form style="margin-top: 0px; padding-top:0px;" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
								<p align="center"  style="margin-top: 0px; padding-top:0px;"><textarea name="comment" id="comment" cols="83%" rows="15" tabindex="4"></textarea></p>
					<?php else : ?>
							<p class="commentPrompt" style="margin-top:1em;">Your thoughts are valuable... post your thoughts on this topic...</p>

							<form style="margin-top: 0px; padding-top:0px;" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
								<p align="center" style="margin-top: 0px; padding-top:0px;"><textarea name="comment" id="comment" cols="83%" rows="15" tabindex="4"></textarea></p>

								<p class="userDetails"><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
									<label for="author"><small>name <?php if ($req) _e('(required)'); ?></small></label><br/>
									<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
									<label for="email"><small>e-mail (will not be published)<?php if ($req) _e('(required)'); ?></small></label>
								</p>
					<?php endif; ?>
								<p class="userDetails">
									<input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
									<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />

									<?php do_action('comment_form', $post->ID); ?>
								</p>
							</form>
				<?php endif; ?>

			<?php else : ?>
				<p class="nocomments">Comments are Closed.</p>
			<?php endif; ?>

		</div>

		<div class="feedbackHeader">
       		<div class="community" onclick="togglePostComments(<?php the_ID(); ?>)">community content (<?php comments_number('no approved comments','1 approved comment','% approved comments'); ?> so far)
			    <div class="clickPrompt" id="click_prompt_comments_<?php the_ID(); ?>">Click to expand</div>
		    </div>
				<div class="feedback" id="post_comments_<?php the_ID(); ?>">

				<?php
				$withcomments = true;
  				comments_template();
				?>
			</div>
		</div>
	</div>
</div>
<!-- End Post -->
<?php
if($first)
	$first=false;
endwhile; else: ?>
<br/>
<p>Sorry, no posts matched your criteria.</p>
<br/>
<?php endif; ?>

<?php next_posts_link('<div class="navLinks" align="right">read older posts --&gt;</div>'); ?>


<?php get_footer(); ?>
