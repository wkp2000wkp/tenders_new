<?php
/**
 *
 * @author john_yu
 * @date 2010-9-15
 */
class QuoteController extends APPBaseController
{

    public $defaultAction = 'ilist';

    public function actions () {
        return array(
            
                'ilist' => 'QuoteListAction', 
                'iform' => 'QuoteFormAction', 
                'option' => 'QuoteOptionAction', 
                'ulist' => 'UploadFileQuoteListAction', 
                'uform' => 'UploadFileQuoteFormAction', 
                'uoption' => 'UploadFileQuoteOptionAction', 
        );
    }
}

