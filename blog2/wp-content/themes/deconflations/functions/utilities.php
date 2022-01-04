<?php
function slashAround($folder, $slash)
{
	if (isset($folder) && $folder != '') {
		return $slash . $folder . $slash;
	}
	return $slash;
}

function dcon_make_relative($uri)
{
	$parts = parse_url($uri);
	$path     = isset($parts['path']) ? $parts['path'] : '';
	$query    = isset($parts['query']) ? '?' . $parts['query'] : '';
	$fragment = isset($parts['fragment']) ? '#' . $parts['fragment'] : '';
	return $path . $query . $fragment;
}

function dcon_get_uri($folder, $name)
{
	$f = get_template_directory() . slashAround($folder,  DIRECTORY_SEPARATOR) . $name;
	if (file_exists($f)) {
		# note the different (non-variable) type of slash - URI's are not folders
		$full_uri = get_template_directory_uri() . slashAround($folder,  '/') . $name;
		return dcon_make_relative($full_uri) . '?v=' . strval(filemtime($f));
	}

	return '??';
}

function dcon_get_image_uri($name)
{
	return dcon_get_uri('images', $name);
}

function dcon_get_style_uri($name)
{
	return dcon_get_uri('css', $name);
}

function dcon_get_script_uri($name)
{
	return dcon_get_uri('js', $name);
}
