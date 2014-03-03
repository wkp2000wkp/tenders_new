<?php
/**
 *
 * @author john_yu
 * @date 2011-11-11
 */
Yii::import( 'application.components.PHPExcelTool' );
class ExportZhongBiaoRecordAction extends APPBaseAction
{
    
	public function run () {
        $totals = array();
        $whereData = $this->getParam('search');
        $data = $this->getZhongBiaoList($whereData);
        if(!$data){
            Yii::app()->showbox->showMessageBox( 'no_data_submit' , '-1' );
        }
        $fileName = "ZBZBTL".date("Y-m-d");
        $phpExcelTool = new PHPExcelTool();
        $phpExcelTool->exportPHPExcelZhongBiaoZhanBiRecord($data,$fileName);
    }
    
    public function getZhongBiaoList($whereData){
    	$showData = array();
    	$dateList = $this->getZhongBiaoForWhereData($whereData);
    	//中标占比
    	if($dateList){
    		foreach($dateList as $list){
    			//过滤35v以下类型数据
    			if($list['transformer_type'] == SelectConstent::EXCLUDE_TRANSFORMER_TYPE) continue;
    			$showData[$list['tb_id']]=$list;
    			$typeList[$list['tb_id']][$list['kb_r_id']]=$list;
    			$kaiBiaoIdList[]=$list['kb_r_id'];
    		}
    		if($kaiBiaoIdList)
    			$kaiBiaoList = $this->getKaiBiaoRecordListById($kaiBiaoIdList);
    		foreach($kaiBiaoList as $tbId=>$list1){
    			$showData[$tbId]['all_bid_price']=$list1['all_bid_price'];
    			$showData[$tbId]['all_san_bid_price']=$list1['all_san_bid_price'];
    			foreach($list1['list'] as $kaiBiaoRecordId=>$list2){
    				$showData[$tbId]['kai_biao_sort'][$kaiBiaoRecordId][$list2['show_bid_company']]+=$list2['show_bid_price'];
    				$showData[$tbId]['kai_biao_list'][$kaiBiaoRecordId]['transformer_type']=$typeList[$tbId][$kaiBiaoRecordId]['transformer_type'];
    				$showData[$tbId]['kai_biao_list'][$kaiBiaoRecordId]['number']=$this->sumTextareaNumber($typeList[$tbId][$kaiBiaoRecordId]['number']);
    				$showData[$tbId]['kai_biao_list'][$kaiBiaoRecordId]['show_bid_price']=$list2['show_bid_price'];
    				$showData[$tbId]['kai_biao_list'][$kaiBiaoRecordId]['show_bid_company']=$list2['show_bid_company'];
    				$showData[$tbId]['kai_biao_list'][$kaiBiaoRecordId]['my_company_price_show']=$list2['my_company_price'] ? $list2['my_company_price'] : SelectConstent::WEI_TOU;
    				$showData[$tbId]['kai_biao_list'][$kaiBiaoRecordId]['my_company_price']=$list2['my_company_price'];
    				$showData[$tbId]['kai_biao_list'][$kaiBiaoRecordId]['show_sum_company_price']=$list1['sum_company_price'][$list2['show_bid_company']];
    				$showData[$tbId]['sort_key'][$kaiBiaoRecordId]=$list1['sum_company_price'][$list2['show_bid_company']];
    				//占比
    				if($kaiBiaoList[$tbId]['all_bid_price'])
    					$showData[$tbId]['kai_biao_list'][$kaiBiaoRecordId]['zhan_bi']=(round(($list1['sum_company_price'][$list2['show_bid_company']]/$kaiBiaoList[$tbId]['all_bid_price']*100),2)).'%';
    				$showData[$tbId]['kai_biao_list'][$kaiBiaoRecordId]['xiangcha_bid_price'] = $list2['show_bid_price'];
    				if($list2['my_company_price'] && $list2['show_bid_price'] && $list2['show_bid_company']!=MY_COMPANY)
    					$showData[$tbId]['kai_biao_list'][$kaiBiaoRecordId]['xiangcha_bid_price'].='('.round((($list2['show_bid_price']/$list2['my_company_price'])-1)*100,1).")";
    			}
    			arsort($showData[$tbId]['sort_key']);
    		}
    	}
    	return $showData;
    }
    
    public function sumTextareaNumber($numberString){
    	$numberString=str_replace(array("\n", "\r\n") , SelectConstent::EXPLODE_STRING, $numberString).SelectConstent::EXPLODE_STRING;
    	$number = @array_sum(explode(SelectConstent::EXPLODE_STRING,$numberString));
    	return $number;
    }
    
    
    public function getKaiBiaoRecordListById($kaiBiaoIdList){
    	$kaiBiaoIdList = @array_unique($kaiBiaoIdList);
    	$sql='select * from '.SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD.' ';
    	$whereData['kb_r_id'] = join($kaiBiaoIdList, SelectConstent::EXPLODE_STRING);
    	$sql .= $this->getSqlSelectForWhere($whereData);
    	$recordList = $this->fetchArray($sql);
    	foreach($recordList as $list){
    		if($list['bid']==BID_STR){
    			$showPrice[$list['tb_id']]['list'][$list['kb_r_id']]['show_bid_price']=$list['bid_price'];
    			$showPrice[$list['tb_id']]['list'][$list['kb_r_id']]['show_bid_company']=$list['bid_company'];
    			$showPrice[$list['tb_id']]['all_bid_price']+=$list['bid_price'];
    			$showPrice[$list['tb_id']]['sum_company_price'][$list['bid_company']]+=$list['bid_price'];
    		}
    		if($list['bid_company']==MY_COMPANY){
    			$showPrice[$list['tb_id']]['list'][$list['kb_r_id']]['my_company_price']=$list['bid_price'];
    			$showPrice[$list['tb_id']]['all_san_bid_price']+=$list['bid_price'];
    		}
    	}
    	
    	return $showPrice;
    }
    
    public function getZhongBiaoForWhereData($whereData,$sort=''){
    	$sql = "SELECT
    	c.id as tb_id,
    	c.tb_show_id as tb_show_id,
    	a.id as kb_r_id,
    	c.respective_regions as respective_regions,
    	c.respective_provinces as respective_provinces,
    	c.project_name as project_name,
    	c.tenderer as tenderer,
    	c.end_time as end_time,
    	a.transformer_type as transformer_type,
    	a.number as number 
    	FROM "
    	.SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT." as a ,"
    	.SelectConstent::TABLE_TOUBIAO." as c
    	where
    	a.tb_id=c.id  ";
    	$sql .= $this->getSqlSelectForWhere($whereData,true,'c.');
    	$sql .= " and c.kaibiao_number > 0 ";
    	if(!$sort) $sort='tb_show_id';
    	$sql .= " order by ".$sort.";";
    	$dateList = $this->fetchArray($sql);
    	return $dateList;
    }
    
}