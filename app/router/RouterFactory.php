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
    $router[] = new Route('<uziv [a-zA-Z]{3}>', 'Mrazak:nabidka');
    $router[] = new Route('<action>', 'Mrazak:default');
    return $router;
  }

}
