<?php


namespace Core;

use Core\Exceptions\NotAllowedException;
use Core\Exceptions\NotFoundException;
use Core\Helpers\ArrayHelper;
use Core\Request\Request;

class App
{
    private static $jsFiles = [];

    public static function path($path = ''): string
    {
        return realpath(__DIR__ . '/../app') . ($path ? "/$path" : '');
    }

    public static function publicPath($path = ''): string
    {
        return realpath(__DIR__ . '/../public') . ($path ? "/$path" : '');
    }

    public static function config($path = null)
    {
        $config = require self::path('config.php');

        if (!$path) {
            return $config;
        }

        $config = ArrayHelper::extract($config, $path);

        return $config;
    }

    public static function registerJs(string $file)
    {
        self::$jsFiles[] = $file;
    }

    public static function jsBlock(): string
    {
        return implode("\n", array_map(function ($fileName) {
            return "<script src='$fileName'></script>";
        }, self::$jsFiles));
    }

    public static function run($requestUri, $post, $get, $files) {
        \Core\Session::start();
        $request = new Request($requestUri, $post, $get, $files);
        $route_config = require '../app/routes.php';

        try {
            $router = new Router($route_config, $request);
            $controller = $router->controller();
            if (! $controller || ! method_exists($controller, $router->controllerMethod())) {
                throw new NotFoundException('Route ' . $request->routePath() . ' not found');
            }

            $controller->{$router->controllerMethod()}();

        }
        catch (NotAllowedException $e) {
            header("HTTP/1.0 403 Not Found");
            echo $e->getMessage();
            exit;
        }
        catch (NotFoundException $e) {
            header("HTTP/1.0 404 Not Found");
            echo $e->getMessage();
            exit;
        }
    }
}
