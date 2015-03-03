<?php
function b_obituaries_show($options) {
    global $xoopsUser;
    $block = array();
    include XOOPS_ROOT_PATH.'/modules/obituaries/include/common.php';
    $start = 0;
    $limit = intval($options[0]);
    $itemsCount = $hBdUsersObituaries->getTodayObituariessCount();
    $users = $hBdUsersObituaries->getTodayObituariess($start, $limit);
    if(count($users) > 0) {
        foreach($users as $user) {
            $block['obituaries_today_users'][] = $user->toArray();
        }
    }
    if($itemsCount > $limit) {
        $block['obituaries_today_more'] = true;
    } else {
        $block['obituaries_today_more'] = false;
    }

    if (is_object($xoopsUser)) {
        $block['obituaries_today_mypage'] = true;
    } else {
        $block['obituaries_today_mypage'] = false;
    }
    $block['obituaries_display_picture'] = intval($options[1]);
    $block['obituaries_picture_width'] = $options[2];

    return $block;
}

function b_obituaries_edit($options)
{
    include XOOPS_ROOT_PATH.'/modules/obituaries/include/common.php';
    $form = '';
    $form .= "<table border='0'>";
    $form .= '<tr><td>'._MB_OBITUARIES_MAX_ITEMS."</td><td><input type='text' name='options[]' id='options' value='".$options[0]."' /></td></tr>\n";
    $form .= "<tr><td>"._MB_OBITUARIES_DISPLAY_PICTURE."</td><td><input type='radio' id='options[]' name='options[]' value='1'";
    if ($options[1] == 1) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;"._YES."<input type='radio' id='options[]' name='options[]' value='0'";
    if ($options[1] == 0) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;"._NO."</td></tr>\n";
    $form .= '<tr><td>'._MB_OBITUARIES_PICTURE_WIDTH."</td><td><input type='text' name='options[]' id='options' value='".$options[2]."' /></td></tr>\n";
    $form .= "</table>\n";

    return $form;
}

function b_obituaries_random_show($options) {
    $block = array();
    include XOOPS_ROOT_PATH.'/modules/obituaries/include/common.php';
    $start = 0;
    $limit = intval($options[0]);

    $users = $hBdUsersObituaries->getRandomObituariess($start, $limit);
    if(count($users) > 0) {
        foreach($users as $user) {
            $block['obituaries_random_users'][] = $user->toArray();
        }
    }

    $block['obituaries_display_picture'] = intval($options[1]);
    $block['obituaries_picture_width'] = $options[2];

    return $block;
}

function b_obituaries_random_edit($options)
{
    include XOOPS_ROOT_PATH.'/modules/obituaries/include/common.php';
    $form = '';
    $form .= "<table border='0'>";
    $form .= '<tr><td>'._MB_OBITUARIES_MAX_ITEMS."</td><td><input type='text' name='options[]' id='options' value='".$options[0]."' /></td></tr>\n";
    $form .= "<tr><td>"._MB_OBITUARIES_DISPLAY_PICTURE."</td><td><input type='radio' id='options[]' name='options[]' value='1'";
    if ($options[1] == 1) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;"._YES."<input type='radio' id='options[]' name='options[]' value='0'";
    if ($options[1] == 0) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;"._NO."</td></tr>\n";
    $form .= '<tr><td>'._MB_OBITUARIES_PICTURE_WIDTH."</td><td><input type='text' name='options[]' id='options' value='".$options[2]."' /></td></tr>\n";
    $form .= "</table>\n";

    return $form;
}

function b_obituaries_last_show($options) {
    $block = array();
    include XOOPS_ROOT_PATH.'/modules/obituaries/include/common.php';
    $start = 0;
    $limit = intval($options[0]);

    if(obituaries_utils::getModuleOption('userslist_sortorder') == 1) {    // Sort by date
        $sort = 'obituaries_date';
        $order = 'DESC';
    } else {
        $sort = 'obituaries_lastname';
        $order = 'ASC';
    }
    $users = $hBdUsersObituaries->getLastObituariess($start, $limit, $sort, $order);

    if(count($users) > 0) {
        foreach($users as $user) {
            $block['obituaries_last_users'][] = $user->toArray();
        }
    }

    $block['obituaries_display_picture'] = intval($options[1]);
    $block['obituaries_picture_width'] = $options[2];

    return $block;
}

function b_obituaries_last_edit($options)
{
    include XOOPS_ROOT_PATH.'/modules/obituaries/include/common.php';
    $form = '';
    $form .= "<table border='0'>";
    $form .= '<tr><td>'._MB_OBITUARIES_MAX_ITEMS."</td><td><input type='text' name='options[]' id='options' value='".$options[0]."' /></td></tr>\n";
    $form .= "<tr><td>"._MB_OBITUARIES_DISPLAY_PICTURE."</td><td><input type='radio' id='options[]' name='options[]' value='1'";
    if ($options[1] == 1) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;"._YES."<input type='radio' id='options[]' name='options[]' value='0'";
    if ($options[1] == 0) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;"._NO."</td></tr>\n";
    $form .= '<tr><td>'._MB_OBITUARIES_PICTURE_WIDTH."</td><td><input type='text' name='options[]' id='options' value='".$options[2]."' /></td></tr>\n";
    $form .= "</table>\n";

    return $form;
}
