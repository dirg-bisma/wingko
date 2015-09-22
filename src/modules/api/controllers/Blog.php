<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 26/08/2015
 * Time: 15:52
 */

namespace Modules\Api\Controllers;

use Silex\Application;
use Modules\Api\Services\BlogDb as BlogData;
use Modules\Api\Services\JsonValidator as JsonValidator;
use Symfony\Component\HttpFoundation\Request;

class Blog
{

    /**
     * @param Application $routes
     */
    public static function addRoutes($routes)
    {
        $routes->get('/blog/data-all', array(new self(), 'dataAll'));
        $routes->get('/blog/data/{paging}', array(new self(), 'data'));
        $routes->get('/blog/paging/{limit}/{paging}', array(new self(), 'dataPaging'));
        $routes->get('/blog/detail/{title}', array(new self(), 'detail'));
        $routes->post('/blog/create', array(new self(), 'create'));
        $routes->put('/blog/update/{id}', array(new self(), 'update'));
    }

    /**
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function dataAll(Application $app)
    {
        $blog = BlogData::getBlogDataAll($app, '');
        $data =  array('record' => $blog);

        return $app->json(array_merge($data));
    }

    /**
     * @param Application $app
     * @param int $paging
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function data(Application $app, $limit = 5)
    {
        $blog = BlogData::getBlogDataAll($app, $limit);
        $data =  array('record' => $blog);

        return $app->json(array_merge($data));
    }

    /**
     * @param Application $app
     * @param $limit
     * @param $paging
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function dataPaging(Application $app, $limit, $paging)
    {
        $blog = BlogData::getBlogDataAll($app, $limit . ',' . $paging);
        $total = BlogData::allCountBlogData($app);
        $data = array('record' => $blog, 'total' => $total);

        return $app->json($data);
    }

    /**
     * @param Application $app
     * @param $title
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function detail(Application $app ,$title)
    {
        $blog =  BlogData::getBlogByTitle($app, $title);
        if($blog){
            return $app->json(array('record' => array($blog)));
        }else{
            return $app->json(array('record' => array('false')));
        }

    }


    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, Application $app)
    {
        $json = $request->getContent();
        $blogValidator = new JsonValidator();
        $schemaPath = realpath(VAR_PATH . DS . 'blogSchema.json');
        $data = $blogValidator->jsonBlogValidator($json, $schemaPath);
        if(is_array($data)){
            BlogData::createBlogData($app, $data);
            return $app->json(array('msg' => 'success'))
                ->setStatusCode(201);
        }else{
            return $app->json(array('msg' => $data));
        }
    }

    /**
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, Application $app, $id)
    {
        $json = $request->getContent();
        $jsonValidator = new JsonValidator();
        $schemaPath = realpath(VAR_PATH . DS . 'blogSchema.json');
        $data = $jsonValidator->jsonBlogValidator($json, $schemaPath);
        if(is_array($data)){
            BlogData::updateBlogData($app, $data, $id);
            return $app->json(array('msg' => 'success'))
                ->setStatusCode(201);
        }else{
            return $app->json(array('msg' => $data));
        }

    }

    /**
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deletePost(Application $app, $id)
    {
        $msg = array();
        if(is_int($id)){
            $db = BlogData::deleteBlogData($app, $id);
            if($db){
                $msg = array('msg' => 'success', 'id' => $id);
            }else{
                $msg = array('msg' => $db);
            }
        }
        return $app->json($msg);
    }

}