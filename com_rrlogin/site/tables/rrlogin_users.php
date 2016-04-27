<?php
/**
 * Social Login
 *
 * @version 	1.0
 * @author		SmokerMan, Arkadiy, Joomline
 * @copyright	© 2012. All rights reserved.
 * @license 	GNU/GPL v.3 or later.
 */

defined('_JEXEC') or die( 'Restricted access' );
jimport('joomla.application.component.model');

class RrloginTableRrlogin_users extends JTable
{
    function __construct( &$_db )
    {
        parent::__construct('#__rrlogin_users', 'id', $_db );
    }
}
?>