<?php

namespace dgk;

require_once 'non-dynamic-object.php';
require_once 'wrapped-blog.php';
require_once 'preloader.php';
require_once 'utils.php';

global $post;


final class WrappedPage extends NonDynamicObject
{
	public $blog;
	public $preload;

	public $pageId;
	public $title;
	public $url;
	public $missing_posts;
	public $isTabPage;

	function __construct()
	{
		global $post;

		$this->pageId = get_the_ID();
		$this->blog = new WrappedBlog($this->pageId);
		$this->preload = new Preloader();
		$this->missing_posts = !have_posts();
		$this->url = make_page_permalink($this->pageId);
		$this->isTabPage = is_page() && !$post->post_parent;

		if (is_404() || $this->missing_posts) {
			$this->title = merge_title_elements(["Not Found", $this->blog->name]);
		} else if (is_archive()) {
			$this->title = merge_title_elements([$post->post_title, "archived", $this->blog->name]);
		} else if (is_search()) {
			$this->title = merge_title_elements(["search", $this->blog->name]);
		} else if (is_tag()) {
			$this->title = merge_title_elements([get_the_tags()[0], $this->blog->name]);
		} else {
			$this->title = merge_title_elements([$post->post_title, $this->blog->name]);
		}
	}

	function make_uri($folder, $name)
	{
		$f = get_template_directory() . slashAround($folder,  DIRECTORY_SEPARATOR) . $name;
		if (file_exists($f)) {
			# note the different (non-variable) type of slash - URI's are not folders
			$full_uri = get_template_directory_uri() . slashAround($folder,  '/') . $name;
			return make_relative($full_uri) . '?v=' . strval(filemtime($f));
		}

		return '??';
	}

	function make_image_uri($name)
	{
		return $this->make_uri('images', $name);
	}

	function make_style_uri($name)
	{
		return $this->make_uri('css', $name);
	}

	function make_script_uri($name)
	{
		return $this->make_uri('js', $name);
	}

	function make_font_uri($name)
	{
		return $this->make_uri('fonts', $name);
	}

	function list_posts($aQuery)
	{
		if (!$aQuery->have_posts()) {
			return;
		}

		$hasPages = $aQuery->max_num_pages > 1;
		$pageId = 	$hasPages ? $aQuery->query["paged"] : 1;

		if ($hasPages && $pageId > 1) {
			$preivousLink = esc_url(get_pagenum_link($pageId - 1));
?>
			<a href="<?= $preivousLink ?>" class="previous-link">&lt;-- newer posts</a>
		<?php
		}

		?>
		<ul class="posts">
			<?php
			$is_first_non_sticky = true;

			while ($aQuery->have_posts()) {
				$aQuery->the_post();

				global $more;
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
			?>
		</ul>

		<?php
		if ($hasPages && $pageId < $aQuery->max_num_pages) {
			$nextLink = esc_url(get_pagenum_link($pageId + 1));
		?>
			<a href="<?= $nextLink ?>" class="next-link">older posts --&gt;</a>
<?php
		}
		wp_reset_postdata();
	}
}
