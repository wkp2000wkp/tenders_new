<?php
/**
 *
 * @author john_yu
 * @date 2011-11-11
 */
Yii::import( 'application.components.PHPExcelTool' );
class ExportKaiBiaoRecordAction extends APPBaseAction
{
	
    public function run () {
        $totals = array();
        $whereData = $this->getParam('search');
        $sort = $this->getParam('sort');
        $sort = (array_key_exists($sort,SelectConstent::getExportSortList())) ? $sort : ''; 
        $dateArea = $this->getParamForAbsIntval('area');
        $exportTable = $this->getParam('export');
        $this->getConnect();
        if(!in_array($sort,SelectConstent::getSpecialSort())){
        	$touBiaoData = $this->getTouBiaoData($whereData,$sort,$dateArea);
        }else{
        	$touBiaoData = $this->getTouBiaoDataByType($whereData,$sort,$dateArea);
        }
        if(!$touBiaoData){
            Yii::app()->showbox->showMessageBox( 'no_data_submit' , '-1' );
        }
        $fileName = "KBJL".date("Y-m-d");
        foreach($touBiaoData as $d){
        	$touBiaoIds[] = $d['id'];
        	$data['t'][$d['id']] = $d;
        }
		if(count($touBiaoIds) == 1){
	    	$fileName = "KBJL".date("Y")."(No_".$d['tb_show_id'].")";
		}
        $touBiaoIdString = join(",", $touBiaoIds);
        $resultAry = $this->getKaiBiaoResultData($touBiaoIdString,$sort);
        
        if($resultAry){
		        foreach($resultAry as $d){
			        $data['k'][$d['tb_id']][$d['id']] = $d;
					$kaiBiaoIds[] = $d['id'];
		        }
	        $kaiBiaoIdString = join(",", $kaiBiaoIds);
	        $recordAry = $this->getKaiBiaoRecordData($kaiBiaoIdString);
	        
        }
        mysql_close($this->connect);
        if($recordAry){
	        foreach($recordAry as $d){
		        $data['r'][$d['tb_id']][$d['kb_r_id']][$d['id']] = $d;
		        
		        if($d['bid'] == BID_STR){
			        $data['z'][$d['tb_id']][$d['kb_r_id']]['bid_company'] = $d['bid_company'];
			        $data['z'][$d['tb_id']][$d['kb_r_id']]['bid_price'] = $d['bid_price'];
		        }
		        if($d['bid_company'] == MY_COMPANY){
			        $data['z'][$d['tb_id']][$d['kb_r_id']]['my_bid_company'] = $d['bid_company'];
			        $data['z'][$d['tb_id']][$d['kb_r_id']]['my_bid_price'] = $d['bid_price'];
			        $data['z'][$d['tb_id']][$d['kb_r_id']]['pai_bid_number'] = count($data['r'][$d['tb_id']][$d['kb_r_id']]);
		        }
			    $data['z'][$d['tb_id']][$d['kb_r_id']]['all_bid_price'] += $d['bid_price'];
			    if($d ['bid_company'] != MY_COMPANY || $d ['bid_price'] )
			    	$data['z'][$d['tb_id']][$d['kb_r_id']]['num_bid_price'] += 1;
		        
	        }
        }
        $phpExcelTool = new PHPExcelTool();
        if(in_array($sort,SelectConstent::getSpecialSort()) ){
        	$data['k']=$resultAry;
        	$phpExcelTool->exportPHPExcelToolKaiBiaoOrderByType($data,$fileName);
        }else{
        	$phpExcelTool->exportPHPExcelToolKaiBiao($data,$fileName);
        }
    }
    
    public function getTouBiaoData($whereData,$sort,$dateArea=0){
		$sql = "select * from ".SelectConstent::TABLE_TOUBIAO."  ";
    	$sql .= $this->getSqlSelectForWhere($whereData);
    	if($dateArea){
			$sql .= " and kaibiao_number > 0 ";
		}
    	if(!$sort){
    		$sort = 'tb_show_id';
    	}
    	$sql .= " order by ".$sort;
		return $this->fetchArray($sql);
    }
    public function getTouBiaoDataByType($whereData,$sort,$dateArea=0){
		$sql = "select c.*,a.transformer_type as transformer_type from ".SelectConstent::TABLE_TOUBIAO."  as c , ".SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT.' as  a ';
    	$sql .= ' where a.tb_id=c.id ';
		$sql .= $this->getSqlSelectForWhere($whereData,true,'c.');
    	if($dateArea){
			$sql .= " and c.kaibiao_number > 0 ";
		}
    	if(!$sort){
    		$sort = 'c.tb_show_id';
    	}elseif($sort=='transformer_type'){
    		$sort='a.transformer_type';
    	}else{
    		$sort = 'c.'.$sort;
    	}
    	
    	$sql .= " order by ".$sort.',a.transformer_type';
		return $this->fetchArray($sql);
    }
    
    
    
    public function getKaiBiaoResultData($touBiaoIdString,$sort=""){
    	$sql = "select * from ".SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT." where is_deleted=0 and tb_id in (".$touBiaoIdString.")";
    	if($sort == "transformer_type" )
    		$sql .= " order by transformer_type,tb_id ";
		return $this->fetchArray($sql);
    }
    
    public function getKaiBiaoRecordData($kaiBiaoIdString){
    	$sql = "select * from ".SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD." where is_deleted=0 and kb_r_id in (".$kaiBiaoIdString.") order by bid_price ";
		return $this->fetchArray($sql);
    }
    
    public function getEexclData($whereData,$sort){
    	$touBiaoData = $this->$touBiaoData($whereData,$sort);
    	if($touBiaoData)
    		$dateList = $this->getShowData($touBiaoData);
    }
    
}