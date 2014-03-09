<?php
class PHPExcelTool {
	protected static $cloumnsExecl = array (
			'A',
			'B',
			'C',
			'D',
			'E',
			'F',
			'G',
			'H',
			'I',
			'J',
			'K',
			'L',
			'M',
			'N',
			'O',
			'P',
			'Q',
			'R',
			'S',
			'T',
			'U',
			'V',
			'W',
			'X',
			'Y',
			'Z' 
	);
	protected static $staticX = 23;
	protected static $pageLine = 20;
	private $objPHPExcel = null;
	private $objActSheet = null;
	// header
	protected static $kaiBiaoStaticHeader1 = array (
			
			"F" => "编号",
			"G" => "区域",
			"H" => "国家",
			"I" => "项目简称",
			"J" => "招标人",
			"K" => "业务员",
			"L" => "开标日期" 
	);
	protected static $kaiBiaoStaticHeaderKey1 = array (
			"F" => "tb_show_id",
			"G" => "respective_regions",
			"H" => "respective_provinces",
			"I" => "project_name",
			"J" => "tenderer",
			"K" => "slesman",
			"L" => "end_time" 
	);
	protected static $kaiBiaoStaticHeader2 = array (
			"A" => "三变报价",
			"B" => "平均价",
			"C" => "中标厂家",
			"D" => "中标价格",
			"E" => "基准价",
			"M" => "类型",
			"N" => "规格型号",
			"O" => "数量",
			"P" => "中标厂家\t\n(相差点数)",
			"Q" => "核价单保留费率",
			"R" => "按价格表下浮点数",
			"S" => "基准价\t\n(相差点数)" ,
			"T" => "平均价\t\n(相差点数)" ,
			"U" => "币种" ,
	);
	protected static $kaiBiaoStaticHeaderKey2 = array (
			"M" => "transformer_type",
			"N" => "specification",
			"O" => "number",
			"Q" => "baoliu",
			"R" => "xiafu" ,
			"U" => "currency_ji_zhun_price" ,
	);
	
	protected static $noShowKeyList = array(
			'id',
			'bid_fee_value',
			'bid_fee_sort_other',
			'currency',
			'other_currency',
			'currency_bid_fee',
			'other_currency_bid_fee',
			'currency_bid_bond',
			'other_currency_bid_bond',
			
			);
	
	public function createExeclFileHeader() {
		$this->objPHPExcel = new PHPExcel ();
		$this->objPHPExcel->getProperties ()->setCreator ( "Maarten Balliauw" )->setLastModifiedBy ( "Maarten Balliauw" )->setTitle ( "Office 2007 XLSX Test Document" )->setSubject ( "Office 2007 XLSX Test Document" )->setDescription ( "Test document for Office 2007 XLSX, generated using PHP classes." )->setKeywords ( "office 2007 openxml php" )->setCategory ( "Test result file" );
		$this->objPHPExcel->setActiveSheetIndex ( 0 );
		$this->objActSheet = $this->objPHPExcel->getActiveSheet ();
	}
	
	public function exportPHPExcelTool($data = array(), $headers = array(), $totals = array()) {
		$this->createExeclFileHeader ();
		$rowNumber = 1;
		
		$this->objActSheet->getColumnDimension ( 'A' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'B' )->setWidth ( 31 );
		$this->objActSheet->getColumnDimension ( 'C' )->setWidth ( 26 );
		$this->objActSheet->getColumnDimension ( 'D' )->setWidth ( 26 );
		$this->objActSheet->getColumnDimension ( 'E' )->setWidth ( 21 );
		$this->objActSheet->getColumnDimension ( 'F' )->setWidth ( 7 );
		$this->objActSheet->getColumnDimension ( 'G' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'H' )->setWidth ( 7 );
		$this->objActSheet->getColumnDimension ( 'I' )->setWidth ( 10 );
		$this->objActSheet->getColumnDimension ( 'J' )->setWidth ( 7 );
		$this->objActSheet->getColumnDimension ( 'K' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'L' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'M' )->setWidth ( 7 );
		$this->objActSheet->getColumnDimension ( 'N' )->setWidth ( 8 );
		$this->objActSheet->getColumnDimension ( 'O' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'P' )->setWidth ( 10 );
		$this->objActSheet->getColumnDimension ( 'Q' )->setWidth ( 10 );
		$this->objActSheet->getColumnDimension ( 'R' )->setWidth ( 10 );
		$this->objActSheet->getColumnDimension ( 'S' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'T' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'U' )->setWidth ( 21 );
		if ($headers) {
			$key = 0;
			foreach ( $headers as $col => $value ) {
				if ($col == 'id') {
					continue;
				}
				$XY = self::$cloumnsExecl [$key] . $rowNumber;
				self::setStyle ( $this->objActSheet, $XY );
				$this->objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $XY, $value );
				$key ++;
			}
		}
		
		if ($data) {
			foreach ( $data as $row ) {
				$rowNumber ++;
				$key = 0;
				foreach ( $row as $showKey => $showValue ) {
					if(in_array($showKey, self::$noShowKeyList)){
						continue;
					}
					
					if ($showKey == 'bid_fee' && ($showValue == SelectConstent::BID_FEE_FREE)) {
						$showValue = $row ['bid_fee_value'] . '%';
					} elseif ($showKey == 'bid_fee' && $showValue == SelectConstent::BID_FEE_QITA) {
						$showValue = $row ['bid_fee_value'];
					}
					
					if ($showKey == 'bid_fee_sort' && ($showValue == SelectConstent::BID_FEE_QITA)) {
						$showValue = $row ['bid_fee_sort_other'] ;
					} elseif ($showKey == 'bid_fee_sort' ) {
						$showValue = $row ['bid_fee_sort'];
					}
					//currency_bid_fee+bid_fee
					if ($showKey == 'bid_fee' && ($row ['currency_bid_fee'] == SelectConstent::BID_FEE_QITA)) {
						$showValue .= $row ['other_currency_bid_fee'] ;
					} elseif($showKey == 'currency_bid_fee'){
						$showValue .= $row ['currency_bid_fee'];
					}
					//currency+tender_fee
					if ($showKey == 'tender_fee' && ($row ['currency'] == SelectConstent::BID_FEE_QITA)) {
						$showValue = $row ['tender_fee'].$row ['other_currency'] ;
					} elseif($showKey == 'tender_fee'){
						$showValue = $row ['tender_fee'].$row ['currency'];
					}
					//currency_bid_bond+bid_bond
					if ($showKey == 'bid_bond' && ($row ['currency_bid_bond'] == SelectConstent::BID_FEE_QITA)) {
						$showValue = $row ['bid_bond'].$row ['other_currency_bid_bond'] ;
					} elseif($showKey == 'bid_bond'){
						$showValue = $row ['bid_bond'].$row ['currency_bid_bond'];
					}
					
					
					$XY = self::$cloumnsExecl [$key] . $rowNumber;
					self::setStyle ( $this->objActSheet, $XY );
					$this->objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $XY, $showValue );
					$key ++;
				}
			}
		}
		
		if ($totals) {
			$rowNumber += 2;
			$this->objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'A' . $rowNumber, '投标：' . $totals ['count_toubiao_bod'] );
			$this->objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'B' . $rowNumber, '总投标价：' . $totals ['total_toubiao_bod'] );
			$this->objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'C' . $rowNumber, '中标：' . $totals ['count_bid_bod'] );
			$this->objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'D' . $rowNumber, '总中标价：' . $totals ['total_bid_bod'] );
			$this->objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'E' . $rowNumber, '中标率：' . $totals ['bid_percent'] );
		}
		
		$fileName = time () . '.xls';
		$this->createExeclFile ( $fileName );
		exit ();
	}
	
	public function exportPHPExcelToolKaiBiao($data = array(), $fileName = '') {
		$this->createExeclFileHeader ();
		$y = 2;
		$rY = 2;
		$maxX = self::$staticX;
		if ($data ['t']) {
			foreach ( $data ['t'] as $t ) {
				$dataCountNum = count ( $data ['k'] [$t ['id']] );
				$dataCountNumLine = $dataCountNum ? $dataCountNum * 2 : 2;
				$tY = $y + $dataCountNumLine;
				foreach ( self::$kaiBiaoStaticHeaderKey1 as $staticKey => $staticHeader ) {
					self::setStyle ( $this->objActSheet, $staticKey . ($y + 1) );
					$this->objActSheet->setCellValue ( $staticKey . ($y + 1), $t [$staticHeader] );
				}
				if ($data ['k'] [$t ['id']]) {
					$kY = $y;
					foreach ( $data ['k'] [$t ['id']] as $k ) {
						$lineNumber = ceil ( (count ( $data ['r'] [$k ['tb_id']] [$k ['id']] ) - 1) / self::$pageLine );
						$lineNumber = $lineNumber ? $lineNumber : 1;
						$tY = $tY + ($lineNumber - 1) * 2;
						foreach ( self::$kaiBiaoStaticHeaderKey2 as $staticKey2 => $staticHeader2 ) {
							$this->objActSheet->mergeCells ( $staticKey2 . ($kY + 1) . ':' . $staticKey2 . ($kY + $lineNumber * 2) );
							self::setStyle ( $this->objActSheet, $staticKey2 . ($kY + 1) );
							$this->objActSheet->setCellValue ( $staticKey2 . ($kY + 1), $k [$staticHeader2] );
						}
						if($data ['z'] [$k ['tb_id']] [$k ['id']] ['num_bid_price'])
						$bid_price = number_format ( round ( ($data ['z'] [$k ['tb_id']] [$k ['id']] ['all_bid_price'] / $data ['z'] [$k ['tb_id']] [$k ['id']] ['num_bid_price']), 1 ), 1, ".", "" );
						// 新增四个字段-平均价
						self::setStyle ( $this->objActSheet, "B" . ($rY + 1) );
						$this->objActSheet->setCellValue ( "B" . ($rY + 1), $bid_price );
						if ($data ['z'] [$k ['tb_id']] [$k ['id']] ['my_bid_price'] && $data ['z'] [$k ['tb_id']] [$k ['id']] ['num_bid_price']) {
							$bid_price .= "(" . (number_format ( round ( (($data ['z'] [$k ['tb_id']] [$k ['id']] ['all_bid_price'] / $data ['z'] [$k ['tb_id']] [$k ['id']] ['num_bid_price']) / $data ['z'] [$k ['tb_id']] [$k ['id']] ['my_bid_price'] - 1) * 100, 1 ), 1, ".", "" )) . ")";
						}
						// 新增四个字段-基准价
						self::setStyle ( $this->objActSheet, "E" . ($rY + 1) );
						if(!$k['ji_zhun_price']) $k['ji_zhun_price']='';
						$this->objActSheet->setCellValue ( "E" . ($rY + 1), $k['ji_zhun_price'] );
						if ($data ['z'] [$k ['tb_id']] [$k ['id']] ['my_bid_price'] && $k['ji_zhun_price']) {
							$k['ji_zhun_price'] .= "(" . (number_format ( round ( ($k['ji_zhun_price'] / $data ['z'] [$k ['tb_id']] [$k ['id']] ['my_bid_price'] - 1) * 100, 1 ), 1, ".", "" )) . ")";
						}
						
						// 新增四个字段-合并单元格-新增基准价
						$this->objActSheet->mergeCells ( "A" . ($kY + 1) . ':' . "A" . ($kY + $lineNumber * 2) );
						$this->objActSheet->mergeCells ( "B" . ($kY + 1) . ':' . "B" . ($kY + $lineNumber * 2) );
						$this->objActSheet->mergeCells ( "C" . ($kY + 1) . ':' . "C" . ($kY + $lineNumber * 2) );
						$this->objActSheet->mergeCells ( "D" . ($kY + 1) . ':' . "D" . ($kY + $lineNumber * 2) );
						$this->objActSheet->mergeCells ( "E" . ($kY + 1) . ':' . "E" . ($kY + $lineNumber * 2) );
						// 中标厂家 P
						$this->objActSheet->mergeCells ( "P" . ($kY + 1) . ':' . "P" . ($kY + $lineNumber * 2) );
						// 平均价 T
						$staticX_PJ = "T";
						$this->objActSheet->mergeCells ( $staticX_PJ . ($kY + 1) . ':' . $staticX_PJ . ($kY + $lineNumber * 2) );
						self::setStyle ( $this->objActSheet, $staticX_PJ . ($kY + 1) );
						$this->objActSheet->setCellValue ( $staticX_PJ . ($kY + 1), $bid_price );
						// 基准价 S
						$staticX_PJ = "S";
						$this->objActSheet->mergeCells ( $staticX_PJ . ($kY + 1) . ':' . $staticX_PJ . ($kY + $lineNumber * 2) );
						self::setStyle ( $this->objActSheet, $staticX_PJ . ($kY + 1) );
						$this->objActSheet->setCellValue ( $staticX_PJ . ($kY + 1), $k['ji_zhun_price'] );
						// 开标币种 U
						$staticX_PJ = "U";
						$this->objActSheet->mergeCells ( $staticX_PJ . ($kY + 1) . ':' . $staticX_PJ . ($kY + $lineNumber * 2) );
						self::setStyle ( $this->objActSheet, $staticX_PJ . ($kY + 1) );
						$currency_ji_zhun_price = ($k['currency_ji_zhun_price'] == SelectConstent::BID_FEE_QITA) ? $k['other_currency_ji_zhun_price'] : $k['currency_ji_zhun_price'];
						$this->objActSheet->setCellValue ( $staticX_PJ . ($kY + 1), $currency_ji_zhun_price );
						
						$numX = self::$staticX; // get cplums to N
						if ($data ['r'] [$k ['tb_id']] [$k ['id']]) {
							$rY = $rtY = $kY;
							foreach ( $data ['r'] [$k ['tb_id']] [$k ['id']] as $r ) {
								if ($numX == self::$staticX + self::$pageLine) {
									$numX = self::$staticX;
									$rtY = $rtY + 2;
									$maxX = self::$staticX + self::$pageLine;
								}
								
								$bid_price = '';
								// write bid info
								if ($r ['bid'] == BID_STR) {
									if ($data ['z'] [$r ['tb_id']] [$r ['kb_r_id']] ['my_bid_price']) {
										$bid_price = "\t\n(" . (number_format ( round ( ($r ['bid_price'] / $data ['z'] [$r ['tb_id']] [$r ['kb_r_id']] ['my_bid_price'] - 1) * 100, 1 ), 1, ".", "" )) . ")";
									}
									// 中标厂家 P
									self::setStyle ( $this->objActSheet, "P" . ($rY + 1) );
									$this->objActSheet->setCellValue ( "P" . ($rY + 1), $r ['bid_company'] . $bid_price );
									// 新增四个字段-中标厂家、中标价格
									self::setStyle ( $this->objActSheet, "C" . ($rY + 1) );
									$this->objActSheet->setCellValue ( "C" . ($rY + 1), $r ['bid_company'] );
									self::setStyle ( $this->objActSheet, "D" . ($rY + 1) );
									$this->objActSheet->setCellValue ( "D" . ($rY + 1), $r ['bid_price'] );
								}
								
								$bid_price = '';
								// write my company
								if ($r ['bid_company'] == MY_COMPANY) {
									$bid_price = $r ['bid_price'] ? $r ['bid_price'] : SelectConstent::WEI_TOU;
									// 新增四个字段-三变价格
									$this->objActSheet->setCellValue ( "A" . ($rY + 1), $bid_price );
									if ($r ['bid_price'])
										$bid_price .= '(' . ($data ['z'] [$r ['tb_id']] [$r ['kb_r_id']] ['pai_bid_number']) . '/' . ($data ['z'] [$r ['tb_id']] [$r ['kb_r_id']] ['num_bid_price']) . ')';
									$rX = self::getNumber26 ( self::$staticX - 1 );
									self::setStyle ( $this->objActSheet, $rX . ($rY + 1) );
									$this->objActSheet->setCellValue ( $rX . ($rY + 1), $r ['bid_company'] );
									self::setStyle ( $this->objActSheet, $rX . ($rY + 2) );
									$this->objActSheet->setCellValue ( $rX . ($rY + 2), $bid_price );
								} else {
									if ($data ['z'] [$r ['tb_id']] [$r ['kb_r_id']] ['my_bid_price']) {
										$bid_price = $r ['bid_price'] . "(" . (number_format ( round ( ($r ['bid_price'] / $data ['z'] [$r ['tb_id']] [$r ['kb_r_id']] ['my_bid_price'] - 1) * 100, 1 ), 1, ".", "" )) . ")";
									} else {
										$bid_price = $r ['bid_price'];
									}
									$rX = self::getNumber26 ( $numX );
									self::setStyle ( $this->objActSheet, $rX . ($rtY + 1) );
									$this->objActSheet->setCellValue ( $rX . ($rtY + 1), $r ['bid_company'] );
									self::setStyle ( $this->objActSheet, $rX . ($rtY + 2) );
									$this->objActSheet->setCellValue ( $rX . ($rtY + 2), $bid_price );
								}
								
								if ($r ['bid_company'] != MY_COMPANY) {
									$numX ++;
								}
							}
							$maxX = ($numX > $maxX) ? $numX : $maxX;
							$rY = $rY + $lineNumber * 2;
						}
						
						$kY = $kY + $lineNumber * 2;
					}
				}
				foreach ( self::$kaiBiaoStaticHeaderKey1 as $staticKey => $staticHeader ) {
					$this->objActSheet->mergeCells ( $staticKey . ($y + 1) . ':' . $staticKey . $tY );
				}
				$y = $tY;
			}
		}
		
		// title
		$this->createKaiBiaoHeader ( $maxX );
		if (! $fileName)
			$fileName = time ();
		$fileName = $fileName . '.xls';
		$this->createExeclFile ( $fileName );
		exit ();
	}
	
	public function exportPHPExcelToolKaiBiaoOrderByType($data = array(), $fileName = '') {
		$this->createExeclFileHeader ();
		$maxX = self::$staticX;
		if ($data ['t']) {
			$kY = $rY = 2;
			foreach ( $data ['k'] as $k ) {
				// set toubiao
				foreach ( self::$kaiBiaoStaticHeaderKey1 as $staticKey => $staticHeader ) {
					self::setStyle ( $this->objActSheet, $staticKey . ($kY + 1) );
					$this->objActSheet->setCellValue ( $staticKey . ($kY + 1), $data ['t'] [$k ['tb_id']] [$staticHeader] );
				}
				// unset tb_id
				$touBiaoList [] = $k ['tb_id'];
				
				$lineNumber = ceil ( (count ( $data ['r'] [$k ['tb_id']] [$k ['id']] ) - 1) / self::$pageLine );
				$lineNumber = $lineNumber ? $lineNumber : 1;
				$tY = $tY + ($lineNumber - 1) * 2;
				foreach ( self::$kaiBiaoStaticHeaderKey2 as $staticKey2 => $staticHeader2 ) {
					$this->objActSheet->mergeCells ( $staticKey2 . ($kY + 1) . ':' . $staticKey2 . ($kY + $lineNumber * 2) );
					self::setStyle ( $this->objActSheet, $staticKey2 . ($kY + 1) );
					$this->objActSheet->setCellValue ( $staticKey2 . ($kY + 1), $k [$staticHeader2] );
				}
				if($data ['z'] [$k ['tb_id']] [$k ['id']] ['num_bid_price'])
					$bid_price = number_format ( round ( ($data ['z'] [$k ['tb_id']] [$k ['id']] ['all_bid_price'] / $data ['z'] [$k ['tb_id']] [$k ['id']] ['num_bid_price']), 1 ), 1, ".", "" );
				// 新增四个字段-平均价
				self::setStyle ( $this->objActSheet, "B" . ($rY + 1) );
				$this->objActSheet->setCellValue ( "B" . ($rY + 1), $bid_price );
				if ($data ['z'] [$k ['tb_id']] [$k ['id']] ['my_bid_price'] && $data ['z'] [$k ['tb_id']] [$k ['id']] ['num_bid_price']) {
					$bid_price .= "(" . (number_format ( round ( (($data ['z'] [$k ['tb_id']] [$k ['id']] ['all_bid_price'] / $data ['z'] [$k ['tb_id']] [$k ['id']] ['num_bid_price']) / $data ['z'] [$k ['tb_id']] [$k ['id']] ['my_bid_price'] - 1) * 100, 1 ), 1, ".", "" )) . ")";
				}
				// 新增四个字段-基准价
				self::setStyle ( $this->objActSheet, "E" . ($rY + 1) );
				if(!$k['ji_zhun_price']) $k['ji_zhun_price']='';
				$this->objActSheet->setCellValue ( "E" . ($rY + 1), $k['ji_zhun_price'] );
				if ($data ['z'] [$k ['tb_id']] [$k ['id']] ['my_bid_price'] && $k['ji_zhun_price']) {
					$k['ji_zhun_price'] .= "(" . (number_format ( round ( ($k['ji_zhun_price'] / $data ['z'] [$k ['tb_id']] [$k ['id']] ['my_bid_price'] - 1) * 100, 1 ), 1, ".", "" )) . ")";
				}
				// 新增四个字段-合并单元格
				$this->objActSheet->mergeCells ( "A" . ($kY + 1) . ':' . "A" . ($kY + $lineNumber * 2) );
				$this->objActSheet->mergeCells ( "B" . ($kY + 1) . ':' . "B" . ($kY + $lineNumber * 2) );
				$this->objActSheet->mergeCells ( "C" . ($kY + 1) . ':' . "C" . ($kY + $lineNumber * 2) );
				$this->objActSheet->mergeCells ( "D" . ($kY + 1) . ':' . "D" . ($kY + $lineNumber * 2) );
				$this->objActSheet->mergeCells ( "E" . ($kY + 1) . ':' . "E" . ($kY + $lineNumber * 2) );
				// 中标厂家 P
				$this->objActSheet->mergeCells ( "P" . ($kY + 1) . ':' . "P" . ($kY + $lineNumber * 2) );
				// 平均价 T
				$staticX_PJ = "T";
				$this->objActSheet->mergeCells ( $staticX_PJ . ($kY + 1) . ':' . $staticX_PJ . ($kY + $lineNumber * 2) );
				self::setStyle ( $this->objActSheet, $staticX_PJ . ($kY + 1) );
				$this->objActSheet->setCellValue ( $staticX_PJ . ($kY + 1), $bid_price );
				// 基准价 S
				$staticX_PJ = "S";
				$this->objActSheet->mergeCells ( $staticX_PJ . ($kY + 1) . ':' . $staticX_PJ . ($kY + $lineNumber * 2) );
				self::setStyle ( $this->objActSheet, $staticX_PJ . ($kY + 1) );
				$this->objActSheet->setCellValue ( $staticX_PJ . ($kY + 1), $k['ji_zhun_price'] );
				// 开标币种 U
				$staticX_PJ = "U";
				$this->objActSheet->mergeCells ( $staticX_PJ . ($kY + 1) . ':' . $staticX_PJ . ($kY + $lineNumber * 2) );
				self::setStyle ( $this->objActSheet, $staticX_PJ . ($kY + 1) );
				$currency_ji_zhun_price = ($k['currency_ji_zhun_price'] == SelectConstent::BID_FEE_QITA) ? $k['other_currency_ji_zhun_price'] : $k['currency_ji_zhun_price'];
				$this->objActSheet->setCellValue ( $staticX_PJ . ($kY + 1), $currency_ji_zhun_price );
				
				$numX = self::$staticX;
				// get cplums to N
				if ($data ['r'] [$k ['tb_id']] [$k ['id']]) {
					$rY = $rtY = $kY;
					foreach ( $data ['r'] [$k ['tb_id']] [$k ['id']] as $r ) {
						if ($numX == self::$staticX + self::$pageLine) {
							$numX = self::$staticX;
							$rtY = $rtY + 2;
							$maxX = self::$staticX + self::$pageLine;
						}
						
						$bid_price = '';
						// write bid info
						if ($r ['bid'] == BID_STR) {
							if ($data ['z'] [$r ['tb_id']] [$r ['kb_r_id']] ['my_bid_price']) {
								$bid_price = "\t\n(" . (number_format ( round ( ($r ['bid_price'] / $data ['z'] [$r ['tb_id']] [$r ['kb_r_id']] ['my_bid_price'] - 1) * 100, 1 ), 1, ".", "" )) . ")";
							}
							// 中标厂家 P
							self::setStyle ( $this->objActSheet, "P" . ($rY + 1) );
							$this->objActSheet->setCellValue ( "P" . ($rY + 1), $r ['bid_company'] . $bid_price );
							// 新增四个字段-中标厂家、中标价格
							self::setStyle ( $this->objActSheet, "C" . ($rY + 1) );
							$this->objActSheet->setCellValue ( "C" . ($rY + 1), $r ['bid_company'] );
							self::setStyle ( $this->objActSheet, "D" . ($rY + 1) );
							$this->objActSheet->setCellValue ( "D" . ($rY + 1), $r ['bid_price'] );
						}
						
						$bid_price = '';
						// write my company
						if ($r ['bid_company'] == MY_COMPANY) {
							$bid_price = $r ['bid_price'] ? $r ['bid_price'] : SelectConstent::WEI_TOU;
							// 新增四个字段-三变价格
							$this->objActSheet->setCellValue ( "A" . ($rY + 1), $bid_price );
							if ($r ['bid_price'])
								$bid_price .= '(' . ($data ['z'] [$r ['tb_id']] [$r ['kb_r_id']] ['pai_bid_number']) . '/' . ($data ['z'] [$r ['tb_id']] [$r ['kb_r_id']] ['num_bid_price']) . ')';
							$rX = self::getNumber26 ( self::$staticX - 1 );
							self::setStyle ( $this->objActSheet, $rX . ($rY + 1) );
							$this->objActSheet->setCellValue ( $rX . ($rY + 1), $r ['bid_company'] );
							self::setStyle ( $this->objActSheet, $rX . ($rY + 2) );
							$this->objActSheet->setCellValue ( $rX . ($rY + 2), $bid_price );
						} else {
							if ($data ['z'] [$r ['tb_id']] [$r ['kb_r_id']] ['my_bid_price']) {
								$bid_price = $r ['bid_price'] . "(" . (number_format ( round ( ($r ['bid_price'] / $data ['z'] [$r ['tb_id']] [$r ['kb_r_id']] ['my_bid_price'] - 1) * 100, 1 ), 1, ".", "" )) . ")";
							} else {
								$bid_price = $r ['bid_price'];
							}
							$rX = self::getNumber26 ( $numX );
							self::setStyle ( $this->objActSheet, $rX . ($rtY + 1) );
							$this->objActSheet->setCellValue ( $rX . ($rtY + 1), $r ['bid_company'] );
							self::setStyle ( $this->objActSheet, $rX . ($rtY + 2) );
							$this->objActSheet->setCellValue ( $rX . ($rtY + 2), $bid_price );
						}
						
						if ($r ['bid_company'] != MY_COMPANY) {
							$numX ++;
						}
					}
					$maxX = ($numX > $maxX) ? $numX : $maxX;
					$rY = $rY + $lineNumber * 2;
				}
				
				// merge toubiao
				$tY = $kY;
				if ($afterResult ['tb_id'] == $k ['tb_id'] && $afterResult ['transformer_type'] == $k ['transformer_type']) {
					$tY = $afterResult ['ty'];
				} else {
					$afterResult = $k;
					$afterResult ['ty'] = $kY;
				}
				foreach ( self::$kaiBiaoStaticHeaderKey1 as $staticKey => $staticHeader ) {
					$this->objActSheet->mergeCells ( $staticKey . ($tY + 1) . ':' . $staticKey . ($kY + $lineNumber * 2) );
				}
				// add y
				$kY = $kY + $lineNumber * 2;
			
			}
			
			$tY = $kY;
			foreach ( $data ['t'] as $t ) {
				if (in_array ( $t ['id'], $touBiaoList ))
					continue;
				foreach ( self::$kaiBiaoStaticHeaderKey1 as $staticKey => $staticHeader ) {
					self::setStyle ( $this->objActSheet, $staticKey . ($tY + 1) );
					$this->objActSheet->setCellValue ( $staticKey . ($tY + 1), $t [$staticHeader] );
					$this->objActSheet->mergeCells ( $staticKey . ($tY + 1) . ':' . $staticKey . ($tY + 2) );
				}
				$tY = $tY + 2;
			}
		
		}
		// title
		$this->createKaiBiaoHeader ( $maxX );
		if (! $fileName)
			$fileName = time ();
		$fileName = $fileName . '.xls';
		$this->createExeclFile ( $fileName );
		exit ();
	}
	
	public function exportPHPExcelToolTongJi($data = array(), $fileName = '') {
		$this->createExeclFileHeader ();
		
		$this->objActSheet->getColumnDimension ( 'A' )->setWidth ( 20 );
		$this->objActSheet->getColumnDimension ( 'B' )->setWidth ( 20 );
		$this->objActSheet->getColumnDimension ( 'C' )->setWidth ( 20 );
		$this->objActSheet->getColumnDimension ( 'D' )->setWidth ( 20 );
		
		self::setStyle ( $this->objActSheet, 'A' );
		self::setStyle ( $this->objActSheet, 'B' );
		self::setStyle ( $this->objActSheet, 'C' );
		self::setStyle ( $this->objActSheet, 'D' );
		$Y = 1;
		
		if ($data) {
			foreach ( $data as $companyName => $list ) {
				$this->objActSheet->setCellValue ( 'A' . $Y, '产品类' );
				$this->objActSheet->setCellValue ( 'B' . $Y, '报价总计（万元）' );
				$this->objActSheet->setCellValue ( 'D' . $Y, '相差点数' );
				$this->objActSheet->setCellValue ( 'B' . ($Y + 1), '我公司' );
				$this->objActSheet->setCellValue ( 'C' . ($Y + 1), $companyName );
				$this->objActSheet->mergeCells ( 'A' . $Y . ':A' . ($Y + 1) );
				$this->objActSheet->mergeCells ( 'B' . $Y . ':C' . $Y );
				$this->objActSheet->mergeCells ( 'D' . $Y . ':D' . ($Y + 1) );
				
				$all_my_price = $all_company_price = $all_xiangcha = 0;
				$Y = $Y + 2;
				foreach ( SelectConstent::getSelectTransformerType () as $type ) {
					$all_my_price += $list [$type] ['my_price'];
					$all_company_price += $list [$type] ['company_price'];
					$this->objActSheet->setCellValue ( 'A' . $Y, $type );
					$this->objActSheet->setCellValue ( 'B' . $Y, $list [$type] ['my_price'] );
					$this->objActSheet->setCellValue ( 'C' . $Y, $list [$type] ['company_price'] );
					$this->objActSheet->setCellValue ( 'D' . $Y, $list [$type] ['xiangcha'] );
					$Y ++;
				}
				//过滤无报价情况$all_my_price=0
				$all_xiangcha = 0;
				if($all_my_price)
					$all_xiangcha = round ( (($all_company_price / $all_my_price) - 1) * 100, 1 ) . "%";
				$this->objActSheet->setCellValue ( 'A' . $Y, '总计' );
				$this->objActSheet->setCellValue ( 'B' . $Y, $all_my_price );
				$this->objActSheet->setCellValue ( 'C' . $Y, $all_company_price );
				$this->objActSheet->setCellValue ( 'D' . $Y, $all_xiangcha );
				$Y = $Y + 2;
			}
		
		}
		
		if (! $fileName)
			$fileName = time ();
		$fileName = $fileName . '.xls';
		$this->createExeclFile ( $fileName );
		exit ();
	}
	
	public function exportPHPExcelToolTongJiKaiBiaoRecord1($data = array(), $fileName = '', $line = '') {
		$this->createExeclFileHeader ();
		
		$this->objActSheet->getColumnDimension ( 'A' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'B' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'C' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'D' )->setWidth ( 31 );
		$this->objActSheet->getColumnDimension ( 'E' )->setWidth ( 26 );
		$this->objActSheet->getColumnDimension ( 'F' )->setWidth ( 7 );
		$this->objActSheet->getColumnDimension ( 'G' )->setWidth ( 10 );
		$this->objActSheet->getColumnDimension ( 'H' )->setWidth ( 7 );
		$this->objActSheet->getColumnDimension ( 'I' )->setWidth ( 21 );
		$this->objActSheet->getColumnDimension ( 'J' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'K' )->setWidth ( 10 );
		$this->objActSheet->getColumnDimension ( 'L' )->setWidth ( 10 );
		$this->objActSheet->getColumnDimension ( 'M' )->setWidth ( 15 );
		$this->objActSheet->getColumnDimension ( 'N' )->setWidth ( 10 );
		$this->objActSheet->getColumnDimension ( 'O' )->setWidth ( 12 );
		$this->objActSheet->getColumnDimension ( 'P' )->setWidth ( 12 );
		$this->objActSheet->getColumnDimension ( 'Q' )->setWidth ( 12 );
		$Y = 1;
		
		if ($data) {
			foreach ( $data as $companyName => $list ) {
				$this->objActSheet->setCellValue ( 'A' . $Y, '编号' );
				$this->objActSheet->setCellValue ( 'B' . $Y, '区域' );
				$this->objActSheet->setCellValue ( 'C' . $Y, '国家' );
				$this->objActSheet->setCellValue ( 'D' . $Y, '项目简称' );
				$this->objActSheet->setCellValue ( 'E' . $Y, '招标人' );
				$this->objActSheet->setCellValue ( 'F' . $Y, '业务员' );
				$this->objActSheet->setCellValue ( 'G' . $Y, '开标日期' );
				$this->objActSheet->setCellValue ( 'H' . $Y, '类型' );
				$this->objActSheet->setCellValue ( 'I' . $Y, '规格类型' );
				$this->objActSheet->setCellValue ( 'J' . $Y, '数量' );
				$this->objActSheet->setCellValue ( 'K' . $Y, '我公司报价' );
				$this->objActSheet->setCellValue ( 'L' . $Y, $companyName . '(相差点数)' );
				$this->objActSheet->setCellValue ( 'M' . $Y, '中标厂家(价格及相差点数)' );
				$this->objActSheet->setCellValue ( 'N' . $Y, '平均价(相差点数)' );
				$this->objActSheet->setCellValue ( 'O' . $Y, $companyName );
				$this->objActSheet->setCellValue ( 'P' . $Y, '中标价' );
				$this->objActSheet->setCellValue ( 'Q' . $Y, '平均价' );
				self::setBackColor ( $this->objActSheet, "A" . $Y . ":Q" . $Y );
				$Y = $Y + 1;
				$merge_s = $Y;
				$pevListString = '';
				foreach ( $list as $lt ) :
					if ($pevListString && $Y - $merge_s > 0) {
						$listString = ($line) ? $lt ['tb_id'] . $lt ['transformer_type'] : $lt ['tb_id'];
						if ($pevListString != $listString) {
							$this->objActSheet->mergeCells ( 'A' . ($merge_s) . ':' . 'A' . ($Y - 1) );
							$this->objActSheet->mergeCells ( 'B' . ($merge_s) . ':' . 'B' . ($Y - 1) );
							$this->objActSheet->mergeCells ( 'C' . ($merge_s) . ':' . 'C' . ($Y - 1) );
							$this->objActSheet->mergeCells ( 'D' . ($merge_s) . ':' . 'D' . ($Y - 1) );
							$this->objActSheet->mergeCells ( 'E' . ($merge_s) . ':' . 'E' . ($Y - 1) );
							$this->objActSheet->mergeCells ( 'F' . ($merge_s) . ':' . 'F' . ($Y - 1) );
							$this->objActSheet->mergeCells ( 'G' . ($merge_s) . ':' . 'G' . ($Y - 1) );
							$merge_s = $Y;
							$pevListString = ($line) ? $lt ['tb_id'] . $lt ['transformer_type'] : $lt ['tb_id'];
						}
					} else {
						$pevListString = ($line) ? $lt ['tb_id'] . $lt ['transformer_type'] : $lt ['tb_id'];
					}
					$this->objActSheet->setCellValue ( 'A' . $Y, $lt ['tb_show_id'] );
					$this->objActSheet->setCellValue ( 'B' . $Y, $lt ['respective_regions'] );
					$this->objActSheet->setCellValue ( 'C' . $Y, $lt ['respective_provinces'] );
					$this->objActSheet->setCellValue ( 'D' . $Y, $lt ['project_name'] );
					$this->objActSheet->setCellValue ( 'E' . $Y, $lt ['tenderer'] );
					$this->objActSheet->setCellValue ( 'F' . $Y, $lt ['slesman'] );
					$this->objActSheet->setCellValue ( 'G' . $Y, $lt ['end_time'] );
					$this->objActSheet->setCellValue ( 'H' . $Y, $lt ['transformer_type'] );
					$this->objActSheet->setCellValue ( 'I' . $Y, $lt ['specification'] );
					$this->objActSheet->setCellValue ( 'J' . $Y, $lt ['number'] );
					$this->objActSheet->setCellValue ( 'K' . $Y, $lt ['my_company_price_show'] );
					$this->objActSheet->setCellValue ( 'L' . $Y, $lt ['bid_company'] . $lt ['bid_price'] . $lt ['xiangcha_search_price'] );
					if ($lt ['show_bid_price'])
						$this->objActSheet->setCellValue ( 'M' . $Y, $lt ['show_bid_company'] . $lt ['show_bid_price'] . $lt ['xiangcha_bid_price'] );
					$this->objActSheet->setCellValue ( 'N' . $Y, $lt ['show_agv_price'] . $lt ['xiangcha_agv_price'] );
					$this->objActSheet->setCellValue ( 'O' . $Y, $lt ['bid_price'] );
					if ($lt ['show_bid_price'])
						$this->objActSheet->setCellValue ( 'P' . $Y, $lt ['show_bid_price'] );
					$this->objActSheet->setCellValue ( 'Q' . $Y, $lt ['show_agv_price'] );
					$Y = $Y + 1;
				endforeach
				;
			}
			$this->objActSheet->mergeCells ( 'A' . ($merge_s) . ':' . 'A' . ($Y - 1) );
		}
		$this->objActSheet->getStyle ( "P2:P" . $Y )->getNumberFormat ()->setFormatCode ( '0.0' );
		$this->objActSheet->getStyle ( "Q2:Q" . $Y )->getNumberFormat ()->setFormatCode ( '0.0' );
		self::setStyleAll ( $this->objActSheet, "A1:Q" . $Y );
		if (! $fileName)
			$fileName = time ();
		$fileName = $fileName . '.xls';
		$this->createExeclFile ( $fileName );
		exit ();
	}
	
	public function exportPHPExcelToolTongJiKaiBiaoRecord2($data = array(), $fileName = '') {
		$this->createExeclFileHeader ();
		
		$this->objActSheet->getColumnDimension ( 'A' )->setWidth ( 20 );
		$this->objActSheet->getColumnDimension ( 'B' )->setWidth ( 20 );
		$this->objActSheet->getColumnDimension ( 'C' )->setWidth ( 20 );
		$this->objActSheet->getColumnDimension ( 'D' )->setWidth ( 20 );
		
		self::setStyle ( $this->objActSheet, 'A' );
		self::setStyle ( $this->objActSheet, 'B' );
		self::setStyle ( $this->objActSheet, 'C' );
		self::setStyle ( $this->objActSheet, 'D' );
		$Y = 1;
		if ($data) {
			$this->objActSheet->setCellValue ( 'A' . $Y, '编号' );
			$this->objActSheet->setCellValue ( 'B' . $Y, '区域' );
			$this->objActSheet->setCellValue ( 'C' . $Y, '国家' );
			$this->objActSheet->setCellValue ( 'D' . $Y, '项目简称' );
			$this->objActSheet->setCellValue ( 'E' . $Y, '招标人' );
			$this->objActSheet->setCellValue ( 'F' . $Y, '业务员' );
			$this->objActSheet->setCellValue ( 'G' . $Y, '开标日期' );
			$this->objActSheet->setCellValue ( 'H' . $Y, '类型' );
			$this->objActSheet->setCellValue ( 'I' . $Y, '规格类型' );
			$this->objActSheet->setCellValue ( 'J' . $Y, '数量' );
			$this->objActSheet->setCellValue ( 'K' . $Y, '我公司报价' );
			$this->objActSheet->setCellValue ( 'L' . $Y, '中标厂家(价格及相差点数)(排名/总数)' );
			$this->objActSheet->setCellValue ( 'M' . $Y, '中标价' );
			$Y = $Y + 1;
			// 数据循环-1
			$mergeCellList = array (
					'A',
					'B',
					'C',
					'D',
					'E',
					'F',
					'G' 
			);
			foreach ( $data as $list ) :
				// 初始化信息
				$list = $this->_setMergeCellsKey ( $list, $Y );
				// 数据循环-2
				foreach ( $list as $lt ) :
					// 判断是否合并
					if (! $lt)
						continue;
					if ($this->_isMergeCells ( $lt ['tb_show_id'], $Y ))
						$this->_megerCellColums ( $mergeCellList, $Y - 1 );
					$this->objActSheet->setCellValue ( 'A' . $Y, $lt ['tb_show_id'] );
					$this->objActSheet->setCellValue ( 'B' . $Y, $lt ['respective_regions'] );
					$this->objActSheet->setCellValue ( 'C' . $Y, $lt ['respective_provinces'] );
					$this->objActSheet->setCellValue ( 'D' . $Y, $lt ['project_name'] );
					$this->objActSheet->setCellValue ( 'E' . $Y, $lt ['tenderer'] );
					$this->objActSheet->setCellValue ( 'F' . $Y, $lt ['slesman'] );
					$this->objActSheet->setCellValue ( 'G' . $Y, $lt ['end_time'] );
					$this->objActSheet->setCellValue ( 'H' . $Y, $lt ['transformer_type'] );
					$this->objActSheet->setCellValue ( 'I' . $Y, $lt ['specification'] );
					$this->objActSheet->setCellValue ( 'J' . $Y, $lt ['number'] );
					$this->objActSheet->setCellValue ( 'K' . $Y, $lt ['my_company_price_show'] );
					$this->objActSheet->setCellValue ( 'L' . $Y, $lt ['show_bid_company'] . $lt ['show_bid_price'] . $lt ['xiangcha_bid_price'] . '(' . $lt ['bid_price_number'] . '/' . $lt ['list_price_count'] . ')' );
					$this->objActSheet->setCellValue ( 'M' . $Y, $lt ['show_bid_price'] );
					$Y = $Y + 1;
				endforeach
				;
			endforeach
			;
		}
		$this->objActSheet->getStyle ( "K2:K" . $Y )->getNumberFormat ()->setFormatCode ( '0.0' );
		$this->objActSheet->getStyle ( "M2:M" . $Y )->getNumberFormat ()->setFormatCode ( '0.0' );
		self::setStyleAll ( $this->objActSheet, "A1:Q" . $Y );
		if (! $fileName)
			$fileName = time ();
		$fileName = $fileName . '.xls';
		$this->createExeclFile ( $fileName );
		exit ();
	}
	public function exportPHPExcelZhongBiaoZhanBiRecord($data = array(), $fileName = '') {
		$this->createExeclFileHeader ();
		
		$this->objActSheet->getColumnDimension ( 'A' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'B' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'C' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'D' )->setWidth ( 20 );
		
		self::setStyle ( $this->objActSheet, 'A' );
		self::setStyle ( $this->objActSheet, 'B' );
		self::setStyle ( $this->objActSheet, 'C' );
		self::setStyle ( $this->objActSheet, 'D' );
		$Y = 1;
		if ($data) {
			$this->objActSheet->setCellValue ( 'A' . $Y, '编号' );
			$this->objActSheet->setCellValue ( 'B' . $Y, '区域' );
			$this->objActSheet->setCellValue ( 'C' . $Y, '国家' );
			$this->objActSheet->setCellValue ( 'D' . $Y, '项目简称' );
			$this->objActSheet->setCellValue ( 'E' . $Y, '招标人' );
			$this->objActSheet->setCellValue ( 'F' . $Y, '类型' );
			$this->objActSheet->setCellValue ( 'G' . $Y, '数量' );
			$this->objActSheet->setCellValue ( 'H' . $Y, '投标价（万元）' );
			$this->objActSheet->setCellValue ( 'I' . $Y, '中标厂家' );
			$this->objActSheet->setCellValue ( 'J' . $Y, '中标价（相差点数)' );
			$this->objActSheet->setCellValue ( 'K' . $Y, '占比' );
			$this->objActSheet->setCellValue ( 'L' . $Y, '中标价（万元）' );
			foreach ( $data as $toubiaoId => $list ) :
				// 过滤没中标记录内容
				if (! $list ['all_bid_price'])
					continue;
				$Y = $Y + 1;
				$this->objActSheet->setCellValue ( 'A' . $Y, $list ['tb_show_id'] );
				$this->objActSheet->setCellValue ( 'B' . $Y, $list ['respective_regions'] );
				$this->objActSheet->setCellValue ( 'C' . $Y, $list ['respective_provinces'] );
				$this->objActSheet->setCellValue ( 'D' . $Y, $list ['project_name'] );
				$this->objActSheet->setCellValue ( 'E' . $Y, $list ['tenderer'] );
				$start_Y = $Y;
				$merge_s = $Y;
				$pevListString = '';
				foreach ( $list ['sort_key'] as $kaiBiaoID => $lt ) :
					// 合并规则
					if ($pevListString && $Y - $merge_s > 0) {
						$listString = $list ['kai_biao_list'] [$kaiBiaoID] ['show_bid_company'];
						if ($pevListString != $listString) {
							$this->objActSheet->mergeCells ( 'I' . ($merge_s) . ':' . 'I' . ($Y - 1) );
							$this->objActSheet->mergeCells ( 'K' . ($merge_s) . ':' . 'K' . ($Y - 1) );
							$merge_s = $Y;
							$pevListString = $list ['kai_biao_list'] [$kaiBiaoID] ['show_bid_company'];
						}
					} else {
						$pevListString = $list ['kai_biao_list'] [$kaiBiaoID] ['show_bid_company'];
					}
					$this->objActSheet->setCellValue ( 'F' . $Y, $list ['kai_biao_list'] [$kaiBiaoID] ['transformer_type'] );
					$this->objActSheet->setCellValue ( 'G' . $Y, $list ['kai_biao_list'] [$kaiBiaoID] ['number'] );
					$this->objActSheet->setCellValue ( 'H' . $Y, $list ['kai_biao_list'] [$kaiBiaoID] ['my_company_price_show'] );
					$this->objActSheet->setCellValue ( 'I' . $Y, $list ['kai_biao_list'] [$kaiBiaoID] ['show_bid_company'] );
					$this->objActSheet->setCellValue ( 'J' . $Y, $list ['kai_biao_list'] [$kaiBiaoID] ['xiangcha_bid_price'] );
					$this->objActSheet->setCellValue ( 'K' . $Y, $list ['kai_biao_list'] [$kaiBiaoID] ['zhan_bi'] );
					$this->objActSheet->setCellValue ( 'L' . $Y, $list ['kai_biao_list'] [$kaiBiaoID] ['show_bid_price'] );
					$Y = $Y + 1;
				endforeach
				;
				$this->objActSheet->mergeCells ( 'A' . ($start_Y) . ':' . 'A' . ($Y - 1) );
				$this->objActSheet->mergeCells ( 'B' . ($start_Y) . ':' . 'B' . ($Y - 1) );
				$this->objActSheet->mergeCells ( 'C' . ($start_Y) . ':' . 'C' . ($Y - 1) );
				$this->objActSheet->mergeCells ( 'D' . ($start_Y) . ':' . 'D' . ($Y - 1) );
				$this->objActSheet->mergeCells ( 'E' . ($start_Y) . ':' . 'E' . ($Y - 1) );
				self::setBackColor ( $this->objActSheet, "A" . $Y . ":L" . $Y );
				$this->objActSheet->setCellValue ( 'E' . $Y, $list ['tenderer'] );
				$this->objActSheet->setCellValue ( 'H' . $Y, $list ['all_san_bid_price'] );
				$this->objActSheet->setCellValue ( 'L' . $Y, $list ['all_bid_price'] );
				$all_bid_price += $list ['all_bid_price'];
				$all_san_bid_price += $list ['all_san_bid_price'];
			endforeach
			;
			$Y = $Y + 1;
			self::setBackColor ( $this->objActSheet, "A" . $Y . ":L" . $Y );
			$this->objActSheet->setCellValue ( 'E' . $Y, '总计' );
			$this->objActSheet->setCellValue ( 'H' . $Y, $all_san_bid_price );
			$this->objActSheet->setCellValue ( 'L' . $Y, $all_bid_price );
		}
		self::setStyleAll ( $this->objActSheet, "A1:L" . $Y );
		if (! $fileName)
			$fileName = time ();
		$fileName = $fileName . '.xls';
		$this->createExeclFile ( $fileName );
		exit ();
	}
	
	public static function getNumber26($v) {
		while ( $v != 0 ) {
			if ($v % 26 == 0) {
				$r .= self::$cloumnsExecl [25];
				$v = $v - 26;
			} else {
				$r .= self::$cloumnsExecl [ceil ( $v % 26 ) - 1];
				$v = intval ( $v / 26 );
			}
		}
		$r = strrev ( $r );
		return $r;
	}
	
	public static function setStyle($objSheet, $keyXY) {
		return;
		$objSheet->getStyle ( $keyXY )->getAlignment ()->setWrapText ( true );
		$objSheet->getStyle ( $keyXY )->getFont ()->setSize ( 9 );
		$objSheet->getStyle ( $keyXY )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
		$objSheet->getStyle ( $keyXY )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
		
		// $objSheet->getStyle($keyXY)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
		// $objSheet->getStyle($keyXY)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		// $objSheet->getStyle($keyXY)->getBorders()->getTop()->getColor()->setARGB('FFFFFFFF');
	// // color
		// $objSheet->getStyle($keyXY)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		// $objSheet->getStyle($keyXY)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		// $objSheet->getStyle($keyXY)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	}
	
	public static function setStyleAll($objSheet, $keyXY) {
		$objSheet->getStyle ( $keyXY )->getAlignment ()->setWrapText ( true );
		$objSheet->getStyle ( $keyXY )->getFont ()->setSize ( 9 );
		$objSheet->getStyle ( $keyXY )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
		$objSheet->getStyle ( $keyXY )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
		$objSheet->getStyle ( $keyXY )->getNumberFormat ()->setFormatCode ( PHPExcel_Style_NumberFormat::FORMAT_NUMBER );
		$objSheet->getStyle ( $keyXY )->getBorders ()->getTop ()->setBorderStyle ( PHPExcel_Style_Border::BORDER_THIN );
		$objSheet->getStyle ( $keyXY )->getBorders ()->getTop ()->getColor ()->setARGB ( 'FFFFFFFF' ); // color
		$objSheet->getStyle ( $keyXY )->getBorders ()->getBottom ()->setBorderStyle ( PHPExcel_Style_Border::BORDER_THIN );
		$objSheet->getStyle ( $keyXY )->getBorders ()->getLeft ()->setBorderStyle ( PHPExcel_Style_Border::BORDER_THIN );
		$objSheet->getStyle ( $keyXY )->getBorders ()->getRight ()->setBorderStyle ( PHPExcel_Style_Border::BORDER_THIN );
	}
	
	public static function setBackColor($objSheet, $keyXY) {
		$objSheet->getStyle ( $keyXY )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
		$objSheet->getStyle ( $keyXY )->getFill ()->getStartColor ()->setARGB ( '#FFFF37' );
	}
	
	public function createKaiBiaoHeader($maxX) {
		$this->objActSheet->getColumnDimension ( 'A' )->setWidth ( 12 );
		$this->objActSheet->getColumnDimension ( 'B' )->setWidth ( 12 );
		$this->objActSheet->getColumnDimension ( 'C' )->setWidth ( 12 );
		$this->objActSheet->getColumnDimension ( 'D' )->setWidth ( 12 );
		$this->objActSheet->getColumnDimension ( 'E' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'F' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'G' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'H' )->setWidth ( 31 );
		$this->objActSheet->getColumnDimension ( 'I' )->setWidth ( 26 );
		$this->objActSheet->getColumnDimension ( 'J' )->setWidth ( 7 );
		$this->objActSheet->getColumnDimension ( 'K' )->setWidth ( 10 );
		$this->objActSheet->getColumnDimension ( 'L' )->setWidth ( 7 );
		$this->objActSheet->getColumnDimension ( 'M' )->setWidth ( 21 );
		$this->objActSheet->getColumnDimension ( 'N' )->setWidth ( 5 );
		$this->objActSheet->getColumnDimension ( 'O' )->setWidth ( 10 );
		$this->objActSheet->getColumnDimension ( 'P' )->setWidth ( 10 );
		$this->objActSheet->getColumnDimension ( 'Q' )->setWidth ( 10 );
		$this->objActSheet->getColumnDimension ( 'R' )->setWidth ( 12 );
		
		foreach ( self::$kaiBiaoStaticHeader1 as $staticKey => $staticHeader ) {
			$this->objActSheet->mergeCells ( $staticKey . '1:' . $staticKey . '2' );
			self::setStyle ( $this->objActSheet, $staticKey . '1' );
			$this->objActSheet->setCellValue ( $staticKey . '1', $staticHeader );
		}
		foreach ( self::$kaiBiaoStaticHeader2 as $staticKey => $staticHeader ) {
			$this->objActSheet->mergeCells ( $staticKey . '1:' . $staticKey . '2' );
			self::setStyle ( $this->objActSheet, $staticKey . '1' );
			$this->objActSheet->setCellValue ( $staticKey . '1', $staticHeader );
		}
		$staticX = self::getNumber26 ( self::$staticX - 1 );
		self::setStyle ( $this->objActSheet, $staticX . '1' );
		$this->objActSheet->setCellValue ( $staticX . '1', '开标记录(万元)' );
		self::setStyle ( $this->objActSheet, $staticX . '2' );
		$this->objActSheet->setCellValue ( $staticX . '2', '排名/总数' );
		
		if ($maxX > self::$staticX) {
			$this->objActSheet->mergeCells ( $staticX . '1:' . (self::getNumber26 ( $maxX - 1 )) . '1' );
			for($i = self::$staticX; $i < $maxX; $i ++) {
				$this->objActSheet->getColumnDimension ( self::getNumber26 ( $i ) )->setWidth ( 10 );
				self::setStyle ( $this->objActSheet, (self::getNumber26 ( $i )) . '2' );
				$this->objActSheet->setCellValue ( (self::getNumber26 ( $i )) . '2', '投标人' . ($i - self::$staticX + 1) );
			}
		}
	}
	
	public function createExeclFile($fileName) {
		$this->objPHPExcel->getActiveSheet ()->setTitle ( 'Simple' );
		$this->objPHPExcel->setActiveSheetIndex ( 0 );
		header ( 'Content-Type: application/vnd.ms-excel; charset=gbk' );
		header ( 'Content-Disposition: attachment;filename="' . $fileName . '"' );
		header ( 'Cache-Control: max-age=0' );
		$objWriter = PHPExcel_IOFactory::createWriter ( $this->objPHPExcel, 'Excel5' );
		$objWriter->save ( 'php://output' );
		exit ();
	}
	
	private $merge_s;
	private $pevListString;
	private $endCount;
	private $endNumber;
	private function _setMergeCellsKey($list, $Y) {
		// 内容合并坐标初始化
		$this->merge_s = $Y;
		// 内容合并判断信息初始化
		$this->pevListString = '';
		$this->endCount = count ( $list );
		// 便于进行最后一次循环，计算是否合并
		$list [] = '';
		$this->endNumber = 0;
		return $list;
	}
	private function _isMergeCells($stringkey, $Y) {
		$key = 0;
		$this->endNumber ++;
		// 排除第一条
		if ($this->pevListString && $this->endNumber > 1) {
			// 当前行字符串信息
			$this->listString = $stringkey;
			if ($this->pevListString != $this->listString || $this->endCount == $this->endNumber) {
				$key = '合并';
				$this->pevListString = $stringkey;
			}
		} else {
			$this->pevListString = $stringkey;
		}
		return $key;
	}
	
	private function _megerCellColums($mergeCellList, $end) {
		if ($this->merge_s == $end)
			return;
		foreach ( $mergeCellList as $X ) {
			$this->objActSheet->mergeCells ( $X . $this->merge_s . ':' . $X . $end );
		}
		$this->merge_s = $end + 1;
	}

}
