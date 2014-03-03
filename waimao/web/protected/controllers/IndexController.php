<?php
/**
 *
 * @author john_yu
 * @date 2010-9-15
 * ��ҳ
 */
class IndexController extends APPBaseController
{

    public $defaultAction = 'login';

    public function actions () {
        return array(
                'login' => 'IndexLoginFormAction'
        );
    }
}