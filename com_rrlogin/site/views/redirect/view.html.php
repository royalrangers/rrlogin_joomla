<?php
/**
 * Social Login
 *
 * @version 	1.0
 * @author		SmokerMan, Arkadiy, Joomline
 * @copyright	© 2012. All rights reserved.
 * @license 	GNU/GPL v.3 or later.
 */

// защита от прямого доступа
defined('_JEXEC') or die('@-_-@');

jimport( 'joomla.application.component.view');

//костыль для поддержки 2 и  3 джумлы
if(!class_exists('RrloginViewRedirectParent')){
    if(class_exists('JViewLegacy')){
        class RrloginViewRedirectParent extends JViewLegacy{}
    }
    else{
        class RrloginViewRedirectParent extends JView{}
    }
}

/**
 * Вид для редиректа и закрытия popup окна
 * @author Николай
 *
 */
class RrloginViewRedirect extends RrloginViewRedirectParent
{

	/**
	 * Метод для отображения 
	 * @param string $tpl	шаблон
	 */
	public function display($tpl = null)
	{
        $session = JFactory::getSession();

        $this->url = JRoute::_('index.php?option=com_rrlogin&amp;task=sredirect');

		parent::display($tpl);
	}


}
