<?php
/**
 * CBehavior class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2010 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
/**
 * CBehavior is a convenient base class for behavior classes.
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CBehavior.php 1678 2010-01-07 21:02:00Z qiang.xue $
 * @package system.base
 * @since 1.0.2
 */
class CBehavior extends CComponent implements IBehavior {

    private $_enabled;

    private $_owner;

    /**
     * Declares events and the corresponding event handler methods.
     * The events are defined by the {@link owner} component, while the handler
     * methods by the behavior class. The handlers will be attached to the corresponding
     * events when the behavior is attached to the {@link owner} component; and they
     * will be detached from the events when the behavior is detached from the component.
     * @return array events (array keys) and the corresponding event handler methods (array values).
     */
    public function events () {
        return array();
    }

    /**
     * Attaches the behavior object to the component.
     * The default implementation will set the {@link owner} property
     * and attach event handlers as declared in {@link events}.
     * Make sure you call the parent implementation if you override this method.
     * @param CComponent the component that this behavior is to be attached to.
     */
    public function attach ($owner) {
        $this->_owner = $owner;
        foreach ($this->events() as $event => $handler)
            $owner->attachEventHandler( 
                    $event , 
                    array(
                        
                            $this, 
                            $handler
                    ) );
    }

    /**
     * Detaches the behavior object from the component.
     * The default implementation will unset the {@link owner} property
     * and detach event handlers declared in {@link events}.
     * Make sure you call the parent implementation if you override this method.
     * @param CComponent the component that this behavior is to be detached from.
     */
    public function detach ($owner) {
        foreach ($this->events() as $event => $handler)
            $owner->detachEventHandler( 
                    $event , 
                    array(
                        
                            $this, 
                            $handler
                    ) );
        $this->_owner = null;
    }

    /**
     * @return CComponent the owner component that this behavior is attached to.
     */
    public function getOwner () {
        return $this->_owner;
    }

    /**
     * @return boolean whether this behavior is enabled
     */
    public function getEnabled () {
        return $this->_enabled;
    }

    /**
     * @param boolean whether this behavior is enabled
     */
    public function setEnabled ($value) {
        $this->_enabled = $value;
    }
}
