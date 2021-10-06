<?php if ( post_password_required() ) : ?>
	<p class="nopassword">
		<?php _e( 'This post is password protected. Enter the password to view any comments.' ); ?>
	</p>
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php 

if ( ! function_exists( 'deconflations_comment' ) ) :

function deconflations_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li class="comment">
		On <?php echo get_comment_date();?> <cite><?php comment_author(); ?></cite>
		<?php if ( $comment->comment_approved == '0' ) 
				echo ' posted a comment which is awaiting moderation.';
			else
				echo ' said...';
		?>
		
		<?php if ( $comment->comment_approved == '1' ) {?>
		<div class="commentText"><?php comment_text(); ?></div>
		<?php } ?>
	</li>
	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
			break;
	endswitch;
}
endif;
?>

<?php if ( have_comments() ) : 
    // Are there comments to navigate through?
 	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<div class="navigation">
		<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'twentyten' ) ); ?></div>
	</div> 
	<?php
	endif; // check for comment navigation ?>

	<ul class="comment">
		<?php
			wp_list_comments( array( 'callback' => 'deconflations_comment' ) );
		?>
	</ul>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) :
?>
	<p class="nocomments"><?php _e( 'Comments are closed.', 'twentyten' ); ?></p>
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>


</div><!-- #comments -->
