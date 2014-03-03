<?php
/**
 *
 * @author john_yu
 * @date 2010-9-19
 */
class QuoteOptionAction extends APPBaseAction
{

    public function run () {
        $data = $this->getParam('data',array());
        $id = $this->getParam('id',0);
        $action = $this->getParam('action','view');
        switch ($action) {
        	case 'view':
        		$this->view(SelectConstent::TABLE_QUOTE,$id);
        		break;
        	case 'insert':
        		$this->insert(SelectConstent::TABLE_QUOTE,$data);
        		break;
        	case 'update':
                if(!$this->checkPermissionsData($id)){
                	echo ShowLang::getLanguage('no_permissions');
                	exit;
        		}
        		$this->update(SelectConstent::TABLE_QUOTE,$id,$data,true);
        		break;
        	case 'delete':
        		$this->delete(SelectConstent::TABLE_QUOTE,$id);
        		break;
        	default:
        		ShowLang::getLanguage('no_data_submit');
        		break;
        }
        
    }
    private function view($tableName,$id){
    	$show['data'] = array();
        $show['action'] = 'insert';
    	$sql = "select * from ".$tableName." where id = ".$id." limit 1";
        $list = Yii::app()->tablegear->query($sql);
        if($list){
            if(!$this->checkPermissions($list[0]['uid'],false)){
          	  echo 'no_permissions';
          	  exit;
  		    }
        	$show['action'] = 'update';
        	$show['data'] = $list[0];
        }
        $this->getController()->renderPartial( "quote_form" , $show);
    }
	private function insert($tableName,$data){
		if(empty($data)){
        	echo ShowLang::getLanguage('no_data_submit');
        	exit;
		}
		$backUpInfo = $this->getBackUpInfo();
		$data = array_merge($data, $backUpInfo);
		$data['uid'] = $this->getUid();
		$data['attachment'] = 0;
        $insertSql = $this->insertSql($tableName,$data);
        $option = Yii::app()->tablegear->getTableGearTool()->query($insertSql);
        if($option){
        	echo ShowLang::getLanguage('insert_option_success');
        }else{
        	echo ShowLang::getLanguage('insert_option_faile');
        }
    }
    
	private function getBackUpInfo(){
        $data = array();
        $sql = "select * from ".SelectConstent::TABLE_QUOTE_BACKUP." where id = ".SelectConstent::BACK_UP_ID;
        $list = Yii::app()->tablegear->query($sql);
        if($list){
	        $id = $list[0]['id'];
	        $updateAry['max_num'] = $list[0]['max_num']+1;
	        $this->update(SelectConstent::TABLE_QUOTE_BACKUP,$id,$updateAry);
	        $data['bu_id'] = $list[0]['id'];
	        $data['tb_show_id'] = $list[0]['max_num'];
	        $data['creat_at'] = date('Y-m-d H:i:s');
	        $data['update_at'] = date('Y-m-d H:i:s');
        }
        return $data;
    }
    
    private function delete($tableName,$id){
		if(empty($id)){
        	echo ShowLang::getLanguage('no_data_submit');
        	exit;
		}
		if(!$this->checkPermissionsData($id)){
        	echo ShowLang::getLanguage('no_permissions');
        	exit;
		}
        $deleteSql = "update ".$tableName ." set is_deleted = 1 where id = ".$id;
        $option = Yii::app()->tablegear->getTableGearTool()->query($deleteSql);
    	if($option){
        	echo ShowLang::getLanguage('delete_option_success');
        }else{
        	echo ShowLang::getLanguage('delete_option_faile');
        }
    }
    
    private function update($tableName,$id,$data,$show = false){
		if(empty($id) || empty($data)){
        	echo ShowLang::getLanguage('no_data_submit');
        	exit;
		}
        $updateSql = "update ".$tableName . $this->getUpdateSect($data) ." where id = ".$id;
        $option = Yii::app()->tablegear->getTableGearTool()->query($updateSql);
        if($show){
	    	if($option){
	        	echo ShowLang::getLanguage('update_option_success');
	        }else{
	        	echo ShowLang::getLanguage('update_option_faile');
	        }
        }
    }
    
	private function checkPermissionsData($id){
        $list = array();
        if($id){
          Yii::app()->tablegear->dataTaseTable = SelectConstent::TABLE_QUOTE;
          $sql = 'select * from '.SelectConstent::TABLE_QUOTE.' where id='.$id.' limit 1';
          $list = Yii::app()->tablegear->getTableGearTool()->query($sql);
        }
        return $this->checkPermissions( $list[0]['uid'],false);
    }
}

