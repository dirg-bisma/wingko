<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 04/09/2015
 * Time: 15:48
 */

namespace Modules\Page\Controllers;

use Silex\Application;

class Auth
{

    /**
     * @param Application $routes
     */
    public static function addRoute($routes)
    {
        $routes->get('login', array(new self(), 'loginPage'));
    }

    public function loginPage(Application $app)
    {
        return $app['twig']->render('login.twig', array());
    }

}