<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 10/09/2015
 * Time: 14:06
 */

namespace Modules\Page\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Gallery
{
    public static function addRoutes($routing)
    {
        $routing->post('/gallery/upload', array(new self(), 'upload'));
        $routing->get('/gallery/browse', array(new self(), 'browse'));
    }

    public function upload(Request $request)
    {
        try{
            $mimes = array(
                'image/gif',
                'image/jpeg', 'image/pjpeg',
                'image/jpeg', 'image/pjpeg',
                'image/png',  'image/x-png'
            );
            $file = $request->files->get('upload');
            $filename = $file->getClientOriginalName();
            if(in_array($file->getMimeType(), $mimes)){
                $file->move(UPLOAD_PATH . '/images/', $filename);
                $this->createThumbnail($filename);
                return $filename . ' success uploaded';
            }else{
                return 'mime :' . $file->getMimeType();
            }


        }catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $e){
            return 'hasil Error :' . $e;
        }

    }

    public function browse(Application $app)
    {
        $files = scandir(UPLOAD_PATH . '/images');
        if(($key = array_search('.', $files)) !== false) {
            unset($files[$key]);
        }
        if(($key = array_search('..', $files)) !== false) {
            unset($files[$key]);
        }
        return $app['twig']->render('gallery-browse.twig', array(
            'files' => $files,
            'path' => $app['asset.host']
        ));
    }

    public function createThumbnail($filename) {

        $final_width_of_image = 100;
        $path_to_image_directory = UPLOAD_PATH . '/images/';
        $path_to_thumbs_directory = UPLOAD_PATH . '/thumb/';
        if(preg_match('/[.](jpg)$/', $filename)) {
            $im = imagecreatefromjpeg($path_to_image_directory . $filename);
        } else if (preg_match('/[.](gif)$/', $filename)) {
            $im = imagecreatefromgif($path_to_image_directory . $filename);
        } else if (preg_match('/[.](png)$/', $filename)) {
            $im = imagecreatefrompng($path_to_image_directory . $filename);
        }

        $ox = imagesx($im);
        $oy = imagesy($im);

        $nx = $final_width_of_image;
        $ny = floor($oy * ($final_width_of_image / $ox));

        $nm = imagecreatetruecolor($nx, $ny);

        imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

        if(!file_exists($path_to_thumbs_directory)) {
            if(!mkdir($path_to_thumbs_directory)) {
                die("There was a problem. Please try again!");
            }
        }

        imagejpeg($nm, $path_to_thumbs_directory . 'thumb-' . $filename);
        return 'success';
    }
}