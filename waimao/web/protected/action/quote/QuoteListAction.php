<?php
/**
 *
 * @author john_yu
 * @date 2010-9-14
 */
class QuoteListAction extends APPBaseAction
{
    public function run () {
        $action = $this->getParam('action','list');
        $history = $this->getParam('time','now');
        $show['action'] = $action;
        $whereData = $this->getParam('search',array());
        $this->setTableGear();
        if(!$whereData['bu_id']){
           $whereData['bu_id'] = ($history == 'history') ? -1 : SelectConstent::BACK_UP_ID ;
        }
        $show['search_html'] = $this->getSearchHtml($whereData,$history);
        $show['table_html'] = $this->getTable($whereData);
        $show['user_type'] = $this->getUserType();
        $show['history'] = $history;
        $this->getController()->render( "quote_list" , $show );
    }
    
    public function setTableGear(){
        Yii::app()->tablegear->headers = SelectConstent::getQuoteHeaders();
        Yii::app()->tablegear->transform = array(
          "id" => array(
              "tag"   => "input",
              "attrib" => array(
                "type" => 'radio',
                "name" => 'id',
                "value" => '{KEY}',
              ),
            ),
        );
        Yii::app()->tablegear->dataTaseTable=SelectConstent::TABLE_QUOTE;
        Yii::app()->tablegear->addNewRows = false;
        Yii::app()->tablegear->editable = false;
        Yii::app()->tablegear->table = array('class'=>'quote_list_table');
        Yii::app()->tablegear->form = array('id'=>'ZBForm','method'=>'post');
        Yii::app()->tablegear->noAutoQuery = true;
    }
    
    public function getTable ($whereData) {
        Yii::app()->tablegear->getTableGearTool()->database["sort"] = "id desc";
        $sql = $this->getSqlSelect(SelectConstent::TABLE_QUOTE,array_keys(Yii::app()->tablegear->getTableGearTool()->headers),$whereData);
        Yii::app()->tablegear->fetchData($sql);
        return Yii::app()->tablegear->getTableGearTool()->getTable(false); 
    }
    
    public function getSearchHtml($whereData,$history){
        if($history == 'history'){
            $show['back_up_list'] = $this->getBackUpList();
            $show['history'] = 'history';
        }
        $show['data'] = $whereData;
        return $this->getController()->renderPartial( "search_form" , $show ,true);
    }
    
    private function getBackUpList(){
        $sql = 'select * from '.SelectConstent::TABLE_QUOTE_BACKUP.' where 1 and is_deleted = 0 order by id desc';
        Yii::app()->tablegear->getTableGearTool()->pagination = array();
        $backUpList = Yii::app()->tablegear->getTableGearTool()->query($sql);
        if(!$backUpList){
            $backUpList = array();
        }
        return $backUpList;
    }
    
}

