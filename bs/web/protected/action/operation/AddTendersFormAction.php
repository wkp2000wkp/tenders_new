<?php
/**
 *
 * @author john_yu
 * @date 2010-9-19
 * ����б��¼
 */
class AddTendersFormAction extends APPBaseAction
{

    public function run () {
        $show = array();
        $this->getController()
            ->renderPartial( "bid_opening_record_form" , $show );
    }
}

