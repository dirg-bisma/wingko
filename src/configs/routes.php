<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 21/08/2015
 * Time: 22:57
 */


$app->mount('/', new Modules\Page\Page());
$app->mount('/api', new Modules\Api\Api());