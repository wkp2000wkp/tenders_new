<?php
/**
 *
 * @author john_yu
 * @date 2010-10-10
 */
class OptionBackUpRecordAction extends APPBaseAction
{
    public function run () {
        $action = $this->getParam('action','insert');
        $tableName = $this->getController()->getTableName();
        $data = $this->getParam('data',array());
        $url = '-1';
        $message = 'no_data_submit';
        if(!$data){
            Yii::app()->showbox->showMessageBox( $message , $url );
        }
        $option = $this->insert($tableName,$data);
        if($option){
        	if($tableName == SelectConstent::TABLE_QUOTE_BACKUP){
        		$backUpTable = SelectConstent::TABLE_QUOTE;
        	}elseif($tableName == SelectConstent::TABLE_BACKUP){
        		$backUpTable = SelectConstent::TABLE_TOUBIAO;
        	}
            $this->updateBackupTable($tableName,$backUpTable,$data);
	        $url = URL_DOMAIN.'/index.php?r=backup/list&table='.$tableName;
            $message = $action.'_option_success';
        }else{
            $message = $action.'_option_faile';
        }
        Yii::app()->showbox->showMessageBox( $message , $url );
    }
    
    private function insert($tableName,$data){
        Yii::app()->tablegear->dataTaseTable = $tableName;
        $sql = "select * from ".$tableName." where id = ".SelectConstent::BACK_UP_ID;
        $list = Yii::app()->tablegear->query($sql);
        $data['name'] = $data['name'];
        $data['start_num'] = 1;
        $data['max_num'] = $list[0]['max_num'];
        $data['creat_at'] = date('Y-m-d H:i:s');
        $insertSql = $this->insertSql($tableName,$data);
        $saved = Yii::app()->tablegear->getTableGearTool()->query($insertSql);
        if($saved){
        	$updateAry['max_num'] = 1;
        	$this->update($tableName,SelectConstent::BACK_UP_ID,$updateAry);
        }
	    return $saved;
    }
    
    private function updateBackupTable($tableName,$backUpTable,$data){
        $data['to_time'] =date('Y-m-d',strtotime($data['to_time'])+86400);;
        $update['bu_id'] = $this->getBackUpId($tableName);
        $updateSql = "update ". $backUpTable . $this->getUpdateSect($update) ." where end_time >='".$data['from_time']."' and end_time < '".$data['to_time']."' and is_deleted = 0 and bu_id =".SelectConstent::BACK_UP_ID;
        return Yii::app()->tablegear->getTableGearTool()->query($updateSql);
    }
    
    private function getBackUpId($tableName){
        $sql = "select * from ".$tableName." order by id desc limit 1";
        $list = Yii::app()->tablegear->query($sql);
        return $list[0]['id'];
    }
    
    private function update($tableName,$id,$data){
        $updateSql = "update ".$tableName . $this->getUpdateSect($data) ." where id = ".$id;
        return Yii::app()->tablegear->getTableGearTool()->query($updateSql);
    }
    
}