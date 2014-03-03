<?php
/**
 *
 * @author john_yu
 * @date 2013-03-22
 */
class BidCompanyListAction extends BaseTongJiListAction
{
     public function run () {
     	$action = $this->getParam('action','');
     	$whereData = $this->getParam('search',array());
     	$show['search_html']=$this->getSerachHtml($whereData,$searchajax);
     	$show['table_list'] = array();
     	$show['export_sort_list'] = array("checked"=>"tb_show_id","list"=>SelectConstent::getExportZhongBiaoSortList());
     	if($action == 'search')
     		$show['table_list'] = $this->getTableData($whereData);
        $this->getController()->render( "bid_company_tongji_list" , $show );
    }
    
    public function getTableData($whereData){
    	$showData = array();
    	$sql = "SELECT b.bid_company as bid_company,a.transformer_type as transformer_type,b.bid as bid,b.bid_price as bid_price FROM ".SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT." as a ,".SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD." as b ,".SelectConstent::TABLE_TOUBIAO." as c where b.kb_r_id=a.id and a.tb_id=c.id  ";
    	$sql .= $this->getSqlSelectForWhere2($whereData);
    	$sql .= " order by bid_company;";
    	$dateList = $this->fetchArray($sql);
    
    	if($dateList){
    		foreach($dateList as $date){
    			if($date['transformer_type'] == SelectConstent::EXCLUDE_TRANSFORMER_TYPE) continue;
    			$showData['info'][$date['bid_company']][$date['transformer_type']]['number'] += 1;
    			if($date['bid'] == BID_STR){
	    			$showData['info'][$date['bid_company']][$date['transformer_type']]['bid_price'] += $date['bid_price'];
    				$showData['info'][$date['bid_company']][$date['transformer_type']]['bid_number'] += 1;
    			}
    		}
    		//过滤未中标数据
    		foreach($showData['info'] as $bid_company=>$list){
    			foreach( SelectConstent::getSelectKaiBiaoTransformerType() as $type){
    				if($list[$type]['bid_number']):
    					$showData['info'][$bid_company]['all_price'] += $list[$type]['bid_price'];
    					$showData['info'][$bid_company]['all_number'] += $list[$type]['number'];
    					$showData['info'][$bid_company]['all_bid_number'] += $list[$type]['bid_number'];
    					$showData['sort'][$bid_company] += $list[$type]['bid_price'];
    				endif;
    			}
    		}
    		//过滤结果无任何中标信息
    		if($showData['sort']){
    			arsort($showData['sort']);
    		}
    	}
    	return $showData;
    }
    

    public function getSerachHtml($whereData,$searchajax){
    	$show['data'] = $whereData;
    	$show['back_up_list']=$this->getBackUpList();
    	return $this->getController()->renderPartial( "bid_company_search_form" , $show ,true);
    }
    
    private function getBackUpList(){
    	$sql = 'select * from '.SelectConstent::TABLE_BACKUP.' where 1 and is_deleted = 0 order by id desc';
    	$backUpList = $this->fetchArray($sql);
    	if(!$backUpList){
    		$backUpList = array();
    	}
    	return $backUpList;
    }
    
}
