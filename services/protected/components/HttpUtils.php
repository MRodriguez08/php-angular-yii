<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HttpUtils
 *
 * @author ubuntu
 */
class HttpUtils {
    
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_HEAD = 'HEAD';
    const METHOD_DELETE = 'DELETE';

    public function isAjaxRequest() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
                || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }
    
    public function getHttpRequestMethod(){
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') !== null)
            return filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        else
            return $_SERVER['REQUEST_METHOD'];
    }
    
    
    
    /**
     * description: Hidrata el array $arguments con la informacion enviada desde el cliente dependiendo del
     * metodo que se trate.
     */
    public function fillArguments() {
        $arguments = array();
        $method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        switch ($method) {
            case HttpUtils::METHOD_GET:
            case HttpUtils::METHOD_HEAD:
                $arguments = $_GET;
                break;
            case HttpUtils::METHOD_POST:
                $json = file_get_contents('php://input');
                $arguments = json_decode($json, true);
                if( $arguments == null)
                {
                    $arguments = $_POST;
                }
                break;
            case HttpUtils::METHOD_PUT:
                break;
            case HttpUtils::METHOD_DELETE:
                parse_str(file_get_contents('php://input'), $arguments);
                break;
        }
        return $arguments;
    }

}
