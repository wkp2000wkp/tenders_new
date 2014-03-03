<?php
class ShowMessage extends CWidget
{

    const SUCCESS = '';

    const FAILURE = ' class="tips_wrong" ';

    public function showMessageBox ($showLangCode, $jumpUrl) {
        Yii::import( 'application.components.ShowLang' );
        $showAry = array();
        $showAry['show_lang'] = ShowLang::getLanguage( $showLangCode );
        $showAry['jump_url'] = $jumpUrl;
        $this->getController()
            ->renderPartial( "/components/showmessage" , $showAry );
        exit();
    }
}
