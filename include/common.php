<?php
/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Copyright (c) Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 * Created on 10 juil. 08 at 13:35:06
 * Version : $Id:
 * ****************************************************************************
 */
 if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

if( !defined("OBITUARIES_DIRNAME") ) {
    define("OBITUARIES_DIRNAME", 'obituaries');
    define("OBITUARIES_URL", XOOPS_URL.'/modules/'.OBITUARIES_DIRNAME.'/');
    define("OBITUARIES_PATH", XOOPS_ROOT_PATH.'/modules/'.OBITUARIES_DIRNAME.'/');
    define("OBITUARIES_CACHE_PATH", XOOPS_UPLOAD_PATH.'/'.OBITUARIES_DIRNAME.'/');

    define("OBITUARIES_IMAGES_URL", OBITUARIES_URL.'images/');
    define("OBITUARIES_IMAGES_PATH", OBITUARIES_PATH.'images/');
    define("OBITUARIES_THUMB", 'thumb_');
}
$myts = &MyTextSanitizer::getInstance();

// Chargement des handler et des autres classes
require_once OBITUARIES_PATH.'class/obituaries_utils.php';

// Check that the class exists before trying to use it
//    if (!class_exists('PEAR')){
//include_once OBITUARIES_PATH.'class/PEAR.php';
//}

$hBdUsersObituaries = xoops_getmodulehandler('users_obituaries', OBITUARIES_DIRNAME);

// D�finition des images
if( !defined("_OBITUARIES_EDIT")) {
    if(!isset($xoopsConfig)) {
        global $xoopsConfig;
    }
    if (isset($xoopsConfig) && file_exists(OBITUARIES_PATH.'language/'.$xoopsConfig['language'].'/main.php')) {
        require_once OBITUARIES_PATH.'language/'.$xoopsConfig['language'].'/main.php';
    } else {
        require_once OBITUARIES_PATH.'language/english/main.php';
    }

    $birdthday_icones = array(
        'edit' => "<img src='". OBITUARIES_IMAGES_URL ."edit.png' alt='" . _AM_OBITUARIES_EDIT . "' align='middle' />",
        'delete' => "<img src='". OBITUARIES_IMAGES_URL ."delete.png' alt='" . _AM_OBITUARIES_DELETE . "' align='middle' />"
    );
}
