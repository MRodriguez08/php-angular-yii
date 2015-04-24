<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
abstract class RWSController extends CController
{    
        
    protected $arguments;
    protected $httpMethod;
    
    public function __construct() {
        $this->actionProcessRequest();
    }  
    
    /**
     * description: Hidrata el array $arguments con la informacion enviada desde el cliente dependiendo del
     * metodo que se trate.
     */
    public function actionProcessRequest() {
        $hU = new HttpUtils();
        $this->httpMethod = $hU->getHttpRequestMethod();        
        switch ($this->httpMethod) {            
            case HttpUtils::METHOD_GET:
                $this->arguments = $_GET;
                $this->processGet(); 
                break;
            case HttpUtils::METHOD_HEAD:
                $this->arguments = $_GET;                
                $this->processHead();                
                break;
            case HttpUtils::METHOD_POST:
                $json = file_get_contents('php://input');
                $this->arguments = CJSON::decode($json);
                if( $this->arguments == null)
                    $this->arguments = $_POST;
                $this->processPost();
                break;
            case HttpUtils::METHOD_PUT:
                $this->processPut();
                break;
            case HttpUtils::METHOD_DELETE:
                parse_str(file_get_contents('php://input'), $this->arguments);
                $this->processDelete();
                break;
        }
    }

    /**
     * Function that is executed on GET HTTP Method
     */
    abstract function processGet();
    
    /**
     * Function that is executed on POST HTTP Method
     */
    abstract function processPost();
    
    /**
     * Function that is executed on DELETE HTTP Method
     */
    abstract function processDelete();
    
    /**
     * Function that is executed on PUT HTTP Method
     */
    abstract function processPut();
    
    /**
     * Function that is executed on HEAD HTTP Method
     */
    abstract function processHead();
    
}