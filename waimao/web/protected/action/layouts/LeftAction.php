<?php
/**
 *
 * @author john_yu
 * @date 2010-9-14
 */
class LeftAction extends APPBaseAction
{

    public function run () {
        $show = array();
        $show['user_type'] = $this->getUserType();
        $this->getController()
            ->renderPartial( "left" , $show );
    }
}

