<?php

namespace dgk;

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
