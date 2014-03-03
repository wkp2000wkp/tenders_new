<?php
/**
 *
 * @author john_yu
 * @date 2010-9-14
 */
class TopAction extends APPBaseAction
{

    public function run () {
        $show = array();
        $show['username'] = $this->getUserName();
        $this->getController()
            ->renderPartial( "top" , $show );
    }
}

