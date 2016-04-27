<?php
/**
 * Social Login
 *
 * @version 	1.0
 * @author		SmokerMan, Arkadiy, Joomline
 * @copyright	© 2012. All rights reserved.
 * @license 	GNU/GPL v.3 or later.
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

//костыль для поддержки 2 и  3 джумлы
if(!class_exists('RrloginViewSettingsParent')){
    if(class_exists('JViewLegacy')){
        class RrloginViewSettingsParent extends JViewLegacy{}
    }
    else{
        class RrloginViewSettingsParent extends JView{}
    }
}

/**
 * View class for a list of Rrlogins
 *
 * @package		Joomla.Administrator
 * @subpackage	com_rrlogin
 */
class RrloginViewSettings extends RrloginViewSettingsParent
{
	protected $component;
	protected $module;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
        $this->loadHelper('rrlogin');
        $app = JFactory::getApplication();

        // Load the submenu.
        RrloginHelper::addSubmenu(JRequest::getCmd('view', 'settings'));

		$this->component = JInstaller::parseXMLInstallFile(JPATH_COMPONENT.'/rrlogin.xml');

		$this->module = JInstaller::parseXMLInstallFile(JPATH_SITE.'/modules/mod_rrlogin/mod_rrlogin.xml');

        $pIds = array();

        $this->authPlugins = $this->get('AuthPlugins');

        foreach($this->authPlugins as $plugin)
        {
            $pIds[] = $plugin->extension_id;
        }

		$this->integrationPlugins = $this->get('IntegrationPlugins');

        $pluginNames = array();
        foreach($this->integrationPlugins as $plugin)
        {
            $pIds[] = $plugin->extension_id;
            $pluginNames[] = $plugin->name;
        }

        $comPlugins = $this->get('ComPlugins');

        if(count($comPlugins) && count($pluginNames))
        {
            for($i=0;$i<count($comPlugins);$i++)
            {
                if(in_array($comPlugins[$i]->element, $pluginNames))
                {
                    unset($comPlugins[$i]);
                }
            }
        }

        $this->comPlugins = $comPlugins;
		$this->config = JComponentHelper::getParams('com_rrlogin');

        $app->setUserState('com_plugins.edit.plugin.id', $pIds);

        $pieChartData = $this->get('PieChartData');
		$this->loadScripts($pieChartData);

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		$doc = JFactory::getDocument();
		$doc->addStyleDeclaration('.icon-48-generic {background: url("../media/com_rrlogin/icon_48x48.png")}');
		//include helper file
		require_once JPATH_COMPONENT.'/helpers/rrlogin.php';
		//actions example
		$canDo	= RrloginHelper::getActions();
		
		//set title
		JToolBarHelper::title(JText::_('COM_RRLOGIN'));
		
		//config
		if ($canDo->get('core.admin')) {
            JToolBarHelper::custom('repair', 'remove', 'remove', JText::_('COM_RRLOGIN_REPAIR_TABLE'), false);
            JToolBarHelper::custom('clean', 'delete', 'delete', JText::_('COM_RRLOGIN_CLEAN_TABLE'), false);
            JToolBarHelper::divider();
            JToolBarHelper::preferences('com_rrlogin');
		}
	}

	protected function loadScripts($pieChartData){
		$document = JFactory::getDocument();
		$document->addScript(JUri::root().'libraries/amcharts/amcharts/amcharts.js');
		$document->addScript(JUri::root().'libraries/amcharts/amcharts/pie.js');

		$script = <<<SCRIPT
            var chart;
            var legend;

            var pie_chartData = $pieChartData;

            AmCharts.ready(function () {
                // PIE CHART
                //http://docs.amcharts.com/3/javascriptcharts/AmPieChart
                chart = new AmCharts.AmPieChart();

                // title of the chart
                //chart.addTitle("Visitors countries", 16);

                chart.dataProvider = pie_chartData;
                chart.titleField = "name";
                chart.valueField = "value";
                chart.colorField = "color";
                chart.sequencedAnimation = true;
                chart.startEffect = "easeOutSine";//easeOutSine, easeInSine, elastic, bounce
                chart.innerRadius = "30%";
                chart.startDuration = 1;
                chart.labelRadius = 20;
                chart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
                // the following two lines makes the chart 3D
                chart.depth3D = 10;
                chart.angle = 30;

                // LEGEND
                //http://docs.amcharts.com/3/javascriptcharts/AmLegend
                legend = new AmCharts.AmLegend();
                legend.align = "left";
                legend.position = "left";
                legend.markerType = "circle";
                chart.addLegend(legend);

                // WRITE
                chart.write("pie_chartdiv");
            });
SCRIPT;

		$document->addScriptDeclaration($script);
	}
}
