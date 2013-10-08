<?php
/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * Created on 10 juil. 08 at 18:39:52
 * Version : $Id:
 * ****************************************************************************
 */

/**
 * Affichage de la page d'un utilisateur
 */
require 'header.php';
$xoopsOption['template_main'] = 'obituaries_user.html';
require_once XOOPS_ROOT_PATH.'/header.php';

$case = 0;
if(isset($_GET['obituaries_id'])) {
    $uid = intval($_GET['obituaries_id']);
    $case = 1;
} elseif(isset($_GET['obituaries_uid'])) {
    $uid = intval($_GET['obituaries_uid']);
    $case = 2;
} elseif(isset($xoopsUser) && is_object($xoopsUser)) {
    $uid = $xoopsUser->getVar('uid');
    $case = 3;
}

$user = null;
switch($case) {
    case 0:    // Unknow user
        obituaries_utils::redirect(_OBITUARIES_ERROR2, 'index.php', 3);
        break;

    case 1:    // obituaries_id
        $user = $hBdUsersObituaries->get($uid);
        break;

    case 2:    // obituaries_uid
    case 3:    // uid
        $user = $hBdUsersObituaries->getFromUid($uid);
        break;
}
if(is_object($user)) {
    $xoopsTpl->assign('obituaries_user', $user->toArray());
    $pageTitle = $user->getFullName().' - '.obituaries_utils::getModuleName();
    $metaDescription = $pageTitle;
    $metaKeywords = obituaries_utils::createMetaKeywords($user->getVar('obituaries_description'));
    obituaries_utils::setMetas($pageTitle, $metaDescription, $metaKeywords);
}
$path = array(  OBITUARIES_URL.'user.php' => $user->getFullName()
               );
$breadcrumb = obituaries_utils::breadcrumb($path);
$xoopsTpl->assign('breadcrumb', $breadcrumb);
include_once XOOPS_ROOT_PATH.'/include/comment_view.php';
require_once XOOPS_ROOT_PATH.'/footer.php';
?>
