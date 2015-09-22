<?php
/**
 * Created by PhpStorm.
 * User: dirg
 * Date: 02/09/2015
 * Time: 15:23
 */

namespace Modules\Api\Services;


use JsonSchema\Validator;
use JsonSchema\Uri\UriRetriever;

class JsonValidator
{

    /**
     * @param $json
     * @return string
     */
    public function JsonBlogValidator($json , $schemaPath)
    {
        $validator = new Validator();
        $retriever = new UriRetriever();

        $schema = $retriever->retrieve("file://" . $schemaPath);

        $refResolver = new \JsonSchema\RefResolver($retriever);
        $refResolver->resolve($schema, 'file://' . __DIR__);

        $validator->check(json_decode($json), $schema);


        if($validator->isValid()){
            return json_decode($json, true);
        }else{
            $msg = "";
            foreach($validator->getErrors() as $error){
               $msg .= sprintf("[%s] %s" . " \n", $error['property'], $error['message']);
            }
            return $msg;
        }
    }

}