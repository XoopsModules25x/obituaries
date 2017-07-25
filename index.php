<?php

/**
 * Permet � l'utilisateur courant de modifier sa fiche (si l'option ad�quate est activ�e)
 */
require_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'obituaries_users.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

$start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
$limit = obituaries_utils::getModuleOption('perpage');    // Nombre maximum d'�l�ments � afficher
$users = array();

if (isset($_GET['op']) && $_GET['op'] === 'today') {    // Les utilisateurs dont l'anniversaire est aujourd'hui
    $itemsCount = $hBdUsersObituaries->getTodayObituariessCount();
    if ($itemsCount > $limit) {
        $pagenav = new XoopsPageNav($itemsCount, $limit, $start, 'start', 'op=today');
    }
    $users = $hBdUsersObituaries->getTodayObituariess($start, $limit);
} else {    // Tous les utilisateurs
    $itemsCount = $hBdUsersObituaries->getAllUsersCount();
    if ($itemsCount > $limit) {
        $pagenav = new XoopsPageNav($itemsCount, $limit, $start, 'start');
    }
    if (obituaries_utils::getModuleOption('userslist_sortorder') == 1) {    // Sort by date
        $sort  = 'obituaries_date';
        $order = 'DESC';
    } else {
        $sort  = 'obituaries_lastname';
        $order = 'ASC';
    }
    $users = $hBdUsersObituaries->getAllUsers($start, $limit, $sort, $order);
}
if (count($users) > 0) {
    foreach ($users as $user) {
        $xoopsTpl->append('obituaries_users', $user->toArray());
    }
}
if (isset($pagenav) && is_object($pagenav)) {
    $xoopsTpl->assign('pagenav', $pagenav->renderNav());
}
$pageTitle       = _AM_OBITUARIES_USERS_LIST . ' - ' . obituaries_utils::getModuleName();
$metaDescription = $pageTitle;
$metaKeywords    = '';
obituaries_utils::setMetas($pageTitle, $metaDescription, $metaKeywords);

$path       = array(OBITUARIES_URL . 'index.php' => _AM_OBITUARIES_USERS_LIST);
$breadcrumb = obituaries_utils::breadcrumb($path);
$xoopsTpl->assign('breadcrumb', $breadcrumb);
require_once XOOPS_ROOT_PATH . '/footer.php';
