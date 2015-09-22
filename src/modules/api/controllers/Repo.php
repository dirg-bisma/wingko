<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 01/09/2015
 * Time: 15:23
 */

namespace Modules\Api\Controllers;

use Silex\Application;
use Modules\Api\Services\RepoDb;
use Modules\Api\Services\JsonValidator;
use Symfony\Component\HttpFoundation\Request;

class Repo
{

    /**
     * @param Application $routes
     */
    public static function addRoutes($routes)
    {
        $routes->get('/repo/data-all', array(new self(), 'dataAll'));
        $routes->get('/repo/data/{paging}', array(new self(), 'data'));
        $routes->get('/repo/detail/{id}', array(new self(), 'detail'));
        $routes->post('/repo/create', array(new self(), 'create'));
        $routes->put('/repo/update/{id}', array(new self(), 'update'));
        $routes->delete('/repo/delete/{id}', array(new self(), 'delete'));
    }

    /**
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function dataAll(Application $app)
    {
        $repo = RepoDb::getRepoDataAll($app, '');
        $data =  array('record' => $repo);

        return $app->json(array_merge($data));
    }

    /**
     * @param Application $app
     * @param $limit
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function data(Application $app, $limit)
    {
        $repo = RepoDb::getRepoDataAll($app, $limit);
        $data =  array('record' => $repo);

        return $app->json(array_merge($data));
    }

    /**
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function detail(Application $app, $id)
    {
        $repo =  RepoDb::getRepoByName($app, $id);
        if($repo){
            return $app->json(array('record' => array($repo)));
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
        $jsonValidator = new JsonValidator();
        $schemaPath = realpath(VAR_PATH . DS . 'repoSchema.json');
        $data = $jsonValidator->jsonBlogValidator($json, $schemaPath);
        if(is_array($data)){
            RepoDb::createRepoData($app, $data);
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
        $schemaPath = realpath(VAR_PATH . DS . 'repoSchema.json');
        $data = $jsonValidator->jsonBlogValidator($json, $schemaPath);
        if(is_array($data)){
            RepoDb::updateRepoData($app, $data, $id);
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
    public function deleteRepo(Application $app, $id)
    {
        $msg = array();
        if(is_int($id)){
            $db = RepoDb::deleteRepoData($app, $id);
            if($db){
                $msg = array('msg' => 'success', 'id' => $id);
            }else{
                $msg = array('msg' => $db);
            }
        }
        return $app->json($msg);
    }
}