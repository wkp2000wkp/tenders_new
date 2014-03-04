<?php
/**
 *
 * @author john_yu
 * @date 2010-9-14
 */
Yii::import( 'application.components.PHPExcelTool' );
class ExportBidOpeningRecordAction extends APPBaseAction
{

    public function run () {
        $totals = array();
        $whereData = $this->getParam('search');
        $exportTable = $this->getParam('export');
        $sort = $this->getParam('sort');
        $dateArea = $this->getParamForAbsIntval('area');
        if($exportTable == 'zb'){
            $tableName = SelectConstent::TABLE_ZHAOBIAO;
            $headers = SelectConstent::getZhaoBiaoHeaders();
        }elseif($exportTable == 'tb'){
        	$sort = (array_key_exists($sort,SelectConstent::getExportSortList())) ? $sort : 'tb_show_id'; 
            $tableName = SelectConstent::TABLE_TOUBIAO;
            $headers = SelectConstent::getTouBiaoHeaders();
        }elseif($exportTable == 'quote'){
            $tableName = SelectConstent::TABLE_QUOTE;
            $headers = SelectConstent::getQuoteHeaders();
        }else{
            Yii::app()->showbox->showMessageBox( 'no_data_submit' , '-1' );
        }
        $this->getConnect();
        $data = $this->getData($tableName,$headers,$whereData,$sort,$dateArea);
        if(!$data){
            Yii::app()->showbox->showMessageBox( 'no_data_submit' , '-1' );
        }
        if($exportTable == 'tb')
            $totals = $this->getTotalsInfo($whereData);
        mysql_close($this->connect);
        $phpExcelTool = new PHPExcelTool();
        $phpExcelTool->exportPHPExcelTool($data,$headers,$totals);
    }
    
    public function getData($tableName,$headers,$whereData,$sort='',$dateArea=0){
    	$headersAry=array_keys($headers);
    	$headersAry[]='bid_fee_value';
    	$headersAry[]='bid_fee_sort_other';
    	$headersAry[]='other_currency';
		$sql = $this->getSqlSelect($tableName,$headersAry,$whereData);
		if($dateArea){
			$sql .= " and kaibiao_number > 0 ";
		}
		if($sort){
			$sql .= " order by ".$sort;
		}
		return $this->fetchArray($sql);
    }
    
    public function getTotalsInfo($whereData){
      $sql = 'select bid_bond,san_bid_all_price,san_bid_price from '.SelectConstent::TABLE_TOUBIAO.$this->getSqlSelectForWhere($whereData);
      $dataAll = $this->fetchArray($sql);  
        $totals['count_toubiao_bod'] = count($dataAll);
        $totals['total_toubiao_bod'] = $this->sumData($dataAll, 'san_bid_all_price');
        $totals['total_bid_bod'] = $this->sumData($dataAll, 'san_bid_price');
        if(!$whereData['bid'] ||  $whereData['bid'] == '是'){
	        $whereData['bid']='是';
	        $sql = 'select bid_bond,san_bid_all_price,san_bid_price from '.SelectConstent::TABLE_TOUBIAO.$this->getSqlSelectForWhere($whereData);
	        $dataAll = $this->fetchArray($sql);  
	        $totals['count_bid_bod'] = count($dataAll);
        }else{
            $totals['count_bid_bod'] = 0;
        }
        $totals['bid_percent'] = ($totals['count_toubiao_bod']) ? (round($totals['count_bid_bod']/$totals['count_toubiao_bod'] * 100 ,2)) : 0;
        $totals['total_bid_percent'] = ($totals['total_toubiao_bod']) ? (round($totals['total_bid_bod']/$totals['total_toubiao_bod'] * 100 ,2)) : 0;
        return $totals;
    }
    
    private function arraySum($data,$key){
        $sumNumber = 0;
        if($data){
            foreach($data as $row){
                $sumNumber += intval($row[$key]);
            }
        }
        return $sumNumber;
    }
    
}