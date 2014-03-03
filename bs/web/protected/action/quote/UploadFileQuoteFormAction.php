<?php
/**
 *
 * @author john_yu
 * @date 2011-1-12
 */
class UploadFileQuoteFormAction extends APPBaseAction
{
    public function run () {
        $show = array();
        $quoteId = $this->getParamForAbsIntval('quote_id',0);
        $show['uid'] = $this->getUid();
        $show['quote_id'] = $quoteId;
        $show['referer'] = $this->getParam('referer','');
        $this->getController()->render( "upload_form" , $show );
    }
}