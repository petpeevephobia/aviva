<?php
/**
 * Mad Blanks; a component for Joomla!
 * Copyright (C) 2006, 2007, 2008, 2009, 2010, 2011 Chris Hallett
 *
 * Use this component to write out text with blanks in it, and have
 * your website users fill in those blanks (or fill them in
 * yourself). Uses include creating custom word games, displaying
 * quotations, keeping a catalog of descriptions, and administering
 * quizzes with freeform responses. For detailed documentation,
 * see <http://www.madblanks.org/>.
 *
 * This file is part of Mad Blanks.
 *
 * Mad Blanks is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * Mad Blanks is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Mad Blanks; if not, see <http://www.gnu.org/licenses/>.
 *
 * This file contains HTML output functions for functions in admin.madblanks.php
 *
 * file version 1.21.0 20110301
 *
 * @package Mad_Blanks_Component
 * @author Chris Hallett <chris@madblanks.org>
 * @copyright Chris Hallett March 1, 2011
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @version 1.4.2
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// enumerate global variables for Joomla! 1.5
global $mbFieldCount, $mbDefaultTextareaWidth, $mbDefaultTextareaHeight, $mbEnteredByLongFormat, $mbColor1,
$mbColor2, $mbAdminRecordEditRawOrForm, $mbDefaultNumColumns, $mbEnableMaxPostOrRequestVarsWarning, 
$mbIncludeCustomizationFile;

if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php')) {
/**
 * Include the component configuration file
 */
	include JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php';
}

/**
 * set number of data fields present in the database, preferably from the config file
 * @global integer $mbFieldCount
 */
if (!isset($mbFieldCount)) {
	$mbFieldCount = 25;
}

// Require class file before language file so that UTF-8 aware string functions 
//  such as JString::strtolower() can be used in the language file
require_once($mainframe->getPath('class'));

$lang_code = &JFactory::getLanguage();
$lang_code = $lang_code->_lang;

if (file_exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'language'.DS.$lang_code.'.com_madblanks.core.php' )) {
/**
 * Include the configured language file
 */
	include_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'language'.DS.$lang_code.'.com_madblanks.core.php';
} 
else {
/**
 * If no configured language, include the default English language file
 */
	include_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'language'.DS.'en-US.com_madblanks.core.php';
}

/**
 * @package Mad_Blanks_Component
 */
class HTML_MadBlanks {

/**
 * Default screeen for the backend, displays options in the form of links
 *
 * @param string $option Joomla option string from URL
 * @param integer $shortdisplay set to 1 for an abbreviated horizontal display
 */
function htmlDefaultScreen($option, $shortdisplay=0) {

	if (empty($shortdisplay)) {
		setMadBlanksBackEndPageTitle('Mad Blanks');
	}	
	
	echo "<div style=\"text-align: left;\">";
	if (!$shortdisplay) {
		echo "<p>" . _MBL_BACKEND_WELCOME . "</p>\n";
		echo "<p>&nbsp;</p>\n";
	}

	echo $shortdisplay ? "<ul style=\"white-space: nowrap; margin: 8px 0 0 0;\">\n" : "<ul>\n";

	echo ($shortdisplay ? "<li style=\"display: inline; list-style: none; margin-right: 40px;\">Mad Blanks 1.4.2</li>\n" : "");
	echo "<li" . ($shortdisplay ? " style=\"display: inline; list-style: none; margin-right: 30px;\"" : "") . "><a href=\"" . JUri::base() . "index2.php?option=$option&task=listrecords\">" . _MBL_BACKEND_RECORDS . "</a></li>\n";
	echo "<li" . ($shortdisplay ? " style=\"display: inline; list-style: none; margin-right: 30px;\"" : "") . "><a href=\"" . JUri::base() . "index2.php?option=$option&task=listcategories\">" . _MBL_BACKEND_CATEGORIES . "</a></li>\n";
	echo "<li" . ($shortdisplay ? " style=\"display: inline; list-style: none; margin-right: 30px;\"" : "") . "><a href=\"javascript: popupWindow( '" . JUri::base() . "index3.php?option=com_madblanks&task=showreferencewindow', 'madblankscatref', screen.width/2, screen.height*0.667, 'yes' );\">" . _MBL_OPEN . " " . _MBL_CATEGORIES_REFERENCE . "</a></li>\n";
	echo "<li" . ($shortdisplay ? " style=\"display: inline; list-style: none; margin-right: 30px;\"" : "") . "><a href=\"" . JUri::base() . "index2.php?option=$option&task=listscorescripts\">" . _MBL_BACKEND_SCORESCRIPTS . "</a></li>\n";
	echo "<li" . ($shortdisplay ? " style=\"display: inline; list-style: none;\"" : "") . "><a href=\"" . JUri::base() . "index2.php?option=$option&task=editconfiguration\">" . _MBL_BACKEND_CONFIGURATION . "</a></li>\n";
	echo "</ul>\n</div>\n";
}

/**
 * Backend edit screen for a Mad Blanks Category
 *
 * @param string $option Joomla option string from URL
 * @param object &$row the row from the database for this category
 * @param object &$lists pulldown menu data
 * @param integer $numbercompleted number of records with completed flag on in this category
 * @param integer $numberapproved number of records with approved flag on in this category
 * @param integer $numberpublished number of records with published flag on in this category
 * @param integer $numbertotal total number of records in this category
 * @param integer $numberdisplayed number of records meeting all three criteria to be displayed (completed, approved, published)
 * @param string $validate_message message to display at top of screen warning that a field did not validate
 * @param array $validate_error_field_list array whose keys contain values with invalid field numbers if applicable
 */
function htmlEditMadBlanksCategory($option, &$row, &$lists, $numbercompleted=0, $numberapproved=0, $numberpublished=0, $numbertotal=0, $numberdisplayed=0, $validate_message=null, $validate_error_field_list=null) {

	global $mbFieldCount, $mbDefaultSeparator1, $mbDefaultSeparator2, $mbEnableMaxPostOrRequestVarsWarning;
	
	setMadBlanksBackEndPageTitle((!empty($row->id) ? _MBL_EDIT : _MBL_NEW) . ' ' . JString::ucfirst(_MBL_CATEGORY_NAME) . (!empty($row->id) ? ' #' . $row->id : '') . (!empty($row->name) ? ': ' . (function_exists('htmlspecialchars_decode') ? htmlspecialchars_decode($row->name) : $row->name) : ''));
	
	if ($validate_message) {
		echo "<div class=\"message\">" . $validate_message . "</div>\n";
	}

	//$mosHTML = new mosHTML();
?>

<script type="text/javascript" language="javascript">
<!--
function toggleLayer( whichLayer )
{
  var elem, vis;
  if( document.getElementById ) // this is the way the standards work
    elem = document.getElementById( whichLayer );
  else if( document.all ) // this is the way old msie versions work
      elem = document.all[whichLayer];
  else if( document.layers ) // this is the way nn4 works
    elem = document.layers[whichLayer];
  vis = elem.style;
  //alert(whichLayer + ' display is set to ' + vis.display); 
  // if the style.display value is blank we try to figure it out here
  if(vis.display==''&&elem.offsetWidth!=undefined&&elem.offsetHeight!=undefined)
    vis.display = (elem.offsetWidth!=0&&elem.offsetHeight!=0)?'block':'none';
  vis.display = (vis.display==''||vis.display=='block')?'none':'block';
}

function toggleLayers()
{
  for (i=1; i <= <?php echo $mbFieldCount; ?>; i++) {
  	if (i < 10) {
  		i = '0' + i;
  	}	
  	toggleLayer('field' + i);
  }
}

function toggleClassVisibility(thetagname, theclass){
  //alert('here1; thetagname is ' + thetagname + ' and theclass is ' + theclass);
  d = document.getElementsByTagName(thetagname);
  j=0;
  var cl = new Array()
  for(i=0;i<d.length;i++){
    if(d[i].className == 'row0 ' + theclass || d[i].className == 'row1 ' + theclass){
      //alert('here2; d[i].style.visibility is ' + d[i].style.visibility);
      if (navigator.userAgent.indexOf('MSIE') !=-1) { // using IE (visibility: collapse not supported)
      	if (d[i].style.display==''||d[i].style.display=='block') {
      		d[i].style.visibility = 'hidden';
      		d[i].style.display = 'none';
      	}
      	else {
      		d[i].style.visibility = 'visible';
      		d[i].style.display = 'block';
      	}
      }
      else { // non-IE (visibility: collapse is supported)
      	if (d[i].style.visibility==''||d[i].style.visibility=='visible') {
      		d[i].style.visibility = 'collapse';
      		d[i].style.display = 'none';
      	}
      	else {
      		d[i].style.display = 'table-row';
      		d[i].style.visibility = 'visible';
      	}
      }
      j++
    }
  }
}

function makeElementVisible(theid, newstate){
	element = document.getElementById(theid);
	if (element) {
		if (!newstate) {
			element.style.visibility = 'hidden';
			element.style.display = 'none';
		}
		else {
			element.style.visibility = 'visible';
			element.style.display = 'block';
		}
	}
}

function autoEnableMultipleChoice(theradio) {
	// determine which field we're dealing with (01-25) by isolating the numeric portion of the element name
	thefieldnumber = theradio.name.match(/\d+/)[0];
	// check if a multiple choice option has been selected
	if (theradio.value == 'radio' || theradio.value == 'checkbox' || theradio.value == 'pulldown' || theradio.value == 'multi') {
		// check 'Yes' to enable multiple choice options for this field number
		document.forms.adminForm["usemultchoice_" + thefieldnumber + "1"].checked = true;
	}
	else if (theradio.value == 0 || theradio.value == 1 || theradio.value == 'hidden') {
		// check 'No' to disable multiple choice options for this field number
		document.forms.adminForm["usemultchoice_" + thefieldnumber + "0"].checked = true;
	}
}

function autoClearBlankIsCorrect(thetextfield) {
	// determine which field we're dealing with (01-25) by isolating the numeric portion of the element name
	thefieldnumber = thetextfield.name.match(/\d+/)[0];
	if (thetextfield.value != '') {
		document.forms.adminForm["blankiscorrect_" + thefieldnumber].checked = false;
	}
}

// supported element_types are input, textarea, radio, checkbox, pulldown
function copyMBFieldSetting(copyfrom, copyto, element_type) {
	if (element_type == 'input' || element_type == 'textarea' || element_type == 'pulldown') {
		document.adminForm[copyto].value = document.adminForm[copyfrom].value;  
	}
	else if (element_type == 'radio') {
		checkbox_length = document.forms.adminForm[copyfrom].length;
		for (counter = 0; counter < checkbox_length; counter++) {
			if ((element_type == 'radio' || element_type == 'checkbox') && document.forms.adminForm[copyfrom][counter].checked) {
				document.forms.adminForm[copyto][counter].checked = true;
			}
			//else if (element_type == 'multi' && document.forms.adminForm[copyfrom][counter].selected) {
			//	document.forms.adminForm[copyto][counter].selected = true;
			//}
		}	
	}
	else if (element_type == 'checkbox') {
		if (document.forms.adminForm[copyfrom].checked) {
			document.forms.adminForm[copyto].checked = true;
		}
		else {
			document.forms.adminForm[copyto].checked = false;
		}
	}
}

function copyMBFieldToAll(copyfrom, copyto, element_type, start_index) {
	if (!isNumber(start_index)) {
		start_index = 1;
	}
	for (i = start_index; i <= <?php echo $mbFieldCount; ?>; i++) {
		j = String(i < 10 ? '0' + i : i);
		copyMBFieldSetting(copyfrom, copyto.replace('#', j), element_type);
  	}
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function addLoadEvent(func) {
	var oldonload = window.onload;
	if (typeof window.onload != 'function') {
        	window.onload = func;
	} 
	else {
              window.onload = function() {
                    if (oldonload) {
                            oldonload();
                    }
                    func();
              }
         }
}

addLoadEvent(function(){
	// when first loading the page for IE only (IE does not support visibility: collapse;)
	// visibility: collapse for 'tr' elements should become 'display:none;' and 'visibility: visible;'
	if (navigator.userAgent.indexOf('MSIE') !=-1) { // using IE
		d = document.getElementsByTagName('tr');
		for(i=0;i<d.length;i++){
			if (d[i].style.visibility=='collapse') {
				d[i].style.display = 'none';
				d[i].style.visibility = 'visible';
      			}
		}  
	}
});

// -->
</script>

<?php

if (!isset($mbEnableMaxPostOrRequestVarsWarning) || (isset($mbEnableMaxPostOrRequestVarsWarning) && $mbEnableMaxPostOrRequestVarsWarning)) {
	ob_start();
	phpinfo();
	$restriction_info = ob_get_contents();
	ob_end_clean();

	// here you parse the HTML from phpinfo()
	// for what you want (contained in $restriction_info).
	// Since it is usually the same that should
	// be easy enough

	if (strpos($restriction_info, "post.max_vars") !== false || strpos($restriction_info, "request.max_vars") !== false) {

		echo "<h2 style=\"color: red;\">Warning: There is a limit on the number of POST variables allowed by your web server
		(<b>Suhosin</b> or similar software may be installed).</h2><div>This may keep some or all of the category data from
		being saved successfully. Look for settings containing <em>post.max_vars</em>, <em>request.max_vars</em>, or similar
		in <em>Help&nbsp;->&nbsp;System&nbsp;Info&nbsp;->&nbsp;PHP&nbsp;Information</em>. If present, these should all be set to 720 at
		minimum for Mad Blanks categories to save properly. If set to 200, as few as 5 of the 25 Mad Blanks fields within
		the category will save correctly.</div><div style=\"color: red;\">To dismiss this warning, set the Mad Blanks configuration variable
		<em>mbEnableMaxPostOrRequestVarsWarning</em> to <b>0 (No)</b>.<br /></div><br />\n";

	}

	unset($restriction_info);
}
?>

<form action="index2.php" method="post" name="adminForm" id="adminForm" class="adminForm">

<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="" />

<table class="adminheading">
<tr>
<th><?php echo $row->id ? _MBL_EDIT : _MBL_NEW; echo " Mad Blanks " . _MBL_CATEGORY_NAME . ($row->id ? " <span style=\"margin-left: 1em; font-style: italic;\">#" . $row->id . ($row->name ? ": " . $row->name . "</span>" : "</span>") : ""); ?></th>
</tr>
</table>

		<?php JHTML::_('behavior.calendar'); ?>

<table border="0" cellpadding="3" cellspacing="0" class="adminlist">

<tr>
<th colspan="2"><?php echo "<p>"; printf(_MBL_NUMBER_OF_RECORDS_THIS_CATEGORY, $numbercompleted, $numberapproved, $numberpublished, $numberdisplayed, $numbertotal); echo "</p>\n"; ?></th>
</tr>

<tr class="row<?php !empty($row0or1) ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td align="right"><b><?php echo ucwords(_MBL_PUBLISHED); ?></b>:</td>
<td><?php echo JHTML::_('select.booleanlist',"published", "", ($row->published ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td width="50%" align="right"><?php echo _MBL_NAME_FOR_THIS_CATEGORY ?></td>
<td width="50%"><input size="55" name="name" value="<?php echo $row->name; ?>" /></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td align="right"><?php echo ucfirst(_MBL_CATEGORY_NAME . " " . _MBL_ORDERING_1); ?>:</td>
<td><?php echo $lists['ordering']; ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td align="right"><?php echo _MBL_CHANGE_CREATION_DATE . " " . _MBL_CREATION_DATE_FORMAT; ?></td>
<td>
<input class="text_area" type="text" name="date_created" id="date_created" size="25" maxlength="19" value="<?php echo $row->date_created ? $row->date_created : date("Y-m-d\ H:i:s"); ?>" />
<input name="reset" type="reset" class="button" value="..." onclick="return showCalendar('date_created', '%Y-%m-%d');">
</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td align="right"><?php echo _MBL_DEFAULT_TITLE_FOR_THIS_CATEGORY ?></td>
<td><input size="55" name="default_title" value="<?php echo $row->default_title; ?>" /></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td align="right"><?php echo _MBL_SELECT_RANDOM_FIELDS_NUMBER ?></td>
<td><input size="3" name="select_random_fields_number" value="<?php echo $row->select_random_fields_number; ?>" /></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_ALWAYSSHOWBEFOREANDAFTER; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"alwaysshowbeforeandafter", "", ($row->alwaysshowbeforeandafter ? "1" : "0")); ?></td>
</tr>

<tr><th colspan="2"><div style="position: relative; text-align: center;"><div style="margin-right: 9em;"><?php echo _MBL_CATEGORY_MESSAGES_TO_USER; ?></div><div style="position: absolute; top: 0; right: 0; float: right; margin: 0 2px 0 auto;"><a href="javascript:toggleClassVisibility('tr', 'mblcatmessagestouser');"><?php echo _MBL_SHOW_HIDE; ?></a></div></div></th></tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatmessagestouser" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_CATEGORY_MESSAGE1; ?></td>
<td><textarea cols="50" rows="8" name="category_message1"><?php echo $row->category_message1; ?></textarea></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatmessagestouser" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_CSS_CATEGORY_MESSAGE1 ?></td>
<td><input size="100" name="css_category_message1" value="<?php echo $row->css_category_message1; ?>" /></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatmessagestouser" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_CATEGORY_MESSAGE2; ?></td>
<td><textarea cols="50" rows="8" name="category_message2"><?php echo $row->category_message2; ?></textarea></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatmessagestouser" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_CSS_CATEGORY_MESSAGE2 ?></td>
<td><input size="100" name="css_category_message2" value="<?php echo $row->css_category_message2; ?>" /></td>
</tr>

<tr><th colspan="2"><div style="position: relative; text-align: center;"><div style="margin-right: 9em;"><?php echo _MBL_SCORESCRIPT_SETTINGS; ?></div><div style="position: absolute; top: 0; right: 0; float: right; margin: 0 2px 0 auto;"><a href="javascript:toggleClassVisibility('tr', 'mblscorescriptoptions');"><?php echo _MBL_SHOW_HIDE; ?></a></div></div></th></tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblscorescriptoptions" style="visibility: visible;">
<td align="right"><?php echo _MBL_DEFAULT_SCORESCRIPT_FOR_THIS_CATEGORY ?></td>
<td><?php echo $lists['scorescripts']; ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblscorescriptoptions" style="visibility: visible;">
<td align="right"><?php echo _MBL_ARCHIVE_SCORESCRIPT_FOR_THIS_CATEGORY ?></td>
<td><?php echo $lists['archivescorescripts']; ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblscorescriptoptions" style="visibility: visible;">
<td align="right"><?php echo _MBL_CSS_ARCHIVE_SCORESCRIPT ?></td>
<td><input size="100" name="css_archive_score_script" value="<?php echo $row->css_archive_score_script; ?>" /></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblscorescriptoptions" style="visibility: visible;">
<td align="right"><?php echo _MBL_HIDE_RECORD_CONTENT ?></td>
<td><?php echo preg_replace('/>(.+?)<input/s', '>\1<br /><input', JHTML::_('select.booleanlist', 'hide_record_content', '', $row->hide_record_content, _MBL_HIDE_RECORD_CONTENT_YES, _MBL_HIDE_RECORD_CONTENT_NO)); ?></td>
</tr>

<tr><th colspan="2"><div style="position: relative; text-align: center;"><div style="margin-right: 9em;"><?php echo _MBL_APPEARANCE_SETTINGS; ?></div><div style="position: absolute; top: 0; right: 0; float: right; margin: 0 2px 0 auto;"><a href="javascript:toggleClassVisibility('tr', 'mblcatappearance');"><?php echo _MBL_SHOW_HIDE; ?></a></div></div></th></tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatappearance" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_SHOW_CATEGORY_TITLE; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"show_category_title", "", ($row->show_category_title ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatappearance" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_SHOW_INDIVIDUAL_TITLE; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"show_individual_title", "", ($row->show_individual_title ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatappearance" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_SHOW_ENTERED_BY; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"show_entered_by", "", ($row->show_entered_by ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatappearance" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_SHOW_DATE_CREATED; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"show_date_created", "", ($row->show_date_created ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatappearance" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_SHOW_MODIFIED_BY; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"show_modified_by", "", ($row->show_modified_by ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatappearance" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_SHOW_MODIFIED_DATE; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"show_modified_date", "", ($row->show_modified_date ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatappearance" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_SHOW_SELF_LINK; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"show_self_link", "", ($row->show_self_link ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatappearance" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_SHOW_HOME_LINK; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"show_home_link", "", ($row->show_home_link ? "1" : "0")); ?></td>
</tr>

<tr><th colspan="2"><div style="position: relative; text-align: center;"><div style="margin-right: 9em;"><?php echo _MBL_STYLE_SETTINGS; ?></div><div style="position: absolute; top: 0; right: 0; float: right; margin: 0 2px 0 auto;"><a href="javascript:toggleClassVisibility('tr', 'mblcatstyle');"><?php echo _MBL_SHOW_HIDE; ?></a></div></div></th></tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatstyle" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_CONTAINER_DIV_CSS; ?></td>
<td><input size="55" name="container_div_css" value="<?php echo $row->container_div_css; ?>" /></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatstyle" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_MASTER_CSS; ?></td>
<td><input size="55" name="master_css" value="<?php echo $row->master_css; ?>" /></td>
</tr>

<tr><th colspan="2"><div style="position: relative; text-align: center;"><div style="margin-right: 9em;"><?php echo _MBL_RANDOMIZATION_SETTINGS; ?></div><div style="position: absolute; top: 0; right: 0; float: right; margin: 0 2px 0 auto;"><a href="javascript:toggleClassVisibility('tr', 'mblcatrand');"><?php echo _MBL_SHOW_HIDE; ?></a></div></div></th></tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatrand" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_RANDOMIZER; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"allow_randomizer", "", ($row->allow_randomizer ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatrand" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_NAME_FOR_RANDOMIZED ?></td>
<td><input size="55" name="name_for_randomized" value="<?php echo $row->name_for_randomized; ?>" /></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatrand" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_SHOW_SELF_BUTTON; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"show_self_button", "", ($row->show_self_button ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatrand" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_SHOW_HOME_LINK_RANDOMIZED; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"show_home_link_for_randomized", "", ($row->show_home_link_for_randomized ? "1" : "0")); ?></td>
</tr>

<tr><th colspan="2"><div style="position: relative; text-align: center;"><div style="margin-right: 9em;"><?php echo _MBL_VIEW_EDIT_PERMISSIONS; ?></div><div style="position: absolute; top: 0; right: 0; float: right; margin: 0 2px 0 auto;"><a href="javascript:toggleClassVisibility('tr', 'mblcatpermissions');"><?php echo _MBL_SHOW_HIDE; ?></a></div></div></th></tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right" style="border-bottom-width: 0;"><?php echo _MBL_USER_LOGGED_SAVE; ?></td>
<td style="border-bottom-width: 0;"><?php echo $lists['user_logged_save']; ?></td>
</tr>

<tr class="row<?php echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right" style="border-top-width: 0;"><?php echo _MBL_USER_LOGGED_NOSAVE_SCORESCRIPT; ?></td>
<td style="border-top-width: 0;"><?php echo $lists['user_logged_nosave_scorescript']; ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right" style="border-bottom-width: 0;"><?php echo _MBL_USER_NOT_LOGGED_SAVE; ?></td>
<td style="border-bottom-width: 0;"><?php echo $lists['user_not_logged_save']; ?></td>
</tr>

<tr class="row<?php echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right" style="border-top-width: 0;"><?php echo _MBL_USER_NOT_LOGGED_NOSAVE_SCORESCRIPT; ?></td>
<td style="border-top-width: 0;"><?php echo $lists['user_not_logged_nosave_scorescript']; ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_FRONTEND_EDITING; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"allow_frontend_editing", "", ($row->allow_frontend_editing ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_FRONTEND_MODULE_EDITING; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"allow_frontend_module_editing", "", ($row->allow_frontend_module_editing ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_FRONTEND_VIEWING; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"allow_frontend_viewing", "", ($row->allow_frontend_viewing ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_FRONTEND_MODULE_VIEWING; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"allow_frontend_module_viewing", "", ($row->allow_frontend_module_viewing ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FRONTEND_SHOW_IN_LIST; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"frontend_show_in_list", "", ($row->frontend_show_in_list ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FRONTEND_SHOW_IN_CSR_LIST; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"frontend_show_in_csr_list", "", ($row->frontend_show_in_csr_list ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_HTML_INPUT; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"allow_html_input", "", ($row->allow_html_input ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_RANDOM_TAG; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"allow_random_tag", "", ($row->allow_random_tag ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_LOOKUP_TAG; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"allow_lookup_tag", "", ($row->allow_lookup_tag ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_FRONTEND_AUTO_APPROVE; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"frontend_auto_approve", "", ($row->frontend_auto_approve ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right" style="color: red;"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_MODULE_APPROVE; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"allow_module_approve", "", ($row->allow_module_approve ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right" style="color: red;"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_MODULE_PUBLISH; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"allow_module_publish", "", ($row->allow_module_publish ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_RESTRICT_VIEWING_TO_CREATOR; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"restrict_viewing_to_creator", "", ($row->restrict_viewing_to_creator ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_VIEWING_CREATORLESS_RECORDS; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"allow_viewing_creatorless_records", "", ($row->allow_viewing_creatorless_records ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatpermissions" style="visibility: collapse; display: none;">
<td align="right"><?php echo _MBL_FOR_THIS_CATEGORY . _MBL_ADMINS_SEE_ALL_CREATORS; ?></td>
<td><?php echo JHTML::_('select.booleanlist',"admins_see_all_creators", "", ($row->admins_see_all_creators ? "1" : "0")); ?></td>
</tr>

<tr><th colspan="2"><div style="position: relative; text-align: center;"><div style="margin-right: 9em;"><?php echo _MBL_NOTES_SETTINGS; ?></div><div style="position: absolute; top: 0; right: 0; float: right; margin: 0 2px 0 auto;"><a href="javascript:toggleClassVisibility('tr', 'mblcatadminnotes');"><?php echo _MBL_SHOW_HIDE; ?></a></div></div></th></tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatadminnotes" style="visibility: visible;">
<td align="right"><?php echo _MBL_NOTES_NOT_VISIBLE_ON_WEBSITE; ?></td>
<td><textarea cols="40" rows="5" name="notes"><?php echo $row->notes; ?></textarea></td>
</tr>

<tr><th colspan="2"><div style="position: relative; text-align: center;"><div style="margin-right: 9em;"><?php echo _MBL_SPECIAL_TAG_DESCRIPTIONS_CAT; ?></div><div style="position: absolute; top: 0; right: 0; float: right; margin: 0 2px 0 auto;"><a href="javascript:toggleClassVisibility('tr', 'mblcatspectags');"><?php echo _MBL_SHOW_HIDE; ?></a></div></div></th></tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?> mblcatspectags" style="visibility: collapse; display: none;"><td colspan="2">
content
<?php
$lang_code = &JFactory::getLanguage();
$lang_code = $lang_code->_lang;

if (file_exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'language'.DS.$lang_code.'.com_madblanks.category.php' )) {
/**
 * Include the configured language file
 */
	include_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'language'.DS.$lang_code.'.com_madblanks.category.php';
} 
else {
/**
 * If no configured language, include the default English language file
 */
	include_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'language'.DS.'en-US.com_madblanks.category.php';
}
?>

</td></tr>

<tr><th colspan="2"><div style="position: relative; text-align: center;"><div style="margin-right: 9em;"><?php echo _MBL_FIELD_SETTINGS; ?></div><div style="position: absolute; top: 0; right: 0; float: right; margin: 0 2px 0 auto;"><a href="javascript:toggleLayers();"><?php echo _MBL_SHOW_HIDE_ADVANCED_ALL; ?></a></div></div></th></tr>
</table>

<table border="0" cellpadding="3" cellspacing="0" class="adminlist" style="border-spacing: 0;">

<tr><td colspan="7"><hr /></td></tr>

<?php
global $mbFieldCount, $mbDefaultNumColumns, $mbDefaultTextareaWidth, $mbDefaultTextareaHeight; // $mbFieldCount set at the top of this file
for ($i=1; $i <= $mbFieldCount; $i++) {
	$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable

	?>
	<tr class="row<?php echo $i % 2 == 1 ? 0 : 1 ?>">
	<td align="right" valign="middle" style="border-bottom: 0;"><?php echo _MBL_FIELD; ?> #<?php echo $i ?>: </td>
	<td align="left" colspan="6" valign="middle" style="border-bottom: 0;">
	
	<table width="100%" style="border-width: 0;">
	<tr>
	<td rowspan="2" style="min-width: 8em;">
	
	&nbsp;&nbsp;
	<?php	echo _MBL_USE_THIS_FIELD . '<br />';
	echo JHTML::_('select.booleanlist',"data_" . $theindex . "_use", "", $row->{"data_" . $theindex . "_use"});
	?>
	
	</td>
	<td rowspan="2">
	
	<?php echo copyMbCatFieldSetting($theindex, array(array('data_#_use', 'radio'))); ?>
	
	</td>
	<td colspan="2" width="80%">
	
	<?php if (!empty($validate_error_field_list[$theindex])) { echo "<span style=\"color: red; background-color: yellow; font-weight: bold; padding: 2px;\">" . _MBL_FIELD_NAME . "</span>"; } else { echo _MBL_FIELD_NAME; } ?><span style="font-size: larger;">*</span>:<!-- /td -->
	<!-- td style="border-bottom: 0;" --><?php echo "<input size=\"40\" style=\"width: 100%;\" name=\"data_" . $theindex . "_name\" id=\"name" . $theindex . "\" value=\"" . $row->{"data_".$theindex."_name"} . "\" />";  ?>

	</td>
	<td>
	
	<?php echo copyMbCatFieldSetting($theindex, array(array('data_#_name', 'input'))); ?>
	
	</td>
	</tr>

	<tr>
	<!-- td>placeholder</td -->
	<!-- td>placeholder</td -->
	
	<td style="width: 1cm;">&nbsp;</td>
	
	<td>
	
	<?php echo _MBL_PARTOFSPEECH; ?><!-- /td -->
	<!-- td style="border-bottom: 0;" --><?php echo "<input size=\"40\" style=\"width: 96%;\" name=\"data_" . $theindex . "_partofspeech\" value=\"" . $row->{"data_".$theindex."_partofspeech"} . "\" />";  ?></td>
	
	<td>
	
	<?php echo copyMbCatFieldSetting($theindex, array(array('data_#_partofspeech', 'input'))); ?>
	
	</td>
	</tr>
	</table>
	</td>
	</tr>


	<tr class="row<?php echo $i % 2 == 1 ? 0 : 1 ?>">
	<td style="border-bottom: 0;">&nbsp;</td>
	<td colspan="2" valign="top" style="border-bottom: 0;"><?php echo _MBL_BEFORE_TEXT . " " . JString::strtolower(_MBL_FIELD_TEXT); ?>:
	<?php echo "<input size=\"55\" style=\"width: 100%;\" name=\"data_" . $theindex . "_before\" value=\"" . $row->{"data_".$theindex."_before"} . "\" />";  ?></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('data_#_before', 'input'))); ?></td>
	<td colspan="2" valign="top" style="border-bottom: 0;"><?php echo _MBL_AFTER_TEXT . " " . JString::strtolower(_MBL_FIELD_TEXT); ?>:
	<?php echo "<input size=\"55\" style=\"width: 100%;\" name=\"data_" . $theindex . "_after\" value=\"" . $row->{"data_".$theindex."_after"} . "\" />";  ?></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('data_#_after', 'input'))); ?>
	</td>
	</tr>

	<tr><?php /* 1.1.0rc2 removed class; was: <tr class="row<?php echo $i % 2 == 1 ? 0 : 1 ?>"> to allow mouseover highlighting of sub-table rows in 1.5.x */ ?>
	<td>&nbsp;</td>

	<td colspan="6">

		<div align="right" style="margin: 2em 2em 8px 0;"><a href="javascript:toggleLayer('field<?php echo $theindex; ?>');"><?php echo _MBL_SHOW_HIDE_ADVANCED; ?></a></div>

		<?php 
		$configarray = parseDataConfigString($row->{"data_".$theindex."_config"});
		$row0or1_a = 0;
		?>

		<table id="field<?php echo $theindex; ?>" align="center" border="0" style="border-collapse: collapse; border: 1px solid black; text-align: center; display: none;" class="adminlist" onmouseover="makeElementVisible('marginfieldmarker<?php echo $theindex; ?>', true);" onmouseout="makeElementVisible('marginfieldmarker<?php echo $theindex; ?>', false);">

		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>

		<div id="marginfieldmarker<?php echo $theindex; ?>" style="display: none; visibility: hidden; position: fixed; left:0; top: 25%; background-color: #000033; color: #ffffff; padding: 6px; text-align: center; font-size: 10pt;"><?php printf(_MBL_FIELD_MARGIN_MARKER, $i); ?></div>

		<div style="margin-left: 15%; margin-right: 2%;">

		<?php

		echo "<b>" . _MBL_INPUT_TYPE . "</b><br />\n";

		$inputtypes = array(JHTML::_('select.option', '0', _MBL_USE_INPUT), JHTML::_('select.option', '1', _MBL_USE_TEXTAREA), JHTML::_('select.option', 'radio', _MBL_USE_RADIO), JHTML::_('select.option', 'checkbox', _MBL_USE_CHECKBOX), JHTML::_('select.option', 'pulldown', _MBL_USE_PULLDOWN), JHTML::_('select.option', 'multi', _MBL_USE_MULTIPLE_MENU), JHTML::_('select.option', 'hidden', _MBL_USE_HIDDEN));
		echo JHTML::_('select.radiolist', $inputtypes, 'usetextarea_' . $theindex, "onclick=\"autoEnableMultipleChoice(this)\"", 'value', 'text', empty($configarray['usetextarea']) ? '0' : $configarray['usetextarea']);
		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('usetextarea_#', 'radio'))); ?></td></tr>

		<?php /* 1.4.0 RC1 20100801 add field attributes readonly and disabled */ ?>
		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">
		
		<?php
		echo "<b>" . _MBL_FORM_INPUT_ATTRIBUTE . "</b><br />\n";

		$inputtypes = array(JHTML::_('select.option','normal', _MBL_FORM_INPUT_ATTRIBUTE_NORMAL), JHTML::_('select.option','readonly', _MBL_FORM_INPUT_ATTRIBUTE_READONLY), JHTML::_('select.option','disabled', _MBL_FORM_INPUT_ATTRIBUTE_DISABLED));
		echo JHTML::_('select.radiolist', $inputtypes, "inputattribute_" . $theindex, '', 'value', 'text', isset($configarray['inputattribute']) ? $configarray['inputattribute'] : 'normal');
		
		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('inputattribute_#', 'radio'))); ?></td></tr>

		<?php /* 1.4.0 RC1 20100731 add manual CSS-based size settings */ ?>
		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">

		<?php // Show form field horizontally (inline) or vertically (insert <br /> in between options)
		echo "<b>" . _MBL_INUPT_SIZES . "</b><br />\n";
		$mbfieldheightvalue = isset($configarray['fieldheightvalue']) ? $configarray['fieldheightvalue'] : '';
		$mbfieldheightunit = isset($configarray['fieldheightunit']) ? $configarray['fieldheightunit'] : '';
		$mbfieldwidthvalue = isset($configarray['fieldwidthvalue']) ? $configarray['fieldwidthvalue'] : '';
		$mbfieldwidthunit = isset($configarray['fieldwidthunit']) ? $configarray['fieldwidthunit'] : '';
		
		$inputtypes = array( 
			JHTML::_('select.option', '', ''),
			JHTML::_('select.option', '%', '% - percent'),
			JHTML::_('select.option', 'cm', 'cm - centimeters'),
			JHTML::_('select.option', 'em', 'em - em-height'),
			JHTML::_('select.option', 'ex', 'ex - x-height'),
			JHTML::_('select.option', 'in', 'in - inches'),
			JHTML::_('select.option', 'mm', 'mm - millimeters'),
			JHTML::_('select.option', 'pc', 'pc - picas'),
			JHTML::_('select.option', 'pt', 'pt - points'),
			JHTML::_('select.option', 'px', 'px - pixels')
		);
		
		echo "<table>\n";
		echo '<tr><td style="text-align: right;">' . _MBL_INUPT_SIZE_WIDTH . ' </td><td style="padding-right: 0; margin-right: 0;"><input size="6" maxlength="20" name="fieldwidthvalue_' . $theindex . '" value="' . $mbfieldwidthvalue . '" style="text-align: right;" /></td>';
		echo '<td style="padding-left: 0; margin-left: 0;">' . JHTML::_('select.genericlist',$inputtypes, "fieldwidthunit_" . $theindex, null, 'value', 'text', $mbfieldwidthunit) . "</td>\n";
		echo '<td style="text-align: right;">' . _MBL_INUPT_SIZE_HEIGHT . ' </td><td style="padding-right: 0; margin-right: 0;"><input size="6" maxlength="20" name="fieldheightvalue_' . $theindex . '" value="' . $mbfieldheightvalue . '" style="text-align: right;" /></td>';
		echo '<td style="padding-left: 0; margin-left: 0;">' . JHTML::_('select.genericlist',$inputtypes, "fieldheightunit_" . $theindex, null, 'value', 'text', $mbfieldheightunit) . "</td></tr>\n";
		echo "</table>\n";

		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('fieldwidthvalue_#', 'input'), array('fieldwidthunit_#', 'pulldown'), array('fieldheightvalue_#', 'input'), array('fieldheightunit_#', 'pulldown'))); ?></td></tr>

		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">


		<?php // Show form field horizontally (inline) or vertically (insert <br /> in between options)
		echo "<b>" . _MBL_HORIZORVERT . "</b><br />\n";
		$mbhorizorvert = (isset($configarray['horizorvert']) && $configarray['horizorvert'] == 'horizontal') ? 'horizontal' : 'vertical';
		$inputtypes = array( JHTML::_('select.option', 'vertical', _MBL_VERTICAL), JHTML::_('select.option', 'horizontal', _MBL_HORIZONTAL));
		echo JHTML::_('select.radiolist',$inputtypes, "horizorvert_" . $theindex, null, 'value', 'text', $mbhorizorvert);

		echo "\n<br />\n" . _MBL_RADIO_CHECKBOX_NUMCOLUMNS;
		$numcolumns = empty($configarray['numcolumns']) ? (isset($mbDefaultNumColumns) ? $mbDefaultNumColumns : 1) : $configarray['numcolumns'];
		?>
		<input size="4" maxlength="4" name="numcolumns_<?php echo $theindex; ?>" value="<?php echo (int) $numcolumns; ?>" />
		
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('horizorvert_#', 'radio'), array('numcolumns_#', 'input'))); ?></td></tr>

		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">
		<?php

		echo "<b>" . _MBL_USE_MULTIPLECHOICE . "</b><br />\n";

		//$usemultchoice = $configarray['usemultchoice'] ? $configarray['usemultchoice'] : 0;
		$usemultchoice = !empty($configarray['usemultchoice']) ? $configarray['usemultchoice'] : 0;
		echo JHTML::_('select.booleanlist',"usemultchoice_" . $theindex, '', $usemultchoice, _MBL_USE_MULTIPLECHOICE_YES, _MBL_USE_MULTIPLECHOICE_NO);
		

		echo "<b>" . _MBL_MULTIPLECHOICE_LIST . "</b>\n";

		//echo "<input size=\"75\" name=\"multchoice_" . $theindex . "\" value=\"" . (!empty($configarray['multchoice']) ? $configarray['multchoice'] : "") . "\" />";
		echo "<textarea style=\"width: 100%;\" cols=\"50\" rows=\"6\" name=\"multchoice_" . $theindex . "\">" . ((isset($configarray['multchoice']) && $configarray['multchoice'] != '') ? convertMBEscapedToLiteral($configarray['multchoice']) : "") . "</textarea>\n";

		echo "<b>" . _MBL_SHORTMULTIPLECHOICE_LIST . "</b>\n";
		
		//echo "<textarea style=\"width: 100%;\" cols=\"50\" rows=\"2\" name=\"multchoiceshort_" . $theindex . "\">" . ((isset($configarray['multchoice']) && $configarray['multchoice'] != '') ? convertMBEscapedToLiteral($configarray['multchoice']) : "") . "</textarea>\n";
		echo "<input style=\"width: 100%;\" size=\"50\" name=\"shortmultchoice_" . $theindex . "\" value=\"" . ((isset($configarray['shortmultchoice']) && $configarray['shortmultchoice'] != '') ? convertMBEscapedToLiteral(convertToQuotLtGt($configarray['shortmultchoice'])) : "") . "\" />\n";

		echo "<br /><br />\n<b>" . _MBL_USE_SQL_MULTIPLECHOICE . "</b><br />\n";

		//$usemultchoice = $configarray['usemultchoice'] ? $configarray['usemultchoice'] : 0;
		$usemultchoice = !empty($configarray['usesqlmultchoice']) ? $configarray['usesqlmultchoice'] : 0;
		echo JHTML::_('select.booleanlist',"usesqlmultchoice_" . $theindex, '', $usemultchoice, _MBL_USE_SQL_MULTIPLECHOICE_YES, _MBL_USE_SQL_MULTIPLECHOICE_NO);
		
		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('usemultchoice_#', 'radio'), array('multchoice_#', 'textarea'), array('shortmultchoice_#', 'input'), array('usesqlmultchoice_#', 'radio'))); ?></td></tr>

		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">
		<?php

		echo "<b>" . _MBL_USE_RANDOMORDER . "</b><br />\n";

		//$randomorder = $configarray['randomorder'] ? $configarray['randomorder'] : 0;
		$randomorder = !empty($configarray['randomorder']) ? $configarray['randomorder'] : 0;
		echo JHTML::_('select.booleanlist',"randomorder_" . $theindex, '', $randomorder, _MBL_USE_RANDOMORDER_YES, _MBL_USE_RANDOMORDER_NO);
		
		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('randomorder_#', 'radio'))); ?></td></tr>

		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">
		<?php

		echo "<b>" . _MBL_SUBMIT_ON_CHANGE . "</b><br />\n";

		$thedefault = !empty($configarray['submitonchange']) ? $configarray['submitonchange'] : 0;
		echo JHTML::_('select.booleanlist',"submitonchange_" . $theindex, "", $thedefault, _MBL_SUBMIT_ON_CHANGE_YES, _MBL_SUBMIT_ON_CHANGE_NO);
		
		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('submitonchange_#', 'radio'))); ?></td></tr>

		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">

		<?php

		echo "<b>" . _MBL_MULTIPLECHOICE_DEFAULT . "</b>\n";
		
		// CPH 20110220 1.4.2 Add JavaScript link to make what user entered last time the default 
		if (!empty($row->id)) {
			echo '<p><a href="javascript:void(0);" onclick="document.forms.adminForm[\'multdefault_'. $theindex . '\'].value = \'[:mostrecentlookup@' . $i . ',' . $row->id . ',userorsession:]\'">' . _MBL_MULTIPLECHOICE_USE_LAST_TIME . "</a></p>\n";
		}
		else {
			echo '<p style="color: #666666;">' . _MBL_MULTIPLECHOICE_USE_LAST_SAVE . "</p>\n";
		}
		
		echo "<input style=\"width: 100%;\" size=\"50\" name=\"multdefault_" . $theindex . "\" value=\"" . ((isset($configarray['multdefault']) && $configarray['multdefault'] != '') ? convertMBEscapedToLiteral(convertToQuotLtGt($configarray['multdefault'])) : "") . "\" />\n";

		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('multdefault_#', 'input'))); ?></td></tr>
		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">
		<table border="0"><tr><td>
		<?php

		echo "<b>" . _MBL_MULTIPLECHOICE_CORRECT . "</b>\n";

		echo "</td><td style=\"vertical-align: bottom;\">";

		echo "<b>" . _MBL_MULTIPLECHOICE_BLANK_IS_CORRECT . "</b>\n";

		echo "</td></tr>\n<tr><td>";

		echo "<input style=\"width: 100%;\" size=\"50\" name=\"multcorrect_" . $theindex . "\" value=\"" . ((isset($configarray['multcorrect']) && $configarray['multcorrect'] != '') ? convertMBEscapedToLiteral(convertToQuotLtGt($configarray['multcorrect'])) : "") . "\" onchange=\"autoClearBlankIsCorrect(this)\" />\n";
		
		echo "</td>\n<td>\n";
		
		?>
		<input type="checkbox" name="blankiscorrect_<?php echo $theindex; ?>" value="true" <?php echo (!empty($configarray['blankiscorrect'])) ? 'checked="checked" ' : ''?>/>
		<?php
		
		echo "</td></tr></table>\n";
		
		echo "<b>" . _MBL_MULTIPLECHOICE_CASE_CORRECT . "</b>\n";
		
		//$randomorder = $configarray['randomorder'] ? $configarray['randomorder'] : 0;
		$thedefault = !empty($configarray['multcasecorrect']) ? $configarray['multcasecorrect'] : 0;
		echo JHTML::_('select.booleanlist',"multcasecorrect_" . $theindex, '', $thedefault, _MBL_MULTIPLECHOICE_CASE_CORRECT_YES, _MBL_MULTIPLECHOICE_CASE_CORRECT_NO);
		
		?>
		
		</td><td><?php echo copyMbCatFieldSetting($theindex, array(array('multcorrect_#', 'input'), array('multcasecorrect_#', 'radio'), array('blankiscorrect_#', 'checkbox'))); ?></td>
		</tr>

		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">
		<?php

		echo "<b>" . _MBL_MULTIPLECHOICE_POINTVALUE . "</b>\n";

		// don't use empty() because this value could be a zero
		//$pointvalue = $configarray['pointvalue'] != '' ? $configarray['pointvalue'] : "";
		$pointvalue = (isset($configarray['pointvalue']) && $configarray['pointvalue'] != '') ? $configarray['pointvalue'] : "";
		echo "<input style=\"width: 10%;\" size=\"10\" name=\"pointvalue_" . $theindex . "\" value=\"" . $pointvalue . "\" />\n";
				
		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('pointvalue_#', 'input'))); ?></td></tr>

		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">
		<?php

		echo "<b>" . _MBL_POINTVALUE_PER_RESPONSE . "</b>\n";

		// don't use empty() because this value could be a zero
		//$ptsperrspns = $configarray['ptsperrspns'] != '' ? $configarray['ptsperrspns'] : "";
		$ptsperrspns = (isset($configarray['ptsperrspns']) && $configarray['ptsperrspns'] != '') ? $configarray['ptsperrspns'] : "";
		echo "<input style=\"width: 20%;\" size=\"20\" name=\"ptsperrspns_" . $theindex . "\" value=\"" . $ptsperrspns . "\" />\n";
				
		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('ptsperrspns_#', 'input'))); ?></td></tr>

		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">

		<?php

		echo "<b>" . _MBL_VALIDATE_ENABLE . "</b><br />\n"; // added in 1.1.0rc2

		//$validatevar = !empty($configarray['validateenable']) ? 1 : 0;
		//echo JHTML::_('select.booleanlist',"validateenable_" . $theindex, "", $validatevar);

		$validatevar = isset($configarray['validateenable']) && $configarray['validateenable'] != '' ? $configarray['validateenable'] : '0';
		$inputtypes = array( JHTML::_('select.option', '0', _MBL_NONE), JHTML::_('select.option', 'both', _MBL_VALIDATE_ENABBOTH), JHTML::_('select.option', 'server', _MBL_VALIDATE_ENABSERVER), JHTML::_('select.option', 'client', _MBL_VALIDATE_ENABCLIENT));
		echo JHTML::_('select.radiolist',$inputtypes, "validateenable_" . $theindex, null, 'value', 'text', $validatevar);

		echo "<br /><br /><b>" . _MBL_VALIDATE_REGEXP . "</b><br />\n"; // added in 1.1.0rc2
		
		// don't use empty() because this value could be a zero
		$validatevar = (isset($configarray['validateregexp']) && $configarray['validateregexp'] != '') ? strval(convertToQuotLtGt(convertMBEscapedToLiteral($configarray['validateregexp']))) : '';
		echo "<input style=\"width: 100%;\" size=\"80\" name=\"validateregexp_" . $theindex . "\" value=\"" . $validatevar . "\" /><br />\n";

		echo "<br /><b>" . _MBL_VALIDATE_ERRMSG . "</b><br />\n"; // added in 1.1.0rc2
		
		// don't use empty() because this value could be a zero
		$validatevar = (isset($configarray['validateerrmsg']) && $configarray['validateerrmsg'] != '') ? strval(convertToQuotLtGt(convertMBEscapedToLiteral($configarray['validateerrmsg']))) : _MBL_VALIDATE_DEFAULT_ERRMSG;
		echo "<input size=\"80\" name=\"validateerrmsg_" . $theindex . "\" value=\"" . $validatevar . "\" /><br />\n";
		
		
		echo "<br /><b>" . _MBL_VALIDATE_DOWIPE . "</b><br />\n";
				
		$thedefault = !empty($configarray['validatewipe']) ? $configarray['validatewipe'] : 0;
		echo JHTML::_('select.booleanlist','validatewipe_' . $theindex, '', $thedefault, _MBL_VALIDATE_WIPE_YES, _MBL_VALIDATE_WIPE_NO);

		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('validateenable_#', 'radio'), array('validateregexp_#', 'input'), array('validateerrmsg_#', 'input'), array('validatewipe_#', 'radio'))); ?></td></tr>

		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">

		<b><?php echo _MBL_APPLY_FORMATTING_FUNCTIONS; ?></b><br />
		<input type="checkbox" name="strtoupper_<?php echo $theindex; ?>" value="true" <?php echo (!empty($configarray['strtoupper'])) ? 'checked="checked" ' : ''?>/>
		<?php echo _MBL_APPLY_FORMATTING_STRTOUPPER; ?><br />
		<input type="checkbox" name="strtolower_<?php echo $theindex; ?>" value="true" <?php echo (!empty($configarray['strtolower'])) ? 'checked="checked" ' : ''?>/>
		<?php echo _MBL_APPLY_FORMATTING_STRTOLOWER; ?><br />
		<input type="checkbox" name="ucwords_<?php echo $theindex; ?>" value="true" <?php echo (!empty($configarray['ucwords'])) ? 'checked="checked" ' : ''?>/>
		<?php echo _MBL_APPLY_FORMATTING_UCWORDS; ?><br />
		<input type="checkbox" name="ucfirst_<?php echo $theindex; ?>" value="true" <?php echo (!empty($configarray['ucfirst'])) ? 'checked="checked" ' : ''?>/>
		<?php echo _MBL_APPLY_FORMATTING_UCFIRST; ?><br />

		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('strtoupper_#', 'checkbox'), array('strtolower_#', 'checkbox'), array('ucwords_#', 'checkbox'), array('ucfirst_#', 'checkbox'))); ?></td></tr>
		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">
		<?php

		echo "<b>" . _MBL_CHECKBOX_SEPARATOR_B . "</b>\n"; // added in 1.1.0b3
		
		// don't use empty() because this value could be a zero
		$checkboxsep = (isset($configarray['checkboxsepb']) && $configarray['checkboxsepb'] != '') ? strval(convertToQuotLtGt(convertMBEscapedToLiteral($configarray['checkboxsepb']))) : "";
		echo "<input style=\"width: 20%;\" size=\"20\" name=\"checkboxsepb_" . $theindex . "\" value=\"" . $checkboxsep . "\" /><br />\n";
		
		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('checkboxsepb_#', 'input'))); ?></td></tr>
		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">
		<?php

		echo "<b>" . _MBL_CHECKBOX_SEPARATOR_Y . "</b>\n"; // added in 1.1.0b3
		
		// don't use empty() because this value could be a zero
		$checkboxsep = (isset($configarray['checkboxsepy']) && $configarray['checkboxsepy'] != '') ? strval(convertToQuotLtGt(convertMBEscapedToLiteral($configarray['checkboxsepy']))) : "";
		echo "<input style=\"width: 20%;\" size=\"20\" name=\"checkboxsepy_" . $theindex . "\" value=\"" . $checkboxsep . "\" /><br />\n";
		
		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('checkboxsepy_#', 'input'))); ?></td></tr>
		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">
		<?php

		echo "<b>" . _MBL_CHECKBOX_SEPARATOR_A . "</b>\n"; // added in 1.1.0b3
		
		// don't use empty() because this value could be a zero
		$checkboxsep = (isset($configarray['checkboxsepa']) && $configarray['checkboxsepa'] != '') ? strval(convertToQuotLtGt(convertMBEscapedToLiteral($configarray['checkboxsepa']))) : "";
		echo "<input style=\"width: 20%;\" size=\"20\" name=\"checkboxsepa_" . $theindex . "\" value=\"" . $checkboxsep . "\" /><br />\n";
		
		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('checkboxsepa_#', 'input'))); ?></td></tr>
		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">
		<?php

		echo "<b>" . _MBL_CHECKBOX_SEPARATOR_1 . "</b>\n";
		
		// don't use empty() because this value could be a zero
		//$checkboxsep1 = $configarray['checkboxsep1'] != '' ? strval(convertMBEscapedToLiteral($configarray['checkboxsep1'])) : "";
		$checkboxsep = (isset($configarray['checkboxsep1']) && $configarray['checkboxsep1'] != '') ? strval(convertToQuotLtGt(convertMBEscapedToLiteral($configarray['checkboxsep1']))) : "";
		echo "<input style=\"width: 20%;\" size=\"20\" name=\"checkboxsep1_" . $theindex . "\" value=\"" . ((isset($checkboxsep) && $checkboxsep != '') ? $checkboxsep : ($row->id ? "" : $mbDefaultSeparator1)) . "\" /><br />\n";
		
		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('checkboxsep1_#', 'input'))); ?></td></tr>
		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">
		<?php

		echo "<b>" . _MBL_CHECKBOX_SEPARATOR_2 . "</b>\n";
		
		// don't use empty() because this value could be a zero
		//$checkboxsep2 = $configarray['checkboxsep2'] != '' ? strval(convertMBEscapedToLiteral($configarray['checkboxsep2'])) : "";
		$checkboxsep = (isset($configarray['checkboxsep2']) && $configarray['checkboxsep2'] != '') ? strval(convertToQuotLtGt(convertMBEscapedToLiteral($configarray['checkboxsep2']))) : "";
		echo "<input style=\"width: 20%;\" size=\"20\" name=\"checkboxsep2_" . $theindex . "\" value=\"" . ((isset($checkboxsep) && $checkboxsep != '') ? $checkboxsep : ($row->id ? "" : $mbDefaultSeparator2)) . "\" /><br />\n";

		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('checkboxsep2_#', 'input'))); ?></td></tr>
		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">

		<?php

		echo "<b>" . _MBL_CHECKBOX_SEPARATOR_Z . "</b>\n"; // added in 1.1.0b3
		
		// don't use empty() because this value could be a zero
		$checkboxsep = (isset($configarray['checkboxsepz']) && $configarray['checkboxsepz'] != '') ? strval(convertToQuotLtGt(convertMBEscapedToLiteral($configarray['checkboxsepz']))) : "";
		echo "<input style=\"width: 20%;\" size=\"20\" name=\"checkboxsepz_" . $theindex . "\" value=\"" . $checkboxsep . "\" /><br />\n";

		?>
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('checkboxsepz_#', 'input'))); ?></td></tr>

		<tr class="row<?php $row0or1_a ? $row0or1_a = 0 : $row0or1_a = 1; echo $row0or1_a; ?>">
		<td>
		
		<div style="margin-left: 15%; margin-right: 2%;">

		<?php

		echo '<b>' . _MBL_TEXTAREA_HEIGHT . '</b>'; 

		$textareaheight = $configarray['textareaheight'] ? $configarray['textareaheight'] : ($mbDefaultTextareaHeight ? $mbDefaultTextareaHeight : 3);
		?>
		<input size="4" maxlength="4" name="textareaheight_<?php echo $theindex; ?>" value="<?php echo (int) $textareaheight; ?>" /><br />
		<?php

		echo '<b>' . _MBL_TEXTAREA_WIDTH . '</b>';

		$textareawidth = $configarray['textareawidth'] ? $configarray['textareawidth'] : ($mbDefaultTextareaWidth ? $mbDefaultTextareaWidth : 45);
		?>
		<input size="4" maxlength="4" name="textareawidth_<?php echo $theindex; ?>" value="<?php echo (int) $textareawidth; ?>" />
		
		</div></td><td><?php echo copyMbCatFieldSetting($theindex, array(array('textareaheight_#', 'input'), array('textareawidth_#', 'input'))); ?></td></tr>

		</table>

	</td>
	</tr>

	<tr><td colspan="7"><hr /></td></tr>

<?php
} /* end for loop */ ?>

</table>

</form>

<?php } // end editMadBlanksCategory

/**
 * List all categories (backend)
 *
 * @param string $option Joomla option string from URL
 * @param object &$rows the rows from the database for the categories
 * @param string $task component task string from URL
 * @param object $pageNav Joomla page navigation data (which page number of how many pages, number of records displayed per page)
 */
function htmlListMadBlanksCategories($option, &$rows, $task, &$pageNav) {
	
	setMadBlanksBackEndPageTitle(_MBL_LIST_CATEGORIES_TITLE);
	
	$HTML_MadBlanks = new HTML_MadBlanks();
	$HTML_MadBlanks->htmlDefaultScreen($option, 1);
	
	JHTML::_('behavior.tooltip');
	$my = &JFactory::getUser();
	?>
<form action="index2.php" method="post" name="adminForm">
<table class="adminheading">
<tr>
<th style="background-position: 0% 0%; vertical-align: top;"><div style="margin-top: 10px"><? echo _MBL_LIST_CATEGORIES_TITLE; ?></div></th>
</tr>
</table>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
<tr><th colspan="13" align="center" style="background: url(); border-style: hidden;"><?php echo $pageNav->getPagesCounter() . " &nbsp; &nbsp; &nbsp; " . $pageNav->getPagesLinks(); ?></th></tr>
<tr>
<th width="5">#</th><th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
<th><?php echo _MBL_ID; ?></th>
<th class="title"><?php echo _MBL_NAME; ?></th>
<th><?php echo _MBL_CREATED_DATE; ?></th>
<th><?php echo _MBL_NUMBER_OF_RECORDS; ?></th>
<th>#1 <?php echo _MBL_FIELD_NAME; ?></th>
<th>#2 <?php echo _MBL_FIELD_NAME; ?></th>
<th>#3 <?php echo _MBL_FIELD_NAME; ?></th>
<th>#4 <?php echo _MBL_FIELD_NAME; ?></th>
<th colspan="2"><?php echo _MBL_ORDERING_1; ?></th>
<th><?php echo ucwords(_MBL_PUBLISHED); ?></th></tr>

<?php
	if (count($rows) == 0) {
		echo '<tr><td colspan="14" align="center">' . _MBL_EMPTY_SET_CAT . "</td></tr>\n";
	}

	$k = 0;
	for($i=0; $i < count( $rows ); $i++) {
	$row = $rows[$i];
	
	jimport('joomla.html.html.grid');
	$checked = JHTML::_('grid.checkedout', $row, $i);

   ?>
	<tr class="<?php echo "row$k"; ?>">
	<td><?php /* echo $pageNav->rowNumber( $i ); */ echo $pageNav->getRowOffset($i); ?></td>
	<td><?php echo $checked; ?></td>
	<td><?php echo (isset($row->id) ? $row->id : "&lt;" . _MBL_NO_ID . "&gt;"); ?></td>
	<td>
	<?php

	if ( $row->checked_out && ( $row->checked_out != $my->id )) {
		echo ($row->name ? $row->name : "<em>&lt;" . _MBL_NO_NAME . "&gt;</em>");
	}
	else {
		$link =  'index2.php?option=com_madblanks&task=editcategory&hidemainmenu=1&id='. $row->id;
		?>
		<a href="<?php echo $link ?>"><?php echo ($row->name ? $row->name : "<em>&lt;" . _MBL_NO_NAME . "&gt;</em>"); ?></a>
		<?php
	}
	?>
	</td>
	<td align="center"><?php echo (intval($row->date_created) ? JHTML::_('date', $row->date_created, JText::_('DATE_FORMAT_LC2')) : "<em>&lt;" . _MBL_NO_DATE . "&gt;</em>"); ?></td>
	<td align="center"><?php echo $row->numbertotal; ?></td>
	<td align="center"><?php echo (trim($row->data_01_name) ? $row->data_01_name : "<em>&lt;" . _MBL_NO_NAME . "&gt;</em>"); ?></td>
	<td align="center"><?php echo (trim($row->data_02_name) ? $row->data_02_name : "<em>&lt;" . _MBL_NO_NAME . "&gt;</em>"); ?></td>
	<td align="center"><?php echo (trim($row->data_03_name) ? $row->data_03_name : "<em>&lt;" . _MBL_NO_NAME . "&gt;</em>"); ?></td>
	<td align="center"><?php echo (trim($row->data_04_name) ? $row->data_04_name : "<em>&lt;" . _MBL_NO_NAME . "&gt;</em>"); ?></td>
	<td><?php echo $pageNav->orderUpIcon($i, true, 'orderupcategory'); ?></td>
	<td><?php echo $pageNav->orderDownIcon($i, count($rows), true, 'orderdowncategory'); ?></td>
	<td align="center">
   <?php
	if ($row->published == "1") {
	echo "<a href=\"javascript: void(0);\" onclick=\"return listItemTask('cb$i','unpublishcategories')\"><img src=\"images/publish_g.png\" border=\"0\" /></a>";
	} else {
	echo "<a href=\"javascript: void(0);\" onclick=\"return listItemTask('cb$i','publishcategories')\"><img src=\"images/publish_x.png\" border=\"0\" /></a>";
	}
   ?>
	</td>
	<?php $k = 1 - $k; ?>
	</tr>
<?php }

?>
</table>
<?php echo $pageNav->getListFooter(); ?>

<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="<?php echo $task; ?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="hidemainmenu" value="0" />
</form>

<?php
}

/**
 * List Mad Blanks records (backend)
 *
 * @param string $option Joomla option string from the URL
 * @param object &$rows the rows from the database for the records
 * @param object $pageNav Joomla page navigation data (which page number of how many pages, number of records displayed per page)
 * @param array &$lists pulldown menus
 * @param string $categorylimit filter data to limit category displayed
 * @param string $authorlimit filter data to limit author displayed
 * @param string $sortby which data the list is sorted by
 * @param string $sortascordesc whether the list is sorted ascending or descending
 * @param integer $substring_length the number of characters to show in data previews for list items
 * @param integer $limit the number of records to show at one time in the list (here to make possible custom 1000 items)
 */
function htmlListMadBlanksRecords($option, $task, &$rows, &$pageNav, &$lists, $categorylimit=NULL, $authorlimit=NULL, $sortby=NULL, $sortascordesc=NULL, $substring_length=255, $limit=null) {

	setMadBlanksBackEndPageTitle(_MBL_LIST_RECORDS_TITLE);
	
	$HTML_MadBlanks = new HTML_MadBlanks();
	$HTML_MadBlanks->htmlDefaultScreen($option, 1);
	
	JHTML::_('behavior.tooltip');
	$my = &JFactory::getUser();
?>
<form action="index2.php" method="post" name="adminForm">
<table class="adminheading" style="width: 100%;">
<tr>
	<th style="background-position: 0; vertical-align: top;"><div style="margin-top: 10px;"><?php echo _MBL_LIST_RECORDS_TITLE; ?></div></th>
	<td>
	<table border="0" style="width: 100%;">
		<tr>
		<td align="right" nowrap="nowrap">
		<?php
		if ($categorylimit || $authorlimit) {
			echo '<span class="error">' . _MBL_LIST_IS_FILTERED . '&nbsp;&#8594;&nbsp;&nbsp;&nbsp;</span>';
		}
		echo $lists['categorylimit'];
		echo $lists['authorlimit'];
		?>
		</td>
		</tr>
		<tr>
		<td align="right" nowrap="nowrap">
		<?php
		echo "&nbsp;&nbsp;&nbsp;" . _MBL_SORT_BY . "&nbsp;&nbsp;";
		echo $lists['sortby'];
		echo $lists['sortascordesc'];
		?>
		</td>
		</tr>
		<tr>
		<td align="right" nowrap="nowrap">
		<?php
		echo "&nbsp;&nbsp;&nbsp;" . _MBL_GO_TO_SPECIFIC_RECORD . "&nbsp;&nbsp;";
		?>
		&nbsp;<input size="5" name="jumptorecord" value="" class="inputbox" />&nbsp;<input type="submit"
		value="<?php echo _MBL_SUBMIT_BUTTON; ?>" class="button" onclick="submitbutton('editrecord');return false;" />
		</td>
		</tr>
	</table>
	</td>
</tr>
</table>

<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
<tr><th colspan="15" align="center" style="background: url(); border-style: hidden;"><?php echo $pageNav->getPagesCounter() . " &nbsp; &nbsp; &nbsp; " . $pageNav->getPagesLinks(); ?></th></tr>
<tr>
<th width="5">#</th><th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows);
?>);" /></th>
<th><?php echo ucwords(_MBL_SORT_PULLDOWN_DATE_ENTERED) ?></th>
<th><?php echo ucwords(_MBL_SORT_PULLDOWN_CONFIGID); ?></th>
<th><?php echo ucwords(_MBL_SORT_PULLDOWN_ID); ?></th>
<th class="title"><?php echo ucwords(_MBL_SORT_PULLDOWN_ENTERED_BY); ?></th>
<th><?php echo ucwords(_MBL_SORT_PULLDOWN_TITLE); ?></th>
<th><?php echo ucwords(_MBL_SORT_PULLDOWN_DATA_01); ?></th>
<th><?php echo ucwords(_MBL_SORT_PULLDOWN_DATA_02); ?></th>
<th><?php echo ucwords(_MBL_SORT_PULLDOWN_DATA_03); ?></th>
<th><?php echo ucwords(_MBL_SORT_PULLDOWN_DATA_04); ?></th>
<th><?php echo ucwords(_MBL_SORT_PULLDOWN_SCODATA1); ?></th>
<th><?php echo ucwords(_MBL_SORT_PULLDOWN_COMPLETED); ?></th>
<th><?php echo ucwords(_MBL_SORT_PULLDOWN_APPROVED); ?></th>
<th><?php echo ucwords(_MBL_SORT_PULLDOWN_PUBLISHED); ?></th>
</tr>

<?php
	
	if (count($rows) == 0) {
		echo '<tr><td colspan="15" align="center">' . _MBL_EMPTY_SET_REC . "</td></tr>\n";
	}
	
	$k = 0;
	for($i=0; $i < count( $rows ); $i++) {
	$row = $rows[$i];
	
	jimport('joomla.html.html.grid');
	$checked = JHTML::_('grid.checkedout', $row, $i);

   ?>
	<tr class="<?php echo "row$k"; ?>">
	<td><?php /* echo $pageNav->rowNumber( $i ); */ echo $pageNav->getRowOffset($i); ?></td>
	<td><?php echo $checked; ?></td>
	<td><?php echo (intval($row->date_entered) ? JHTML::_('date', $row->date_entered, JText::_('DATE_FORMAT_LC2')) : "<em>&lt;" . _MBL_NO_DATE . "&gt;</em>"); ?></td>
	<td align="center"><?php echo (trim($row->configid) ? $row->configid : "<em>&lt;" . _MBL_NO . " " . _MBL_CATEGORY_NAME . "&gt;</em>"); ?></td>
	<td><?php echo trim($row->id) ? $row->id : "<em>&lt;" . _MBL_NO . " " . _MBL_ID . "&gt;</em>"; ?></td>
	<td><?php global $mbEnteredByLongFormat; echo $row->entered_by ? getUserNameByID($row->entered_by, $mbEnteredByLongFormat) : ($row->author_alias ? $row->author_alias : "<em>&lt;" . _MBL_NO_AUTHOR . "&gt;</em>"); ?><?php if ($row->session) { echo "<div style=\"" . getHexStyleAttributeByPercentage($row->session, 10000000000) . "\">" . _MBL_SESSION_NUMBER . " " . $row->session . "</div>"; } ?></td>
	<td>
	<?php
	if ( $row->checked_out && ( $row->checked_out != $my->id )) {
		echo wordwrap(trim($row->title) ? $row->title : "<em>&lt;" . JString::strtolower(_MBL_NO . " " . _MBL_TITLE) . "&gt;</em>", 30, "\n", 1);
	}
	else {
		$link =  'index2.php?option=com_madblanks&task=editrecord&hidemainmenu=1&id='. $row->id;
		if ($categorylimit) {
			$link .= "&categorylimit=" . $categorylimit;
		}
		if ($authorlimit) {
			$link .= "&authorlimit=" . $authorlimit;
		}
		if ($sortby) {
			$link .= "&sortby=" . $sortby;
		}
		if ($sortascordesc) {
			$link .= "&sortascordesc=" . $sortascordesc;
		}
		?>
		<a href="<?php echo $link ?>"><?php echo wordwrap((trim($row->title) ? $row->title : "<em>&lt;" . JString::strtolower(_MBL_NO . " " . _MBL_TITLE) . "&gt;</em>"), 30, "\n", 1); ?></a>
		<?php
	}
	?>
	</td>
	<td><?php echo wordwrap((trim($row->data_01) != '' ? (JString::strlen($row->data_01) >= $substring_length + 6 ? JString::substr($row->data_01, 0, $substring_length) . ".&nbsp;.&nbsp;." : JString::substr($row->data_01, 0, $substring_length + 6)) : "<em>&lt;" . _MBL_NO_DATA . "&gt;</em>"), 30, "<br />", 1); ?></td>
	<td><?php echo wordwrap((trim($row->data_02) != '' ? (JString::strlen($row->data_02) >= $substring_length + 6 ? JString::substr($row->data_02, 0, $substring_length) . ".&nbsp;.&nbsp;." : JString::substr($row->data_02, 0, $substring_length + 6)) : "<em>&lt;" . _MBL_NO_DATA . "&gt;</em>"), 30, "<br />", 1); ?></td>
	<td><?php echo wordwrap((trim($row->data_03) != '' ? (JString::strlen($row->data_03) >= $substring_length + 6 ? JString::substr($row->data_03, 0, $substring_length) . ".&nbsp;.&nbsp;." : JString::substr($row->data_03, 0, $substring_length + 6)) : "<em>&lt;" . _MBL_NO_DATA . "&gt;</em>"), 30, "<br />", 1); ?></td>
	<td><?php echo wordwrap((trim($row->data_04) != '' ? (JString::strlen($row->data_04) >= $substring_length + 6 ? JString::substr($row->data_04, 0, $substring_length) . ".&nbsp;.&nbsp;." : JString::substr($row->data_04, 0, $substring_length + 6)) : "<em>&lt;" . _MBL_NO_DATA . "&gt;</em>"), 30, "<br />", 1); ?></td>
	<td><?php echo wordwrap((trim($row->scodata1) != '' ? (JString::strlen($row->scodata1) >= $substring_length + 6 ? JString::substr($row->scodata1, 0, $substring_length) . ".&nbsp;.&nbsp;." : JString::substr($row->scodata1, 0, $substring_length + 6)) : "<em>&lt;" . _MBL_NO_DATA . "&gt;</em>"), 30, "<br />", 1); ?></td>
	<td align="center">
	   <?php
		if ($row->completed > 0) {
		echo "<a href=\"javascript: void(0);\" onclick=\"return listItemTask('cb$i','uncompleterecord')\"><img src=\"images/publish_g.png\" border=\"0\" /></a>";
		} else {
		echo "<a href=\"javascript: void(0);\" onclick=\"return listItemTask('cb$i','completerecord')\"><img src=\"images/publish_x.png\" border=\"0\" /></a>";
		}
	   ?>
	</td>
	<td align="center">
	   <?php
		if ($row->approved > 0) {
		echo "<a href=\"javascript: void(0);\" onclick=\"return listItemTask('cb$i','unapproverecord')\"><img src=\"images/publish_g.png\" border=\"0\" /></a>";
		} else {
		echo "<a href=\"javascript: void(0);\" onclick=\"return listItemTask('cb$i','approverecord')\"><img src=\"images/publish_x.png\" border=\"0\" /></a>";
		}
	   ?>
	</td>
	<td align="center">
   <?php
	if ($row->published == "1") {
	echo "<a href=\"javascript: void(0);\" onclick=\"return listItemTask('cb$i','unpublishrecord')\"><img src=\"images/publish_g.png\" border=\"0\" /></a>";
	} else {
	echo "<a href=\"javascript: void(0);\" onclick=\"return listItemTask('cb$i','publishrecord')\"><img src=\"images/publish_x.png\" border=\"0\" /></a>";
	}
   ?>
	</td>
	<?php $k = 1 - $k; ?>
	</tr>
<?php }

?>
</table>
<?php echo str_replace('<option value="0" >all</option>', $limit == 1000 ? '<option value="1000" selected="selected">1000</option>' : '<option value="1000" >1000</option>', $pageNav->getListFooter()); ?>

<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="<?php echo $task; ?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="hidemainmenu" value="0" />
</form>

<?php
}

/**
 * Edit an individual Mad Blanks record (backend)
 *
 * @param string $option Joomla option string from URL
 * @param object &$row the row from the database for an individual record
 * @param object &$configrow the row from the database for the record's category
 * @param integer $configid the category id number for this record
 * @param array &$lists pulldown menus
 * @param string $categorylimit passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $sortby passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $sortascordesc passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $authorlimit passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 */
function htmlEditMadBlanksRecord ($option, &$row, &$configrow, $configid, &$lists, $categorylimit=NULL, $sortby=NULL, $sortascordesc=NULL, $authorlimit=NULL) {

	setMadBlanksBackEndPageTitle((!empty($row->id) ? _MBL_EDIT : _MBL_NEW) . ' ' . JString::ucfirst(_MBL_RECORD_NAME) . (!empty($row->id) ? ' #' . $row->id : '') . (!empty($row->title) ? ': ' . (function_exists('htmlspecialchars_decode') ? htmlspecialchars_decode($row->title) : $row->title) : ''));
	
	if (empty($configrow)) {
		echo "<div class=\"message\">" . _MBL_INVALID_CATEGORY . "</div>";
	}

	if (!isset($row->configid)) {
		if ($configid) {
			$row->configid = $configid;
		}
		else {
			die ('Unknown configuration. Go back.');
		}
	}

	JHTML::_('behavior.calendar');
?>

<form action="index2.php" method="post" name="adminForm">
<table class="adminheading">
<tr>
<th>
<?php
echo $row->id ? _MBL_EDIT : _MBL_NEW;
echo " " . _MBL_RECORD_NAME;
echo $row->id ? " #" . $row->id . " " : " ";
echo _MBL_USING_CATEGORY;
echo " #" . $row->configid . " [" . getCategoryFieldByID($row->configid) . "]";
?>
</th>
</tr>
</table>

<table border="0" cellpadding="3" cellspacing="0" class="adminlist">

<tr><th colspan="4">
<div style="text-align: center;"><div style="padding: 5px;"><?php echo ucfirst(_MBL_ENTERED_OR_AUTHORED_BY) . ' ';
echo $lists['entered_by'] . ' ';

if (!empty($row->date_entered)) {
	echo _MBL_ON . ' ' . JHTML::_('date', $row->date_entered, _MBL_DATE_ENTERED_FORMAT);
}
echo '</div>';
if (!empty($row->modified_by)) {
	echo '<div style="padding: 5px;">' . _MBL_MODIFIED_BY . ' ' . getUserNameByID($row->modified_by,1) . ' ('
	. getUserNameByID($row->modified_by,0) . ') ';
	if (!empty($row->date_modified)) {
		echo _MBL_ON . ' ' . JHTML::_('date', $row->date_modified, _MBL_DATE_MODIFIED_FORMAT);
	}
	echo '</div>';
}
?>
</div>
</th>
</tr>

<tr class="row<?php !empty($row0or1) ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><b><?php echo ucwords(_MBL_PUBLISHED); ?></b>:</td>
<td><?php echo JHTML::_('select.booleanlist',"published", "", ($row->published ? "1" : "0")); ?></td>
<td>&nbsp;</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_COMPLETED; ?>:</td>
<td><?php echo JHTML::_('select.booleanlist',"completed", "", ($row->completed ? "1" : "0")); ?></td>
<td>&nbsp;</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_APPROVED; ?>:</td>
<td>

<?php
// if already approved, preserve the id number of the user who approved it
$my = &JFactory::getUser();
$thearray = array( JHTML::_('select.option', '0', _MBL_NO), JHTML::_('select.option', ($row->approved ? $row->approved : $my->id), _MBL_YES));
echo JHTML::_('select.radiolist', $thearray, 'approved', null, 'value', 'text', $row->id ? $row->approved : $my->id); // new records aleady approved by default in the backend
if ($row->approved) {
	printf(_MBL_APPROVED_BY, getUserNameByID($row->approved, 1) . " [" . getUserNameByID($row->approved, 0) ."]");
}
?>

</td>
<td>&nbsp;</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_TITLE; ?>:</td>
<td colspan="2"><input size="60" name="title" value="<?php echo $row->title; ?>" /></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_AUTHOR_ALIAS ?>:</td>
<td colspan="2"><input size="60" name="author_alias" value="<?php echo $row->author_alias; ?>" /></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td width="5%">&nbsp;</td>
<td width="30%" align="right"><?php echo _MBL_CHANGE_CREATION_DATE . " " . _MBL_CREATION_DATE_FORMAT; ?></td>
<td width="25%" nowrap="nowrap">
<input class="text_area" type="text" name="date_entered" id="date_entered" size="25" maxlength="19" value="<?php echo $row->date_entered; ?>" />
<input type="reset" class="button" value="..." onclick="return showCalendar('date_entered', '%y-%m-%d');">
</td>
<td width="40%">&nbsp;</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_SESSION_NUMBER ?></td>
<td colspan="2"><?php echo "<div style=\"" . getHexStyleAttributeByPercentage($row->session, 10000000000) . "\">" . $row->session . "</div>"; ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_LOGGED_SCORESCRIPT_DATA . ' 1'; ?>:</td>
<td colspan="2"><textarea style="width: 95%;" cols="100" rows="10" name="scodata1"><?php echo convertToQuotLtGt($row->scodata1); ?></textarea></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_LOGGED_SCORESCRIPT_DATA . ' 2'; ?>:</td>
<td colspan="2"><textarea style="width: 95%;" cols="100" rows="10" name="scodata2"><?php echo convertToQuotLtGt($row->scodata2); ?></textarea></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_USE_ENTRY_WHEN_RANDOMIZING; ?>:</td>
<td><?php echo JHTML::_('select.booleanlist',"show_in_random", "", ($row->show_in_random ? "1" : "0")); ?> &nbsp; [<?php echo getCurrentOptionSetting($configrow->allow_randomizer, 0); ?>]</td>
<td>&nbsp;</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_STICKY; ?>:</td>
<td><?php echo JHTML::_('select.booleanlist',"sticky", "", ($row->sticky ? "1" : "0")); ?></td>
<td>&nbsp;</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_ORDERING; ?></td>
<td colspan="2"><input size="10" name="ordering" value="<?php echo $row->ordering; ?>" /></td>
</tr>

<?php
$noyesglobalarray = array(
	 JHTML::_('select.option',  '0', _MBL_NO ),
	 JHTML::_('select.option',  '1', _MBL_YES ),
	 JHTML::_('select.option',  '-1', _MBL_USE_GLOBAL )
 );
?>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_SHOW_CATEGORY_TITLE; ?></td>
<td><?php echo JHTML::_('select.radiolist', $noyesglobalarray, 'show_category_title', null, 'value', 'text', $row->show_category_title); ?> [<?php echo getCurrentOptionSetting($configrow->show_category_title, 1); ?>]</td>
<td>&nbsp;</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_SHOW_INDIVIDUAL_TITLE; ?></td>
<td><?php echo JHTML::_('select.radiolist',$noyesglobalarray, "show_individual_title", null, 'value', 'text', $row->show_individual_title); ?> [<?php echo getCurrentOptionSetting($configrow->show_individual_title, 1); ?>]</td>
<td>&nbsp;</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_SHOW_ENTERED_BY; ?></td>
<td><?php echo JHTML::_('select.radiolist',$noyesglobalarray, "show_entered_by", null, 'value', 'text', $row->show_entered_by); ?> [<?php echo getCurrentOptionSetting($configrow->show_entered_by, 1); ?>]</td>
<td>&nbsp;</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_SHOW_DATE_CREATED; ?></td>
<td><?php echo JHTML::_('select.radiolist',$noyesglobalarray, "show_date_created", null, 'value', 'text', $row->show_date_created); ?> [<?php echo getCurrentOptionSetting($configrow->show_date_created, 1); ?>]</td>
<td>&nbsp;</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_SHOW_MODIFIED_BY; ?></td>
<td><?php echo JHTML::_('select.radiolist',$noyesglobalarray, "show_modified_by", null, 'value', 'text', $row->show_modified_by); ?> [<?php echo getCurrentOptionSetting($configrow->show_modified_by, 1); ?>]</td>
<td>&nbsp;</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_SHOW_MODIFIED_DATE; ?></td>
<td><?php echo JHTML::_('select.radiolist',$noyesglobalarray, "show_modified_date", null, 'value', 'text', $row->show_modified_date); ?> [<?php echo getCurrentOptionSetting($configrow->show_modified_date, 1); ?>]</td>
<td>&nbsp;</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_SHOW_SELF_LINK; ?></td>
<td><?php echo JHTML::_('select.radiolist',$noyesglobalarray, "show_self_link", null, 'value', 'text', $row->show_self_link); ?> [<?php echo getCurrentOptionSetting($configrow->show_self_link, 1); ?>]</td>
<td>&nbsp;</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_SHOW_SELF_BUTTON; ?></td>
<td><?php echo JHTML::_('select.radiolist',$noyesglobalarray, "show_self_button", null, 'value', 'text', $row->show_self_button); ?> [<?php echo getCurrentOptionSetting($configrow->show_self_button, 1); ?>]</td>
<td>&nbsp;</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_SHOW_HOME_LINK; ?></td>
<td><?php echo JHTML::_('select.radiolist',$noyesglobalarray, "show_home_link", null, 'value', 'text', $row->show_home_link); ?> [<?php echo getCurrentOptionSetting($configrow->show_home_link, 1); ?>]</td>
<td>&nbsp;</td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td>&nbsp;</td>
<td align="right"><?php echo _MBL_ALWAYSSHOWBEFOREANDAFTER; ?></td>
<td><?php echo JHTML::_('select.radiolist',$noyesglobalarray, "alwaysshowbeforeandafter", null, 'value', 'text', $row->alwaysshowbeforeandafter); ?> [<?php echo getCurrentOptionSetting($configrow->alwaysshowbeforeandafter, 1); ?>]</td>
<td>&nbsp;</td>
</tr>

</table>

<hr />

<div align="left">

<?php
$lang_code = &JFactory::getLanguage();
$lang_code = $lang_code->_lang;

if (file_exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'language'.DS.$lang_code.'.com_madblanks.record.php' )) {
/**
 * Include the configured language file
 */
	include_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'language'.DS.$lang_code.'.com_madblanks.record.php';
} 
else {
/**
 * If no configured language, include the default English language file
 */
	include_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'language'.DS.'en-US.com_madblanks.record.php';
}
?>

</div>

<hr />

<table border="0" cellpadding="3" cellspacing="0" class="adminlist" style="min-width: 60%;">

<tr>
<th width="5"><?php echo _MBL_FIELD; ?> #</th>
<th><?php echo _MBL_FIELD_NAME; ?></th>
<th><?php echo _MBL_PART_OF_SPEECH; ?></th>
<th><?php echo _MBL_BEFORE_TEXT; ?></th>
<th><?php echo _MBL_FIELD_TEXT; ?></th>
<th><?php echo _MBL_AFTER_TEXT; ?></th>
</tr>

<?php
// for loop represents the number of fields in the database
global $mbFieldCount; // $mbFieldCount set at the top of this file
$therowclass = null;

for ($i=1; $i <= $mbFieldCount; $i++) {

	$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable

	$configarray = parseDataConfigString($configrow->{"data_".$theindex."_config"});

	if ($configrow->{"data_".$theindex."_use"}) {

		$editingafield = true;
		
		//$activefieldlist .= $activefieldlist ? ",'" . $theindex . "'" : "'" . $theindex . "'";

		$therowclass = $therowclass ? 0 : 1; // alternating row color each time we output a row

		$blankarray = array();
		//$beforestring = $configrow->{"data_".$theindex."_before"} ? replaceSpecialCharacters($configrow->{"data_".$theindex."_before"}, 0, null, 0, null, null, $blankarray) : "&nbsp;";
		//$afterstring = $configrow->{"data_".$theindex."_after"} ? replaceSpecialCharacters($configrow->{"data_".$theindex."_after"}, 0, null, 0, null, null, $blankarray) : "&nbsp;";
		$beforestring = $configrow->{"data_".$theindex."_before"} ? $configrow->{"data_".$theindex."_before"} : "&nbsp;";
		$afterstring = $configrow->{"data_".$theindex."_after"} ? $configrow->{"data_".$theindex."_after"} : "&nbsp;";
		?>

		<tr class="row<?php echo $therowclass ?>">
		<td><?php echo $i; ?></td>
		<td><?php echo $configrow->{"data_".$theindex."_name"} ? $configrow->{"data_".$theindex."_name"} : "Data # " . $i ?>: </td>
		<td><?php echo $configrow->{"data_".$theindex."_partofspeech"}; ?></td>
		<td align="right"><font color="#0000ff"><?php echo $beforestring ?></font></td>
		<td><?php

		//echo "<pre>"; print_r($configarray); echo "</pre>\n";
		
		
		global $mbAdminRecordEditRawOrForm;
		// 0 for raw editing mode
		if (empty($mbAdminRecordEditRawOrForm)) {
			// original field editing prior to 20100505
			if ($configarray['usetextarea'] == 1) {
				echo "<textarea cols=\"" . ($configarray['textareawidth'] ? $configarray['textareawidth'] : ($mbDefaultTextareaWidth ? $mbDefaultTextareaWidth : 45)) . "\" rows=\"" . ($configarray['textareaheight'] ? $configarray['textareaheight'] : ($mbDefaultTextareaHeight ? $mbDefaultTextareaHeight : 3)) . "\" name=\"data_" . $theindex . "\">" . $row->{"data_".$theindex} . "</textarea>\n";
			}
			else {
				echo "<input size=\"65\" name=\"data_" . $theindex . "\" value=\"" . convertToQuotLtGt($row->{"data_".$theindex}) . "\" />";
			}
		}
		// form control editing mode added 20100505
		else {
		
			$defaultvalue = $row->{"data_".$theindex};
			$inputboxsize = 65;

			if (!empty($configarray['usemultchoice'])) {

				echo makeQuizForm($configarray, str_replace("[:multisep:]", ";", $defaultvalue), ';', isset($configarray['horizorvert']) ? $configarray['horizorvert'] : '', '[:multisep:]', $configrow);

				// Because the radio button does not indicate its presence in $_REQUEST if left blank,
				//	we will store this list of fields that use multiple choice in a hidden form field
				//$multchoicefieldlist .= ($multchoicefieldlist ? "," . $theindex : $theindex);
				echo '<input type="hidden" name="data_' . $theindex . '_array" value="1" />' . "\n";

			}

			else {

				if ($defaultvalue == '' && $i != 0) {
					$defaultvalue = (isset($configarray['multdefault']) && $configarray['multdefault'] != '') ? $configarray['multdefault'] : '';
				}
				if ($defaultvalue != '') {
					$empty_array = array();
					$defaultvalue = str_replace('[:blank:]', '', replaceSpecialCharacters(convertMBEscapedToLiteral($defaultvalue), 0, null, 0, null, null, $empty_array));
				}

				if (isset($configarray['usetextarea']) && is_numeric($configarray['usetextarea']) && $configarray['usetextarea'] == 1) {
				
					//$css_textarea = strval($params->get('css_textarea', 'width: 95%;')); // 1.1.0rc3
					$textareacols = (isset($configarray['textareawidth']) && is_numeric($configarray['textareawidth']) && $configarray['textareawidth'] > 0) ? $configarray['textareawidth'] : 45;
					$textarearows = (isset($configarray['textareaheight']) && is_numeric($configarray['textareaheight']) && $configarray['textareawidth'] > 0) ? $configarray['textareaheight'] : 3;
					
					echo "<textarea class=\"inputbox mbltextarea\" style=\"" . /*$css_textarea .*/ "\" cols=\"" . $textareacols . "\" rows=\"" . $textarearows . "\" name=\"data_" . $theindex . "\">" . $defaultvalue . "</textarea>\n";
				}
				else {
					//$css_textinputfield = strval($params->get('css_textinputfield', 'width: 95%;')); // 1.1.0rc3
					echo "<input class=\"inputbox mbltextinputfield\" style=\"" . /*$css_textinputfield .*/ "\" size=\"" . $inputboxsize . "\" name=\"data_" . $theindex . "\" value=\"" . $defaultvalue . "\" />\n";  
				}	

			}
		}

		?></td>
		<td><font color="#0000ff"><?php echo $afterstring; ?></font></td>
		</tr>

	<?php
	} /* end if statement */

} /* end for loop */
$therowclass = $therowclass ? 0 : 1; // alternating row color based on the last value from the for loop

if (empty($editingafield)) {
	echo "<tr><td colspan=\"6\">" . _MBL_NO_ACTIVE_FIELDS . "</td></tr>\n";
}

?>

<tr><td colspan="6"><hr /></td></tr>

<tr class="row<?php echo $therowclass; ?>">
<td colspan="2"><?php echo _MBL_NOTES_NOT_VISIBLE_ON_WEBSITE; ?></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td align="center"><textarea cols="30" rows="10" name="notes"><?php echo $row->notes; ?></textarea></td>
<td align="center" valign="middle"><?php if (!$row->approved && $row->id) { ?><a class="toolbar" href="javascript:submitbutton('quickapproverecord')"><img src="<?php echo JUri::base(); ?>images/apply_f2.png"  alt="<?php echo _MBL_APPROVE; ?>" name="quickapproverecord" title="<?php echo _MBL_APPROVE; ?>" align="middle" border="0" /><br /><?php echo _MBL_QUICK_APPROVE; ?></a><?php } else echo "&nbsp;"; ?></td>
</tr>

</table>

<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
<input type="hidden" name="configid" value="<?php echo $row->configid; ?>" />
<input type="hidden" name="session" value="<?php echo $row->session; ?>" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="categorylimit" value="<?php echo $categorylimit; /* pass on filter data for list */ ?>" />
<input type="hidden" name="sortby" value="<?php echo $sortby; /* pass on filter data for list */ ?>" />
<input type="hidden" name="sortascordesc" value="<?php echo $sortascordesc; /* pass on filter data for list */ ?>" />
<input type="hidden" name="authorlimit" value="<?php echo $authorlimit; /* pass on filter data for list */ ?>" />
<input type="hidden" name="hidemainmenu" value="0" />

</form>

<?php
}

/**
 * Create a new Mad Blanks record (backend)
 *
 * @param string $option Joomla option string from URL
 * @param object $rows this data includes category data from the database: id numbers, names, and publish status
 * @param string $categorylimit passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $sortby passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $sortascordesc passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $authorlimit passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 */
function htmlNewMadBlanksRecord($option, &$rows, $categorylimit, $sortby, $sortascordesc, $authorlimit) {
	?>
	<form action="index2.php" method="post" name="adminForm">
	<div style="display: table; text-align: left;">
	<ul>
	<?php
	$didbreak = false; // put a break in between published and nonpublished entries

	if (!empty($rows)) {
		foreach ($rows as $row) {
			if ($row->published == 0 && !$didbreak) {
				echo "\n</ul>\n<ul>\n";
				$didbreak = true;
			}
			echo "<li><a href=\"" . JUri::base() . "index2.php?option=$option&task=editrecord&configid=$row->id&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit\">" . sprintf(_MBL_NEW_RECORD_LINK_TEXT, ($row->name ? _MBL_CATEGORY_NAME . " #" . $row->id . ": " . $row->name : _MBL_CATEGORY_NAME . " #" . $row->id)) . " (" . ucfirst(_MBL_CATEGORY_NAME) . " " . _MBL_IS . " " . ($row->published ? "<span style=\"color: green; font-weight: bold;\">" . _MBL_PUBLISHED : "<span style=\"color: red; font-weight: bold;\">" . _MBL_UNPUBLISHED) . "</span>)</a></li>\n";
		}
	}
	else {
		echo "<div class=\"message\">" . _MBL_NO_CATEGORIES_NEW_RECORD . "</div>\n";
	}

	?>
	</ul>
	</div>
	<input type="hidden" name="categorylimit" value="<?php echo $categorylimit; /* pass on filter data for list */ ?>" />
	<input type="hidden" name="sortby" value="<?php echo $sortby; /* pass on filter data for list */ ?>" />
	<input type="hidden" name="sortascordesc" value="<?php echo $sortascordesc; /* pass on filter data for list */ ?>" />
	<input type="hidden" name="authorlimit" value="<?php echo $authorlimit; /* pass on filter data for list */ ?>" />
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	</form>
	<?php
}

/**
 * Edit the component's configuration file, madblanksconfig.php (backend)
 *
 * The default configuration file is stored in this function htmlas a JavaScript string
 *
 * @param string $option Joomla option string from URL
 * @param string $conf_style the current configuration from the configuration file, minus the opening and closing php tags
 * @param integer $configpermission flag to indicate if the configuration file is writable on the server
 */
function htmlEditMadBlanksConfiguration($option, $conf_style, $configpermission) {

	setMadBlanksBackEndPageTitle(_MBL_BACKEND_CONFIGURATION);
	
	if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php')) {
		include JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php';
	}

	//$mosHTML = new mosHTML();

	$HTML_MadBlanks = new HTML_MadBlanks();
	$HTML_MadBlanks->htmlDefaultScreen($option, 1);

	?>
	<form action="index2.php" method="post" name="adminForm">
	<table class="adminheading">
	<tr>
	<th style="background-position: 0% 0%; vertical-align: top;">
	<div style="margin-top: 10px"><?php echo _MBL_EDIT_CONFIGURATION; ?></div>
	</th>
	</tr>
	</table>

	<p align="center"><?php echo _MBL_CONFIGURATION_FILE_NOTICE ?></p>

	<h3 align="center"><?php printf(_MBL_CONFIGURATION_WRITE_STATUS, ($configpermission ? "<b><font color=\"green\"> " . _MBL_WRITEABLE . "</font></b>" : "<b><font color=\"red\"> " . _MBL_UNWRITEABLE . "</font></b>")); ?></h3>

	<p align="center"><input class="inputbox" type="button" name="default_config" size="20" value="<?php echo _MBL_RESET_CONFIGURATION; ?>" onclick="if (confirm('<?php echo _MBL_RESET_CONFIRM; ?>')) { document.adminForm.resetdefault.value=1; submitbutton('saveconfiguration');} else return false;" /></p>

	<!-- p align="center"><?php /* printf(_MBL_CONFIGURATION_LANGUAGE_NOTICE, $GLOBALS['mosConfig_lang']) */ ?></p -->

	<table border="0" cellpadding="3" cellspacing="0" class="adminlist">

	<tr class="row<?php !empty($row0or1) ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<th><?php echo ucwords(_MBL_VARIABLE . " " . _MBL_NAME); ?></th>
	<th><?php echo ucwords(_MBL_VARIABLE . " " . _MBL_DESCRIPTION); ?></th>
	<th><?php echo ucwords(_MBL_VARIABLE . " " . _MBL_SETTING); ?></th>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbComponentTitle</td>
	<td><?php echo _MBL_MBCOMPONENTTITLE; ?></td>
	<td><input size="35" name="mbComponentTitle" value="<?php echo htmlspecialchars($mbComponentTitle); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbFieldCount</td>
	<td><?php

	// the following code allows us to show the actual database table names in place of #__madblanks_categories and #__madblanks_records
	$database = &JFactory::getDBO(); 
	$database->setQuery("#__madblanks_categories");
	$categories_db_table = str_replace(array("<pre>","</pre>"),"",$database->getQuery());
	$database->setQuery("#__madblanks_records");
	$records_db_table = str_replace(array("<pre>","</pre>"),"",$database->getQuery());
	$database->setQuery("#__madblanks_timeout");
	$timeout_db_table = str_replace(array("<pre>","</pre>"),"",$database->getQuery());

	echo str_replace(array("#__madblanks_categories", "#__madblanks_records"), array($categories_db_table, $records_db_table), _MBL_MBFIELDCOUNT);

	?></td>
	<td><input size="3" name="mbFieldCount" value="<?php echo htmlspecialchars($mbFieldCount); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbColor1</td>
	<td><?php echo _MBL_MBCOLOR1; ?></td>
	<td><input size="15" name="mbColor1" value="<?php echo htmlspecialchars($mbColor1); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbColor2</td>
	<td><?php echo _MBL_MBCOLOR2; ?></td>
	<td><input size="15" name="mbColor2" value="<?php echo htmlspecialchars($mbColor2); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbEnteredByLongFormat</td>
	<td><?php echo _MBL_MBENTEREDBYLONGFORMAT; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbEnteredByLongFormat", "", ($mbEnteredByLongFormat ? "1" : "0")); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbModifiedByLongFormat</td>
	<td><?php echo _MBL_MBMODIFIEDBYLONGFORMAT; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbModifiedByLongFormat", "", ($mbModifiedByLongFormat ? "1" : "0")); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbAllowBlankRandomFields</td>
	<td><?php echo _MBL_MBALLOWBLANKRANDOMFIELDS; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbAllowBlankRandomFields", "", ($mbAllowBlankRandomFields ? "1" : "0")); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultRecordsPerPage</td>
	<td><?php echo _MBL_MBDEFAULTRECORDSPERPAGE; ?></td>
	<td><input size="3" name="mbDefaultRecordsPerPage" value="<?php echo htmlspecialchars($mbDefaultRecordsPerPage); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDisplayResultNumbering</td>
	<td><?php echo _MBL_MBDISPLAYRESULTNUMBERING; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbDisplayResultNumbering", "", ($mbDisplayResultNumbering ? "1" : "0")); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbFrontendPageNavAlwaysOn</td>
	<td><?php echo _MBL_MBFRONTENDPAGENAVALWAYSON; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbFrontendPageNavAlwaysOn", "", ($mbFrontendPageNavAlwaysOn ? "1" : "0")); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbFeaturedRecords</td>
	<td><?php echo _MBL_MBFEATUREDRECORDS; ?></td>
	<td><input size="35" name="mbFeaturedRecords" value="<?php echo htmlspecialchars($mbFeaturedRecords); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbPreviewBeforeSave</td>
	<td><?php echo _MBL_MBPREVIEWBEFORESAVE; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbPreviewBeforeSave", "", ($mbPreviewBeforeSave ? "1" : "0")); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultNumColumns</td>
	<td><?php echo _MBL_MBDEFAULTNUMCOLUMNS; ?></td>
	<td><input size="3" name="mbDefaultNumColumns" value="<?php echo (isset($mbDefaultNumColumns) ? htmlspecialchars($mbDefaultNumColumns) : 1); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultTextareaWidth</td>
	<td><?php echo _MBL_MBDEFAULTTEXTAREAWIDTH; ?></td>
	<td><input size="3" name="mbDefaultTextareaWidth" value="<?php echo htmlspecialchars($mbDefaultTextareaWidth); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultTextareaHeight</td>
	<td><?php echo _MBL_MBDEFAULTTEXTAREAHEIGHT; ?></td>
	<td><input size="3" name="mbDefaultTextareaHeight" value="<?php echo htmlspecialchars($mbDefaultTextareaHeight); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbShowDisplayingWhatTitle</td>
	<td><?php echo _MBL_MBSHOWDISPLAYINGWHATTITLE; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbShowDisplayingWhatTitle", "", ($mbShowDisplayingWhatTitle ? "1" : "0")); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbShowHTMLTitleTagData</td>
	<td><?php echo _MBL_MBSHOWHTMLTITLETAGDATA; ?></td>
	<td><?php $thearray = array( JHTML::_('select.option', '0', '0'), JHTML::_('select.option', '1', '1'), JHTML::_('select.option', '2', '2')); echo JHTML::_('select.radiolist', $thearray, 'mbShowHTMLTitleTagData', null, 'value', 'text', $mbShowHTMLTitleTagData); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbCustomTitleText</td>
	<td><?php echo _MBL_MBCUSTOMTITLETEXT; ?></td>
	<td><textarea rows="12" cols="25" name="mbCustomTitleText"><?php echo htmlspecialchars($mbCustomTitleText); ?></textarea></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbFrontendInputFieldSize</td>
	<td><?php echo _MBL_MBFRONTENDINPUTFIELDSIZE; ?></td>
	<td><input size="3" name="mbFrontendInputFieldSize" value="<?php echo htmlspecialchars($mbFrontendInputFieldSize); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbShowFooterComponentHomeLink</td>
	<td><?php echo _MBL_MBSHOWFOOTERCOMPONENTHOMELINK; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbShowFooterComponentHomeLink", "", ($mbShowFooterComponentHomeLink ? "1" : "0")); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbApplyContentPlugins</td>
	<td><?php echo _MBL_MBAPPLYCONTENTPLUGINS; ?></td>
	<td><?php echo JHTML::_('select.radiolist',$thearray, "mbApplyContentPlugins", null, 'value', 'text', $mbApplyContentPlugins); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbHideCheckedOut</td>
	<td><?php echo _MBL_MBHIDECHECKEDOUT; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbHideCheckedOut", "", ($mbHideCheckedOut ? "1" : "0")); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbWordWrapWidth</td>
	<td><?php echo _MBL_MBWORDWRAPWIDTH; ?></td>
	<td><input size="3" name="mbWordWrapWidth" value="<?php echo htmlspecialchars($mbWordWrapWidth); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbEnableMainScreen</td>
	<td><?php echo _MBL_MBENABLEMAINSCREEN; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbEnableMainScreen", "", ($mbEnableMainScreen ? "1" : "0")); ?></td>
	</tr>
	
	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbEnableCreateSingleRecordLinks</td>
	<td><?php echo _MBL_MBENABLECREATESINGLERECORDLINKS; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbEnableCreateSingleRecordLinks", "", ($mbEnableCreateSingleRecordLinks ? "1" : "0")); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbCreateSingleRecordPosition</td>
	<td><?php echo _MBL_MBCREATESINGLERECORDPOSITION; ?></td>
	<td><input size="35" name="mbCreateSingleRecordPosition" value="<?php echo htmlspecialchars($mbCreateSingleRecordPosition); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbEnableShowAllLink</td>
	<td><?php echo _MBL_MBENABLESHOWALLLINK; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbEnableShowAllLink", "", ($mbEnableShowAllLink ? "1" : "0")); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbEnableCategoriesLinks</td>
	<td><?php echo _MBL_MBENABLECATEGORIESLINKS; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbEnableCategoriesLinks", "", ($mbEnableCategoriesLinks ? "1" : "0")); ?></td>
	</tr>
	
	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbEnableRandomizerLinks</td>
	<td><?php echo _MBL_MBENABLERANDOMIZERLINKS; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbEnableRandomizerLinks", "", ($mbEnableRandomizerLinks ? "1" : "0")); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbEnableSpecificRecordBox</td>
	<td><?php echo _MBL_MBENABLESPECIFICRECORDBOX; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbEnableSpecificRecordBox", "", ($mbEnableSpecificRecordBox ? "1" : "0")); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbEnableEditRecordsLink</td>
	<td><?php echo _MBL_MBENABLEEDITRECORDSLINK; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbEnableEditRecordsLink", "", ($mbEnableEditRecordsLink ? "1" : "0")); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbEditThreshold</td>
	<td><?php echo _MBL_MBEDITTHRESHOLD; ?></td>
	<td><?php $thearray = array( JHTML::_('select.option', '0', 'registered'), JHTML::_('select.option', '1', 'special')); echo JHTML::_('select.radiolist',$thearray, "mbEditThreshold", null, 'value', 'text', $mbEditThreshold); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbEnableRecordListShowAll</td>
	<td><?php echo _MBL_MBENABLERECORDLISTSHOWALL; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbEnableRecordListShowAll", "", ($mbEnableRecordListShowAll ? "1" : "0")); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbStartPage</td>
	<td><?php echo _MBL_MBSTARTPAGE; ?></td>
	<td><input size="35" name="mbStartPage" value="<?php echo htmlspecialchars($mbStartPage); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbModuleWithinComponentStyle</td>
	<td><?php echo _MBL_MBMODULEWITHINCOMPONENTSTYLE; ?></td>
	<td><input size="35" name="mbModuleWithinComponentStyle" value="<?php echo htmlspecialchars($mbModuleWithinComponentStyle); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbModuleWithinComponentChrome</td>
	<td><?php echo _MBL_MBMODULEWITHINCOMPONENTCHROME; ?></td>
	<td><input size="35" name="mbModuleWithinComponentChrome" value="<?php echo htmlspecialchars($mbModuleWithinComponentChrome); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbModuleWithinComponentTypes</td>
	<td><?php echo _MBL_MBMODULEWITHINCOMPONENTTYPES; ?></td>
	<td><input size="35" name="mbModuleWithinComponentTypes" value="<?php echo htmlspecialchars($mbModuleWithinComponentTypes); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultSeparator1</td>
	<td><?php echo _MBL_MBDEFAULTSEPARATOR1; ?></td>
	<td><input size="35" name="mbDefaultSeparator1" value="<?php echo htmlspecialchars($mbDefaultSeparator1); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultSeparator2</td>
	<td><?php echo _MBL_MBDEFAULTSEPARATOR2; ?></td>
	<td><input size="35" name="mbDefaultSeparator2" value="<?php echo htmlspecialchars($mbDefaultSeparator2); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultSSEmailFrom</td>
	<td><?php echo _MBL_MBDEFAULTSSEMAILFROM; ?></td>
	<td><input size="35" name="mbDefaultSSEmailFrom" value="<?php echo htmlspecialchars($mbDefaultSSEmailFrom); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultSSEmailTo</td>
	<td><?php echo _MBL_MBDEFAULTSSEMAILTO; ?></td>
	<td><input size="35" name="mbDefaultSSEmailTo" value="<?php echo htmlspecialchars($mbDefaultSSEmailTo); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultSSEmailSubject</td>
	<td><?php echo _MBL_MBDEFAULTSSEMAILSUBJECT; ?></td>
	<td><input size="35" name="mbDefaultSSEmailSubject" value="<?php echo htmlspecialchars($mbDefaultSSEmailSubject); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultSSEmailBody</td>
	<td><?php echo _MBL_MBDEFAULTSSEMAILBODY; ?></td>
	<td><textarea rows="12" cols="25" name="mbDefaultSSEmailBody"><?php echo htmlspecialchars($mbDefaultSSEmailBody); ?></textarea></td>
	</tr>

	<?php /* $mbDefaultSSEmailMode is a quoted string and not an int because field can contain special tags that would be found in a Score Script and resolve to the desired content */ ?>
	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultSSEmailMode</td>
	<td><?php echo _MBL_MBDEFAULTSSEMAILMODE; ?></td>
	<td><input size="35" name="mbDefaultSSEmailMode" value="<?php echo htmlspecialchars($mbDefaultSSEmailMode); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultSSEmailCC</td>
	<td><?php echo _MBL_MBDEFAULTSSEMAILCC; ?></td>
	<td><input size="35" name="mbDefaultSSEmailCC" value="<?php echo htmlspecialchars($mbDefaultSSEmailCC); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultSSEmailBCC</td>
	<td><?php echo _MBL_MBDEFAULTSSEMAILBCC; ?></td>
	<td><input size="35" name="mbDefaultSSEmailBCC" value="<?php echo htmlspecialchars($mbDefaultSSEmailBCC); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultSSEmailAttachment</td>
	<td><?php echo _MBL_MBDEFAULTSSEMAILATTACHMENT; ?></td>
	<td><input size="35" name="mbDefaultSSEmailAttachment" value="<?php echo htmlspecialchars($mbDefaultSSEmailAttachment); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultSSEmailReplyTo</td>
	<td><?php echo _MBL_MBDEFAULTSSEMAILREPLYTO; ?></td>
	<td><input size="35" name="mbDefaultSSEmailReplyTo" value="<?php echo htmlspecialchars($mbDefaultSSEmailReplyTo); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultSSEmailSuccess</td>
	<td><?php echo _MBL_MBDEFAULTSSEMAILSUCCESS; ?></td>
	<td><input size="35" name="mbDefaultSSEmailSuccess" value="<?php echo htmlspecialchars($mbDefaultSSEmailSuccess); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultSSEmailFailure</td>
	<td><?php echo _MBL_MBDEFAULTSSEMAILFAILURE; ?></td>
	<td><input size="35" name="mbDefaultSSEmailFailure" value="<?php echo htmlspecialchars($mbDefaultSSEmailFailure); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultSSDateFormat</td>
	<td><?php echo _MBL_MBDEFAULTSSDATEFORMAT; ?></td>
	<td><input size="35" name="mbDefaultSSDateFormat" value="<?php echo htmlspecialchars($mbDefaultSSDateFormat); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbDefaultSSDateAdjustment</td>
	<td><?php echo _MBL_MBDEFAULTSSDATEADJUSTMENT; ?></td>
	<td><input size="35" name="mbDefaultSSDateAdjustment" value="<?php echo htmlspecialchars($mbDefaultSSDateAdjustment); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbAcceptGoogleChartTOS</td>
	<td><?php echo _MBL_MBACCEPTGOOGLECHARTTOS; ?></td>
	<td><input size="5" name="mbAcceptGoogleChartTOS" value="<?php echo htmlspecialchars($mbAcceptGoogleChartTOS); ?>" class="inputbox" /></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbTimeoutDataTimeToLive</td>
	<td><?php echo str_replace('#__madblanks_timeout', $timeout_db_table, _MBL_MBTIMEOUTDATATIMETOLIVE); ?></td>
	<td><input size="10" name="mbTimeoutDataTimeToLive" value="<?php echo htmlspecialchars($mbTimeoutDataTimeToLive); ?>" class="inputbox" /></td>
	</tr>
	
	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbAdminRecordEditRawOrForm</td>
	<td><?php echo _MBL_MBADMINRECORDEDITRAWORFORM; ?></td>
	<td><?php echo JHTML::_('select.booleanlist',"mbAdminRecordEditRawOrForm", "", (!isset($mbAdminRecordEditRawOrForm) || $mbAdminRecordEditRawOrForm > 0) ? "1" : "0"); ?></td>
	</tr>

	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbEnableMaxPostOrRequestVarsWarning</td>
	<td><?php echo _MBL_MBENABLEMAXPOSTORREQUESTVARSWARNING; ?></td>
	<td><?php echo JHTML::_('select.booleanlist','mbEnableMaxPostOrRequestVarsWarning', '', (!isset($mbEnableMaxPostOrRequestVarsWarning) || $mbEnableMaxPostOrRequestVarsWarning > 0) ? '1' : '0'); ?></td>
	</tr>
	
	<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
	<td>mbIncludeCustomizationFile</td>
	<td><?php echo _MBL_MBINCLUDECUSTOMIZATIONFILE; ?></td>
	<td><?php echo JHTML::_('select.booleanlist','mbIncludeCustomizationFile', '', empty($mbIncludeCustomizationFile) ? '0' : '1'); ?></td>
	</tr>
	
	

	</table>

	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="resetdefault" value="0" />
	</form>
<?php
}

/**
 * Preview a record before saving it (backend)
 *
 * @param string $option Joomla option string from the URL
 * @param object &$row the row from the database for the record
 * @param string $content_string the converted for display content of the Mad Blanks record
 * @param string $categorylimit filter data to limit category displayed
 * @param string $sortby which data the list is sorted by
 * @param string $sortascordesc whether the list is sorted ascending or descending
 * @param string $authorlimit filter data to limit author displayed
 */
function htmlSaveMadBlanksRecordPreview($option, &$row, $content_string, $categorylimit, $sortby, $sortascordesc, $authorlimit) {
		?>
		<form action="index2.php" method="post" name="adminForm">
<?php
		foreach($row as $key=>$value) {
			// check that key doesn't start with underscore and leave out checked_out and checked_out_time
			if (!(strpos($key, "_") === 0) && $key != 'checked_out' && $key != 'checked_out_time') {
?>
		<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
<?php
			}
		}

		?>
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="configid" value="<?php echo $row->configid; ?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="categorylimit" value="<?php echo $categorylimit; ?>" />
		<input type="hidden" name="sortby" value="<?php echo $sortby; ?>" />
		<input type="hidden" name="sortascordesc" value="<?php echo $sortascordesc; ?>" />
		<input type="hidden" name="authorlimit" value="<?php echo $authorlimit; ?>" />
		<input type="hidden" name="reeditpreview" value="1" />
		<input type="hidden" name="hidemainmenu" value="0" />

		</form>

		<table border="0" cellpadding="3" cellspacing="0" class="adminheading">
		<tr><th><?php echo _MBL_PREVIEW_SCREEN ?></th></tr>
		</table>

		<p align="center"><?php echo _MBL_PREVIEW_NOTICE; ?></p>

		<table border="0" cellpadding="3" cellspacing="0" class="adminlist">
		<tr class="row1"><td>
		<div style="margin: auto; max-width: 40%; min-height: 1in; padding: 2em;"><?php echo $content_string; ?></div>
		</td></tr>
		</table>

		<?php
}

/**
 * Displays configuration data for currently published categories
 * Use index2.php in the frontend to display alone (i.e. without modules)
 *
 * @param &$rows rows from the categories table in the database
 */
function htmlShowReferenceWindow(&$rows, $message='') {
	
	setMadBlanksBackEndPageTitle(_MBL_CATEGORIES_REFERENCE);
	
	?>
	<h1 align="center"><?php echo _MBL_CATEGORIES_REFERENCE; ?></h1>
	<form name="adminForm" id="adminForm">
	<?php
	echo "<div align=\"center\"><a href=\"" . JUri::base() . "index3.php?option=com_madblanks&task=showreferencewindow&published=1\">" . ucwords(_MBL_PUBLISHED) . " " . _MBL_CATEGORY_NAME_PLURAL . "</a> &nbsp; &nbsp; &nbsp; &nbsp; <a href=\"" . JUri::base() . "index3.php?option=com_madblanks&task=showreferencewindow&published=0\">" . ucwords(_MBL_UNPUBLISHED) . " " . _MBL_CATEGORY_NAME_PLURAL . "</a></div>";

	if ($message) {
		echo "<hr /><div style=\"text-align: center; font-style: italic;\">" . $message . "</div>\n";
	}	

	foreach ($rows as $row) {
		echo "<hr width=\"100%\" />\n";
		echo "<h2>" . _MBL_CATEGORY_NAME . " #" . $row->id . ": " . (trim($row->name) ? $row->name : "<em>&lt;no name&gt;</em>") . "</h2>\n";
		echo "<table border=\"1\" width=\"100%\">

		<tr><td width=\"100%\" colspan=\"5\">\n";

		// permissions table

		echo "<table border=\"1\" width=\"100%\">\n";
		echo "<tr><td>" . ucwords(_MBL_CATEGORY_NAME) . " " . _MBL_IS . " " . _MBL_PUBLISHED . "</td><td style=\"color: white\" bgcolor=\"" . ($row->published ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_FRONTEND_VIEWING . "</td><td style=\"color: white\" bgcolor=\"" . ($row->allow_frontend_viewing ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_FRONTEND_EDITING . "</td><td style=\"color: white\" bgcolor=\"" . ($row->allow_frontend_editing ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_FRONTEND_MODULE_VIEWING . "</td><td style=\"color: white\" bgcolor=\"" . ($row->allow_frontend_module_viewing ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_FRONTEND_MODULE_EDITING . "</td><td style=\"color: white\" bgcolor=\"" . ($row->allow_frontend_module_editing ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_RANDOMIZER . "</td><td style=\"color: white\" bgcolor=\"" . ($row->allow_randomizer ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FRONTEND_SHOW_IN_LIST . "</td><td style=\"color: white\" bgcolor=\"" . ($row->frontend_show_in_list ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FRONTEND_SHOW_IN_CSR_LIST . "</td><td style=\"color: white\" bgcolor=\"" . ($row->frontend_show_in_csr_list ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_HTML_INPUT . "</td><td style=\"color: white\" bgcolor=\"" . ($row->allow_html_input ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_RANDOM_TAG . "</td><td style=\"color: white\" bgcolor=\"" . ($row->allow_random_tag ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_LOOKUP_TAG . "</td><td style=\"color: white\" bgcolor=\"" . ($row->allow_lookup_tag ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FOR_THIS_CATEGORY . _MBL_FRONTEND_AUTO_APPROVE . "</td><td style=\"color: white\" bgcolor=\"" . ($row->frontend_auto_approve ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_MODULE_APPROVE . "</td><td style=\"color: white\" bgcolor=\"" . ($row->allow_module_approve ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_MODULE_PUBLISH . "</td><td style=\"color: white\" bgcolor=\"" . ($row->allow_module_publish ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FOR_THIS_CATEGORY . _MBL_RESTRICT_VIEWING_TO_CREATOR . "</td><td style=\"color: white\" bgcolor=\"" . ($row->restrict_viewing_to_creator ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FOR_THIS_CATEGORY . _MBL_ALLOW_VIEWING_CREATORLESS_RECORDS . "</td><td style=\"color: white\" bgcolor=\"" . ($row->allow_viewing_creatorless_records ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "<tr><td>" . _MBL_FOR_THIS_CATEGORY . _MBL_ADMINS_SEE_ALL_CREATORS . "</td><td style=\"color: white\" bgcolor=\"" . ($row->admins_see_all_creators ? "green\">" . _MBL_YES : "red\">" . _MBL_NO) . "</td></tr>\n";
		echo "</table>\n";

		$displaying_something = 0;
		?>
		</td></tr>
		<tr>
		<th width="8%"><?php echo _MBL_FIELD; ?> #</th>
		<th width="22%"><?php echo _MBL_FIELD_NAME; ?></th>
		<th width="30%"><?php echo _MBL_BEFORE_TEXT; ?></th>
		<th width="10%"><?php echo _MBL_FIELD_TEXT; ?></th>
		<th width="30%"><?php echo _MBL_AFTER_TEXT; ?></th>
		</tr>
		<?php
		// retrieve $mbFieldCount from top of file and colors from config file
		global $mbFieldCount, $mbColor1, $mbColor2;
		$rowcolor = ''; // initialize
		$mbColor1 = !empty($mbColor1) ? $mbColor1 : '#d3d3d3'; // default color if not found in config file
		$mbColor2 = !empty($mbColor2) ? $mbColor2 : '#add8e6'; // default color if not found in config file
		// for loop represents the number of fields in the database
		for ($i=1; $i <= $mbFieldCount; $i++) {
			// sprintf (as opposed to printf) is used to put the value into a variable
			$theindex = sprintf('%02d', $i);

			if ($row->{"data_".$theindex."_use"}) {
				$displaying_something = 1;
				$rowcolor = $rowcolor == $mbColor1 ? $mbColor2 : $mbColor1;
				$blankarray = array();
				?>

				<tr>
				<td bgcolor="<?php echo $rowcolor; ?>">Field&nbsp;<?php echo $theindex; ?>:</td>
				<td bgcolor="<?php echo $rowcolor; ?>"><?php echo $row->{"data_".$theindex."_name"} ? $row->{"data_".$theindex."_name"} : "<em>&lt;#" . $i . "&gt;</em>"; echo $row->{"data_".$theindex."_partofspeech"} ? " (" . $row->{"data_".$theindex."_partofspeech"} . ")" : ""; ?>: </td>
				<td align="right" bgcolor="<?php echo $rowcolor; ?>"><font color="#0000ff"><?php echo $row->{"data_".$theindex."_before"} ? $row->{"data_".$theindex."_before"} : "&nbsp;" ?></font></td>
				<td bgcolor="<?php echo $rowcolor; ?>" nowrap="nowrap">&nbsp;<?php echo "<input size=\"10\" name=\"data_" . $theindex . "\" value=\"" . $row->id . "," . $i . "\" style=\"border: 1px solid gray; color: gray;\" readonly=\"readonly\" nowrap=\"nowrap\" onclick=\"this.select();\" />";  ?>&nbsp;</td>
				<td bgcolor="<?php echo $rowcolor; ?>"><font color="#0000ff"><?php echo $row->{"data_".$theindex."_after"} ? $row->{"data_".$theindex."_after"} : "&nbsp;" ?></font></td>
				</tr>

				<?php
			} /* end if statement */
		} /* end for loop */
		if (!($displaying_something)) {
			echo "<tr><td colspan=\"5\" align=\"center\"><span class=\"madblanksusermessage\">" . _MBL_NO_ACTIVE_FIELDS . "</span></td></tr>";

		}
		echo "</table>\n";
	}
	echo "<hr width=\"100%\" />\n";
	?>
	</form>
	<div align="center"><form method="post"><input type="button" value="<?php echo _MBL_CLOSE_WINDOW; ?>" onclick="window.close()"></form></div>
	<?php
	return;
}

/**
 * Backend edit screen for a Mad Blanks ScoreScript
 *
 * @param string $option Joomla option string from URL
 * @param object &$row the row from the database for this scorescript
 * @param object &$lists pulldown menu data
 * @param integer $numbercompleted number of records with completed flag on in this scorescript
 * @param integer $numberapproved number of records with approved flag on in this scorescript
 * @param integer $numberpublished number of records with published flag on in this scorescript
 * @param integer $numbertotal total number of records in this scorescript
 * @param integer $numberdisplayed number of records meeting all three criteria to be displayed (completed, approved, published)
 * @param string $validate_message message to display at top of screen warning that a field did not validate
 * @param array $validate_error_field_list array whose keys contain values with invalid field numbers if applicable
 */
function htmlEditMadBlanksScoreScript($option, &$row, &$lists, $numbercompleted=0, $numberapproved=0, $numberpublished=0, $numbertotal=0, $numberdisplayed=0, $validate_message=null, $validate_error_field_list=null) {

	setMadBlanksBackEndPageTitle((!empty($row->id) ? _MBL_EDIT : _MBL_NEW) . ' ' . JString::ucfirst(_MBL_SCORESCRIPT_NAME) . (!empty($row->id) ? ' #' . $row->id : '') . (!empty($row->name) ? ': ' . (function_exists('htmlspecialchars_decode') ? htmlspecialchars_decode($row->name) : $row->name) : ''));
	
	global $mbFieldCount;
	if ($validate_message) {
		echo "<div class=\"message\">" . $validate_message . "</div>\n";
	}
	
	//$mosHTML = new mosHTML();

?>

<script type="text/javascript" language="javascript">
<!--

function toggleVisibility( whichLayer )
{
  var elem, vis;
  if( document.getElementById ) // this is the way the standards work
    elem = document.getElementById( whichLayer );
  else if( document.all ) // this is the way old msie versions work
      elem = document.all[whichLayer];
  else if( document.layers ) // this is the way nn4 works
    elem = document.layers[whichLayer];
  vis = elem.style;
   //alert(whichLayer + ' starting visibility is set to ' + vis.visibility); 
   //alert(whichLayer + ' starting display is set to ' + vis.display); 

  if (navigator.userAgent.indexOf('MSIE') !=-1) {
    using_ie = true; // Using IE (does not support visibility: collapse;)
  }
  else {
    using_ie = false;
  }

  // if the style.display value is blank we try to figure it out here
  if (using_ie) {
	  if(vis.display==''&&elem.offsetWidth!=undefined&&elem.offsetHeight!=undefined) {
	    vis.display = (elem.offsetWidth!=0&&elem.offsetHeight!=0)?'block':'none';
	  }  
	  vis.display = (vis.display==''||vis.display=='block')?'none':'block';
  
  }
  else {
	  if(vis.visibility==''&&elem.offsetWidth!=undefined&&elem.offsetHeight!=undefined) {
	    vis.visibility = (elem.offsetWidth!=0&&elem.offsetHeight!=0)?'visible':'collapse';
	  }
  
	  if (vis.visibility==''||vis.visibility=='visible') {
	  	vis.visibility = 'collapse';
      		vis.display = 'none';
	  }
	  else {
      		vis.display = 'table-row';
	  	vis.visibility = 'visible';
	  }
	  
  }
  
  //alert(whichLayer + ' ending visibility is set to ' + vis.visibility); 
  //alert(whichLayer + ' ending display is set to ' + vis.display); 
  
}

function addLoadEvent(func) {
	var oldonload = window.onload;
	if (typeof window.onload != 'function') {
        	window.onload = func;
	} 
	else {
              window.onload = function() {
                    if (oldonload) {
                            oldonload();
                    }
                    func();
              }
         }
}

addLoadEvent(function(){
	// when first loading the page for IE only (IE does not support visibility: collapse;)
	// visibility: collapse for 'tr' elements should become 'display:none;' and 'visibility: visible;'
	if (navigator.userAgent.indexOf('MSIE') !=-1) { // using IE
		d = document.getElementsByTagName('tr');
		for(i=0;i<d.length;i++){
			if (d[i].style.visibility=='collapse') {
				d[i].style.display = 'none';
				d[i].style.visibility = 'visible';
      			}
		}  
	}
});


// -->
</script>

<form action="index2.php" method="post" name="adminForm" id="adminForm" class="adminForm">

<table class="adminheading">
<tr>
<th><?php echo $row->id ? _MBL_EDIT : _MBL_NEW; echo " Mad Blanks " . ucwords(_MBL_SCORESCRIPT_NAME) . ($row->id ? " <span style=\"margin-left: 1em; font-style: italic;\">#" . $row->id . ($row->name ? ": " . $row->name . "</span>" : "</span>") : ""); ?></th>
</tr>
</table>

		<?php JHTML::_('behavior.calendar'); ?>

<table border="0" cellpadding="3" cellspacing="0" class="adminlist">

<tr>
<th colspan="2">&nbsp;</th>
</tr>

<tr class="row<?php !empty($row0or1) ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td align="right"><b><?php echo ucwords(_MBL_PUBLISHED); ?></b>:</td>
<td><?php echo JHTML::_('select.booleanlist',"published", "", ($row->published ? "1" : "0")); ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td width="50%" align="right"><?php echo _MBL_NAME_FOR_THIS_SCORESCRIPT ?></td>
<td width="50%"><input size="55" name="name" value="<?php echo $row->name; ?>" /></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td align="right"><?php echo ucfirst(_MBL_SCORESCRIPT_NAME . " " . _MBL_ORDERING_1); ?>:</td>
<td><?php echo $lists['ordering']; ?></td>
</tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>">
<td align="right"><?php echo _MBL_CHANGE_CREATION_DATE . " " . _MBL_CREATION_DATE_FORMAT; ?></td>
<td>
<input class="text_area" type="text" name="date_created" id="date_created" size="25" maxlength="19" value="<?php echo $row->date_created ? $row->date_created : date("Y-m-d\ H:i:s"); ?>" />
<input name="reset" type="reset" class="button" value="..." onclick="return showCalendar('date_created', '%Y-%m-%d');">
</td>
</tr>

<?php /* <tr><th colspan="2">&nbsp;</th></tr> */ ?>
<tr><th colspan="2"><div style="position: relative; text-align: center;"><div style="margin-right: 9em;"><?php echo _MBL_NOTES_SETTINGS; ?></div><div style="position: absolute; top: 0; right: 0; float: right; margin: 0 2px 0 auto;"><a href="javascript:toggleVisibility('mblscoscrnotes');"><?php echo _MBL_SHOW_HIDE; ?></a></div></div></th></tr>

<tr id="mblscoscrnotes" class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>" style="visibility: visible;">
<td align="right"><?php echo _MBL_NOTES_NOT_VISIBLE_ON_WEBSITE; ?></td>
<td><textarea cols="40" rows="5" name="notes"><?php echo $row->notes; ?></textarea></td>
</tr>

<?php /* <tr><th colspan="2">&nbsp;</th></tr> */ ?>
<tr><th colspan="2"><div style="position: relative; text-align: center;"><div style="margin-right: 9em;"><?php echo _MBL_SPECIAL_TAG_DESCRIPTIONS_SCO; ?></div><div style="position: absolute; top: 0; right: 0; float: right; margin: 0 2px 0 auto;"><a href="javascript:toggleVisibility('mblscoscrspectags');"><?php echo _MBL_SHOW_HIDE; ?></a></div></div></th></tr>

<tr id="mblscoscrspectags" style="visibility: collapse; display: none;"><td colspan="2">
<div style="height: 290px; overflow: scroll;">

<?php
$lang_code = &JFactory::getLanguage();
$lang_code = $lang_code->_lang;

if (file_exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'language'.DS.$lang_code.'.com_madblanks.scorescript.php' )) {
/**
 * Include the configured language file
 */
	include_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'language'.DS.$lang_code.'.com_madblanks.scorescript.php';
} 
else {
/**
 * If no configured language, include the default English language file
 */
	include_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'language'.DS.'en-US.com_madblanks.scorescript.php';
}
?>

</div>
</td></tr>

<!-- tr><td colspan="2"><hr /></td></tr>
</table>

<table border="0" cellpadding="3" cellspacing="0" class="adminlist" -->

<tr><th colspan="2"><?php echo _MBL_SCORESCRIPT_EDIT_TITLE . "\n"; ?></th></tr>

<tr class="row<?php $row0or1 ? $row0or1 = 0 : $row0or1 = 1; echo $row0or1; ?>"><td colspan="2">

<div align="center" style="width: 75%; margin: auto;">
<textarea style="width: 100%;" cols="50" rows="20" name="scorescript"><?php echo $row->scorescript ?></textarea>
</div>

</td></tr>

</table>

<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="" />

</form>

<?php } // end editMadBlanksScoreScript

/**
 * List all scorescripts (backend)
 *
 * @param string $option Joomla option string from URL
 * @param object &$rows the rows from the database for the scorescripts
 * @param string $task component task string from URL
 * @param object $pageNav Joomla page navigation data (which page number of how many pages, number of records displayed per page)
 */
function htmlListMadBlanksScoreScripts($option, &$rows, $task, &$pageNav) {

setMadBlanksBackEndPageTitle(_MBL_LIST_SCORESCRIPTS_TITLE);

$HTML_MadBlanks = new HTML_MadBlanks();
$HTML_MadBlanks->htmlDefaultScreen($option, 1);

JHTML::_('behavior.tooltip');
$my = &JFactory::getUser();
?>
<form action="index2.php" method="post" name="adminForm">
<table class="adminheading">
<tr>
<th style="background-position: 0% 0%; vertical-align: top;"><div style="margin-top: 10px"><? echo _MBL_LIST_SCORESCRIPTS_TITLE; ?></div></th>
</tr>
</table>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
<tr><th colspan="13" align="center" style="background: url(); border-style: hidden;"><?php echo $pageNav->getPagesCounter() . " &nbsp; &nbsp; &nbsp; " . $pageNav->getPagesLinks(); ?></th></tr>
<tr>
<th width="5">#</th><th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
<th><?php echo _MBL_ID; ?></th>
<th class="title"><?php echo _MBL_NAME; ?></th>
<th><?php echo _MBL_CREATED_DATE; ?></th>
<th colspan="2"><?php echo _MBL_ORDERING_1; ?></th>
<th><?php echo ucwords(_MBL_PUBLISHED); ?></th></tr>

<?php
	if (count($rows) == 0) {
		echo '<tr><td colspan="8" align="center">' . _MBL_EMPTY_SET_SCO . "</td></tr>\n";
	}

	$k = 0;
	for($i=0; $i < count( $rows ); $i++) {
	$row = $rows[$i];
	jimport('joomla.html.html.grid');
	$checked = JHTML::_('grid.checkedout', $row, $i);

   ?>
	<tr class="<?php echo "row$k"; ?>">
	<td><?php /* echo $pageNav->rowNumber( $i ); */ echo $pageNav->getRowOffset($i); ?></td>
	<td><?php echo $checked; ?></td>
	<td><?php echo (isset($row->id) ? $row->id : "&lt;" . _MBL_NO_ID . "&gt;"); ?></td>
	<td>
	<?php

	if ( $row->checked_out && ( $row->checked_out != $my->id )) {
		echo ($row->name ? $row->name : "<em>&lt;" . _MBL_NO_NAME . "&gt;</em>");
	}
	else {
		$link =  'index2.php?option=com_madblanks&task=editscorescript&hidemainmenu=1&id='. $row->id;
		?>
		<a href="<?php echo $link ?>"><?php echo ($row->name ? $row->name : "<em>&lt;" . _MBL_NO_NAME . "&gt;</em>"); ?></a>
		<?php
	}
	?>
	</td>
	<td align="center"><?php echo (intval($row->date_created) ? JHTML::_('date', $row->date_created, JText::_('DATE_FORMAT_LC2')) : "<em>&lt;" . _MBL_NO_DATE . "&gt;</em>"); ?></td>
	<td><?php echo $pageNav->orderUpIcon($i, true, 'orderupscorescript'); ?></td>
	<td><?php echo $pageNav->orderDownIcon($i, count($rows), true, 'orderdownscorescript'); ?></td>
	<td align="center">
   <?php
	if ($row->published == "1") {
	echo "<a href=\"javascript: void(0);\" onclick=\"return listItemTask('cb$i','unpublishscorescripts')\"><img src=\"images/publish_g.png\" border=\"0\" /></a>";
	} else {
	echo "<a href=\"javascript: void(0);\" onclick=\"return listItemTask('cb$i','publishscorescripts')\"><img src=\"images/publish_x.png\" border=\"0\" /></a>";
	}
   ?>
	</td>
	<?php $k = 1 - $k; ?>
	</tr>
<?php }

?>
</table>
<?php echo $pageNav->getListFooter(); ?>

<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="<?php echo $task; ?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="hidemainmenu" value="0" />
</form>

<?php
}

} // end class HTML_MadBlanks
?>