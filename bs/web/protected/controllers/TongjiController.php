<?php
/**
 *
 * @author john_yu
 * @date 2010-9-15
 */
class TongjiController extends APPBaseController
{

    public $defaultAction = 'duibi';

    public function actions () {
        return array(
            
                'duibi' => 'DuiBiListAction', 
                'getkbc' => 'AjaxGetKBCompanyListAction', 
                'ertj' => 'ExportTongJiRecordAction', 
                'ertjkb' => 'ExportTongJiKaiBiaoRecordAction', 
                'ertjdbkb' => 'ExportTongJiDuiBiKaiBiaoRecordAction', 
                'ertjzbkb' => 'ExportTongJiZhongBiaoKaiBiaoRecordAction', 
                'bcl' => 'BidCompanyListAction', 
                'ttl' => 'TransformerTypeListAction', 

        );
    }
}

