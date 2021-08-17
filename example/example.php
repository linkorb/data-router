<?php

require_once __DIR__ . '/../vendor/autoload.php';

use LinkORB\Component\DataRouter\Router;
use LinkORB\Component\DataRouter\Route;
use LinkORB\Component\DataRouter\RouteLoader;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('test');
$logger->pushHandler(new StreamHandler('/dev/stdout', Logger::DEBUG));

$alert = [
    'squad' => 'sre',
    'prio' => 2,
    'duration' => 5,
];

$expressionLanguage = new ExpressionLanguage();
$expressionLanguage->register('date', function ($str) {
    null;
}, function ($arguments, $str, $format) {
    if (!$str) {
        throw new RuntimeException("Can't convert null date");
    }
    // echo $str . '!' .PHP_EOL;
    if (is_numeric($str)) {
        $stamp = $str;
    } else {
        $stamp = strtotime($str);
    }
    return date($format, $stamp);
});

$yaml = file_get_contents(__DIR__ . '/test-routes.yaml');

$config = Yaml::parse($yaml);

$loader = new RouteLoader();
$root = $loader->load('root', $config);

$data = [
    'alert' => (object)$alert,
    'now' => date('c'),
];

$router = new Router($expressionLanguage, $logger);
$route = $router->route($root, $data);

if (!$route) {
    echo "No route matched" . PHP_EOL;
} else {
    echo 'Route: ' . $route->getFullName() . PHP_EOL;
    print_r($route->getOutput());
}