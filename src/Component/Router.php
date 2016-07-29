<?php

namespace App\Component;


use App\Controller\DefaultController;


class Router
{
    const REQUIRED_PARAMETER = 'Параметр %s для метода %s::%s является обязательным.';
    const UNDEFINED_METHOD = 'Данный метод %s::%s не опрелен.';
    const METHOD_ACCESS = 'Данный метод %s::%s (%s) должен быть глобально доступен.';
    const UNDEFINED_ROUTE = 'Адрес не найден.';
    const CLASS_EXISTS = 'Указанный класс %s отсутствует.';

    protected static $currentRoute = null;
    protected static $routes = [];

    public static function setRoutes($routes)
    {
        self::$routes = $routes;
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public static function setCurrentRoute($route)
    {
        self::$currentRoute = $route;
    }

    public static function getCurrentRoute()
    {
        return self::$currentRoute;
    }

    public static function handle()
    {
        $response = null;
        try {
            foreach (self::getRoutes() as $key => $route) {
                $pattern = "#^{$route['pattern']}$#";
                // '#^' . $route['pattern'] . '$#'
                // sprintf('#^%s$#', $route['pattern']);

                if (preg_match($pattern, $_SERVER['REQUEST_URI'], $array)) {
                    self::setCurrentRoute($key);
                    $controllerName = $route['controller'];
                    $methodName = "{$route['action']}Action";
                    // $route['action'] . 'Action'
                    // sprintf('%s%s', $route['pattern'], 'Action');

                    if (false === class_exists($controllerName)) {
                        throw new \Exception(
                            sprintf(
                                self::CLASS_EXISTS,
                                $controllerName
                            )
                        );
                    }

                    $reflectionClass = new \ReflectionClass($controllerName);
                    $controller = $reflectionClass->newInstance();

                    // if (false === $reflectionClass->isUserDefined()) {}

                    if ($reflectionClass->hasMethod($methodName)) {
                        $reflectionMethod = $reflectionClass->getMethod($methodName);

                        if (false === $reflectionMethod->isPublic()) {
                            throw new \Exception(
                                sprintf(
                                    self::METHOD_ACCESS,
                                    $controllerName,
                                    $methodName,
                                    \Reflection::getModifierNames($reflectionMethod->getModifiers())
                                )
                            );
                        }

                        $methodArgs = [];
                        $args = $reflectionMethod->getParameters();
                        foreach ($args as $arg) {
                            $argName = $arg->getName();
                            if ((isset($array[$argName]) && !empty($array[$argName])) || $arg->isOptional()) {
                                $methodArgs[$argName] = $array[$argName];
                            } else {
                                throw new \Exception(
                                    sprintf(
                                        self::REQUIRED_PARAMETER,
                                        $argName,
                                        $controllerName,
                                        $methodName
                                    )
                                );
                            }
                        }

                        $response = $reflectionMethod->invokeArgs($controller, $methodArgs);
                    } else {
                        throw new \Exception(
                            sprintf(
                                self::UNDEFINED_METHOD,
                                $controllerName,
                                $methodName
                            )
                        );
                    }

                    break; // Маршрут найден. Прекратить поиски.
                }
            }

            if (null === $response) {
                throw new \Exception(self::UNDEFINED_ROUTE);
            }

        } catch (\Exception $e) {
            $controller = new DefaultController;
            $response = $controller->defaultAction($e->getMessage());
        }

        return $response;
    }

/*    public static function path($uri, $args)
    {
        // Шаблон адреса в виде: /path/id{id}/page{page}/{?sorting}
        // Подстановка нужных данных и т.д.

        $result = '';
        $currentRoute = [];

        $routes = self::getRoutes();

        try {
            if (isset($routes[$uri])) {
                $currentRoute = [$uri => $routes[$uri]];
            } else {
                throw new \Exception(self::UNDEFINED_ROUTE);
            }

            if (preg_match($pattern, )) {
                ;
            }
        } catch (\Exception $e) {
            $result = $routes['default']['pattern'];
        }

        return $result;
    }*/
}
