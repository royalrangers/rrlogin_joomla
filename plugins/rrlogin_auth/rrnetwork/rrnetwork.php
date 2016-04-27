<?php
/**
 * Social Login
 *
 * @version 	1.0
 * @author		Arkadiy, Joomline
 * @copyright	© 2012. All rights reserved.
 * @license 	GNU/GPL v.3 or later.
 */

// No direct access
defined('_JEXEC') or die;

class plgRrlogin_authRrnetwork extends JPlugin
{
    private $provider = 'rrnetwork';

    public function onRrloginAuth()
    {
        if($this->params->get('allow_remote_check', 1))
        {
            $remotelUrl = JURI::getInstance($_SERVER['HTTP_REFERER'])->toString(array('host'));
            $localUrl = JURI::getInstance()->toString(array('host'));
            if($remotelUrl != $localUrl){
                die('Remote authorization not allowed');
            }
        }

        $redirect = JURI::base().'?option=com_rrlogin&task=check&plugin=rrnetwork';

        $scope = 'profile';

        $params = array(
            'client_id=' . $this->params->get('id'),
            'redirect_uri=' . urlencode($redirect),
            'scope=' . $scope,
            "grant_type=authorization_code",
            "response_type=code",
        );

        $params = implode('&', $params);

        $url = 'http://royalrangers.network/index.php?option=com_oauth&view=authorize&state=xyz&' . $params;
        return $url;
    }

    public function onRrloginCheck()
    {
        require_once JPATH_BASE.'/components/com_rrlogin/controller.php';

        $controller = new RrloginController();

        $input = JFactory::getApplication()->input;

        $request = null;

        $code = $input->get('code', null, 'STRING');

        $returnRequest = new RrloginRequest();
        

        if ($code)
        {
            $token = $this->getToken($code);



            $ResponseUrl = 'http://royalrangers.network/index.php?option=com_oauth&view=data&state=xyz&access_token='.$token['access_token'];
            
            
            $request = json_decode($controller->open_http($ResponseUrl));


            if(empty($request)){
                echo 'Error - empty user data';
                exit;
            }
            else if(!empty($request->error)){
                echo 'Error - '. $request->error;
                exit;
            }
            
            

            //сохраняем данные токена в сессию
            //expire - время устаревания скрипта, метка времени Unix
            JFactory::getApplication()->setUserState('rrlogin.token', array(
                'provider' => $this->provider,
                'token' => $token['access_token'],
                'expire' => (time() + $token['expires']),
                'rrlogin_user' => $request->id,
                'app_id' => $this->params->get('id', 0),
                'app_secret' => $this->params->get('password', 0)
            ));

            $returnRequest->first_name  = explode(" ",$request->name)[0];
            $returnRequest->last_name   = explode(" ",$request->name)[1];
            $returnRequest->email       = $request->email;
            $returnRequest->id          = $request->id;
            $returnRequest->real_name   = $request->name;
            $returnRequest->network     = "rrnetwork";
    
            $returnRequest->display_name = $request->name;
            $returnRequest->all_request  = $request;
            
           // JError::raiseWarning(0,print_r($returnRequest,true));

            return $returnRequest;
        }
        else{
            echo 'Error - empty code';
            exit;
        }
    }

    public function getToken($code){
	    

        require_once JPATH_BASE.'/components/com_rrlogin/controller.php';
        
        $controller = new RrloginController();

        $redirect = urlencode(JURI::base().'?option=com_rrlogin&task=check&plugin=rrnetwork');

        //подключение к API
        $params = array(
            'client_id=' . $this->params->get('id'),
            'client_secret=' . $this->params->get('password'),
            'code=' . $code,
            'redirect_uri='. $redirect,
            "state=xyz",
             "grant_type=authorization_code",
        );

        $params = implode('&', $params);

        $url = 'http://royalrangers.network/index.php?option=com_oauth&view=token&state=xyz&' . $params;
        $data = $controller->open_http($url,TRUE,$params);
        $data_array = json_decode($data,TRUE);
    
      
        if(empty($data_array['access_token'])){
            echo 'Error - empty access token';
            exit;
        }

        return $data_array;
    }

    public function onCreateRrloginLink(&$links, $add = '')
    {
	   
        $i = count($links);
        $links[$i]['link'] = 'index.php?option=com_rrlogin&task=auth&plugin=rrnetwork' . $add;
        $links[$i]['class'] = 'rrnetworkrrlogin';
        $links[$i]['plugin_name'] = $this->provider;
        $links[$i]['plugin_title'] = JText::_('RR Network');
    }
}
