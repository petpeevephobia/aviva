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
    $edit=JRequest::getVar( 'edit', true );
    JArrayHelper::toInteger($cid, array(0));
    $txtEditor = &JFactory::getEditor();

    $text = ( $edit ? JText::_( 'FLEXAM_EDIT' ) : JText::_( 'FLEXAM_NEW' ) );

    JToolBarHelper::title(  JText::_( 'FLEXAM_MENUADMIN_TESTS' ).': <small><small>[ ' . $text.' ]</small></small>' );

    if ($edit) {
            // for existing items the button is renamed `close`
        JToolBarHelper::custom('update', 'save', NULL, 'FLEXAM_MOD', false);
        JToolBarHelper::cancel( 'cancel', 'Close' );
    } else {
        JToolBarHelper::save();
        JToolBarHelper::cancel();
    }
    //JToolBarHelper::help( 'screen.flexam.edit' );
    
    JFilterOutput::objectHTMLSafe( $this->items, ENT_QUOTES );
?>

<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		// do field validation
		if (form.nameTest.value == "") {
			alert( "<?php echo JText::_( 'FLEXAM_TEST_NAME', true ); ?>" );
		} else if (isNaN(parseInt( form.idsubjects.value ) ) || parseInt(form.idsubjects.value) < 1 || isNaN(parseInt( form.dificulty.value ) ) || parseInt(form.dificulty.value) < 1)  {
			alert( "<?php echo JText::_( 'FLEXAM_TEST_VALID_ITEMFORM').' '.JText::_( 'FLEXAM_TEST_VALID_DIFICULTY', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}
</script>
<form action="index.php?option=com_flexam&optCtrl=testName" method="post" name="adminForm">
<div style="width:70%; float:left;">
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Details' ); ?></legend>
	<table class="admintable">
            <?php
            if($acctionTask == 'edit'){
                foreach($this->items AS $items){
                    if((int)$items->id===$cid[0]){
                        echo '<tr><td width="110" class="key"><label for="title">';

                        echo JText::_( 'Title' );

                        echo ':</label></td><td>';

                        echo '<input type="hidden" name="cid" id="cid" size="60" value="'.$items->idtest.'" />';

                        echo '<input class="inputbox" type="text" name="nameTest" id="nameTest" size="60" value="'.$items->nameTest.'" />';

                        echo '</td></tr><tr><td width="120" class="key">';

                        echo JText::_( 'Published' );

                        echo ':</td><td>';

                        echo JHTML::_( 'select.booleanlist',  'published', 'class="inputbox"', $items->published );

                        echo '</td></tr><tr><td width="120" class="key">';

                        echo JText::_( 'FLEXAM_INSTRUCTIONS' );

                        echo ':</td><td>';

                        echo $txtEditor->display('instruction', $this->getIntruction($items->idtest), '50%;', '300', '30', '20' );

                        echo '</td></tr>';
                    }
                }
            }

            if($acctionTask == 'add'){
                  echo '<tr><td width="110" class="key"><label for="title">';

                  echo JText::_( 'Title' );

                  echo ':</label></td><td><input class="inputbox" type="text" name="nameTest" id="nameTest" size="60" value="';

                  echo '" /></td></tr><tr><td width="120" class="key">';

                  echo JText::_( 'Published' );

                  echo ':</td><td>';

                  echo JHTML::_( 'select.booleanlist',  'published', 'class="inputbox"', '' );

                  echo '</td></tr><tr><td width="120" class="key">';

                  echo JText::_( 'FLEXAM_INSTRUCTIONS' );

                  echo ':</td><td>';

                  echo $txtEditor->display('instruction', '', '50%;', '300', '50', '20' );

                  echo '</td></tr>';
            }

              ?>
	</table>
	</fieldset>
</div>
<div style="width:30%; float:left;">
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Options' ); ?></legend>
            <table class="admintable">
            <?php
            if($acctionTask == 'edit'){
                foreach($this->items AS $items){
                    if($items->idtest == $cid[0]){
                        echo '<tr><td width="80" class="key"><label for="title">';

                        echo JText::_( 'FLEXAM_COURSES' );

                        echo ':</label></td><td>';

                        echo '<select class="inputbox" name="idsubjects" id="idsubjects" >';
                        
                        foreach($this->subjAsocLst AS $itemsSubj){
                            if($items->idsubjects == $itemsSubj->idsubjects){
                                echo "<option value=\"$itemsSubj->idsubjects\" selected=\"true\">$itemsSubj->subjects</option>";
                            }else{
                                echo "<option value=\"$itemsSubj->idsubjects\">$itemsSubj->subjects</option>";
                            }
                        }

                        echo '</select></td></tr>';

                        echo '<tr><td width="80" class="key"><label for="title">';

                        echo JText::_( 'FLEXAM_TEST_DIFICULTY' );

                        echo ':</label></td><td>';

                        echo '<select class="inputbox" name="dificulty" id="dificulty" >';
                        //var_dump($this);
                        foreach($this->difLevel AS $itemsDif){
                            if($items->dificulty == $itemsDif->idDificulty){
                                echo "<option value=\"$itemsDif->idDificulty\" selected=\"true\">$itemsDif->pCent</option>";
                            }else{
                                echo "<option value=\"$itemsDif->idDificulty\">$itemsDif->pCent</option>";
                            }
                        }

                        echo '</select></td></tr>';

                        echo '<tr><td width="80" class="key"><label for="title">';

                        echo JText::_( 'FLEXAM_TEST_STARTSCORE' );

                        echo ':</label></td><td>';

                        echo '<input type="text" id="minScore" name="minScore" value="'.$items->minScore.'" onBlur="javascript:checkNumberField(\'minScore\', \''.JText::_('FLEXAM_ANSWER_JAVA_WARNING').'\');" />';

                        echo '</td></tr>';
                        
                        echo '<tr><td width="80" class="key"><label for="title">';

                        echo JText::_( 'FLEXAM_TEST_ENDSCORE' );

                        echo ':</label></td><td>';

                        echo '<input type="text" id="maxScore" name="maxScore" value="'.$items->maxScore.'" onBlur="javascript:checkNumberField(\'maxScore\', \''.JText::_('FLEXAM_ANSWER_JAVA_WARNING').'\');" />';

                        echo '</td></tr>';

                        echo '<tr><td width="80" class="key"><label for="title">';

                        echo JText::_( 'FLEXAM_TEST_APPROVALSCORE' );

                        echo ':</label></td><td>';

                        echo '<input type="text" id="aprobeScore" name="aprobeScore" value="'.$items->aprobeScore.'" onBlur="javascript:checkNumberField(\'aprobeScore\', \''.JText::_('FLEXAM_ANSWER_JAVA_WARNING').'\');" />';

                        echo '</td></tr>';
                    }
                }
            }

            if($acctionTask == 'add'){
                echo '<tr><td width="80" class="key"><label for="title">';

                echo JText::_( 'FLEXAM_COURSES' );

                echo ':</label></td><td>';

                echo '<select class="inputbox" name="idsubjects" id="idsubjects" >';
                echo '<option value="-1">'.JText::_( 'FLEXAM_SELECT' ).'</option>';
                
                foreach($this->subjAsocLst AS $itemsSubj){
                    echo "<option value=\"$itemsSubj->idsubjects\">$itemsSubj->subjects</option>";
                }

                echo '</select></td></tr>';

                echo '<tr><td width="80" class="key"><label for="title">';

                echo JText::_( 'FLEXAM_TEST_DIFICULTY' );

                echo ':</label></td><td>';

                echo '<select class="inputbox" name="dificulty" id="dificulty" >';
                echo '<option value="-1">'.JText::_( 'FLEXAM_SELECT' ).'</option>';

                foreach($this->difLevel AS $itemsDif){
                    echo "<option value=\"$itemsDif->idDificulty\">$itemsDif->pCent</option>";
                }

                echo '</select></td></tr>';

                echo '<tr><td width="80" class="key"><label for="title">';

                echo JText::_( 'FLEXAM_TEST_STARTSCORE' );

                echo ':</label></td><td>';

                echo '<input type="text" id="minScore" name="minScore" value="" onBlur="javascript:checkNumberField(\'minScore\', \''.JText::_('FLEXAM_ANSWER_JAVA_WARNING').'\');" />';

                echo '</td></tr>';

                echo '<tr><td width="80" class="key"><label for="title">';

                echo JText::_( 'FLEXAM_TEST_ENDSCORE' );

                echo ':</label></td><td>';

                echo '<input type="text" id="maxScore" name="maxScore" value="" onBlur="javascript:checkNumberField(\'maxScore\', \''.JText::_('FLEXAM_ANSWER_JAVA_WARNING').'\');" />';

                echo '</td></tr>';

                echo '<tr><td width="80" class="key"><label for="title">';

                echo JText::_( 'FLEXAM_TEST_APPROVALSCORE' );

                echo ':</label></td><td>';

                echo '<input type="text" id="aprobeScore" name="aprobeScore" value="" onBlur="javascript:checkNumberField(\'aprobeScore\', \''.JText::_('FLEXAM_ANSWER_JAVA_WARNING').'\');" />';

                echo '</td></tr>';
            }
              ?>
            </table>
	</fieldset>
</div>
<div class="clr"></div>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="option" value="com_flexam" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
