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

use XoopsModules\Obituaries;
use XoopsModules\Obituaries\Common;

require_once __DIR__ . '/admin_header.php';
// Display Admin header
xoops_cp_header();

$adminObject = \Xmf\Module\Admin::getInstance();

$a  = dirname(__DIR__) . '/include/common.php';
$b  = realpath(__DIR__ . '/../include/common.php');
$b2 = dirname(__DIR__) . '/include/common.php';
$c  = dirname(__DIR__) . '/include/common.php';

//check for upload folders
$utility      = new Obituaries\Utility();
$configurator = new Common\Configurator();
foreach (array_keys($configurator->uploadFolders) as $i) {
    $utility::createFolder($configurator->uploadFolders[$i]);
    $adminObject->addConfigBoxLine($configurator->uploadFolders[$i], 'folder');
}

$adminObject->displayNavigation(basename(__FILE__));


//check for latest release
$newRelease = $utility::checkVerModule($helper);
if (!empty($newRelease)) {
    $adminObject->addItemButton($newRelease[0], $newRelease[1], 'download', 'style="color : Red"');
}

//------------- Test Data ----------------------------

if ($helper->getConfig('displaySampleButton')) {
    xoops_loadLanguage('admin/modulesadmin', 'system');
    require_once dirname(__DIR__) . '/testdata/index.php';

    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA'), './../testdata/index.php?op=load', 'add');

    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA'), './../testdata/index.php?op=save', 'add');

    //    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA'), './../testdata/index.php?op=exportschema', 'add');

    $adminObject->displayButton('left', '');
}

//------------- End Test Data ----------------------------

$adminObject->displayIndex();

echo $utility::getServerStats();

require_once __DIR__ . '/admin_footer.php';
