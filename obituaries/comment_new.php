<?php
/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * Created on 20 oct. 07 at 14:38:20
 * Version : $Id:
 * ****************************************************************************
 */

require '../../mainfile.php';
require 'header.php';
$com_itemid = isset($_GET['com_itemid']) ? intval($_GET['com_itemid']) : 0;
if ($com_itemid > 0) {
	include XOOPS_ROOT_PATH.'/modules/obituaries/include/common.php';
	$user = null;
	$user = $hBdUsersObituaries->get($com_itemid);
	if(is_object($user)) {
    	$com_replytitle = $user->getFullName();
    	require XOOPS_ROOT_PATH.'/include/comment_new.php';
	} else {
		exit();
	}
}
?>
