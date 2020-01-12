<?php
/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * Created on 11 juil. 08 at 14:53:56
 * Version :
 * ****************************************************************************
 * @param array $queryarray
 * @param       $andor
 * @param       $limit
 * @param       $offset
 * @param       $userid
 * @return array
 */

use XoopsModules\Obituaries;

/**
 * @param $queryarray
 * @param $andor
 * @param $limit
 * @param $offset
 * @param $userid
 * @return array
 */
function obituaries_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;
    require_once __DIR__ . '/common.php';
    require_once XOOPS_ROOT_PATH . '/modules/obituaries/class/Users.php';

    // Recherche dans les produits
    $sql = 'SELECT obituaries_id, obituaries_firstname, obituaries_lastname, obituaries_date, obituaries_uid FROM ' . $xoopsDB->prefix('users_obituaries') . ' WHERE (obituaries_id <> 0 ';
    if (0 != $userid) {
        $sql .= ' AND obituaries_uid = ' . $userid;
    }
    $sql .= ') ';

    /** @var Obituaries\UsersHandler $usersHandler */
    $usersHandler = Obituaries\Helper::getInstance()->getHandler('Users');
    $tmpObject    = $usersHandler->create();
    $datas        = $tmpObject->getVars();
    $tblFields    = [];
    $cnt          = 0;
    foreach ($datas as $key => $value) {
        if (XOBJ_DTYPE_TXTBOX == $value['data_type'] || XOBJ_DTYPE_TXTAREA == $value['data_type']) {
            if (0 == $cnt) {
                $tblFields[] = $key;
            } else {
                $tblFields[] = ' OR ' . $key;
            }
            ++$cnt;
        }
    }

    $count = is_array($queryarray) ? count($queryarray) : 0;
    $more  = '';
    if ($queryarray && is_array($queryarray)) {
        $cnt  = 0;
        $sql  .= ' AND (';
        $more = ')';
        foreach ($queryarray as $oneQuery) {
            $sql  .= '(';
            $cond = " LIKE '%" . $oneQuery . "%' ";
            $sql  .= implode($cond, $tblFields) . $cond . ')';
            ++$cnt;
            if ($cnt != $count) {
                $sql .= ' ' . $andor . ' ';
            }
        }
    }
    $sql    .= $more . ' ORDER BY obituaries_date DESC';
    $i      = 0;
    $ret    = [];
    $myts   = \MyTextSanitizer::getInstance();
    $result = $xoopsDB->query($sql, $limit, $offset);
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $ret[$i]['image'] = 'assets/images/crown.png';
        $ret[$i]['link']  = 'user.php?obituaries_id=' . $myrow['obituaries_id'];
        $ret[$i]['title'] = $myts->htmlSpecialChars($myrow['obituaries_lastname'] . ' ' . $myrow['obituaries_firstname']);
        $ret[$i]['time']  = strtotime($myrow['obituaries_date']);
        $ret[$i]['uid']   = $myrow['obituaries_uid'];
        ++$i;
    }

    return $ret;
}
