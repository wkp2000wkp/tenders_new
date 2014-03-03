<?php
/**
 *
 * @author john_yu
 * @date 2010-11-14
 */
class AjaxGetKBCompanyListAction extends BaseTongJiListAction
{
     public function run () {
     	header("Content-type: text/html; charset=utf-8");
     	$whereData = $this->getParam('searchajax',array());
		$dateList = $this->getTongjiCompanyList($whereData);
     	if($dateList){
     		foreach($dateList as $companyName){
     			echo "<option value='{$companyName['bid_company']}'>{$companyName['bid_company']}({$companyName['bid_recored_count']})</option>";
     		}
     	}
    }
}