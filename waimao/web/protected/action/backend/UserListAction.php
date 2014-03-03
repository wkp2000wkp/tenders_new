<?php
/**
 *
 * @author john_yu
 * @date 2010-11-14
 */
class UserListAction extends APPBaseAction
{
     public function run () {
        $show['table_html'] = $this->getTable($action);
        $this->getController()->renderPartial( "user_list" , $show );
    }
    public function getTable () {
        Yii::app()->tablegear->headers = array(
            
                'id' => '人员编号', 
                'username' => '用户名', 
                'user_type' => '权限级别',
        );
         Yii::app()->tablegear->transform = array(
          "id" => array(
              "tag"   => "input",
              "html"   => "{DATA}",
              "attrib" => array(
                "type" => 'radio',
                "name" => 'id',
                "value" => '{DATA}',
              ),
            ),
        );
        Yii::app()->tablegear->dataTaseTable = 'san_user';
        Yii::app()->tablegear->selects = array("user_type"=>SelectConstent::getSelectUserType());
        Yii::app()->tablegear->form = array('id'=>'ZBForm','method'=>'post','submit'=>'添加');
        $show['table_html'] = Yii::app()->tablegear->getTable();
        $show['table_script_html'] = Yii::app()->tablegear->getJavascript();
        return $this->getController()->renderPartial( "/layouts/project_list" , $show ,true);
    }
    
}