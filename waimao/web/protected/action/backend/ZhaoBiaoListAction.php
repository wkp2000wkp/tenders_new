<?php
/**
 *
 * @author john_yu
 * @date 2010-9-14
 */
class ZhaoBiaoListAction extends APPBaseAction
{

    public function run () {
        $whereData = $this->getParam('search',array());
        $page = $this->getParamForAbsIntval('page','1');
        $page = ($page > 0 ) ? $page : 1;
        $show['search_html'] = $this->getSearchHtml($whereData);
        $show['table_html'] .= $this->getFixedHeaderTable($whereData,$page);
        $show['user_type'] = $this->getUserType();
        $this->getController()->render( "zhaobiao_list" , $show );
    }
    
    public function getTable($whereData){
        Yii::app()->tablegear->dataTaseTable = SelectConstent::TABLE_ZHAOBIAO;
        Yii::app()->tablegear->headers = SelectConstent::getZhaoBiaoHeaders();
        Yii::app()->tablegear->sortable = array( "project_name","bidding_agent","tenderer","specification","transformer_type","number","slesman","end_time","tender_manager","respective_regions","tender_fee","bid_bond﻿"  );
        Yii::app()->tablegear->transform = array(
          "id" => array(
              "tag"   => "input",
              "attrib" => array(
                "type" => 'radio',
                "name" => 'zb_id',
                "value" => '{DATA}',
              )
            ),
        );
        Yii::app()->tablegear->custom = array("FORM_TOP" => array( "tag"   => "h3", "html"   => '招标项目公示'));
        Yii::app()->tablegear->editable = false;
        Yii::app()->tablegear->table = array('class'=>'zhaobiao_biao_list_table');
        Yii::app()->tablegear->form = array('id'=>'ZBForm','method'=>'post');
        Yii::app()->tablegear->noAutoQuery = true;
        $sql = $this->getSqlSelect(Yii::app()->tablegear->dataTaseTable,array_keys(Yii::app()->tablegear->headers),$whereData);
        Yii::app()->tablegear->fetchData($sql);
        $show['table_html'] = Yii::app()->tablegear->getTable();
        return $this->getController()->renderPartial( "/layouts/project_list" , $show ,true);
    }
    
    public function getFixedHeaderTable($whereData,$page){
    	$this->getConnect();
    	$sql = 'select SQL_CALC_FOUND_ROWS * from '.SelectConstent::TABLE_ZHAOBIAO;
    	$sql .= $this->getSqlSelectForWhere($whereData);
    	$sql .= ' order by id desc ';
    	$sql .= ' limit '.(($page-1)*$this->pageSize).','.$this->pageSize;
    	$toubiaoList = $this->fetchArray($sql);
    	foreach($toubiaoList as $key => $value){
    		$toubiaoList[$key]['id']="<input type='radio' value='{$value['id']}' name='zb_id'>";
    	}
    	$show['table_list'] = $toubiaoList;
    	$show['table_header'] = SelectConstent::getZhaoBiaoHeaders();
    	$show['pagination_html'] = $this->getTablePaginationHtml($page);
    	return $this->getController()->renderPartial( "/layouts/fixed_header_table_list" , $show ,true);
    }
    
    public function getSearchHtml($whereData){
        $show['data'] = $whereData;
        return $this->getController()->renderPartial( "search_form" , $show ,true);
    }
}

