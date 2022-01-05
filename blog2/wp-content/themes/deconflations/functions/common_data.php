<?php

namespace dgk;

global $dgk, $post;

function merge_title_elements($elements)
{
	return implode(" | ", $elements);
}

function slashAround($folder, $slash)
{
	if (isset($folder) && $folder != '') {
		return $slash . $folder . $slash;
	}
	return $slash;
}

function make_relative($uri)
{
	$parts = parse_url($uri);
	$path     = isset($parts['path']) ? $parts['path'] : '';
	$query    = isset($parts['query']) ? '?' . $parts['query'] : '';
	$fragment = isset($parts['fragment']) ? '#' . $parts['fragment'] : '';
	return $path . $query . $fragment;
}

function make_page_permalink($page)
{
	return make_relative(get_permalink($page));
}

class NonDynamicObject
{
	public function __set($name, $value)
	{
		throw new \Exception("Cannot add new property \$$name to instance of " . __CLASS__);
	}
	public function __get($name)
	{
		throw new \Exception($name . ' does not exist in foo');
	}
}

final class DgkTab extends NonDynamicObject
{
	public $displayText;
	public $link;
	public $isCurrent;
	public $id;

	function __construct($id, $text, $link, $current)
	{
		$this->displayText = $text;
		$this->link = $link;
		$this->isCurrent = $current;
		$this->id = $id;
	}
}

final class DgkWrappedBlog extends NonDynamicObject
{
	public $name;
	public $language;
	public $charset;
	public $url;
	public $tagline;
	public $tabs;

	function __construct($currentPageId)
	{
		$this->name = get_bloginfo('name');
		$this->language = get_bloginfo('language');
		$this->url = home_url();
		$this->charset = get_bloginfo('charset');

		$makeTab = function ($topLevelPage) use ($currentPageId) {
			return new DgkTab(
				$topLevelPage->ID,
				$topLevelPage->post_title,
				make_page_permalink($topLevelPage),
				($currentPageId == $topLevelPage->ID)
			);
		};

		$this->tabs = array_map(
			$makeTab,
			get_pages([
				'sort_column' => 'menu_order',
				'child_of'  => 0,
				'parent' => 0,
				'hierarchical' => false
			])
		);

		$this->tagline = get_bloginfo('description');
	}
}


final class DgkWrappedPage extends NonDynamicObject
{
	public $blog;

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

	function get_uri($folder, $name)
	{
		$f = get_template_directory() . slashAround($folder,  DIRECTORY_SEPARATOR) . $name;
		if (file_exists($f)) {
			# note the different (non-variable) type of slash - URI's are not folders
			$full_uri = get_template_directory_uri() . slashAround($folder,  '/') . $name;
			return make_relative($full_uri) . '?v=' . strval(filemtime($f));
		}

		return '??';
	}

	function get_image_uri($name)
	{
		return $this->get_uri('images', $name);
	}

	function get_style_uri($name)
	{
		return $this->get_uri('css', $name);
	}

	function get_script_uri($name)
	{
		return $this->get_uri('js', $name);
	}
}

$dgk = new DgkWrappedPage();
