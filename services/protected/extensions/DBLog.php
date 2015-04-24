<?php

class DBLog extends CDbLogRoute
{
    const LOG_LEVEL_ERROR = "error";
    const LOG_LEVEL_WARNING = "warning";
    const LOG_LEVEL_INFO = "info";
    const LOG_LEVEL_TRACE = "trace";
 
    protected function createLogTable($db,$tableName)
    {
        /*
        $db->createCommand()->createTable($tableName, array(
            'id'=>'INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'level'=>'varchar(128)',
            'category'=>'varchar(128)',
            'logtime'=>'datetime', 
            'user_ip'=>'varchar(50)',
            'user_name'=>'varchar(50)',
            'request_url'=>'text',
            'message'=>'text',
        ));
        */
    }
    protected function processLogs($logs)
    {
        $command=$this->getDbConnection()->createCommand();
        $logTime=date('Y-m-d H:i:s');
 
        foreach($logs as $log)
        {
            $command->insert($this->logTableName,array(
                'level'=>$log[1],
                'category'=>$log[2],
                'logtime'=>$logTime,
                'user_ip'=> Yii::app()->request->userHostAddress,
                'user_name'=>Yii::app()->user->id ,
                'request_url'=>Yii::app()->request->url,
                'message'=>$log[0]
            ));
        }
    }
 
}
