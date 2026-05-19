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

$db   =& JFactory::getDBO();

$db->setQuery("SELECT * FROM #__flexam_typeQuestions");
$tQst = $db->loadObjectList();

$typeQuestArray[] = JText::_( 'FLEXAM_TITLE_TQUESTIONS_ALTER');
$typeQuestArray[] = JText::_( 'FLEXAM_TITLE_TQUESTIONS_RTERM');
$typeQuestArray[] = JText::_( 'FLEXAM_TITLE_TQUESTIONS_TRUFAL');
$typeQuestArray[] = JText::_( 'FLEXAM_TITLE_TQUESTIONS_OPENQ');
$tQuestName = array('Multiple Choice', 'Related Term', 'True or False', 'Open Response');

for($i = 1; $i <= $numQst; $i++){
    echo '<fieldset class="adminform">'."\n<legend>\n";
    echo JText::_( 'FLEXAM_QUESTION')." $i" ."\n</legend>\n";
    echo '<table class="admintable">';

    echo "\n<tr>\n";
    echo '<td width="150" class="key">'."\n".'<label for="title">'.JText::_( 'FLEXAM_PUBLISHED' )."</label>\n</td>\n<td>";
    echo JHTML::_( 'select.booleanlist',  'published'.$i, 'class="inputbox"', '' )."</td>\n</tr>\n";

    echo "\n<tr>\n";
    echo '<td width="150" class="key" title="'.JText::_( 'FLEXAM_QUESTION_POINT_INFO' ).'">'."\n".'<label for="title">'.JText::_( 'FLEXAM_POINTS' )."</label>\n</td>\n<td>";
    echo '<input type="text" class="inputbox" id="pointQst'.$i.'" name="pointQst'.$i.'" value="" style="width:380px;" /></td>';
    echo "\n</tr>\n";

    echo "\n<tr>\n";
    echo '<td width="150" class="key" title="'.JText::_( 'FLEXAM_QUESTION_ANSWER_INFO' ).'">'."\n".'<label for="title">'.JText::_( 'FLEXAM_ANSWERS_OKTITLE' )."</label>\n</td>\n<td>";
    echo '<textarea cols="51" rows="1" id="answQst'.$i.'" name="answQst'.$i.'" style="width:380px;"></textarea></td>';
    echo "\n</tr>\n";

    echo "\n<tr>\n";
    echo '<td width="150" class="key" title="'.JText::_( 'FLEXAM_QUESTION_TYPE_INFO' ).'">'."\n".'<label for="title">'.JText::_( 'FLEXAM_TYPE' )."</label>\n</td>\n<td>";
    echo '<select id="typeQst'.$i.'" name="typeQst'.$i.'" class="inputbox" style="width:380px;" onBlur="javascript:checkTypeQ(\'typeQst'.$i.'\', \'answQst'.$i.'\',  \'pointQst'.$i.'\', \''.JText::_('FLEXAM_WARNING_OPENANSWER').'\')">'."\n";
    echo '<option value="-1">'.JText::_( 'FLEXAM_SELECT' )."</option>\n";

    if(!empty($tQst)){
        foreach ($tQst as $tQuestC){
            echo '<option value="'.$tQuestC->idtypeQuestions.'">'.$typeQuestArray[array_search($tQuestC->type, $tQuestName)]."</option>\n";
        }
    }

    echo "</select>\n</td>\n";
    echo "\n</tr>\n<tr>\n";
    echo '<td width="150" class="key">'."\n".'<label for="title">'.JText::_( 'FLEXAM_QUESTION' )."</label>\n</td>\n<td>";
    echo $txtEditor->display('txtQuest'.$i, '', '50%;', '300', '30', '20' );
    echo "</td>\n</tr>\n</table>\n";
    echo "</fieldset>\n";
}
?>