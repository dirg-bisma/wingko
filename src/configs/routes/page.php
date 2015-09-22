<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 26/08/2015
 * Time: 15:51
 */
//require __DIR__ . '/../../src/page/controllers/Page.php';
use Page\Controllers\Page;
$app->get('/', 'Page\\Controllers\Page::index');
$app->get('/blog/detail/{title}', 'Page\\Controllers\Page::blogDetail');
$app->get('/blog/form/create', 'Page\\Controllers\Page::blogCreate');
$app->get('/test/{id}',function($id) use ($app){
    $sql = "SELECT * FROM post WHERE post.id = ?";
    $post = $app['dbs']['local']->fetchAssoc($sql, array((int) $id));

    return $post['content'];
});