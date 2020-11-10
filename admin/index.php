<?php
/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard (http://www.herve-thouzard.com)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Hervé Thouzard (http://www.herve-thouzard.com)
 * @license         https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @package         Obituaries
 * @author          Hervé Thouzard (http://www.herve-thouzard.com)
 *
 * Version :
 * ****************************************************************************
 */

use Xmf\Module\Admin;
use Xmf\Request;
use Xmf\Yaml;
use XoopsModules\Obituaries;
use XoopsModules\Obituaries\Common;

require_once __DIR__ . '/admin_header.php';
// Display Admin header
xoops_cp_header();

$adminObject = Admin::getInstance();

$a  = dirname(__DIR__) . '/include/common.php';
$b  = realpath(dirname(__DIR__) . '/include/common.php');
$b2 = dirname(__DIR__) . '/include/common.php';
$c  = dirname(__DIR__) . '/include/common.php';

//check for upload folders
$utility      = new Obituaries\Utility();
$configurator = new Common\Configurator();
foreach (array_keys($configurator->uploadFolders) as $i) {
    $utility::createFolder($configurator->uploadFolders[$i]);
    $adminObject->addConfigBoxLine($configurator->uploadFolders[$i], 'folder');
}

$modStats    = [];
$moduleStats = $utility::getModuleStats($configurator, $modStats);

$adminObject->addInfoBox(constant('CO_' . $moduleDirNameUpper . '_' . 'STATS_SUMMARY'));
if ($moduleStats && is_array($moduleStats)) {
    foreach ($moduleStats as $key => $value) {
        switch ($key) {
            case 'totalcategories':
                $ret = '<span style=\'font-weight: bold; color: green;\'>' . $value . '</span>';
                $adminObject->addInfoBoxLine(sprintf($ret . ' ' . constant('CO_' . $moduleDirNameUpper . '_' . 'TOTAL_CATEGORIES')));
                break;
            case 'totalitems':
                $ret = '<span style=\'font-weight: bold; color: green;\'>' . $value . '</span>';
                $adminObject->addInfoBoxLine(sprintf($ret . ' ' . constant('CO_' . $moduleDirNameUpper . '_' . 'TOTAL_ITEMS')));
                break;
            case 'totaloffline':
                $ret = '<span style=\'font-weight: bold; color: red;\'>' . $value . '</span>';
                $adminObject->addInfoBoxLine(sprintf($ret . ' ' . constant('CO_' . $moduleDirNameUpper . '_' . 'TOTAL_OFFLINE')));
                break;
            case 'totalpublished':
                $ret = '<span style=\'font-weight: bold; color: green;\'>' . $value . '</span>';
                $adminObject->addInfoBoxLine(sprintf($ret . ' ' . constant('CO_' . $moduleDirNameUpper . '_' . 'TOTAL_PUBLISHED')));
                break;
            case 'totalrejected':
                $ret = '<span style=\'font-weight: bold; color: red;\'>' . $value . '</span>';
                $adminObject->addInfoBoxLine(sprintf($ret . ' ' . constant('CO_' . $moduleDirNameUpper . '_' . 'TOTAL_REJECTED')));
                break;
            case 'totalsubmitted':
                $ret = '<span style=\'font-weight: bold; color: green;\'>' . $value . '</span>';
                $adminObject->addInfoBoxLine(sprintf($ret . ' ' . constant('CO_' . $moduleDirNameUpper . '_' . 'TOTAL_SUBMITTED')));
                break;
        }
    }
}

$adminObject->displayNavigation(basename(__FILE__));

//check for latest release
//$newRelease = $utility::checkVerModule($helper);
//if (!empty($newRelease)) {
//    $adminObject->addItemButton($newRelease[0], $newRelease[1], 'download', 'style="color : Red"');
//}

//------------- Test Data ----------------------------

if ($helper->getConfig('displaySampleButton')) {
    $yamlFile            = dirname(__DIR__) . '/config/admin.yml';
    $config              = loadAdminConfig($yamlFile);
    $displaySampleButton = $config['displaySampleButton'];

    if (1 == $displaySampleButton) {
        xoops_loadLanguage('admin/modulesadmin', 'system');
        require_once dirname(__DIR__) . '/testdata/index.php';

        $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA'), './../testdata/index.php?op=load', 'add');
        $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA'), './../testdata/index.php?op=save', 'add');
        $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'HIDE_SAMPLEDATA_BUTTONS'), '?op=hide_buttons', 'delete');
    } else {
        $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLEDATA_BUTTONS'), '?op=show_buttons', 'add');
        $displaySampleButton = $config['displaySampleButton'];
    }
    $adminObject->displayButton('left', '');
}

//------------- End Test Data ----------------------------

$adminObject->displayIndex();

/**
 * @param $yamlFile
 * @return array|bool
 */
function loadAdminConfig($yamlFile)
{
    $config = Yaml::readWrapped($yamlFile); // work with phpmyadmin YAML dumps
    return $config;
}

/**
 * @param $yamlFile
 */
function hideButtons($yamlFile)
{
    $app['displaySampleButton'] = 0;
    Yaml::save($app, $yamlFile);
    redirect_header('index.php', 0, '');
}

/**
 * @param $yamlFile
 */
function showButtons($yamlFile)
{
    $app['displaySampleButton'] = 1;
    Yaml::save($app, $yamlFile);
    redirect_header('index.php', 0, '');
}

$op = Request::getString('op', 0, 'GET');

switch ($op) {
    case 'hide_buttons':
        hideButtons($yamlFile);
        break;
    case 'show_buttons':
        showButtons($yamlFile);
        break;
}

echo $utility::getServerStats();

require __DIR__ . '/admin_footer.php';

