<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 01/09/2015
 * Time: 15:32
 */

namespace Modules\Api\Services;

use Silex\Application;

class RepoDb
{
    /**
     * @param Application $app
     * @param $paging
     * @return mixed
     */
    static  function getRepoDataAll(Application $app, $paging)
    {
        $sql = "SELECT * FROM repo ORDER BY repo.date_create ASC";
        if($paging != ''){
            $sql .= ' LIMIT ' . $paging;
        }
        $repo = $app['dbs']['local']->fetchAll($sql);
        return $repo;
    }

    /**
     * @param Application $app
     * @param $name
     * @return mixed
     */
    static function getRepoByName(Application $app, $id)
    {
        $whiteSpace = str_replace('-', ' ', $id);
        $sql = "SELECT * FROM post WHERE repo.id_repo = ?";
        $post = $app['dbs']['local']->fetchAssoc($sql, array($whiteSpace));
        return $post;
    }

    static function createRepoData(Application $app, $data)
    {
        $app['dbs']['local']->insert('repo', array(
            'repo_nama' => $data['repo_name'],
            'repo_url' => $data['repo_url'],
            'date_create' => date('Y-m-d H:i:s')
        ));
    }

    static function updateRepoData(Application $app, $id, $data)
    {
        $app['dbs']['local']->update('repo', array(
            'repo_nama' => $data['repo_name'],
            'repo_url' => $data['repo_url'],
            'date_create' => date('Y-m-d H:i:s')
        ), array('id_repo' => $id));
    }

    static function deleteRepoData(Application $app, $id)
    {
        try{
            $app['dbs']['local']->delete('repo', array('id' => $id));
            return true;
        }catch (\ErrorException $error){
            return $error;
        }
    }
}