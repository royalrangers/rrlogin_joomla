<?php
/**
 * Social Login
 *
 * @version 	1.0
 * @author		SmokerMan, Arkadiy, Joomline
 * @copyright	© 2012. All rights reserved.
 * @license 	GNU/GPL v.3 or later.
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

//костыль для поддержки 2 и  3 джумлы
if(!class_exists('RrloginViewMailParent')){
    if(class_exists('JViewLegacy')){
        class RrloginViewMailParent extends JViewLegacy{}
    }
    else{
        class RrloginViewMailParent extends JView{}
    }
}

// import joomla controller library
jimport('joomla.application.component.controller');

/**
 * HTML View class for the HelloWorld Component
 */
class RrloginViewMail extends RrloginViewMailParent
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
        $app	= JFactory::getApplication();

        $data = $app->getUserState('com_rrlogin.provider.data');
        $app = JFactory::getApplication();

        $msg = $app->getUserState('com_rrlogin.msg', '');
        $msgType = $app->getUserState('com_rrlogin.msgType', '');
        $app->setUserState('com_rrlogin.msg', '');
        $app->setUserState('com_rrlogin.msgType', '');

        if(!empty($msg)){
            $msgType = (!empty($msgType)) ? $msgType : 'message';
            $app->enqueueMessage($msg, $msgType);
        }

        //костыль для поддержки 2 и  3 джумлы
        $className = (class_exists('JControllerLegacy')) ? 'JControllerLegacy' : 'JController';

        // Get an instance of the controller prefixed by Rrlogin
        $controller = call_user_func(array($className, 'getInstance'), 'Rrlogin');
        $controller->setVars('first_name', $data['first_name']);
        $controller->setVars('last_name', $data['last_name']);
        $controller->setVars('email', $data['email']);
        $controller->setVars('rrlogin_id', $data['rrlogin_id']);
        $controller->setVars('provider', $data['provider']);

        $this->name = $controller->setUserName();
        $this->username = $controller->setUserUserName();
        $this->email = $data['email'];

        $this->action = JRoute::_('index.php?option=com_rrlogin&task=check_mail');

		// Display the view
		parent::display($tpl);
	}
}
