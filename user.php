<?php
/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * Created on 10 juil. 08 at 18:39:52
 * Version :
 * ****************************************************************************
 */

use Xmf\Request;
use XoopsModules\Obituaries;
use XoopsModules\Obituaries\Helper;

/**
 * Affichage de la page d'un utilisateur
 */
require_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'obituaries_user.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

$helper = Helper::getInstance();

$case = 0;
if (Request::hasVar('obituaries_id', 'GET')) {
    $uid  = Request::getInt('obituaries_id', 0, 'GET');
    $case = 1;
} elseif (Request::hasVar('obituaries_uid', 'GET')) {
    $uid  = Request::getInt('obituaries_uid', 0, 'GET');
    $case = 2;
} elseif (isset($xoopsUser) && is_object($xoopsUser)) {
    $uid  = $xoopsUser->getVar('uid');
    $case = 3;
}

$user = null;
switch ($case) {
    case 0:    // Unknow user
        Obituaries\ObituariesUtils::redirect(_OBITUARIES_ERROR2, 'index.php', 3);
        break;
    case 1:    // obituaries_id
        $user = $usersHandler->get($uid);
        break;
    case 2:    // obituaries_uid
    case 3:    // uid
        $user = $usersHandler->getFromUid($uid);
        break;
}
if (is_object($user)) {
    $xoopsTpl->assign('obituaries_user', $user->toArray());
    $pageTitle       = $user->getFullName() . ' - ' . Obituaries\ObituariesUtils::getModuleName();
    $metaDescription = $pageTitle;
    $metaKeywords    = Obituaries\ObituariesUtils::createMetaKeywords($user->getVar('obituaries_description'));
    Obituaries\ObituariesUtils::setMetas($pageTitle, $metaDescription, $metaKeywords);
}
$path       = [OBITUARIES_URL . 'user.php' => $user->getFullName()];
$breadcrumb = Obituaries\ObituariesUtils::breadcrumb($path);
$xoopsTpl->assign('breadcrumb', $breadcrumb);

$xoopsTpl->assign('title1', $helper->getConfig('title1'));
$xoopsTpl->assign('title2', $helper->getConfig('title2'));
$xoopsTpl->assign('title3', $helper->getConfig('title3'));
$xoopsTpl->assign('title4', $helper->getConfig('title4'));

require_once XOOPS_ROOT_PATH . '/include/comment_view.php';
require_once XOOPS_ROOT_PATH . '/footer.php';
