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
if(!class_exists('RrloginViewFusionParent')){
    if(class_exists('JViewLegacy')){
        class RrloginViewFusionParent extends JViewLegacy{}
    }
    else{
        class RrloginViewFusionParent extends JView{}
    }
}

/**
 * HTML View class for the HelloWorld Component
 */
class RrloginViewFusion extends RrloginViewFusionParent
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
        $input = new JInput;

        $this->params       = JComponentHelper::getParams('com_users');
        $this->user		    = JFactory::getUser();

        $this->form		    = $this->get('Form');

        $providers = $this->get('Providers');

        $this->attachedProviders = array();
        $this->unattachedProviders = array();

        $fusionProviders = $this->get('FusionProviders');

        foreach($providers as $v){
            if(!in_array($v['plugin_name'], $fusionProviders)){
               $this->attachedProviders[] = $v;
            }
            else{
                $this->unattachedProviders[] = $v;
            }
        }

        $document = JFactory::getDocument();
        $document->addStyleSheet( JURI::root().'modules/mod_rrlogin/tmpl/compact/rrlogin.css');
        $document->addScript(JURI::root().'modules/mod_rrlogin/media/rrlogin.js');
		// Display the view
		parent::display($tpl);
	}
}
