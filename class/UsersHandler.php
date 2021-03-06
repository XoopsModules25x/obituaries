<?php

namespace XoopsModules\Obituaries;

/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * Created on 10 juil. 08 at 13:27:45
 * Version :
 * ****************************************************************************
 */

use Xmf\Request;

/** @var Helper $helper */
/** @var Users $item */

$helper = Helper::getInstance();



require_once XOOPS_ROOT_PATH . '/kernel/object.php';
//if (!class_exists('Obituaries_XoopsPersistableObjectHandler')) {
//  require_once XOOPS_ROOT_PATH.'/modules/obituaries/class/PersistableObjectHandler.php';
//}

/**
 * Class UsersHandler
 */
class UsersHandler extends \XoopsPersistableObjectHandler //Obituaries_XoopsPersistableObjectHandler
{
    /**
     * UsersHandler constructor.
     * @param null|\XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {    //                             Table           Classe          Id              Description
        parent::__construct($db, 'users_obituaries', Users::class, 'obituaries_id', 'obituaries_lastname');
    }

    /**
     * Retourne un utilisateur ŕ partir de son uid
     *
     * @param int $uid L'ID Xoops recherché
     * @return object
     */
    public function getFromUid($uid)
    {
        $criteria = new \Criteria('obituaries_uid', (int)$uid, '=');
        if ($this->getCount($criteria) > 0) {
            $temp = [];
            $temp = $this->getObjects($criteria);
            if (\count($temp) > 0) {
                return $temp[0];
            }
        }

        return $this->create(true);
    }

    /**
     * Création du formulaire de saisie
     *
     * @param Users   $item           L'élément ŕ ajouter/modifier
     * @param string  $baseurl        L'url de destination
     * @param boolean $withUserSelect Indique s'il faut inclure la liste de sélection de l'utilisateur
     * @return \XoopsThemeForm Le formulaire ŕ utiliser
     */
    public function getForm(Users $item, $baseurl, $withUserSelect = true)
    {
        require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        require_once XOOPS_ROOT_PATH . '/modules/obituaries/class/FormTextDateSelect.php';
        $helper = Helper::getInstance();

        $edit = true;
        if ($item->isNew()) {
            $edit = false;
        }

        if ($edit) {
            $labelSubmit = _AM_OBITUARIES_MODIFY;
            $title       = _AM_OBITUARIES_MODIFY_ITEM;
        } else {
            $labelSubmit = _AM_OBITUARIES_ADD;
            $title       = _AM_OBITUARIES_ADD_ITEM;
        }
        // Formulaire de création
        $sform = new \XoopsThemeForm($title, 'frmadd', $baseurl);
        $sform->setExtra('enctype="multipart/form-data"');
        $sform->addElement(new \XoopsFormHidden('op', 'saveedit'));
        $sform->addElement(new \XoopsFormHidden('obituaries_id', $item->getVar('obituaries_id')));
        if ($withUserSelect) {
            $selectUser = new \XoopsFormSelectUser(_AM_OBITUARIES_USERNAME, 'obituaries_uid', true, $item->getVar('obituaries_uid', 'e'));
            $selectUser->setDescription(_AM_OBITUARIES_USE_ANONYMOUS);
            $sform->addElement($selectUser);
        }
        $date = \strtotime($item->getVar('obituaries_date'));
        $sform->addElement(new \XoopsFormTextDateSelect(_AM_OBITUARIES_DATE, 'obituaries_date', 15, $date));
        $sform->addElement(new \XoopsFormText(_AM_OBITUARIES_FIRSTNAME, 'obituaries_firstname', 50, 150, $item->getVar('obituaries_firstname', 'e')), false);
        $sform->addElement(new \XoopsFormText(_AM_OBITUARIES_LASTNAME, 'obituaries_lastname', 50, 150, $item->getVar('obituaries_lastname', 'e')), false);

        //      $editor1 = ObituariesUtils::getWysiwygForm(_OBITUARIES_DESCRIPTION, 'obituaries_description', $item->getVar('obituaries_description', 'e'), 15, 60, 'description_hidden');
        //        $editor2 = ObituariesUtils::getWysiwygForm(_OBITUARIES_SURVIVORS, 'obituaries_survivors', $item->getVar('obituaries_survivors', 'e'), 15, 60, 'survivors_hidden');
        //      $editor3 = ObituariesUtils::getWysiwygForm(_OBITUARIES_SERVICE, 'obituaries_service', $item->getVar('obituaries_service', 'e'), 15, 60, 'service_hidden');
        //      $editor4 = ObituariesUtils::getWysiwygForm(_OBITUARIES_MEMORIAL, 'obituaries_memorial', $item->getVar('obituaries_memorial', 'e'), 15, 60, 'memorial_hidden');
        //      if ($editor1) {
        //            $sform->addElement($editor1, false);
        //        }
        //        if ($editor2) {
        //            $sform->addElement($editor2, false);
        //        }
        //        if ($editor3) {
        //            $sform->addElement($editor3, false);
        //        }
        //        if ($editor4) {
        //            $sform->addElement($editor4, false);
        //        }
        //

        $helper = Helper::getInstance();

        //        $options_tray1 = new \XoopsFormElementTray(_AM_OBITUARIES_DESCRIPTION, '<br>');
        $options_tray1 = new \XoopsFormElementTray($helper->getConfig('title1'), '<br>');

        if (\class_exists('XoopsFormEditor')) {
            $options['name']        = 'obituaries_description';
            $options['value']       = $item->getVar('obituaries_description', 'e');
            $options['rows']        = 10;
            $options['cols']        = '100%';
            $options['width']       = '100%';
            $options['height']      = '600px';
            $obituaries_description = new \XoopsFormEditor('', $helper->getConfig('form_options'), $options, $nohtml = false, $onfailure = 'textarea');
            $options_tray1->addElement($obituaries_description);
        } else {
            $obituaries_description = new \XoopsFormDhtmlTextArea('', 'obituaries_description', $item->getVar('obituaries_description', 'e'), '100%', '100%');
            $options_tray1->addElement($obituaries_description);
        }
        $sform->addElement($options_tray1);

        //        $options_tray2 = new \XoopsFormElementTray(_AM_OBITUARIES_SURVIVORS, '<br>');
        $options_tray2 = new \XoopsFormElementTray($helper->getConfig('title2'), '<br>');
        if (\class_exists('XoopsFormEditor')) {
            $options['name']      = 'obituaries_survivors';
            $options['value']     = $item->getVar('obituaries_survivors', 'e');
            $options['rows']      = 10;
            $options['cols']      = '100%';
            $options['width']     = '100%';
            $options['height']    = '600px';
            $obituaries_survivors = new \XoopsFormEditor('', $helper->getConfig('form_options'), $options, $nohtml = false, $onfailure = 'textarea');
            $options_tray2->addElement($obituaries_survivors);
        } else {
            $obituaries_survivors = new \XoopsFormDhtmlTextArea('', 'contents_contents', $item->getVar('obituaries_survivors', 'e'), '100%', '100%');
            $options_tray2->addElement($obituaries_survivors);
        }
        $sform->addElement($options_tray2);

        //        $options_tray3 = new \XoopsFormElementTray(_AM_OBITUARIES_SERVICE, '<br>');
        $options_tray3 = new \XoopsFormElementTray($helper->getConfig('title3'), '<br>');
        if (\class_exists('XoopsFormEditor')) {
            $options['name']    = 'obituaries_service';
            $options['value']   = $item->getVar('obituaries_service', 'e');
            $options['rows']    = 10;
            $options['cols']    = '100%';
            $options['width']   = '100%';
            $options['height']  = '600px';
            $obituaries_service = new \XoopsFormEditor('', $helper->getConfig('form_options'), $options, $nohtml = false, $onfailure = 'textarea');
            $options_tray3->addElement($obituaries_service);
        } else {
            $obituaries_service = new \XoopsFormDhtmlTextArea('', 'obituaries_service', $item->getVar('obituaries_service', 'e'), '100%', '100%');
            $options_tray3->addElement($obituaries_service);
        }
        $sform->addElement($options_tray3);

        //        $options_tray4 = new \XoopsFormElementTray(_AM_OBITUARIES_MEMORIAL, '<br>');
        $options_tray4 = new \XoopsFormElementTray($helper->getConfig('title4'), '<br>');
        if (\class_exists('XoopsFormEditor')) {
            $options['name']     = 'obituaries_memorial';
            $options['value']    = $item->getVar('obituaries_memorial', 'e');
            $options['rows']     = 10;
            $options['cols']     = '100%';
            $options['width']    = '100%';
            $options['height']   = '600px';
            $obituaries_memorial = new \XoopsFormEditor('', $helper->getConfig('form_options'), $options, $nohtml = false, $onfailure = 'textarea');
            $options_tray4->addElement($obituaries_memorial);
        } else {
            $obituaries_memorial = new \XoopsFormDhtmlTextArea('', 'obituaries_memorial', $item->getVar('obituaries_memorial', 'e'), '100%', '100%');
            $options_tray4->addElement($obituaries_memorial);
        }

        $sform->addElement($options_tray4);

        if ($edit && '' != \trim($item->getVar('obituaries_photo')) && $item->pictureExists()) {
            $pictureTray = new \XoopsFormElementTray(_AM_OBITUARIES_CURRENT_PICTURE, '<br>');
            $pictureTray->addElement(new \XoopsFormLabel('', "<img src='" . $item->getPictureUrl() . "' alt='' border='0'>"));
            $deleteCheckbox = new \XoopsFormCheckBox('', 'delpicture');
            $deleteCheckbox->addOption(1, _DELETE);
            $pictureTray->addElement($deleteCheckbox);
            $sform->addElement($pictureTray);
            unset($pictureTray, $deleteCheckbox);
        }
        $sform->addElement(new \XoopsFormFile(_AM_OBITUARIES_PICTURE, 'attachedfile', ObituariesUtils::getModuleOption('maxuploadsize')), false);

        $buttonTray = new \XoopsFormElementTray('', '');
        $submit_btn = new \XoopsFormButton('', 'post', $labelSubmit, 'submit');
        $buttonTray->addElement($submit_btn);
        $sform->addElement($buttonTray);
        $sform = ObituariesUtils::formMarkRequiredFields($sform);

        return $sform;
    }

    /**
     * Enregistre un utilisateur aprčs modification (ou ajout)
     *
     * @param bool $withCurrentUser Indique s'il faut prendre l'utilisateur courant ou pas
     * @return bool Vrai si l'enregistrement a réussi sinon faux
     */
    public function saveUser($withCurrentUser = false)
    {
        global $destname;
        $images_width  = ObituariesUtils::getModuleOption('images_width');
        $images_height = ObituariesUtils::getModuleOption('images_height');
        $id            = Request::getInt('obituaries_id', 0, 'POST');
        if (!empty($id)) {
            $edit = true;
            $item = $this->get($id);
            if (!\is_object($item)) {
                return false;
            }
            $item->unsetNew();
        } else {
            $edit = false;
            $item = $this->create(true);
        }
        $item->setVars($_POST);
        if ($withCurrentUser) {
            global $xoopsUser;
            $item->setVar('obituaries_uid', $xoopsUser->getVar('uid'));
        }
        if (Request::hasVar('delpicture', 'POST') && 1 == Request::getInt('delpicture', 0, 'POST')) {
            if ('' != \trim($item->getVar('obituaries_photo')) && $item->pictureExists()) {
                $item->deletePicture();
            }
            $item->setVar('obituaries_photo', '');
        }

        $uploadFolder = ObituariesUtils::getModuleOption('folder_path');

        $return = ObituariesUtils::uploadFile(0, $uploadFolder);
        if (true === $return) {
            $newDestName = ObituariesUtils::createUploadName($uploadFolder, \basename($destname), true);

            $retval = ObituariesUtils::resizePicture($uploadFolder . '/' . $destname, $uploadFolder . '/' . $newDestName, $images_width, $images_height);
            if (1 == $retval || 3 == $retval) {
                $item->setVar('obituaries_photo', $newDestName);
            }
        } else {
            if (false !== $return) {
                echo $return;
            }
        }

        $tempDate = \date(_SHORTDATESTRING, \strtotime(Request::getString('obituaries_date', '', 'POST')));

        $item->setVar('obituaries_date', $tempDate);

        $res = $this->insert($item);
        if ($res) {
            ObituariesUtils::updateCache();
        }

        return $res;
    }

    /**
     * Suppression d'un utilisateur
     *
     * @param Users $user L'utilisateur ŕ supprimer
     * @return bool          Le résultat de la suppression
     */
    public function deleteUser(Users $user)
    {
        $user->deletePicture();
        $res = $this->delete($user, true);
        if ($res) {
            ObituariesUtils::updateCache();
        }

        return $res;
    }

    /**
     * Mise ŕ jour du compteur de commentaires pour un utilisateur
     *
     * @param int $userId
     * @param int $commentsCount
     * @internal param int $total_num
     */
    public function updateCommentsCount($userId, $commentsCount)
    {
        $userId        = (int)$userId;
        $commentsCount = (int)$commentsCount;
        $user          = null;
        $user          = $this->get($userId);
        if (\is_object($user)) {
            $criteria = new \Criteria('obituaries_id', $userId, '=');
            $this->updateAll('prod_comments', $commentsCount, $criteria, true);
        }
    }

    /**
     * Retourne les anniversaires du jour
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array Objets de type Users
     */
    public function getTodayObituariess($start = 0, $limit = 0, $sort = 'obituaries_lastname', $order = 'ASC')
    {
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('day(obituaries_date)', \date('j'), '='));
        $criteria->add(new \Criteria('month(obituaries_date)', \date('n'), '='));
        $criteria->setStart($start);
        if ($limit > 0) {
            $criteria->setLimit($limit);
        }
        $criteria->setSort($sort);
        $criteria->setOrder($order);

        return $this->getObjects($criteria);
    }

    /**
     * Return random obituarues
     * @param int $start
     * @param int $limit
     * @return array Objets de type Users
     */
    public function getRandomObituariess($start = 0, $limit = 0)
    {
        //disable cache for this one
//        $this->setCachingOptions(['caching' => false]);

        $criteria = new \CriteriaCompo(null);
        $criteria->setStart($start);
        if ($limit > 0) {
            $criteria->setLimit($limit);
        }
        $criteria->setSort('rand()');

        return $this->getObjects($criteria);
    }

    /**
     * Return last obituarues
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array Objets de type Users
     */
    public function getLastObituariess($start = 0, $limit = 0, $sort = 'obituaries_date', $order = 'DESC')
    {
        $criteria = new \CriteriaCompo();
        $criteria->setStart($start);
        if ($limit > 0) {
            $criteria->setLimit($limit);
        }
        $criteria->setSort($sort);
        $criteria->setOrder($order);

        return $this->getObjects($criteria);
    }

    /**
     * Retourne le nombre total d'anniversaires du jour
     * @return int
     */
    public function getTodayObituariessCount()
    {
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('day(obituaries_date)', \date('j'), '='));
        $criteria->add(new \Criteria('month(obituaries_date)', \date('n'), '='));

        return $this->getCount($criteria);
    }

    /**
     * Returns the total number of users
     *
     * @return int
     */
    public function getAllUsersCount()
    {
        return $this->getCount();
    }

    /**
     * Returns the list of all users
     *
     * @param int     $start Position de départ
     * @param integer $limit Nombre maximum d'enregistrements
     * @param string  $sort  Champ ŕ utiliser pour le tri
     * @param string  $order Ordre de tri
     *
     * @return array   Objets de type Users
     */
    public function getAllUsers($start = 0, $limit = 0, $sort = 'obituaries_lastname', $order = 'ASC')
    {
        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('obituaries_id', 0, '<>'));
        $criteria->setStart($start);
        if ($limit > 0) {
            $criteria->setLimit($limit);
        }
        $criteria->setSort($sort);
        $criteria->setOrder($order);

        return $this->getObjects($criteria);
    }
}
