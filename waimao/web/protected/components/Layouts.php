<?php
Yii::import( 'application.action.service.LayoutsTopService' );
Yii::import( 'application.action.service.LayoutsLeftService' );
Yii::import( 'application.action.service.LayoutsBottomService' );
class Layouts extends CWidget
{

    private $visitUrl = null;

    public function setVisitUrl ($visitUrl = null) {
        $navigationList = LayoutsTopService::getTopNavigationList();
        if (!array_key_exists( $visitUrl , $navigationList )) {
            $this->visitUrl = LayoutsTopService::NAVIGATION_INDEX;
        }
        else {
            $this->visitUrl = $visitUrl;
        }
    }

    public function render ($view, $data = null, $return = false) {
        $show['top'] = LayoutsTopService::getInstance()->getLayouts( $this->visitUrl );
        $show['left'] = LayoutsLeftService::getInstance()->getLayouts();
        $show['right'] = $this->getController()
            ->renderPartial( $view , $data , true );
        $show['bottom'] = LayoutsBottomService::getInstance()->getLayouts( $this->visitUrl );
        $show['page_html'] = $data['page_html'];
        $this->getController()
            ->render( "/layouts/rate_main" , $show , $return );
    }

    /**
     *
     * @param int $view
     * @param array $data
     * @param string $return
     */
    public function renderOld ($view, $data = null, $return = false) {
        $show['top'] = LayoutsTopService::getInstance()->getLayouts( $this->visitUrl );
        $show['left'] = LayoutsLeftService::getInstance()->getLayouts();
        $show['right'] = $this->getController()
            ->renderPartial( $view , $data , true );
        $show['bottom'] = LayoutsBottomService::getInstance()->getLayouts( $this->visitUrl );
        $show['page_html'] = $data['page_html'];
        $this->getController()
            ->render( "/layouts/rate_main_mala" , $show , $return );
    }

    public function renderSimple ($view, $data = null, $return = false) {
        $show['top'] = LayoutsTopService::getInstance()->getLayouts( $this->visitUrl );
        $show['main'] = $this->getController()
            ->renderPartial( $view , $data , true );
        $show['bottom'] = LayoutsBottomService::getInstance()->getLayouts( $this->visitUrl );
        $show['userInfo'] = LayoutsLeftService::getInstance()->userPointInfo( 'rank' );
        $this->getController()
            ->render( "/layouts/rate_main_simple" , $show , $return );
    }
}
