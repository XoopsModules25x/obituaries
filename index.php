<?php

/**
 * Permet à l'utilisateur courant de modifier sa fiche (si l'option adéquate est activée)
 */

use XoopsModules\Obituaries;

$GLOBALS['xoopsOption']['template_main'] = 'obituaries_users.tpl';

require_once __DIR__ . '/header.php';

require_once XOOPS_ROOT_PATH . '/header.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

$start = \Xmf\Request::getInt('start', 0, 'GET');
$limit = Obituaries\ObituariesUtils::getModuleOption('perpage');    // Nombre maximum d'éléments à afficher
$users = [];

if (\Xmf\Request::hasVar('op', 'GET') && 'today' === $_GET['op']) {    // Les utilisateurs dont l'anniversaire est aujourd'hui
    $itemsCount = $usersHandler->getTodayObituariessCount();
    if ($itemsCount > $limit) {
        $pagenav = new \XoopsPageNav($itemsCount, $limit, $start, 'start', 'op=today');
    }
    $users = $usersHandler->getTodayObituariess($start, $limit);
} else {    // Tous les utilisateurs
    $itemsCount = $usersHandler->getAllUsersCount();
    if ($itemsCount > $limit) {
        $pagenav = new \XoopsPageNav($itemsCount, $limit, $start, 'start');
    }
    if (1 == Obituaries\ObituariesUtils::getModuleOption('userslist_sortorder')) {    // Sort by date
        $sort  = 'obituaries_date';
        $order = 'DESC';
    } else {
        $sort  = 'obituaries_lastname';
        $order = 'ASC';
    }
    $users = $usersHandler->getAllUsers($start, $limit, $sort, $order);
}
if (count($users) > 0) {
    foreach ($users as $user) {
        $xoopsTpl->append('obituaries_users', $user->toArray());
    }
}
if (isset($pagenav) && is_object($pagenav)) {
    $xoopsTpl->assign('pagenav', $pagenav->renderNav());
}
$pageTitle       = _AM_OBITUARIES_USERS_LIST . ' - ' . Obituaries\ObituariesUtils::getModuleName();
$metaDescription = $pageTitle;
$metaKeywords    = '';
Obituaries\ObituariesUtils::setMetas($pageTitle, $metaDescription, $metaKeywords);

$path       = [OBITUARIES_URL . 'index.php' => _AM_OBITUARIES_USERS_LIST];
$breadcrumb = Obituaries\ObituariesUtils::breadcrumb($path);
$xoopsTpl->assign('breadcrumb', $breadcrumb);

require_once XOOPS_ROOT_PATH . '/footer.php';
