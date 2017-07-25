<?php
/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Based on birthday module made by Hervé Thouzard
 * Created on 10 jully. 08 at 11:32:40
 * ****************************************************************************
 */

// defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

$moduleDirName = basename(dirname(__DIR__));

if (false !== ($moduleHelper = Xmf\Module\Helper::getHelper($moduleDirName))) {
} else {
    $moduleHelper = Xmf\Module\Helper::getHelper('system');
}
$adminObject = \Xmf\Module\Admin::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
//$pathModIcon32 = $moduleHelper->getModule()->getInfo('modicons32');

$moduleHelper->loadLanguage('modinfo');

$adminObject            = array();
$i                      = 1;
$adminmenu[$i]['title'] = _MI_OBITUARIES_HOME;
$adminmenu[$i]['link']  = 'admin/index.php';
$adminmenu[$i]['icon']  = $pathIcon32 . '/home.png';
++$i;
$adminmenu[$i]['title'] = _MI_OBITUARIES_OBITUARIES;
$adminmenu[$i]['link']  = 'admin/main.php';
$adminmenu[$i]['icon']  = './assets/images/obituary.png';
//++$i;
//$adminmenu[$i]["title"] = _MI_OBITUARIES_MAINTAIN;
//$adminmenu[$i]["link"]  = "admin/main.php?op=maintain";
//$adminmenu[$i]["icon"] = './assets/images/maintenance.png';
++$i;
$adminmenu[$i]['title'] = _MI_OBITUARIES_ABOUT;
$adminmenu[$i]['link']  = 'admin/about.php';
$adminmenu[$i]['icon']  = $pathIcon32 . '/about.png';
