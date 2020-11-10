<?php
/**
 * Obituaries module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright           XOOPS Project (https://xoops.org)
 * @license             https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @package             Obituaries
 * @since               2.5.0
 * @author              XOOPS Module Team
 **/

use Xmf\Module\Admin;
use XoopsModules\Obituaries;

require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';

require_once dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName); //$capsDirName

/** @var Obituaries\Helper $helper */
$helper = Obituaries\Helper::getInstance();
/** @var Xmf\Module\Admin $adminObject */
$adminObject   = Admin::getInstance();
$pathIcon16    = Admin::iconUrl('', 16);
$pathIcon32    = Admin::iconUrl('', 32);
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');

// Load language files
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('common');

$myts = \MyTextSanitizer::getInstance();

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof \XoopsTpl)) {
    require_once $GLOBALS['xoops']->path('class/template.php');
    $xoopsTpl = new \XoopsTpl();
}
