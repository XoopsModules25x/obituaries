<?php
/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Based on birthday module made by Hervé Thouzard
 * Created on 10 jully. 08 at 11:32:40
 * ****************************************************************************
 */

// defined('XOOPS_ROOT_PATH') || exit('Restricted access');

use XoopsModules\Obituaries;

require_once dirname(__DIR__) . '/preloads/autoloader.php';

/** @var Obituaries\Helper $helper */
$helper = Obituaries\Helper::getInstance();

// get path to icons
$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
if (is_object($helper->getModule())) {
    $pathModIcon32 = $helper->getModule()->getInfo('modicons32');
}

$adminmenu[] = [
    'title' => _MI_OBITUARIES_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png',
];

$adminmenu[] = [
    'title' => _MI_OBITUARIES_OBITUARIES,
    'link'  => 'admin/main.php',
    'icon'  => './assets/images/obituary.png',
];

//$adminmenu[] = [
//$adminmenu[$i]["title"] = _MI_OBITUARIES_MAINTAIN;
//$adminmenu[$i]["link"]  = "admin/main.php?op=maintain";
//$adminmenu[$i]["icon"] = './assets/images/maintenance.png';
//];

$adminmenu[] = [
    'title' => _MI_OBITUARIES_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];
