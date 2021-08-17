<?php

namespace LinkORB\Component\DataRouter;

class RouteLoader
{
    public function load(string $name, array $config)
    {
        $route = new Route($name, $config['expression'] ?? null, $config['output'] ?? null);

        foreach (($config['routes'] ?? []) as $routeName => $routeConfig) {
            $route->addRoute($this->load($routeName, $routeConfig));
        }
        return $route;
    }

}