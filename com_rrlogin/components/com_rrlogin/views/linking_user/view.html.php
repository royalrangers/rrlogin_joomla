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
if(!class_exists('RrloginViewLinkingParent')){
    if(class_exists('JViewLegacy')){
        class RrloginViewLinkingParent extends JViewLegacy{}
    }
    else{
        class RrloginViewLinkingParent extends JView{}
    }
}

/**
 * HTML View class for the HelloWorld Component
 */
class RrloginViewLinking_user extends RrloginViewLinkingParent
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
        $document = JFactory::getDocument();
        $document->addStyleSheet( JURI::root().'components/com_rrlogin/views/linking_user/tmpl/linking.css');

        $app	= JFactory::getApplication();
        $model = $this->getModel();

        $data = $app->getUserState('com_rrlogin.comparison_user.data');

        $this->params       = JComponentHelper::getParams('com_users');
        $this->user		    = JFactory::getUser();

        $this->rrloginParams       = JComponentHelper::getParams('com_rrlogin');

        $this->form		    = $this->get('Form');

        $this->email        = $data['email'];
        $this->id           = $data['id'];
        $this->provider     = $data['provider'];
        $this->rrlogin_id    = $data['rrlogin_id'];

        $this->failure_redirect = $model->getReturnURL($this->rrloginParams, 'failure_redirect');
        $this->after_reg_redirect = $model->getReturnURL($this->rrloginParams, 'after_reg_redirect');

		// Display the view
		parent::display($tpl);
	}
}
