<?php declare(strict_types=1);

require_once('vendor/autoload.php');

// Load the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Load helpers
require 'helpers/helpers.php';

// Load the database
require 'models/db.php';

// Path of the request
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$methodRequest = $_SERVER['REQUEST_METHOD'];

// Load routes
$router = new Router();
$router->load();
$router->direct($path, $methodRequest);