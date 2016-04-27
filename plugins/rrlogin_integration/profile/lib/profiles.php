<?php
/**
 * Social Login Integration Plugin Profile
 *
 * @version 	1.0
 * @author		Arkadiy, Joomline
 * @copyright	© 2013. All rights reserved.
 * @license 	GNU/GPL v.3 or later.
 */

class PlgRrloginProfilesTable extends JTable{

    function __construct(&$db)
    {
        parent::__construct('#__plg_rrlogin_profile', 'id', $db);
    }
}