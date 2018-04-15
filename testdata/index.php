<?php
/**
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package
 * @since           2.5.9
 * @author          Michael Beck (aka Mamba)
 */

use XoopsModules\Obituaries;
use XoopsModules\Obituaries\Common;

require_once  dirname(dirname(dirname(__DIR__))) . '/mainfile.php';

include  dirname(__DIR__) . '/preloads/autoloader.php';

$op = \Xmf\Request::getCmd('op', '');

switch ($op) {
    case 'load':
        loadSampleData();
        break;
}

// XMF TableLoad for SAMPLE data

function loadSampleData()
{
    $moduleDirName = basename(dirname(__DIR__));
    $moduleDirNameUpper = strtoupper($moduleDirName); //$capsDirName
    $helper       = Obituaries\Helper::getInstance();
    $utility      = new Obituaries\Utility();
    $configurator = new common\Configurator();
    // Load language files
    $helper->loadLanguage('admin');
    $helper->loadLanguage('modinfo');
    $helper->loadLanguage('common');

    $items = \Xmf\Yaml::readWrapped('obituaries_data.yml');
    \Xmf\Database\TableLoad::truncateTable('users_obituaries');
    \Xmf\Database\TableLoad::loadTableFromArray('users_obituaries', $items);



    //  ---  COPY test folder files ---------------
    if (count($configurator->copyTestFolders) > 0) {
        //        $file =  dirname(__DIR__) . '/testdata/images/';
        foreach (array_keys($configurator->copyTestFolders) as $i) {
            $src  = $configurator->copyTestFolders[$i][0];
            $dest = $configurator->copyTestFolders[$i][1];
            $utility::xcopy($src, $dest);
        }
    }



    redirect_header('../admin/index.php', 0, constant('CO_' . $moduleDirNameUpper . '_SAMPLEDATA_SUCCESS'));
}
