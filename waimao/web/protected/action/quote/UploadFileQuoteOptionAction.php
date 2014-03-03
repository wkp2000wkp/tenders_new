<?php
/**
 *
 * @author john_yu
 * @date 2010-10-10
 */
class UploadFileQuoteOptionAction extends APPBaseAction
{
    public $tableName = '';
    public function run () {
        $action = $this->getParam('action','insert');
        $id = $this->getParamForAbsIntval('id','0');
        $data = $this->getParam('data');
        $url = '-1';
        $message = 'no_data_submit';
        if( !$action){
            Yii::app()->showbox->showMessageBox( $message , $url );
        }
        $return = $this->getTable($table);
        $this->tableName = $return['table'];
        Yii::app()->tablegear->dataTaseTable = $this->tableName;
        switch ($action){
            case 'insert':
                $this->uploadFile($id,$data);
                break;
            case 'update':
                $data['remark'] = $this->getParam('remark');
	            $option = $this->update($id,$data);
                break;
            case 'delete':
	            $option = $this->delete($id);
		        if($option){
			        $url = $return['url'];
		            $message = $action.'_option_success';
		        }else{
		            $message = $action.'_option_faile';
		        }
		        Yii::app()->showbox->showMessageBox( $message , $url );
                break;
        }
    }
    
    private function getTable($table){
        $quoteId = $this->getParam('tb_id','');
        $return['table'] =  SelectConstent::TABLE_QUOTE_UPLOADFILE;
        $return['url'] = URL_DOMAIN.'/index.php?r=quote/ulist&id='.$quoteId;
        return $return;
    }
    
    private function uploadFile($quoteId,$data){
	    if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = WEB_UPLOAD_PATH . '/';
			$fileName = $_FILES['Filedata']['name'];
			$pathName = time().'_file.'.strtolower(substr(strrchr($fileName, "."), 1));
			$targetFile =  str_replace('//','/',$targetPath) . $pathName;
			move_uploaded_file($tempFile,iconv("UTF-8","gb2312", $targetFile));
			$this->addUploadFile($quoteId,$fileName,$pathName,$data);
			echo '1';
	    }
    }
    
    private function addUploadFile($quoteId,$fileName,$pathName,$data){
        $insert['quote_id'] = $quoteId;
        $insert['file_name'] = $fileName;
        $insert['path_name'] = $pathName;
        $insert['date_time'] = date('Y-m-d H:i:s');
        $insert['remark'] = $data['remark'];
        $insert['uid'] = $data['uid'];
        $insertSql = $this->insertSql(SelectConstent::TABLE_QUOTE_UPLOADFILE,$insert);
        Yii::app()->tablegear->query($insertSql);
    }
    
    private function delete($id){
        $deleteSql = "update ".$this->tableName ." set is_deleted = 1 where id = ".$id;
        return Yii::app()->tablegear->getTableGearTool()->query($deleteSql);
    }
    
    private function update($id,$data){
        $updateSql = "update ".$this->tableName . $this->getUpdateSect($data) ." where id = ".$id;
        return Yii::app()->tablegear->getTableGearTool()->query($updateSql);
    }
    
}

