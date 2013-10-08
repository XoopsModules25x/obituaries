<?php
/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Copyright (c) Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 * Created on 10 juil. 08 at 11:38:52
 * Version : $Id:
 * ****************************************************************************
 */
require_once '../../../include/cp_header.php';
require_once '../include/common.php';
require_once XOOPS_ROOT_PATH.'/class/pagenav.php';
require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
include_once 'admin_header.php';

$indexAdmin = new ModuleAdmin();

$op = 'default';
if (isset($_POST['op'])) {
	$op = $_POST['op'];
} elseif ( isset($_GET['op'])) {
   	$op = $_GET['op'];
}

// Lecture de certains param�tres de l'application ********************************************************************
$limit = obituaries_utils::getModuleOption('perpage');	// Nombre maximum d'�l�ments � afficher
$baseurl = OBITUARIES_URL.'admin/'.basename(__FILE__);	// URL de ce script
$conf_msg = obituaries_utils::javascriptLinkConfirm(_AM_OBITUARIES_CONF_DELITEM);
$images_width = obituaries_utils::getModuleOption('images_width');
$images_height = obituaries_utils::getModuleOption('images_height');
$destname = '';

$cacheFolder = XOOPS_UPLOAD_PATH.'/'.OBITUARIES_DIRNAME;
if(!is_dir($cacheFolder)) {
	mkdir($cacheFolder, 0777);
    file_put_contents($cacheFolder.'/index.html', '<script>history.go(-1);</script>');
}


switch($op)
{
    // ****************************************************************************************************************
    case 'default':    // List obituariess and show form to add a someone
    // ****************************************************************************************************************
        xoops_cp_header();
        // echo '<h1>'.obituaries_utils::getModuleName().'</h1>';
        echo $indexAdmin->addNavigation('main.php');
        $start = isset($_GET['start']) ? intval($_GET['start']) : 0;
        $itemsCount = $hBdUsersObituaries->getCount();
        if($itemsCount > $limit) {
            $pagenav = new XoopsPageNav($itemsCount, $limit, $start, 'start');
        }
		if(isset($pagenav) && is_object($pagenav)) {
			echo "<div align='right'>".$pagenav->renderNav()."</div>";
		}
		if($itemsCount > 0) {
		    $class = '';
//		    $items = $hBdUsersObituaries->getItems($start, $limit, 'obituaries_lastname');

            $tblItems = array();
            		//$critere = new Criteria($this->keyName, 0 ,'<>');
                    $critere = new Criteria('obituaries_id', 0 ,'<>');
            		$critere->setLimit($limit);
            		$critere->setStart($start);
            		$critere->setSort('obituaries_lastname');
//            		$critere->setOrder($order);
//            		$tblItems = $this->getObjects($critere, $idAsKey);
            $items = $hBdUsersObituaries->getObjects($start, $limit, 'obituaries_lastname');


		    echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
            echo "<tr><th align='center'>"._AM_OBITUARIES_DATE."</th><th align='center'>"._AM_OBITUARIES_USERNAME."</th><th align='center'>"._AM_OBITUARIES_LASTNAME.',  '._AM_OBITUARIES_FIRSTNAME."</th><th align='center'>"._AM_OBITUARIES_ACTION."</th></tr>";
		    foreach ($items as $item) {
    			$class = ($class == 'even') ? 'odd' : 'even';
			    $id = $item->getVar('obituaries_id');
			    $user = null;
			    $user = $item->getXoopsUser();
			    $uname = '';
   			    if(is_object($user)) {
			        $uname = $user->getVar('uname');
    			}
			    $action_edit = "<a href='$baseurl?op=edit&id=".$id."' title='"._EDIT."'>".$birdthday_icones['edit'].'</a>';
			    $action_delete = "<a href='$baseurl?op=delete&id=".$id."' title='"._DELETE."'".$conf_msg.">".$birdthday_icones['delete'].'</a>';

			    echo "<tr class='".$class."'>\n";
			    echo "<td align='center'>".obituaries_utils::SQLDateToHuman($item->getVar('obituaries_date'))."</td>";
			    echo "<td align='center'>".$uname.'</td>';
			    echo "<td align='center'>".$item->getFullName().'</td>';
			    echo "<td align='center'>".$action_edit.' '.$action_delete.'</td>';
                echo "</tr>\n";
            }
		    echo "</table>\n";
		    if(isset($pagenav) && is_object($pagenav)) {
    			echo "<div align='left'>".$pagenav->renderNav()."</div>";
		    }
		    echo "<br /><br />\n";
		}
        $item = $hBdUsersObituaries->create(true);
        $form = $hBdUsersObituaries->getForm($item, $baseurl);
        $form->display();
        break;

    // ****************************************************************************************************************
    case 'maintain':    // Maintenance des tables et du cache
    // ****************************************************************************************************************
    	xoops_cp_header();
        echo $indexAdmin->addNavigation('main.php');
    	require_once '../xoops_version.php';
    	$tables = array();
		foreach ($modversion['tables'] as $table) {
			$tables[] = $xoopsDB->prefix($table);
		}
		if(count($tables) > 0) {
			$list = implode(',', $tables);
			$xoopsDB->queryF('CHECK TABLE '.$list);
			$xoopsDB->queryF('ANALYZE TABLE '.$list);
			$xoopsDB->queryF('OPTIMIZE TABLE '.$list);
		}
		obituaries_utils::updateCache();
		$hBdUsersObituaries->forceCacheClean();
		obituaries_utils::redirect(_AM_OBITUARIES_SAVE_OK, $baseurl, 2);
    	break;

    // ****************************************************************************************************************
    case 'edit':    // Edition d'un utilisateur existant
    // ****************************************************************************************************************
    	xoops_cp_header();
        echo $indexAdmin->addNavigation('main.php');
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if(empty($id)) {
			obituaries_utils::redirect(_AM_OBITUARIES_ERROR_1, $baseurl, 5);
		}
		// Item exits ?
		$item = null;
		$item = $hBdUsersObituaries->get($id);
		if(!is_object($item)) {
			obituaries_utils::redirect(_AM_OBITUARIES_NOT_FOUND, $baseurl, 5);
		}
        $form = $hBdUsersObituaries->getForm($item, $baseurl);
        $form->display();
        break;

    // ****************************************************************************************************************
    case 'saveedit':    // Enregistrement des modifications
    // ****************************************************************************************************************
    	xoops_cp_header();
        echo $indexAdmin->addNavigation('main.php');
        $result = $hBdUsersObituaries->saveUser();
        if($result) {
            obituaries_utils::redirect(_AM_OBITUARIES_SAVE_OK, $baseurl, 1);
        } else {
            obituaries_utils::redirect(_AM_OBITUARIES_SAVE_PB, $baseurl, 3);
        }
        break;

    // ****************************************************************************************************************
    case 'delete':    // Suppression d'un utilisateur
    // ****************************************************************************************************************
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if(empty($id)) {
			obituaries_utils::redirect(_AM_OBITUARIES_ERROR_1, $baseurl, 5);
		}
		// Item exits ?
		$item = null;
		$item = $hBdUsersObituaries->get($id);
		if(!is_object($item)) {
			obituaries_utils::redirect(_AM_OBITUARIES_NOT_FOUND, $baseurl, 5);
		}
		$result = $hBdUsersObituaries->deleteUser($item);
        if($result) {
            obituaries_utils::redirect(_AM_OBITUARIES_SAVE_OK, $baseurl, 1);
        } else {
            obituaries_utils::redirect(_AM_OBITUARIES_SAVE_PB, $baseurl, 3);
        }

}
xoops_cp_footer();
?>