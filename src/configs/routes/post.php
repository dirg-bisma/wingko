<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 26/08/2015
 * Time: 15:52
 */

$app->get('/api/post/data-all', 'Api\\Controllers\Post::dataAll');
$app->get('/api/post/data/{paging}', 'Api\\Controllers\Post::data');
$app->get('/api/post/detail/{title}', 'Api\\Controllers\Post::detail');
$app->post('/api/post/create', 'Api\\Controllers\Post::create');
$app->put('/api/post/update/{id}', 'Api\\Controllers\\Post::update');