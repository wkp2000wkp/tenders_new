<?php
/**
 *
 * @author john_yu
 * @date 2010-11-14
 */
class DuiBiListAction extends BaseTongJiListAction
{
     public function run () {
     	$action = $this->getParam('actionfor','');
     	$whereData = $this->getParam('search',array());
     	$searchajax = $this->getParam('searchajax');
     	$allCompanyName = $searchajax['bid_company']."汇总";
     	$show['search_html']=$this->getSerachHtml($whereData,$searchajax);
     	if($action == 'search')
     		$show['table_html'] = $this->getTable($whereData,$allCompanyName);
        $this->getController()->render( "tongji_list" , $show );
    }
    
    public function getSerachHtml($whereData,$searchajax){
    	$show['data'] = $whereData;
    	$show['ajax_data'] = $searchajax;
    	return $this->getController()->renderPartial( "search_form" , $show ,true);
    }
    
    public function getTable($whereData,$allCompanyName=''){
    	$showCompany = $this->getTongJiDate($whereData,$allCompanyName);
    	if($showCompany){
    		$show['export_sort_list'] = array("checked"=>"tb_show_id","list"=>SelectConstent::getExportSortList());
    		$show['export_area_list'] = array("checked"=>"1","list"=>SelectConstent::getExportAreaList());
    		$show['company_list'] = $showCompany;
    		$html = $this->getController()->renderPartial( "tongji_table" , $show ,true);
    	}
    	return $html;
    }
}