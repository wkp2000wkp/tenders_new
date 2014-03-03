<?php
/**
 *
 * @author john_yu
 * @date 2010-9-14
 */
class UploadFileFormAction extends APPBaseAction
{
    public function run () {
        $show = array();
        $touBiaoId = $this->getParamForAbsIntval('tb_id',0);
        $show['tou_biao_id'] = $touBiaoId;
        $show['uid'] = $this->getUid();
        $show['referer'] = $this->getParam('referer','');
        $this->getController()->render( "upload_file" , $show );
    }
}