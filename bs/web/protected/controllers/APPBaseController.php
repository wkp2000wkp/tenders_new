<?php
Yii::import( 'application.action.APPBaseAction' , TRUE );
class APPBaseController extends CController
{

    public $keywords = '';

    public $description = '';

    /**
     * @param string $words
     */
    public function setKeywords ($words) {
        $this->keywords = $words;
    }

    /**
     * @param string $description
     */
    public function setDescription ($description) {
        $this->description = $description;
    }
}
    
    