<?php
/**
 *
 * @author john_yu
 * @date 2010-9-19
 */
class AddZhaoBiaoFormAction extends APPBaseAction
{
    public $tableName = 'san_zhaobiao';
    public function run () {
        $data = $this->getParam('data');
        $action = $this->getParam('action','view');
        $zhaoBiaoId = $this->getParamForAbsIntval('zb_id',0);
        if($action == 'insert'){
            $this->insert($data);
        }elseif($action == 'update'){
            $this->update($zhaoBiaoId,$data);
        }else{
            Yii::app()->showbox->showMessageBox( 'no_data_submit' , '-1' );
        }
    }
    
    private function insert($data){
        $data['uid'] = $this->getUid();
        $insertSql = $this->insertSql($this->tableName,$data);
        $saved = Yii::app()->tablegear->query($insertSql);
        if($saved){
            Yii::app()->showbox->showMessageBox( 'zhaobiao_insert_success' , 'index.php?r=backend/zb' );
        }else{
            Yii::app()->showbox->showMessageBox( 'zhaobiao_insert_faile' , '-1' );
        }
    }
    
    private function update($zhaoBiaoId,$data){
        if(!$zhaoBiaoId){
            Yii::app()->showbox->showMessageBox( 'no_data_submit' , '-1' );
            exit;
        }
        $updateSql = "update ".$this->tableName . $this->getUpdateSect($data) ." where id = ".$zhaoBiaoId;
        $upadted = Yii::app()->tablegear->query($updateSql);
        if($upadted){
            Yii::app()->showbox->showMessageBox( 'zhaobiao_insert_success' , 'index.php?r=backend/zb' );
        }else{
            Yii::app()->showbox->showMessageBox( 'zhaobiao_update_faile' , 'index.php?r=backend/tf&action=update&zb_id='.$zhaoBiaoId );
        }
    }
    
}

