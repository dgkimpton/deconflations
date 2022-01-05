<?php

namespace dgk;

require_once 'non-dynamic-object.php';
require_once 'dgk-wrapped-blog.php';
require_once 'dgk-preloader.php';
require_once 'utils.php';

global $post;


final class DgkWrappedPage extends NonDynamicObject
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
		$this->blog = new DgkWrappedBlog($this->pageId);
		$this->preload = new DgkPreloader();
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
}
