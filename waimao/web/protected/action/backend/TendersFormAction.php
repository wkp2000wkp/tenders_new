<?php
/**
 *
 * @author john_yu
 * @date 2010-9-19
 */
class TendersFormAction extends APPBaseAction
{

    public function run () {
        $show = array();
        $action = $this->getParam('action','insert');
        $zhaoBiaoId = $this->getParamForAbsIntval('zb_id',0);
        $show['action'] = $action;
        $show['data'] = array();
        if($action == 'update'){
	        if($zhaoBiaoId){
	            $show['data'] = $this->getZhaoBiaoData($zhaoBiaoId);
	        }else{
	            Yii::app()->showbox->showMessageBox( 'no_data_submit' , '-1' );
	        }
        }
        $this->getController()->render( "tenders_form" , $show );
    }
    
    private function getZhaoBiaoData($zhaoBiaoId){
        $list = array();
        if($zhaoBiaoId){
          Yii::app()->tablegear->dataTaseTable = SelectConstent::TABLE_ZHAOBIAO;
          $sql = 'select * from '.SelectConstent::TABLE_ZHAOBIAO.' where id='.$zhaoBiaoId.' limit 1';
          $list = Yii::app()->tablegear->getTableGearTool()->query($sql);
        }
        $this->checkPermissions( $list[0]['uid']);
        return $list[0];
    }
    
}

