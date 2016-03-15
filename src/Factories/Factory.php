<?php

abstract class Factory
{
	public function __construct($config = [])
	{

	}

	abstract public static function make($type, $config);
}