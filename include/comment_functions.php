<?php
/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * Created on 20 oct. 07 at 14:38:20
 * Version :
 * ****************************************************************************
 * @param $userId
 * @param $total_num
 */

// defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

function obituaries_com_update($userId, $total_num)
{
    include XOOPS_ROOT_PATH . '/modules/obituaries/include/common.php';
    global $hBdUsersObituaries;
    if (!is_object($hBdUsersObituaries)) {
        $hBdUsersObituaries = xoops_getModuleHandler('users_obituaries', OBITUARIES_DIRNAME);
    }
    $hBdUsersObituaries->updateCommentsCount($userId, $total_num);
}

function obituaries_com_approve(&$comment)
{
    // notification mail here
}
