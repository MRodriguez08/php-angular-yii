<?php
/**
 * AssetsHelper creates the necesary assets include tags (css and js)
 */

/**
 * Description of AssetsHelper
 *
 * @author mauricio
 */
class AssetsHelper {
   
    
    public function getCssIncludes(){
        $out = "";
        if (Yii::app()->params["debugMode"] === false){ 
            $out = "<link rel='stylesheet' href='" . Yii::app()->request->baseUrl. "/css/styles.css' >";
        } else { 
            foreach (Yii::app()->params["styles"] as $s){
                $out .= $this->getCssTag($s);        
            }
        }
        return $out;
    }
    
    public function getjsIncludes(){
        $out = "";
        if (Yii::app()->params["debugMode"] === false){ 
            $out = "<script src='" . Yii::app()->request->baseUrl . "/assets/js/scripts.css'></script>";
        } else { 
            foreach (Yii::app()->params["scripts"] as $s){
                $out .= $this->getJsTag($s);
            }
        }
        return $out;
    }   
    
    private function getCssTag($s){
        if ($s["local"] !== null){
            return "<link rel='stylesheet' href='" . Yii::app()->request->baseUrl . "/" . $s["local"] . "'>";
        } else {
            return "<link rel='stylesheet' href='" . $s["cdn"] . "'>";
        }
    }
    
    /**
     * Get a resource node as parameter and return the <script> tag with the local fallback (if possible).
     * Creates a include with local fallback.
     * @param type $r
     * @return type
     */
    private function getJsTag($r){
        $out = "";        
        if ($r["cdn"] !== null){
            //if i have a cdn set, return the script with local fallback
            $out .= "<script src='" . $r["cdn"] . "'></script><script>window." . $r["fn"] . " || document.write('<script src=\"". Yii::app()->request->baseUrl . "/" . $r["local"] . "\"><\/script>')</script>";
        } else {
            //if I don't... just local
            $out = "<script src=\"" . Yii::app()->request->baseUrl . "/" . $r["local"] . "\"></script>";        
        }
        return $out;
    }
    
}
