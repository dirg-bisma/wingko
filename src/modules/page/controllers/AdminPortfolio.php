<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 05/09/2015
 * Time: 13:27
 */

namespace Modules\Page\Controllers;

use Silex\Application;


class AdminPortfolio
{

    /**
     * @param Application $routes
     */
    public static function addRoutes($routes)
    {
        $routes->get('/admin/portfolio', array(new self(), 'portfolioIndex'));
    }

    public function portfolioIndex(Application $app)
    {
        return $app['twig']->render('admin-portfolio-data.twig', array());
    }
}