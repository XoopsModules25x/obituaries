<?php

/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * Created on 20 oct. 07 at 14:38:20
 * Version :
 * ****************************************************************************
 */

use Xmf\Request;

require_once dirname(__DIR__, 2) . '/mainfile.php';
require_once __DIR__ . '/header.php';
$com_itemid = Request::getInt('com_itemid', 0, 'GET');
if ($com_itemid > 0) {
    require_once XOOPS_ROOT_PATH . '/modules/obituaries/include/common.php';
    $user = $usersHandler->get($com_itemid);
    if (is_object($user)) {
        $com_replytitle = $user->getFullName();
        require_once XOOPS_ROOT_PATH . '/include/comment_new.php';
    } else {
        exit();
    }
}
