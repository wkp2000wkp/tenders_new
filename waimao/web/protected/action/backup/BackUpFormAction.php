<?php
/**
 *
 * @author john_yu
 * @date 2010-11-13
 */
class BackUpFormAction extends APPBaseAction
{

    public function run () {
        $show = array();
        $action = $this->getParam('action','insert');
        $tableName = $this->getController()->getTableName();
        $id = $this->getParamForAbsIntval('id',0);
        $show['action'] = $action;
        $show['form_info'] = $this->getFormInfo($tableName,$action);
        $this->getController()->render( "/layouts/publish_form" , $show );
    }
    
    private function getFormInfo($tableName,$action){
         $form = array(
            'title'=>'历史信息',
            'backurl'=> URL_DOMAIN.'/index.php?r=backup/list&table='.$tableName,
            'action'=>URL_DOMAIN.'/index.php?r=backup/option&table='.$tableName.'&action='.$action,
            'table' => array(
                array('column'=>'name','title'=>'备份名称',),
                array('column'=>'datetime','title'=>'时间区域','type'=>'timearea'),
            ),
        
        );
        return $form;
    }
    
}

