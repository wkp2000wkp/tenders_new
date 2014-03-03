<?php
/**
 *
 * @author john_yu
 * @date 2010-9-14
 */
class BidOpeningRecordAction extends APPBaseAction
{

    public function run () {
        $touBiaoId = $this->getParamForAbsIntval('id',0);
        $referer = $this->getParam('referer','');
        $show = array();
        $show['referer'] = $referer ? $referer : $_SERVER['HTTP_REFERER'];
        if($touBiaoId){
	        $show['tou_biao_id'] = $touBiaoId;
	        $show['table_html'] = $this->getUploadFileList($touBiaoId);
	        $this->getController()->render( "bid_opening_record_form" , $show );
        }else{
            Yii::app()->showbox->showMessageBox( 'no_data_submit' , '-1' );
        }
    }
    
    private function getUploadFileList($touBiaoId){
        Yii::app()->tablegear->headers = array(
        		'id' => ' ', 
                'file_name' => '文件名', 
                'date_time' => '上传日期', 
                'path_name' => '文件下载', 
                'remark' => '备注',
        );
        Yii::app()->tablegear->transform = array(
          "id" => array(
              "tag"   => "input",
              "attrib" => array(
                "type" => 'radio',
                "name" => 'id',
                "value" => '{KEY}',
              ),
            ),
          "remark" => array(
              "tag"   => "span",
              "html" => "{DATA}",
              "attrib" => array(
                "id" =>"remark_{KEY}",
              )
            ),
          "path_name" => array(
              "tag"   => "a",
              "html" => "【点击下载】",
              "attrib" => array(
				"target" => "_blank",
                "href" => URL_DOMAIN."/upload/{DATA}",
              )
            )
          );
        Yii::app()->tablegear->dataTaseTable = SelectConstent::TABLE_UPLOADFILE;
        Yii::app()->tablegear->noAutoQuery = true;
        Yii::app()->tablegear->editable = array();
        Yii::app()->tablegear->form = array('id'=>'ZBForm','method'=>'post');
        Yii::app()->tablegear->getTableGearTool()->pagination = array();
        $whereDate=array('tb_id'=>$touBiaoId);
        $sql = $this->getSqlSelect(Yii::app()->tablegear->dataTaseTable,array_keys(Yii::app()->tablegear->headers),$whereDate);
        Yii::app()->tablegear->getTableGearTool()->fetchData($sql);
        $show['table_html'] = Yii::app()->tablegear->getTable();
        return $this->getController()->renderPartial( "/layouts/project_list" , $show,true);
    }
    
}

