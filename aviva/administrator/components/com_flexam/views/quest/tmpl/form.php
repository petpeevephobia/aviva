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

    $titleFm = NULL;
    $acctionTask = JRequest::getVar( 'task' );
    $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
    $edit = JRequest::getVar( 'edit', true );
    $numQst = JRequest::getVar( 'numQst', NULL, 'POST');
    $newNumQst = JRequest::getVar( 'newNumQ', NULL, 'POST');
    $delQst = JRequest::getVar( 'idToDel', array(0), 'POST');
    $actQst = JRequest::getVar( 'selAct', NULL, 'POST');
    $nTestQst = JRequest::getVar( 'idTest', NULL, 'POST');
    $txtEditor = &JFactory::getEditor();
    JArrayHelper::toInteger($cid, array(0));

    switch ($acctionTask) {
        // for existing items the button is renamed `close`
        case 'edit':
            JToolBarHelper::custom('update', 'save', NULL, 'FLEXAM_MOD', false);
            JToolBarHelper::cancel( 'cancel', 'Close' );
            $text = JText::_( 'FLEXAM_EDIT' );
        break;

        case 'copy':
            JToolBarHelper::custom('copyTest', 'save', NULL, 'FLEXAM_COPY', false);
            JToolBarHelper::cancel( 'cancel', 'Close' );
            $text = JText::_( 'FLEXAM_COPY' );
        break;

        case 'add':
            JToolBarHelper::save();
            JToolBarHelper::cancel();
            $text = JText::_( 'FLEXAM_NEW' );
        break;
    }

    JToolBarHelper::title(  JText::_( 'FLEXAM_MENUADMIN_QUESTIONS' ).': <small><small>[ '.$text.' ]</small></small>' );

    //JToolBarHelper::help( 'screen.flexam.edit' );

    if (!empty($newNumQst) && $actQst === 'aQ') {
        $this->addNewQ();
    } elseif (!empty($delQst) && $actQst === 'dQ') {
        $this->delSelQ();
    }

    $dataQst = $this->getDataQuestions($cid[0]);
?>

<script language="javascript" type="text/javascript">
    function submitbutton(pressbutton) {
        if (pressbutton == 'cancel' || pressbutton == 'copyTest') {
            submitform( pressbutton );
            return;
        } else {
            var fieldFm = new Array('pointQst', 'answQst', 'typeQst');
            var numQ = document.getElementById('numQst').value;
            numQ = parseInt(numQ);

            var test = document.getElementById('idTest').value;
            test = parseInt(test);

            var disc = 0;
            var fm = 0;

            if(!isNaN(numQ) && (!isNaN(test) && test > 0)){
                for (var i = 1; i <= numQ; i++ ){
                    for (var j = 0; j < fieldFm.length; j++){
                        eval('fm = document.getElementById(\'' + fieldFm[j] + i + '\').value;');
                        
                        if(fm != '' && fm != '-1'){
                            disc += 1;
                        }
                    }
                }

                if(disc == (numQ * 3) && parseInt(test) > 0){
                    submitform( pressbutton );
                } else {
                    alert('<?php echo JText::_('FLEXAM FIELD_ALERT'); ?>');
                }
            } else {
                alert('<?php echo JText::_('FLEXAM FIELD_ALERT'); ?>');
            }
        }
    }
</script>
<form action="index.php?option=com_flexam&optCtrl=questionTest" method="post" name="adminForm" enctype="multipart/form-data">
<div>
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Details' ); ?></legend>
	<table class="admintable" width="90%">
            <?php
            if($acctionTask == 'edit'){
                $db   =& JFactory::getDBO();

                $db->setQuery("SELECT * FROM #__flexam_typeQuestions");
                $tQst = $db->loadObjectList();

                $typeQuestArray[] = JText::_( 'FLEXAM_TITLE_TQUESTIONS_ALTER');
                $typeQuestArray[] = JText::_( 'FLEXAM_TITLE_TQUESTIONS_RTERM');
                $typeQuestArray[] = JText::_( 'FLEXAM_TITLE_TQUESTIONS_TRUFAL');
                $typeQuestArray[] = JText::_( 'FLEXAM_TITLE_TQUESTIONS_OPENQ');
                $tQuestName = array('Multiple Choice', 'Related Term', 'True or False', 'Open Response');

                echo '<tr><td>';

                echo '<fieldset class="adminform">'."\n".'<legend>';
                echo JText::_( 'FLEXAM_DEL_QUESTION')."</legend>\n";
                echo '<table class="admintable"><tr>';

                echo '<td width="150" class="key"><label for="title">'.JText::_( 'FLEXAM_QUESTIONS' ).'</label></td><td style="vertical-align:top;">';
                
                echo '<select multiple="multiple" size="4" class="inputbox" id="idToDel[]" name="idToDel[]" style="width:380px;" title="'.JText::_('FLEXAM_TITLE_DELQ').'">'."\n";

                $iter = 1;

                foreach($dataQst->id as $lst){
                    echo '<option value="'.$lst.'">'.JText::_('FLEXAM_QUESTION')." $iter</option>\n";
                    $iter++;
                }

                echo '</select>&nbsp;';
                echo '<input type="button" id="delQ" name="delQ" value="'.JText::_('FLEXAM_OK').'"  onClick="javascript:setQuestionModify(\'adminForm\', \'edit\',\'dQ\');" />';
                echo '</td></tr></table></fieldset>';

                echo '<fieldset class="adminform">'."\n".'<legend>';
                echo JText::_( 'FLEXAM_ADD_QUESTION')."</legend>\n";
                echo '<table class="admintable"><tr>';

                echo '<td width="150" class="key"><label for="title">'.JText::_( 'FLEXAM_QUESTIONS_NUMITEM' ).'</label></td><td style="vertical-align:top;">';
                echo '<input type="text" class="inputbox" id="newNumQ" name="newNumQ" value=""  style="width:380px;" />&nbsp;';
                echo '<input type="button" id="addQ" name="addQ" value="'.JText::_('FLEXAM_OK').'"  onClick="javascript:setQuestionModify(\'adminForm\', \'edit\',\'aQ\');" />';

                echo '</td></tr></table></fieldset>';

                echo '<tr><td>';
                
                echo '<input type="hidden" id="idTest" name="idTest" value="'.$cid[0].'" />';
                echo '<input type="hidden" id="cid[]" name="cid[]" value="'.$cid[0].'" />';
                echo '<input type="hidden" id="selAct" name="selAct" value="" />';

                if(!empty($dataQst)){
                    echo '<input type="hidden" id="numQst" name="numQst" value="'.$dataQst->numQuest.'" />';
                    
                    for($i = 0;$i < $dataQst->numQuest; $i++){
                        echo '<fieldset class="adminform">'."\n".'<legend>';
                        echo JText::_( 'FLEXAM_QUESTION')." ".($i + 1)."</legend>\n";
                        echo '<table class="admintable">';

                        echo "\n<tr>\n";
                        echo '<td width="150" class="key"><label for="title">'.JText::_( 'FLEXAM_PUBLISHED' ).'</label></td>';
                        echo '<td>'.JHTML::_( 'select.booleanlist',  'published'.($i + 1), 'class="inputbox"', $dataQst->published[$i] ).'</td>';
                        echo "\n</tr>\n";

                        echo "\n<tr>\n";
                        echo '<td width="150" class="key"><label for="title">'.JText::_( 'FLEXAM_POINTS' ).'</label></td>';
                        echo '<td><input type="text" class="inputbox" '.((empty($dataQst->points[$i])) ? : 'readonly="true"').' id="pointQst'.($i + 1).'" name="pointQst'.($i + 1).'" value="'.$dataQst->points[$i].'"  style="width:380px;" /></td>';
                        echo "\n</tr>\n";

                        echo "\n<tr>\n";
                        echo '<td width="150" class="key"><label for="title">'.JText::_( 'FLEXAM_ANSWERS_OKTITLE' ).'</label></td>';
                        echo '<td><textarea cols="51" rows="1" id="answQst'.($i + 1).'" name="answQst'.($i + 1).'"  style="width:380px;">'.$dataQst->response[$i].'</textarea></td>';
                        echo "\n</tr>\n";

                        echo "\n<tr>\n";
                        echo '<td width="150" class="key"><label for="title">'.JText::_( 'FLEXAM_TYPE' )."</label>\n</td>\n<td>\n";

                        if(!empty($dataQst->points[$i])){
                            
                            echo '<input type="text" readonly="true" value="'.$this->getSelectedType($dataQst->idtypeQuestions[$i]).'" id="typeQst'.($i + 1).'" name="typeQst'.($i + 1).'" class="inputbox" style="width:380px;">'."\n";

                        } else {

                            echo '<select id="typeQst'.($i + 1).'" name="typeQst'.($i + 1).'" class="inputbox" style="width:380px;" onBlur="javascript:checkTypeQ(\'typeQst'.($i + 1).'\', \'answQst'.($i + 1).'\',  \'pointQst'.($i + 1).'\', \''.JText::_('FLEXAM_WARNING_OPENANSWER').'\')">'."\n";
                            echo '<option value="-1">'.JText::_( 'FLEXAM_SELECT' )."</option>\n";

                            if(!empty($tQst)){
                                foreach ($tQst as $tQuestC){
                                    echo '<option value="'.$tQuestC->idtypeQuestions.'">'.$typeQuestArray[array_search($tQuestC->type, $tQuestName)]."</option>\n";
                                }
                            }

                            echo "</select>\n";

                        }

                        echo "</td>\n<tr>\n";

                        echo "\n<tr>\n";
                        echo '<td width="150" class="key"><label for="title">'.JText::_( 'FLEXAM_TITLE' ).'</label><input type="hidden" id="idQuest'.($i + 1).'" name="idQuest'.($i + 1).'" value="'.$dataQst->id[$i].'" /></td>'."\n".'<td>';
                        echo $txtEditor->display('txtQuest'.($i + 1), $dataQst->question[$i], '50%;', '300', '30', '20' );
                        echo "</td>\n</tr>\n</table>\n</fieldset>\n";
                    }
                }

                echo "</td>\n</tr>\n";
            }

            if($acctionTask == 'add'){
                echo '<tr><td width="150" class="key">'."\n".'<label for="title">'.JText::_( 'FLEXAM_TITLE_ORDER_TEST' )." :</label>\n</td>\n<td>\n";

                echo '<select id="idTest" name="idTest" class="inputbox" style="width:380px;">'."\n".'<option value="-1">'.JText::_( 'FLEXAM_SELECT' )."</option>\n";

                foreach($this->nameTstLst as $NTLsts){
                    echo '<option '.(($NTLsts->idtest == $nTestQst) ? 'value="'.$NTLsts->idtest.'" selected="true"' : 'value="'.$NTLsts->idtest.'"').'>'.$NTLsts->nameTest."</option>\n";
                }

                echo "</select>\n</td>\n</tr>\n<tr>\n";
                echo '<td width="150" class="key">'."\n".'<label for="title">'.JText::_( 'FLEXAM_QUESTIONS_NUMITEM' )." :</label>\n</td>\n<td>\n";
                echo '<input type="text" class="inputbox" id="numQst" name="numQst" value="'.((!empty($numQst)) ? $numQst : NULL).'" style="width:380px;" />'."\n";
                echo '<input type="button" value="'.JText::_( 'Continue' ).'" onClick="javascript:getQuestionDefinition(\'adminForm\', \'add\');" class="inputbox" />';
                echo "\n</td>\n</tr>\n<tr>\n<td colspan=\"2\">\n<div id=\"qstList\">\n";

                if(!empty($numQst)){
                    if(is_numeric($numQst)){
                        include('nQueDef.php');
                    }
                }

                echo "</div>\n</td>\n</tr>\n";
            }

            if($acctionTask == 'copy'){
                if(!empty($cid)){
                    if(count($cid) === 1){
                        $test = $this->getTestInfo($cid[0]);

                        echo '<tr><td style="width:400px;" class="key">'."\n".'<label for="title">'.JText::_( 'FLEXAM_COPY' ).' '.JText::_( 'FLEXAM_QUESTIONS' ).' '.JText::_( 'FLEXAM_FROM' )." <span style=\"text-decoration:underline; font-style:italic;\">$test</span> ".JText::_( 'FLEXAM_TO' )." :</label>\n</td>\n<td>\n";

                        echo '<input type="hidden" id="idTestOld" name="idTestOld" value="'.$cid[0].'" />';

                        echo '<select id="idTest" name="idTest" class="inputbox" style="width:380px;">'."\n".'<option value="-1">'.JText::_( 'FLEXAM_SELECT' )."</option>\n";

                        foreach($this->nameTstLst as $ts){
                            echo '<option '.(($ts->idtest == $nTestQst) ? 'value="'.$ts->idtest.'" selected="true"' : 'value="'.$ts->idtest.'"').'>'.$ts->nameTest."</option>\n";
                        }

                        echo "</select>\n</td>\n</tr>\n<tr>\n";

                    } else {
                        $this->goAway('index.php?option=com_flexam&view=quest&optCtrl=questionTest', JTetxt::_('FLEXAM_WARNING_COPYTEST'));
                    }
                } else {
                    $this->goAway('index.php?option=com_flexam&view=quest&optCtrl=questionTest', JTetxt::_('FLEXAM_WARNING_COPYTEST'));
                }
            }

              ?>
	</table>
	</fieldset>
</div>
<div class="clr"></div>

	<input type="hidden" name="task" id="task" value="" />
	<input type="hidden" name="option" value="com_flexam" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>