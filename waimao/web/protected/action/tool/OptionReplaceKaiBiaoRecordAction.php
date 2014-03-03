<?php
/**
 *
 * @author john_yu
 * @date 2013-03-22
 */
class OptionReplaceKaiBiaoRecordAction extends BaseTongJiListAction
{
     public function run () {
     	$action = $this->getParam('action','');
     	$whereData = $this->getParam('search',array());
     	$data = $this->getParam('data','');
     	$form = $this->getParam('form','');
     	$show['table_list'] = array();
     	if($action == 'replace' && $data['tb_id']){
     		$this->optionReplaceKaiBiaoCompany($data['tb_id'],$form['find'],$form['replace']);
     		$data['bid_company'] = $form['replace'];
     	}
     	if($action == 'search')
     		$show['table_list'] = $this->getTableData($whereData);
    	$show['data'] = $whereData;
    	$show['back_up_list']=$this->getBackUpList();
      $this->getController()->render( "replace_kaibiao_search_form" , $show );
    }
    
    private function getBackUpList(){
    	$sql = 'select * from '.SelectConstent::TABLE_BACKUP.' where 1 and is_deleted = 0 order by id desc';
    	$backUpList = $this->fetchArray($sql);
    	if(!$backUpList){
    		$backUpList = array();
    	}
    	return $backUpList;
    }
    public function getTableData($whereData){
    	$showData = $return = array();
    	$sql = "SELECT c.id as tb_id,c.tb_show_id as tb_show_id,b.bid_company as bid_company,count(b.kb_r_id) as kb_count FROM ".SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT." as a ,".SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD." as b ,".SelectConstent::TABLE_TOUBIAO." as c where b.kb_r_id=a.id and a.tb_id=c.id  ";
    	$sql .= $this->getSqlSelectForWhere2($whereData);
    	$sql .= " group by tb_id,bid_company order by bid_company;";
    	$showData = $this->fetchArray($sql);
    	if($showData){
	    	foreach($showData as $list){
	    		$return[$list['bid_company']]['tb_show_id'][] = $list['tb_show_id'];
	    		$return[$list['bid_company']]['tb_id'][] = $list['tb_id'];
	    		$return[$list['bid_company']]['kb_count'] +=$list['kb_count'];
	    	}
    	}
    	return $return;
    }
    
    public function optionReplaceKaiBiaoCompany($keiBiaoList,$findStr,$replaceStr){
    	$sql="UPDATE ".SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD." SET `bid_company` = replace(bid_company, '".$findStr."', '".$replaceStr."') ";	
    	$whereData['tb_id']=join(array_unique($keiBiaoList),SelectConstent::EXPLODE_STRING);
    	$sql .= $this->getSqlSelectForWhere($whereData);
    	return $this->query($sql);
    	
    }
}