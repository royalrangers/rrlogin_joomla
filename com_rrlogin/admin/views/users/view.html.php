<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');

class SloginViewUsers extends JViewLegacy
{

	function display($tpl = null) 
	{
        $this->loadHelper('rrlogin');

        // Load the submenu.
        RrloginHelper::addSubmenu(JRequest::getCmd('view', 'settings'));

		// Assign data to the view
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
        $this->state		= $this->get('State');
        $this->providers		= $this->get('Providers');

        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }

		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
 
		// Set the document
		$this->setDocument();
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
        $this->loadHelper( 'rrlogin' );
        $canDo = RrloginHelper::getActions();

        $doc = JFactory::getDocument();
        $doc->addStyleDeclaration('.icon-48-users {background: url("../media/com_rrlogin/icon_48x48.png")}');

        JToolBarHelper::title(JText::_('COM_RRLOGIN_USERS'), 'users');

        if($canDo->get('core.admin')){
            JToolBarHelper::deleteList(JText::_('COM_RRLOGIN_CONFIRM'), 'remove_rrlogin_users', 'COM_RRLOGIN_DELETE_USERS');
            JToolBarHelper::deleteList(JText::_('COM_RRLOGIN_CONFIRM'), 'remove_joomla_users', 'COM_RRLOGIN_DELETE_J_USERS');
        }
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_RRLOGIN'));
	}
}
