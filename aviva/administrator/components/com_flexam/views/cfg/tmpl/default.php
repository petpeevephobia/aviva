<?php
/**
* @package      com_flexam for Joomla! 1.5
* @version	$Id: flexam.php 2010-04-02 10:07:31Z Hernán Roa $
* @author       Hernán Roa Reyes
* @copyright	(C) 2010 - 2012 Hernán Roa Reyes.
* @license	GNU/GPLv3 http://www.gnu.org/copyleft/gpl.html
* See license.txt
* flexam is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');

$acctionTask = JRequest::getVar( 'task' );

JToolBarHelper::title(  JText::_( 'FLEXAM_MODULE_TITLE' ) );
JToolBarHelper::custom('remove','delete','','Delete');
JToolBarHelper::save();
JToolBarHelper::help( '../help_6', true );

$labels = array(JText::_('FLEXAM_STACK_MODE'), JText::_('FLEXAM_FEUSER_TITLE_MODULE'),JText::_('FLEXAM_SERVER_REQUEST'), JText::_('FLEXAM_SERVER_SENDTO'), JText::_('FLEXAM_SERVER_SENDTIME'), JText::_('FLEXAM_SERVER_MAILBODY'), JText::_('FLEXAM_TITLE_SHOW_RESPONSES'), JText::_('FLEXAM_TITLE_APROVED_MSG'), JText::_('FLEXAM_TITLE_REPROVED_MSG'));
$titles = array(JText::_('FLEXAM_STACK_MODE_TITLE'), JText::_('FLEXAM_FEUSER_TITLE_MODULE_TITLE'),JText::_('FLEXAM_SERVER_REQUEST_TITLE'), JText::_('FLEXAM_SERVER_SENDTO_TITLE'), JText::_('FLEXAM_SERVER_SENDTIME'), JText::_('FLEXAM_SERVER_MAILBODY_TITLE'),'','','');
$i = 1;
?>

<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
            submitform( pressbutton );
            return;
	}
</script>
<form action="index.php?option=com_flexam&optCtrl=mainFlCfg" method="post" name="adminForm">
<div>
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Details' ); ?></legend>
	<table class="admintable">
            <?php
                if(!empty($this->items)){
                    foreach($this->items as $rows){
                        echo '<tr><td style="width:300px;" class="key" title="'.array_shift($titles).'"><label for="title">'.array_shift($labels).' :</label></td><td>';
                        echo '<input type="text" class="inputbox" id="cfgV'.$i.'" name="cfgV'.$i.'" value="'.$rows->value.'" size="60" '.(($i==1) ? 'onBlur="javascript:checkStackMode(\'cfgV'.$i.'\', \''.JText::_('FLEXAM_ANSWER_JAVA_WARNING').'\');"' : NULL).' />';
                        echo '</td></tr>';
                        $i++;
                    }
                }
              ?>
	</table>
	</fieldset>
</div>
<div class="clr"></div>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="option" value="com_flexam" />
        <input type="hidden" name="boxchecked" value="1" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>