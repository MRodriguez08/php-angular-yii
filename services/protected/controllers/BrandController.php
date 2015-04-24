<?php

class BrandController extends RWSController {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function processDelete() {
        
    }

    public function processGet() {
        Response::ok(CJSON::encode(Brand::model()->findAll()));
    }

    public function processHead() {
        
    }

    public function processPost() {
        
    }

    public function processPut() {
        
    }

}
