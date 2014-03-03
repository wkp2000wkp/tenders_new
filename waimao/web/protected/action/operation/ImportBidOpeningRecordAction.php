<?php
/**
 *
 * @author john_yu
 * @date 2010-10-10
 */
Yii::import( 'application.components.PHPExcelTool' );
class ImportBidOpeningRecordAction extends APPBaseAction
{

    public function run () {
        $tbId = $this->getParamForAbsIntval('tb_id',0);
        $show['flie_name'] = $_FILES["execl"]["name"];
        $show['flie_size'] = $_FILES["execl"]["size"] / 1024;
        $show['tb_id'] = $tbId;
        $touBiaoInfo = $this->getTouBiaoInfo($tbId);
        if($touBiaoInfo){
          $excelList = PHPExcelTool::readPHPExcelTool( $_FILES["execl"]["tmp_name"] );
          $tableKey = 0;
          if($excelList){
              foreach($excelList as $sheetKey => $sheetVal){
  	            foreach($sheetVal as $rowKey => $rowVal){
  	                if (is_numeric(strpos($rowVal[0],'序号'))){
  		                $tableKey++;
  				        $show['header_table_list'][$tableKey] = $rowVal;
  	                    
  	                }else{
  				        $show['show_table_list'][$tableKey][$rowKey] = $rowVal;
  	                }
  	            }
              }
          }
            $this->getController()->render( "impor_bid_open_record" , $show );
        }else{
            Yii::app()->showbox->showMessageBox( 'toubiao_no_exist' , '-1' );
        }
        
    }
    
    private function getTouBiaoInfo($tbId){
        $sql = 'select * from '.SelectConstent::TABLE_TOUBIAO.' where id='.$tbId;
        $info = Yii::app()->tablegear->query($sql);
        return ($info) ? $info[0] : array();
    }
    
}

