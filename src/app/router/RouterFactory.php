<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


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
