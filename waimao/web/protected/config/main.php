<?php
return array(
    
        'name' => 'tenders', 
        'basePath' => WEB_PROTECTED_PATH, 
        'preload' => array(
            'log'
        ), 
        'defaultController' => 'index', 
        'import' => array(
            
                'application.action.index.*', 
                'application.action.backend.*', 
                'application.action.operation.*', 
                'application.action.quote.*', 
                'application.action.backup.*', 
                'application.action.service.*', 
                'application.action.layouts.*', 
        		'application.action.tongji.*',
        		'application.action.tool.*',
                'application.controllers.*', 
                'application.components.*',
                'application.extensions.phpexcel.*', 
                'application.extensions.phpexcel.PHPExcel.*'
        ), 
        'components' => array(
            
                'phpexcel' => array(
                    
                        'class' => 'PHPExcelTool'
                ), 
                'showbox' => array(
                    
                        'class' => 'ShowMessage'
                ), 
                'turnpage' => array(
                    
                        'class' => 'TurnPage'
                ),
                'tablegear' => array(
                    
                        'class' => 'TableGearTool'
                ),
        )
);