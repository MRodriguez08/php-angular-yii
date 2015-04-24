<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IFileSystem
 *
 * @author mauricio
 */
interface IFileSystem {
    
    public function createFile($filePath, $rights = 755);
    
    public function deleteFile($filePath);
    
    public function readFile($filePath);
    
    public function copyFile($srcFilePath, $dstFilePath);
    
}
