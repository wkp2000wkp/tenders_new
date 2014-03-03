<?php
/**
 *
 * @author john_yu
 * @date 2010-11-14
 */
class BaseTongJiListAction extends APPBaseAction
{
    public function getTongJiDate($whereData,$allCompanyName='汇总'){

    	$showCompany = $dateList = array();
    	$html = '';
    	$dateList = $this->getTongjiDateByWhereDate($whereData);
    	if($dateList){
    		foreach($dateList as $list){
    			$searchDate['kb_r_id'][]=$list['kb_r_id'];
    		}
    		$searchDate['bid_company'] = MY_COMPANY;
    		$dateList2 = $this->getTongjiDateByWhereDate($searchDate);
    		if($dateList2)
    			$dateList = @array_merge($dateList,$dateList2);
    	}
    	if($dateList){
    		foreach($dateList as $list){
    			if($list['transformer_type'] == SelectConstent::EXCLUDE_TRANSFORMER_TYPE) continue;
    			if($list['bid_company'] == MY_COMPANY){
    				$myCompanyList[$list['transformer_type']][$list['kb_r_id']] += $list['bid_price'];
    				continue;
    			}
    			
     			$companyList [$list['bid_company']][$list['transformer_type']][$list['kb_r_id']] += $list['bid_price'];
    		}
    	}
    	if($companyList){
    		$allList = array();
    		foreach($companyList as $companyName => $list){
    			foreach( SelectConstent::getSelectKaiBiaoTransformerType() as $type){
    				if($list[$type]){
	    					$kaibiao_key=array_keys($list[$type]);
	    					if($myCompanyList[$type]){
	    						$showCompany[$companyName][$type]['my_price'] = array_sum(array_intersect_key($myCompanyList[$type],$list[$type]));
	    						$allList[$type]['my_price'] += $showCompany[$companyName][$type]['my_price'];
	    					}else{
	    						$showCompany[$companyName][$type]['my_price'] = 0;
	    					}
	    					$showCompany[$companyName][$type]['company_price'] = array_sum($list[$type]);
	    					$allList[$type]['company_price'] += $showCompany[$companyName][$type]['company_price'];
	    					$showCompany[$companyName][$type]['xiangcha'] = 0;
	    					
	    					if($showCompany[$companyName][$type]['company_price'] && $showCompany[$companyName][$type]['my_price']){
	    						$showCompany[$companyName][$type]['xiangcha'] = round((($showCompany[$companyName][$type]['company_price']/$showCompany[$companyName][$type]['my_price'])-1)*100,1)."%";
	    					}
    				}
    			}
    		}
    		foreach($allList as $type=>$list3){
	    		if($list3['company_price'] && $list3['my_price']){
	    			$allList[$type]['xiangcha'] = round((($list3['company_price']/$list3['my_price'])-1)*100,1)."%";
	    		}
    		}
    		$showCompany[$allCompanyName] = $allList;
    		
    	}
    	return $showCompany;
    }
    
    public function getTongjiCompanyList($whereData){
    	$showCompany = array();
    	$sql = "SELECT b.bid_company as bid_company,count(b.id) as bid_recored_count  FROM ".SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD." as b ,".SelectConstent::TABLE_TOUBIAO." as c where  b.tb_id=c.id  ";
    	$sql .= $this->getSqlSelectForWhere2($whereData);
    	$sql .= " group by bid_company order by bid_recored_count desc;";
    	$showCompany = $this->fetchArray($sql);
    	return $showCompany;
    }
    
    public function getTongjiDateByWhereDate($whereData){
    	$sql = "SELECT b.kb_r_id as kb_r_id,b.bid_company as bid_company,a.transformer_type as transformer_type,sum(b.bid_price) as bid_price FROM ".SelectConstent::TABLE_QUOTE_KAIBIAO_RESULT." as a ,".SelectConstent::TABLE_QUOTE_KAIBIAO_RECORD." as b ,".SelectConstent::TABLE_TOUBIAO." as c where b.kb_r_id=a.id and a.tb_id=c.id  ";
    	$sql .= $this->getSqlSelectForWhere2($whereData);
    	$sql .= " group by b.kb_r_id,b.bid_company,a.transformer_type;";
    	$dateList = $this->fetchArray($sql);
    	return $dateList;
    }
    
    
}