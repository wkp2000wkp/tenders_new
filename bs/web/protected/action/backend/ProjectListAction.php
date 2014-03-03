<?php
/**
 *
 * @author john_yu
 * @date 2010-9-14
 */
class ProjectListAction extends APPBaseAction
{

    public function run () {
        
        Yii::app()->tablegear->headers = array(
            
                'id' => '序列号', 
                'bidder' => '投标人', 
                'date_time' => '日期', 
                'price' => '价格',
                'number' => '数量',
                'bid_status' => '是否中标',
                'bid_status' => '是否中标',
                'remark' => '备注',
        );
        Yii::app()->tablegear->dataTaseTable = 'san_kaibiao';
        Yii::app()->tablegear->shiftColumns = array( "操作" => 'last' );
        Yii::app()->tablegear->transform = array(
          "操作" => array(
              "tag"   => "a",
              "html" => "修改",
              "attrib" => array(
                "href" => URL_DOMAIN."/index.php?r=backend/bor&id={KEY}",
              )
            )
          );
          
          
        $show['table_html'] = Yii::app()->tablegear->getTable();
        $show['table_script_html'] = Yii::app()->tablegear->getJavascript();
        $this->getController()->renderPartial( "/layouts/project_list" , $show );
//        $show = array();
//        echo $this->getController()->renderPartial( "result" , $show );
    }
}

