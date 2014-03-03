<?php
/**
 *
 * @author john_yu
 * @date 2010-10-10
 */
class OptionTouBiaoRecordAction extends APPBaseAction
{
    public function run () {
        $action = $this->getParam('action','update');
        $touBiaoId = $this->getParamForAbsIntval('id',0);
        $insertCount = 0;
        $url = '-1';
        $showMessage = 'no_data_submit';
        if($touBiaoId){
            $this->checkTouBiaoData($touBiaoId);
            if($action =='update'){
              $data = $this->getParam('data');
              $this->update($touBiaoId,$data);
            }else{
              $this->delete($touBiaoId);
            }
        }else{
            Yii::app()->showbox->showMessageBox( 'no_data_submit' , '-1' );
        }
    }
    
    
    private function delete($touBiaoId){
        $deleteSql = "update ".SelectConstent::TABLE_TOUBIAO ." set is_deleted = 1 where id = ".$touBiaoId;
        $deleted =  Yii::app()->tablegear->query($deleteSql);
        if($deleted){
            Yii::app()->showbox->showMessageBox( 'toubiao_delete_success' , 'index.php?r=backend/tb' );
        }else{
            Yii::app()->showbox->showMessageBox( 'toubiao_delete_faile' , 'index.php?r=backend/tb' );
        }
    }
    
    private function update($touBiaoId,$data){
      $referer = $this->getParam('referer',$_SERVER['HTTP_REFERER']);
      $updateSql = "update ".SelectConstent::TABLE_TOUBIAO . $this->getUpdateSect($data) ." where id = ".$touBiaoId;
        $upadted = Yii::app()->tablegear->query($updateSql);
        if($upadted){
            Yii::app()->showbox->showMessageBox( 'toubiao_update_success' , $referer );
        }else{
            Yii::app()->showbox->showMessageBox( 'toubiao_update_faile' , 'index.php?r=backend/tbf&action=update&id='.$touBiaoId.'&referer='.(urlencode($referer)) );
        }
    }
    
    private function checkTouBiaoData($touBiaoId){
        $list = array();
        if($touBiaoId){
          Yii::app()->tablegear->dataTaseTable = SelectConstent::TABLE_TOUBIAO;
          $sql = 'select * from '.SelectConstent::TABLE_TOUBIAO.' where id='.$touBiaoId.' limit 1';
          $list = Yii::app()->tablegear->getTableGearTool()->query($sql);
        }
        $this->checkPermissions( $list[0]['uid']);
        return $list[0];
    }
    
    
}

