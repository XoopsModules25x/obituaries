<?php
/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Based on birthday module made by Hervé Thouzard
 * Created on 10 jully. 08 at 11:32:40
 * ****************************************************************************
 */

use Xmf\Module\Admin;
use XoopsModules\Obituaries;

require_once dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

$helper = Obituaries\Helper::getInstance();
$helper->loadLanguage('modinfo');
$helper->loadLanguage('common');

// get path to icons
$pathIcon32 = Admin::menuIconPath('');
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

if (is_object($helper->getModule()) && $helper->getConfig('displayDeveloperTools')) {
    $adminmenu[] = [
        'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_MIGRATE'),
        'link'  => 'admin/migrate.php',
        'icon'  => $pathIcon32 . '/database_go.png',
    ];
}

$adminmenu[] = [
    'title' => _MI_OBITUARIES_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];
