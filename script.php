<?php
// no direct access
defined('_JEXEC') or die ;
class pkg_rrloginInstallerScript
{
	public function postflight($type, $parent)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->update('`#__extensions`')
            ->set('`enabled` = 1')
            ->where('`element` = '.$db->quote('rrlogin'))
            ->where('`type` = '.$db->quote('plugin'))
            ->where('(`folder` = '.$db->quote('authentication').' OR `folder` = '.$db->quote('user').')')
           ;
        $db->setQuery($query)->execute();
        
    }
}
