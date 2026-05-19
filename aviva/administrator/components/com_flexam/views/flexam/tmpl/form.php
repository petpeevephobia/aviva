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
    $edit=JRequest::getVar( 'edit', true );
    JArrayHelper::toInteger($cid, array(0));

    $text = ( $edit ? JText::_( 'FLEXAM_EDIT' ) : JText::_( 'FLEXAM_NEW' ) );

    JToolBarHelper::title(  JText::_( 'FLEXAM_CATEGORIES' ).': <small><small>[ ' . $text.' ]</small></small>' );
 
    if ($edit) {
            // for existing items the button is renamed `close`
            JToolBarHelper::custom('update', 'save', NULL, JText::_( 'FLEXAM_MOD' ), false);
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
		if (form.areaName.value == "") {
			alert( "<?php echo JText::_( 'FLEXAM_CATEGORIES_VALID_ITEMFORM', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}
</script>
<form action="index.php?option=com_flexam&optCtrl=areaCourse" method="post" name="adminForm" enctype="multipart/form-data">
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

                        echo ':</label></td><td><input class="inputbox" type="text" name="areaName" id="areaName" size="60" value="';

                        echo $items->areaName;

                        echo '" /></td></tr><tr><td width="120" class="key">';

                        echo JText::_( 'Published' );

                        echo ':</td><td>';

                        echo JHTML::_( 'select.booleanlist',  'published', 'class="inputbox"', $items->published );

                        echo '</td></tr>';
                    }
                }
            }

            if($acctionTask == 'add'){
                  echo '<tr><td width="110" class="key"><label for="title">';

                  echo JText::_( 'Title' );

                  echo ':</label></td><td><input class="inputbox" type="text" name="areaName" id="areaName" size="60" value="';

                  echo '" /></td></tr><tr><td width="120" class="key">';

                  echo JText::_( 'Published' );

                  echo ':</td><td>';

                  echo JHTML::_( 'select.booleanlist',  'published', 'class="inputbox"', '' );

                  echo '</td></tr>';
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
                    if((int)$items->id===$cid[0]){
                        echo '<tr><td width="110" class="key" title="'.JText::_('FLEXAM_IMAGE_LIMITSIZE').'"><label for="title">';

                        echo JText::_( 'Image' );

                        echo ':</label></td><td><input type="hidden" name="cid" id="cid" value="'.$items->id.'" />' .
                                '<input type="hidden" name="oldImg" id="oldImg" value="'.$items->img.'" />' .
                                '<input class="inputbox" type="file" name="img" id="img" size="60" value="" title="'.JText::_('FLEXAM_IMAGE_LIMITSIZE').'" /></td></tr>';

                        echo '</td><td valign="top">';

                        if (preg_match("#swf$#i", $items->img)) {
                            echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" ' .
                                'codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" ' .
                                'border="0" width="" height="">' .
                                '<param name="movie" value="../components/com_flexam/images/thumb/'.$items->img.'">' .
                                '<embed src="../components/com_flexam/images/thumb/'.$items->img.'" loop="false" ' .
                                'pluginspage="http://www.macromedia.com/go/get/flashplayer" type="application/x-shockwave-flash" ' .
                                'width="" height=""></embed></object>';

                        } elseif (preg_match("#gif|jpg|png#i", $items->img)) {

                            echo '<img src="../components/com_flexam/images/thumb/'.$items->img.'" name="imagelib" />';

                        } else {

                            echo '<img src="images/blank.png" name="imagelib" />';
                        }

                        echo '</td></tr>';
                    }
                }
            }

            if($acctionTask == 'add'){
                echo '<tr><td width="110" class="key"><label for="title">';

                echo JText::_( 'Image' );

                echo ':</label></td><td><input class="inputbox" type="file" name="img" id="img" size="60" value="" /></td></tr>';
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