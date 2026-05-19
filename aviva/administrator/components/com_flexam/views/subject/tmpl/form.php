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
    $acctionTask = JRequest::getVar( 'task');
    $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
    $edit = JRequest::getVar( 'edit', true );
    JArrayHelper::toInteger($cid, array(0));

    $text = ( $edit ? JText::_( 'FLEXAM_EDIT' ) : JText::_( 'FLEXAM_NEW' ) );

    JToolBarHelper::title(  JText::_( 'FLEXAM_COURSES' ).': <small><small>[ ' . $text.' ]</small></small>' );
    
    if ($edit) {
        JToolBarHelper::custom('update', 'save', NULL, JText::_( 'FLEXAM_MOD' ), false);
        JToolBarHelper::cancel('cancel', 'Close' );
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
		if (form.subjects.value == "") {
			alert( "<?php echo JText::_( 'FLEXAM_CATEGORIES_VALID_ITEMFORM', true ); ?>" );
		} else if (isNaN(parseInt( form.idknowledgeArea.value ) ) || parseInt(form.idknowledgeArea.value) < 1)  {
			alert( "<?php echo JText::_( 'FLEXAM_COURSES_VALID_ITEMFORM', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}
</script>
<form action="index.php?option=com_flexam&optCtrl=courseName" method="post" name="adminForm">
<div class="col width-45">
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
                        
                        echo '<input type="hidden" name="cid" id="cid" size="60" value="'.$items->idsubjects.'" />';

                        echo '<input class="inputbox" type="text" name="subjects" id="subjects" size="60" value="'.$items->subjects.'" />';

                        echo '</td></tr><tr><td width="120" class="key">';

                        echo JText::_( 'Published' );

                        echo ':</td><td>';

                        echo JHTML::_( 'select.booleanlist',  'published', 'class="inputbox"', $items->published );

                        echo '</td></tr>';

                        echo '<tr><td width="110" class="key"><label for="title">';

                        echo JText::_( 'Areas' );

                        echo ':</label></td><td>';

                        echo '<select class="inputbox" name="idknowledgeArea" id="idknowledgeArea" >';

                        foreach($this->areasKnow AS $itemsAreas){
                            if($items->idknowledgeArea == $itemsAreas->idknowledgeArea){
                                echo "<option value=\"$itemsAreas->idknowledgeArea\" selected=\"true\">$itemsAreas->areaName</option>";
                            }else{
                                echo "<option value=\"$itemsAreas->idknowledgeArea\">$itemsAreas->areaName</option>";
                            }
                        }

                        echo '</select></td></tr>';
                    }
                }
            }

            if ($acctionTask == 'add') {
                echo '<tr><td width="110" class="key"><label for="title">';

                echo JText::_('Title');

                echo ':</label></td><td><input class="inputbox" type="text" name="subjects" id="subjects" size="60" value="';

                echo '" /></td></tr><tr><td width="120" class="key">';

                echo JText::_('Published');

                echo ':</td><td>';

                echo JHTML::_('select.booleanlist', 'published', 'class="inputbox"', '');

                echo '</td></tr>';

                echo '<tr><td width="110" class="key"><label for="title">';

                echo JText::_('Areas');

                echo ':</label></td><td>';

                echo '<select class="inputbox" name="idknowledgeArea" id="idknowledgeArea" >';

                echo '<option value="-1">' . JText::_( 'FLEXAM_SELECT') . '</option>';

                foreach ($this->areasKnow AS $itemsAreas) {
                    echo "<option value=\"$itemsAreas->idknowledgeArea\">$itemsAreas->areaName</option>";
                }

                echo '</select></td></tr>';
            }

              ?>
	</table>
	</fieldset>
</div>
<div class="col width-45">
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Options' ); ?></legend>
            <table class="admintable">
            <?php
            if($acctionTask == 'edit'){
                foreach($this->items AS $items){
                    if($items->idsubjects == $cid[0]){
                        echo '<tr><td width="110" class="key"><label for="title">';

                        echo JText::_( 'FLEXAM_CODE' );

                        echo ':</label></td><td>';

                        echo '<input type="text" class="inputbox" name="codeknowledgeArea" id="codeknowledgeArea" value="'.$items->code.'" onBlur="javascript:checkNumberField(\'codeknowledgeArea\', \''.JText::_('FLEXAM_ANSWER_JAVA_WARNING').'\');" />';

                        echo '</td></tr>';

                        echo '<tr><td width="110" class="key"><label for="title">';

                        echo JText::_( 'FLEXAM_SUBJECT_TYPE' );

                        echo ':</label></td><td>';

                        echo '<select class="inputbox" name="idTypeSubject" id="idTypeSubject" >';
                        
                        foreach($this->typeSubject AS $typeSubject){
                            if($items->	idTypeSubject == $typeSubject->	idTypeSubject){
                                echo "<option value=\"$typeSubject->idTypeSubject\" selected=\"true\">$typeSubject->type</option>";
                            }else{
                                echo "<option value=\"$typeSubject->idTypeSubject\">$typeSubject->type</option>";
                            }
                        }

                        echo '</select></td></tr>';

                        echo '<tr><td width="110" class="key"><label for="title">';

                        echo JText::_( 'FLEXAM_SUBJECT_MAIL_MANAGER' );

                        echo ':</label></td><td>';

                        echo '<input type="text" class="inputbox" name="mailManager" id="mailManager" value="'.$items->mailManager.'" onBlur="javascript:checkMailField(\'mailManager\', \''.JText::_('FLEXAM_ANSWER_JAVA_WARNING').'\');" />';

                        echo '</td></tr>';
                    }
                }
            }

            if($acctionTask == 'add'){
                echo '<tr><td width="110" class="key"><label for="title">';

                echo JText::_( 'FLEXAM_CODE' );

                echo ':</label></td><td>';

                echo '<input type="text" class="inputbox" name="code" id="code"  onBlur="javascript:checkNumberField(\'code\', \''.JText::_('FLEXAM_ANSWER_JAVA_WARNING').'\');" />';

                echo '</select></td></tr>';

                echo '<tr><td width="110" class="key"><label for="title">';

                echo JText::_( 'FLEXAM_SUBJECT_TYPE' );

                echo ':</label></td><td>';
                
                echo '<select class="inputbox" name="idTypeSubject" id="idTypeSubject" >';

                echo '<option value="1">'.JText::_( 'FLEXAM_SELECT' ).'</option>';
                
                foreach($this->typeSubject AS $typeSubject){
                    echo "<option value=\"$typeSubject->idTypeSubject\">$typeSubject->type</option>";
                }

                echo '</select></td></tr>';

                echo '<tr><td width="110" class="key"><label for="title">';

                        echo JText::_( 'FLEXAM_SUBJECT_MAIL_MANAGER' );

                        echo ':</label></td><td>';

                        echo '<input type="text" class="inputbox" name="mailManager" id="mailManager" value="" onBlur="javascript:checkMailField(\'mailManager\', \''.JText::_('FLEXAM_ANSWER_JAVA_WARNING').'\');" />';

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

<div id="footFlExamUser"><?php echo JText::_('FLEXAM_COPYRIGHTS') ?></div>