<?php
/**
 *
 * @author john_yu
 * @date 2010-9-15
 */
class LayoutsController extends APPBaseController
{

    public $defaultAction = 'index';

    public function actions () {
        return array(
            
                'left' => 'LeftAction', 
                'top' => 'TopAction', 
                'index' => 'IndexAction'
        );
    }
}

