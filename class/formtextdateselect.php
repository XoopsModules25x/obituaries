<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team, Kazumi Ono (AKA onokazu)
 */

// defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');
/**
 * @package     kernel
 * @subpackage  form
 *
 * @author      Kazumi Ono  <onokazu@xoops.org>
 * @copyright   copyright (c) 2000-2003 XOOPS.org
 */

/**
 * A text field with calendar popup
 *
 * @package     kernel
 * @subpackage  form
 *
 * @author      Kazumi Ono  <onokazu@xoops.org>
 * @copyright   copyright (c) 2000-2003 XOOPS.org
 */
class BD_XoopsFormTextDateSelect extends XoopsFormText
{
    public function __construct($caption, $name, $size = 15, $value = 0)
    {
        $value = !is_numeric($value) ? time() : (int)$value;
        parent::__construct($caption, $name, $size, 25, $value);
    }

    public function render()
    {
        $ele_name  = $this->getName();
        $ele_value = $this->getValue(false);
        $jstime    = formatTimestamp($ele_value, 'F j Y, H:i:s');
        require_once XOOPS_ROOT_PATH . '/modules/obituaries/include/calendarjs.php';

        return "<input type='text' name='"
               . $ele_name
               . "' id='"
               . $ele_name
               . "' size='"
               . $this->getSize()
               . "' maxlength='"
               . $this->getMaxlength()
               . "' value='"
               . date('Y-m-d', $ele_value)
               . "'"
               . $this->getExtra()
               . "><input type='reset' value=' ... ' onclick='return showCalendar(\""
               . $ele_name
               . "\");'>";
    }
}
