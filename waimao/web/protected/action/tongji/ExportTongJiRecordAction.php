<?php
/**
 *
 * @author john_yu
 * @date 2011-11-11
 */
Yii::import( 'application.components.PHPExcelTool' );
class ExportTongJiRecordAction extends BaseTongJiListAction
{

    public function run () {
        $whereData = $this->getParam('search');
        $searchajax = $this->getParam('searchajax');
        $allCompanyName = $searchajax['bid_company']."汇总";
        $data = $this->getTongJiDate($whereData,$allCompanyName);
        if(!$data){
        	Yii::app()->showbox->showMessageBox( 'no_data_submit' , '-1' );
        }
        $fileName = "TJ".date("Y-m-d");
        $phpExcelTool = new PHPExcelTool();
        $phpExcelTool->exportPHPExcelToolTongJi($data,$fileName);
    }
}