<?php

if( !function_exists( 'xoo_framework_includes' ) ){
	function xoo_framework_includes(){
		require_once __DIR__.'/class-xoo-helper.php';
		require_once __DIR__.'/class-xoo-exception.php';
	}
	xoo_framework_includes();
}