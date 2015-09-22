<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 04/09/2015
 * Time: 21:41
 */

namespace Modules\Api\Services;

use Silex\Application;

class PortfolioDb
{
    /**
     * @param Application $app
     * @param $paging
     * @return mixed
     */
    static function getPortfolioDataAll(Application $app, $paging)
    {
        $sql = "SELECT * FROM portfolio ORDER BY portfolio.date_create ASC";
        if($paging != ''){
            $sql .= ' LIMIT ' . $paging;
        }
        $portfolio = $app['dbs']['local']->fetchAll($sql);
        return $portfolio;

    }

    /**
     * @param Application $app
     * @param $name
     * @return mixed
     */
    static function getPortfolioByName(Application $app, $name)
    {
        $whiteSpace = str_replace('-', ' ', $name);
        $sql = "SELECT * FROM portfolio WHERE portfolio.name_portfolio = ?";
        $post = $app['dbs']['local']->fetchAssoc($sql, array($whiteSpace));
        return $post;
    }

    /**
     * @param Application $app
     * @param $data
     */
    static function createPortfolioData(Application $app, $data)
    {
        $app['dbs']['local']->insert('portfolio', array(
            'name_portfolio' => $data['name_portfolio'],
            'content_portfolio' => $data['content_portfolio'],
            'tags' => $data['tags'],
            'date_start' => $data['date_start'],
            'date_end' => $data['date_end'],
            'date_create' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * @param Application $app
     * @param $id
     * @param $data
     */
    static function updatePortfolioData(Application $app, $id, $data)
    {
        $app['dbs']['local']->update('portfolio', array(
            'name_portfolio' => $data['name_portfolio'],
            'content_portfolio' => $data['content_portfolio'],
            'tags' => $data['tags'],
            'date_start' => $data['date_start'],
            'date_end' => $data['date_end'],
            'date_create' => date('Y-m-d H:i:s')
        ), array('id_portfolio' => $id));
    }

    /**
     * @param Application $app
     * @param $id
     * @return bool|\ErrorException|\Exception
     */
    static function deletePortfolioData(Application $app, $id)
    {
        try{
            $app['dbs']['local']->delete('portfolio', array('id_portfolio' => $id));
            return true;
        }catch (\ErrorException $error){
            return $error;
        }
    }
}