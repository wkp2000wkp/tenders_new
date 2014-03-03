<?php
/**
 *
 * @author john_yu
 * @date 2011-11-11
 */
class AjaxBidOpeningRecordAction extends APPBaseAction {
	public $maxBid = 0;
	public $sanbianTotal = 0;
	public $bidTotal = 0;
	public function run() {
		$touBiaoId = $this->getParamForAbsIntval ( 'id', 0 );
		$referer = $this->getParam ( 'referer', '' );
		$show = array ();
		$show ['referer'] = $referer ? $referer : $_SERVER ['HTTP_REFERER'];
		
		if ($touBiaoId) {
			$show ['tou_biao_id'] = $touBiaoId;
			$show ['toubiao_info'] = $this->getTouBiaoInfo ( $touBiaoId );
			$show ['permission'] = $this->checkPermissions ($show ['toubiao_info']['uid'], false);
			$this->getConnect ();
			$show ['kaibiao_list'] = $this->getKaiBiaoList ( $touBiaoId );
			$show ['bid_list'] = $this->getBidList ( $touBiaoId );
			$show ['max_bid'] = $this->maxBid;
			$show ['sanbian_total'] = $this->sanbianTotal;
			$show ['bid_total'] = $this->bidTotal;
			$this->getController ()
				->render ( "ajax_bid_opening_record_form", $show );
		} else {
			Yii::app ()->showbox
				->showMessageBox ( 'no_data_submit', '-1' );
		}
	}
	
	private function getKaiBiaoList($id) {
		$this->getConnect ();
		$sql = "select * from " . SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT . " where tb_id = " . $id . " and is_deleted=0 order by id";
		$kaiBiaoRusult = $this->fetchArray ( $sql );
		$sql = "select * from " . SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD . " where tb_id = " . $id . " and is_deleted=0 order by bid_price";
		$kaiBiaoRecord = $this->fetchArray ( $sql );
		foreach ( $kaiBiaoRecord as $record ) {
			if ($record ['bid_company'] == MY_COMPANY ) {
				if(is_array ( $recordList [$record ['kb_r_id']] ['bid_company'] )){
					array_unshift ( $recordList [$record ['kb_r_id']] ['bid_company'], $record ['bid_company'] );
					array_unshift ( $recordList [$record ['kb_r_id']] ['bid_price'], $record ['bid_price'] );
				}else{
					$recordList [$record ['kb_r_id']] ['bid_company'] [] = $record ['bid_company'];
					$recordList [$record ['kb_r_id']] ['bid_price'] [] = $record ['bid_price'];
				}
				$recordList [$record ['kb_r_id']] ['pai_bid_number'] = count($recordList [$record ['kb_r_id']] ['bid_price']);
				//20130312 三变投标金额汇总
				$this->sanbianTotal += $record ['bid_price'];
			} else {
				$recordList [$record ['kb_r_id']] ['bid_company'] [] = $record ['bid_company'];
				$recordList [$record ['kb_r_id']] ['bid_price'] [] = $record ['bid_price'];
			}
			//20130312 中标金额汇总
			if($record['bid'] == BID_STR && $record ['bid_company'] == MY_COMPANY){
				$this->bidTotal += $record ['bid_price'];
			}
			$recordList [$record ['kb_r_id']]['all_bid_price'] += $record ['bid_price'];
			if($record ['bid_company'] != MY_COMPANY || $record ['bid_price'] )
				$recordList [$record ['kb_r_id']]['num_bid_price'] += 1;
			
		}
		foreach ( $kaiBiaoRusult as $rusult ) {
			$rusult ['bid_info'] = ($recordList [$rusult ['id']] ['bid_company']) ? $recordList [$rusult ['id']] ['bid_company'] : array ();
			$rusult['all_bid_price'] = $recordList [$rusult ['id']] ['all_bid_price'];
			$rusult['num_bid_price'] = intval($recordList [$rusult ['id']] ['num_bid_price']);
			$showList [] = $rusult;
			$rusult ['bid_info'] = ($recordList [$rusult ['id']] ['bid_price']) ? $recordList [$rusult ['id']] ['bid_price'] : array ();
			$rusult['pai_bid_number'] = $recordList [$rusult ['id']] ['pai_bid_number'];
			$showList [] = $rusult;
			$this->maxBid = ($this->maxBid > count ( $recordList [$rusult ['id']] ['bid_price'] )) ? $this->maxBid : count ( $recordList [$rusult ['id']] ['bid_price'] );
		}
		return $showList;
	}
	
	private function getBidList($id) {
		$sql = "select * from " . SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD . " where tb_id = " . $id . " and bid='".BID_STR."' and is_deleted=0 order by bid_price";
		$kaiBiaoRecord = $this->fetchArray ( $sql );
		foreach ( $kaiBiaoRecord as $record ) {
			$showList [$record ['kb_r_id']] ['bid_company'] = $record ['bid_company'];
			$showList [$record ['kb_r_id']] ['bid_price'] = $record ['bid_price'];
		}
		$sql = "select * from " . SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD . " where tb_id = " . $id . " and bid_company='".MY_COMPANY."' and is_deleted=0 order by bid_price";
		$kaiBiaoRecord = $this->fetchArray ( $sql );
		foreach ( $kaiBiaoRecord as $record ) {
			$showList [$record ['kb_r_id']] ['my_bid_company'] = $record ['bid_company'];
			$showList [$record ['kb_r_id']] ['my_bid_price'] = $record ['bid_price'] ;
		}
		return $showList;
	}
	
	private function getTouBiaoInfo($touBiaoId) {
		$this->getConnect ();
		$sql = "select * from " . SelectConstent::TABLE_TOUBIAO . " where id = " . $touBiaoId . " and is_deleted=0 order by id";
		$result = $this->fetchArray ( $sql );
		return $result [0];
	}

}

