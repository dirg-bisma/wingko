<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 29/08/2015
 * Time: 21:10
 */

namespace Modules\Api\Services;

use Silex\Application;

class BlogDb
{
     /**
     * @param Application $app
     * @param string $paging
     * @return array mixed
     *
     * return data from post table
     */
    static function getBlogDataAll(Application $app, $paging)
    {
        $sql = "SELECT * FROM blog ORDER BY blog.date_create DESC";
        if($paging != '' | $paging != null){
            $sql .= ' LIMIT ' . $paging;
        }
        $post = $app['dbs']['local']->fetchAll($sql);
        return $post;
    }

    /**
     * @param Application $app
     * @return int $total
     */
    static function allCountBlogData(Application $app)
    {
        $sql = "SELECT id FROM blog";
        $total = $app['dbs']['local']->executeQuery($sql)->rowCount();
        return $total;
    }

    /**
     * @param Application $app
     * @param string $title
     * @return array mixed
     *
     * get data from post table by title field
     */
    static function getBlogByTitle(Application $app, $title)
    {
        $whiteSpace = str_replace('-', ' ',$title);
        $sql = "SELECT * FROM blog WHERE blog.title = ?";
        $post = $app['dbs']['local']->fetchAssoc($sql, array($whiteSpace));
        return $post;
    }

    /**
     * @param Application $app
     * @param array $data
     *
     * create data on post table
     */
    static function createBlogData(Application $app, $data)
    {
        $app['dbs']['local']->insert('blog', array(
            'content' => $data['content'],
            'title' => $data['title'],
            'category' => $data['tags'],
            'date_create' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * @param Application $app
     * @param array $data
     * @param integer $id
     *
     * update data post table
     */
    static function updateBlogData(Application $app, $data, $id)
    {
        $app['dbs']['local']->update('blog', array(
            'content' => $data['content'],
            'title' => $data['title'],
            'category' => $data['tags'],
            'date_update' => date('Y-m-d H:i:s')
        ), array('id' => $id));
    }

    /**
     * @param Application $app
     * @param integer $id
     *
     * delete data from post table
     */
    static function deleteBlogData(Application $app, $id)
    {
        try{
            $app['dbs']['local']->delete('blog', array('id' => $id));
            return true;
        }catch (\ErrorException $error){
            return $error;
        }

    }
}