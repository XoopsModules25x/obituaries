<?php
/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * Created on 20 oct. 07 at 14:38:20
 * Version : $Id:
 * ****************************************************************************
 */

function obituaries_adminMenu($currentoption = 0, $breadcrumb = '')
{
	global $xoopsConfig, $xoopsModule;
	if(file_exists(XOOPS_ROOT_PATH.'/modules/obituaries/language/'.$xoopsConfig['language'].'/modinfo.php')) {
		include_once XOOPS_ROOT_PATH.'/modules/obituaries/language/'.$xoopsConfig['language'].'/modinfo.php';
	} else {
		include_once XOOPS_ROOT_PATH.'/modules/obituaries/language/english/modinfo.php';
	}
	global $adminmenu;
	include 'menu.php';

	echo "<style type=\"text/css\">\n";
	echo "#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }\n";
	echo "#buttonbar { float:left; width:100%; background: #e7e7e7 url('../images/modadminbg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }\n";
	echo "#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }\n";
	echo "#buttonbar li { display:inline; margin:0; padding:0; }";
	echo "#buttonbar a { float:left; background:url('../images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }\n";
	echo "#buttonbar a span { float:left; display:block; background:url('../images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }\n";
	echo "/* Commented Backslash Hack hides rule from IE5-Mac \*/\n";
	echo "#buttonbar a span {float:none;}\n";
	echo "/* End IE5-Mac hack */\n";
	echo "#buttonbar a:hover span { color:#333; }\n";
	echo "#buttonbar .current a { background-position:0 -150px; border-width:0; }\n";
	echo "#buttonbar .current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }\n";
	echo "#buttonbar a:hover { background-position:0% -150px; }\n";
	echo "#buttonbar a:hover span { background-position:100% -150px; }\n";
	echo "</style>\n";

	echo "<div id=\"buttontop\">\n";
	echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\">\n";
	echo "<tr>\n";
	echo "<td style=\"width: 70%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\">\n";
	echo "<a href=\"../index.php\">"._AM_OBITUARIES_GO_TO_MODULE."</a> | <a href=\"".XOOPS_URL."/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=".$xoopsModule->getVar('mid')."\">"._AM_OBITUARIES_PREFERENCES."</a> | <a href='index.php?op=maintain'>"._AM_OBITUARIES_MAINTAIN."</a>\n";
	echo "</td>\n";
	echo "<td style=\"width: 30%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;\">\n";
	echo "<b>".$xoopsModule->getVar('name')."&nbsp;"._AM_OBITUARIES_ADMINISTRATION."</b>&nbsp;".$breadcrumb."\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	echo "</div>\n";
	echo "<div id=\"buttonbar\">\n";
	echo "<ul>\n";
	foreach($GLOBALS['adminmenu'] as $key=>$link) {
		if($key == $currentoption) {
			echo "<li class=\"current\">\n";
		} else {
			echo "<li>\n";
		}
		echo "<a href=\"".XOOPS_URL."/modules/obituaries/".$link['link']."\"><span>".$link['title']."</span></a>\n";
		echo "</li>\n";
	}
	echo "</ul>\n";
	echo "</div>\n";
	echo "<br style=\"clear:both;\" />\n";

}
?>