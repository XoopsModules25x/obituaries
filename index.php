<?php

/**
 * Permet � l'utilisateur courant de modifier sa fiche (si l'option ad�quate est activ�e)
 */
require_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'obituaries_users.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

$start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
$limit = ObituariesUtils::getModuleOption('perpage');    // Nombre maximum d'�l�ments � afficher
$users = [];

if (isset($_GET['op']) && 'today' === $_GET['op']) {    // Les utilisateurs dont l'anniversaire est aujourd'hui
    $itemsCount = $usersHandler->getTodayObituariessCount();
    if ($itemsCount > $limit) {
        $pagenav = new XoopsPageNav($itemsCount, $limit, $start, 'start', 'op=today');
    }
    $users = $usersHandler->getTodayObituariess($start, $limit);
} else {    // Tous les utilisateurs
    $itemsCount = $usersHandler->getAllUsersCount();
    if ($itemsCount > $limit) {
        $pagenav = new XoopsPageNav($itemsCount, $limit, $start, 'start');
    }
    if (1 == ObituariesUtils::getModuleOption('userslist_sortorder')) {    // Sort by date
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
$pageTitle       = _AM_OBITUARIES_USERS_LIST . ' - ' . ObituariesUtils::getModuleName();
$metaDescription = $pageTitle;
$metaKeywords    = '';
ObituariesUtils::setMetas($pageTitle, $metaDescription, $metaKeywords);

$path       = [OBITUARIES_URL . 'index.php' => _AM_OBITUARIES_USERS_LIST];
$breadcrumb = ObituariesUtils::breadcrumb($path);
$xoopsTpl->assign('breadcrumb', $breadcrumb);
require_once XOOPS_ROOT_PATH . '/footer.php';
