<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 21/08/2015
 * Time: 22:53
 */

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'dbs.options' => array (
        'local' => array(
            'driver'    => 'pdo_mysql',
            'host'      => '127.0.0.1',
            'dbname'    => 'blog',
            'user'      => 'root',
            'password'  => '',
            'charset'   => 'utf8',
        ),
    ),
));