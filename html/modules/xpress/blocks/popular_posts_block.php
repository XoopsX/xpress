<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

eval( '
function b_'.$mydirname.'_popular_show($options){
	return _b_popular_show($options) ;
}
function b_'.$mydirname.'_popular_edit($options){
	return _b_popular_edit($options) ;
}
' ) ;

if( ! defined( 'XPRESS_POPULAR_BLOCK_INCLUDED' ) ) {
	define( 'XPRESS_POPULAR_BLOCK_INCLUDED' , 1 ) ;
	function _b_popular_edit($options)
	{
		$mydirname = empty( $options[0] ) ? 'xpress' : $options[0] ;
		$this_template = empty( $options[1] ) ? 'db:'.$mydirname.'_popular_posts_block.html' : trim( $options[1] );
		$disp_count = empty( $options[2] ) ? '10' : $options[2] ;
		$show_month_range = empty( $options[3] ) ? '0' : $options[3] ;
		$date_format = empty( $options[4] ) ? '' : $options[4] ;
		$time_format = empty( $options[5] ) ? '' : $options[5] ;
		$tag_select = $options[6] ;
		$cat_select = empty( $options[7] ) ? '0' : $options[7] ;

		$mydirpath = XOOPS_ROOT_PATH . '/modules/' . $mydirname;
		
		require_once(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/blocks/block_common.php');
		$form  = javascript_check();
		$form .= "MyDirectory <input type='text' name='options[0]' value='" . $mydirname . "' /><br />\n";
		$form .= block_template_setting($mydirname,'options[1]',htmlspecialchars($this_template,ENT_QUOTES));
		$form .= "<br />\n";
		$form .= _MB_XP2_COUNT .": <input type='text' name='options[2]' value='" . $disp_count . "' /><br />\n";
		$form .= _MB_XP2_MONTH_RANGE .": <input type='text' name='options[3]' value='" . $show_month_range . "' /><br />\n";
		$form .= _MB_XP2_DATE_FORMAT .": <input type='text' name='options[4]' value='" . $date_format . "' /><br />\n";
		$form .= _MB_XP2_TIME_FORMAT .": <input type='text' name='options[5]' value='" . $time_format . "' /><br />\n";
		include $mydirpath .'/wp-includes/version.php' ;
		if (wp_version_compare($wp_version, '>=','2.3')){
			$form .= "<br />\n";
			$form .= _MB_XP2_TAGS_SELECT .": <input type='text' name='options[6]' value='" . $tag_select . "' /><br />\n";
		} else {
			$form .= "<input type='hidden' name='options[6]' value='' /><br />\n";
		}

		$form .= categorie_select('options[7]' , $cat_select);
		return $form;
	}

	function _b_popular_show($options)
	{
		$mydirname = empty( $options[0] ) ? 'xpress' : $options[0] ;
		$mydirpath = XOOPS_ROOT_PATH . '/modules/' . $mydirname;
		$block_function_name = basename( __FILE__ );
		
		require_once $mydirpath.'/include/xpress_block_render.php';
		return xpress_block_render($mydirname,$block_function_name,$options);
	}
}
?>