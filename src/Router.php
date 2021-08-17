<?php

namespace LinkORB\Component\DataRouter;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use RuntimeException;
use Psr\Log\LoggerInterface;

class Router
{
    public function __construct(ExpressionLanguage $expressionLanguage, LoggerInterface $logger)
    {
        $this->expressionLanguage = $expressionLanguage;
        $this->logger = $logger;
    }

    protected $routes = [];

    public function route(Route $route, array $data): ?Route
    {
        foreach ($route->getRoutes() as $route) {
            $this->logger->debug('Evaluating ' . $route->getFullName());
            $res = true;
            if ($route->getExpression()) {
                try {
                    $res = $this->expressionLanguage->evaluate($route->getExpression(), $data);
                } catch (\Exception $e) {
                    // print_r($e);
                    $error = "Failed to evaluate route expression `" . $route->getFullName() . '`';
                    $this->logger->error($error);
                    throw new RuntimeException($error);
                }
            }
            if ($res==true) {
                $this->logger->debug(' * true');
                if ($route->hasRoutes()) {
                    return $this->route($route, $data);
                } else {
                    return $route;
                }
            } else {
                $this->logger->debug(' * false');
            }
        }
        $this->logger->debug('No route matched');
        return null;
    }
}