<?php
/**
 *
 * @author john_yu
 * @date 2010-10-10
 */
class ImportTouBiaoRecordAction extends APPBaseAction
{

    public function run () {
        $action = $this->getParam('action','import');
        $zhaoBiaoId = $this->getParamForAbsIntval('zb_id',0);
        $insertCount = 0;
        $url = '-1';
        $showMessage = 'no_data_submit';
        if($zhaoBiaoId){
            $this->checkZhaoBiaoData($zhaoBiaoId,$action);
            if($action =='import'){
              $insertCount = $this->import($zhaoBiaoId);
              $url = 'index.php?r=backend/tb';
              if($insertCount){
                  $showMessage = 'zhaobiao_import_success';
              }else{
                  $showMessage = 'zhaobiao_import_faile';
              }
            }elseif($action =='delete'){
              $insertCount = $this->delete($zhaoBiaoId);
              $url = 'index.php?r=backend/zb';
              if($insertCount){
                  $showMessage = 'zhaobiao_delete_success';
              }else{
                  $showMessage = 'zhaobiao_delete_faile';
              }
            }elseif($action =='copy'){
              $insertCount = $this->copy($zhaoBiaoId);
              $url = 'index.php?r=backend/zb';
              if($insertCount){
                  $showMessage = 'zhaobiao_copy_success';
              }else{
                  $showMessage = 'zhaobiao_copy_faile';
              }
            }
        }
        Yii::app()->showbox->showMessageBox( $showMessage, $url );
    }
    
    
    private function delete($zhaoBiaoId){
        $deleteSql = "update ".SelectConstent::TABLE_ZHAOBIAO." set is_deleted = 1 where id = ".$zhaoBiaoId." ";
        return Yii::app()->tablegear->query($deleteSql);
    }
    
    private function copy($zhaoBiaoId){
    	$deleteSql = "INSERT INTO ".SelectConstent::TABLE_ZHAOBIAO."( ".join(',', array_keys($this->getZhaoBiaoTaleColumns()))." ) SELECT   ".join(',', $this->getZhaoBiaoTaleColumns())."   FROM ".SelectConstent::TABLE_ZHAOBIAO." where id = ".$zhaoBiaoId."  ";
    	return Yii::app()->tablegear->query($deleteSql);
    }
    
    private function import($zhaoBiaoId){
        $insertCount = 0;
        $sql = "select * from ".SelectConstent::TABLE_ZHAOBIAO." where id = ".$zhaoBiaoId." ";
            $rows = Yii::app()->tablegear->query($sql);
            foreach($rows as $row){
                if($backUpInfo =$this->getBackUpInfo()){
                    $row = array_merge($row, $backUpInfo);
                }else{
                    Yii::app()->showbox->showMessageBox( 'no_data_submit', '-1' );
                }
                $row['bid']='未定';
                $insertSql = $this->insertSql(SelectConstent::TABLE_TOUBIAO,$row);
                $saved = Yii::app()->tablegear->getTableGearTool()->query($insertSql);
                if($saved){
                    $insertCount++;
                    $deleteSql = "update ".SelectConstent::TABLE_ZHAOBIAO." set is_deleted = 1 where id=".$row['id'];
                    Yii::app()->tablegear->getTableGearTool()->query($deleteSql);
                }
            }
            return $insertCount;
    }
    
    private function getBackUpInfo(){
        $data = array();
        $sql = "select * from ".SelectConstent::TABLE_BACKUP." where id = ".SelectConstent::BACK_UP_ID;
        $list = Yii::app()->tablegear->query($sql);
        if($list){
	        $id = $list[0]['id'];
	        $updateAry['max_num'] = $list[0]['max_num']+1;
	        $this->update(SelectConstent::TABLE_BACKUP,$id,$updateAry);
	        $data['bu_id'] = $list[0]['id'];
	        $data['tb_show_id'] = $list[0]['max_num'];
	        $data['creat_at'] = date('Y-m-d H:i:s');
	        $data['update_at'] = date('Y-m-d H:i:s');
        }
        return $data;
    }
    
    private function update($tableName,$id,$data){
        $updateSql = "update ".$tableName . $this->getUpdateSect($data) ." where id = ".$id;
        return Yii::app()->tablegear->getTableGearTool()->query($updateSql);
    }
    
    private function checkZhaoBiaoData($zhaoBiaoId,$action){
        $list = array();
        if($zhaoBiaoId){
          Yii::app()->tablegear->dataTaseTable = SelectConstent::TABLE_ZHAOBIAO;
          $sql = 'select * from '.SelectConstent::TABLE_ZHAOBIAO.' where id='.$zhaoBiaoId.' limit 1';
          $list = Yii::app()->tablegear->getTableGearTool()->query($sql);
        }
        if($action!='copy') $this->checkPermissions( $list[0]['uid']);
        return $list[0];
    }
    
    private function getZhaoBiaoTaleColumns(){
    	$time='"'.date('Y-m-d H:i:s',time()).'"';
    	$uid=$this->getUid ();
    	return array(
					'uid'=>$uid,
					'project_name'=>'project_name',
					'bidding_agent'=>'bidding_agent',
					'tenderer'=>'tenderer',
					'specification'=>'specification',
					'transformer_type'=>'transformer_type',
					'number'=>'number',
					'slesman'=>'slesman',
					'end_time'=>'end_time',
					'tender_manager'=>'tender_manager',
					'respective_regions'=>'respective_regions',
					'respective_provinces'=>'respective_provinces',
					'tender_fee'=>'tender_fee',
					'bid_bond'=>'bid_bond',
    			//投标有效期(天)\币种\其他币种
					'currency'=>'currency',
					'other_currency'=>'other_currency',
					'bid_valid'=>'bid_valid',
    				'creat_at'=>$time,
					'update_at'=>$time,
					'is_deleted'=>'is_deleted',
					'skill_fee'=>'skill_fee',
					'place_fee'=>'place_fee',
					'bid_fee'=>'bid_fee',
					'bid_fee_value'=>'bid_fee_value',
					'bid_fee_sort'=>'bid_fee_sort',
					'bid_fee_sort_other'=>'bid_fee_sort_other',
    			);
    }
    
}

