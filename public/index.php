<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 19/08/2015
 * Time: 15:32
 */
defined('APP_NAME')    || define('APP_NAME', 'BlogApi');
defined('APP_VERSION') || define('APP_VERSION', '1.0');

defined('DS') || define('DS', DIRECTORY_SEPARATOR);

defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(__DIR__ . DS . '..' . DS . 'src'));

defined('APPLICATION_ENV')  || define('APPLICATION_ENV', 'production');
defined('CONFIG_PATH')      || define('CONFIG_PATH', realpath(APPLICATION_PATH . DS . 'configs'));
defined('MODULE_PATH')      || define('MODULE_PATH', APPLICATION_PATH . DS . 'Modules');
defined('TEMPLATE_PATH')    || define('TEMPLATE_PATH', realpath(APPLICATION_PATH . DS . 'template'));
defined('VAR_PATH')         || define('VAR_PATH', realpath(APPLICATION_PATH . DS . 'var'));
defined('PUBLIC_PATH')      || define('PUBLIC_PATH', realpath(__DIR__));
defined('LIB_PATH')         || define('LIB_PATH', realpath(__DIR__ . DS . '..' . DS . 'vendor'));
defined('UPLOAD_PATH')      || define('UPLOAD_PATH', realpath(__DIR__ . DS . 'upload'));


$app = require LIB_PATH . DS . 'autoload.php';

$app = new Silex\Application();
/**
 * app config
 */
require CONFIG_PATH . DS . 'app.php';

/**
 * database config
 */
require CONFIG_PATH . DS . 'database.php';

include MODULE_PATH . DS . 'Page/Page.php';
include MODULE_PATH . DS . 'Api/Api.php';

/**
 * route app
 */
require CONFIG_PATH . DS . 'routes.php';

$app->run();