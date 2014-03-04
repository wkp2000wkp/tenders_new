<?php
class SelectConstent
{

    const BACK_UP_ID = 1;
    const EXPLODE_STRING= ',';
    const EXPLODE_STRING_BR="<BR />";
    const USER_TYPE_ADMIN = '6';
    const USER_TYPE_SALE = '1';
    const USER_TYPE_MENGER = '3';
    const USER_TYPE_BAN = '0';
    const TABLE_ZHAOBIAO = 'san_zhaobiao';
    const TABLE_TOUBIAO = 'san_toubiao';
    const TABLE_USER = 'san_user';
    const TABLE_BACKUP = 'san_backup';
    const TABLE_UPLOADFILE = 'san_uploadfile';
    const TABLE_QUOTE = 'san_quote';
    const TABLE_QUOTE_BACKUP = 'san_quote_backup';
    const TABLE_QUOTE_UPLOADFILE = 'san_quote_uploadfile';
    const TABLE_QUOTE_KAIBIAO_RESULT = 'san_quote_kaibiao_result';
    const TABLE_QUOTE_KAIBIAO_RECORD = 'san_quote_kaibiao_record';
    const TOUBIAO_BID_STATUS_NONE = 0;
    const TOUBIAO_BID_STATUS_NO = 1;
    const TOUBIAO_BID_STATUS_OK = 2;
    const BID_FEE_FREE = '口%';
    const BID_FEE_QITA = '其他';
    const TOUBIAO_BID_STATUS_YES = 3;
    const EXCLUDE_TRANSFORMER_TYPE = '35kV级及以下';
    const ALL_TPYE_NAME="所有类型";
    const WEI_TOU="未投";
    
    
    public static function getSpecialSort(){
    	return array("transformer_type","respective_regions","respective_provinces");	
    }
    public static function getLanguage ($word) {
        return isset( self::$language[$word] ) ? self::$language[$word] : $word;
    }
    
    public static function getSelectTransformerType(){
        return array('220','110','35kV级及以下','干变','箱变','其它');
    }
    public static function getSelectKaiBiaoTransformerType(){
    	return array('220','110','35','10kV油变','非晶合金','干变','箱变','其它');
    }

    public static function getSelectBidFee(){
        return array('国标',self::BID_FEE_FREE,'未提',self::BID_FEE_QITA);
    }
    public static function getSelectBidFeeSort(){
        return array('FOB','CIF','合同总价',self::BID_FEE_QITA);
    }
    public static function getSelectPlaceFee(){
        return array('有','未提');
    }
    public static function getSelectSkillFee(){
        return array('有','未提');
    }
    
    public static function getSelectRespectiveRegions(){
//         return array('浙江','华东','华中','西北','东北','南方','央企','国网','直属');
        return array('国内','国外');
    }
    
    public static function getSelectCurrency(){
    	return array('美元','欧元','人民币',self::BID_FEE_QITA);
    }
    
    public static function getSelectYesOrNo(){
        return array('','否','是');
    }
    public static function getSelectUserType(){
        return array(1,3,6,0);
    }
    public static function getSelectBid(){
        return array('未定','否','是','取消');
    }
    
    public static function getZhaoBiaoHeaders(){
        return array(
              'id'=>' ',
			  'project_name'=>'项目名称',
			  'bidding_agent'=>'招标代理',
			  'tenderer'=>'招标人', 
			  'specification'=>'规格型号', 
			  'transformer_type'=>'变压器类型', 
			  'number'=>'数量',
			  'slesman'=>'业务员', 
			  'end_time'=>'开标日期', 
			  'tender_manager'=>'标书管理员', 
			  'respective_regions'=>'所属区域', 
			  'respective_provinces'=>'所属国家', 
			  'tender_fee'=>'标书费(多币种)', 
			  'bid_bond'=>'投标保证金(多币种)',
			  'currency'=>'币种',
			  'bid_valid'=>'投标有效期(天)',
			  'bid_fee'=>'代理费', 
			  'bid_fee_sort'=>'代理费种类', 
			  'skill_fee'=>'投标服务费', 
        );
    }
    
    public static function getTouBiaoHeaders(){
        return array(
              'id'=>' ',
              'tb_show_id'=>'编号',
			  'project_name'=>'项目名称',
			  'bidding_agent'=>'招标代理',
			  'tenderer'=>'招标人', 
			  'specification'=>'规格型号', 
			  'transformer_type'=>'变压器类型', 
			  'number'=>'数量',
			  'slesman'=>'业务员', 
			  'end_time'=>'开标日期', 
			  'tender_manager'=>'标书管理员', 
			  'respective_regions'=>'所属区域', 
              'respective_provinces'=>'所属国家', 
			  'tender_fee'=>'标书费(多币种)', 
			  'bid_bond'=>'投标保证金(多币种)',
			  'currency'=>'币种',
			  'bid_valid'=>'投标有效期(天)',
			  'bid'=>'是否中标',
			  'manufacturers'=>'中标厂家',
			  'san_bid_all_price'=>'三变投标总价(万元)',
			  'san_bid_price'=>'三变中标总价(万元)',
			  'feedback'=>'是否反馈',
			  'reimbursement'=>'是否报销',
			  'bid_fee'=>'代理费',
			  'bid_fee_sort'=>'代理费种类',
			  'skill_fee'=>'投标服务费',
			  'remark'=>'备注',
        );
    }
    public static function getQuoteHeaders(){
        return array(
        	  'id'=>' ',
              'tb_show_id'=>'编号',
			  'company_name'=>'单位名称（项目名称）',
			  'specification'=>'规格型号', 
			  'transformer_type'=>'变压器类型', 
        	  'number'=>'数量',
			  'end_time'=>'日期', 
			  'slesman'=>'业务员', 
			  'tender_manager'=>'标书管理员',
			  'remark'=>'备注',
        );
    }
    public static function getBackUpHeaders(){
        return array(
			  'name' => '名称', 
                'max_num' => '最大编号',
                'creat_at' => '创建时间',
                'from_time' => ' 开始时间',
                'to_time' => '结束时间',
        );
    }
    
    public static function getExportSortList(){
    	return array(
              'tb_show_id'=>'编号',
              'respective_regions'=>'所属区域',
              'respective_provinces'=>'所属国家', 
			  'slesman'=>'业务员', 
			  'end_time'=>'开标日期',
			  'transformer_type'=>'变压器类型', 
        );
    }
    public static function getExportZhongBiaoSortList(){
    	return array(
              'tb_show_id'=>'编号',
              'respective_regions'=>'所属区域',
              'respective_provinces'=>'所属国家', 
			  'transformer_type'=>'变压器类型', 
			  'bid_company'=>'中标厂家', 
        );
    }
    public static function getExportAreaList(){
    	return array(
              '0'=>'所有项目',
              '1'=>'仅开标记录', 
        );
    }
    public static function getTHClassHeadersWidth($key){
        $list = array(
            	'id'=>'30',
            	'tb_show_id'=>'30',
            	'number'=>'60',
    			'company_name'=>'250',
    			'project_name'=>'250',
    			'bidding_agent'=>'210',
    			'tenderer'=>'210', 
    			'specification'=>'150', 
    			'transformer_type'=>'60', 
    			'slesman'=>'60', 
    			'end_time'=>'80', 
    			'tender_manager'=>'60', 
    			'respective_regions'=>'60', 
    			'respective_provinces'=>'60', 
    			'tender_fee'=>'60', 
    			'bid_bond'=>'80',
    			'currency'=>'80',
    			'bid_valid'=>'80',
    			'bid'=>'30',
    			'san_bid_all_price'=>'85',
    			'san_bid_price'=>'85',
    			'manufacturers'=>'80',
    			'feedback'=>'30',
    			'reimbursement'=>'30',
        		'bid_fee'=>'50',
        		'bid_fee_sort'=>'50',
    			'place_fee'=>'50',
    			'skill_fee'=>'50',
    			'remark'=>'200',
            );
        return $list[$key];
    }
    
    
    public static function getTdClassHeaders(){
        return  array(
            	'id'=>'td_css_id',
            	'tb_show_id'=>'td_css_tb_show_id',
            	'number'=>'td_css_number',
    			'company_name'=>'td_css_company_name',
    			'project_name'=>'td_css_project_name',
    			'bidding_agent'=>'td_css_bidding_agent',
    			'tenderer'=>'td_css_tenderer', 
    			'specification'=>'td_css_specification', 
    			'transformer_type'=>'td_css_transformer_type', 
    			'slesman'=>'td_css_slesman', 
    			'end_time'=>'td_css_end_time', 
    			'tender_manager'=>'td_css_tender_manager', 
    			'respective_regions'=>'td_css_respective_regions', 
    			'respective_provinces'=>'td_css_respective_provinces', 
    			'tender_fee'=>'td_css_tender_fee', 
    			'bid_bond'=>'td_css_bid_bond',
    			'bid_valid'=>'td_css_bid_valid',
    			'currency'=>'td_css_currency',
    			'bid'=>'td_css_bid',
    			'san_bid_all_price'=>'td_css_san_bid_all_price',
    			'san_bid_price'=>'td_css_san_bid_price',
    			'manufacturers'=>'td_css_manufacturers',
    			'feedback'=>'td_css_feedback',
    			'reimbursement'=>'td_css_reimbursement',
        		'bid_fee'=>'td_css_bid_fee',
        		'bid_fee_sort'=>'td_css_bid_fee_sort',
    			'place_fee'=>'td_css_place_fee',
    			'skill_fee'=>'td_css_skill_fee',
    			'remark'=>'td_css_remark',
            );
    }
    
    
    
    public static function getUploadFileTxt(){
        return iconv('utf-8', 'gbk', '浏览文件');
    }
    
    public static function getDataBaseConfig(){
        return array(
            'host'=>MYSQL_HOST,
            'user'=>MYSQL_USER,
            'password'=>MYSQL_PASSWORD,
            'db'=>MYSQL_DB,
        );
    }
    
}
