<?php

define('APP_ROOT', __DIR__);

require dirname(APP_ROOT) . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

use Magma\Core\Application;
use Magma\Routing\Dispatcher;
use Magma\Http\Request;
use Magma\ORM\Database;

Database::connect([
    "driver"   => $_ENV['DB_DRIVER'] ?? "mysql",
    "host"     => $_ENV['DB_HOST'] ?? "localhost",
    "username" => $_ENV['DB_USER'] ?? "root",
    "password" => $_ENV['DB_PASS'] ?? "",
    "database" => $_ENV['DB_NAME'] ?? "magma",
    "port"     => (int) ($_ENV['DB_PORT'] ?? 3306),
    "charset"  => $_ENV['DB_CHARSET'] ?? "utf8mb4"
]);

$router = Application::run();

$request = Request::fromGlobals();

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = $_SERVER['REQUEST_URI'] ?? '/';

$match = $router->match($method, $uri);

if ($match === null) {
    http_response_code(404);
    echo '404 - Page Not Found';
    exit;
}

$dispatcher = new Dispatcher();
$dispatcher->dispatch($match, $request);
