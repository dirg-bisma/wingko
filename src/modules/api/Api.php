<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 31/08/2015
 * Time: 12:25
 */

namespace Modules\Api;

use Silex\Application;
use Silex\ControllerProviderInterface;

class Api  implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $this->__autoload();
        // creates a new controller based on the default route
        $routing = $app['controllers_factory'];
        /* Set corresponding endpoints on the controller classes */
        Controllers\Blog::addRoutes($routing);
        Controllers\Portfolio::addRoutes($routing);
        Controllers\Repo::addRoutes($routing);

        return $routing;
    }

    static public function __autoload() {
        require __DIR__ . '/Controllers/Blog.php';
        require __DIR__ . '/Controllers/Portfolio.php';
        require __DIR__ . '/Controllers/Repo.php';
        require __DIR__ . '/Services/BlogDb.php';
        require __DIR__ . '/Services/PortfolioDb.php';
        require __DIR__ . '/Services/RepoDb.php';
        require __DIR__ . '/Services/JsonValidator.php';
    }
}
