<?php
/**
 * Social Login
 *
 * @version 	1.9.0
 * @author		SmokerMan, Arkadiy, Joomline
 * @copyright	© 2012. All rights reserved.
 * @license 	GNU/GPL v.3 or later.
 */

// No direct access.
defined('_JEXEC') or die('(@)|(@)');

//подключаем helper стандартного модуля авторизации, для ридеректа
require_once JPATH_BASE.'/modules/mod_login/helper.php';
require_once dirname(__FILE__).'/helper.php';

$doc = JFactory::getDocument();

$loadAfter = $params->get('load_after', 0);

$layout = $params->get('layout', 'default');

$layout = (strpos($layout, '_:') === false) ? $layout : substr($layout, 2);

if ($params->get('load_js') != '1') { $doc->addScript(JURI::root().'modules/mod_rrlogin/media/rrlogin.js'); }

if ($params->get('load_css') != '1') { $doc->addStyleSheet(JURI::root().'modules/mod_rrlogin/tmpl/'.$layout.'/rrlogin.css'); }

$type	= modLoginHelper::getType();

$return	= modLoginHelper::getReturnURL($params, $type);

$allow = modRrloginHelper::getalw($params);

$input = JFactory::getApplication()->input;
$task = $input->getCmd('task', '');
$option = $input->getCmd('option', '');

if(!($option == 'com_rrlogin' && ($task == 'auth' || $task == 'check')))
{
    JFactory::getApplication()->setUserState('com_rrlogin.return_url', $return);
}


if($loadAfter == 1 && $type != 'logout'){
    ?>
    <div id="mod_rrlogin">
        <img src="/modules/mod_rrlogin/media/ajax-loader.gif" alt="Loader"/>
    </div>
    <script type="text/javascript">
        Rrlogin.addListener(window, 'load', function () {
            Rrlogin.loadModuleAjax();
        });
    </script>
    <?php
}
else{
	
	
    $user = JFactory::getUser();
    $input = new JInput;

    $callbackUrl = '';

    $moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

    $dispatcher	= JDispatcher::getInstance();

    JPluginHelper::importPlugin('rrlogin_auth');

    $plugins = array();
    $config = JComponentHelper::getParams('com_rrlogin');
  
    if($config->get('service_auth', 0)){
        modRrloginHelper::loadLinks($plugins, $callbackUrl, $params);
    }
    else{
	    
    $dispatcher->trigger('onCreateRrloginLink', array(&$plugins, $callbackUrl));
    }


    $profileLink = $avatar = '';
    if(JPluginHelper::isEnabled('rrlogin_integration', 'profile') && $user->id > 0){
        require_once JPATH_BASE.'/plugins/rrlogin_integration/profile/helper.php';
        $profile = plgProfileHelper::getProfile($user->id);
        $avatar = isset($profile->avatar) ? $profile->avatar : '';
        $profileLink = isset($profile->social_profile_link) ? $profile->social_profile_link : '';
    }
    else if(JPluginHelper::isEnabled('rrlogin_integration', 'rrlogin_avatar') && $user->id > 0){
        require_once JPATH_BASE.'/plugins/rrlogin_integration/rrlogin_avatar/helper.php';
        $path = Rrlogin_avatarHelper::getavatar($user->id);
        if(!empty($path['photo_src'])){
            $avatar = $path['photo_src'];
            if(JString::strpos($avatar, '/') !== 0)
                $avatar = '/'.$avatar;
        }
		$profileLink = isset($path['profile']) ? $path['profile'] : '';
    }

    require JModuleHelper::getLayoutPath('mod_rrlogin', $params->get('layout', 'default'));
}