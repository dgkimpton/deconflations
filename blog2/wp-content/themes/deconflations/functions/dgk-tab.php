<?php

namespace dgk;

require_once 'non-dynamic-object.php';

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
