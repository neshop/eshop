<?php

namespace App\Router;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;

class RouterFactory
{
    /**
    * @return Nette\Application\IRouter
    */
    public static function createRouter()
    {
        $router = new RouteList;
        $router[] = new Route(
            'admin/<presenter>/<action>[/<id>]',
            [
                'module' => 'Admin',
                'presenter' => 'Dashboard',
                'action' => 'default',
            ]
        );
        $router[] = new Route(
            'kategorie/<categoryId>',
            [
                'module' => 'Front',
                'presenter' => 'Catalog',
                'action' => 'category',
            ]
        );
        $router[] = new Route(
            'produkt/<productId>',
            [
                'module' => 'Front',
                'presenter' => 'Product',
                'action' => 'detail',
            ]
        );
        $router[] = new Route(
            '<presenter>/<action>[/<id>]',
            [
                'presenter' => 'Homepage',
                'module' => 'Front',
                'action' => 'default',
            ]
        );
        return $router;
    }
}
