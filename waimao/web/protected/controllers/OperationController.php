<?php
/**
 *
 * @author john_yu
 * @date 2011-11-11
 * ��̨����
 */
class OperationController extends APPBaseController
{

    public $defaultAction = 'ir';

    public function actions () {
        return array(
            
                'izb' => 'AddZhaoBiaoFormAction', 
                'ir' => 'ImportBidOpeningRecordAction', 
                'er' => 'ExportBidOpeningRecordAction',
                'ekbr' => 'ExportKaiBiaoRecordAction',
                'ezbr' => 'ExportZhongBiaoRecordAction',
                'itb' => 'ImportTouBiaoRecordAction',
                'otb' => 'OptionTouBiaoRecordAction',
                'or' => 'OptionRecordAction',
                'our' => 'OptionBackUpRecordAction',
                'oufr' => 'OptionUploadFileRecordAction',
                'okbr' => 'OptionNewKaiBiaoRecordAction',
                'orkbr' => 'OptionReplaceKaiBiaoRecordAction',
                
        );
    }
}

