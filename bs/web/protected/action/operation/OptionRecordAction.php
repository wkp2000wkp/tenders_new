<?php
/**
 *
 * @author john_yu
 * @date 2010-10-10
 */
class OptionRecordAction extends APPBaseAction
{
    public $tableName = '';
    public function run () {
        $action = $this->getParam('action','');
        $table = $this->getParam('table','');
        $id = $this->getParamForAbsIntval('id','0');
        $data = $this->getParam('data');
        $url = '-1';
        $message = 'no_data_submit';
        if(!$table || !$action){
            Yii::app()->showbox->showMessageBox( $message , $url );
        }
        $return = $this->getTable($table);
        $this->tableName = $return['table'];
        Yii::app()->tablegear->dataTaseTable = $this->tableName;
        switch ($action){
            case 'insert':
                $option = $this->insert($data);
                break;
            case 'update':
	            $option = $this->update($id,$data);
                break;
            case 'delete':
	            $option = $this->delete($id);
                break;
        }
        if($option){
	        $url = $return['url'];
            $message = $action.'_option_success';
        }else{
            $message = $action.'_option_faile';
        }
        Yii::app()->showbox->showMessageBox( $message , $url );
    }
    
    private function getTable($table){
        switch ($table){
            case 'user':
                $return['table'] = SelectConstent::TABLE_USER;
                $private = $this->getParam('user_show','');
                if($private){
                    $return['url'] = URL_DOMAIN.'/index.php?r=backend/zb';
                }else{
	                $return['url'] = URL_DOMAIN.'/index.php?r=backend/u';
                }
                break;
            case 'toubiao':
                $return['table'] =  SelectConstent::TABLE_TOUBIAO;
                $return['url'] = URL_DOMAIN.'/index.php?r=backend/tb';
                break;
            case 'zhaobiao':
                $return['table'] =  SelectConstent::TABLE_ZHAOBIAO;
                $return['url'] = URL_DOMAIN.'/index.php?r=backend/zb';
                break;
            case 'file':
                $touBiaoId = $this->getParam('tb_id','');
                $return['table'] =  SelectConstent::TABLE_UPLOADFILE;
                $return['url'] = URL_DOMAIN.'/index.php?r=backend/bor&id='.$touBiaoId;
                break;
        }
        return $return;
    }
    
    private function insert($data){
        $insertSql = $this->insertSql($this->tableName,$data);
        return Yii::app()->tablegear->getTableGearTool()->query($insertSql);
    }
    
    private function delete($id){
        $deleteSql = "update ".$this->tableName ." set is_deleted = 1 where id = ".$id;
        return Yii::app()->tablegear->getTableGearTool()->query($deleteSql);
    }
    
    private function update($id,$data){
        $updateSql = "update ".$this->tableName . $this->getUpdateSect($data) ." where id = ".$id;
        return Yii::app()->tablegear->getTableGearTool()->query($updateSql);
    }
    
}

