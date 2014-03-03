<?php
/**
 *
 * @author john_yu
 * @date 2010-9-14
 */
class IndexAction extends APPBaseAction
{

    public function run () {
        $show = array();
        $this->getController()
            ->renderPartial( "index" , $show );
    }
}

