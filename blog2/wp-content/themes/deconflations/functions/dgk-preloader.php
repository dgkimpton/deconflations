<?php

namespace dgk;

require_once 'non-dynamic-object.php';

global $post;

final class DgkPreloader extends NonDynamicObject
{
	private $knownPreloads;
	private $prePushed;
	private $toPush;

	function __construct()
	{
		$this->prePushed = isset($_COOKIE["pre-pushed"]) ? explode('<>', $_COOKIE["pre-pushed"]) : [];
		$this->knownPreloads = [];
		$this->toPush = [];
	}

	private function enqueue_preload($uri, $type, $crossOrigin)
	{
		if (in_array($uri, $this->knownPreloads)) {
			return;
		}

		array_push($this->knownPreloads, $uri);

		$push = in_array($uri, $this->prePushed) ? '; nopush' : '';
		$origin = $crossOrigin ? '; crossorigin' : '';

		array_push($this->toPush, 'Link: <' . $uri . '>; as=' . $type . '; rel=preload' . $origin . $push . ';');
	}

	function connect($server)
	{
		array_push($this->toPush, 'Link: <' . $server . '>; rel=preconnect; crossorigin');
	}

	function load_font($fontUri)
	{
		$this->enqueue_preload($fontUri, 'font', true);
	}

	function load_image($imageUri)
	{
		$this->enqueue_preload($imageUri, 'image', false);
	}

	function load_style($styleUri)
	{
		$this->enqueue_preload($styleUri, 'style', false);
	}

	function send_all()
	{
		foreach ($this->toPush as $header) {
			header($header, false);
		}

		$expiryAtNowPlus30Days = time() + 60 * 60 * 24 * 30;
		setcookie("pre-pushed", implode('<>', $this->knownPreloads), $expiryAtNowPlus30Days, "/", $_SERVER['HTTP_HOST'], true, true);
	}
}
