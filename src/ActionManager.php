<?php

namespace Kiri\Router;

class ActionManager
{


	private static array $array = [];


	/**
	 * @param string $class
	 * @param string $method
	 * @param Handler $handler
	 * @return void
	 */
	public static function add(string $class, string $method, Handler $handler): void
	{
		if (!isset(static::$array[$class])) {
			static::$array[$class] = [$method => []];
		}
		static::$array[$class][$method] = $handler;
	}


	/**
	 * @param string $class
	 * @param string $method
	 * @return array|null
	 */
	public static function get(string $class, string $method): ?Handler
	{
		if (isset(static::$array[$class])) {
			return static::$array[$class][$method] ?? null;
		}
		return null;
	}


}
