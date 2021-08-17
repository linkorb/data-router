<?php

namespace LinkORB\Component\DataRouter;

class Route
{
    protected $name;
    protected $parent = null;
    protected $expression = null;
    protected $output = null;
    protected $routes = [];
    
    
    public function __construct(string $name, ?string $expression = null, ?array $output = null)
    {
        $this->name = $name;
        $this->expression = $expression;
        $this->output = $output;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getExpression(): ?string
    {
        return $this->expression;
    }

    public function getOutput(): ?array
    {
        return $this->output;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function hasRoutes(): bool
    {
        return count($this->routes)>0;
    }

    public function addRoute(Route $route)
    {
        $this->routes[$route->getName()] = $route;
        $route->setParent($this);
    }

    public function setParent(Route $parent): void
    {
        $this->parent = $parent;
    }

    public function getParent(): ?Route
    {
        return $this->parent;
    }

    public function getFullName(): string
    {
        $name = $this->getName();
        if ($this->parent) {
            $name = $this->parent->getFullName() . '/' . $name;
        }
        return $name;
    }
}