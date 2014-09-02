<?php

namespace App;

use Nette\Application\Routers\RouteList,
  Nette\Application\Routers\Route;


/**
 * Router factory.
 */
class RouterFactory
{

  /**
   * @return \Nette\Application\IRouter
   */
  public function createRouter()
  {
    $router = new RouteList();
    $router[] = new Route('<zakaznik>', 'Mrazak:default');
    $router[] = new Route('<presenter>/<action>', 'Mrazak:default');
    return $router;
  }

}
