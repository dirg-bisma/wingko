<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 26/08/2015
 * Time: 14:00
 */
namespace Modules\Page\Controllers;

use Silex\Application;

class Front
{
    /**
     * @param Application $routing
     */
    public static function addRoutes($routing)
    {
        $routing->get('/', array(new self(), 'home'));
        $routing->get('/blog/detail/{title}' . '.html', array(new self(), 'blogDetail'));
        $routing->get('/blog', array(new self(), 'blogAll'));
        $routing->get('portfolio', array(new self(), 'portfolioIndex'));
        $routing->get('portfolio/detail/{title}' . '.html', array(new self(), 'portfolioDetail'));
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function home(Application $app)
    {
        return $app['twig']->render('index.twig', array(
            // parameter
        ));
    }

    public function blogDetail(Application $app, $title)
    {
        return $app['twig']->render('blog-detail.twig', array(
            'title' => $title
        ));
    }

    /**
     * @param Application $app
     * @param $title
     * @return mixed
     */
    public function blogAll(Application $app)
    {
        return $app['twig']->render('blog-all.twig', array(
        ));
    }

    public function portfolioIndex(Application $app)
    {
        return $app['twig']->render('portfolio-all.twig', array());
    }

    public function portfolioDetail(Application $app, $title)
    {
        return $app['twig']->render('portfolio-detail.twig', array(
            'title' => $title
        ));
    }
}