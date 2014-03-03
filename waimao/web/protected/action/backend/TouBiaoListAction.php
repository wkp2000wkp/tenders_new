<?php
/**
 *
 * @author john_yu
 * @date 2010-9-14
 */
class TouBiaoListAction extends APPBaseAction
{
    public function run () {
    	
        $action = $this->getParam('action','list');
        $history = $this->getParam('time','now');
        $page = $this->getParamForAbsIntval('page','1');
        $page = ($page > 0 ) ? $page : 1;
        $show['action'] = $action;
        $whereData = $this->getParam('search',array());
        if(!$whereData['bu_id']){
           $whereData['bu_id'] = ($history == 'history') ? -1 : SelectConstent::BACK_UP_ID ;
        }
        $show['table_html'] = $this->getFixedHeaderTable($whereData,$page);
        $show['export_sort_list'] = array("checked"=>"tb_show_id","list"=>SelectConstent::getExportSortList());
        $show['export_area_list'] = array("checked"=>"1","list"=>SelectConstent::getExportAreaList());
        $show['search_html'] = $this->getSearchHtml($whereData,$history);
        $show['totals'] = $this->getTotalsInfo($whereData);
        $show['user_type'] = $this->getUserType();
        $show['kaibiao_logo'] = $this->getTouBiaoData($whereData);
        $show['history'] = $history;
        $this->getController()->render( "toubiao_list" , $show );
    }
    
    public function getFixedHeaderTable($whereData,$page){
    	$this->getConnect();
    	$sql = 'select SQL_CALC_FOUND_ROWS * from '.SelectConstent::TABLE_TOUBIAO;
    	$sql .= $this->getSqlSelectForWhere($whereData);
    	$sql .= ' order by tb_show_id desc ';
    	$sql .= ' limit '.(($page-1)*$this->pageSize).','.$this->pageSize;
    	$toubiaoList = $this->fetchArray($sql);
    	foreach($toubiaoList as $key => $value){
    		$toubiaoList[$key]['id']="<input type='radio' value='{$value['id']}' name='id'>";
    		$toubiaoList[$key]['project_name']="<a id='{$value['id']}' class='fixed_css_a' target='_blank' href='".URL_DOMAIN."/index.php?r=backend/abor&id={$value['id']}'>{$value['project_name']}</a>";
    	}
    	$show['table_list'] = $toubiaoList;
    	$show['table_header'] = SelectConstent::getTouBiaoHeaders();
    	$show['pagination_html'] = $this->getTablePaginationHtml($page);
    	return $this->getController()->renderPartial( "/layouts/fixed_header_table_list" , $show ,true);
    }

  
    public function getSearchHtml($whereData,$history){
        if($history == 'history'){
            $show['back_up_list'] = $this->getBackUpList();
            $show['history'] = 'history';
        }
        $show['data'] = $whereData;
        return $this->getController()->renderPartial( "search_form" , $show ,true);
    }
    
    public function getTotalsInfo($whereData){
    	$this->getConnect();
        $sql = 'select bid_bond,san_bid_all_price,san_bid_price from '.SelectConstent::TABLE_TOUBIAO.$this->getSqlSelectForWhere($whereData);
        $dataAll = $this->fetchArray($sql);
        $totals['count_toubiao_bod'] = count($dataAll);
        $totals['total_toubiao_bod'] = $this->sumData($dataAll, 'san_bid_all_price');
        $totals['total_bid_bod'] = $this->sumData($dataAll, 'san_bid_price');
        if(!$whereData['bid'] ||  $whereData['bid'] == '是'){
	        $whereData['bid']='是';
	        $sql = 'select bid_bond,san_bid_all_price,san_bid_price from '.SelectConstent::TABLE_TOUBIAO.$this->getSqlSelectForWhere($whereData);
	        $bidDataAry = $this->fetchArray($sql);
	        $totals['count_bid_bod'] = count($bidDataAry);
        }else{
            $totals['count_bid_bod'] = 0;
        }
        $totals['bid_percent'] = ($totals['count_toubiao_bod']) ? (round($totals['count_bid_bod']/$totals['count_toubiao_bod'] * 100 ,2)) : 0;
        $totals['total_bid_percent'] = ($totals['total_toubiao_bod']) ? (round($totals['total_bid_bod']/$totals['total_toubiao_bod'] * 100 ,2)) : 0;
        return $totals;
    }
    
    private function getBackUpList(){
        $sql = 'select * from '.SelectConstent::TABLE_BACKUP.' where 1 and is_deleted = 0 order by id desc';
        $backUpList = $this->fetchArray($sql);
        if(!$backUpList){
            $backUpList = array();
        }
        return $backUpList;
    }
    
	private function getTouBiaoData($whereData){
		$kaiBiaoStatusList = $selectIdAry = $kaiBiaoList = array();
		$this->getConnect();
		$sql = "select id,kaibiao_number from ".SelectConstent::TABLE_TOUBIAO." ";
    	$sql .= $this->getSqlSelectForWhere($whereData);
		$toubiaoList = $this->fetchArray($sql);
		if($toubiaoList){
			foreach($toubiaoList as $list1) :
				if($list1['kaibiao_number'] > 0) $selectIdAry[] = $list1['id'];
				$kaiBiaoStatusList[$list1['id']]=array('id'=>$list1['id'],'status'=>SelectConstent::TOUBIAO_BID_STATUS_NONE);
			endforeach;
		}
		if($selectIdAry){
			$whereData2['tb_id']=join(SelectConstent::EXPLODE_STRING,$selectIdAry);
			$sql = "select tb_id,kb_r_id,bid,bid_company from ".SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD." ";
			$sql .= $this->getSqlSelectForWhere($whereData2);
			$kaiBiaoList = $this->fetchArray($sql);
		}
		if($kaiBiaoList){
			foreach($kaiBiaoList as $list2):
				$checkList[$list2['tb_id']]['company_number'][] = $list2['kb_r_id'];
				if($list2['bid']==BID_STR) $checkList[$list2['tb_id']]['bid_number'] += 1;
				$checkList[$list2['tb_id']]['bid_company']=($list2['bid_company'] == MY_COMPANY && $list2['bid']==BID_STR) ? $list2['bid_company'] : $checkList[$list2['tb_id']]['bid_company'];
			endforeach;
			foreach($toubiaoList as $list1){
				$companyNumber = count(@array_unique($checkList[$list1['id']]['company_number']));
				$status = ($checkList[$list1['id']]) ? SelectConstent::TOUBIAO_BID_STATUS_NO : SelectConstent::TOUBIAO_BID_STATUS_NONE;
				$status = ($checkList[$list1['id']]['bid_number'] == $companyNumber && !empty($companyNumber)) ? SelectConstent::TOUBIAO_BID_STATUS_OK : $status;
				$status = ($checkList[$list1['id']]['bid_company'] == MY_COMPANY) ? SelectConstent::TOUBIAO_BID_STATUS_YES : $status;
				$kaiBiaoStatusList[$list1['id']]=array('id'=>$list1['id'],'status'=>$status);
			}
		}
		return $kaiBiaoStatusList;
    }

    
}

