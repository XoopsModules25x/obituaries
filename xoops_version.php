<?php
// defined('XOOPS_ROOT_PATH') || exit('Restricted access');

use XoopsModules\Obituaries;

require_once __DIR__ . '/preloads/autoloader.php';

$moduleDirName      = basename(__DIR__);
$moduleDirNameUpper = mb_strtoupper($moduleDirName); //$capsDirName

/** @var \XoopsModules\Obituaries\Helper $helper */
$helper = \XoopsModules\Obituaries\Helper::getInstance();
//$helper->loadLanguage('common');
xoops_loadLanguage('common', $moduleDirName);

$modversion['version']             = 2.40;
$modversion['module_status']       = 'Beta 1';
$modversion['release_date']        = '2017/11/23';
$modversion['name']                = _MI_OBITUARIES_TITRE;
$modversion['description']         = _MI_OBITUARIES_DESC;
$modversion['author']              = 'Mariane Antoun based on Birthday module by Herve Thouzard';
$modversion['credits']             = 'XOOPS Project';
$modversion['help']                = 'page=help';
$modversion['license']             = 'GNU GPL 2.0';
$modversion['license_url']         = 'www.gnu.org/licenses/gpl-2.0.html';
$modversion['official']            = 0; //1 indicates supported by XOOPS Dev Team, 0 means 3rd party supported
$modversion['image']               = 'assets/images/logoModule.png';
$modversion['dirname']             = basename(__DIR__);
$modversion['modicons16']          = 'assets/images/icons/16';
$modversion['modicons32']          = 'assets/images/icons/32';
$modversion['module_website_url']  = 'www.xoops.org/';
$modversion['module_website_name'] = 'XOOPS';
$modversion['min_php']             = '5.6';
$modversion['min_xoops']           = '2.5.10';
$modversion['min_admin']           = '1.2';
$modversion['min_db']              = ['mysql' => '5.5'];

// ********************************************************************************************************************
// Administration *****************************************************************************************************
// ********************************************************************************************************************
$modversion['hasAdmin']    = 1;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';
$modversion['system_menu'] = 1;

// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    ['name' => _MI_OBITUARIES_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_OBITUARIES_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => _MI_OBITUARIES_LICENSE, 'link' => 'page=license'],
    ['name' => _MI_OBITUARIES_SUPPORT, 'link' => 'page=support'],
];

//Install/Uninstall Functions
$modversion['onInstall']   = 'include/oninstall.php';
$modversion['onUpdate']    = 'include/onupdate.php';
$modversion['onUninstall'] = 'include/onuninstall.php';

// ********************************************************************************************************************
// Blocks *************************************************************************************************************
// ********************************************************************************************************************

$modversion['blocks'][] = [
    'file'        => 'b_obituaries.php',
    'name'        => _MI_OBITUARIES_TITRE,
    'description' => '_MI_OBITUARIES_DESC',
    'show_func'   => 'b_obituaries_show',
    'edit_func'   => 'b_obituaries_edit',
    'options'     => '5|0|130',
    'template'    => 'obituaries_block_obituaries.tpl',
];

$modversion['blocks'][] = [
    'file'        => 'b_obituaries.php',
    'name'        => _MI_OBITUARIES_RANDOM,
    'description' => '_MI_BD_RANDOM_DESC',
    'show_func'   => 'b_obituaries_random_show',
    'edit_func'   => 'b_obituaries_random_edit',
    'options'     => '5|0|130',
    'template'    => 'obituaries_block_random_obituaries.tpl',
];

$modversion['blocks'][] = [
    'file'        => 'b_obituaries.php',
    'name'        => _MI_OBITUARIES_LAST,
    'description' => '_MI_BD_LAST_DESC',
    'show_func'   => 'b_obituaries_last_show',
    'edit_func'   => 'b_obituaries_last_edit',
    'options'     => '5|0|130',
    'template'    => 'obituaries_block_last_obituaries.tpl',
];

// ********************************************************************************************************************
// Search *************************************************************************************************************
// ********************************************************************************************************************
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'obituaries_search';

// ********************************************************************************************************************
// Templates **********************************************************************************************************
// ********************************************************************************************************************
$cptt = 0;

++$cptt;
$modversion['templates'][$cptt]['file']        = 'obituaries_index.tpl';
$modversion['templates'][$cptt]['description'] = 'Index page';

++$cptt;
$modversion['templates'][$cptt]['file']        = 'obituaries_user.tpl';
$modversion['templates'][$cptt]['description'] = 'Display a user page';

++$cptt;
$modversion['templates'][$cptt]['file']        = 'obituaries_users.tpl';
$modversion['templates'][$cptt]['description'] = 'List of Users';

// ********************************************************************************************************************
// Menu ***************************************************************************************************************
// ********************************************************************************************************************
$modversion['hasMain'] = 1;

// ********************************************************************************************************************
// Tables *************************************************************************************************************
// ********************************************************************************************************************
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0]        = 'users_obituaries';

// ********************************************************************************************************************
// Preferences ********************************************************************************************************
// ********************************************************************************************************************
$cpto = 0;

/**
 * Images width
 */
$modversion['config'][] = [
    'name'        => 'images_width',
    'title'       => '_MI_OBITUARIES_IMAGES_WIDTH',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 150,
];

/**
 * Images height
 */
$modversion['config'][] = [
    'name'        => 'images_height',
    'title'       => '_MI_OBITUARIES_IMAGES_HEIGHT',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 150,
];

/**
 * Folder's path (where to save pictures)
 */
$modversion['config'][] = [
    'name'        => 'folder_path',
    'title'       => '_MI_OBITUARIES_FOLDER_PATH',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => XOOPS_UPLOAD_PATH . '/' . basename(__DIR__) . '/images',
];

/**
 * Folder's url (where to save pictures)
 */
$modversion['config'][] = [
    'name'        => 'folder_url',
    'title'       => '_MI_OBITUARIES_FOLDER_URL',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => XOOPS_UPLOAD_URL . '/' . basename(__DIR__) . '/images',
];

/**
 * Items count per page
 */
$modversion['config'][] = [
    'name'        => 'perpage',
    'title'       => '_MI_OBITUARIES_PERPAGE',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 15,
];

/**
 * Mime Types
 * Default values : Web pictures (png, jpeg)
 */
//$modversion['config'][] = [
//    'name'        => 'mimetypes',
//    'title'       => '_MI_OBITUARIES_MIMETYPES',
//    'description' => '',
//    'formtype'    => 'textarea',
//    'valuetype'   => 'text',
//    'default'     => "image/jpeg\nimage/pjpeg\nimage/x-png\nimage/png",
//];

//Uploads : mimetypes of images
$modversion['config'][] = [
    'name'        => 'mimetypes',
    'title'       => '_MI_OBITUARIES_MIMETYPES',
    'description' => '',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'default'     => ['image/gif', 'image/jpeg', 'image/png', 'image/jpg'],
    'options'     => [
        'bmp'   => 'image/bmp',
        'gif'   => 'image/gif',
        'pjpeg' => 'image/pjpeg',
        'jpeg'  => 'image/jpeg',
        'jpg'   => 'image/jpg',
        'jpe'   => 'image/jpe',
        'png'   => 'image/png',
    ],
];

/**
 * MAX Filesize Upload in kilo bytes
 */
$modversion['config'][] = [
    'name'        => 'maxuploadsize',
    'title'       => '_MI_OBITUARIES_UPLOADFILESIZE',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 1048576,
];

/**
 * Editor to use
 */
xoops_load('XoopsEditorHandler');
$editorHandler = \XoopsEditorHandler::getInstance();
$editorList    = array_flip($editorHandler->getList());

$modversion['config'][] = [
    'name'        => 'form_options',
    'title'       => '_MI_BIRTHDAY_FORM_OPTIONS',
    'description' => '_MI_BIRTHDAY_FORM_OPTIONS_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => $editorList,
    'default'     => 'dhtml',
];

/**
 * Sort order
 */
$modversion['config'][] = [
    'name'        => 'userslist_sortorder',
    'title'       => '_MI_OBITUARIES_SORT_ORDER',
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'options'     => [
        _MI_OBITUARIES_SORT_ORDER1 => 1,
        _MI_OBITUARIES_SORT_ORDER2 => 2,
    ],
    'default'     => 1,
];

/**
 * Make Sample button visible?
 */
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => '_MI_OBITUARIES_SHOW_SAMPLE_BUTTON',
    'description' => '_MI_OBITUARIES_SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

// ********************************************************************************************************************
// Comments ***********************************************************************************************************
// ********************************************************************************************************************
$modversion['hasComments']          = 1;
$modversion['comments']['itemName'] = 'obituaries_id';
$modversion['comments']['pageName'] = 'user.php';

// Comment callback functions
$modversion['comments']['callbackFile']        = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'obituaries_com_approve';
$modversion['comments']['callback']['update']  = 'obituaries_com_update';

$modversion['config'][] = [
    'name'        => 'title1',
    'title'       => 'CO_' . $moduleDirNameUpper . '_TITLE1',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => constant('CO_' . $moduleDirNameUpper . '_TITLE1'),
];

$modversion['config'][] = [
    'name'        => 'title2',
    'title'       => 'CO_' . $moduleDirNameUpper . '_TITLE2',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => constant('CO_' . $moduleDirNameUpper . '_TITLE2'),
];

$modversion['config'][] = [
    'name'        => 'title3',
    'title'       => 'CO_' . $moduleDirNameUpper . '_TITLE3',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => constant('CO_' . $moduleDirNameUpper . '_TITLE3'),
];

$modversion['config'][] = [
    'name'        => 'title4',
    'title'       => 'CO_' . $moduleDirNameUpper . '_TITLE4',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => constant('CO_' . $moduleDirNameUpper . '_TITLE4'),
];
