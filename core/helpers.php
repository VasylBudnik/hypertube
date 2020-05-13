<?php

/**
 * Require a view.
 *
 * @param  string $name
 * @param  array  $data
 *
 * @return views
 */
function view($name, $data = [])
{
	extract($data);

	return require "app/views/{$name}.view.php";
}

/**
 * Redirect to a new page.
 *
 * @param  string $path
 */
function redirect($path)
{
	header("Location: /{$path}");
}

function checkLanguage()
{
    if ($_SESSION["lang"] == 'rus') {
        return false;
    }
    return true;
}