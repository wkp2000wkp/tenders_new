<?php
/**
 *
 * @author john_yu
 * @date 2010-9-15
 */
class BackendController extends APPBaseController
{

    public $defaultAction = 'main';

    public function actions () {
        return array(
            
                'bl' => 'BackUpListAction', 
                'bf' => 'BackUpFormAction', 
                'u' => 'UserListAction', 
                'ui' => 'UserFormAction', 
                'tf' => 'TendersFormAction', 
                'tbf' => 'TouBiaoFormAction', 
                'pl' => 'ProjectListAction', 
                'zb' => 'ZhaoBiaoListAction', 
                'tb' => 'TouBiaoListAction', 
                'main' => 'MainAction', 
                'bor' => 'BidOpeningRecordAction', 
                'up' => 'UploadFileFormAction', 
                'abor' => 'AjaxBidOpeningRecordAction', 
                'nbor' => 'NewBidOpeningRecordAction', 
                'nkbr' => 'NewKaiBaoAction', 
                
        );
    }
}

