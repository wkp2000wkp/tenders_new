<?php
/**
 *
 * @author john_yu
 * @date 2010-9-14
 */
class MainAction extends APPBaseAction
{

    public function run () {
        $show = array();
        $this->getController()
            ->render( "main" , $show );
    }
}

