<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 21/08/2015
 * Time: 22:53
 */
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../template',
    'http_cache.cache_dir' => VAR_PATH . '/cache/',
));
$app['debug'] = true;
$app['asset.host'] = 'http://silexblog.dev/';