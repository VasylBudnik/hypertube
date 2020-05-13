<?php

namespace App\Core;

class Request
{
	/**
	 * Fetch the request URI.
	 *
	 * @return string
	 */
	public static function uri()
	{
        // Получаем строку запроса
        $query = end(explode("?", $_SERVER['REQUEST_URI']));

        // Вносим её в массив $_GET
        parse_str($query, $_GET);

		return trim(
			parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'
		);
	}

	/**
	 * Fetch the request method.
	 *
	 * @return string
	 */
	public static function method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}
}
