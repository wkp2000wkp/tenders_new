<?php
/**
 *
 * @author john_yu
 * @date 2010-9-14
 */
class IndexLoginFormAction extends APPBaseAction
{

    public function run () {
        $show = array();
        if ($_POST) {
            if($user = $this->checkUserInfo()){
                $this->setUserInfo($user);
                Yii::app()->showbox
                    ->showMessageBox( 'login_success' , 'index.php?r=layouts/index' );
            }
            else {
                Yii::app()->showbox
                    ->showMessageBox( 'login_password_error' , '-1' );
            }
        }
        $this->getController()
            ->renderPartial( "login" , $show );
    }

    public function login () {
    }
    
    private function setUserInfo($user){
        $_SESSION['uid'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type'] = $user['user_type'];
    }
    
    private function checkUserInfo(){
        $list = array();
        Yii::app()->tablegear->dataTaseTable = SelectConstent::TABLE_USER;
        $sql = 'select * from '.SelectConstent::TABLE_USER.' where username="'.$_POST['username'].'" and password="'.$_POST['password'].'" limit 1';
        $list = Yii::app()->tablegear->getTableGearTool()->query($sql);
        if($list && $list[0]['user_type'] == 0)
            Yii::app()->showbox->showMessageBox( 'no_permissions' , '-1' );
        return $list[0];
    }
}

