<?php
/**
 *
 * @author john_yu
 * @date 2010-11-14
 */
class TransformerTypeListAction extends BaseTongJiListAction
{
	
     public function run () {
     	$action = $this->getParam('action','');
     	$whereData = $this->getParam('search',array());
     	$show['search_html']=$this->getSerachHtml($whereData,$searchajax);
     	$show['table_list'] = $this->getTable($whereData);
     	$show['tpye_list'] = SelectConstent::getSelectKaiBiaoTransformerType();
     	$show['export_sort_list'] = array("checked"=>"tb_show_id","list"=>SelectConstent::getExportZhongBiaoSortList());
     	$show['tpye_list'][] = SelectConstent::ALL_TPYE_NAME;
        $this->getController()->render( "transformer_type_tongji_list_2" , $show );
    }
    
    public function getTable($whereData){
    	$showData=array();
    	$sql="select b.bid_company as bid_company,a.transformer_type as transformer_type,count(b.bid) as bid_count,sum(b.bid_price) as bid_price FROM ".SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT." as a ,".SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD." as b ,".SelectConstent::TABLE_TOUBIAO." as c where b.kb_r_id=a.id and a.tb_id=c.id ";
    	$whereData['bid'] = BID_STR;
    	$sql .= $this->getSqlSelectForWhere2($whereData);
    	$sql.='group by bid_company,transformer_type';
    	$dateList = $this->fetchArray($sql);
    	if($dateList){
			foreach($dateList as $list){
				if($list['transformer_type'] == SelectConstent::EXCLUDE_TRANSFORMER_TYPE) continue;
				//所有类型
				$showData['sort'][SelectConstent::ALL_TPYE_NAME][$list['bid_company']]+=$list['bid_price'];
				$showData['info'][SelectConstent::ALL_TPYE_NAME][$list['bid_company']]['bid_company']=$list['bid_company'];
				$showData['info'][SelectConstent::ALL_TPYE_NAME][$list['bid_company']]['bid_price']+=$list['bid_price'];
				$showData['info'][SelectConstent::ALL_TPYE_NAME][$list['bid_company']]['bid_count']+=$list['bid_count'];
				//分类型
				$showData['sort'][$list['transformer_type']][$list['bid_company']]+=$list['bid_price'];
				$showData['info'][$list['transformer_type']][$list['bid_company']]['bid_company']=$list['bid_company'];
				$showData['info'][$list['transformer_type']][$list['bid_company']]['bid_price']=$list['bid_price'];
				$showData['info'][$list['transformer_type']][$list['bid_company']]['bid_count']=$list['bid_count'];
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