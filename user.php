<?php
/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * Created on 10 juil. 08 at 18:39:52
 * Version :
 * ****************************************************************************
 */

/**
 * Affichage de la page d'un utilisateur
 */
require_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'obituaries_user.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

$case = 0;
if (isset($_GET['obituaries_id'])) {
    $uid  = (int)$_GET['obituaries_id'];
    $case = 1;
} elseif (isset($_GET['obituaries_uid'])) {
    $uid  = (int)$_GET['obituaries_uid'];
    $case = 2;
} elseif (isset($xoopsUser) && is_object($xoopsUser)) {
    $uid  = $xoopsUser->getVar('uid');
    $case = 3;
}

$user = null;
switch ($case) {
    case 0:    // Unknow user
        ObituariesUtils::redirect(_OBITUARIES_ERROR2, 'index.php', 3);
        break;

    case 1:    // obituaries_id
        $user = $hBdUsersObituaries->get($uid);
        break;

    case 2:    // obituaries_uid
    case 3:    // uid
        $user = $hBdUsersObituaries->getFromUid($uid);
        break;
}
if (is_object($user)) {
    $xoopsTpl->assign('obituaries_user', $user->toArray());
    $pageTitle       = $user->getFullName() . ' - ' . ObituariesUtils::getModuleName();
    $metaDescription = $pageTitle;
    $metaKeywords    = ObituariesUtils::createMetaKeywords($user->getVar('obituaries_description'));
    ObituariesUtils::setMetas($pageTitle, $metaDescription, $metaKeywords);
}
$path       = [OBITUARIES_URL . 'user.php' => $user->getFullName()];
$breadcrumb = ObituariesUtils::breadcrumb($path);
$xoopsTpl->assign('breadcrumb', $breadcrumb);
require_once XOOPS_ROOT_PATH . '/include/comment_view.php';
require_once XOOPS_ROOT_PATH . '/footer.php';
