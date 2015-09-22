<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 31/08/2015
 * Time: 12:25
 */

namespace Modules\Page;

use Silex\Application;
use Silex\ControllerProviderInterface;

class Page implements ControllerProviderInterface
{

    /**
     * @param Application $app
     * @return mixed
     */
    public function connect(Application $app)
    {
        $this->__autoload();
        // creates a new controller based on the default route
        $routing = $app['controllers_factory'];
        /* Set corresponding endpoints on the controller classes */
        Controllers\Front::addRoutes($routing);
        Controllers\AdminBlog::addRoutes($routing);
        Controllers\Auth::addRoute($routing);
        Controllers\AdminPortfolio::addRoutes($routing);
        Controllers\AdminRepo::addRoute($routing);
        Controllers\Gallery::addRoutes($routing);
        return $routing;
    }


    public function __autoload() {
        require __DIR__ . '/Controllers/Front.php';
        require __DIR__ . '/Controllers/Auth.php';
        require __DIR__ . '/Controllers/AdminPortfolio.php';
        require __DIR__ . '/Controllers/AdminBlog.php';
        require __DIR__ . '/Controllers/AdminRepo.php';
        require __DIR__ . '/Controllers/Gallery.php';
    }
}
