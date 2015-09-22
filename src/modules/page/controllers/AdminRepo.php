<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 05/09/2015
 * Time: 14:45
 */

namespace Modules\Page\Controllers;

use Silex\Application;

class AdminRepo
{
    /**
     * @param Application $routes
     */
    public static function addRoute($routes)
    {
        $routes->get('/admin/repo', array(new self(), 'index'));
    }

    public function index(Application $app)
    {
        return $app['twig']->render('admin-repo-data.twig', array());
    }

}