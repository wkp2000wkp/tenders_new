<?php
/**
 *
 * @author john_yu
 * @date 2011-11-11
 */
class OptionNewKaiBiaoRecordAction extends APPBaseAction {
	public $tableName = '';
	public $url = '-1';
	public function run() {
		$action = $this->getParam ( 'action', '' );
		$data = $this->getParam ( 'data' );
		$bid = $this->getParam ( 'bid' );
		$insertlist = $this->getParam ( 'insertlist' );
		$updatelist = $this->getParam ( 'updatelist' );
		$this->getConnect ();
		switch ($action) {
			case 'insert' :
				$option = $this->insert ( $data, $insertlist, $bid );
				break;
			case 'update' :
				$option = $this->update ( $data,$updatelist,$insertlist, $bid  );
				break;
			case 'delete_result' :
				$id = $this->getParamForAbsIntval ( 'kb_id', '0' );
				$tbId = $this->getParamForAbsIntval ( 'tb_id', '0' );
				$option = $this->deleteKaiBiaoResult ( $id,$tbId );
				$this->url = 'index.php?r=backend/abor&id='.$tbId;
				break;
			case 'copy_result' :
				$id = $this->getParamForAbsIntval ( 'kb_id', '0' );
				$tbId = $this->getParamForAbsIntval ( 'tb_id', '0' );
				$option = $this->copyKaiBiaoResult ( $id,$tbId );
				$this->url = 'index.php?r=backend/abor&id='.$tbId;
				break;
			case 'delete_record' :
				$id = $this->getParamForAbsIntval ( 'kbr_id', '0' );
				$option = $this->deleteKaiBiaoRecord ( $id );
				$tbId = $this->getParamForAbsIntval ( 'tb_id', '0' );
				$this->url = 'index.php?r=backend/abor&id='.$tbId;
				break;
		}
		if ($option) {
			$message = $action . '_option_success';
		} else {
			$message = $action . '_option_faile';
		}
		Yii::app ()->showbox->showMessageBox ( $message, $this->url );
	}
	
	private function insert($data, $insertlist, $bid) {
		$data['creat_at'] = date('Y-m-d H:i:s');
		$data['uid'] = $this->getUid();
		$insertSql = $this->insertSql ( SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT, $data );
		$this->query($insertSql);
		$kaiBiaoResultId = $this->insert_id ();
		$this->updateTouBiaoForKaiBiaoNumber($data['tb_id']);
		$this->insertKaiBiaoRecord($kaiBiaoResultId,$insertlist, $bid);
		$this->url = 'index.php?r=backend/abor&id='.$data['tb_id'];
		return TRUE;
	}
	
	private function deleteKaiBiaoResult($id,$tbId) {
		$this->deleteKaiBiaoRecordForKeiBiaoResultId($id);
		$this->updateTouBiaoForKaiBiaoNumber($tbId);
		$deleteSql = "update " . SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT . " set is_deleted = 1 where id = " . $id;
		$this->query($deleteSql);
		return TRUE;
	}
	private function copyKaiBiaoResult($kaiBiaoResultId) {
		$copySql ="INSERT INTO `" . SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT . "` (tb_id,uid,transformer_type,specification,number,fudian,baoliu,xiafu,creat_at) SELECT tb_id,uid,transformer_type,specification,number,fudian,baoliu,xiafu,'".(date("Y-m-d H:i:s"))."' FROM `" . SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT . "` WHERE is_deleted = 0 and id =".$kaiBiaoResultId;
		$this->query($copySql);
		$newId = $this->insert_id();
		$copySql ="INSERT INTO `" . SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD . "` (tb_id,kb_r_id,uid,bid,bid_company,bid_price,creat_at) SELECT tb_id,".$newId.",uid,bid,bid_company,bid_price,'".(date("Y-m-d H:i:s"))."' FROM `" . SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD . "` WHERE is_deleted = 0 and kb_r_id =".$kaiBiaoResultId;
		$this->query($copySql);
		return TRUE;
	}
	
	private function deleteKaiBiaoRecord($id) {
		$deleteSql = "update " . SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD . " set is_deleted = 1 where id = " . $id;
		$this->query($deleteSql);
		return TRUE;
	}
	
	private function deleteKaiBiaoRecordForKeiBiaoResultId($id) {
		$deleteSql = "update " . SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD . " set is_deleted = 1 where kb_r_id = " . $id;
		$this->query($deleteSql);
		return TRUE;
	}
	
	private function update( $data,$updatelist,$insertlist, $bid ) {
		$updateSql = "update " . SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT . $this->getUpdateSect ( $data ) . " where id = " . $data['id'];
		$this->query($updateSql);
		if ($bid) {
			$bidId = (is_int ( $bid )) ? $bid : str_replace ( KAIBIAO_BID_UPDATE_STR, '', $bid );
		}
		$bidId = intval($bidId);
		if($updatelist){
			foreach($updatelist as $recordId => $record){
				$record['bid'] = ($recordId == $bidId) ? BID_STR : '';
				$record = $this->formatPriceRound($record);
				$updateSql = "update " . SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD . $this->getUpdateSect ( $record ) . " where id = " . $recordId;
				$this->query($updateSql);
			}
		}
		if($insertlist){
			$this->insertKaiBiaoRecord($data['id'],$insertlist, $bid);
		}
		$this->url = 'index.php?r=backend/abor&id='.$data['tb_id'];
		return TRUE;
	}
	
	private function insertKaiBiaoRecord($kaiBiaoResultId,$insertlist, $bid){
		if ($bid) {
			$bidId = (is_int ( $bid )) ? $bid : str_replace ( KAIBIAO_BID_STR, '', $bid );
		}
		$bidId = intval($bidId);
		foreach ( $insertlist as $k => $insertK ) {
			$insertK['creat_at'] = date('Y-m-d H:i:s');
			$insertK['uid'] = $this->getUid();
			if (! $insertK ['bid_company'])
				continue;
			if ($k == $bidId)
				$insertK ['bid'] = BID_STR;
			$insertK ['kb_r_id'] = $kaiBiaoResultId;
			$insertK = $this->formatPriceRound($insertK);
			$insertSql = $this->insertSql ( SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD, $insertK );
			$this->query($insertSql);
		}
		return true;
	}
	
	private function updateTouBiaoForKaiBiaoNumber($tbId){
		$selectSql = "select count(*) as num from ".SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT." where tb_id=".$tbId." and is_deleted=0";
		$result = $this->fetchArray($selectSql);
		$number = intval($result[0]['num']);
		$updateSql = " update ".SelectConstent::TABLE_TOUBIAO." set kaibiao_number=".$number." where id= ".$tbId;
		$this->query($updateSql);
		return true;
	}
	
	private function formatPriceRound($record){
		if($record['bid_price']){
			$record['bid_price'] = round($record['bid_price'],1);
		}
		return $record;
	}

}

