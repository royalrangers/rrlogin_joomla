<?php
/**
 * Social Login
 *
 * @version 	1.7
 * @author		SmokerMan, Arkadiy, Joomline
 * @copyright	© 2012. All rights reserved.
 * @license 	GNU/GPL v.3 or later.
 */

// No direct access.
defined('_JEXEC') or die('(@)|(@)');

?>

<noindex>
<div class="jlrrlogin">
<?php if ($type == 'logout') : ?>

<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form">

    <?php if (!empty($avatar)) : ?>
        <div class="rrlogin-avatar">
			<a href="<?php echo $profileLink; ?>" target="_blank">
				<img src="<?php echo $avatar; ?>" alt=""/>
			</a>
        </div>
    <?php endif; ?>

    <div class="login-greeting">
        <?php echo JText::sprintf('MOD_RRLOGIN_HINAME', htmlspecialchars($user->get('name')));	 ?>
    </div>
		<ul class="ul-jlrrlogin">
			<?php	if ($params->get('rrlogin_link_auch_edit', 1) == 1) {?>
				<li><a href="<?php echo JRoute::_('index.php?option=com_users&view=profile&layout=edit'); ?>"><?php echo JText::_('MOD_RRLOGIN_EDIT_YOUR_PROFILE'); ?></a></li>
			<?php }	?>
	
		</ul>
    <div class="logout-button">
        <input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGOUT'); ?>" />
        <input type="hidden" name="option" value="com_users" />
        <input type="hidden" name="task" value="user.logout" />
        <input type="hidden" name="return" value="<?php echo $return; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
<?php else : ?>
<?php if ($params->get('inittext')): ?>

    <div class="pretext">
        <p><?php echo $params->get('inittext'); ?></p>
    </div>
  <?php endif; ?>

<div id="rrlogin-buttons" class="rrlogin-buttons <?php echo $moduleclass_sfx?>">
    <?php if (count($plugins)): ?>
        <?php
        foreach($plugins as $link):
            $linkParams = '';
            if(isset($link['params'])){
                foreach($link['params'] as $k => $v){
                    $linkParams .= ' ' . $k . '="' . $v . '"';
                }
            }
            $title = (!empty($link['plugin_title'])) ? ' title="'.$link['plugin_title'].'"' : '';
            ?>
            <a  rel="nofollow" <?php echo $linkParams.$title;?> href="<?php echo JRoute::_($link['link']);?>"><span class="<?php echo $link['class'];?>">&nbsp;</span></a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="rrlogin-clear"></div>

    <?php if ($params->get('pretext')): ?>
    <div class="pretext">
        <p><?php echo $params->get('pretext'); ?></p>
    </div>
    <?php endif; ?>

<?php if ($params->get('show_login_form')): ?>
    <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" >
        <fieldset class="userdata">
            <p id="form-login-username">
                <label for="modlgn-username"><?php echo JText::_('MOD_RRLOGIN_VALUE_USERNAME') ?></label>
                <input id="modlgn-username" type="text" name="username" class="inputbox"  size="18" />
            </p>
            <p id="form-login-password">
                <label for="modlgn-passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
                <input id="modlgn-passwd" type="password" name="password" class="inputbox" size="18"  />
            </p>
            <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
            <p id="form-login-remember">
				 <label for="modlgn-remember">
				  	<input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes"/>
				  	<?php echo JText::_('MOD_RRLOGIN_REMEMBER_ME') ?>
				 </label>
			</p>
			<div class="rrlogin-clear"></div>
            <?php endif; ?>
            <input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGIN') ?>" />
            <input type="hidden" name="option" value="com_users" />
            <input type="hidden" name="task" value="user.login" />
            <input type="hidden" name="return" value="<?php echo $return; ?>" />
            <?php echo JHtml::_('form.token'); ?>
        </fieldset>
        <ul class="ul-jlrrlogin">
            <li>
                <a  rel="nofollow" href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
                    <?php echo JText::_('MOD_RRLOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
            </li>
            <li>
                <a  rel="nofollow" href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
                    <?php echo JText::_('MOD_RRLOGIN_FORGOT_YOUR_USERNAME'); ?></a>
            </li>
            <?php
            $usersConfig = JComponentHelper::getParams('com_users');
            if ($usersConfig->get('allowUserRegistration')) : ?>
                <li>
                    <a  rel="nofollow" href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
                        <?php echo JText::_('MOD_RRLOGIN_REGISTER'); ?></a>
                </li>
                <?php endif; ?>
        </ul>
        <?php if ($params->get('posttext')): ?>
        <div class="posttext">
            <p><?php echo $params->get('posttext'); ?></p>
        </div>
        <?php endif; ?>
    </form>
    <?php endif; ?>
<?php endif; ?>
</div>
</noindex>

