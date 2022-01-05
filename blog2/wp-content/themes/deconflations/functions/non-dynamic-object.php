<?php

namespace dgk;

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
