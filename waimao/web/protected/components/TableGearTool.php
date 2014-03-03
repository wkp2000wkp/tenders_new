<?php
Yii::import( 'application.extensions.tablegear.TableGear' );
class TableGearTool extends CWidget
{
    public $TableGear = null;
    public $dataTaseTable = null;
    public $editable = false;
    public $noAutoQuery = false;
    public $headers = array();
    public $form = array();
    public $transform = array();
    public $shiftColumns = array();
    public $sortable = "all";
    public $addNewRows = false;
    public $perPage = 30;
    public $custom = array();
    public $table = array();
    public $selects = array();
    public function getTableGearTool () {
        if (!$this->TableGear) {
            $databaseConfig = SelectConstent::getDataBaseConfig();
            $options["database"]["host"] = $databaseConfig['host'];
            $options["database"]["name"] =  $databaseConfig['db'];
            $options["database"]["username"] = $databaseConfig['user'];
            $options["database"]["password"] = $databaseConfig['password'];
            $options["database"]["noAutoQuery"] = $this->noAutoQuery;
            $options["database"]["table"] = $this->dataTaseTable;
            $options["database"]["sort"] = "id desc";
            $options["sortable"] = $this->sortable;
            $options["editable"] = $this->editable;
            if( $this->table ) $options["table"] = $this->table;
            $options["allowDelete"] = false;
            $options["addNewRows"] = $this->addNewRows;
            $options["headers"] =  $this->headers;
            $options["textareas"] = array('remark');
            if( $this->form ) $options["form"] =  $this->form;
            $options["database"]["fields"] =  array_keys($this->headers);
            if( $this->selects ) $options["selects"] = $this->selects;
            $options['custom'] = $this->custom;
            if($this->shiftColumns){
                $options["shiftColumns"]= $this->shiftColumns;
            }
            $options["columns"]= SelectConstent::getTdClassHeaders();
            if( $this->transform ) $options["transform"] = $this->transform;
            $options["pagination"] = array( "perPage" => $this->perPage, "prev" => "上一页", "next" => "下一页", "linkCount" => 30 );
            $this->TableGear = New TableGear( $options );
        }
        return $this->TableGear;
    }

    public function getTable ($output = false) {
        return $this->getTableGearTool()->getTable( $output );
    }

    public function getJavascript ($library = "jquery", $id = null, $output = false) {
        return $this->getTableGearTool()->getJavascript( $library , $id , $output );
    }
    
    public function query ($query) {
        return $this->getTableGearTool()->query( $query );
    }
    public function fetchData ($query) {
        return $this->getTableGearTool()->fetchData( $query );
    }
    
}
