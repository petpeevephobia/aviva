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
 * This file contains administration functions to perform editing
 * and data saving/deleting for the component in the backend.
 *
 * file version 1.18.0 20110301
 *
 * @package Mad_Blanks_Component
 * @author Chris Hallett <chris@madblanks.org>
 * @copyright Chris Hallett March 1, 2011
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @version 1.4.2
 */

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

// enumerate global variables for Joomla! 1.5
global $apply_editoverride, $mbFieldCount, $mbPreviewBeforeSave, $mbEnteredByLongFormat,
$mbDefaultSeparator1, $mbDefaultSeparator2;

/**
 * Require the administrator html file
 */
require_once($mainframe->getPath('admin_html'));

/**
 * Require the component class and support function file
 */
require_once($mainframe->getPath('class'));

if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php')) {
/**
 * Include the component configuration file
 */
	include JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php';
}

// ensure user has access to this function
if (!madblanks_user_is_administrator()) {
	$app = &JFactory::getApplication();$app->redirect('index2.php', JText::_('ALERTNOTAUTH'));
}

/**
 * set number of data fields present in the database, preferably from the config file
 * @global integer $mbFieldCount
 */
if (!isset($mbFieldCount)) {
	$mbFieldCount = 25;
}

$lang_code = &JFactory::getLanguage();
$lang_code = $lang_code->_lang;

if (file_exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'language'.DS.$lang_code.'.com_madblanks.core.php' )) {
/**
 * Include the configured language file
 */
	include_once JPATH_ADMINISTRATOR.''.DS.'components'.DS.'com_madblanks'.DS.'language'.DS.$lang_code.'.com_madblanks.core.php';
} 
else {
/**
 * If no configured language, include the default English language file
 */
	include_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'language'.DS.'en-US.com_madblanks.core.php';
}

$ido = JRequest::getVar('cid', array(0));
$id = JRequest::getVar('id', '');
if (!is_array($ido)) {
	$ido = array(0);
}
else if ($id) {
	$ido = array($id);
}

$task = JRequest::getVar('task');
$option = JRequest::getVar('option');

/**
 * This is a global variable for the function 'applyMadBlanksCategory'
 * @global integer $apply_editoverride
 */
$apply_editoverride = 0;

switch ($task) {

// Category section

	case "listcategories" :
		listMadBlanksCategories($option, $task);
		break;

	case "newcategory" :
		$ido = '';
		editMadBlanksCategory($option, $ido);
		break;

	case "applycategory" :
		applyMadBlanksCategory($option);
		break;

	case "savecategory" :
		saveMadBlanksCategory($option);
		break;

	case "editcategory" :
		editMadBlanksCategory($option, $ido);
		break;

	case "canceleditcategory" :
		cancelEditMadBlanksCategory($option);
		break;

	case "copycategory" :
		copyMadBlanksCategory($option, $ido);
		break;

	case "deletecategories" :
		deleteMadBlanksCategories($option, $ido);
		break;

	case "publishcategories" :
		publishMadBlanksCategories($option, 1, $ido);
		break;

	case "unpublishcategories" :
		publishMadBlanksCategories($option, 0, $ido);
		break;

       case 'orderupcategory':
                orderMadBlanksCategories(intval($ido[0]), -1, $option);
                break;

        case 'orderdowncategory':
                orderMadBlanksCategories(intval($ido[0]), 1, $option);
                break;

	case 'showreferencewindow':
		$published = JRequest::getVar('published', 1);
		showReferenceWindow($published);
		break;

	case 'popupreferencewindow':
		?>
		<script language="javascript">popupWindow( '<?php echo JURI::base(); ?>index3.php?option=com_madblanks&task=showreferencewindow', 'madblankscatref', screen.width/2, screen.height*0.667, 'yes' )</script>
		<?php
		defaultScreen($option);
		break;

// Individual record section

	case "saverecordafterpreview" :
		saveAfterPreview($option);
		break;

	case "saverecord" :
		$previewdone = JRequest::getVar('previewdone');
		saveMadBlanksRecord($option, $previewdone);
		break;

	case "quickapproverecord" :
		$theid = JRequest::getVar('id');
		approveMadBlanksRecords($option, array($theid), 1, 0);
		cancelEditMadBlanksRecord($option);
		break;

	case "editrecord" :
		editMadBlanksRecord($option, $ido);
		break;

	case "canceleditrecord" :
		cancelEditMadBlanksRecord($option);
		break;

	case "copyrecord" :
		copyMadBlanksRecord($option, $ido);
		break;

	case "newrecord" :
		newMadBlanksRecord($option);
		break;

	case "deleterecords" :
		deleteMadBlanksRecords($option, $ido);
		break;

	case "publishrecord" :
		publishMadBlanksRecords($option, 1, $ido);
		break;

	case "unpublishrecord" :
		publishMadBlanksRecords($option, 0, $ido);
		break;

	case "approverecord" :
		approveMadBlanksRecords($option, $ido, 1, 1);
		break;

	case "unapproverecord" :
		approveMadBlanksRecords($option, $ido, 0, 1);
		break;

	case "completerecord" :
		completeMadBlanksRecords($option, 1, $ido);
		break;

	case "uncompleterecord" :
		completeMadBlanksRecords($option, 0, $ido);
		break;

	case "listrecords" :
		listMadBlanksRecords($option);
		break;

// Master configuration section

	case "editconfiguration" :
		editMadBlanksConfiguration($option);
		break;

	case "applyconfiguration" :
		saveMadBlanksConfiguration($option, 1);
		break;

	case "saveconfiguration" :
		saveMadBlanksConfiguration($option, 0);
		break;


// ScoreScripts section

	case "listscorescripts" :
		listMadBlanksScoreScripts($option, $task);
		break;

	case "newscorescript" :
		$ido = '';
		editMadBlanksScoreScript($option, $ido);
		break;

	case "applyscorescript" :
		applyMadBlanksScoreScript($option);
		break;

	case "savescorescript" :
		saveMadBlanksScoreScript($option);
		break;

	case "editscorescript" :
		editMadBlanksScoreScript($option, $ido);
		break;

	case "canceleditscorescript" :
		cancelEditMadBlanksScoreScript($option);
		break;

	case "copyscorescript" :
		copyMadBlanksScoreScript($option, $ido);
		break;

	case "deletescorescripts" :
		deleteMadBlanksScoreScripts($option, $ido);
		break;

	case "publishscorescripts" :
		publishMadBlanksScoreScripts($option, 1, $ido);
		break;

	case "unpublishscorescripts" :
		publishMadBlanksScoreScripts($option, 0, $ido);
		break;

       case 'orderupscorescript':
                orderMadBlanksScoreScripts(intval($ido[0]), -1, $option);
                break;

        case 'orderdownscorescript':
                orderMadBlanksScoreScripts(intval($ido[0]), 1, $option);
                break;

	case 'showscorescriptreferencewindow':
		$published = JRequest::getVar('published', 1);
		showScoreScriptReferenceWindow($published);
		break;

//	case 'popupscorescriptreferencewindow':
//		?>
//		<script language="javascript">popupWindow( '<?php echo JUri::base(); ?>/administrator/index3.php?option=com_madblanks&task=showreferencewindow', 'madblankscatref', screen.width/2, screen.height*0.667, 'yes' )</script>
//		<?php
//		defaultScoreScriptScreen($option);
//		break;

// Default section

	default:
		defaultScreen($option);
		break;

} // end switch

/**
 * Default screeen for the backend, displays options in the form of links
 *
 * @param string $option Joomla option string from URL
 */
function defaultScreen($option) {

	$HTML_MadBlanks = new HTML_MadBlanks();
	$HTML_MadBlanks->htmlDefaultScreen($option, 0);

}

/**
 * Apply Mad Blanks Category
 *
 * after the category record has been passed to the server via a form on the edit page, save and return to edit page
 *
 * @global integer if set, prevents the edit category function from being called
 * @param string $option Joomla option string from URL
 */
function applyMadBlanksCategory($option) {
	global $apply_editoverride;
	$apply_editoverride = 0;
	$uid = JRequest::getInt('id', 0);
	//$message = saveMadBlanksCategory($option, 1);
	$newid = saveMadBlanksCategory($option, 1);
	if (empty($uid)) {
		$uid = $newid;
	}	
	$message = sprintf(_MBL_SAVE_CATEGORY_MOSMSG, $newid);
	if (!$apply_editoverride) {
		$_REQUEST['hidemainmenu'] = 1; // Hide the main menu when editing after applying new data
		editMadBlanksCategory($option, array($uid), null, $message);
	}
}

/**
 * Save Mad Blanks Category
 *
 * after the category record has been passed to the server via a form on the edit page
 *
 * @param string $option Joomla option string from URL
 * @param integer $noredirect, when set (as in the applyMadBlanksCategory function),
 * prevents going to the record list, which would normally happen
 * @global integer number of data fields present in the database
 * @global integer if set, prevents the edit category function
 * from being called in the applyMadBlanksCategory function; this keeps us from
 * showing the edit screen twice when using apply during validation
 */
function saveMadBlanksCategory($option, $noredirect=0) {

	//echo "<pre>"; print_r($_POST); echo "</pre>\n";
	
	foreach($_POST as $thekey => $theitem) {
		// if magic quotes is on and POSTed variable is not destined for dataXXconfig
		if ((get_magic_quotes_gpc() && class_exists('JConfig')) || (get_magic_quotes_gpc() && !class_exists('JConfig') && preg_match('/_\d\d$/', $thekey))) {
			$_POST[$thekey] = htmlspecialchars(stripslashes($_POST[$thekey]));
		}
		else {
			$_POST[$thekey] = htmlspecialchars($_POST[$thekey]);
		}
	}
	
	//echo "<pre>POST after magic quotes processing\n\n"; print_r($_POST); echo "</pre>\n";
	//exit;
	
	global $mbFieldCount, $apply_editoverride;

	for ($i=1; $i <= $mbFieldCount; $i++) {
		$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
		$configarray = array(
		
		'index' => $theindex,
		'usetextarea' => JRequest::getVar('usetextarea_' . $theindex, null, 'post'),
		'textareawidth' => JRequest::getVar('textareawidth_' . $theindex, null, 'post'),
		'textareaheight' => JRequest::getVar('textareaheight_' . $theindex, null, 'post'),
		'strtoupper' => JRequest::getVar('strtoupper_' . $theindex, null, 'post'),
		'strtolower' => JRequest::getVar('strtolower_' . $theindex, null, 'post'),
		'ucwords' => JRequest::getVar('ucwords_' . $theindex, null, 'post'),
		'ucfirst' => JRequest::getVar('ucfirst_' . $theindex, null, 'post'),
		'usemultchoice' => JRequest::getVar('usemultchoice_' . $theindex, null, 'post'),
		'usesqlmultchoice' => JRequest::getVar('usesqlmultchoice_' . $theindex, null, 'post'),
		'ischeckbox' => JRequest::getVar('ischeckbox_' . $theindex, null, 'post'),
		'checkboxsep1' => convertMBLiteralToEscaped($_POST['checkboxsep1_' . $theindex]),
		'checkboxsep2' => convertMBLiteralToEscaped($_POST['checkboxsep2_' . $theindex]),
		'checkboxsepa' => convertMBLiteralToEscaped($_POST['checkboxsepa_' . $theindex]),
		'checkboxsepz' => convertMBLiteralToEscaped($_POST['checkboxsepz_' . $theindex]),
		'checkboxsepb' => convertMBLiteralToEscaped($_POST['checkboxsepb_' . $theindex]),
		'checkboxsepy' => convertMBLiteralToEscaped($_POST['checkboxsepy_' . $theindex]),
		'randomorder' => JRequest::getVar('randomorder_' . $theindex, null, 'post'),
		'pointvalue' => preg_replace('/[^\d\-\.]/','', JRequest::getVar('pointvalue_' . $theindex, null, 'post')),
		'ptsperrspns' => preg_replace('/[^\d;\-\.]/',';', JRequest::getVar('ptsperrspns_' . $theindex, null, 'post')),
		'multchoice' => convertMBLiteralToEscaped($_POST['multchoice_' . $theindex]),
		'shortmultchoice' => convertMBLiteralToEscaped($_POST['shortmultchoice_' . $theindex]),
		'multdefault' => convertMBLiteralToEscaped($_POST['multdefault_' . $theindex]),
		'multcorrect' => convertMBLiteralToEscaped($_POST['multcorrect_' . $theindex]),
		'multcasecorrect' => convertMBLiteralToEscaped($_POST['multcasecorrect_' . $theindex]),
		'horizorvert' => (JRequest::getVar('horizorvert_' . $theindex, null, 'post') == 'horizontal' ? 'horizontal' : 'vertical'),
		'validateenable' => JRequest::getVar('validateenable_' . $theindex, null, 'post'),
		'validateregexp' => convertMBLiteralToEscaped($_POST['validateregexp_' . $theindex]),
		'validateerrmsg' => convertMBLiteralToEscaped($_POST['validateerrmsg_' . $theindex]),
		'submitonchange' => convertMBLiteralToEscaped($_POST['submitonchange_' . $theindex]),
		'numcolumns' => JRequest::getVar('numcolumns_' . $theindex, null, 'post'),
		'fieldwidthvalue' => JRequest::getVar('fieldwidthvalue_' . $theindex, '', 'post'),
		'fieldwidthunit' => JRequest::getVar('fieldwidthunit_' . $theindex, '', 'post'),
		'fieldheightvalue' => JRequest::getVar('fieldheightvalue_' . $theindex, '', 'post'),
		'fieldheightunit' => JRequest::getVar('fieldheightunit_' . $theindex, '', 'post'),
		'inputattribute' => JRequest::getVar('inputattribute_' . $theindex, '', 'post'),
		'validatewipe' => JRequest::getInt('validatewipe_' . $theindex, '', 'post'),
		'blankiscorrect' => JRequest::getVar('blankiscorrect_' . $theindex, '', 'post')

		);
		// 1.4.0 RC1 20100731 validate width and height CSS 
		if (!(is_numeric($configarray['fieldwidthvalue']) || $configarray['fieldwidthvalue'] == 'auto' || $configarray['fieldwidthvalue'] == 'inherit')) {
			$configarray['fieldwidthvalue'] = '';	
		}
		if (!(is_numeric($configarray['fieldheightvalue']) || $configarray['fieldheightvalue'] == 'auto' || $configarray['fieldheightvalue'] == 'inherit')) {
			$configarray['fieldheightvalue'] = '';	
		}
		if (is_numeric($configarray['fieldwidthvalue']) && $configarray['fieldwidthvalue'] !=0 && $configarray['fieldwidthunit'] == '') {
			$configarray['fieldwidthvalue'] = '';
		}
		if (is_numeric($configarray['fieldheightvalue']) && $configarray['fieldheightvalue'] !=0 && $configarray['fieldheightunit'] == '') {
			$configarray['fieldheightvalue'] = '';
		}
		if ($configarray['fieldwidthvalue'] == 'auto' || $configarray['fieldwidthvalue'] == 'inherit') {
			$configarray['fieldwidthunit'] = '';
		}
		if ($configarray['fieldheightvalue'] == 'auto' || $configarray['fieldheightvalue'] == 'inherit') {
			$configarray['fieldheightunit'] = '';
		}
		
		$_POST['data_' . $theindex . '_config'] = makeDataConfigString(JRequest::getVar('id', null, 'post'), $i, $configarray);
	}
	
	// combine information (permission to save/overwrite record with Score Script to load on no permission)
	$_POST['user_logged_save'] = JRequest::getVar('user_logged_save', null, 'post') . ';' . JRequest::getVar('user_logged_nosave_scorescript', null, 'post');
	$_POST['user_not_logged_save'] = JRequest::getVar('user_not_logged_save', null, 'post') . ';' . JRequest::getVar('user_not_logged_nosave_scorescript', null, 'post');
	
	$database = &JFactory::getDBO(); 
	$row = new MadBlanksCategory($database);

	// bind it to the table
	if (!$row -> bind($_POST)) {
		echo "<script> alert('"
			. addslashes($row -> getError())
			."'); window.history.go(-1); </script>\n";
		exit();
	}

	//echo "<pre>row after bind\n";
	//print_r($row);
	//echo "</pre>";die();

	$validate_message = '';
	$validate_error_field_list = array();
	for ($i = 1; $i <= $mbFieldCount; $i++) {
		$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
		if ($row->{'data_' . $theindex . '_use'} && !$row->{'data_' . $theindex . '_name'}) {
			$validate_message .= sprintf(_MBL_CATEGORY_VALIDATION_ERROR, $i);//'Found empty name field on activated index; please fill in the value: ' . $theindex . '<br />';
			$validate_error_field_list[$theindex] = true;
		}
	}

	if ($validate_message) {
		$_REQUEST['hidemainmenu'] = 1; // Hide the main menu when reediting after discovering a validation error
		editMadBlanksCategory($option, array($row->id), $row, $validate_message, $validate_error_field_list);
		$apply_editoverride = 1;
		return;
	}

	if (!$row->ordering) {
		$database->setQuery("SELECT MAX(ordering) + 1 from #__madblanks_categories WHERE 1");
		$row->ordering = intval($database->loadResult());
	}

//	echo "<pre>row before store\n";
//	print_r($row);
//	echo "</pre>";

	// store it in the db
	if (!$row -> store()) {
		echo "store error!<br />";
		echo "<script> alert('"
			. addslashes($row -> getError())
			."'); window.history.go(-1); </script>\n";
		exit();
	}

//	echo "<pre>row after store\n";
//	print_r($row);
//	echo "</pre>"; exit;

	// for the "Apply" case
	if ($noredirect) {
		//return sprintf(_MBL_SAVE_CATEGORY_MOSMSG, $row->id);
		return $row->id;
	}
	else {
		$row->checkin();
		$app = &JFactory::getApplication();$app->redirect("index2.php?option=$option&task=listcategories&justsaved=$row->id", sprintf(_MBL_SAVE_CATEGORY_MOSMSG, $row->id));
	}
}

/**
 * Edit Mad Blanks Category
 *
 * pass the category record to the edit form
 *
 * @param string $option Joomla option string from URL
 * @param array $uid category id numbers to process (function only operates on the first one in the array)
 * @param object $validate_row this is used to "try again" in cases when a save has been attempted but the form did not validate
 * @param string $message optional message to show at the top of the edit screen (equivalent to mosmsg)
 * @param array $validate_error_field_list an array whose keys correspond to field numbers with validation errors
 */
function editMadBlanksCategory($option, $uid, $validate_row=null, $message=null, $validate_error_field_list=null) {

	$database =& JFactory::getDBO();
	$my =& JFactory::getUser();
	
	$row = new MadBlanksCategory($database);

	if ($validate_row) {
		$row = $validate_row;
	}

	else if (!empty($uid[0])) {
		$row -> load($uid[0]);
	}

	$row->id = intval($row->id); // CPH 1.4.1 20101218 make sure the following queries are valid

	$database->setQuery( "SELECT count(*) FROM #__madblanks_records where configid = " . $row->id . " AND published = 1");
	$numberpublished = $database->loadResult() ? $database->loadResult() : 0;
	$database->setQuery( "SELECT count(*) FROM #__madblanks_records where configid = " . $row->id . " AND approved > 0");
	$numberapproved = $database->loadResult() ? $database->loadResult() : 0;
	$database->setQuery( "SELECT count(*) FROM #__madblanks_records where configid = " . $row->id . " AND completed > 0");
	$numbercompleted = $database->loadResult() ? $database->loadResult() : 0;
	$database->setQuery( "SELECT count(*) FROM #__madblanks_records where configid = " . $row->id);
	$numbertotal = $database->loadResult() ? $database->loadResult() : 0;
	$database->setQuery( "SELECT count(*) FROM #__madblanks_records where configid = " . $row->id . " AND completed > 0 AND approved > 0 AND published > 0");
	$numberdisplayed = $database->loadResult() ? $database->loadResult() : 0;

	// build the html select list for ordering
	$query = "SELECT ordering AS value, name AS text"
	. "\n FROM #__madblanks_categories"
	. "\n ORDER BY ordering"
	;
	
	//$mosAdminMenus = new mosAdminMenus();
	//$lists['ordering'] = $mosAdminMenus->SpecificOrdering( $row, $uid, $query );
	$lists['ordering'] = JHTML::_('list.specificordering', $row, $uid, $query);

	// get list of score scripts
	$scorescripts[] =  JHTML::_('select.option',  '0', _MBL_NO_DEFAULT_SCORESCRIPT );
	// "AS" aliases in this MySQL query are turned into variables and used below in the call to selectList()
	$database->setQuery( "SELECT id AS value,CONCAT('#',id,': ',IF(name > '',IF(CHAR_LENGTH(name) > 100,CONCAT(LEFT(name,97),'...'),name),'&lt;" . _MBL_NO_NAME . "&gt;')) AS text FROM #__madblanks_scorescripts WHERE 1 ORDER BY ordering ASC,id ASC" );
	// take the returned object and make an array of arrays...
	$scriptsarray = (array)$database->loadObjectList();
	
	$scorescripts = array_merge($scorescripts, $scriptsarray);

	// the first argument selectList() accepts is an array, the components of which are referred to in the later variables of the call
	$lists['scorescripts'] = JHTML::_('select.genericlist', $scorescripts, 'default_score_script',
	'class="inputbox" size="1"', 'value', 'text', $row->default_score_script);
	
	// 1.4.0 Beta 6 break the user_logged_save and the user_not_logged_save from the category 
	//  into its two parts CPH 20100611
	//  (the action [new, overwrite, disallowoverwrite, or disallowwrite] and the Score Script id)
	$user_logged_permission_scorescript = explode(';', $row->user_logged_save);
	if (!isset($user_logged_permission_scorescript[0])) {
		$user_logged_permission_scorescript[0] = 'new'; // new is the default
	}
	if (!isset($user_logged_permission_scorescript[1])) {
		$user_logged_permission_scorescript[1] = 0; // 0 (no Score Script selected) is the default
	}
	$user_not_logged_permission_scorescript = explode(';', $row->user_not_logged_save);
	if (!isset($user_not_logged_permission_scorescript[0])) {
		$user_not_logged_permission_scorescript[0] = 'new'; // new is the default
	}
	if (!isset($user_not_logged_permission_scorescript[1])) {
		$user_not_logged_permission_scorescript[1] = 0; // 0 (no Score Script selected) is the default
	}

	// 1.4.0 Beta 6 add ability to load a Score Script when user/visitor not allowed to create a record CPH 20100611
	$scorescripts[0]->text = _MBL_RECORD_DISALLOW_SCORESCRIPT;
	$lists['user_logged_nosave_scorescript'] = JHTML::_('select.genericlist', $scorescripts, 'user_logged_nosave_scorescript',
	'class="inputbox" size="1"', 'value', 'text', $user_logged_permission_scorescript[1]);
	$lists['user_not_logged_nosave_scorescript'] = JHTML::_('select.genericlist', $scorescripts, 'user_not_logged_nosave_scorescript',
	'class="inputbox" size="1"', 'value', 'text', $user_not_logged_permission_scorescript[1]);

	// CPH 20090523 1.1.0final add 'archive' Score Scripts to be displayed with records later on
	$archivescorescripts[] =  JHTML::_('select.option',  '0', _MBL_NO_ARCHIVE_SCORESCRIPT );
	$archivescorescripts = array_merge($archivescorescripts, $scriptsarray);
	
	// the first argument selectList() accepts is an array, the components of which are referred to in the later variables of the call
	$lists['archivescorescripts'] = JHTML::_('select.genericlist', $archivescorescripts, 'archive_score_script',
		'class="inputbox" size="1"', 'value', 'text', $row->archive_score_script);
	
	unset($scriptsarray);
	unset($scorescripts);
	unset($archivescorescripts);
	

	$user_logged_save[] =  JHTML::_('select.option',  'new', JText::sprintf(_MBL_RECORD_CREATE_NEW, _MBL_LOGGED_USER));
	$user_logged_save[] =  JHTML::_('select.option',  'overwrite', JText::sprintf(_MBL_RECORD_OVERWRITE, _MBL_LOGGED_USER));
	$user_logged_save[] =  JHTML::_('select.option',  'disallowoverwrite', JText::sprintf(_MBL_RECORD_DISALLOW_OVERWRITE, _MBL_LOGGED_USER));
	$user_logged_save[] =  JHTML::_('select.option',  'disallowwrite', _MBL_RECORD_DISALLOW_WRITE);
	
	// the first argument selectList() accepts is an array, the components of which are referred to in the later variables of the call
	$lists['user_logged_save'] = JHTML::_('select.genericlist', $user_logged_save, 'user_logged_save',
		'class="inputbox"', 'value', 'text', /*$row->user_logged_save*/$user_logged_permission_scorescript[0]);
		
	unset($user_logged_save);

	$user_not_logged_save[] =  JHTML::_('select.option',  'new', JText::sprintf(_MBL_RECORD_CREATE_NEW, _MBL_NOT_LOGGED_VISITOR));
	$user_not_logged_save[] =  JHTML::_('select.option',  'overwrite', JText::sprintf(_MBL_RECORD_OVERWRITE, _MBL_NOT_LOGGED_VISITOR));
	$user_not_logged_save[] =  JHTML::_('select.option',  'disallowoverwrite', JText::sprintf(_MBL_RECORD_DISALLOW_OVERWRITE, _MBL_NOT_LOGGED_VISITOR));
	$user_not_logged_save[] =  JHTML::_('select.option',  'disallowwrite', _MBL_RECORD_DISALLOW_WRITE);
	
	// the first argument selectList() accepts is an array, the components of which are referred to in the later variables of the call
	$lists['user_not_logged_save'] = JHTML::_('select.genericlist', $user_not_logged_save, 'user_not_logged_save',
		'class="inputbox"', 'value', 'text', /*$row->user_not_logged_save*/$user_not_logged_permission_scorescript[0]);
		
	unset($user_not_logged_save);
	
	// fail if checked out not by current user
	//(we should usually never get here because the checkbox and link to edit this record should not have been available)
	if ($row->checked_out && $row->checked_out != $my->id) {
		$app = &JFactory::getApplication();$app->redirect( "index2.php?option=$option&task=listcategories", sprintf(_MBL_CHECKED_OUT_ERROR, _MBL_CATEGORY_NAME, $row->name, getUserNameByID($row->checked_out, 1) . ' [' . getUserNameByID($row->checked_out, 0) . ']' ));
	}

	$row->checkout($my->id);

	$HTML_MadBlanks = new HTML_MadBlanks();
	$HTML_MadBlanks->htmlEditMadBlanksCategory($option, $row, $lists, $numbercompleted, $numberapproved, $numberpublished, $numbertotal, $numberdisplayed, $message, $validate_error_field_list);
}

/**
 * Cancels an edit operation
 *
 * @param string $option Joomla option string from URL
 */
function cancelEditMadBlanksCategory($option) {
        $database = &JFactory::getDBO(); 

        $row = new MadBlanksCategory($database);
        $row->bind( $_POST );
        $row->checkin();

        $app = &JFactory::getApplication();$app->redirect("index2.php?option=$option&task=listcategories");
}

/**
 * Copy Mad Blanks Category
 *
 * @param string $option Joomla option string from URL
 * @param array $cid category id numbers to process (function only operates on the first one in the array)
 */
function copyMadBlanksCategory($option, $cid) {

	$database = &JFactory::getDBO(); 
	if (!is_array($cid) || count($cid) < 1 || !$cid[0]) {
		echo "<script> alert('" . sprintf(_MBL_MAKE_SELECTION, JString::strtolower(_MBL_COPY)) . "'); window.location.href='index2.php?option=$option&task=listcategories&mosmsg=" . sprintf(_MBL_MAKE_SELECTION, JString::strtolower(_MBL_COPY)) . "';</script>\n";
		exit();
	}

	$row = new MadBlanksCategory($database);

	if($cid[0]){
		$row -> load($cid[0]);
		$row->id = NULL;
		$row->published = 0; // copied configuration unpublished by default
		$row->name = _MBL_COPY_OF . ' ' . $row->name;
		$row->date_created = date("Y-m-d\ H:i:s");
	}
	else {
		echo "<script> alert('Unable to copy the configuration (no cid[0] passed to function)'); window.history.go(-1);</script>\n";
		exit();
	}

	// store it in the db
	if (!$row -> store()) {
		echo "<script> alert('"
			. addslashes($row -> getError())
			."'); window.history.go(-1); </script>\n";
		exit();
	}

	$app = &JFactory::getApplication();$app->redirect("index2.php?option=$option&task=listcategories", sprintf(_MBL_CATEGORY_COPY_MOSMSG, $cid[0], madblanks_mysql_insert_id($database->_resource)));

}

/**
 * Delete Mad Blanks Categories
 *
 * @param string $option Joomla option string from URL
 * @param array $cid category id numbers to process (function operates on ALL categories given in the array)
 */
function deleteMadBlanksCategories($option, $cid) {
	$database = &JFactory::getDBO(); 
	if (!is_array($cid) || count($cid) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit();
	}

	if (count($cid))
	{
		foreach ($cid as $item) {
			$database->setQuery("SELECT COUNT(*) FROM #__madblanks_records WHERE configid = '$item'");
			$thecount = $database->loadResult();
			if ($thecount) {
				echo "<script> if(confirm('The database for category $item has $thecount records. '"
				. "\n + 'Confirm deletion or cancel.')){} else { window.history.go(-1) }; </script>\n";
			}
		}


		$ids = implode(',', $cid);
		$database->setQuery("DELETE FROM #__madblanks_categories \nWHERE id IN ($ids)");
	}

	if (!$database->query()) {
		echo "<script> alert('"
			.$database -> getErrorMsg()
			."'); window.history.go(-1); </script>\n";
	}
	
	$app = &JFactory::getApplication();
	$app->redirect("index2.php?option=$option&task=listcategories", $cid[1] ? sprintf(_MBL_CATEGORY_DELETE_PLURAL_MOSMSG, implode(", ", $cid)) : sprintf(_MBL_CATEGORY_DELETE_SINGULAR_MOSMSG, $cid[0]));
}

/**
 * List Mad Blanks Categories
 *
 * @param string $option Joomla option string from URL
 * @param array $task component task string from URL
 */
function listMadBlanksCategories($option, $task) {
	
	//global $mainframe;
	$database = &JFactory::getDBO();
	$app = &JFactory::getApplication();

	// passed from the dropdown menu to select awards for only a particular member
	//$matchtypelimit = JRequest::getInt('matchtypelimit', 0);
	//$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $app->getCfg('list_limit'));
	//$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	$limit = $app->getUserStateFromRequest("$option.categories.limit", 'limit', $app->getCfg('list_limit'));
	$limitstart = $app->getUserStateFromRequest( "$option.categories.limitstart", 'limitstart', 0 );
	
	// get the total number of records
	$thequery = "SELECT count(*) FROM #__madblanks_categories";
	//if ($matchtypelimit) {
	//	$thequery .= " WHERE type='$matchtypelimit'";
	//}
	$database->setQuery($thequery);
	$total = $database->loadResult();
	//require_once( JPATH_SITE . '/administrator/includes/pageNavigation.php' );
	//$pageNav = new mosPageNav( $total, $limitstart, $limit );
	
	// In case limit has been changed, adjust it
	if ($limitstart > $total) {
		$limitstart = 0;
	}

	// 1.4.0 RC1 20100729 Position the pagination to display the page that lists the saved category
	$justsaved = JRequest::getVar('justsaved', 0); 
	// now determine what ordering this record number is in the list when sorted by the 'ordering' field ASC
	if ($justsaved && $limit > 0) {

		$thequery = "SELECT id FROM #__madblanks_categories ORDER BY ordering ASC";
		$database->setQuery($thequery);
		$rows_for_ordering = $database->loadObjectList();

		$ordering_in_list = 0; // initialize
		foreach ($rows_for_ordering as $rowindex => $rowcontent) {
			if ($rowcontent->id == $justsaved) {
				$ordering_in_list = $rowindex;
				break;
			}

		}
		//echo "<pre>"; print_r($rows_for_ordering); echo "</pre>\n";
		//echo "<h1>ordering_in_list for $justsaved is $ordering_in_list</h1>";

		// calculate the appropriate $limitstart
		$limitstart = floor($ordering_in_list / $limit) * $limit;
		//echo "<h1>new limitstart is $limitstart</h1>";
	}

	$app->setUserState("$option.categories.limit", $limit);
	$app->setUserState( "$option.categories.limitstart", $limitstart);
	
	jimport('joomla.html.pagination');
	if (version_compare(PHP_VERSION, '5.0.0', '<')) { // PHP 4
		$pageNavCategory =& new JPagination($total, $limitstart, $limit);
	}
	else { // PHP 5
		$pageNavCategory = new JPagination($total, $limitstart, $limit);
	}

	$thequery = "SELECT c.*, concat(u.name, ' (', u.username, ')') AS editor FROM #__madblanks_categories AS c
	LEFT JOIN #__users AS u ON u.id = c.checked_out";
	//if ($matchtypelimit) {
	//	$thequery .= " WHERE c.type='$matchtypelimit'";
	//}
	$thequery .= " ORDER BY c.ordering ASC LIMIT $pageNavCategory->limitstart,$pageNavCategory->limit";
	$database->setQuery($thequery);
	$rows = $database -> loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}

	// inject a count of records for a given category ID into the object for each category
	foreach ($rows as $thekey => $row) {
		$database->setQuery( "SELECT count(*) FROM #__madblanks_records where configid = '" . $row->id . "'");
		$rows[$thekey]->numbertotal = $database->loadResult();
	}

	$HTML_MadBlanks = new HTML_MadBlanks();
	$HTML_MadBlanks->htmlListMadBlanksCategories($option, $rows, $task, $pageNavCategory);
}

/**
 * Complete or uncomplete individual Mad Blanks records
 *
 * @param string $option Joomla option string from URL
 * @param integer $complete mark the passed records as complete (1) or uncomplete (0)
 * @param array $cid record id numbers to process (function operates on ALL categories given in the array)
 */
function completeMadBlanksRecords($option, $complete=1, $cid) {
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	
	if (!is_array( $cid ) || count( $cid ) < 1) {
		$action = $publish ? 'complete' : 'uncomplete';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__madblanks_records SET completed=" . ($complete ? $my->id : 0)
	. "\nWHERE id IN ($cids) AND (checked_out=0 OR checked_out=$my->id)");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	// $categorylimit, $sortby, $sortascordesc, and $authorlimit are simply passed through
	//  via hidden form fields to preserve the content of the filter and sort pulldown menu lists
	$categorylimit = JRequest::getVar('categorylimit');
        $authorlimit = JRequest::getVar('authorlimit');
	$sortby = JRequest::getVar('sortby');
	$sortascordesc = JRequest::getVar('sortascordesc');

$app = &JFactory::getApplication();$app->redirect( "index2.php?option=$option&task=listrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit" );
}

/**
 * Approve or unapprove individual Mad Blanks records
 *
 * @param string $option Joomla option string from URL
 * @param array $cid record id numbers to process (function operates on ALL categories given in the array)
 * @param integer $approve mark the passed records as approved (1) or unapproved (0)
 * @param integer $doredirect if this variable not empty, redirect to the list of records at the end of the function
 */
function approveMadBlanksRecords($option, $cid, $approve=1, $doredirect=1) {
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	if (!is_array( $cid ) || count( $cid ) < 1) {
		$action = $publish ? 'approve' : 'unapprove';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__madblanks_records SET approved=" . ($approve ? $my->id : 0)
	. "\nWHERE id IN ($cids) AND (checked_out=0 OR checked_out=$my->id)");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if ($doredirect) {
		// $categorylimit, $sortby, $sortascordesc, and $authorlimit are simply passed through
		//  via hidden form fields to preserve the content of the filter and sort pulldown menu lists
		$categorylimit = JRequest::getVar('categorylimit');
		$sortby = JRequest::getVar('sortby');
		$sortascordesc = JRequest::getVar('sortascordesc');
		$authorlimit = JRequest::getVar('authorlimit');

		$app = &JFactory::getApplication();$app->redirect("index2.php?option=$option&task=listrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit");
	}
}

/**
 * Publish or unpublish individual Mad Blanks records
 *
 * @param string $option Joomla option string from URL
 * @param integer $publish publish (1) or unpublish (0) the passed records
 * @param array $cid record id numbers to process (function operates on ALL categories given in the array)
 */
function publishMadBlanksRecords($option, $publish=1, $cid) {
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	if (!is_array( $cid ) || count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__madblanks_records SET published='$publish'"
	. "\nWHERE id IN ($cids) AND (checked_out=0 OR checked_out=$my->id)");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	// $categorylimit, $sortby, $sortascordesc, and $authorlimit are simply passed through
	//  via hidden form fields to preserve the content of the filter and sort pulldown menu lists
	$categorylimit = JRequest::getVar('categorylimit');
	$sortby = JRequest::getVar('sortby');
	$sortascordesc = JRequest::getVar('sortascordesc');
	$authorlimit = JRequest::getVar('authorlimit');

	$app = &JFactory::getApplication();$app->redirect( "index2.php?option=$option&task=listrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit");
}

/**
 * Publish or unpublish Mad Blanks categories
 *
 * @param string $option Joomla option string from URL
 * @param integer $publish publish (1) or unpublish (0) the passed records
 * @param array $cid category id numbers to process (function operates on ALL categories given in the array)
 */
function publishMadBlanksCategories($option, $publish=1 ,$cid) {
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	if (!is_array( $cid ) || count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__madblanks_categories SET published='$publish'"
	. "\nWHERE id IN ($cids)"
	// AND (checked_out=0 OR (checked_out='$my->id')
	);
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$app = &JFactory::getApplication();$app->redirect( "index2.php?option=$option&task=listcategories" );
}

/**
 * Call saveMadBlanksRecord with the 'previewdone' flag set
 *
 * This indicates that the save function should not call the preview routine
 *
 * @param string $option Joomla option string from URL
 */
function saveAfterPreview($option) {
	saveMadBlanksRecord($option, 1);
}

/**
 * Save Mad Blanks individual record
 *
 * after the record has been passed to the server via a form on the edit page
 *
 * @param string $option Joomla option string from URL
 * @param integer $previewdone When present, this flag indicates that this save function should not call the preview routine
 */
function saveMadBlanksRecord($option, $previewdone=0) {

	// $categorylimit, $sortby, $sortascordesc, and $authorlimit are simply passed through
	//  via hidden form fields to preserve the content of the filter and sort pulldown menu lists
	$categorylimit = JRequest::getVar('categorylimit');
	$sortby = JRequest::getVar('sortby');
	$sortascordesc = JRequest::getVar('sortascordesc');
	$authorlimit = JRequest::getVar('authorlimit');
	
	//echo "<pre>"; print_r($_POST); echo "</pre>\n";exit;

	foreach( $_POST as $thekey => $theitem ) {
		// Clean posted variables for security
		if (is_string($theitem)) {
			$_POST[$thekey] = get_magic_quotes_gpc() ? htmlspecialchars(stripslashes($theitem)) : htmlspecialchars($theitem);
		}
	}
	
	// add this section to deal with form controls other than textarea and input 20100505
	
	global $mbFieldCount;
	for ($i=1; $i <= $mbFieldCount; $i++) {
		$theindex = sprintf('%02d', $i);
		// 1.4.0 Beta 6 add check that data_XX is an array before imploding it 20100612
		if (isset($_POST['data_' . $theindex . '_array']) && $_POST['data_' . $theindex . '_array'] && is_array($_POST['data_' . $theindex])) {
			$_POST['data_' . $theindex] = implode('[:multisep:]', $_POST['data_' . $theindex]);
		}
	}

	global $mbPreviewBeforeSave, $mbFieldCount;
	$database = &JFactory::getDBO();
	
	$row = new MadBlanksRecord($database);

	// bind it to the table
	if (!$row -> bind($_POST)) {
		echo "<script> alert('"
			. addslashes($row -> getError())
			."'); window.history.go(-1); </script>\n";
		exit();
	}

	$configuration = getConfigurationArray(1);
	if ($configuration[$row->configid]->allow_html_input) {
		for ($i=1; $i <= $mbFieldCount; $i++) {
			$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
			$row->{'data_'.$theindex} = JRequest::getVar('data_' . $theindex, '', 'request', 'none', JREQUEST_ALLOWHTML);
		}	
	}

	if (!$previewdone && $mbPreviewBeforeSave) {
		$content_string = concatenateDisplayString($mbFieldCount, $row, $configuration[$row->configid], 0, 0);
		
		$HTML_MadBlanks = new HTML_MadBlanks();			
		$HTML_MadBlanks->htmlSaveMadBlanksRecordPreview($option, $row, $content_string, $categorylimit, $sortby, $sortascordesc, $authorlimit);
	}

	else {
		// track who modified this record and when
		if (empty($row->date_entered)) { // only put in a date_entered when the record is created, never again
			$row->date_entered = date("YmdHis"); //save date in MySQL format
		}
		$row->date_modified = date("YmdHis"); //save date in MySQL format
		$my = &JFactory::getUser();
		$row->modified_by = $my->id; // id number of the current user
		
		$row->scodata1 = convertFromQuotLtGt($row->scodata1);
		$row->scodata2 = convertFromQuotLtGt($row->scodata2);

		// store it in the db
		if (!$row -> store()) {
			echo "store error!<br />";
			echo "<script> alert('"
				. addslashes($row -> getError())
				."'); window.history.go(-1); </script>\n";
			exit();
		}

		$row->checkin();

		$app = &JFactory::getApplication();$app->redirect("index2.php?option=$option&task=listrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit&justsaved=$row->id", sprintf(_MBL_SAVE_RECORD_MOSMSG, madblanks_mysql_insert_id($database->_resource) ? madblanks_mysql_insert_id($database->_resource) : $row->id));
	}
}

/**
 * Delete Mad Blanks Records
 *
 * @param string $option Joomla option string from URL
 * @param array $cid category id numbers to process (function operates on ALL categories given in the array)
 */
function deleteMadBlanksRecords($option, $cid) {
	$database = &JFactory::getDBO(); 
	if (!is_array($cid) || count($cid) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit();
	}

	if (count($cid))
	{
		$ids = implode(',', $cid);
		$database->setQuery("DELETE FROM #__madblanks_records \nWHERE id IN ($ids)");
	}
	if (!$database->query()) {
		echo "<script> alert('"
			.$database -> getErrorMsg()
			."'); window.history.go(-1); </script>\n";
	}

	// $categorylimit, $sortby, $sortascordesc, and $authorlimit are simply passed through
	//  via hidden form fields to preserve the content of the filter and sort pulldown menu lists
	$categorylimit = JRequest::getVar('categorylimit');
	$sortby = JRequest::getVar('sortby');
	$sortascordesc = JRequest::getVar('sortascordesc');
	$authorlimit = JRequest::getVar('authorlimit');

	$app =& JFactory::getApplication();
	$app->redirect("index2.php?option=$option&task=listrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit", isset($cid[1]) ? sprintf(_MBL_RECORD_DELETE_PLURAL_MOSMSG, implode(", ", $cid)) : sprintf(_MBL_RECORD_DELETE_SINGULAR_MOSMSG, $cid[0]));
}

/**
 * List Records
 *
 * @param string $option Joomla option string from URL
 */
function listMadBlanksRecords($option) {
	//global $mainframe;
	$app =& JFactory::getApplication();
	$database =& JFactory::getDBO();
	
	// passed from the dropdown menu to select records for only a particular category
	$categorylimit = intval(JRequest::getVar('categorylimit'));
	$sortby = JRequest::getVar('sortby', 0);
	$authorlimit = JRequest::getVar('authorlimit');

	if (!$sortby) {
		$sortby = "id"; // default is to order by id descending
	}
	$sortascordescselection = JRequest::getVar('sortascordesc', 0);
	if (!$sortascordescselection) {
		$sortascordescselection = "DESC"; // default is to order by id descending
	}
	
	//$limit = JRequest::getVar('limit');
	$limit = $app->getUserStateFromRequest("$option.records.limit", 'limit', $app->getCfg('list_limit'));
	$limitstart = $app->getUserStateFromRequest( "$option.records.limitstart", 'limitstart', 0 );

	if (!is_numeric($limit)) {
		//$app = &JFactory::getApplication();
		$limit = $app->getCfg('list_limit');
	}

	//$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

	// get the total number of records
	$thequery = "SELECT count(*) FROM #__madblanks_records WHERE 1";
	if ($categorylimit) {
		$thequery .= " AND configid=" . (int) $categorylimit;
	}
	if ($authorlimit) {
		$thequery .= " AND entered_by=" . ($authorlimit == 'noauthor' ? 0 : (int) $authorlimit);
	}
	$database->setQuery($thequery);
	$total = $database->loadResult();
	//require_once( JPATH_SITE . '/administrator/includes/pageNavigation.php' );
	//$pageNav = new mosPageNav( $total, $limitstart, $limit );
	
	// In case limit has been changed, adjust it
	if ($limitstart > $total) {
		$limitstart = 0;
	}

	if ($sortby) {
		$order_by_clause = " ORDER BY data." . isValidMadBlanksVariableForSQL($sortby, 0, 'id');
		 if (strval($sortascordescselection) == "ASC" || strval($sortascordescselection) == "DESC") {
		 	$order_by_clause .= ' ' . $sortascordescselection;
		 }
	}
	else {
		$order_by_clause = " ORDER BY data.id DESC";
	}

	// 1.4.0 RC1 20100729 Position the pagination to display the page that lists the saved category
	$justsaved = JRequest::getVar('justsaved', 0); 
	// now determine what ordering this record number is in the list when sorted by the 'ordering' field ASC
	if ($justsaved && $limit > 0) {

		$thequery = "SELECT id FROM #__madblanks_records AS data" . $order_by_clause;
		$database->setQuery($thequery);
		$rows_for_ordering = $database->loadObjectList();

		$ordering_in_list = 0; // initialize
		foreach ($rows_for_ordering as $rowindex => $rowcontent) {
			if ($rowcontent->id == $justsaved) {
				$ordering_in_list = $rowindex;
				break;
			}

		}
		//echo "<pre>"; print_r($rows_for_ordering); echo "</pre>\n";
		//echo "<h1>ordering_in_list for $justsaved is $ordering_in_list</h1>";

		// calculate the appropriate $limitstart
		$limitstart = floor($ordering_in_list / $limit) * $limit;
		//echo "<h1>new limitstart is $limitstart</h1>";
	}

	$app->setUserState("$option.records.limit", $limit);
	$app->setUserState( "$option.records.limitstart", $limitstart);

	jimport('joomla.html.pagination');

	if (version_compare(PHP_VERSION, '5.0.0', '<')) { // PHP 4
		$pageNavRecord =& new JPagination($total, $limitstart, $limit);
	}
	else { // PHP 5
		$pageNavRecord = new JPagination($total, $limitstart, $limit);
	}
	
	$thequery = "SELECT data.*, concat(u.name, ' (', u.username, ')') AS editor FROM #__madblanks_records AS data
	LEFT JOIN #__users AS u ON u.id = data.checked_out WHERE 1";
	if ($categorylimit) {
		$thequery .= " AND data.configid=" . (int) $categorylimit;
	}
	if ($authorlimit) {
		$thequery .= " AND data.entered_by=" . ($authorlimit == 'noauthor' ? 0 : (int) $authorlimit);
	}
	$thequery .= $order_by_clause;
	$thequery .= " LIMIT $pageNavRecord->limitstart,$pageNavRecord->limit"; // date_entered DESC,
	$database->setQuery($thequery);
	$rows = $database -> loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}

	$lists = array();
	// get list of categories
	$categories[] =  JHTML::_('select.option',  '0', _MBL_ALL_CATEGORIES );
	// "AS" aliases in this MySQL query are turned into variables and used below in the call to selectList()
	$database->setQuery( "SELECT id AS value,CONCAT('#',id,': ',IF(name > '',name,'&lt;" . _MBL_NO_NAME . "&gt;')) AS text FROM #__madblanks_categories WHERE 1 ORDER BY id" );
	// take the returned object and make an array of arrays...
	$categories = array_merge($categories, (array)$database->loadObjectList());

	// the first argument selectList() accepts is an array, the components of which are referred to in the later variables of the call
	$lists['categorylimit'] = JHTML::_('select.genericlist',  $categories, 'categorylimit',
	'class="inputbox" size="1" onchange="document.adminForm.submit();"',
	'value', 'text', $categorylimit );
	unset( $categories );

	$sortoptions[] =  JHTML::_('select.option',  '0', _MBL_CHOOSE_SORT_CRITERIA );

	$arrangeby = (array) new MadBlanksRecord($database);

	// grab the variable names stored in the keys of the $arrangeby array to make a list of things we can sort by
	foreach ($arrangeby as $thekey => $thevalue) {
		if (strpos($thekey, "_") !== 0) { // if $thekey does NOT start with an underscore
			array_push($sortoptions,  JHTML::_('select.option',  $thekey, defined('_MBL_SORT_PULLDOWN_' . JString::strtoupper($thekey)) ? constant('_MBL_SORT_PULLDOWN_' . JString::strtoupper($thekey)) : strval($thekey)));
		}
	}

	$lists['sortby'] = JHTML::_('select.genericlist',  $sortoptions, 'sortby',
		'class="inputbox" size="1" onchange="document.adminForm.submit();"',
		'value', 'text', $sortby );
	unset($arrangeby);
	unset($sortoptions);

	$sortascordesc[0] =  JHTML::_('select.option',  'ASC', _MBL_SORT_ASCENDING );
	$sortascordesc[1] =  JHTML::_('select.option',  'DESC', _MBL_SORT_DESCENDING );

	$lists['sortascordesc'] = JHTML::_('select.genericlist',  $sortascordesc, 'sortascordesc',
		'class="inputbox" size="1" onchange="document.adminForm.submit();"',
		'value', 'text', $sortascordescselection );
	unset($sortascordesc);

	// "AS" aliases in this MySQL query are turned into variables and used below in the call to selectList()
	$database->setQuery( "SELECT DISTINCT entered_by AS value, entered_by AS text FROM #__madblanks_records WHERE 1 ORDER BY entered_by" );
	// take the returned object and make an array of arrays...
	$authors = array_merge((array)$database->loadObjectList());

	global $mbEnteredByLongFormat;
	$authorzeroexists = 0;
	foreach ($authors as $thekey => $author) {
		if ($author->text) {
			$authors[$thekey]->text = getUserNameByID ($author->text, $mbEnteredByLongFormat);
		}
		else {
			$authors[$thekey]->text = _MBL_ALL_AUTHORS;
			$authorzeroexists = 1;
		}
	}
	if (empty($authorzeroexists)) {
		// This will create an object from an array and put it on the beginning of the array
		array_unshift($authors, (object) array('value'=> 0, 'text'=>_MBL_ALL_AUTHORS) );
	}

	$authors[] =  JHTML::_('select.option', 'noauthor', _MBL_NO_AUTHOR_LIST);

	// the first argument selectList() accepts is an array, the components of which are referred to in the later variables of the call
	$lists['authorlimit'] = JHTML::_('select.genericlist',  $authors, 'authorlimit',
	'class="inputbox" size="1" onchange="document.adminForm.submit();"',
	'value', 'text', $authorlimit );
	unset( $authors );

	$task = JRequest::getVar('task');

	// we need to know if $categorylimit is in place in order to display the note saying the list is filtered
	$HTML_MadBlanks = new HTML_MadBlanks();
	$HTML_MadBlanks->htmlListMadBlanksRecords($option, $task, $rows, $pageNavRecord, $lists, $categorylimit, $authorlimit, $sortby, $sortascordescselection, 255, $limit);
}

/**
 * New Mad Blanks individual record
 *
 * This function presents a list of links so the user can choose which category to create a new record for.
 * If the category of the new record ($configid) is already defined, skip directly to editing the new record.
 *
 * @param string $option Joomla option string from URL
 */
function newMadBlanksRecord($option) {

	if (JRequest::getVar('configid')) {
		editMadBlanksRecord($option, null);
	}
	else {
		$database = &JFactory::getDBO(); 
		// get the category id numbers, names, and publish status
		$database->setQuery("SELECT id, name, published FROM #__madblanks_categories ORDER BY published DESC, ordering ASC, id ASC");
		$rows = $database->loadObjectList();

		// $categorylimit, $sortby, $sortascordesc, and $authorlimit are simply passed through
		//  via hidden form fields to preserve the content of the filter and sort pulldown menu lists
		$categorylimit = JRequest::getVar('categorylimit');
		$authorlimit = JRequest::getVar('authorlimit');
		$sortby = JRequest::getVar('sortby');
		$sortascordesc = JRequest::getVar('sortascordesc');

		$HTML_MadBlanks = new HTML_MadBlanks();
		$HTML_MadBlanks->htmlNewMadBlanksRecord($option, $rows, $categorylimit, $sortby, $sortascordesc, $authorlimit);
	}
}

/**
 * Edit Mad Blanks individual record
 *
 * Edit an individual Mad Blanks record on the backend, defined by $uid.
 * If $_REQUEST[$configid] is set and $uid is not, create a new record
 * using that category id number.
 *
 * @param string $option Joomla option string from URL
 * @param array $uid id numbers to process (function only operates on the first one in the array)
 */
function editMadBlanksRecord($option, $uid) {

	// $categorylimit, $sortby, $sortascordesc, and $authorlimit are simply passed through
	//  via hidden form fields to preserve the content of the filter and sort pulldown menu lists
	$categorylimit = JRequest::getVar('categorylimit');
	$authorlimit = JRequest::getVar('authorlimit');
	$sortby = JRequest::getVar('sortby');
	$sortascordesc = JRequest::getVar('sortascordesc');

	$configid = JRequest::getVar('configid');
	$jumptorecord = JRequest::getVar('jumptorecord');
	$reeditpreview = JRequest::getVar('reeditpreview');

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	
	$row = new MadBlanksRecord($database);

	if (is_numeric($jumptorecord)){
		$row -> load($jumptorecord);

		// this is an existing record, so pre-select the author for the "entered by" pulldown menu
		if (isset($row->entered_by)) {
			$entered_by = $row->entered_by;
		}
		else { // unless there was no author specified
			$entered_by = 0;
		}
	}
	else if($uid[0] && !$reeditpreview) { // editing an existing record
		$row -> load($uid[0]);

		// this is an existing record, so pre-select the author for the "entered by" pulldown menu
		if (isset($row->entered_by)) {
			$entered_by = $row->entered_by;
		}
		else { // unless there was no author specified
			$entered_by = 0;
		}
	}
	else { // new record; published and show_in_random are enabled by default

		// when creating a new record on the backend, make the radio buttons completed and pubslihed by default
		// the class file makes them zero by default for the benefit of the field at a time module
		$row->completed = 1;
		$row->published = 1;

		// the following in case we've come back to reedit an entry from the preview
		// if there's nothing to bind in $_POST, this won't have an effect

		// fix up $_POST vars to be reinserted into the editing form
		foreach($_POST as $thekey=>$thevalue) {
			// check that thekey doesn't start with underscore and leave out checked_out and checked_out_time
			if (!(strpos($thekey, "_") === 0) && $thekey != 'checked_out' && $thekey != 'checked_out_time' && is_string($thevalue)) {
				$_POST[$thekey] = get_magic_quotes_gpc() ? htmlspecialchars(stripslashes($_POST[$thekey])) : htmlspecialchars($_POST[$thekey]);
			}
		}

		// bind it to the table
		if (!$row -> bind($_POST)) {
			echo "<script> alert('"
			. addslashes($row -> getError())
			."'); window.history.go(-1); </script>\n";
			exit();
		}

		// set these in the class file class declaration instead
		//$row->published = 1;
		//$row->show_in_random = 1;

		// this is a new record, so pre-select the current user for the "entered by" pulldown menu
		
		$my = &JFactory::getUser();

		// user saved during record preview if exists, else current user's id number
		$entered_by = isset($row->entered_by) && !empty($row->entered_by) ? $row->entered_by : $my->id;
	}

	// fail if checked out not by current user
	//(we should usually never get here because the checkbox and link to edit this record should not have been available)
	if ($row->checked_out && $row->checked_out != $my->id) {
		$app = &JFactory::getApplication();$app->redirect( "index2.php?option=$option&task=listrecords", sprintf(_MBL_CHECKED_OUT_ERROR, _MBL_RECORD_NAME, "#" . $row->id, getUserNameByID($row->checked_out, 1) . ' [' . getUserNameByID($row->checked_out, 0) . ']' ));
	}

	$row->checkout($my->id);

	if($row->configid) {
		$configid = $row->configid;
	}
	else {
		$row->configid = $configid;
	}

	// if the category configuration was not loaded, redirect back to the list with error message
	if (!isset($row->configid)) {
		$app = &JFactory::getApplication();$app->redirect("index2.php?option=$option&task=listrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit", _MBL_RECORD_NOT_FOUND_MOSMSG);
	}

	// get list of creators for dropdown list
	$database->setQuery( "SELECT id AS value, CONCAT(name, ' (', username, ')') AS text FROM #__users WHERE 1 ORDER BY name" );

	$authors[] =  JHTML::_('select.option',  '0', _MBL_SELECT_AUTHOR );
	$authors = array_merge($authors, (array)$database->loadObjectList());
	$lists['entered_by'] = JHTML::_('select.genericlist',  $authors, 'entered_by',
        'class="inputbox" size="1"', 'value', 'text', $entered_by );
	unset( $authors );

	// pass along configuration information
	$database->setQuery("SELECT * FROM #__madblanks_categories WHERE id='" . $row->configid. "' LIMIT 1");
	$configrow = $database->loadObjectList();
	$configrow = $configrow[0];

	$HTML_MadBlanks = new HTML_MadBlanks();
	$HTML_MadBlanks->htmlEditMadBlanksRecord($option, $row, $configrow, $configid, $lists, $categorylimit, $sortby, $sortascordesc, $authorlimit);
}

/**
 * Cancels an edit operation for an individual record
 *
 * @param string $option Joomla option string from URL
 */
function cancelEditMadBlanksRecord($option) {

        // $categorylimit, $sortby, $sortascordesc, and $authorlimit are simply passed through
	//  via hidden form fields to preserve the content of the filter and sort pulldown menu lists
	$categorylimit = JRequest::getVar('categorylimit');
        $authorlimit = JRequest::getVar('authorlimit');
	$sortby = JRequest::getVar('sortby');
	$sortascordesc = JRequest::getVar('sortascordesc');

        $database = &JFactory::getDBO(); 

        $row = new MadBlanksRecord($database);
        $row->bind( $_POST );
        $row->checkin();

        $app = &JFactory::getApplication();$app->redirect("index2.php?option=$option&task=listrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit");
}

/**
 * Copy an individual Mad Blanks Record
 *
 * @param string $option Joomla option string from URL
 * @param array $cid category id numbers to process (function only operates on the first one in the array)
 */
function copyMadBlanksRecord($option, $cid) {

	$database = &JFactory::getDBO(); 
	if (!is_array($cid) || count($cid) < 1 || !$cid[0]) {
		echo "<script> alert('" . sprintf(_MBL_MAKE_SELECTION, JString::strtolower(_MBL_COPY)) . "'); window.location.href='index2.php?option=$option&task=listrecords&mosmsg=" . sprintf(_MBL_MAKE_SELECTION, JString::strtolower(_MBL_COPY)) . "';</script>\n";
		exit();
	}

	$row = new MadBlanksRecord($database);

	if($cid[0]){
		$row -> load($cid[0]);
		$row->id = NULL;
		$row->published = 0; // copied configuration unpublished by default
		$row->date_entered = date("Y-m-d\ H:i:s");

	}
	else {
		echo "<script> alert('Unable to copy the configuration (no cid[0] passed to function)'); window.history.go(-1);</script>\n";
		exit();
	}

	// store it in the db
	if (!$row -> store()) {
		echo "<script> alert('"
			. addslashes($row -> getError())
			."'); window.history.go(-1); </script>\n";
		exit();
	}

	// $categorylimit, $sortby, $sortascordesc, and $authorlimit are simply passed through
	//  via hidden form fields to preserve the content of the filter and sort pulldown menu lists
	$categorylimit = JRequest::getVar('categorylimit');
        $authorlimit = JRequest::getVar('authorlimit');
	$sortby = JRequest::getVar('sortby');
	$sortascordesc = JRequest::getVar('sortascordesc');

	$app = &JFactory::getApplication();$app->redirect("index2.php?option=$option&task=listrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit", sprintf(_MBL_RECORD_COPY_MOSMSG, $cid[0], madblanks_mysql_insert_id($database->_resource)));

}

/**
 * Edit Mad Blanks Configuration file
 *
 * @param string $option Joomla option string from URL
 */
function editMadBlanksConfiguration($option) {

	$filename = rtrim(JPATH_SITE, ' /\\')
	. DS . 'administrator'.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php';
	if ($fp = fopen( $filename, "r" )) {
		$configuration_file = fread( $fp, filesize( $filename ) );
		$configuration_file = str_replace (array("<?php", "?>"), "", $configuration_file); //strip php tags
		$configuration_file = htmlspecialchars( $configuration_file );
		fclose ($fp);
		$configpermission = is_writable($filename);
	}
	else {
		$app = &JFactory::getApplication();$app->redirect( "index2.php?option=$option&mosmsg=" . sprintf(_MBL_CONFIG_OPEN_FAIL_MOSMSG, basename($filename)));
	}

	$HTML_MadBlanks = new HTML_MadBlanks();
	$HTML_MadBlanks->htmlEditMadBlanksConfiguration($option, $configuration_file, $configpermission);
}

/**
 * Save Mad Blanks Configuration file
 *
 * This routine stores configuration data from adminForm OR restores the default
 * configuration data, which is stored here in this function.
 *
 * @param string $option Joomla option string from URL
 * @param string $apply True if apply button was pushed instead of save button
 */
function saveMadBlanksConfiguration($option, $apply=0) {

	$usedefault = JRequest::getVar('resetdefault');

	$configfile = "../administrator/components/com_madblanks/madblanksconfig.php";
	$configpermission = is_writable($configfile);
	if (!$configpermission) {
		$app = &JFactory::getApplication();$app->redirect("index2.php?option=$option&mosmsg=" . _MBL_CONFIG_NOT_WRITABLE_MOSMSG);
	}
	else {
		if ($usedefault) {
			// Maintain default values here
			// Also remember to include them as the 3rd argument in the mosGetParam function calls below
			//  and in the configuration variable descriptions in the language file
			$configtxt = "/**
 * @package Mad_Blanks_Component
 * In single quoted strings, use \\' for an apostrophe and \\\\ for a backslash
 */
\$mbComponentTitle = 'Mad Blanks Component'; //" . strip_tags(_MBL_MBCOMPONENTTITLE) . "
\$mbFieldCount = 25; //" . strip_tags(_MBL_MBFIELDCOUNT) . "
\$mbColor1 = '#d3d3d3'; //" . strip_tags(_MBL_MBCOLOR1) . "
\$mbColor2 = '#add8e6'; //" . strip_tags(_MBL_MBCOLOR2) . "
\$mbEnteredByLongFormat = 0; //" . strip_tags(_MBL_MBENTEREDBYLONGFORMAT) . "
\$mbModifiedByLongFormat = 0; //" . strip_tags(_MBL_MBMODIFIEDBYLONGFORMAT) . "
\$mbAllowBlankRandomFields = 0; //" . strip_tags(_MBL_MBALLOWBLANKRANDOMFIELDS) . "
\$mbDefaultRecordsPerPage = 15; //" . strip_tags(_MBL_MBDEFAULTRECORDSPERPAGE) . "
\$mbDisplayResultNumbering = 0; //" . strip_tags(_MBL_MBDISPLAYRESULTNUMBERING) . "
\$mbFrontendPageNavAlwaysOn = 0; //" . strip_tags(_MBL_MBFRONTENDPAGENAVALWAYSON) . "
\$mbFeaturedRecords = ''; //" . strip_tags(_MBL_MBFEATUREDRECORDS) . "
\$mbPreviewBeforeSave = 1; //" . strip_tags(_MBL_MBPREVIEWBEFORESAVE) . "
\$mbDefaultNumColumns = 1; //" . strip_tags(_MBL_MBDEFAULTNUMCOLUMNS) . "
\$mbDefaultTextareaHeight = 3; //" . strip_tags(_MBL_MBDEFAULTTEXTAREAHEIGHT) . "
\$mbDefaultTextareaWidth = 45; //" . strip_tags(_MBL_MBDEFAULTTEXTAREAWIDTH) . "
\$mbShowDisplayingWhatTitle = 1; //" . strip_tags(_MBL_MBSHOWDISPLAYINGWHATTITLE) . "
\$mbShowHTMLTitleTagData = 2; //" . strip_tags(_MBL_MBSHOWHTMLTITLETAGDATA) . "
\$mbCustomTitleText = ''; //" . strip_tags(_MBL_MBCUSTOMTITLETEXT) . "
\$mbFrontendInputFieldSize = 35; //" . strip_tags(_MBL_MBFRONTENDINPUTFIELDSIZE) . "
\$mbShowFooterComponentHomeLink = 1; //" . strip_tags(_MBL_MBSHOWFOOTERCOMPONENTHOMELINK) . "
\$mbApplyContentPlugins = 0; //" . strip_tags(_MBL_MBAPPLYCONTENTPLUGINS) . "
\$mbHideCheckedOut = 0; //" . strip_tags(_MBL_MBHIDECHECKEDOUT) . "
\$mbWordWrapWidth = 75; //" . strip_tags(_MBL_MBWORDWRAPWIDTH) . "
\$mbEnableMainScreen = 1; //" . strip_tags(_MBL_MBENABLEMAINSCREEN) . "
\$mbEnableCreateSingleRecordLinks = 1; //" . strip_tags(_MBL_MBENABLECREATESINGLERECORDLINKS) . "
\$mbCreateSingleRecordPosition = 'madblanks'; //" . strip_tags(_MBL_MBCREATESINGLERECORDPOSITION) . "
\$mbEnableShowAllLink = 1; //" . strip_tags(_MBL_MBENABLESHOWALLLINK) . "
\$mbEnableCategoriesLinks = 1; //" . strip_tags(_MBL_MBENABLECATEGORIESLINKS) . "
\$mbEnableRandomizerLinks = 1; //" . strip_tags(_MBL_MBENABLERANDOMIZERLINKS) . "
\$mbEnableSpecificRecordBox = 1; //" . strip_tags(_MBL_MBENABLESPECIFICRECORDBOX) . "
\$mbEnableEditRecordsLink = 1; //" . strip_tags(_MBL_MBENABLEEDITRECORDSLINK) . "
\$mbEditThreshold = 1; //" . strip_tags(_MBL_MBEDITTHRESHOLD) . "
\$mbEnableRecordListShowAll = 1; //" . strip_tags(_MBL_MBENABLERECORDLISTSHOWALL) . "
\$mbStartPage = ''; //" . strip_tags(_MBL_MBSTARTPAGE) . "
\$mbModuleWithinComponentStyle = ''; //" . strip_tags(_MBL_MBMODULEWITHINCOMPONENTSTYLE) . "
\$mbModuleWithinComponentChrome = '-2'; /* " . strip_tags(_MBL_MBMODULEWITHINCOMPONENTCHROME) . "*/
\$mbModuleWithinComponentTypes = 'mod_madblanks_createsinglerecord,mod_madblanks_singlefieldinput,mod_madblanks_display,mod_madblanks_menu'; //" . strip_tags(_MBL_MBMODULEWITHINCOMPONENTTYPES) . "
\$mbDefaultSeparator1 = ',[:space:]'; //" . strip_tags(_MBL_MBDEFAULTSEPARATOR1) . "
\$mbDefaultSeparator2 = '[:space:]and[:space:]'; //" . strip_tags(_MBL_MBDEFAULTSEPARATOR2) . "
\$mbDefaultSSEmailFrom = ''; //" . strip_tags(_MBL_MBDEFAULTSSEMAILFROM) . "
\$mbDefaultSSEmailTo = ''; //" . strip_tags(_MBL_MBDEFAULTSSEMAILTO) . "
\$mbDefaultSSEmailSubject = 'Mad Blanks Score Script'; //" . strip_tags(_MBL_MBDEFAULTSSEMAILSUBJECT) . "
\$mbDefaultSSEmailBody = ''; //" . strip_tags(_MBL_MBDEFAULTSSEMAILBODY) . "
\$mbDefaultSSEmailMode = '0'; //" . strip_tags(_MBL_MBDEFAULTSSEMAILMODE) . "
\$mbDefaultSSEmailCC = ''; //" . strip_tags(_MBL_MBDEFAULTSSEMAILCC) . "
\$mbDefaultSSEmailBCC = ''; //" . strip_tags(_MBL_MBDEFAULTSSEMAILBCC) . "
\$mbDefaultSSEmailAttachment = ''; //" . strip_tags(_MBL_MBDEFAULTSSEMAILATTACHMENT) . "
\$mbDefaultSSEmailReplyTo = ''; //" . strip_tags(_MBL_MBDEFAULTSSEMAILREPLYTO) . "
\$mbDefaultSSEmailSuccess = ''; //" . strip_tags(_MBL_MBDEFAULTSSEMAILSUCCESS) . "
\$mbDefaultSSEmailFailure = ''; //" . strip_tags(_MBL_MBDEFAULTSSEMAILFAILURE) . "
\$mbDefaultSSDateFormat = ''; //" . strip_tags(_MBL_MBDEFAULTSSDATEFORMAT) . "
\$mbDefaultSSDateAdjustment = ''; //" . strip_tags(_MBL_MBDEFAULTSSDATEADJUSTMENT) . "
\$mbAcceptGoogleChartTOS = 'NO'; /* " . strip_tags(_MBL_MBACCEPTGOOGLECHARTTOS) . "*/
\$mbTimeoutDataTimeToLive = '2 hours'; //" . strip_tags(_MBL_MBTIMEOUTDATATIMETOLIVE) . "
\$mbAdminRecordEditRawOrForm = 1; //" . strip_tags(_MBL_MBADMINRECORDEDITRAWORFORM) . "
\$mbEnableMaxPostOrRequestVarsWarning = 1; //" . strip_tags(_MBL_MBENABLEMAXPOSTORREQUESTVARSWARNING) . "
\$mbIncludeCustomizationFile = 0; //" . strip_tags(_MBL_MBINCLUDECUSTOMIZATIONFILE) . "
";
		}

		else {
			// validate the data here or below
			$mbShowHTMLTitleTagData = JRequest::getVar('mbShowHTMLTitleTagData', 2);
			if ($mbShowHTMLTitleTagData > 1) {
				$mbShowHTMLTitleTagData = 2;
			}
			else if ($mbShowHTMLTitleTagData < 1) {
				$mbShowHTMLTitleTagData = 0;
			}
			else {
				$mbShowHTMLTitleTagData = 1;
			}
			$mbFieldCount = JRequest::getVar('mbFieldCount', 25);
			if ($mbFieldCount < 1) {
				$mbFieldCount = 1;
			}
			$mbDefaultRecordsPerPage = JRequest::getVar('mbDefaultRecordsPerPage', 15);
			if ($mbDefaultRecordsPerPage < 1) {
				$mbDefaultRecordsPerPage = 1;
			}
			$configtxt = "/**\n * @package Mad_Blanks_Component\n * In single quoted strings, use \\' for an apostrophe and \\\\ for a backslash\n */\n";

			$configtxt .= '$mbComponentTitle = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbComponentTitle', 'Default Component Title')) . "'; //" . strip_tags(_MBL_MBCOMPONENTTITLE) . "\n";
			$configtxt .= '$mbFieldCount = ' . (int) $mbFieldCount . "; //" . strip_tags(_MBL_MBFIELDCOUNT) . "\n";
			$configtxt .= '$mbColor1 = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbColor1', '#d3d3d3')) . "'; //" . strip_tags(_MBL_MBCOLOR1) . "\n";
			$configtxt .= '$mbColor2 = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbColor2', '#add8e6')) . "'; //" . strip_tags(_MBL_MBCOLOR2) . "\n";
			$configtxt .= '$mbEnteredByLongFormat = ' . (int) (JRequest::getVar('mbEnteredByLongFormat', 0) ? 1 : 0) . "; //" . strip_tags(_MBL_MBENTEREDBYLONGFORMAT) . "\n";

			$configtxt .= '$mbModifiedByLongFormat = ' . (int) (JRequest::getVar('mbModifiedByLongFormat', 0) ? 1 : 0)  . "; //" . strip_tags(_MBL_MBMODIFIEDBYLONGFORMAT) . "\n";
			$configtxt .= '$mbAllowBlankRandomFields = ' . (int) (JRequest::getVar('mbAllowBlankRandomFields', 0) ? 1 : 0) . "; //" . strip_tags(_MBL_MBALLOWBLANKRANDOMFIELDS) . "\n";
			$configtxt .= '$mbDefaultRecordsPerPage = ' . (int) $mbDefaultRecordsPerPage . "; //" . strip_tags(_MBL_MBDEFAULTRECORDSPERPAGE) . "\n";
			$configtxt .= '$mbDisplayResultNumbering = ' . (int) (JRequest::getVar('mbDisplayResultNumbering', 0) ? 1 : 0) . "; //" . strip_tags(_MBL_MBDISPLAYRESULTNUMBERING) . "\n";
			$configtxt .= '$mbFrontendPageNavAlwaysOn = ' . (int) (JRequest::getVar('mbFrontendPageNavAlwaysOn', 0) ? 1 : 0) . "; //" . strip_tags(_MBL_MBFRONTENDPAGENAVALWAYSON) . "\n";

			$configtxt .= '$mbFeaturedRecords = \'' . (string) preg_replace('/\D/',',',JRequest::getVar('mbFeaturedRecords', '')) . "'; //" . strip_tags(_MBL_MBFEATUREDRECORDS) . "\n"; // replace anything that is not a decimal digit with a comma
			$configtxt .= '$mbPreviewBeforeSave = ' . (int) (JRequest::getVar('mbPreviewBeforeSave', 1) ?  1 : 0)  . "; //" . strip_tags(_MBL_MBPREVIEWBEFORESAVE) . "\n"; // 1 or 0
			
			$configtxt .= '$mbDefaultNumColumns = ' . (int) JRequest::getVar('mbDefaultNumColumns', 1) . "; //" . strip_tags(_MBL_MBDEFAULTNUMCOLUMNS) . "\n";
			
			$configtxt .= '$mbDefaultTextareaHeight = ' . (int) JRequest::getVar('mbDefaultTextareaHeight', 3) . "; //" . strip_tags(_MBL_MBDEFAULTTEXTAREAHEIGHT) . "\n";
			$configtxt .= '$mbDefaultTextareaWidth = ' . (int) JRequest::getVar('mbDefaultTextareaWidth', 45) . "; //" . strip_tags(_MBL_MBDEFAULTTEXTAREAWIDTH) . "\n";
			$configtxt .= '$mbShowDisplayingWhatTitle = ' . (int) (JRequest::getVar('mbShowDisplayingWhatTitle', 1) ? 1 : 0) . "; //" . strip_tags(_MBL_MBSHOWDISPLAYINGWHATTITLE) . "\n";

			$configtxt .= '$mbShowHTMLTitleTagData = ' . (int) $mbShowHTMLTitleTagData . "; //" . strip_tags(_MBL_MBSHOWHTMLTITLETAGDATA) . "\n";
			$configtxt .= '$mbCustomTitleText = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbCustomTitleText', '', 'default', 'none', JREQUEST_ALLOWHTML)) . "'; //" . strip_tags(_MBL_MBCUSTOMTITLETEXT) . "\n";
			$configtxt .= '$mbFrontendInputFieldSize = ' . (string) mblconfig_addslashes(JRequest::getVar('mbFrontendInputFieldSize', 35)) . "; //" . strip_tags(_MBL_MBFRONTENDINPUTFIELDSIZE) . "\n";
			$configtxt .= '$mbShowFooterComponentHomeLink = ' . (int) JRequest::getVar('mbShowFooterComponentHomeLink', 1) . "; //" . strip_tags(_MBL_MBSHOWFOOTERCOMPONENTHOMELINK) . "\n";
			$configtxt .= '$mbApplyContentPlugins = ' . (int) JRequest::getVar('mbApplyContentPlugins', 0) . "; //" . strip_tags(_MBL_MBAPPLYCONTENTPLUGINS) . "\n";

			$configtxt .= '$mbHideCheckedOut = ' . (int) JRequest::getVar('mbHideCheckedOut', 0) . "; //" . strip_tags(_MBL_MBHIDECHECKEDOUT) . "\n";
			$configtxt .= '$mbWordWrapWidth = ' . (int) JRequest::getVar('mbWordWrapWidth', 75) . "; //" . strip_tags(_MBL_MBWORDWRAPWIDTH) . "\n";
			$configtxt .= '$mbEnableMainScreen = ' . (int) JRequest::getVar('mbEnableMainScreen', 1) . "; //" . strip_tags(_MBL_MBENABLEMAINSCREEN) . "\n";
			$configtxt .= '$mbEnableCreateSingleRecordLinks = ' . (int) JRequest::getVar('mbEnableCreateSingleRecordLinks', 1) . "; //" . strip_tags(_MBL_MBENABLECREATESINGLERECORDLINKS) . "\n";
			$configtxt .= '$mbCreateSingleRecordPosition = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbCreateSingleRecordPosition', 'madblanks')) . "'; //" . strip_tags(_MBL_MBCREATESINGLERECORDPOSITION) . "\n";
			
			$configtxt .= '$mbEnableShowAllLink = ' . (int) JRequest::getVar('mbEnableShowAllLink', 1) . "; //" . strip_tags(_MBL_MBENABLESHOWALLLINK) . "\n";
			$configtxt .= '$mbEnableCategoriesLinks = ' . (int) JRequest::getVar('mbEnableCategoriesLinks', 1) . "; //" . strip_tags(_MBL_MBENABLECATEGORIESLINKS) . "\n";
			$configtxt .= '$mbEnableRandomizerLinks = ' . (int) JRequest::getVar('mbEnableRandomizerLinks', 1) . "; //" . strip_tags(_MBL_MBENABLERANDOMIZERLINKS) . "\n";
			$configtxt .= '$mbEnableSpecificRecordBox = ' . (int) JRequest::getVar('mbEnableSpecificRecordBox', 1) . "; //" . strip_tags(_MBL_MBENABLESPECIFICRECORDBOX) . "\n";
			$configtxt .= '$mbEnableEditRecordsLink = ' . (int) JRequest::getVar('mbEnableEditRecordsLink', 1) . "; //" . strip_tags(_MBL_MBENABLEEDITRECORDSLINK) . "\n";

			$configtxt .= '$mbEditThreshold = ' . (int) JRequest::getVar('mbEditThreshold', 1) . "; //" . strip_tags(_MBL_MBEDITTHRESHOLD) . "\n";
			$configtxt .= '$mbEnableRecordListShowAll = ' . (int) JRequest::getVar('mbEnableRecordListShowAll', 1) . "; //" . strip_tags(_MBL_MBENABLERECORDLISTSHOWALL) . "\n";
			$configtxt .= '$mbStartPage = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbStartPage', '')) . "'; //" . strip_tags(_MBL_MBSTARTPAGE) . "\n";
			$configtxt .= '$mbModuleWithinComponentStyle = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbModuleWithinComponentStyle', '')) . "'; //" . strip_tags(_MBL_MBMODULEWITHINCOMPONENTSTYLE) . "\n";
			$configtxt .= '$mbModuleWithinComponentChrome = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbModuleWithinComponentChrome', '-2')) . "'; /* " . strip_tags(_MBL_MBMODULEWITHINCOMPONENTCHROME) . "*/\n";

			$configtxt .= '$mbModuleWithinComponentTypes = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbModuleWithinComponentTypes', 'mod_madblanks_createsinglerecord,mod_madblanks_singlefieldinput,mod_madblanks_display,mod_madblanks_menu')) . "'; //" . strip_tags(_MBL_MBMODULEWITHINCOMPONENTTYPES) . "\n";
			$configtxt .= '$mbDefaultSeparator1 = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbDefaultSeparator1', ',[:space:]')) . "'; //" . strip_tags(_MBL_MBDEFAULTSEPARATOR1) . "\n";
			$configtxt .= '$mbDefaultSeparator2 = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbDefaultSeparator2', '[:space:]and[:space:]')) . "'; //" . strip_tags(_MBL_MBDEFAULTSEPARATOR2) . "\n";
			$configtxt .= '$mbDefaultSSEmailFrom = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbDefaultSSEmailFrom', '')) . "'; //" . strip_tags(_MBL_MBDEFAULTSSEMAILFROM) . "\n";
			$configtxt .= '$mbDefaultSSEmailTo = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbDefaultSSEmailTo', '')) . "'; //" . strip_tags(_MBL_MBDEFAULTSSEMAILTO) . "\n";

			$configtxt .= '$mbDefaultSSEmailSubject = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbDefaultSSEmailSubject', 'Mad Blanks Score Script')) . "'; //" . strip_tags(_MBL_MBDEFAULTSSEMAILSUBJECT) . "\n";
			$configtxt .= '$mbDefaultSSEmailBody = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbDefaultSSEmailBody', '')) . "'; //" . strip_tags(_MBL_MBDEFAULTSSEMAILBODY) . "\n";

			// $mbDefaultSSEmailMode is a quoted string and not an int because field can contain special tags that would be found in a Score Script and resolve to the desired content
			$configtxt .= '$mbDefaultSSEmailMode = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbDefaultSSEmailMode', '0')) . "'; //" . strip_tags(_MBL_MBDEFAULTSSEMAILMODE) . "\n";

			$configtxt .= '$mbDefaultSSEmailCC = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbDefaultSSEmailCC', '')) . "'; //" . strip_tags(_MBL_MBDEFAULTSSEMAILCC) . "\n";
			$configtxt .= '$mbDefaultSSEmailBCC = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbDefaultSSEmailBCC', '')) . "'; //" . strip_tags(_MBL_MBDEFAULTSSEMAILBCC) . "\n";

			$configtxt .= '$mbDefaultSSEmailAttachment = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbDefaultSSEmailAttachment', '')) . "'; //" . strip_tags(_MBL_MBDEFAULTSSEMAILATTACHMENT) . "\n";
			$configtxt .= '$mbDefaultSSEmailReplyTo = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbDefaultSSEmailReplyTo', '')) . "'; //" . strip_tags(_MBL_MBDEFAULTSSEMAILREPLYTO) . "\n";
			$configtxt .= '$mbDefaultSSEmailSuccess = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbDefaultSSEmailSuccess', '')) . "'; //" . strip_tags(_MBL_MBDEFAULTSSEMAILSUCCESS) . "\n";
			$configtxt .= '$mbDefaultSSEmailFailure = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbDefaultSSEmailFailure', '')) . "'; //" . strip_tags(_MBL_MBDEFAULTSSEMAILFAILURE) . "\n";
			$configtxt .= '$mbDefaultSSDateFormat = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbDefaultSSDateFormat', '')) . "'; //" . strip_tags(_MBL_MBDEFAULTSSDATEFORMAT) . "\n";

			$configtxt .= '$mbDefaultSSDateAdjustment = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbDefaultSSDateAdjustment', '')) . "'; //" . strip_tags(_MBL_MBDEFAULTSSDATEADJUSTMENT) . "\n";

			$configtxt .= '$mbAcceptGoogleChartTOS = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbAcceptGoogleChartTOS', 'NO')) . "'; /*" . strip_tags(_MBL_MBACCEPTGOOGLECHARTTOS) . "*/\n";
			$configtxt .= '$mbTimeoutDataTimeToLive = \'' . (string) mblconfig_addslashes(JRequest::getVar('mbTimeoutDataTimeToLive', '2 hours')) . "'; //" . strip_tags(_MBL_MBTIMEOUTDATATIMETOLIVE) . "\n";
			
			$configtxt .= '$mbAdminRecordEditRawOrForm = ' . (int) mblconfig_addslashes(JRequest::getVar('mbAdminRecordEditRawOrForm', 1)) . "; //" . strip_tags(_MBL_MBADMINRECORDEDITRAWORFORM) . "\n";
			$configtxt .= '$mbEnableMaxPostOrRequestVarsWarning = ' . (int) mblconfig_addslashes(JRequest::getVar('mbEnableMaxPostOrRequestVarsWarning', 1)) . "; //" . strip_tags(_MBL_MBENABLEMAXPOSTORREQUESTVARSWARNING) . "\n";
			$configtxt .= '$mbIncludeCustomizationFile = ' . (int) mblconfig_addslashes(JRequest::getVar('mbIncludeCustomizationFile', 0)) . "; //" . strip_tags(_MBL_MBINCLUDECUSTOMIZATIONFILE) . "\n";
			
		}

		if ($fp = fopen("$configfile", "w+")) {
			fputs($fp, "<?php\n");
			fputs($fp, $configtxt, JString::strlen($configtxt));
			fputs($fp, "\n?>\n");
			fclose ($fp);
			$app = &JFactory::getApplication();$app->redirect("index2.php?option=$option" . ($apply ? "&task=editconfiguration" : "") . "&mosmsg=" . _MBL_CONFIG_SAVED_MOSMSG);
		}
		else {
			$app = &JFactory::getApplication();$app->redirect("index2.php?option=$option" . ($apply ? "&task=editconfiguration" : "") . "&mosmsg=" . _MBL_CONFIG_NOT_SAVED_MOSMSG);
		}
	}
}

/**
 * Alter the order of the categories
 *
 * @param integer $uid category id number to process
 * @param integer $inc the increment to reorder by
 * @param string $option Joomla option string from URL
 */
function orderMadBlanksCategories($uid, $inc, $option) {
        $database = &JFactory::getDBO(); 

	$row = new MadBlanksCategory($database);
        $row->load((int)$uid);
        $row->reorder();
        $row->move($inc, "published >= 0");
        $row->reorder();

	$app = &JFactory::getApplication();$app->redirect("index2.php?option=$option&task=listcategories");
}

/**
 * Displays configuration data for currently published categories
 * Use index.php in the frontend to display alone (i.e. without modules)
 */
function showReferenceWindow($published=1) {
	global $access;
	$database = &JFactory::getDBO();
	
	$database->setQuery("SELECT * FROM #__madblanks_categories WHERE " . ($published ? "published > 0" : "published = 0") . " ORDER BY id ASC");
	$rows = $database->loadObjectList();
	if (empty($rows) && $published) {
		$message = _MBL_NO_PUBLISHED_CATEGORIES_TO_DISPLAY;
	}
	else if (empty($rows) && !$published) {
		$message = _MBL_NO_UNPUBLISHED_CATEGORIES_TO_DISPLAY;
	}
	else {
		$message = '';
	}	
	
	$HTML_MadBlanks = new HTML_MadBlanks();
	$HTML_MadBlanks->htmlShowReferenceWindow($rows, $message);
}



/**
 * Apply Mad Blanks ScoreScript
 *
 * after the scorescript record has been passed to the server via a form on the edit page, save and return to edit page
 *
 * @global integer if set, prevents the edit scorescript function from being called
 * @param string $option Joomla option string from URL
 */
function applyMadBlanksScoreScript($option) {
	global $apply_editoverride;
	$apply_editoverride = 0;
	$uid = JRequest::getInt('id', 0);
	//$message = saveMadBlanksScoreScript($option, 1);
	$newid = saveMadBlanksScoreScript($option, 1);
		if (empty($uid)) {
			$uid = $newid;
		}	
	$message = sprintf(_MBL_SAVE_SCORESCRIPT_MOSMSG, $newid);
	if (!$apply_editoverride) {
		$_REQUEST['hidemainmenu'] = 1; // Hide the main menu when editing after applying new data
		editMadBlanksScoreScript($option, array($uid), null, $message);
	}
}

/**
 * Save Mad Blanks ScoreScript
 *
 * after the scorescript record has been passed to the server via a form on the edit page
 *
 * @param string $option Joomla option string from URL
 * @param integer $noredirect, when set (as in the applyMadBlanksScoreScript function),
 * prevents going to the record list, which would normally happen
 * @global integer number of data fields present in the database
 * @global integer if set, prevents the edit scorescript function
 * from being called in the applyMadBlanksScoreScript function; this keeps us from
 * showing the edit screen twice when using apply during validation
 */
function saveMadBlanksScoreScript($option, $noredirect=0) {

	foreach($_POST as $thekey => $theitem) {
		if ($thekey != 'scorescript') { // Clean posted variables for security; but we need to retain html in 'scorescript'
			$_POST[$thekey] = get_magic_quotes_gpc() ? htmlspecialchars(stripslashes($_POST[$thekey])) : htmlspecialchars($_POST[$thekey]);
		}
		else if ($thekey == 'scorescript' && get_magic_quotes_gpc() && class_exists('JConfig')) {
			$_POST[$thekey] = stripslashes($_POST[$thekey]); // needed for Joomla 1.5 only
		}
	}

//	global $mbFieldCount, $apply_editoverride;
//
//	for ($i=1; $i <= $mbFieldCount; $i++) {
//		$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
//		$configarray = array('index' => $theindex, 'usetextarea' => mosGetParam($_REQUEST, 'usetextarea_' . $theindex), 'textareawidth' => mosGetParam($_REQUEST, 'textareawidth_' . $theindex), 'textareaheight' => mosGetParam($_REQUEST, 'textareaheight_' . $theindex), 'strtoupper' => mosGetParam($_REQUEST, 'strtoupper_' . $theindex), 'strtolower' => mosGetParam($_REQUEST, 'strtolower_' . $theindex), 'ucwords' => mosGetParam($_REQUEST, 'ucwords_' . $theindex), 'ucfirst' => mosGetParam($_REQUEST, 'ucfirst_' . $theindex), 'usemultchoice' => mosGetParam($_REQUEST, 'usemultchoice_' . $theindex), 'multchoice' => convertMBLiteralToEscaped(mosGetParam($_REQUEST, 'multchoice_' . $theindex)), 'multdefault' => convertMBLiteralToEscaped(mosGetParam($_REQUEST, 'multdefault_' . $theindex)), 'multcorrect' => convertMBLiteralToEscaped(mosGetParam($_REQUEST, 'multcorrect_' . $theindex)));
//		$_POST['data_' . $theindex . '_config'] = makeDataConfigString(JRequest::getVar('id'), $i, $configarray);
//	}

	$database = &JFactory::getDBO(); 
	$row = new MadBlanksScoreScript($database);

	// bind it to the table
	if (!$row -> bind($_POST)) {
		echo "<script> alert('"
			. addslashes($row -> getError())
			."'); window.history.go(-1); </script>\n";
		exit();
	}

	//$validate_message = '';
	//$validate_error_field_list = array();
	//for ($i = 1; $i <= $mbFieldCount; $i++) {
	//	$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
	//	if ($row->{'data_' . $theindex . '_use'} && !$row->{'data_' . $theindex . '_name'}) {
	//		$validate_message .= sprintf(_MBL_CATEGORY_VALIDATION_ERROR, $i);//'Found empty name field on activated index; please fill in the value: ' . $theindex . '<br />';
	//		$validate_error_field_list[$theindex] = true;
	//	}
	//}

	//if ($validate_message) {
	//	$_REQUEST['hidemainmenu'] = 1; // Hide the main menu when reediting after discovering a validation error
	//	editMadBlanksScoreScript($option, array($row->id), $row, $validate_message, $validate_error_field_list);
	//	$apply_editoverride = 1;
	//	return;
	//}

	if (!$row->ordering) {
		$database->setQuery("SELECT MAX(ordering) + 1 from #__madblanks_scorescripts WHERE 1");
		$row->ordering = intval($database->loadResult());
	}

	// store it in the db
	if (!$row -> store()) {
		echo "store error!<br />";
		echo "<script> alert('"
			. addslashes($row -> getError())
			."'); window.history.go(-1); </script>\n";
		exit();
	}

	// for the "Apply" case
	if ($noredirect) {
		//return sprintf(_MBL_SAVE_CATEGORY_MOSMSG, $row->id);
		return $row->id;
	}
	else {
		$row->checkin();
		$app = &JFactory::getApplication();$app->redirect("index2.php?option=$option&task=listscorescripts&justsaved=$row->id", sprintf(_MBL_SAVE_SCORESCRIPT_MOSMSG, $row->id));
	}
}

/**
 * Edit Mad Blanks ScoreScript
 *
 * pass the scorescript record to the edit form
 *
 * @param string $option Joomla option string from URL
 * @param array $uid scorescript id numbers to process (function only operates on the first one in the array)
 * @param object $validate_row this is used to "try again" in cases when a save has been attempted but the form did not validate
 * @param string $message optional message to show at the top of the edit screen (equivalent to mosmsg)
 * @param array $validate_error_field_list an array whose keys correspond to field numbers with validation errors
 */
function editMadBlanksScoreScript($option, $uid, $validate_row=null, $message=null, $validate_error_field_list=null) {

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();


	$row = new MadBlanksScoreScript($database);

	if ($validate_row) {
		$row = $validate_row;
	}

	else if (!empty($uid[0])) {
		$row -> load($uid[0]);
	}

	$database->setQuery( "SELECT count(*) FROM #__madblanks_records where configid = " . $row->id . " AND published = 1");
	$numberpublished = $database->loadResult() ? $database->loadResult() : 0;
	$database->setQuery( "SELECT count(*) FROM #__madblanks_records where configid = " . $row->id . " AND approved > 0");
	$numberapproved = $database->loadResult() ? $database->loadResult() : 0;
	$database->setQuery( "SELECT count(*) FROM #__madblanks_records where configid = " . $row->id . " AND completed > 0");
	$numbercompleted = $database->loadResult() ? $database->loadResult() : 0;
	$database->setQuery( "SELECT count(*) FROM #__madblanks_records where configid = " . $row->id);
	$numbertotal = $database->loadResult() ? $database->loadResult() : 0;
	$database->setQuery( "SELECT count(*) FROM #__madblanks_records where configid = " . $row->id . " AND completed > 0 AND approved > 0 AND published > 0");
	$numberdisplayed = $database->loadResult() ? $database->loadResult() : 0;

	// build the html select list for ordering
	$query = "SELECT ordering AS value, name AS text"
	. "\n FROM #__madblanks_scorescripts"
	. "\n ORDER BY ordering"
	;
	
	//$mosAdminMenus = new mosAdminMenus();
	//$lists['ordering'] = $mosAdminMenus->SpecificOrdering( $row, $uid, $query );
	$lists['ordering'] = JHTML::_('list.specificordering', $row, $uid, $query);

	// fail if checked out not by current user
	//(we should usually never get here because the checkbox and link to edit this record should not have been available)
	if ($row->checked_out && $row->checked_out != $my->id) {
		$app = &JFactory::getApplication();$app->redirect( "index2.php?option=$option&task=listscorescripts", sprintf(_MBL_CHECKED_OUT_ERROR, _MBL_CATEGORY_NAME, $row->name, getUserNameByID($row->checked_out, 1) . ' [' . getUserNameByID($row->checked_out, 0) . ']' ));
	}

	$row->checkout( $my->id );

	$HTML_MadBlanks = new HTML_MadBlanks();
	$HTML_MadBlanks->htmlEditMadBlanksScoreScript($option, $row, $lists, $numbercompleted, $numberapproved, $numberpublished, $numbertotal, $numberdisplayed, $message, $validate_error_field_list);
}

/**
 * Cancels an edit operation
 *
 * @param string $option Joomla option string from URL
 */
function cancelEditMadBlanksScoreScript($option) {
        $database = &JFactory::getDBO(); 

        $row = new MadBlanksScoreScript($database);
        $row->bind( $_POST );
        $row->checkin();

        $app = &JFactory::getApplication();$app->redirect("index2.php?option=$option&task=listscorescripts");
}



/**
 * Copy Mad Blanks ScoreScript
 *
 * @param string $option Joomla option string from URL
 * @param array $cid scorescript id numbers to process (function only operates on the first one in the array)
 */
function copyMadBlanksScoreScript($option, $cid) {



	$database = &JFactory::getDBO(); 
	if (!is_array($cid) || count($cid) < 1 || !$cid[0]) {
		echo "<script> alert('" . sprintf(_MBL_MAKE_SELECTION, JString::strtolower(_MBL_COPY)) . "'); window.location.href='index2.php?option=$option&task=listscorescripts&mosmsg=" . sprintf(_MBL_MAKE_SELECTION, JString::strtolower(_MBL_COPY)) . "';</script>\n";
		exit();
	}

	$row = new MadBlanksScoreScript($database);

	if($cid[0]){
		$row -> load($cid[0]);
		$row->id = NULL;
		$row->published = 0; // copied configuration unpublished by default
		$row->name = _MBL_COPY_OF . ' ' . $row->name;
		$row->date_created = date("Y-m-d\ H:i:s");

	}
	else {
		echo "<script> alert('Unable to copy the configuration (no cid[0] passed to function)'); window.history.go(-1);</script>\n";
		exit();
	}

	// store it in the db
	if (!$row -> store()) {
		echo "<script> alert('"
			. addslashes($row -> getError())
			."'); window.history.go(-1); </script>\n";
		exit();
	}

	$app = &JFactory::getApplication();$app->redirect("index2.php?option=$option&task=listscorescripts", sprintf(_MBL_SCORESCRIPT_COPY_MOSMSG, $cid[0], madblanks_mysql_insert_id($database->_resource)));

}



/**
 * Delete Mad Blanks ScoreScripts
 *
 * @param string $option Joomla option string from URL
 * @param array $cid scorescript id numbers to process (function operates on ALL scorescripts given in the array)
 */
function deleteMadBlanksScoreScripts($option, $cid) {
	$database = &JFactory::getDBO(); 
	if (!is_array($cid) || count($cid) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit();
	}

	if (count($cid))
	{
		foreach ($cid as $item) {
			$database->setQuery("SELECT COUNT(*) FROM #__madblanks_records WHERE configid = '$item'");
			$thecount = $database->loadResult();
			if ($thecount) {
				echo "<script> if(confirm('The database for scorescript $item has $thecount records. '"
				. "\n + 'Confirm deletion or cancel.')){} else { window.history.go(-1) }; </script>\n";
			}
		}


		$ids = implode(',', $cid);
		$database->setQuery("DELETE FROM #__madblanks_scorescripts \nWHERE id IN ($ids)");
	}

	if (!$database->query()) {
		echo "<script> alert('"
			.$database -> getErrorMsg()
			."'); window.history.go(-1); </script>\n";
	}
	$app = &JFactory::getApplication();$app->redirect("index2.php?option=$option&task=listscorescripts", $cid[1] ? sprintf(_MBL_SCORESCRIPT_DELETE_PLURAL_MOSMSG, implode(", ", $cid)) : sprintf(_MBL_SCORESCRIPT_DELETE_SINGULAR_MOSMSG, $cid[0]));
}

/**
 * List Mad Blanks ScoreScripts
 *
 * @param string $option Joomla option string from URL
 * @param array $task component task string from URL
 */
function listMadBlanksScoreScripts($option, $task) {
	//global $mainframe;
	$database = &JFactory::getDBO();
	$app = &JFactory::getApplication();
	
	// passed from the dropdown menu to select awards for only a particular member
	//$matchtypelimit = JRequest::getInt('matchtypelimit', 0);
	//$limit = $mainframe->getUserStateFromRequest('viewlistlimit', 'limit', $app->getCfg('list_limit'));
	//$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	$limit = $app->getUserStateFromRequest("$option.scorescripts.limit", 'limit', $app->getCfg('list_limit'));
	$limitstart = $app->getUserStateFromRequest( "$option.scorescripts.limitstart", 'limitstart', 0 );
	//echo "<h1>limit is $limit and limitstart is $limitstart</h1>";	

	// get the total number of records
	$thequery = "SELECT count(*) FROM #__madblanks_scorescripts";
	//if ($matchtypelimit) {
	//	$thequery .= " WHERE type='$matchtypelimit'";
	//}
	$database->setQuery($thequery);
	$total = $database->loadResult();
	//require_once( JPATH_SITE . '/administrator/includes/pageNavigation.php' );
	//$pageNav = new mosPageNav( $total, $limitstart, $limit );
	
	// In case limit has been changed, adjust it
        if ($limitstart > $total) {
        	$limitstart = 0;
        }

	// 1.4.0 RC1 20100729 Position the pagination to display the page that lists the saved category
	$justsaved = JRequest::getVar('justsaved', 0); 
	// now determine what ordering this record number is in the list when sorted by the 'ordering' field ASC
	if ($justsaved && $limit > 0) {

		$thequery = "SELECT id FROM #__madblanks_scorescripts ORDER BY ordering ASC";
		$database->setQuery($thequery);
		$rows_for_ordering = $database->loadObjectList();

		$ordering_in_list = 0; // initialize
		foreach ($rows_for_ordering as $rowindex => $rowcontent) {
			if ($rowcontent->id == $justsaved) {
				$ordering_in_list = $rowindex;
				break;
			}

		}
		//echo "<pre>"; print_r($rows_for_ordering); echo "</pre>\n";
		//echo "<h1>ordering_in_list for $justsaved is $ordering_in_list</h1>";

		// calculate the appropriate $limitstart
		$limitstart = floor($ordering_in_list / $limit) * $limit;
		//echo "<h1>new limitstart is $limitstart</h1>";
	}

	$app->setUserState("$option.scorescripts.limit", $limit);
	$app->setUserState( "$option.scorescripts.limitstart", $limitstart);

	jimport('joomla.html.pagination');
	if (version_compare(PHP_VERSION, '5.0.0', '<')) { // PHP 4
		$pageNavScoreScript =& new JPagination($total, $limitstart, $limit);
	}
	else { // PHP 5
		$pageNavScoreScript = new JPagination($total, $limitstart, $limit);
	}
	

	$thequery = "SELECT c.*, concat(u.name, ' (', u.username, ')') AS editor FROM #__madblanks_scorescripts AS c
	LEFT JOIN #__users AS u ON u.id = c.checked_out";
	//if ($matchtypelimit) {
	//	$thequery .= " WHERE c.type='$matchtypelimit'";
	//}
	$thequery .= " ORDER BY c.ordering ASC LIMIT $pageNavScoreScript->limitstart,$pageNavScoreScript->limit";
	$database->setQuery($thequery);
	$rows = $database -> loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
//echo "<pre>"; print_r($rows); echo "</pre>\n";



	$HTML_MadBlanks = new HTML_MadBlanks();
	$HTML_MadBlanks->htmlListMadBlanksScoreScripts($option, $rows, $task, $pageNavScoreScript);
}

/**
 * Publish or unpublish Mad Blanks scorescripts
 *
 * @param string $option Joomla option string from URL
 * @param integer $publish publish (1) or unpublish (0) the passed records
 * @param array $cid scorescript id numbers to process (function operates on ALL scorescripts given in the array)
 */
function publishMadBlanksScoreScripts($option, $publish=1 ,$cid) {

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	if (!is_array( $cid ) || count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__madblanks_scorescripts SET published='$publish'"
	. "\nWHERE id IN ($cids)"
	// AND (checked_out=0 OR (checked_out='$my->id')
	);
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$app = &JFactory::getApplication();$app->redirect( "index2.php?option=$option&task=listscorescripts" );
}

/**
 * Alter the order of the scorescripts
 *
 * @param integer $uid scorescript id number to process
 * @param integer $inc the increment to reorder by
 * @param string $option Joomla option string from URL
 */
function orderMadBlanksScoreScripts($uid, $inc, $option) {
        $database = &JFactory::getDBO(); 

	$row = new MadBlanksScoreScript($database);
        $row->load((int)$uid);
        $row->reorder();
        $row->move($inc, "published >= 0");
        $row->reorder();

	$app = &JFactory::getApplication();$app->redirect("index2.php?option=$option&task=listscorescripts");
}

/**
 * Displays configuration data for currently published scorescripts
 * Use index.php in the frontend to display alone (i.e. without modules)
 */
function showScoreScriptReferenceWindow($published="1") {
	global $access;
	$database = &JFactory::getDBO();
	
	$database->setQuery("SELECT * FROM #__madblanks_scorescripts WHERE " . ($published ? "published > 0" : "published = 0") . " ORDER BY id ASC");
	$rows = $database->loadObjectList();
	
	$HTML_MadBlanks = new HTML_MadBlanks();
	$HTML_MadBlanks->htmlShowScoreScriptReferenceWindow($rows);
}

?>
