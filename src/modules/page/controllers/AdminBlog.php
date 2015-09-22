<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 04/09/2015
 * Time: 20:26
 */

namespace Modules\Page\Controllers;

use Silex\Application;


class AdminBlog
{
    /**
     * @param Application $routing
     */
    public static function addRoutes($routing)
    {
        $routing->get('/admin/blog', array(new self(), 'index'));
        $routing->get('/admin/blogform', array(new self(), 'form'));
    }

    public function index(Application $app)
    {
        return $app['twig']->render('admin-blog-data.twig', array(
            // parameter
        ));
    }

    public function form(Application $app)
    {
        return $app['twig']->render('admin-blog-form.twig', array(
            // parameter
        ));
    }

}