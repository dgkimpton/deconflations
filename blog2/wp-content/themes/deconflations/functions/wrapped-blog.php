<?php

namespace dgk;

require_once 'non-dynamic-object.php';
require_once 'utils.php';
require_once 'tab.php';

final class WrappedBlog extends NonDynamicObject
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
			return new Tab(
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
