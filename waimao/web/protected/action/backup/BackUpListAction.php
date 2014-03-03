<?php
/**
 *
 * @author john_yu
 * @date 2010-11-13
 */
class BackUpListAction extends APPBaseAction
{
	public function run () {
		$tableName = $this->getController()->getTableName();
        $show['table_name'] = $tableName;
        $show['table_html'] = $this->getTable($tableName);
        $this->getController()->renderPartial( "backup_list" , $show );
    }
    public function getTable ($tableName) {
        Yii::app()->tablegear->headers = SelectConstent::getBackUpHeaders();
        $title = '历史投标';
        if($tableName == SelectConstent::TABLE_QUOTE_BACKUP){
	        $title = '历史报价';
        }
        Yii::app()->tablegear->form = array('id'=>'ZBForm','method'=>'post');
        Yii::app()->tablegear->custom = array("FORM_TOP" => array( "tag"   => "h3", "html"   => $title));
        Yii::app()->tablegear->dataTaseTable = $tableName;
        $sql = $this->getSqlSelect($tableName,array_keys(Yii::app()->tablegear->getTableGearTool()->headers));
        Yii::app()->tablegear->getTableGearTool()->pagination = array();
        $backUpList = Yii::app()->tablegear->getTableGearTool()->fetchData($sql);
        $show['table_html'] = Yii::app()->tablegear->getTable();
        $show['table_script_html'] = Yii::app()->tablegear->getJavascript();
        return $this->getController()->renderPartial( "/layouts/project_list" , $show ,true);
    }
}