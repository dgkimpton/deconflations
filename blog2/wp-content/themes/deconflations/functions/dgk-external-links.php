<?php
function dgk_external_links($content)
{
	$internal_sites = implode('|', array_map(function ($el) {
		return str_replace('.', '\.', $el);
	}, [
		'deconflations.com',
		'www.deconflations.com',
		'192.168.1.2'
	]));

	$interal_regex = '/^(http|https):\/\/(' . $internal_sites . ')/i';

	return preg_replace_callback(
		'/<a .*href="(.*)".*>/iUmS',
		function ($m) use ($interal_regex) {
			$isRelative = strpos($m[1], '/') === 0;
			$isExternal = !$isRelative && !preg_match($interal_regex, $m[1]);

			return $isExternal ? rtrim($m[0], '>') . ' class="offsite">' : $m[0];
		},
		$content
	);
}
