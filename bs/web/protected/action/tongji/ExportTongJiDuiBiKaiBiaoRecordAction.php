<?php
/**
 *
 * @author john_yu
 * @date 2011-11-11
 */
Yii::import( 'application.components.PHPExcelTool' );
class ExportTongJiDuiBiKaiBiaoRecordAction extends BaseTongJiListAction
{

    public function run () {
        $action = $this->getParam('action','');
     	$whereData = $this->getParam('search',array());
		$sort = $this->getParam('sort','tb_show_id');
		$data=$this->getTongJiDateRecordList($whereData,$action,$sort,$action);
        if(!$data){
        	Yii::app()->showbox->showMessageBox( 'no_data_submit' , '-1' );
        }
        $line = (in_array($sort,SelectConstent::getSpecialSort())) ? 'type':'';
        	$fileName = "TJDBKBR".date("Y-m-d");
        	$phpExcelTool = new PHPExcelTool();
        	$phpExcelTool->exportPHPExcelToolTongJiKaiBiaoRecord1($data,$fileName,$line);
    }
    
    public function getTongJiDateRecordList($whereData,$action,$sort='',$action=''){
    	$showCompany = array();
    	$html = '';
    	$dateList = $this->getTongJiDateForWhereData($whereData,$sort);
    	if($dateList){
    		foreach($dateList as $list){
    			if($list['transformer_type'] == SelectConstent::EXCLUDE_TRANSFORMER_TYPE) continue;
				$showDate[$list['bid_company']][$list['kb_r_id']]=$list;
				$kaiBiaoIdList[]=$list['kb_r_id'];
    		}
    		$kaiBiaoPriceList = $this->getKaiBiaoRecordListById($kaiBiaoIdList);
    		foreach($showDate as $bidCompany=>$list1):
    			foreach($list1 as $kaiBiaoRecordId=>$list2):
    				$showDate[$bidCompany][$kaiBiaoRecordId]['bid_price_number']=array_search($showDate[$bidCompany][$kaiBiaoRecordId]['bid_price'], $kaiBiaoPriceList[$kaiBiaoRecordId]['list_price'])+1;
    				$showDate[$bidCompany][$kaiBiaoRecordId]['list_price_count']=$kaiBiaoPriceList[$kaiBiaoRecordId]['list_price_count'];
    				$showDate[$bidCompany][$kaiBiaoRecordId]['show_bid_price']=$kaiBiaoPriceList[$kaiBiaoRecordId]['show_bid_price'];
    				$showDate[$bidCompany][$kaiBiaoRecordId]['show_bid_company']=$kaiBiaoPriceList[$kaiBiaoRecordId]['show_bid_company'];
    				$showDate[$bidCompany][$kaiBiaoRecordId]['my_company_price_show']=$kaiBiaoPriceList[$kaiBiaoRecordId]['my_company_price'] ? $kaiBiaoPriceList[$kaiBiaoRecordId]['my_company_price'] : SelectConstent::WEI_TOU;
    				$showDate[$bidCompany][$kaiBiaoRecordId]['my_company_price']=$kaiBiaoPriceList[$kaiBiaoRecordId]['my_company_price'];
    				$showDate[$bidCompany][$kaiBiaoRecordId]['show_agv_price']=round(array_sum($kaiBiaoPriceList[$kaiBiaoRecordId]['list_price'])/count($kaiBiaoPriceList[$kaiBiaoRecordId]['list_price']),2);
    				if($kaiBiaoPriceList[$kaiBiaoRecordId]['my_company_price']){
    					if($showDate[$bidCompany][$kaiBiaoRecordId]['show_bid_price'])
    						$showDate[$bidCompany][$kaiBiaoRecordId]['xiangcha_bid_price']='('.round((($showDate[$bidCompany][$kaiBiaoRecordId]['show_bid_price']/$showDate[$bidCompany][$kaiBiaoRecordId]['my_company_price'])-1)*100,1).")";
    					if($showDate[$bidCompany][$kaiBiaoRecordId]['show_agv_price'])
    						$showDate[$bidCompany][$kaiBiaoRecordId]['xiangcha_agv_price']='('.round((($showDate[$bidCompany][$kaiBiaoRecordId]['show_agv_price']/$showDate[$bidCompany][$kaiBiaoRecordId]['my_company_price'])-1)*100,1).")";
    					if($showDate[$bidCompany][$kaiBiaoRecordId]['bid_price'])
    						$showDate[$bidCompany][$kaiBiaoRecordId]['xiangcha_search_price']='('.round((($showDate[$bidCompany][$kaiBiaoRecordId]['bid_price']/$showDate[$bidCompany][$kaiBiaoRecordId]['my_company_price'])-1)*100,1).")";
    				}
    			endforeach;
    		endforeach;
    	}
    	return $showDate;
    }
    
    public function getKaiBiaoRecordListById($kaiBiaoIdList){
    	$whereData['kb_r_id'] = join(array_unique($kaiBiaoIdList),SelectConstent::EXPLODE_STRING);
    	$sql='select * from '.SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD ;
    	$sql .= $this->getSqlSelectForWhere($whereData);
    	$recordList = $this->fetchArray($sql);
    	foreach($recordList as $list){
    		$showPrice[$list['kb_r_id']]['list_price'][]=$list['bid_price'];
    		if($list['bid']==BID_STR){
    			$showPrice[$list['kb_r_id']]['show_bid_price']=$list['bid_price'];
    			$showPrice[$list['kb_r_id']]['show_bid_company']=$list['bid_company'];
    		}
    		if($list['bid_company']==MY_COMPANY && $list['bid_company']){
    			$showPrice[$list['kb_r_id']]['my_company_price']=$list['bid_price'];
    		}
    	}
    	foreach($showPrice as $kaiBiaoId => $list){
    		$showPrice[$kaiBiaoId]['list_price_count'] = count($showPrice[$kaiBiaoId]['list_price']);
    		sort($showPrice[$kaiBiaoId]['list_price'],SORT_NUMERIC);
    	}
    	return $showPrice;
    }
    
	public function getTongJiDateForWhereData($whereData,$sort=''){
		
		$sql = "SELECT
		c.id as tb_id,
		c.tb_show_id as tb_show_id,
		b.kb_r_id as kb_r_id,
		c.respective_regions as respective_regions,
		c.respective_provinces as respective_provinces,
		c.project_name as project_name,
		c.tenderer as tenderer,
		c.slesman as slesman ,
		c.end_time as end_time,
		b.bid_company as bid_company,
		a.transformer_type as transformer_type,
		a.specification as specification,
		a.number as number,
		b.bid_price as bid_price,
		b.bid as bid
		FROM "
		.SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT." as a ,"
		.SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD." as b ,"
		.SelectConstent::TABLE_TOUBIAO." as c
		where
		b.kb_r_id=a.id and a.tb_id=c.id  ";
		$sql .= $this->getSqlSelectForWhere2($whereData);
// 		排序：编号、区域、省份、类型、中标厂家排序
		$sql .= " order by ".$sort.";";
		$dateList = $this->fetchArray($sql);
		return $dateList;
	}
}