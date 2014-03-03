<?php
/**
 *
 * @author john_yu
 * @date 2011-11-11
 * 
 */
class ToolController extends APPBaseController
{

    public $defaultAction = 'orkbr';

    public function actions () {
        return array(
           
                'orkbr' => 'OptionReplaceKaiBiaoRecordAction',
                
        );
    }
}

