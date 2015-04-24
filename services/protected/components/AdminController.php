<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AdminController extends CController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/adminMasterPage';
    
    /**
     * Set error state to operation
     * @var type boolean
     */
    public $hasError;
    
    /**
     * Set error message in case of error
     * @var type string
     */
    public $errorMessage;

    /**
     * Set error message in case of error
     * @var type string
     */
    public $errorFields = array();
    
    /**
     * Object to log events in the audir database table
     * @var type Audit
     */
    protected $audit;

    
    /**
     * Object create necesary assets imports.
     * @var type AssetsHelper (extension)
     */
    protected $assetsHelper;
    
    protected function setCustomError($message){
        $this->hasError = true; 
        $this->errorMessage = $message;
    }
    
    protected function initController() {
        $this->audit = new Audit;
        $this->assetsHelper = new AssetsHelper();
    }

}
