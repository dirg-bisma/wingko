<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 05/09/2015
 * Time: 0:30
 */

namespace Modules\Api\Controllers;

use Silex\Application;
use Modules\Api\Services\PortfolioDb;
use Modules\Api\Services\JsonValidator as JsonValidator;
use Symfony\Component\HttpFoundation\Request;

class Portfolio
{
    /**
     * @param Application $routes
     */
    public static function addRoutes($routes)
    {
        $routes->get('/portfolio/data-all', array(new self(), 'dataAll'));
        $routes->get('/portfolio/data/{limit}', array(new self(), 'data'));
        $routes->get('/portfolio/detail/{name}', array(new self(), 'detail'));
        $routes->post('/portfolio/create', array(new self(), 'create'));
        $routes->put('/portfolio/update/{id}', array(new self(), 'update'));
        $routes->delete('/portfolio/delete/{id}', array(new self(), 'delete'));
    }

    /**
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function dataAll(Application $app)
    {
        $portfolio = PortfolioDb::getPortfolioDataAll($app, '');
        $data =  array('record' => $portfolio);

        return $app->json(array_merge($data));
    }

    /**
     * @param Application $app
     * @param $limit
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function data(Application $app, $limit)
    {
        $portfolio = PortfolioDb::getPortfolioDataAll($app, $limit);
        $data =  array('record' => $portfolio);

        return $app->json(array_merge($data));
    }

    /**
     * @param Application $app
     * @param $name
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function detail(Application $app, $name)
    {
        $portfolio =  PortfolioDb::getPortfolioByName($app, $name);
        if($portfolio){
            return $app->json(array('record' => array($portfolio)));
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
        $schemaPath = realpath(VAR_PATH . DS . 'portfolioSchema.json');
        $data = $jsonValidator->jsonBlogValidator($json, $schemaPath);
        if(is_array($data)){
            PortfolioDb::createPortfolioData($app, $data);
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
        $schemaPath = realpath(VAR_PATH . DS . 'portfolioSchema.json');
        $data = $jsonValidator->jsonBlogValidator($json, $schemaPath);
        if(is_array($data)){
            PortfolioDb::updatePortfolioData($app, $data, $id);
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
    public function deletePortfolio(Application $app, $id)
    {
        $msg = array();
        if(is_int($id)){
            $db = PortfolioDb::deletePortfolioData($app, $id);
            if($db){
                $msg = array('msg' => 'success', 'id' => $id);
            }else{
                $msg = array('msg' => $db);
            }
        }
        return $app->json($msg);
    }
}