<?php
/**
 * @param $options
 * @return array
 */

use XoopsModules\Obituaries;

/**
 * @param $options
 * @return array
 */
function b_obituaries_show($options)
{
    global $xoopsUser;
    $block = [];
    require_once XOOPS_ROOT_PATH . '/modules/obituaries/include/common.php';

    $usersHandler = new Obituaries\UsersHandler($db);
    $start        = 0;
    $limit        = (int)$options[0];
    $itemsCount   = $usersHandler->getTodayObituariessCount();
    $users        = $usersHandler->getTodayObituariess($start, $limit);
    if ($users && is_array($users)) {
        foreach ($users as $user) {
            $block['obituaries_today_users'][] = $user->toArray();
        }
    }
    if ($itemsCount > $limit) {
        $block['obituaries_today_more'] = true;
    } else {
        $block['obituaries_today_more'] = false;
    }

    if (is_object($xoopsUser)) {
        $block['obituaries_today_mypage'] = true;
    } else {
        $block['obituaries_today_mypage'] = false;
    }
    $block['obituaries_display_picture'] = (int)$options[1];
    $block['obituaries_picture_width']   = $options[2];

    return $block;
}

/**
 * @param $options
 * @return string
 */
function b_obituaries_edit($options)
{
    require_once XOOPS_ROOT_PATH . '/modules/obituaries/include/common.php';
    $form = '';
    $form .= "<table border='0'>";
    $form .= '<tr><td>' . _MB_OBITUARIES_MAX_ITEMS . "</td><td><input type='text' name='options[]' id='options' value='" . $options[0] . "'></td></tr>\n";
    $form .= '<tr><td>' . _MB_OBITUARIES_DISPLAY_PICTURE . "</td><td><input type='radio' id='options[]' name='options[]' value='1'";
    if (1 == $options[1]) {
        $form .= ' checked';
    }
    $form .= '>&nbsp;' . _YES . "<input type='radio' id='options[]' name='options[]' value='0'";
    if (0 == $options[1]) {
        $form .= ' checked';
    }
    $form .= '>&nbsp;' . _NO . "</td></tr>\n";
    $form .= '<tr><td>' . _MB_OBITUARIES_PICTURE_WIDTH . "</td><td><input type='text' name='options[]' id='options' value='" . $options[2] . "'></td></tr>\n";
    $form .= "</table>\n";

    return $form;
}

/**
 * @param $options
 * @return array
 */
function b_obituaries_random_show($options)
{
    /** @var Obituaries\Helper $helper */
    $helper = Obituaries\Helper::getInstance();

    $block = [];
    require_once XOOPS_ROOT_PATH . '/modules/obituaries/include/common.php';
    $start = 0;
    $limit = (int)$options[0];

    //    $usersHandler = new Obituaries\UsersHandler($db);
    /** @var Obituaries\UsersHandler $usersHandler */
    $usersHandler = $helper->getHandler('Users');
    $users        = $usersHandler->getRandomObituariess($start, $limit);
    if (count($users) > 0) {
        foreach ($users as $user) {
            $block['obituaries_random_users'][] = $user->toArray();
        }
    }

    $block['obituaries_display_picture'] = (int)$options[1];
    $block['obituaries_picture_width']   = $options[2];

    return $block;
}

/**
 * @param $options
 * @return string
 */
function b_obituaries_random_edit($options)
{
    require_once XOOPS_ROOT_PATH . '/modules/obituaries/include/common.php';
    $form = '';
    $form .= "<table border='0'>";
    $form .= '<tr><td>' . _MB_OBITUARIES_MAX_ITEMS . "</td><td><input type='text' name='options[]' id='options' value='" . $options[0] . "'></td></tr>\n";
    $form .= '<tr><td>' . _MB_OBITUARIES_DISPLAY_PICTURE . "</td><td><input type='radio' id='options[]' name='options[]' value='1'";
    if (1 == $options[1]) {
        $form .= ' checked';
    }
    $form .= '>&nbsp;' . _YES . "<input type='radio' id='options[]' name='options[]' value='0'";
    if (0 == $options[1]) {
        $form .= ' checked';
    }
    $form .= '>&nbsp;' . _NO . "</td></tr>\n";
    $form .= '<tr><td>' . _MB_OBITUARIES_PICTURE_WIDTH . "</td><td><input type='text' name='options[]' id='options' value='" . $options[2] . "'></td></tr>\n";
    $form .= "</table>\n";

    return $form;
}

/**
 * @param $options
 * @return array
 */
function b_obituaries_last_show($options)
{
    /** @var Obituaries\Helper $helper */
    $helper = Obituaries\Helper::getInstance();

    $block = [];
    require_once XOOPS_ROOT_PATH . '/modules/obituaries/include/common.php';
    $start = 0;
    $limit = (int)$options[0];

    if (1 == Obituaries\ObituariesUtils::getModuleOption('userslist_sortorder')) {    // Sort by date
        $sort  = 'obituaries_date';
        $order = 'DESC';
    } else {
        $sort  = 'obituaries_lastname';
        $order = 'ASC';
    }
    //    $usersHandler = new Obituaries\UsersHandler($db);
    /** @var Obituaries\UsersHandler $usersHandler */
    $usersHandler = $helper->getHandler('Users');
    $users        = $usersHandler->getLastObituariess($start, $limit, $sort, $order);

    if (count($users) > 0) {
        foreach ($users as $user) {
            $block['obituaries_last_users'][] = $user->toArray();
        }
    }

    $block['obituaries_display_picture'] = (int)$options[1];
    $block['obituaries_picture_width']   = $options[2];

    return $block;
}

/**
 * @param $options
 * @return string
 */
function b_obituaries_last_edit($options)
{
    require_once XOOPS_ROOT_PATH . '/modules/obituaries/include/common.php';
    $form = '';
    $form .= "<table border='0'>";
    $form .= '<tr><td>' . _MB_OBITUARIES_MAX_ITEMS . "</td><td><input type='text' name='options[]' id='options' value='" . $options[0] . "'></td></tr>\n";
    $form .= '<tr><td>' . _MB_OBITUARIES_DISPLAY_PICTURE . "</td><td><input type='radio' id='options[]' name='options[]' value='1'";
    if (1 == $options[1]) {
        $form .= ' checked';
    }
    $form .= '>&nbsp;' . _YES . "<input type='radio' id='options[]' name='options[]' value='0'";
    if (0 == $options[1]) {
        $form .= ' checked';
    }
    $form .= '>&nbsp;' . _NO . "</td></tr>\n";
    $form .= '<tr><td>' . _MB_OBITUARIES_PICTURE_WIDTH . "</td><td><input type='text' name='options[]' id='options' value='" . $options[2] . "'></td></tr>\n";
    $form .= "</table>\n";

    return $form;
}
