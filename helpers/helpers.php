<?php

if (!function_exists('view')) {
    function view($view, $data = [])
    {
        $view = str_replace('.', '/', $view);
        extract($data);
        require "views/{$view}.php";
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url)
    {
        header("Location: /{$url}");
    }
}

if (!function_exists('dd')) {
    function dd($data)
    {
        echo '<pre>';
        die(var_dump($data));
        echo '</pre>';
    }
}

if (!function_exists('view_path')) {
    function view_path($path)
    {
        return $_SERVER['DOCUMENT_ROOT'] . "/views/{$path}";
    }
}
