<?php
/**
 *
 * @author john_yu
 * @date 2010-9-15
 */
class BackupController extends APPBaseController
{

    public $defaultAction = 'list';
    public function actions () {
        return array(
            
                'list' => 'BackUpListAction', 
                'form' => 'BackUpFormAction', 
                'option' => 'OptionBackUpRecordAction', 
        );
    }
    
    public function getTableName(){
		$tableName = SelectConstent::TABLE_BACKUP;
    	$getTableName = Yii::app()->getRequest()->getParam('table');
		if(in_array($getTableName,array(SelectConstent::TABLE_BACKUP,SelectConstent::TABLE_QUOTE_BACKUP))){
			 $tableName = $getTableName;
		}
		return $tableName;
    }
}

