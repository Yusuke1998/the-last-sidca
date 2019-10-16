<?php 

/**
 * Todo lo necesario para los menus del sidebar
 **/

class Sidebar
{
	public static function here($urls)
	{
		foreach ($urls as $url) {
			if (request()->is($url))return"open";
		}
	}

	public static function preload_here($urls)
	{
		foreach ($urls as $url) {
			if (request()->is("precarga/".$url))return"open";
		}
	}

	public static function movement_here($urls)
	{
		foreach ($urls as $url) {
			if (request()->is("movimiento/".$url))return"open";
		}
	}
}