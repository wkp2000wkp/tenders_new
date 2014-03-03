<?php
/**
 * BaseAction 
 * @author john_yu
 * @date 2010-02-25
 */
class APPBaseAction extends CAction
{

    public $uid;

    public $userType;

    public $userName;
    
    public $pageSize = 100;

    public $sqlInList = array('tb_show_id','tb_id','kb_r_id');
    public $sqlLikeList = array(

            "project_name", 
            "company_name", 
            "bidding_agent", 
            "tenderer", 
            "specification", 
            "slesman", 
            "tender_manager", 
            "respective_regions", 
            "respective_provinces"
    );
		
	public  $connect = null;
		
    public function getUid () {
        if (!$this->uid) {
            if ($_SESSION['uid']) {
                $this->uid = $_SESSION['uid'];
            }
            else {
                Yii::app()->showbox->showMessageBox( 'login_time_out' , 'index.php' );
            }
        }
        return $this->uid;
    }

    public function getUserName () {
        if (!$this->userName) {
            if ($_SESSION['username']) {
                $this->userName = $_SESSION['username'];
            }
            else {
                Yii::app()->showbox->showMessageBox( 'login_time_out' , 'index.php' );
            }
        }
        return $this->userName;
    }

    public function getUserType () {
        if (!$this->userType) {
            if ($_SESSION['user_type']) {
                $this->userType = $_SESSION['user_type'];
            }
            else {
                Yii::app()->showbox->showMessageBox( 'login_time_out' , 'index.php' );
            }
        }
        return $this->userType;
    }

    public function getParamDateToTime ($name, $defaultValue = null) {
        $return = $this->getParam( $name , $defaultValue );
        return strtotime( $return );
    }

    public function getParamForAbsIntval ($name, $defaultValue = null) {
        $return = $this->getParam( $name , $defaultValue );
        return intval( abs( $return ) );
    }

    public function getParam ($name, $defaultValue = null) {
        $return = Yii::app()->getRequest()->getParam( $name , $defaultValue );
        return $return;
    }

    public function run () {
    }

    public function insertSql ($tableName, array $fields) {
        $sql = '';
        if ($fields) {
            $sql = 'INSERT INTO ' . $tableName . '(' . (join( array_keys( $fields ) , ',' )) . ') value("' . (join( $fields , '","' )) . '");';
        }
        return $sql;
    }

    public function getUpdateSect (Array $array) {
        $updateSect = ' SET ';
        foreach ($array as $key => $value) {
            $updateSect .= '`' . $key . '`="' . $value . '",';
        }
        return substr_replace( $updateSect , '' , -1 );
    }

    public function getSqlSelect ($tableName, $columns = array(), $whereDate = array(), $checkUser = true) {
        $sql = 'select SQL_CALC_FOUND_ROWS ' . $this->getSqlColumns( $columns ) . ' from ' . $tableName . $this->getSqlSelectForWhere( $whereDate , $checkUser );
        return $sql;
    }

    private function getSqlColumns (array $columns = array()) {
        $sql = ' * ';
        if ($columns) {
            $sql = '`' . implode( '`,`' , $columns ) . '`';
        }
        return $sql;
    }

    public function getSqlSelectForWhere ($whereDate = array(), $checkUser = true,$as='') {
    	if(!$as)
        	$sql = ' where 1 ';
        if (!isset( $whereDate['is_deleted'] )) $sql .= ' and '.$as.'is_deleted = "0" ';
        if ($whereDate) {
            foreach ($whereDate as $key => $value) {
                if ($value) {
                    if (in_array( $key , $this->sqlLikeList )) {
                        $sql .= ' and ' . $as.$key . ' like "%' . $value . '%"';
                    }
                    elseif ($key == 'random') {
                    	 //强制过滤推挤参数--解决360提交两次最后参数丢失问题，强制添加随机无用参数
                        continue;
                    }
                    elseif ($key == 'from_time') {
                        $sql .= ' and '.$as.'end_time >= "' . $value . '"';
                    }
                    elseif ($key == 'to_time') {
                        $value = date( 'Y-m-d' , strtotime( $value ) + 86400 );
                        $sql .= ' and '.$as.'end_time < "' . $value . '"';
                    }
                    elseif (in_array( $key , $this->sqlInList )) {
        				$valueAry = @explode(SelectConstent::EXPLODE_STRING,$value);
        				if(is_array($valueAry) && count($valueAry) > 1){
        					$sql .= ' and '.$as.$key .' IN (' . join($valueAry, ',') . ')';
        				}else{
        					$sql .= ' and ' . $as.$key  . '="' . $value . '"';
        				}
                    }
                    elseif ( $key == "bid_company" ) {
                    $valueAry = @explode(SelectConstent::EXPLODE_STRING,$value);
    					if(is_array($valueAry) && count($valueAry) > 1){
    						$sql .= ' and  ( '.$as.$key .' ="' . join($valueAry, '" or '.$as.$key .' ="')  . '")';
    					}else{
    						$sql .= ' and ' . $as.$key  . ' like "%' . $value . '%"';
    					}

                    }else {
                        $sql .= ' and ' . $as.$key  . '="' . $value . '"';
                    }
                }
            }
        }
        return $sql;
    }
    
    public function getSqlSelectForWhere2 ($whereDate = array()) {
    	$sql = ' ';
    	if (!isset( $whereDate['is_deleted'] )) $sql .= ' and b.is_deleted = "0" ';
    	if ($whereDate) {
    		foreach ($whereDate as $key => $value) {
    			if ($value) {
    				switch ($key){
    					case 'from_creat_time':
    						$sql .= ' and c.end_time >= "' . $value . '"';
    						break;
    					case 'to_creat_time':
    						$value = date( 'Y-m-d' , strtotime( $value ) + 86400 );
    						$sql .= ' and c.end_time < "' . $value . '"';
    						break;
    					case "bid_company":
    						$valueAry = @explode(SelectConstent::EXPLODE_STRING,$value);
    						if(is_array($valueAry) && count($valueAry) > 1){
    							$sql .= ' and  ( b.bid_company ="' . join($valueAry, '" or b.bid_company ="')  . '")';
    						}else{
    							$sql .= ' and b.' . $key . ' like "%' . $value . '%"';
    						}
    						break;
    					case 'bu_id':
    						$sql .= ' and c.' . $key . '="' . $value . '"';
    						break;
    					case 'bid':
    						$sql .= ' and b.' . $key . '="' . $value . '"';
    						break;
    					case 'kb_r_id':
    						if(is_array($value) && count($value) > 1){
    							$sql .= ' and b.'.$key.' IN (' . join($value, ',') . ')';
    						}else{
    							$sql .= ' and b.' . $key . '="' . $value . '"';
    						}
    						break;
    					case 'tb_show_id':
    						$valueAry = @explode(SelectConstent::EXPLODE_STRING,$value);
    						if(is_array($valueAry) && count($valueAry) > 1){
    							$sql .= ' and c.'.$key.' IN (' . join($valueAry, ',') . ')';
    						}else{
    							$sql .= ' and c.' . $key . '="' . $value . '"';
    						}
    						break;
    				}
    
    			}
    		}
    	}
    	return $sql;
    }

    public function checkPermissions ($uid, $show = true) {
        if ($this->getUserType() != SelectConstent::USER_TYPE_ADMIN && $this->getUid() != $uid) {
            if ($show) {
                Yii::app()->showbox->showMessageBox( 'no_permissions' , '-1' );
            }
            else {
                return false;
            }
        }
        return true;
    }

    public function sumData ($data, $key) {
        $sumNumber = 0;
        if ($data) {
            foreach ($data as $row) {
                if (is_array( $row['data'] )) {
                    $sumNumber += round( $row['data'][$key] , 3 );
                }
                else {
                    $sumNumber += round( $row[$key] , 3 );
                }
            }
        }
        return $sumNumber;
    }
    
    
    public function getConnect(){
        if(!$this->connect){
            $databaseConfig = SelectConstent::getDataBaseConfig();
	        $options["database"]["host"] = $databaseConfig['host'];
	        $options["database"]["name"] =  $databaseConfig['db'];
	        $options["database"]["username"] = $databaseConfig['user'];
	        $options["database"]["password"] = $databaseConfig['password'];
	        $this->connect = mysql_connect($databaseConfig['host'], $databaseConfig['user'], $databaseConfig['password']);
	        if (!$this->connect)
			  {
			  die('Could not connect: ' . mysql_error());
	        }
			$db_selected = mysql_select_db($databaseConfig['db'],$this->connect);
        }
        return $this->connect;
    }
    
    public function fetchArray($sql){
        $list = array();
        $result = $this->query($sql,$this->getConnect());
        if($result){
	        while($row = mysql_fetch_array($result,MYSQL_ASSOC )){
			    $list[] = $row;
			}
        }
		return $list;
    }
    
    public function query($sql){
    	return mysql_query($sql,$this->getConnect());
    }
    
    public function insert_auto($tableName, array $fields){
    	$insertSql = $this->insertSql($tableName,$fields);
    	$this->query($insertSql);
    	return $this->insert_id();
    }
    
    public function insert_id(){
    	return mysql_insert_id();
    }
    
    public function getTablePaginationHtml($currentPage){
    	$currentPage = ( $currentPage > 0 ) ? intval($currentPage) : 1;
    	$row = $this->fetchArray( "SELECT FOUND_ROWS() AS total" );
    	$totalPages = ceil( $row[0]["total"] / $this->pageSize );
    	$linkCount = 100;
    	$show['min'] = ($page - $linkCount < 1) ? 1 : $currentPage - $linkCount;
    	$show['max'] = ($page + $linkCount > $totalPages) ? $totalPages : $currentPage + $linkCount;
    	$show['current_page'] = $currentPage;
    	$show['uri'] = $this->excludeURLParam('page');
    	return $this->getController()->renderPartial("/layouts/table_page_list",$show,true);
    }
    
    
    function excludeURLParam ($inputName) {
    	$params = array();
    	foreach ($_GET as $name => $value) {
    		if ($name == $inputName) {
    			continue;
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
    	$uri = $_SERVER["PHP_SELF"] . "?" . implode( "&" , $params );
    	return $uri;
    }

    
}