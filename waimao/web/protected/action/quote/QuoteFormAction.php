<?php
/**
 *
 * @author john_yu
 * @date 2010-9-19
 */
class QuoteFormAction extends APPBaseAction
{

    public function run () {
        $show = array();
        $touBiaoId = $this->getParamForAbsIntval('id',0);
        $show['data'] = array();
        if($touBiaoId){
            $show['data'] = $this->getTouBiaoData($touBiaoId);
        }else{
            Yii::app()->showbox->showMessageBox( 'no_data_submit' , '-1' );
        }
        $this->getController()->render( "toubiao_form" , $show );
    }
    
    private function getTouBiaoData($touBiaoId){
        $list = array();
        if($touBiaoId){
          Yii::app()->tablegear->dataTaseTable = SelectConstent::TABLE_TOUBIAO;
          $sql = 'select * from '.SelectConstent::TABLE_TOUBIAO.' where id='.$touBiaoId.' limit 1';
          $list = Yii::app()->tablegear->getTableGearTool()->query($sql);
        }
        $this->checkPermissions( $list[0]['uid']);
        return $list[0];
    }
    
}

