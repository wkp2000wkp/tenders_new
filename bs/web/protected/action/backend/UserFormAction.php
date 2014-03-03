<?php
/**
 *
 * @author john_yu
 * @date 2010-11-13
 */
class UserFormAction extends APPBaseAction
{

    public function run () {
        $show = array();
        $action = $this->getParam('action','insert');
        $id = $this->getParamForAbsIntval('id',0);
        $show['form_info'] = $this->getFormInfo($action);
        if(!$id && $action=='update'){
            $id = $this->getUid();
	        $show['form_info'] = $this->getUserFormInfo($action);
        }
        $show['action'] = $action;
        $show['data'] = array();
        if($action == 'update'){
	        if($id){
	            $show['data'] = $this->getData($id);
	        }else{
	            Yii::app()->showbox->showMessageBox( 'no_data_submit' , '-1' );
	        }
        }
        $this->getController()->render( "/layouts/publish_form" , $show );
    }
    
    private function getData($id){
        $list = array();
        if($id){
          Yii::app()->tablegear->dataTaseTable = SelectConstent::TABLE_USER;
          $sql = 'SELECT * FROM '.SelectConstent::TABLE_USER.' WHERE id='.$id.' limit 1';
          $list = Yii::app()->tablegear->getTableGearTool()->query($sql);
        }
        $this->checkPermissions( $list[0]['id']);
        return $list[0];
    }
    
    private function getFormInfo($action){
        return array(
            'title'=>'用户信息',
            'backurl'=> URL_DOMAIN.'/index.php?r=backend/u',
            'action'=>URL_DOMAIN.'/index.php?r=operation/or&table=user&action='.$action,
            'table' => array(
                array('column'=>'id','title'=>'用户ID','type'=>'span'),
                array('column'=>'username','title'=>'用户名',),
                array('column'=>'password','title'=>'密码','type'=>'password'),
                array('column'=>'user_type','title'=>'权限级别','type'=>'select','select'=>SelectConstent::getSelectUserType()),
            ),
        
        );
    }
    private function getUserFormInfo($action){
        return array(
            'title'=>'用户信息',
            'action'=>URL_DOMAIN.'/index.php?r=operation/or&user_show=private&table=user&action='.$action,
            'table' => array(
                array('column'=>'id','title'=>'用户ID','type'=>'span'),
                array('column'=>'username','title'=>'用户名','type'=>'span'),
                array('column'=>'password','title'=>'密码','type'=>'password'),
            ),
        
        );
    }
    
}

