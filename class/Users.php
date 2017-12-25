<?php namespace Xoopsmodules\obituaries;

/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * Created on 10 juil. 08 at 13:27:45
 * Version :
 * ****************************************************************************
 */

use Xmf\Request;

// defined('XOOPS_ROOT_PATH') || exit('Restricted access.');

require_once XOOPS_ROOT_PATH . '/kernel/object.php';
//if (!class_exists('Obituaries_XoopsPersistableObjectHandler')) {
//  require_once XOOPS_ROOT_PATH.'/modules/obituaries/class/PersistableObjectHandler.php';
//}

/**
 * Class Users
 */
class Users extends \XoopsObject
{
    /**
     * Users constructor.
     */
    public function __construct()
    {
        $this->initVar('obituaries_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('obituaries_uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('obituaries_date', XOBJ_DTYPE_TIMESTAMP, null, false);
        $this->initVar('obituaries_photo', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('obituaries_description', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('obituaries_survivors', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('obituaries_service', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('obituaries_memorial', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('obituaries_firstname', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('obituaries_lastname', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('obituaries_comments', XOBJ_DTYPE_INT, null, false);
        // Pour autoriser le html
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
    }

    /**
     * Retourne l'URL de l'image
     * @return string L'URL
     */
    public function getPictureUrl()
    {
        if ('' != xoops_trim($this->getVar('obituaries_photo'))) {
            return ObituariesUtils::getModuleOption('folder_url') . '/' . $this->getVar('obituaries_photo');
        } else {
            return '';
        }
    }

    /**
     * Retourne le chemin de l'image
     * @return string Le chemin
     */
    public function getPicturePath()
    {
        if ('' != xoops_trim($this->getVar('obituaries_photo'))) {
            return ObituariesUtils::getModuleOption('folder_path') . '/' . $this->getVar('obituaries_photo');
        } else {
            return '';
        }
    }

    /**
     * Indique si l'image existe
     *
     * @return boolean Vrai si l'image existe sinon faux
     */
    public function pictureExists()
    {
        $return = false;
        if ('' != xoops_trim($this->getVar('obituaries_photo'))
            && file_exists(ObituariesUtils::getModuleOption('folder_path') . '/' . $this->getVar('obituaries_photo'))) {
            $return = true;
        }

        return $return;
    }

    /**
     * Supprime l'image associ�e
     * @return void
     */
    public function deletePicture()
    {
        if ($this->pictureExists()) {
            @unlink(ObituariesUtils::getModuleOption('folder_path') . '/' . $this->getVar('obituaries_photo'));
        }
        $this->setVar('obituaries_photo', '');
    }

    /**
     * Rentourne la chaine � envoyer dans une balise <a> pour l'attribut href
     *
     * @return string
     */
    public function getHrefTitle()
    {
        return ObituariesUtils::makeHrefTitle(xoops_trim($this->getVar('obituaries_lastname')) . ' ' . xoops_trim($this->getVar('obituaries_firstname')));
    }

    /**
     * Retourne l'utilisateur Xoops li� � l'enregistrement courant
     *
     */
    public function getXoopsUser()
    {
        $ret = null;
        static $memberHandler;
        if ($this->getVar('obituaries_uid') > 0) {
            if (null === $memberHandler) {
                $memberHandler = xoops_getHandler('member');
            }
            $user = $memberHandler->getUser($this->getVar('obituaries_uid'));
            if (is_object($user)) {
                $ret = $user;
            }
        }

        return $ret;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return xoops_trim($this->getVar('obituaries_lastname')) . ' ' . xoops_trim($this->getVar('obituaries_firstname'));
    }

    /**
     * Retourne les �l�ments format�s pour affichage
     *
     * @param  string $format Le format � utiliser
     * @return array  Les donn�es formatt�es
     */
    public function toArray($format = 's')
    {
        $ret = [];
        foreach ($this->vars as $k => $v) {
            $ret[$k] = $this->getVar($k, $format);
        }
        $ret['obituaries_full_imgurl'] = $this->getPictureUrl();
        $ret['obituaries_href_title']  = $this->getHrefTitle();
        $user                          = null;
        $user                          = $this->getXoopsUser();
        if (is_object($user)) {
            $ret['obituaries_user_name']        = $user->getVar('name');
            $ret['obituaries_user_uname']       = $user->getVar('uname');
            $ret['obituaries_user_email']       = $user->getVar('email');
            $ret['obituaries_user_url']         = $user->getVar('url');
            $ret['obituaries_user_user_avatar'] = $user->getVar('user_avatar');
            $ret['obituaries_user_user_from']   = $user->getVar('user_from');
        }

        $ret['obituaries_picture_url'] = $this->getPictureUrl();

        $ret['obituaries_formated_date'] = formatTimestamp(strtotime($this->getVar('obituaries_date')), 's');
        $ret['obituaries_fullname']      = $this->getFullName();

        return $ret;
    }
}

