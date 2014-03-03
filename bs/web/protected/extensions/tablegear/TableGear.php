<?php
define( "MYSQL_DATE_FORMAT" , "Y-m-d H:i:s" );
class TableGear extends CWidget
{

    public $processHTTP = true; // Process data submitted by HTTP

    public $indent = 0; // HTML indent base

    public $autoHeaders = true; // Automatically get the headers from field names

    public $readableHeaders = true; // Creates readable headers from camelCase and underscore field names.

    public $noDataMessage = "- No Data -"; // The message to display when no data is available

    public $newRowLabel = "新增";

    public $primaryKeyDelimiter = "|";

    public $addNewRows = true;

    public $editableFields = array(); // For HTML output

    public $form = array(); // For HTML output

    public $table = array(
        "id" => "tgTable"
    );

    public $headers = array(
        "EDIT" => "选择", "DELETE" => "删除记录"
    );

    public $tgTableID = 0;
    
    public $sortable;

    public $editable;

    public $allowDelete;

    public $database;

    public $pagination;

    public $connection;

    public $debug;

    public $primaryKeyColumnsByName;

    public $data;

    public $shiftColumns;

    public $custom;

    public $errors;

    public $columns;

    public $column;

    public $formatting;

    public $title;

    public $footers;

    public $totals;

    public $editRowLabel;

    public $hotText;

    public $loading;

    public $blockEditable;

    public $transform;

    public $selects;

    public $textareas;

    public $deleteRowLabel;

    public $emptyDataRow;

    public $callback;

    public $inputFormat;

    public $validate;
    
    public $getPrevious;
    
    public $totalRows;
    
    public $URIParams;
    
    public $fetchEmptyRow;
    
    public $_curIndent = 0; // For HTML output

    public $_hasTags = false; // For HTML output
    
    public $hiddenNoData = false; // For HTML output

    public $_httpArray;

    public $_affectedRows;

    public $_json;

    function TableGear ($options = array()) {
        $options = $this->_setDefaults( $options );
        if ($options["editable"]) $this->form = array(
            
                "url" => $_SERVER["REQUEST_URI"], 
                "method" => "post", 
                "submit" => "Update"
        );
        $this->table = array(
            "id" => "tgTable"
        );
        $this->_setOptions( $options );
        $this->_errorOnRequiredFields();
        if ($this->database) $this->connect();
        if ($this->processHTTP) $this->_checkSubmit();
        if (!$this->database["noAutoQuery"]) $this->fetchData();
        if ($this->database["error"]) return;
        $this->_checkColumnShift();
    }

    function _setDefaults ($options) {
        if (!isset( $options["editable"] )) $options["editable"] = "allExceptAutoIncrement";
        if (!isset( $options["sortable"] )) $options["sortable"] = "all";
        if (!isset( $options["allowDelete"] )) $options["allowDelete"] = true;
        return $options;
    }

    function _errorOnRequiredFields () {
        $this->_errorOnField( $this->database["name"] , "<DATABASE_NAME>" , "Database required." );
        $this->_errorOnField( $this->database["username"] , "<DATABASE_USERNAME>" , "Username required." );
        $this->_errorOnField( $this->database["table"] , "<DATABASE_TABLE>" , "Table required." );
    }

    function _errorOnField ($field, $default, $message) {
        if (!isset( $field ) || $field == $default) {
            $this->addDatabaseError( $message );
        }
    }

    /* Functions for working with the database */
    function connect () {
        $db = $this->database;
        $this->connection = mysql_connect( $db["host"] , $db["username"] , $db["password"] );
        if (!mysql_select_db( $db["name"] , $this->connection )) $this->addDatabaseError( "Database not found." );
    }

    function addDatabaseError ($error) {
        if ($this->database["error"]) return;
        $this->database["error"] = $error;
    }

    function query ($query) {
        if ($this->debug) {
            echo "<br/>QUERY: $query<br/>";
        }
        if (!$this->connection) $this->addDatabaseError( "No database connection established!" );
        $result = mysql_query( $query , $this->connection );
        $this->_affectedRows = mysql_affected_rows( $this->connection );
        if (!$result) {
            $this->addDatabaseError( mysql_error() );
            return false;
        }
        elseif ($result && $result != 1) {
            $data = array();
            while ($row = mysql_fetch_assoc( $result )){
                array_push( $data , $row );
            }
            if(!$data){
                $this->data=$data;
            }
            return $data;
        }
        else {
            return true;
        }
    }

    function fetchData ($query = null) {
        if (!$query && !$this->database["table"]) return;
        $table = $this->database["table"];
        // Get the sorting field
        if ($_GET["sort"]) {
            $sort = $_GET["sort"];
            $desc = $_GET["desc"] ? " DESC" : " ASC";
            $this->database["sort"] = $sort . $desc;
        }
        elseif ($this->database["sort"]) {
            $sort = $this->database["sort"];
            if (is_array( $sort )) {
                $sort = implode( "," , $sort );
            }
        }
        else {
            $sort = $this->_getPrimaryKeyNamesAsString( "," );
        }
        $auto_query = !isset( $query );
        if ($this->database["join"]) {
            $join_data = $this->database["join"];
            $join_table = $join_data["table"];
            $join_fk = $join_data["foreign_key"];
            $join_key = $join_data["key"] ? $join_data["key"] : "id";
            $join = "LEFT JOIN $join_table ON $join_table.$join_key=$table.$join_fk";
            if ($this->database["fields"]) {
                $fields_id_index = array_search( "id" , $this->database["fields"] );
                if ($fields_id_index !== false) {
                    $this->database["fields"][$fields_id_index] = "$table.id";
                }
            }
            if ($sort == "id") {
                $sort = "$table.id";
            }
        }
        if ($auto_query) {
            if (!$this->database["table"]) return;
            $fields = $this->database["fields"] ? implode( "," , $this->database["fields"] ) : "*";
            $query = "SELECT SQL_CALC_FOUND_ROWS $fields FROM $table $join ORDER BY $sort$desc";
        }
        if ($this->pagination) {
            if (!$auto_query && isset( $sort )) {
                // Add the sort field onto the query for custom queries,
                // but only if we have pagination otherwise sort is handled manually.
                $query .= " ORDER BY $sort$desc";
            }
            $page = $this->pagination["currentPage"] = ($_GET["page"]) ? $_GET["page"] : 1;
            if (!$this->pagination["perPage"]) $this->pagination["perPage"] = 10;
            $min = ($page - 1) * $this->pagination["perPage"];
            $perPage = $this->pagination["perPage"];
            $query .= " LIMIT $min, $perPage";
        }
        $data = $this->query( $query );
        if ($this->pagination) {
            $result = mysql_query( "SELECT FOUND_ROWS() AS total" );
            $row = mysql_fetch_assoc( $result );
            $this->totalRows = $row["total"];
            $this->pagination["totalPages"] = ceil( $this->totalRows / $this->pagination["perPage"] );
        }
        if (!$data) return;
        $this->data = array();
        foreach ($data as $row) {
            $entry = array();
            $entry["key"] = $this->_getPrimaryKeyValues( $row );
            $entry["data"] = $row;
            array_push( $this->data , $entry );
        }
    }

    function _getPrimaryKeyColumns () {
        // This is a shortcut that the user can set. Only works with non-composite PKs.
        if ($this->database["key"]) return array(
            array(
            "name" => $this->database["key"]
        )
        );
        // This will store the resulting PK fields fetched from the database.
        if ($this->database["keys"]) return $this->database["keys"];
        $table = $this->database["table"];
        $columns = $this->query( "SHOW COLUMNS FROM $table WHERE `Key`='PRI'" );
        $keys = array();
        $this->primaryKeyColumnsByName = array();
        foreach ($columns as $column) {
            $key = array();
            $key["name"] = $column["Field"];
            // MySQL appears to not allow a value of NULL as a default for a primary key field.
            $key["default"] = $column["Default"];
            if (stripos( $column["Extra"] , "auto_increment" ) !== -1) {
                $key["auto"] = true;
            }
            array_push( $keys , $key );
            $this->primaryKeyColumnsByName[$key["name"]] = $key;
            if ($this->database["fields"]) {
                array_push( $this->database["fields"] , $key["name"] );
                $this->database["fields"] = array_unique( $this->database["fields"] );
            }
        }
        if (!count( $keys ) === 0) trigger_error( "Primary key is required for table $table." , E_USER_ERROR );
        $this->database["keys"] = $keys;
        return $keys;
    }

    function _limitQueryByPrimaryKey ($query, $key) {
        $where = array();
        $values = explode( $this->primaryKeyDelimiter , $key );
        $primaryKeys = $this->_getPrimaryKeyColumns();
        for ($i = 0; $i < count( $primaryKeys ); $i++) {
            $field = $primaryKeys[$i]["name"];
            $value = $values[$i];
            if (!is_numeric( $value )) $value = '"' . mysql_real_escape_string( $value , $this->connection ) . '"';
            array_push( $where , "$field=$value" );
        }
        $where = implode( " AND " , $where );
        return "$query WHERE $where";
    }

    function _getPrimaryKeyNamesAsString ($delimiter) {
        if (!$delimiter) $delimiter = $this->primaryKeyDelimiter;
        $result = array();
        foreach ($this->_getPrimaryKeyColumns() as $key) {
            array_push( $result , $key["name"] );
        }
        return implode( $delimiter , $result );
    }

    function _getPrimaryKeyValues ($data) {
        $result = array();
        foreach ($this->_getPrimaryKeyColumns() as $key) {
            $value = $data[$key["name"]];
            array_push( $result , $data[$key["name"]] );
        }
        return implode( $this->primaryKeyDelimiter , $result );
    }

    function _getPrimaryKeyValuesAfterInsertion ($data) {
        $primaryKeys = $this->_getPrimaryKeyColumns();
        $values = array();
        foreach ($primaryKeys as $key) {
            if ($key["auto"]) {
                // Note here that in mySQL it IS possible to have a composite primary key with a single field set
                // to auto_increment. In that case, LAST_INSERT_ID() will return 0, despite the fact that the field
                // gets incremented, effectively making it impossible to know the data in that field. I am NOT handling
                // that case here ("0" will be foreced into the resulting JSON data), and I can't see any reason it would
                // make sense to be using a composite primary key AND an auto_increment field in the same table. If there
                // IS a good reason and this is some kind of huge problem, contact me, especially if you have some good ideas
                // about how to retrieve the result without a reliable means of getting the last inserted id.
                $this->_json["auto"] = $key["name"];
                array_push( $values , mysql_insert_id() );
            }
            else {
                $value = $data[$key["name"]];
                if ($value) {
                    array_push( $values , $value );
                }
                else {
                    // We know that this primary key is not auto-increment, and we don't have a value from the incoming user data,
                    // so the value should be the default value for this field.
                    array_push( $values , $key["default"] );
                }
            }
        }
        return implode( $this->primaryKeyDelimiter , $values );
    }

    function _getPrimaryKeyValuesAfterUpdate ($updatedData, $cKey) {
        $primaryKeys = $this->_getPrimaryKeyColumns();
        $currentValues = explode( $this->primaryKeyDelimiter , $cKey );
        $values = array();
        foreach ($primaryKeys as $i => $key) {
            $updated = $updatedData[$key["name"]];
            if ($updated) {
                array_push( $values , $updated );
            }
            else {
                array_push( $values , $currentValues[$i] );
            }
        }
        return implode( $this->primaryKeyDelimiter , $values );
    }

    /* Functions for working with the data */
    function injectColumn ($array, $position = "first", $fieldName = null) {
        if (!$this->data) return;
        foreach ($this->data as $rowIndex => $row) {
            $data = $row["data"];
            $column = count( $data ) + 1;
            if ($fieldName)
                $data[$fieldName] = $array[$rowIndex];
            else
                $data[$column] = $array[$rowIndex];
            $this->data[$rowIndex]["data"] = $data;
        }
        $col = $fieldName ? $fieldName : $column;
        $this->shiftColumn( $this->data,$col , $position );
    }

    function shiftColumn ($row, $col, $pos) {
        if (is_numeric( $col )) {
            $keys = array_keys( $row );
            $col = $keys[$col - 1];
        }
        if (!is_numeric( $pos )) list($pos, $params) = $this->_getParams( $pos );
        $new = array();
        $currentColumn = 1;
        if ($pos == "first") {
            $new[$col] = $row[$col];
            $currentColumn++;
        }
        foreach ($row as $field => $data) {
            if ($pos == "before" && $params == $field) {
                $new[$col] = $row[$col];
                $currentColumn++;
            }
            if ($pos == $currentColumn) {
                $new[$col] = $row[$col];
                $currentColumn++;
            }
            if ($field != $col) {
                $new[$field] = $data;
                $currentColumn++;
            }
            if ($pos == "after" && $params == $field) {
                $new[$col] = $row[$col];
                $currentColumn++;
            }
        }
        if ($pos == "last") {
            $new[$col] = $row[$col];
        }
        
        return $new;
    }

    function _fetchHeaders () {
        $headers = array();
        if ($this->form && $this->editable) array_push( $headers , array(
            
                "field" => "EDIT", 
                "html" => $this->headers["EDIT"], 
                "attrib" => array(
                    
                        "class" => $this->_checkColumnClass( "EDIT" )
                )
        ) );
        if (count( $this->data ) > 0) {
            $firstRow = reset( $this->data );
            $column = 1;
            foreach ($firstRow["data"] as $field => $data) {
                $sortable = $this->_testForOption( "sortable" , $field , $column ) ? true : false;
                $sortType = $this->_getSortType( $field );
                $class = $this->_addClass( "sortable" , null , $sortable );
                $class = $this->_addClass( $sortType , $class );
                if ($this->primaryKeyColumnsByName[$field]) {
                    $class = $this->_addClass( "primary_key" , $class );
                    if ($this->primaryKeyColumnsByName[$field]["auto"]) {
                        $class = $this->_addClass( "auto_increment" , $class );
                    }
                }
                if ($this->headers[$field])
                    $userHeader = $this->headers[$field];
                elseif ($this->headers[$column])
                    $userHeader = $this->headers[$column];
                else
                    $userHeader = null;
                $html = null;
                if (is_array( $userHeader )) {
                    $html = $userHeader["html"];
                    $class = $this->_addClass( $userHeader["class"] , $class );
                }
                elseif (is_string( $userHeader )) {
                    $html = $userHeader;
                }
                if (!$html && $this->autoHeaders) $html = $this->_autoFormatHeader( $field );
                // Match sorting field
                preg_match( '/^\w+/' , $this->database["sort"] , $match );
                $sort = $match[0];
                $desc = preg_match( '/desc\s*$/i' , $this->database["sort"] ) > 0;
                $carat = array(
                    
                        "tag" => "span", 
                        "attrib" => array(
                            
                                "class" => $caratClass
                        )
                );
                if ($sort == $field) {
                    if ($desc) {
                        $desc = null;
                        $carat["html"] = "▼";
                    }
                    else {
                        $desc = "true";
                        $carat["html"] = "▲";
                    }
                }
                $html = array(
                    
                        array(
                            
                                "tag" => "span", 
                                "html" => $html
                        ), 
                        $carat
                );
                if ($this->pagination && $this->pagination["totalPages"] != 1) {
                    $href = $this->_modifyURIParams( array(
                        
                            "sort" => $field, 
                            "desc" => $desc, 
                            "page" => null
                    ) );
                    $link = array(
                        
                            "tag" => "a", 
                            "html" => $html, 
                            "attrib" => array(
                                
                                    "href" => $href
                            )
                    );
                    $header = array(
                        
                            "html" => $link
                    );
                }
                else {
                    $header = array(
                        
                            "html" => $html, 
                            "attrib" => array(
                                
                                    "class" => $class, 
//                                    "id" => $userHeader["id"]
                            )
                    );
                }
                array_push( $headers , $header );
                $column++;
            }
        }
        elseif ($this->connection) {
            if (!$this->database["table"]) return;
            $columns = $this->query( "SHOW COLUMNS FROM " . $this->database["table"] );
            if (!$columns) return;
            foreach ($columns as $column) {
                $field = $column["Field"];
                if($this->headers){
                    if(($this->headers[$field])){
                        $field = $this->headers[$field];
                    }else{
                        continue;
                    }
                }
                if($this->hiddenNoData) $header['attrib']["class"] = $this->columns[$column["Field"]];
                $header["field"] = $field;
                if ($this->autoHeaders)
                    $header["html"] = $this->_autoFormatHeader( $field );
                else
                    $header["html"] = $field;
                array_push( $headers , $header );
            }
            if($this->shiftColumns){
                foreach($this->shiftColumns as $key=>$value){
	                $header["html"] =  $header["field"] = $key;
	                array_push( $headers , $header );
                }
            }
        }
        if ($this->allowDelete && $this->form) array_push( $headers , array(
            
                "field" => "DELETE", 
                "html" => $this->headers["DELETE"], 
                "attrib" => array(
                    
                        "class" => $this->_checkColumnClass( "DELETE" )
                )
        ) );
        return $headers;
    }

    function _fetchFooters () {
        $footers = array();
        if ($this->form && $this->editable) array_push( $footers , $this->footers["EDIT"] );
        if (count( $this->data ) > 0) {
            $firstRow = reset( $this->data );
            $column = 1;
            foreach ($firstRow["data"] as $field => $data) {
                $footer = $this->footers[$column] ? $this->footers[$column] : $this->footers[$field];
                if ($footer) array_push( $footers , $footer );
                $column++;
            }
        }
        if ($this->allowDelete && $this->form) array_push( $footers , $this->footers["DELETE"] );
        return $footers;
    }

    function _fetchTotals () {
        $totals = array();
        if ($this->form && $this->editable) $totals[0] = array(
            "field" => "EDIT"
        );
        $dataArray = $this->data ? $this->data : array(
            $this->_fetchEmptyDataRow()
        );
        foreach ($dataArray as $rowIndex => $row) {
            $column = 1;
            foreach ($row["data"] as $field => $data) {
                if ($rowIndex == 0) $totals[$column] = array(
                    
                        "field" => $field
                );
                if ($this->_testForOption( "totals" , $field , $column )) $totals[$column]["text"] += $data;
                $column++;
            }
        }
        if ($this->allowDelete && $this->form) $totals[$column + 1] = array(
            "field" => "DELETE"
        );
        return $totals;
    }

    /* Functions for handling options and working with HTML */
    function getTable ($output = true) {
        if (!$this->data) $this->data = array();
        if ($this->database["error"]) {
            $html .= $this->_openTag( "div" , array(
                "class" => "error"
            ) , $output );
            $html .= $this->_outputHTML( "Database error: " . $this->database["error"] , $output );
            $html .= $this->_closeTag( "div" , $output );
            return;
        }
        if ($this->form) {
            $html .= $this->_openTag( "form" , array(
                
                    "action" => $this->form["url"], 
                    "method" => $this->form["method"], 
                    "id" => $this->form["id"], 
                    "class" => $this->form["class"]
            ) , $output );
            $html .= $this->_outputHTML( $this->custom["FORM_TOP"] ,false, $output );
            if ($this->errors) {
                $html .= $this->_openTag( "fieldset" , array(
                    
                        "class" => "errors"
                ) , $output );
                foreach ($this->errors as $error) {
                    $html .= $this->_openTag( "p" , $output );
                    $html .= $this->_outputHTML( $error["message"] . " for field " ,false, $output );
                    $html .= $this->_openTag( "span" , array(
                        
                            "class" => "field"
                    ) , $output );
                    $html .= $this->_outputHTML( '"' . $error["field"] . '".' ,false, $output );
                    $html .= $this->_closeTag( "span" , $output );
                    $html .= $this->_closeTag( "p" , $output );
                }
                $html .= $this->_closeTag( "fieldset" , $output );
            }
            $html .= $this->_openTag( "fieldset" , null , $output );
        }
        $html .= $this->_outputHTML( $this->custom["TABLE_TOP"] ,false, $output );
        $html .= $this->_openTag( "table" , array(
            
                "id" => $this->table["id"], 
                "class" => $this->table["class"]
        ) , $output );
        $headers = $this->_fetchHeaders();
        if ($headers || $this->title) {
            $html .= $this->_outputHeaders( $headers , true , false );
        }
        if ($this->footers || $this->totals || $this->addNewRows) {
            $html .= $this->_openTag( "tfoot" , null , $output );
            if ($this->totals) {
                $totals = $this->_fetchTotals();
                $html .= $this->_openTag( "tr" , null , $output );
                foreach ($totals as $column => $footer) {
                    $class = isset( $footer["text"] ) ? $footer["field"] . " total" : null;
                    $attrib["class"] = $this->_addClass( $class );
                    $attrib["class"] = $this->_addClass( $this->_checkColumnClass( $footer["field"] , $column ) , $attrib["class"] );
                    $html .= $this->_openTag( "td" , $attrib , $output );
                    $text = $footer["text"] ? $this->_getFormatted( $footer["text"] , $footer["field"] , $column ) : null;
                    $html .= $this->_outputHTML( $text ,false, $output );
                    $html .= $this->_closeTag( "td" , $output );
                }
                $html .= $this->_closeTag( "tr" , $output );
            }
            if ($this->footers) {
                $footers = $this->_fetchFooters();
                $html .= $this->_openTag( "tr" , null , $output );
                foreach ($footers as $footer) {
                    $colspan = ($footer == end( $footers )) ? count( $headers ) - count( $footers ) + 1 : null;
                    $html .= $this->_openTag( "th" , array(
                        
                            "colspan" => $colspan
                    ) , $output );
                    $html .= $this->_outputHTML( $footer , false , $output );
                    $html .= $this->_closeTag( "th" , $output );
                }
                $html .= $this->_closeTag( "tr" , $output );
            }
            $html .= $this->_closeTag( "tfoot" , $output );
        }
        $html .= $this->_openTag( "tbody" , null , $output );
        if (!$this->data) {
            if(!$this->hiddenNoData){
	            $html .= $this->_openTag( "tr" , array(
	                "class" => "noDataRow odd"
	            ) , $output );
	            $html .= $this->_openTag( "td" , array(
	                "colspan" => count( $headers )
	            ) , $output );
	            $html .= $this->_outputHTML( $this->noDataMessage , false , $output );
	            $html .= $this->_closeTag( "td" , $output );
	            $html .= $this->_closeTag( "tr" , $output );
            }
        }
        else {
            foreach ($this->data as $rowIndex => $row) {
                $html .= $this->_constructDataRow( $row , $rowIndex , true , array() , $output );
            }
        }
        $html .= $this->_closeTag( "tbody" , $output );
        $html .= $this->_closeTag( "table" , $output );
        if ($this->pagination && $this->totalRows > $this->pagination["perPage"]) {
            $html .= $this->_openTag( "div" , array(
                "class" => "pagination"
            ) , $output );
            $this->_navLink( "prev" , $this->pagination["prev"] ,$output);
            $this->_navLink( "next" , $this->pagination["next"] ,$output);
            $html .= $this->_openTag( "div" , array(
                "class" => "pages"
            ) , $output );
            $page = $this->pagination["currentPage"];
            $linkCount = $this->pagination["linkCount"] ? $this->pagination["linkCount"] : 5;
            $min = ($page - $linkCount < 1) ? 1 : $page - $linkCount;
            $max = ($page + $linkCount > $this->pagination["totalPages"]) ? $this->pagination["totalPages"] : $page + $linkCount;
            for ($i = $min; $i <= $max; $i++) {
                $attribs = array();
                if ($i == $this->pagination["currentPage"]) {
                    $attribs["class"] = "current";
                    $tag = "span";
                }
                else {
                    $uri = $this->_injectURLParam( "page" , $i );
                    $attribs = array(
                        
                            "href" => $uri
                    );
                    $tag = "a";
                }
                $html .= $this->_openTag( $tag , $attribs , $output );
                $html .= $this->_outputHTML( $i , false , $output );
                $html .= $this->_closeTag( $tag , $output );
            }
            $html .= $this->_closeTag( "div" , $output );
            $html .= $this->_closeTag( "div" , $output );
        }
        $html .= $this->_outputHTML( $this->custom["TABLE_BOTTOM"] , false , $output );
        if ($this->form) {
            foreach (array_unique( $this->editableFields ) as $field) {
                $html .= $this->_openTag( "input" , array(
                    
                        "type" => "hidden", 
                        "name" => "fields[]", 
                        "value" => $field
                ) , $output );
            }
            $html .= $this->_openTag( "input" , array(
                
                    "type" => "hidden", 
                    "name" => "noDataMessage", 
                    "value" => $this->noDataMessage
            ) , $output );
            $html .= $this->_openTag( "input" , array(
                
                    "type" => "hidden", 
                    "name" => "table", 
                    "value" => $this->table["id"]
            ) , $output );
            if ($this->pagination) {
                $html .= $this->_openTag( "input" , array(
                    
                        "type" => "hidden", 
                        "name" => "page", 
                        "value" => $this->pagination["currentPage"]
                ) , $output );
            }
            if ($this->form["submit"]) {
                $html .= $this->_openTag( "div" , array(
                    
                        "class" => "submit"
                ) , $output );
                $html .= $this->_openTag( "input" , array(
                    
                        "type" => "submit", 
                        "value" => $this->form["submit"]
                ) , $output );
                $html .= $this->_closeTag( "div" , $output );
            }
            $html .= $this->_closeTag( "fieldset" , $output );
            $html .= $this->_outputHTML( $this->custom["FORM_BOTTOM"] , false , $output );
            $html .= $this->_closeTag( "form" , $output );
        }
        if ($this->_newRowsAllowed()) {
            $html .= $this->getAddRowHtml($headers,$output);
        }
        //    echo "\n";
        if (!$output) return $html;
    }
    
    function getAddRowHtml( $headers,$output = true){
        
            $addNewRowID = "addNewRow_" . $this->table["id"];
            $html .= $this->_openTag( "form" , array(
                
                    "action" => $this->form["url"], 
                    "method" => $this->form["method"], 
                    "id" => $addNewRowID, 
                    "class" => "newRow"
            ) , $output );
            $html .= $this->_outputHTML( array(
                
                    "tag" => "h3", 
                    "html" => $this->newRowLabel
            ) , false , $output );
            
            $html .= $this->_openTag( "table" , null , $output );
            $html .= $this->_outputHeaders( $headers ,false , $output );
            $html .= $this->_openTag( "tbody" , null , $output );
            $emptyDataRow = $this->_fetchEmptyDataRow();
            $newDataRowID = "newDataRow_" . $this->table["id"];
            $html .= $this->_constructDataRow( $emptyDataRow , 1 , false , array(
                
                    "id" => $newDataRowID, 
                    "class" => "newRow"
            ) , $output );
            $html .= $this->_closeTag( "tbody" , $output );
            $html .= $this->_closeTag( "table" , $output );
            $html .= $this->_openTag( "div" , array(
                "class" => "submit"
            ) , $output );
            $html .= $this->_openTag( "input" , array(
                
                    "type" => "hidden", 
                    "name" => "insert", 
                    "value" => "true"
            ) , $output );
            $html .= $this->_openTag( "input" , array(
                
                    "type" => "hidden", 
                    "name" => "table", 
                    "value" => $this->table["id"]
            ) , $output );
            $html .= $this->_openTag( "input" , array(
                
                    "type" => "submit", 
                    "value" => $this->form["submit"]
            ) , $output );
            $html .= $this->_closeTag( "div" , $output );
            $html .= $this->_closeTag( "form" , $output );
            
            return $html;
    }

    function getJavascript ($library = "jquery", $id = null,$output = true) {
        if ($this->database["error"]) return;
        if (!$id) $id = $this->table["id"];
        $editableCellsPerRow = count( array_unique( $this->editableFields ) );
        $options = array(
            
                "noDataMessage" => $this->noDataMessage, 
                "editableCellsPerRow" => $editableCellsPerRow
        );
        if (!$this->_newRowsAllowed()) $options["addNewRows"] = false;
        if ($this->pagination) $options["paginated"] = true;
        $options = $this->_jsonEncode( $options );
        $html .= $this->_openTag( "script" , array(
            "type" => "text/javascript"
        ) ,$output);
        $html .= "\n";
        if ($library == "mootools") {
            $html .= "new TableGear('$id', $options);";
        }
        if ($library == "jquery") {
            $html .= "$('#$id').tableGear($options);";
        }
        $html .= "\n";
        $html .= $this->_closeTag( "script" ,$output);
        if($output) echo $html;
        return $html;
    }

    function _newRowsAllowed () {
        if ($this->pagination && $this->pagination["currentPage"] != $this->pagination["totalPages"]) return false;
        return $this->addNewRows && $this->form;
    }

    function _constructDataRow ($data, $rowIndex, $appendKey = true, $attrib = array(), $output = true) {
        $key = $data["key"];
        $attrib["class"] = isset( $attrib["class"] ) ? $attrib["class"] . " " : "";
        $attrib["class"] .= ($rowIndex % 2) ? "even" : "odd";
        $html .= $this->_openTag( "tr" , $attrib , $output );
        if ($this->form && $this->editable) {
            $attrib = array();
            $attrib["class"] = $this->_checkColumnClass( "EDIT" );
            $html .= $this->_openTag( "td" , $attrib , $output );
            $id = $appendKey ? "edit" . $key : null;
            $value = $key ? $key : "NULL_STRING";
            $html .= $this->_openTag( "input" , array(
                
                    "type" => "checkbox", 
                    "name" => "edit[]", 
                    "value" => $value
            ) , $output );
            $html .= $this->_getLabel( "editRowLabel" , "edit" . $key , "edit" ,$output);
            $html .= $this->_closeTag( "td" , $output );
        }
        $currentColumn = 1;
        foreach ($data["data"] as $column => $data) {
            $hottext = ($this->_testForOption( "hotText" , $column , $currentColumn )) ? true : false;
            $editable = ($this->_testForOption( "editable" , $column , $currentColumn )) ? true : false;
            $attrib["class"] = $this->_addClass( "hotText" , null , $hottext );
            $attrib["class"] = $this->_addClass( "editable" , $attrib["class"] , $editable );
            $attrib["class"] = $this->_addClass( $this->_checkColumnClass( $column , $currentColumn ) , $attrib["class"] );
            $html .= $this->_openTag( "td" , $attrib , $output );
            if ($editable) {
                array_push( $this->editableFields , $column );
                if ($this->loading) $html .= $this->_outputHTML( $this->loading , "loading" , $output );
                $tag = $this->blockEditable ? "div" : "span";
                $html .= $this->_openTag( $tag , null , $output );
                $text = $this->_getFormatted( $data , $column , $currentColumn );
                $text = $this->_dataTransform( $text , $column , $rowIndex , $currentColumn , $key );
                $html .= $this->_outputHTML( $text , true , $output );
                $html .= $this->_closeTag( $tag , $output );
                $name = $appendKey ? "data[$key][$column]" : "data[$column]";
                if ($this->_testForOption( "selects" , $column , $currentColumn )) {
                    $options = $this->_getOptionsArray( $column , $currentColumn , $data );
                    $html .= $this->_openTag( "select" , array(
                        
                            "name" => $name
                    ) , $output );
                    $associative = $this->_isHash( $options );
                    foreach ($options as $name => $value) {
                        $selected = ($value == $data) ? "selected" : null;
                        $html .= $this->_openTag( "option" , array(
                            
                                "value" => $value, 
                                "selected" => $selected
                        ) , $output );
                        $text = ($associative) ? $name : $value;
                        $text = $this->_getFormatted( $text , $column , $currentColumn );
                        $html .= $this->_outputHTML( $text ,false , $output );
                        $html .= $this->_closeTag( "option" , $output );
                    }
                    $html .= $this->_closeTag( "select" , $output );
                }
                elseif ($this->_testForOption( "textareas" , $column , $currentColumn )) {
                    $args = $this->textareas[$currentColumn] ? $this->textareas[$currentColumn] : $this->textareas[$column];
                    $rows = ($args["rows"]) ? $args["rows"] : 3;
                    $cols = ($args["cols"]) ? $args["cols"] : 20;
                    $html .= $this->_openTag( "textarea" , array(
                        
                            "name" => $name, 
                            "rows" => $rows, 
                            "cols" => $cols
                    ), $output );
                    $html .= $this->_outputHTML( $data ,false, $output );
                    $html .= $this->_closeTag( "textarea" , $output );
                }
                else {
                    $html .= $this->_openTag( "input" , array(
                        
                            "type" => "text", 
                            "name" => $name, 
                            "value" => $data
                    ) , $output );
                }
            }
            else {
                $useFormat = $this->_testForOption( "formatting" , $column , $currentColumn );
                $text = ($useFormat) ? $this->_getFormatted( $data , $column , $currentColumn ) : $data;
                $text = $this->_dataTransform( $text , $column , $rowIndex , $currentColumn , $key );
                $html .= $this->_openTag( "span" ,null, $output );
                $html .= $this->_outputHTML( $text ,false, $output );
                $html .= $this->_closeTag( "span" , $output );
            }
            $html .= $this->_closeTag( "td" , $output );
            $currentColumn++;
        }
        if ($this->allowDelete && $this->form) {
            $attrib["class"] = $this->_checkColumnClass( "DELETE" );
            $html .= $this->_openTag( "td" , $attrib , $output );
            if ($this->loading) $html .= $this->_outputHTML( $this->loading , "loading" , $output );
            if (!$key) $key = "NULL_STRING";
            $html .= $this->_openTag( "input" , array(
                
                    "type" => "checkbox", 
                    "name" => "delete[]", 
                    "value" => $key, 
                    "id" => "delete" . $key
            ) , $output );
            $html .= $this->_getLabel( "deleteRowLabel" , "delete" . $key ,null , $output );
            $html .= $this->_closeTag( "td" , $output );
        }
        $html .= $this->_closeTag( "tr" , $output );
        return $html;
    }

    function _fetchEmptyDataRow () {
        if ($this->emptyDataRow) return $this->emptyDataRow;
        if ($this->data && !$this->database["fetchEmptyRow"]) {
            $emptyDataRow["data"] = $this->data[0]["data"];
            foreach ($emptyDataRow["data"] as $index => $value) {
                $emptyDataRow["data"][$index] = "";
            }
        }
        else {
            $emptyDataRow["data"] = array();
            $query = "SHOW COLUMNS IN " . $this->database["table"];
            if ($this->database["fields"]) {
                // Array map is ugly as shit in PHP so do it the old fashioned way.
                $escaped = array();
                foreach ($this->database["fields"] as $field) {
                    array_push( $escaped , "\"$field\"" );
                }
                $query .= " WHERE Field IN (" . implode( "," , $escaped ) . ")";
            }
            $columns = $this->query( $query );
            foreach ($columns as $row) {
                $default = $row["Default"];
                $field = $row["Field"];
                if ($default == "CURRENT_TIMESTAMP") {
                    $value = date( MYSQL_DATE_FORMAT );
                }
                else {
                    $value = $default;
                }
                $emptyDataRow["data"][$field] = $value;
            }
        }
        $emptyDataRow = $this->_checkColumnShift( $emptyDataRow );
        $this->emptyDataRow = $emptyDataRow;
        return $emptyDataRow;
    }

    function _outputHeaders ($headers, $showTitle = false, $output = true) {
        $html .= $this->_openTag( "thead" , null , $output );
        if ($this->title && $showTitle) {
            $html .= $this->_openTag( "tr" , null , $output );
            $html .= $this->_openTag( "th" , array(
                
                    "colspan" => count( $headers ), 
                    "class" => "title"
            ) , $output );
            $html .= $this->_outputHTML( $this->title , false , $output );
            $html .= $this->_closeTag( "th" , $output );
            $html .= $this->_closeTag( "tr" , $output );
        }
        if ($headers) {
            $html .= $this->_openTag( "tr" , null , $output );
            foreach ($headers as $header) {
                $html .= $this->_openTag( "th" , $header["attrib"] , $output );
                $html .= $this->_outputHTML( $header["html"] , false , $output );
                $html .= $this->_closeTag( "th" , $output );
            }
            $html .= $this->_closeTag( "tr" , $output );
        }
        $html .= $this->_closeTag( "thead" , $output );
        return $html;
    }

    function _setOptions ($options) {
        if (!$options) return;
        foreach ($options as $name => $value) {
            $this->$name = $value;
        }
    }

    function _openTag ($tag, $args = null, $output = true) {
        if($output)
            var_dump( $tag.'_openTag'.$output );
        $nl = "\n";
        $tabs = str_repeat( "\t" , $this->indent + $this->_curIndent );
        $selfClosing = (in_array( $tag , array(
            "input", "img", "br"
        ) )) ? true : false;
        $close = ($selfClosing) ? " /" : null;
        if ($args) {
            foreach ($args as $name => $value) {
                $value = trim( $value );
                if ($value || is_numeric( $value )) {
                    if ($value == "NULL_STRING") $value = ""; // Fairly ghetto hack to force value="" into checkboxes.
                    $value = htmlspecialchars( trim( $value ) );
                    $attributes .= " $name=\"$value\"";
                }
            }
        }
        $html = "$nl$tabs<$tag$attributes$close>";
        if ($output) echo $html;
        if (!$selfClosing) $this->_curIndent++;
        $this->_hasTags = ($selfClosing) ? true : false;
        return $html;
    }

    function _outputHTML ($html, $lineBreaks = false, $output = true) {
        if($output)
            var_dump( '_outputHTML'.$output );
        if (!isset( $html )) return;
        if (is_array( $html )) {
            $result = '';
            if ($this->_isHash( $html )) {
                $result .= $this->_openTag( $html["tag"] , $html["attrib"] , $output );
                $result .= $this->_outputHTML( $html["html"] , $lineBreaks , $output );
                $result .= $this->_closeTag( $html["tag"] , $output );
                return $result;
            }
            else {
                foreach ($html as $element) {
                    $result .= $this->_outputHTML( $element , $lineBreaks , $output );
                }
                return $result;
            }
        }
        else {
            $html = nl2br( $html );
            if ($lineBreaks) $html = nl2br( $html );
            if ($output) echo $html;
            return $html;
        }
    }

    function _closeTag ($tag, $output = true) {
        if($output)
            var_dump( '_closeTag'.$output );
        $selfClosing = (in_array( $tag , array(
            "input", "img", "br"
        ) )) ? true : false;
        if ($selfClosing) return '';
        $this->_curIndent--;
        $nl = "\n";
        $tabs = str_repeat( "\t" , $this->indent + $this->_curIndent );
        if (!$this->_hasTags) {
            $html = "</$tag>";
            $this->_hasTags = true;
        }
        else {
            $html = "$nl$tabs</$tag>";
        }
        if ($output) echo $html;
        return $html;
    }

    function _autoFormatHeader ($header) {
        if (is_numeric( $header ))
            return null;
        elseif (in_array( $header , array(
            "FIRST", "LAST", "BEFORE", "AFTER"
        ) ))
            return null;
        if ($this->readableHeaders) {
            $header = str_replace( "_" , " " , $header );
            $header = preg_replace( "/([A-Z])/" , " \\1" , $header );
            $header = ucwords( strtolower( $header ) );
        }
        return $header;
    }

    function _getLabel ($label, $for, $class = null, $output = true) {
        $label = $this->$label;
        if (!$label) return;
        $html .= $this->_openTag( "label" , array(
            "for" => $for, "class" => $class
        ) ,$output);
        $this->_outputHTML( $label ,false,$output);
        $this->_closeTag( "label" ,$output);
    }

    function _checkColumnClass ($column, $num = null) {
        if ($this->columns[$column])
            return $this->columns[$column];
        elseif ($this->column[$num])
            return $this->columns[$num];
        elseif ($column == "EDIT" || $column == "DELETE")
            return strtolower( $column );
        elseif (isset( $this->primaryKeyColumnsByName[$column] )) {
            $class = "primary_key";
            if ($this->primaryKeyColumnsByName[$column]["auto"]) {
                $class .= " auto_increment";
            }
            return $class;
        }
    }

    function _getOptionsArray ($field, $column, $data) {
        $arg = $this->selects[$column] ? $this->selects[$column] : $this->selects[$field];
        if (is_array( $arg ) || !$arg) return $arg;
        list($type, $params) = $this->_getParams( $arg , true );
        if ($type == "increment") {
            $options = array();
            if ($params["convert_time"]) $data = strtotime( $data );
            $abs = ($params["absolute"] || $params["abs"]) ? true : false;
            $min = isset( $params["min"] ) ? $params["min"] : -INF;
            $max = isset( $params["max"] ) ? $params["max"] : INF;
            $step = ($params["step"]) ? $params["step"] : 1;
            $start = ($abs) ? $min : $data - ceil( $params["range"] / 2 ) * $step;
            $stop = ($abs) ? $max : $data + ceil( $params["range"] / 2 ) * $step;
            if (!is_numeric( $start ) || !is_numeric( $stop ) || !$step) return array();
            for ($i = $start; $i <= $stop; $i += $step) {
                $num = $i;
                if (!$abs && ($num < $min || $num > $max)) continue;
                if ($params["convert_time"]) $num = date( MYSQL_DATE_FORMAT , $num );
                array_push( $options , $num );
            }
            return $options;
        }
    }

    function _getSortType ($field) {
        $format = $this->formatting[$field];
        if (!$format) return null;
        list($type) = $this->_getParams( $format );
        if ($type == "date") return "date";
        if ($type == "eDate") return "eDate";
        if ($type == "memory")
            return "memory";
        elseif ($type == "numeric" || $type == "currency")
            return "numeric";
    }

    function _getFormatted ($data, $field, $column) {
        if (!$this->_testForOption( "formatting" , $field , $column )) return $data;
        $format = $this->formatting[$column] ? $this->formatting[$column] : $this->formatting[$field];
        list($type, $params) = $this->_getParams( $format );
        if ($type == "date" || $type == "eDate") {
            if (!is_numeric( $data )) $data = strtotime( $data );
            if (is_null( $data )) return null;
            if (preg_match( "/^[A-Z0-9_]+$/" , $params ) && strlen( $params ) > 1) $params = constant( $params );
            return ($params) ? date( $params , $data ) : date( "F j, Y" , $data );
        }
        elseif ($type == "currency") {
            list($type, $params) = $this->_getParams( $format , true );
            $currency = $data;
            $precision = (isset( $params["precision"] )) ? $params["precision"] : 2;
            $thousands = (isset( $params["thousands"] )) ? $params["thousands"] : ",";
            $decimal = (isset( $params["decimal"] )) ? $params["decimal"] : ".";
            $padding = $params["pad"] ? $precision : false;
            $currency = number_format( round( $currency , $precision ) , $precision , $decimal , $thousands );
            $currency = $padding ? $currency : str_replace( ".00" , "" , $currency );
            $currency = $params["prefix"] . $currency;
            $currency = $currency . $params["suffix"];
            return $currency;
        }
        elseif ($type == "numeric") {
            list($type, $params) = $this->_getParams( $format , true );
            $precision = (isset( $params["precision"] )) ? $params["precision"] : 0;
            $thousands = (isset( $params["thousands"] )) ? $params["thousands"] : ",";
            $decimal = (isset( $params["decimal"] )) ? $params["decimal"] : ".";
            if ($decimal == "COMMA") $decimal = ",";
            return number_format( round( $data , $precision ) , $precision , $decimal , $thousands );
        }
        elseif ($type == "memory") {
            list($type, $params) = $this->_getParams( $format , true );
            $auto = $params["auto"];
            $precision = $params["precision"] ? $params["precision"] : 0;
            $unit = $params["unit"] ? strtolower( $params["unit"] ) : "b";
            $units = array(
                
                    "b", 
                    "kb", 
                    "mb", 
                    "gb", 
                    "tb", 
                    "pb", 
                    "eb"
            );
            $memory = $data;
            if ($auto) {
                $u = $unit;
                $u = str_replace( "bytes" , "b" , $u );
                $u = str_replace( "kilobytes" , "kb" , $u );
                $u = str_replace( "megabytes" , "mb" , $u );
                $u = str_replace( "gigabytes" , "gb" , $u );
                $u = str_replace( "terabytes" , "tb" , $u );
                $u = str_replace( "petabytes" , "pb" , $u );
                $u = str_replace( "exabytes" , "eb" , $u );
                $index = array_search( $u , $units );
                while ($memory > 999 && $index !== FALSE) {
                    if (!$units[++$index])
                        break;
                    else {
                        $unit = $units[$index];
                        $memory = $memory / 1000;
                    }
                }
            }
            if (!$params["small"] && $unit == "mb" || $unit == "kb") $precision = 0;
            $unit = ($unit == "b") ? "B" : $unit;
            $unit = $params["capital"] ? strtoupper( $unit ) : $unit;
            $unit = $params["camel"] ? ucwords( $unit ) : $unit;
            $space = $params["space"] ? " " : null;
            $memory = number_format( round( $memory , $precision ) , $precision );
            if ($precision > 0) $memory = str_replace( ".0" , "" , str_replace( ".00" , "" , $memory ) );
            $memory .= $space . $unit;
            return $memory;
        }
        return $data;
    }

    function _getInputFormat ($value, $field) {
        list($type, $params) = $this->_getParams( $this->inputFormat[$field] );
        if (!$type) return $value;
        $type = strtolower( str_replace( " " , "" , $type ) );
        if ($type == "date" || $type == "edate") {
            /* Get English Dates */
            if ($type == "edate") $value = preg_replace( "/^(\d{1,2})[\/\-.](\d{1,2})[\/\-.](\d{2,4})$/" , "\\2/\\1/\\3" , $value );
            /* Get Japanese/Chinese dates */
            $value = mb_convert_kana( $value , "as" , "UTF-8" );
            $value = preg_replace( "/^(\d+)年(\d+)月(\d+)日$/" , "\\2/\\3/\\1" , $value );
            /* Note: 32-bit platforms only support dates between 1901 and 2038 */
            $stamp = is_numeric( $value ) ? $value : strtotime( $value );
            if (!$stamp) {
                $this->_addError( $field , "Timestamp is invalid" );
                return false;
            }
            if ($params == "timestamp" || $params == "TIMESTAMP") {
                return $stamp;
            }
            else {
                if (preg_match( "/^[A-Z0-9_]+$/" , $params ))
                    $format = constant( $params );
                else
                    $format = $params ? $params : MYSQL_DATE_FORMAT;
                $date = date( $format , $stamp );
                if (!$date) $this->_addError( $field , "Date is invalid" );
                return $date;
            }
        }
        elseif ($type == "numeric") {
            $number = str_replace( "," , "" , $value );
            preg_match( "/[-+]?[0-9]*\.?[0-9]+/" , $number , $match );
            if (!$match[0]) $this->_addError( $field , "Numeric format is invalid" );
            return $match[0];
        }
    }

    function _getParams ($option, $subparams = false) {
        $split = explode( "[" , $option );
        $type = $split[0];
        $params = rtrim( $split[1] , "]" );
        if ($subparams) {
            $split = explode( "," , $params );
            $params = array();
            foreach ($split as $sub) {
                list($name, $value) = explode( "=" , $sub );
                if (!isset( $value )) $value = true;
                $params[$name] = $value;
            }
        }
        return array(
            $type, $params
        );
    }

    function _testForOption ($option, $field, $column = null) {
        if ($field == "EDIT" || $field == "DELETE") return false;
        $option = $this->$option;
        if ($option == "all") return true;
        if ($option == "allExceptAutoIncrement") {
            $column = $this->primaryKeyColumnsByName[$field];
            return ($column && $column["auto"]) ? false : true;
        }
        elseif (is_array( $option )) {
            $associative = $this->_isHash( $option );
            if ($option[$field] || ($associative && $option[$column])) return true;
            return (in_array( $field , $option ) || in_array( $column , $option )) ? true : false;
        }
        return false;
    }

    function _addClass ($add, $class = null, $test = null) {
        $class .= ($add && $class) ? " " : null;
        if (isset( $test ))
            $class .= ($test) ? $add : null;
        else
            $class .= $add;
        return $class;
    }

    function _dataTransform ($data, $field, $row, $column, $key, $transform = null, $associated = null) {
        if (!$this->_testForOption( "transform" , $field , $column )) return $data;
        if (!$transform) {
            $transform = $this->transform[$field] ? $this->transform[$field] : $this->transform[$column];
        }
        if (is_array( $transform )) {
            if ($transform["associate"]) $associated = $transform["associate"];
            if ($transform["attrib"] && is_array( $transform["attrib"] )) {
                foreach ($transform["attrib"] as $attrib => $value) {
                    $transform["attrib"][$attrib] = $this->_dataTransform( $data , $field , $row , $column , $key , $value , $associated );
                }
            }
            if ($transform["html"]) $transform["html"] = $this->_dataTransform( $data , $field , $row , $column , $key , $transform["html"] , $associated );
        }
        else {
            $transform = str_replace( "{DATA}" , $data , $transform );
            $transform = str_replace( "{KEY}" , $key , $transform );
            $transform = str_replace( "{FIELD}" , $field , $transform );
            $transform = str_replace( "{COLUMN}" , $column , $transform );
            $transform = str_replace( "{RANDOM}" , rand( 0 , 9999 ) , $transform );
            if ($associated) {
                $text = $this->_getFormatted( $this->data[$row]["data"][$associated] , $associated , $column );
                $transform = str_replace( "{ASSOCIATED}" , $text , $transform );
            }
        }
        return $transform;
    }

    function _checkColumnShift ($array = null) {
        $shift = $this->shiftColumns;
        if (!$shift) return $array;
        foreach ($shift as $col => $pos) {
            if ($array) {
                $array["data"] = $this->shiftColumn( $array["data"] , $col , $pos );
            }
            else {
                if($this->data){
                    foreach ($this->data as $rowIndex => $row) {
                        $this->data[$rowIndex]["data"] = $this->shiftColumn( $row["data"] , $col , $pos );
                    }
                }
            }
        }
        return $array;
    }

    function _injectURLParam ($inputName, $inputValue) {
        $params = array();
        foreach ($_GET as $name => $value) {
            if ($name == $inputName) {
                $match = true;
                $value = urlencode($inputValue);
            }
            if(is_array($value)){
                foreach($value as $key=>$val){
                    $param = $name.'['.$key.']='.(urlencode($val));
                    array_push( $params , $param );
                }
            }else{
                $param = "$name=".(urlencode($value));
                array_push( $params , $param );
            }
        }
        if (!$match) {
            $param = "$inputName=".(urlencode($inputValue));
            array_push( $params , $param );
        }
        $uri = $_SERVER["PHP_SELF"] . "?" . implode( "&" , $params );
        return $uri;
    }

    function _navLink ($type, $html ,$output = true) {
        $current = $this->pagination["currentPage"];
        $total = $this->pagination["totalPages"];
        $tag = (($type == "prev" && $current <= 1) || ($type == "next" && $current >= $total)) ? "div" : "a";
        $attribs = array(
            "class" => $type
        );
        if ($tag == "a") {
            $page = ($type == "prev") ? $current - 1 : $current + 1;
            $attribs["href"] = $this->_injectURLParam( "page" , $page );
            $attribs["id"] = $type . "Page";
        }
        $html .= $this->_openTag( $tag , $attribs ,$output);
        $html .= $this->_outputHTML( $html ,false,$output);
        $html .= $this->_closeTag( $tag ,$output);
        if(!$output){
           return $html; 
        }
    }

    function _modifyURIParams ($added, $append = false) {
        $params = $this->_getURIParams();
        foreach ($added as $name => $value) {
            $params[$name] = $value;
        }
        if ($append) $this->URIParams = $params;
        return $this->_getURI( $params );
    }

    function _getURIParams () {
        if ($this->URIParams) return $this->URIParams;
        $this->URIParams = array();
        $split = explode( "&" , $_SERVER["QUERY_STRING"] );
        foreach ($split as $param) {
            list($name, $value) = explode( "=" , $param );
            $this->URIParams[$name] = $value;
        }
        return $this->URIParams;
    }

    function _getURI ($params = null) {
        $params = $params ? $params : $this->_getURIParams();
        $faux_params = array(); // Finally I see why Ruby is so much better (other than just syntax).
        foreach ($params as $name => $value) {
            if (!isset( $value )) continue;
            array_push( $faux_params , "$name=$value" );
        }
        $URI = $_SERVER["PHP_SELF"] . "?" . implode( "&" , $faux_params );
        return $URI;
    }

    function _isHash ($array) {
        return (array_keys( $array ) != range( 0 , count( $array ) - 1 )) ? true : false;
    }

    /* Functions for handling submitted data */
    function _checkSubmit () {
        if (!$this->_httpArray) $http = ($this->form["method"] == "get") ? $_GET : $_POST;
        if ($http["table"] != $this->table["id"]) return;
        $this->_httpArray = $this->_handleMagicQuotes( $http );
        if ($this->_httpArray["edit"]) $this->_processSubmit( "edit" );
        if ($this->_httpArray["delete"]) $this->_processSubmit( "delete" );
        if ($this->_httpArray["insert"]) $this->_processSubmit( "insert" );
        $this->_jsonOutput();
    }

    function _processSubmit ($action) {
        $this->_json["affected"] = 0;
        if ($action == "insert")
            $this->_insertRow();
        else {
            $rows = $this->_httpArray[$action];
            if (!$rows) return;
            // Note: $cKey denotes that there may be composite keys!
            foreach ($rows as $cKey) {
                if ($action == "delete")
                    $this->_deleteRow( $cKey );
                elseif ($action == "edit")
                    $this->_updateTable( $cKey );
                if (is_numeric( $this->_affectedRows )) {
                    $this->_json["affected"] = $this->_affectedRows;
                }
            }
        }
        $this->_json["action"] = $action;
        $this->_getTotals();
    }

    function _insertRow () {
        $table = $this->database["table"];
        if (!$table) return;
        $fields = array_keys( $this->_httpArray["data"] );
        $values = $this->_constructQueryValues( $this->_httpArray["data"] );
        if ($this->errors) return;
        $query = "INSERT INTO $table (" . implode( "," , $fields ) . ") VALUES (" . implode( "," , $values ) . ")";
        $data = $this->query( $query );
        if ($data !== false) {
            $this->_json["affected"] = $this->_affectedRows; // Timing requires this to be here.
            $this->_json["key"] = $this->_getPrimaryKeyValuesAfterInsertion( $this->_httpArray["data"] );
            $this->_callback( "onInsert" , $this->_json["key"] , $callbackPrev , $this->_httpArray["data"] );
        }
    }

    function _deleteRow ($cKey) {
        if ($this->connection) {
            $table = $this->database["table"];
            if (!$table) return;
            if ($this->callback["getPrevious"]) {
                $query = $this->_limitQueryByPrimaryKey( "SELECT * FROM $table" , $cKey );
                $callbackPrev = $this->query( $query );
                $callbackPrev = $callbackPrev[0];
            }
            $query = $this->_limitQueryByPrimaryKey( "DELETE FROM $table" , $cKey );
            $result = $this->query( $query );
            if ($result) {
                $this->_json["key"] = $cKey;
                $this->_callback( "onDelete" , $cKey , $callbackPrev );
            }
        }
        elseif ($this->data) {
            $row = $this->_selectArrayRow( $cKey );
            if ($this->data[$row]) {
                $callbackPrev = $this->data[$row];
                unset( $this->data[$row] );
                $this->_callback( "onDelete" , $cKey , $callbackPrev );
                return 1;
            }
        }
    }

    function _updateTable ($cKey) {
        $table = $this->database["table"];
        if (!$table) return;
        if ($this->callback["getPrevious"]) {
            $query = $this->_limitQueryByPrimaryKey( "SELECT * FROM $table" , $cKey );
            $callbackPrev = $this->query( $query );
            $callbackPrev = $callbackPrev[0];
        }
        $values = $this->_constructQueryValues( $this->_httpArray["data"][$cKey] , true );
        if ($this->errors) return;
        $query = $this->_limitQueryByPrimaryKey( "UPDATE $table SET " . implode( "," , $values ) , $cKey );
        $result = $this->query( $query );
        if ($result) {
            $updatedData = $this->_httpArray["data"][$cKey];
            $this->_getUpdatedOptions( $this->_httpArray["data"][$cKey] , $this->_httpArray["column"] );
            $this->_json["key"] = $this->_getPrimaryKeyValuesAfterUpdate( $updatedData , $cKey );
            $keys = array_keys( $this->_httpArray["data"][$cKey] );
            $field = $keys[0];
            $transformed = $this->_dataTransform( $this->_json["formatted"] , $field , $cKey , $this->_httpArray["column"] , $cKey );
            $this->_json["formatted"] = $this->_outputHTML( $transformed , false , false );
            $this->_callback( "onUpdate" , $cKey , $callbackPrev , $updatedData );
        }
    }

    function _constructQueryValues ($dataSet, $update = null) {
        $values = array();
        $count = 1;
        foreach ($dataSet as $field => $userInput) {
            $data = $this->_getInputFormat( $userInput , $field );
            $column = $this->_httpArray["column"] ? $this->_httpArray["column"] : $count;
            $this->_validateData( $data , $field , $column );
            $sql = mysql_real_escape_string( $data , $this->connection );
            if (!isset( $sql ))
                $sql = "NULL";
            elseif (is_numeric( $sql ))
                $sql = floatval( $sql );
            else
                $sql = "'$sql'";
            $sql = ($update) ? "$field=$sql" : $sql;
            array_push( $values , $sql );
            $this->_json["field"] = $field;
            $this->_json["value"] = $userInput;
            $this->_json["formatted"] = nl2br( $this->_getFormatted( $data , $field , $column ) );
            $count++;
        }
        return $values;
    }

    function _getUpdatedOptions ($data, $column) {
        $options = array();
        foreach ($data as $field => $value) {
            if (!$this->_hasIncrementedSelect( $field , $column )) continue;
            if ($this->_testForOption( "selects" , $field , $column )) {
                $arr = $this->_getOptionsArray( $field , $column , $value );
                foreach ($arr as $val) {
                    $option = array();
                    $option["value"] = $val;
                    $option["formatted"] = $this->_getFormatted( $val , $field , $column );
                    array_push( $options , $option );
                }
            }
        }
        if (count( $options ) > 0) $this->_json["updatedOptions"] = $options;
    }

    function _hasIncrementedSelect ($field, $column) {
        $arg = $this->selects[$column] ? $this->selects[$column] : $this->selects[$field];
        if (is_array( $arg ) || !$arg) return false;
        list($type, $params) = $this->_getParams( $arg , true );
        return $type == "increment";
    }

    function _callback ($type, $key, $previous = null, $updated = null) {
        $function = $this->callback[$type];
        if (!function_exists( $function )) return;
        $userExposedKey = $this->_getPrimaryKeyArrayOrValue( $key );
        $updated = $this->_appendPrimaryKeyValues( $updated , $key );
        call_user_func( $function , $userExposedKey , $previous , $updated , $this );
    }

    function _getPrimaryKeyArrayOrValue ($key) {
        $key = implode( $this->primaryKeyDelimiter , $key );
        return count( $key == 1 ) ? $key[0] : $key;
    }

    function _appendPrimaryKeyValues ($updated, $values) {
        $values = implode( $this->primaryKeyDelimiter , $values );
        foreach ($this->_getPrimaryKeyColumns() as $i => $key) {
            $updated[$key["name"]] = $values[$i];
        }
        return $updated;
    }

    function _getTotals () {
        $totals = $this->totals;
        if (!$totals || !$this->connection) return;
        $this->_json["totals"] = array();
        $this->fetchData();
        foreach ($totals as $field) {
            $total = 0;
            if ($this->data) {
                foreach ($this->data as $row) {
                    if (is_numeric( $field )) {
                        $data = array_values( $row["data"] );
                        $total += $data[$field - 1];
                    }
                    else {
                        $total += $row["data"][$field];
                    }
                }
            }
            $total = $this->_getFormatted( $total , $field , $this->_httpArray["column"] );
            $type = is_numeric( $field ) ? "column" : "field";
            array_push( $this->_json["totals"] , array(
                $type => $field, "total" => $total
            ) );
        }
    }

    function _validateData ($data, $field, $column) {
        if (!$this->_testForOption( "validate" , $field , $column )) return true;
        $validation = $this->validate[$field] ? $this->validate[$field] : $this->validate[$column];
        if (preg_match( $validation , $data ))
            return true;
        else {
            $this->_addError( $field , "Validation failed." );
        }
    }

    function _addError ($field, $message) {
        if (!$this->errors) $this->errors = array();
        array_push( $this->errors , array(
            "field" => $field, "message" => $message
        ) );
    }

    function _selectArrayRow ($key) {
        foreach ($this->data as $index => $row) {
            if ($row["key"] == $key) return $index;
        }
    }

    function _handleMagicQuotes ($array) {
        if (!get_magic_quotes_gpc()) return $array;
        foreach ($array as $key => $value) {
            if (is_array( $value ))
                $value = $this->_handleMagicQuotes( $value );
            else
                $value = stripslashes( $value );
            $array[$key] = $value;
        }
        return $array;
    }

    function _jsonOutput () {
        if ($_SERVER["HTTP_X_REQUESTED_WITH"] != "XMLHttpRequest") return;
        $json = $this->_json;
        if (!$json) $json = array(
            "success" => false, "info" => "No actions performed."
        );
        $json = $this->_jsonEncode( $json );
        die( $json );
    }

    /* For PHP installs less than 5.2.0 */
    function _jsonEncode ($array) {
        if (function_exists( json_encode )) return json_encode( $array );
        $assoc = false;
        for ($i = 0; $i < sizeof( $keys = array_keys( $array ) ); $i++) {
            if (strval( $i ) != $keys[$i]) $assoc = true;
        }
        $json = ($assoc) ? "{" : "[";
        foreach ($array as $key => $value) {
            $key = addslashes( $key );
            if ($assoc) $json .= "'$key':";
            if (is_array( $value ))
                $json .= $this->_jsonEncode( $value );
            elseif (is_string( $value ))
                $json .= "'" . addslashes( $value ) . "'";
            elseif (is_bool( $value ))
                $json .= ($value) ? "true" : "false";
            elseif (is_null( $value ))
                $json .= "null";
            else
                $json .= $value;
            $json .= ",";
        }
        $json = rtrim( $json , "," );
        $json .= ($assoc) ? "}" : "]";
        return $json;
    }
}
