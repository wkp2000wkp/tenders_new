<?php
/**
 *
 * @author john_yu
 * @date 2011-11-11
 */
class NewBidOpeningRecordAction extends APPBaseAction {
	
	public function run() {
		$touBiaoId = $this->getParamForAbsIntval ( 'tb_id', 0 );
		$kaiBiaoId = $this->getParamForAbsIntval ( 'kb_id', 0 );
		$show = array ();
		$show ['action'] = $this->getParam ( 'action', 'insert' );
		$show ['referer'] = URL_DOMAIN.'/index.php?r=backend/tb';
		$show ['toubiao_info'] = $this->getTouBiaoInfo ( $touBiaoId );
		if ($show ['action'] == 'update') {
			$show ['kaibiao_list'] = $this->getKaiBiaoInfoList ( $kaiBiaoId );
			$show ['bid_record'] = $this->getBidList ( $kaiBiaoId );
		}
		if ($touBiaoId) {
			$show ['tou_biao_id'] = $touBiaoId;
			$this->getController ()
				->renderPartial ( "new_bid_opening_record_form", $show );
		} else {
			Yii::app ()->showbox
				->showMessageBox ( 'no_data_submit', '-1' );
		}
	}
	
	private function getKaiBiaoInfoList($kaiBiaoId) {
		$this->getConnect ();
		$sql = "select * from " . SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT . " where id = " . $kaiBiaoId . " and is_deleted=0 order by id";
		$result = $this->fetchArray ( $sql );
		$showList ['kaibiao_result'] = $result [0];
		$sql = "select * from " . SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD . " where kb_r_id = " . $kaiBiaoId . " and is_deleted=0 order by id";
		$kaiBiaoRecord = $this->fetchArray ( $sql );
		foreach ( $kaiBiaoRecord as $key => $record ) {
			if ($record ['bid_company'] == MY_COMPANY) {
				$showList ['my_company'] = $record;
				unset ( $kaiBiaoRecord [$key] );
				array_unshift ( $kaiBiaoRecord, $record );
			}
			$showList ['kaibiao_record'] = $kaiBiaoRecord;
		}
		return $showList;
	}
	
	private function getTouBiaoInfo($touBiaoId) {
		$this->getConnect ();
		$sql = "select * from " . SelectConstent::TABLE_TOUBIAO . " where id = " . $touBiaoId . " and is_deleted=0 order by id";
		$result = $this->fetchArray ( $sql );
		return $result [0];
	}
	
	private function getBidList($kaiBiaoId) {
		$sql = "select * from " . SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD . " where 	kb_r_id = " . $kaiBiaoId . " and bid='".BID_STR."' and is_deleted=0 ";
		$kaiBiaoRecord = $this->fetchArray ( $sql );
		return $kaiBiaoRecord[0];
	}

}

