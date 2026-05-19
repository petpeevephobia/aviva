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
 * This file is the main front-end interface.
 *
 * file version 1.14.1 20110301
 *
 * @package Mad_Blanks_Component
 * @author Chris Hallett <chris@madblanks.org>
 * @copyright Chris Hallett March 1, 2011
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @version 1.4.2
 */

defined('_JEXEC') or die( 'Direct Access to this location is not allowed.' );

echo "\n<!-- Mad Blanks component 1.4.2 begin -->\n";

// enumerate global variables for Joomla! 1.5
global $mbFeaturedRecords, $access, $mbFieldCount, $mbEnteredByLongFormat, $mbModifiedByLongFormat,
$mbDisplayResultNumbering, $mbDefaultRecordsPerPage, $mbFrontendPageNavAlwaysOn,
$mbShowDisplayingWhatTitle, $mbPreviewBeforeSave, $mbApplyContentPlugins, $mbWordWrapWidth, $mbEnableMainScreen,
$mbStartPage, $mbModuleWithinComponentStyle, $mbModuleWithinComponentChrome, $mbModuleWithinComponentTypes,
$mbEnableCreateSingleRecordLinks, $mbCreateSingleRecordPosition, $mbTimeoutDataTimeToLive;

global $mainframe;
if (isset($madBlanksMenuOption)) {
	$option = $madBlanksMenuOption; // added $option here for compatibility with mod_madblanks_menu
}
else {
	$option = JRequest::getVar('option'); // added $option here for compatibility with mod_madblanks_menu
	$madBlanksMenuOption = ''; // initialize
}

/**
 * Require the component's class and support function file
 */
require_once($mainframe->getPath('class', $option)); // added $option here for compatibility with mod_madblanks_menu
// if that doesn't work, you can do this:
//require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanks.class.php');

/**
 * Require the component's frontend HTML output
 */
require_once($mainframe->getPath('front_html', $option)); // added $option here for compatibility with mod_madblanks_menu
// if that doesn't work, you can do this:
//require_once(JPATH_SITE.DS.'components'.DS.'com_madblanks'.DS.'madblanks.html.php');

// For component display, put the component's CSS file in the HTML head section
JHTML::stylesheet('madblanks.css', 'components/com_madblanks/', array('id' => 'madblanks-css'));

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


// Editor usertype check

$access = new stdClass();

$user_type =& JFactory::getUser();

// if user is an administrator, set $access->canEdit to 1
if($user_type->usertype == "Super Administrator" || $user_type->usertype == "Administrator"){
	$access->canEdit = 1;
}

// if user is not an administrator, set $access->canEdit to 0
else{
	$access->canEdit = 0;
}

// Determine whether users can edit their own records on the front end
// user types are "Super Administrator"=>0, "Administrator"=>1, "Manager"=>2, "Publisher"=>3, "Editor"=>4, "Author"=>5,
//  "Registered", or empty string if not logged in

$access->canEditOwn = 0; // initialize

// if $mbEditThreshold is 1 (the default) then "special" users can edit own
// if $mbEditThreshold is 0 then "registered" users can edit own

if ($mbEditThreshold) {
	if (
		$user_type->usertype == "Super Administrator" ||
		$user_type->usertype == "Administrator" ||
		$user_type->usertype == "Manager" ||
		$user_type->usertype == "Publisher" ||
		$user_type->usertype == "Editor" ||
		$user_type->usertype == "Author"
	) {
		$access->canEditOwn = 1;
	}
}
else {
	if (
		$user_type->usertype == "Super Administrator" ||
		$user_type->usertype == "Administrator" ||
		$user_type->usertype == "Manager" ||
		$user_type->usertype == "Publisher" ||
		$user_type->usertype == "Editor" ||
		$user_type->usertype == "Author" ||
		$user_type->usertype == "Registered"
	) {
		$access->canEditOwn = 1;
	}
}

$task = JRequest::getVar('task');

$params =& $mainframe->getPageParameters('com_madblanks');

$param_task = $params->get('task');

$param_startpage = $params->get('startpage');

if ($param_task == 'madblanksurl' && $param_startpage) {
	$mbStartPage = $param_startpage;
}

// any tasks not in the switch below will run the default: case
if (!$task && $param_task) {
	$task = $param_task;
}

if (!empty($_REQUEST['mod_madblanks_menu'])) {
        $task = 'default';
}

switch ( strtolower( $task ) ) {

	case 'showmadblanks':
		showMadBlanks();
		break;

	case 'userlistrecords':
		userListMadBlanks();
		break;

	case 'usereditrecordcid':
		userEditMadBlanksRecordCID();
		break;

	case 'usereditrecord':
		userEditMadBlanksRecord();
		break;

	case 'usernewrecord':
		userNewMadBlanksRecord();
		break;

	case 'saverecord':
		saveMadBlanksRecordFrontEnd();
		break;

	case "quickapproverecord":
		$theid = JRequest::getVar('id');
		approveMadBlanksRecordsFrontEnd(array($theid), 1, 0);
		cancelEditMadBlanksRecordFrontEnd();
		break;

	case 'canceleditrecord':
		cancelEditMadBlanksRecordFrontEnd();
		break;

	case "publishrecord":
		publishMadBlanksRecordsFrontEnd(1);
		break;

	case "unpublishrecord":
		publishMadBlanksRecordsFrontEnd(0);
		break;

	case "approverecord":
		$cid = JRequest::getVar('cid');
		approveMadBlanksRecordsFrontEnd($cid, 1, 1);
		break;

	case "unapproverecord":
		$cid = JRequest::getVar('cid');
		approveMadBlanksRecordsFrontEnd($cid, 0, 1);
		break;

	case "completerecord":
		completeMadBlanksRecordsFrontEnd(1);
		break;

	case "uncompleterecord":
		completeMadBlanksRecordsFrontEnd(0);
		break;

	case "usercopyrecord":
		userCopyMadBlanksRecord();
		break;

	case "userdeleterecords":
		userDeleteMadBlanksRecords();
		break;

	case "singlefieldinput":
		singleFieldInput();
		break;

	//case "newrecord_module":
	//	newRecordModuleSave();
	//	break;

	case 'showmbmod':
		showMBLCSRModules();
		break;

	default:
		showMadBlanksDefault(0, '', 0, $madBlanksMenuOption);
		break;

}

echo "\n<!-- Mad Blanks component output end -->\n";

/**
 * Default front-end interface with links and form access to the component's content
 * @param integer $mod_madblanks_menu is true if this is being called by the Mad Blanks menu module on a Mad Blanks page
 * @param string $alternateformname name of the form if the menu module is calling this function
 * @param string $overrideItemid Itemid to use
 * @param string $madBlanksMenuOption option to use when creating URLs
 */
function showMadBlanksDefault($mod_madblanks_menu=0, $alternateformname='', $overrideItemid=0, $madBlanksMenuOption='') {

	global $mbFeaturedRecords, $mbStartPage, $mbEnableCreateSingleRecordLinks,
	$mbCreateSingleRecordPosition;

	if (!empty($madBlanksMenuOption)) {
		$option = $madBlanksMenuOption; // added $option here for compatibility with mod_madblanks_menu
	}
	else {
		$option = JRequest::getVar('option'); // added $option here for compatibility with mod_madblanks_menu
	}
	$Itemid = $overrideItemid ? $overrideItemid : JRequest::getVar('Itemid');

	// if this was called by mod_madblanks_menu not on a Mad Blanks page, this var should be 1
	if (empty($mod_madblanks_menu)) {
		$mod_madblanks_menu = JRequest::getVar('mod_madblanks_menu', 0);
	}

	// redirect the start page if this function was not called by the menu module
	if (empty($mod_madblanks_menu) && !empty($mbStartPage)) {
		$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option" . (!empty($Itemid) ? "&Itemid=$Itemid" : "") . $mbStartPage));
	}

	$gotorecord = JRequest::getVar('gotorecord');
	$gotocategory = JRequest::getVar('gotocategory');
	$therecord = JRequest::getVar('therecord');
	$thecategory = JRequest::getVar('thecategory');

	if ($gotorecord) {
		if (is_numeric($therecord) && ((int) $therecord > 0)) {
			$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=showmadblanks&id=$therecord&Itemid=$Itemid"));
		}
		else {
			$theerrormsg = _MBL_NUMERIC_FORM_INPUT; //"Form input must be a number.";
		}
	}

	if ($gotocategory) {
		if (is_numeric($thecategory) && ((int) $thecategory > 0)) {
			$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=showmadblanks&category=$thecategory&Itemid=$Itemid"));
		}
		else {
			$theerrormsg = _MBL_NUMERIC_FORM_INPUT; //"Form input must be a number.";
		}
	}

	if (!isset($theerrormsg)) {
		$theerrormsg = '';
	}

	// determine whether or not there are any records that can be displayed by the component
	//  all we need here is a yes or no
	$thequery = getDisplayQuery(null, null, null, "AND cat.allow_frontend_viewing > 0", null, "SELECT count(*)");

	$database = &JFactory::getDBO();

	$database->setQuery($thequery);
	$somethingtodisplay = $database->loadResult();
	//echo "<h1>the total count is $somethingtodisplay</h1>\n";

	$database->setQuery("SELECT id, name, default_title FROM #__madblanks_categories WHERE published > 0 AND allow_frontend_viewing > 0 AND frontend_show_in_list > 0 ORDER BY ordering ASC, date_created ASC");
	$rows = $database->loadObjectList();

	$mbFeaturedRecords = preg_replace('/\D/',',',$mbFeaturedRecords); // replace anything that is not a decimal digit with a comma

	// added the following conditional to solve SQL error notification when no featuredrows; 1.1.0 Final CPH 20090517
	if ($mbFeaturedRecords) {
		$database->setQuery("SELECT id, title, configid, show_category_title FROM #__madblanks_records WHERE completed > 0 AND approved > 0 AND published > 0 AND id IN (" . $mbFeaturedRecords . ") ORDER BY FIELD( id, " . $mbFeaturedRecords . ")");
		$featuredrows = $database->loadObjectList();
	}
	else {
		$featuredrows = '';
	}

	$csrlist = array(); // initialize array that will hold the list of links for taking quizzes/surveys via CSR
	$database->setQuery("SELECT id,params FROM #__modules WHERE module = 'mod_madblanks_createsinglerecord' AND published > 0 AND position = '" . $mbCreateSingleRecordPosition . "' LIMIT 1");
	$csrrows = $database->loadObjectList();

	//echo "<pre>csrrows\n"; print_r($csrrows); echo "</pre>\n";

	if ($mbEnableCreateSingleRecordLinks && count($csrrows) > 0) {
		//echo "<pre>"; print_r($csrrows); echo "</pre>\n";

		// save the ID number of the Create Single Record module
		$csrid = $csrrows[0]->id;

		preg_match("/newcategories=(([\d,])*)\n/", $csrrows[0]->params, $matches);
		// $matches[1] is now a comma-delimited list of the module's configured categories

		$module_configured_categories = $matches[1];

		if (!empty($matches[1])) {
			$new_categories_array = explode(',', $matches[1]);
		}

		preg_match("/cat_choice_format=(.*)\n/", $csrrows[0]->params, $matches);
		// $matches[1] is now the category string format to be used for the links

		//echo "<pre>link format\n"; print_r($matches); echo "</pre>\n";

		$link_format = $matches[1];


		// Get master list of available categories for CSR module
		$database->setQuery("SELECT id,name FROM #__madblanks_categories WHERE published > 0 AND allow_frontend_module_editing > 0 AND frontend_show_in_csr_list > 0 ORDER BY ordering ASC");
		$csrrows = $database->loadObjectList();

		//echo "<pre>master list\n"; print_r($csrrows); echo "</pre>\n";

		foreach ($csrrows as $csrrow) {
			$allowed_array[] = $csrrow->id;
			//echo "<br />the next id is $configrow->id\n";
			$cat_names[$csrrow->id] = $csrrow->name;
		}

		//echo "<pre>master allowed array\n"; print_r($allowed_array); echo "</pre>\n";

		// store the categories available for new records that are selected in
		//  the module parameter AND allowed in the component configuration
		if (isset($new_categories_array) && is_array($new_categories_array) && isset($allowed_array) && is_array($allowed_array)) {
			$new_categories_array = array_intersect($new_categories_array, $allowed_array);
		}

		// if the categories field is blank and there are categories in the allowed array, use the allowed array only
		else if (empty($module_configured_categories) && isset($allowed_array) && is_array($allowed_array)) {
			$new_categories_array = $allowed_array;
		}

		else {
			unset($new_categories_array);
		}

		// if we've got categories to make links for, they're now in $new_categories_array
		if (!empty($new_categories_array)) {

			//echo "<pre>"; print_r($new_categories_array); echo "</pre>\n";

			$randomtagresultssofar = array(); // array to cache random tag results

			$postprefix = "mbcsr";

			foreach ($new_categories_array as $category_id) {
				$cat_name = sprintf(replaceSpecialCharacters(strval($link_format ? $link_format : "Category #%1$s: %2$s"), 0, null, 0, null, null, $randomtagresultssofar), $category_id, $cat_names[$category_id]);
				//$csrlist[] =  JHTML::_('select.option', $category_id, !empty($selectcategorytruncatelength) && JString::strlen($cat_name) >= $selectcategorytruncatelength +6 ? JString::substr($cat_name, 0, $selectcategorytruncatelength) . ".&nbsp;.&nbsp;." : $cat_name);
				$csrlist[] = "<a href=\"" . sefRelToAbs_madblanks("index.php?option=$option&task=showmbmod&mid=" . $csrid . "&" . $postprefix . $csrid . "configid=" . $category_id . ($Itemid ? "&Itemid=" . $Itemid : "")) . "\" >" . $cat_name . "</a>";
			}

		}

		// $csrlist has the final list of links
		//echo "<pre>final list of links:\n"; print_r($csrlist); echo "</pre>\n";
	}

	// set HTML <title> data if set in configuration
	setMadBlanksPageTitle();

	global $access, $mbEnableMainScreen;
	if ($mbEnableMainScreen) {
		$HTML_MadBlanks_frontend = new HTML_MadBlanks_frontend();
		$HTML_MadBlanks_frontend->htmlShowMadBlanksDefault($option, $theerrormsg, $rows, $featuredrows, $access, $Itemid, $somethingtodisplay, $alternateformname, $csrlist);
	}
	else {
		echo _MBL_MAIN_SCREEN_DISABLED . "\n";
	}
}

/**
 * Main routine for displaying records
 */
function showMadBlanks() {

	// 1.2.1 CPH 20090831 added $mbDefaultRecordsPerPage here
	global $mbFieldCount, $mbApplyContentPlugins, $mbDefaultRecordsPerPage, $mainframe;

	$database =& JFactory::getDBO();

	$HTML_MadBlanks_frontend = new HTML_MadBlanks_frontend();

	// $id is the id of a particular record
	// $option is the $option data in the URL
	// $random is a boolean value indicating to display a random configuration
	// $category is a jos_madblanks_categories table id
	// $Itemid is for the Joomla menus

	$option = JRequest::getVar('option');
	$task = JRequest::getVar('task');
	$random = JRequest::getVar('random'); // boolean
	$category = JRequest::getVar('category'); // filter records by category (single value, comma-delimited list, or hyphen-delimited range)
	$id = JRequest::getVar('id'); // filter records by id (single value, comma-delimited list, or hyphen-delimited range)
	$Itemid = JRequest::getVar('Itemid');
	$showall = JRequest::getVar('showall');


	$params =& $mainframe->getPageParameters('com_madblanks');

	// default: $select = "SELECT data.*, IF(data.ordering,1,0) AS specialordering";
	$select = $params->get('select');
	// the instructions advise that 'rec.' is the prefix for
	//  items from the records table, this is changed here to 'data.'
	if ($select != '') {
		$select = 'SELECT ' . str_replace('rec.', 'data.', $select);
	}

	// Create the ORDER BY clause based on what the URL or parameters may have provided for $orderby
	// if there is no data provided, leave it as an empty string here to use the default

	// default: $order_by_etc="ORDER BY cat.ordering ASC, data.sticky DESC, specialordering DESC, data.ordering ASC, data.date_entered DESC, data.id DESC";
	$orderby = JRequest::getVar('orderby');
	// keep $orderby as is for use in forming the URL to the page in this function below
	if ($orderby == '') {
		$orderby2 = $params->get('orderby');
	}
	else {
		$orderby2 = $orderby;
	}
	$order_by_etc = ''; // initialize
	if ($orderby2 != '') {

		//// lines removed for 1.4.1 CPH 20101220
		$order_by_etc .= 'ORDER BY ';
		// eliminate extraneous spaces around commas
		////$orderby2 = str_replace(', ', ',', $orderby2);
		// the instructions advise that 'rec.' is the prefix for
		//  items from the records table, this is changed here to 'data.'
		////$orderby2 = explode(',', str_replace('rec.', 'data.', $orderby2));
		$orderby2 = str_replace('rec.', 'data.', $orderby2);
		////$comma = ''; // initialize, empty for first looparound
		////$database =& JFactory::getDBO();
		////foreach($orderby2 as $item) {
		////	$field_ascordesc = explode(' ', $item);
		////	if (JString::strtoupper($field_ascordesc[1]) == 'DESC') {
		////		$ascordesc = 'DESC';
		////	}
		////	else {
		////		$ascordesc = 'ASC';
		////	}
		////	$order_by_etc .= $comma . $database->getEscaped($field_ascordesc[0]) . ' ' . $ascordesc;
		$order_by_etc .= $orderby2;
		////	$comma = ',';
		////}
	}

	//$params =& $mainframe->getPageParameters('com_madblanks');
	$param_categoryid = $params->get('categoryid');
	if (!$category && $param_categoryid && is_numeric($param_categoryid)) { // 1.4.1 CPH 20101001 add is_numeric check because default category in config.xml is now 'none' instead of 0
		$category = $param_categoryid;
	}

	if ($showall) {
		$limit = 0; // limit of zero is interpreted as very high limit
		$limitstart = 0;
	}
	else if (JRequest::getInt('limit')) {
		$limit = JRequest::getInt('limit');
		$limitstart = JRequest::getInt('limitstart', '0');
	}
	else if (isset($mbDefaultRecordsPerPage) && $mbDefaultRecordsPerPage) {
		$limit = $mbDefaultRecordsPerPage;
		$limitstart = JRequest::getInt('limitstart', 0);
	}
	else {
		$limit = 15;
		$limitstart = JRequest::getInt('limitstart', 0);
	}

	$startdatetime = JRequest::getVar('startdatetime');
	$enddatetime = JRequest::getVar('enddatetime');
	$user = JRequest::getVar('user'); // filter records by userid (single value or comma-delimited list or 'none')

	// In the following if-else tree we define the object $rows to contain the data fields to be displayed.
	// Use &random=true&category=<category id number> in the URL to create one randomized record to be displayed in a given category
	if ($random) { // output $rows for a randomized record from this category
		// A category must be specified to do randomization when using &random=true in the URL.
		//  If it is not specified, provide a list of choices.
		if (!isset($category)) {
			$HTML_MadBlanks_frontend->htmlMakeRandomizerLinkList($option, $Itemid);
			return;
		}
		else {
			$rows = makeRandomizedRecord ($category, $startdatetime, $enddatetime, $user, "AND cat.allow_frontend_viewing > 0");
		}
		$thetitlestring = sprintf(_MBL_RANDOMIZED_ENTRY_TITLE, getCategoryFieldByID(intval($category), 'name', 1));

		// same query whose sole purpose later in the function will be to get the total number of records
		// in this case, only one randomized record is displayed in the results
		$totalquery = "SELECT 1";
	}

	else if ($id) {
		// if 'id' is set as a URL variable and has been passed to this function, output $rows
		// $id can be a comma-delimited list, a range with a hyphen, or a single value
		//$sortarg1 ='';
		$additional_sql = "AND cat.allow_frontend_viewing > 0";
		if (strpos($id, "-")){
			// start point is $sortarg[0] end point is $sortarg[1]
			$sortarg = explode('-',$id);

			// remove anything that is not a decimal digit
			$sortarg[0] = preg_replace('/\D/','',$sortarg[0]);
			$sortarg[1] = preg_replace('/\D/','',$sortarg[1]);
			//$id = $sortarg[0] . "-" . $sortarg[1];

			$additional_sql .= "\nAND data.id BETWEEN " . $sortarg[0] . " AND " . $sortarg[1];
			}
		else {
			$id = preg_replace('/\D/',',',$id); // replace anything that is not a decimal digit with a comma
			$additional_sql .= "\nAND data.id IN (" . $id . ")";
		}

		$thequery = getDisplayQuery($startdatetime, $enddatetime, $user, $additional_sql, $order_by_etc, $select, $limitstart, $limit);
		// same query whose sole purpose later in the function will be to get the total number of records
		$totalquery = getDisplayQuery($startdatetime, $enddatetime, $user, $additional_sql, null, "SELECT count(*)");

		$database->setQuery($thequery);
		$rows = $database->loadObjectList();

		// create text to append inside HTML <title> tag
		if (!empty($rows)) {
			foreach ($rows as $row) {
				$newtitle = $row->title ? $row->title : getCategoryFieldByID($row->configid, 'default_title', 1);
				if (!empty($newtitle)) {
					$title_array[] = $newtitle;
				}
			}

			$thetitlestring = ''; // initialize
			if (!empty($title_array)) {
				$titlenotempty = false; // initialize
				$title_array = array_unique($title_array);
				foreach($title_array as $title) {
					if (!empty($title)){
						$titlenotempty = true;
						break;
					}
				}
				if ($titlenotempty) {
					$thetitlestring = implode(", ", $title_array);
				}
			}
		}

	}
	else if ($category) {
		// if 'category' is set as a URL variable and has been passed to this function, output $rows
		// $category can be a comma-delimited list, a range with a hyphen, or a single value
		//$sortarg1 ='';
		$additional_sql = "AND cat.allow_frontend_viewing > 0";
		if (strpos($category, "-")){
			// start point is $sortarg[0] end point is $sortarg[1]
			$sortarg = explode('-',$category);

			// remove anything that is not a decimal digit
			$sortarg[0] = preg_replace('/\D/','',$sortarg[0]);
			$sortarg[1] = preg_replace('/\D/','',$sortarg[1]);
			$additional_sql .= "\nAND data.configid BETWEEN " . $sortarg[0] . " AND " . $sortarg[1];
		}
		else {
			$category = preg_replace('/\D/',',',$category); // replace anything that is not a decimal digit with a comma
			$additional_sql .= "\nAND data.configid IN (" . $category . ")";
			//$sortarg = explode(',',$category);
			//$sortarg1 = "";
			//foreach ($sortarg as $sarg) {
			//	$sortarg1 .= empty($sortarg1) ? "\nAND (data.configid=" . $sarg : " OR data.configid=" . $sarg;
			//}
			//$sortarg1 .=")";
		}
		$thequery = getDisplayQuery($startdatetime, $enddatetime, $user, $additional_sql, $order_by_etc, $select, $limitstart, $limit);
		// same query whose sole purpose later in the function will be to get the total number of records
		$totalquery = getDisplayQuery($startdatetime, $enddatetime, $user, $additional_sql, null, "SELECT count(*)");

		$database->setQuery($thequery);
		$rows = $database->loadObjectList();

		// create text to append inside HTML <title> tag
		if (!empty($rows)) {
			foreach ($rows as $row) {
				$newtitle = getCategoryFieldByID($row->configid, 'name', 1);
				if (!empty($newtitle)) {
					$title_array[] = $newtitle;
				}
			}

			$thetitlestring = ''; // initialize
			if (!empty($title_array)) {
				$titlenotempty = false; // initialize
				$title_array = array_unique($title_array);
				foreach($title_array as $title) {
					if (!empty($title)){
						$titlenotempty = true;
						break;
					}
				}
				if ($titlenotempty) {
					$thetitlestring = implode(", ", $title_array);
				}
			}
		}

	}
	else {  // output $rows for everything

		//echo "<h1>limitstart is $limitstart and limit is $limit</h1>";
		$thequery = getDisplayQuery($startdatetime, $enddatetime, $user, "AND cat.allow_frontend_viewing > 0", $order_by_etc, $select, $limitstart, $limit);
		// same query whose sole purpose later in the function will be to get the total number of records
		$totalquery = getDisplayQuery($startdatetime, $enddatetime, $user, "AND cat.allow_frontend_viewing > 0", null, "SELECT count(*)");

		//echo "<br />setting query $thequery\n";
		$database->setQuery($thequery);
		$rows = $database->loadObjectList();
		$thetitlestring = _MBL_SHOW_ALL . " " . _MBL_RECORD_NAME_PLURAL;
	}

	if (empty($rows)) { // if we retrieved nothing
		if ($id) {
			// $id can be a comma-delimited list, a range with a hyphen, or a single value
   			if (strpos($id, "-") || strpos($id, ",")) {
				$HTML_MadBlanks_frontend->htmlDisplayFrontEndError(sprintf(_MBL_ID_PLURAL_DOESNT_EXIST, $id), $option);
			}
			else {
				$HTML_MadBlanks_frontend->htmlDisplayFrontEndError(sprintf(_MBL_ID_SINGULAR_DOESNT_EXIST, $id), $option);
			}
		}
		else if ($random) {
			$HTML_MadBlanks_frontend->htmlDisplayFrontEndError(sprintf(_MBL_NO_RANDOMIZIBLE_RECORDS, $category), $option);
		}
		else if ($category) {
			$HTML_MadBlanks_frontend->htmlDisplayFrontEndError(sprintf(_MBL_CATEGORY_DOESNT_EXIST, $category), $option);
		}
		else {
			$HTML_MadBlanks_frontend->htmlDisplayFrontEndError(_MBL_NO_RECORDS_TO_DISPLAY, $option);
		}
	}
	else { // now let's go ahead and get what we have ready to display
		 $configuration = getConfigurationArray();
		/**
		 * This will be a collection of objects to display. The script will normally
		 * add another $displayrow object to this array during each iteration of the
		 * foreach loop that follows. This array will then be passed to the HTML display
		 * function.
		 * @var array
		 */
		$displayrows = array();

 		foreach($rows as $row) {
			// If $category is not already set (as it should be when displaying a randomized entry),
			//  set the current category equal to the configid for the current record.
			unset($currentcategory);
			// if displaying a random entry and the category is set to a numeric (and thus usable) value, then
			//  set $currentcategory to that value; otherwise grab the category number out of the particular record
			$currentcategory = (is_numeric($category)&& $random) ? $category : $row->configid;
			// if the configuration is unpublished or not retrievable from the database, skip this record
			if (!isset($configuration[$currentcategory])) {
				continue; // go to the next iteration of the foreach loop
			}
			else {
				(bool) $displaying_something = true;
				/**
				 * The following variables are collected in the $displayrow object for each record
				 * to display, collected in the $displayrows array, and passed to the HTML generator function,
				 * @see HTML_MadBlanks_frontend::htmlShowMadBlanks()
				 * $displayrow->category_id
				 * $displayrow->record_id
				 * $displayrow->category_title
				 * $displayrow->random_button
				 * $displayrow->record_title
				 * $displayrow->created_date
				 * $displayrow->entered_by
				 * $displayrow->modified_by
				 * $displayrow->modified_date
				 * $displayrow->content_string
				 * $displayrow->home_link
				 * $displayrow->self_link_string
				 * $displayrow->text
				 * $displayrow->scodata1
				 * $displayrow->scodata2
				 * { $displayrow->scodataN where N equals up to 100 }
				 *
				 * $displayrow->record_id
				 * $displayrow->self_url
				 * @var object
				 */
				$displayrow = new MadBlanksRecordDisplay();
				// 1.4.0 final add new members to $displayrow, including the whole of $row
				$displayrow->category_id = $row->configid;
				$displayrow->record_id = $row->id;
				$displayrow->row = $row;
			}

			if ($random) {
				$displayrow->record_title = $configuration[$currentcategory]->name_for_randomized;
				$displayrow->random_button = "<br clear=\"all\" /><a class=\"mbl_link_as_button\" href=\"" . JUri::base()
					. "/index.php?option=" . $option . "&task=showmadblanks&category=" . $currentcategory
					. "&random=true"
					. (isset($Itemid) ? "&Itemid=$Itemid" : "")
					. (isset($randomizerstartdatetime) ? "&randomizerstartdatetime=$randomizerstartdatetime" : "")
					. (isset($randomizerenddatetime) ? "&randomizerenddatetime=$randomizerenddatetime\"" : "")
					. "\" />" . _MBL_BUTTON_SHOW_ANOTHER_RANDOM_TEXT . "</a>";
			}
			else {
				if (getDisplayConfigurationVariable($row, $configuration[$row->configid], 'show_category_title')) {
					$displayrow->category_title = $configuration[$row->configid]->name;
				}
				if (getDisplayConfigurationVariable($row, $configuration[$row->configid], 'show_self_button')) {
					$displayrow->random_button = "<br clear=\"all\" /><a class=\"mbl_link_as_button\" href=\"" . JUri::base()
					. "/index.php?option=" . $option . "&task=showmadblanks&id=" . $row->id
					. (isset($Itemid) ? "&Itemid=$Itemid" : "")
					. (isset($randomizerstartdatetime) ? "&randomizerstartdatetime=$randomizerstartdatetime" : "")
					. (isset($randomizerenddatetime) ? "&randomizerenddatetime=$randomizerenddatetime\"" : "")
					.  "\">" . _MBL_BUTTON_SHOW_ANOTHER_RANDOM_TEXT . "</a>";
				}
				if (getDisplayConfigurationVariable($row, $configuration[$row->configid], 'show_individual_title')) {
					if (!empty($row->title)) {
						$displayrow->record_title = trim($row->title);
					}
					else {
						$displayrow->record_title = trim($configuration[$row->configid]->default_title);
					}
				}

				global $mbWordWrapWidth; // set at the top of this file
				if ($mbWordWrapWidth) {
					$displayrow->record_title = wordwrap($displayrow->record_title, $mbWordWrapWidth, "\n", 1);
				}

				if (getDisplayConfigurationVariable($row, $configuration[$row->configid], 'show_date_created')) {
					if (intval($row->date_entered)) {
						$displayrow->created_date = JHTML::_('date', $row->date_entered, JText::_('_MBL_DATE_ENTERED_FORMAT'));
					}
				}
				if (getDisplayConfigurationVariable($row, $configuration[$row->configid], 'show_entered_by')) {
					if ($row->author_alias) {
						$displayrow->entered_by = _MBL_ENTERED_OR_AUTHORED_BY . " " . $row->author_alias;
					}
					else if ($row->entered_by) {
						// access configuration option to determine if this shows name or username
						global $mbEnteredByLongFormat;
						$displayrow->entered_by = _MBL_ENTERED_OR_AUTHORED_BY . " " . getUserNameByID ($row->entered_by, $mbEnteredByLongFormat);
					}
				}
				if (getDisplayConfigurationVariable($row, $configuration[$row->configid], 'show_modified_by')) {
					if ($row->modified_by) {
						// access configuration option to determine if this shows name or username
						global $mbModifiedByLongFormat;
						$displayrow->modified_by = _MBL_MODIFIED_BY . " " . getUserNameByID ($row->modified_by, $mbModifiedByLongFormat);
					}
				}
				if (getDisplayConfigurationVariable($row, $configuration[$row->configid], 'show_modified_date')) {
					if (intval($row->date_modified)) {
						$displayrow->modified_date = _MBL_MODIFIED_ON . " " . JHTML::_('date', $row->date_modified, JText::_('_MBL_DATE_MODIFIED_FORMAT'));
					}
				}
			}

			global $mbFieldCount, $mbWordWrapWidth; // set at the top of this file

			$displayrow->text = concatenateDisplayString($mbFieldCount, $row, $configuration[$currentcategory], $mbWordWrapWidth, 1);
			$displayrow->record_id = $row->id;
			// 1.4.0 final 20100820 add scodataN (at least scodata1 and scodata2) to the possible fields to display
			for ($scodataindex = 1; $scodataindex <= 100; $scodataindex++) { // assume no more than 100 scodata fields as a hard limit
				if (isset($row->{'scodata' . $scodataindex})) {
					$displayrow->{'scodata' . $scodataindex} = $row->{'scodata' . $scodataindex};
				}
				else {
					break;
				}
			}
			unset($scodataindex);

			if (getDisplayConfigurationVariable($row, $configuration[$row->configid], 'show_self_link') && !$random) {
				$displayrow->self_link_string = "\n<p align=\"right\" class=\"madblankslink\"><a href=\""
				. sefRelToAbs_madblanks("index.php?option=" . $option . "&amp;task=showmadblanks&amp;id=" . $row->id . (!empty($Itemid) ? "&amp;Itemid=$Itemid" : ""))
				. "\">" . sprintf(_MBL_LINK_TO_THIS, $row->id) . "</a></p>\n";

			       	$displayrow->self_url = sefRelToAbs_madblanks("index.php?option=" . $option . "&amp;task=showmadblanks&amp;id=" . $row->id . (!empty($Itemid) ? "&amp;Itemid=$Itemid" : ""));

				$displayrow->self_link_string = str_replace("&", "&amp;", $displayrow->self_link_string);
				$displayrow->self_url = str_replace("&", "&amp;", $displayrow->self_url);

			}
			if (($random && $configuration[$currentcategory]->show_home_link_for_randomized) ||
			(!empty($row->id) && getDisplayConfigurationVariable($row, $configuration[$row->configid], 'show_home_link'))) {
				$displayrow->home_link = "<p><a href=\""
				. sefRelToAbs_madblanks("index.php?option=" . $option . "&amp;Itemid=$Itemid") . "\">" . _MBL_COMPONENT_HOME_LINK_TEXT . "</a></p>";
			}

		$displayrows[] = $displayrow; // add the object for the record we just created to the master array
		//echo "<h1>added displayrow</h1>\n";

		} // end foreach loop

		if (!$displaying_something) {
			$HTML_MadBlanks_frontend->htmlDisplayFrontEndError(_MBL_NO_RECORDS_TO_DISPLAY, $option);
		}
		else {
                        // because the array keys for $displayrows will be destroyed when doing array_slice(),
                        //  and we want to preserve the value if we want to show consecutive numbering for returned
                        //  results on the frontend, put the key (plus 1 so we start with 1, not 0) into each
                        //  object in the array
                        global $mbDisplayResultNumbering;
                        if ($mbDisplayResultNumbering) {
                        	$numberingindex = $limitstart + 1; // initialize
				foreach ($displayrows as $key => $value) {
					//$displayrows[$key]->originalkey = $key + 1;
					// 1.2.1 CPH 20090901 modified since array_slice() method no longer being used
					$displayrows[$key]->originalkey = $numberingindex;
					$numberingindex++;
				}
			}

			// set the number of records to display per page
			// use the configuration default if zero or not defined
			// use hard-coded value if we can't find the configuration variable
			global $mbFrontendPageNavAlwaysOn;
			// 1.2.1 CPH 20090901 reestablish the record limit for display purposes as opposed to count purposes
			$limit = JRequest::getVar('limit');
			$limit = $limit ? $limit : ($mbDefaultRecordsPerPage ? $mbDefaultRecordsPerPage : 15);

			//echo "<h1>the totalquery was <pre>" . $totalquery . "</pre></h1>\n";

			// look up the total number of records in the entire batch, not just on this page
			//  use the previously saved $totalquery
			$database->setQuery($totalquery);
			$total = $database->loadResult();

			//echo "<h1>total is $total and limit is $limit and limitstart is $limitstart and mbFrontendPageNavAlwaysOn is $mbFrontendPageNavAlwaysOn</h1>\n";

			//  If $showall is true in the URL, all the results go on one page no matter what
			if ($showall) {
				$limit = $total;
			}

			// If there are more records than we can display on one page,
			//  or if the component configuration says to always use pageNav,
                        //  set up pageNavigation to make multiple pages
                        if (($total > $limit) || $mbFrontendPageNavAlwaysOn) {

				$limitstart = isset($limitstart) ? $limitstart : 0;

				// restart display at record zero if funky things happen due to changing the pulldown list limit number
				if (!(is_int($limitstart / $limit + 1)) || ($limitstart / $limit + 1 > ceil($total / $limit))) {
					$limitstart = 0;
				}

				// 1.2.1 CPH 20090907 fix front end pagination
				//if (class_exists('JPagination')) {

				//echo "<h1>total is $total and limit is $limit and limitstart is $limitstart and mbFrontendPageNavAlwaysOn is $mbFrontendPageNavAlwaysOn</h1>\n";

				global $mainframe;
				jimport('joomla.html.pagination');
				if (version_compare(PHP_VERSION, '5.0.0', '<')) { // PHP 4
					$pageNav =& new JPagination($total, $limitstart, $limit);
				}
				else { // PHP 5
					$pageNav = new JPagination($total, $limitstart, $limit);
				}
				//}

				//else {
				//	// pageNav allows pagination of results on the frontend
				//	require_once( JPATH_SITE . '/includes/pageNavigation.php' );
				//	$pageNav = new mosPageNav( $total, $limitstart, $limit );
				///}

				// build the entire link to the current page we're on, for the benefit of pageNav;
				//  the pageNav functions will add on the limit and limitstart values
				$pageNavBaseLink = "index.php?option=" . $option
				. (isset($task) ? "&task=" . $task : "")
				. (isset($id) ? "&id=" . $id : "")
				. (isset($random) ? "&random=" . $random : "")
				. (isset($category) ? "&category=" . $category : "")
				. (isset($startdatetime) ? "&startdatetime=" . $startdatetime : "")
				. (isset($enddatetime) ? "&enddatetime=" . $enddatetime : "")
				. (isset($limit) ? "&limit=" . $limit : "") /* added limit CPH 1.4.0 Beta 1 20090106 */
				. (isset($orderby) ? "&orderby=" . $orderby : '') /* added orderby CPH 1.4.0 Beta 5 20100525 */
				. (!empty($Itemid) ? "&Itemid=" . $Itemid : "");

				//echo "<h1>pageNavBaseLink is $pageNavBaseLink</h1>";

				// show which page out of how many we are looking at
				$pageNavPageWhatOfWhat = " " . _MBL_PAGE . " " . (string) ($limitstart / $limit + 1) . " " . _MBL_OF . " " . (string) ceil($total / $limit) . " ";

				//echo "<pre>displayrowsA:\n\n"; print_r($displayrows); echo "</pre>\n";

				// 1.2.1 CPH 20090901 the following line now irrelevant
				//$displayrows = array_slice($displayrows, $limitstart, $limit);

				//echo "<pre>displayrowsB:\n\n"; print_r($displayrows); echo "</pre>\n";

			}
			else {
				$pageNav = '';
				$pageNavBaseLink = '';
				$pageNavPageWhatOfWhat = '';
			}

			//echo "<pre>"; print_r($pageNav); echo "</pre>\n";

			// set HTML <title> data if set in configuration
			setMadBlanksPageTitle($thetitlestring);

			// create title data to show at the top of the component if set in configuration
			global $mbShowDisplayingWhatTitle;
			$thetitlestring = $mbShowDisplayingWhatTitle ? $thetitlestring : "";

			$HTML_MadBlanks_frontend = new HTML_MadBlanks_frontend();
			$HTML_MadBlanks_frontend->htmlShowMadBlanks($displayrows, $option, $task, $thetitlestring, $Itemid, $pageNav, $pageNavBaseLink, $pageNavPageWhatOfWhat);
		}
	}
}

/**
 * User Edit Mad Blanks Record with CID (checkbox) input
 *
 * Determine which checkbox was pressed and pass the id on to userEditMadBlanksRecord().
 */
function userEditMadBlanksRecordCID() {

	$option = JRequest::getVar('option');
	$cid = JRequest::getVar('cid');

	if (!is_array($cid) || count($cid) < 1 || !$cid[0]) {
		echo "<script> alert('" . sprintf(_MBL_MAKE_SELECTION, JString::strtolower(_MBL_EDIT)) . "'); window.location.href='index.php?option=$option&task=userlistrecords&mosmsg=" . sprintf(_MBL_MAKE_SELECTION, JString::strtolower(_MBL_EDIT)) . "';</script>\n";
		exit();
	}

	if($cid[0]) {
		userEditMadBlanksRecord($cid[0]);
	}
	else { // code should not get here
		echo "<script> alert('Unable to edit (no cid[0] passed to function)'); window.history.go(-1);</script>\n";
		exit();
	}
}

/**
 * User Edit Mad Blanks Record
 *
 * Edit an individual Mad Blanks record on the frontend.
 */
function userEditMadBlanksRecord($cid_id=null) {

	$HTML_MadBlanks_frontend = new HTML_MadBlanks_frontend();

	$option = JRequest::getVar('option');
	$id = JRequest::getVar('id');
	$configid = JRequest::getVar('configid');
	$jumptorecord = JRequest::getVar('jumptorecord');
	$reeditpreview = JRequest::getVar('reeditpreview', 0);
	$categorylimit = JRequest::getVar('categorylimit', null);
	$authorlimit = JRequest::getVar('authorlimit', null);
	$sortby = JRequest::getVar('sortby', null);
	$sortascordesc = JRequest::getVar('sortascordesc', null);
	$limit = JRequest::getVar('limit', null);
	$limitstart = JRequest::getVar('limitstart', null);
	$Itemid = JRequest::getVar('Itemid', null);

	if ($cid_id) { // a checkbox was selected and passed via the function userEditMadBlanksRecordCID().
		$id = $cid_id;
	}

	global $access;
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	if ((!($access->canEdit))&&(!($access->canEditOwn))){
		$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&authorlimit=$authorlimit&sortby=$sortby&sortascordesc=$sortascordesc&limit=$limit&limitstart=$limitstart&Itemid=$Itemid"), JText::_('ALERTNOTAUTH') );
	}
	else {
		$row = new MadBlanksRecord($database);

		if (is_numeric($jumptorecord)){

			if (mbRecordExistsFrontendEditAllowed($jumptorecord)) {

				$row -> load($jumptorecord);

				// this is an existing record, so pre-select the author for the "entered by" pulldown menu
				if (isset($row->entered_by)) {
					if ($access->canEditOwn && ($row->entered_by != $my->id)) {
						$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&authorlimit=$authorlimit&sortby=$sortby&sortascordesc=$sortascordesc&limit=$limit&limitstart=$limitstart&Itemid=$Itemid"), JText::_('ALERTNOTAUTH'));
					}
					$entered_by = $row->entered_by;
				}
				else { // unless there was no author specified
					$entered_by = 0;
				}
			}
			else {
				$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&authorlimit=$authorlimit&sortby=$sortby&sortascordesc=$sortascordesc&limit=$limit&limitstart=$limitstart&Itemid=$Itemid"), _MBL_RECORD_DOESNT_EXIST);
			}
		}
		else if($id && !$reeditpreview) { // editing an existing record

			if (mbRecordExistsFrontendEditAllowed($id)) {
				$row -> load($id);

				// this is an existing record, so pre-select the author for the "entered by" pulldown menu
				if (isset($row->entered_by)) {
					if ($access->canEditOwn && ($row->entered_by != $my->id)) {
						$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&authorlimit=$authorlimit&sortby=$sortby&sortascordesc=$sortascordesc&limit=$limit&limitstart=$limitstart&Itemid=$Itemid"), JText::_('ALERTNOTAUTH'));
					}
					$entered_by = $row->entered_by;
				}
				else { // unless there was no author specified
					$entered_by = 0;
				}
			}
			else {
				$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&authorlimit=$authorlimit&sortby=$sortby&sortascordesc=$sortascordesc&limit=$limit&limitstart=$limitstart&Itemid=$Itemid"), _MBL_RECORD_DOESNT_EXIST);
			}
		}
		else { // new record; published and show_in_random are enabled by default

			// when creating a new record, make the radio buttons completed and published by default
			// the class file makes them zero by default for the benefit of the field at a time module
			$row->completed = 1;
			$row->published = 1;
			// prefill author field
			$row->entered_by = $my->id;

			// the following in case we've come back to reedit an entry from the preview
			// if there's nothing to bind in $_POST, this won't have an effect

			// fix up $_POST vars to be reinserted into the editing form
			foreach($_POST as $key=>$value) {
				// check that key doesn't start with underscore and leave out checked_out and checked_out_time
				if (!(strpos($key, "_") === 0) && $key != 'checked_out' && $key != 'checked_out_time' && is_string($value)) {
					$_POST[$key] = htmlspecialchars($value);
				}
			}

			// bind it to the table
			if (!$row -> bind($_POST)) {
				echo "<script> alert('"
				.$row -> getError()
				."'); window.history.go(-1); </script>\n";
				exit();
			}

			// set these in the class file instead
			//$row->published = 1;
			//$row->show_in_random = 1;

			// this is a new record, so pre-select the current user for the "entered by" pulldown menu
			$my = &JFactory::getUser();
			$row->entered_by = $my->id; // current user's id number
			$row->configid = $configid;
		}

		// fail if checked out not by 'me'
		//(we should usually never get here because the checkbox and link to edit this record should not have been available)
		if ($row->checked_out && $row->checked_out != $my->id) {
			$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&authorlimit=$authorlimit&sortby=$sortby&sortascordesc=$sortascordesc&limit=$limit&limitstart=$limitstart&Itemid=$Itemid"), sprintf(_MBL_CHECKED_OUT_ERROR, _MBL_RECORD_NAME, "#" . $row->id, getUserNameByID($row->checked_out, 1) . ' [' . getUserNameByID($row->checked_out, 0) . ']'));
		}

		// fail if record configuration says this category is not editable on the frontend
		if (!checkRecordFrontendEditable($row->configid)) {
			$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&authorlimit=$authorlimit&sortby=$sortby&sortascordesc=$sortascordesc&limit=$limit&limitstart=$limitstart&Itemid=$Itemid"), sprintf(_MBL_CONFIG_UNEDITABLE_FRONTEND));
		}

		$row->checkout( $my->id );

		if($row->configid) {
			$configid = $row->configid;
		}
		else {
			$row->configid = $configid;
		}

		// if the category configuration was not loaded, redirect back to the list with error message
		if (!isset($row->configid)) {
			$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit&Itemid=$Itemid"), _MBL_RECORD_NOT_FOUND_MOSMSG);
		}

		$configrow = new MadBlanksCategory($database);
		$configrow -> load($configid);

		$HTML_MadBlanks_frontend->htmlUserEditMadBlanksRecord($option, $row, $configrow, $configid, $categorylimit, $authorlimit, $sortby, $sortascordesc, $limit, $limitstart, $access, $Itemid);
	}
}

/**
 * Save Mad Blanks Record
 *
 * this function is called after the record has been passed to the server via a form on the edit page
 */
function saveMadBlanksRecordFrontEnd() {

	$HTML_MadBlanks_frontend = new HTML_MadBlanks_frontend();

	$option = JRequest::getVar('option');
	$previewdone = JRequest::getVar('previewdone', 0);
	$categorylimit = JRequest::getVar('categorylimit', null);
	$authorlimit = JRequest::getVar('authorlimit', null);
	$sortby = JRequest::getVar('sortby', null);
	$sortascordesc = JRequest::getVar('sortascordesc', null);
	$limit = JRequest::getVar('limit', null);
	$limitstart = JRequest::getVar('limitstart', null);
	$Itemid = JRequest::getVar('Itemid');

	foreach( $_POST as $thekey => $theitem ) {
		if (is_string($theitem)) {
			$_POST[$thekey] = get_magic_quotes_gpc() ? htmlspecialchars(stripslashes($_POST[$thekey])) : htmlspecialchars($_POST[$thekey]); // Clean posted variables for security
		}
	}

	$_POST['session'] = getMadBlanksSession();

	global $mbPreviewBeforeSave, $mbFieldCount;
	$database = &JFactory::getDBO();
	$row = new MadBlanksRecord($database);

	// bind it to the table
	if (!$row -> bind($_POST)) {
		echo "<script> alert('"
			.$row -> getError()
			."'); window.history.go(-1); </script>\n";
		exit();
	}

	// 1.1.0b2 let's handle this by how we display the HTML instead of how we store it
	$configuration = getConfigurationArray(1);
	//if ($configuration[$row->configid]->allow_html_input) {
	//	for ($i=1; $i <= $mbFieldCount; $i++) {
	//		$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
	//		$row->{'data_'.$theindex} = mosGetParam($_REQUEST, 'data_' . $theindex, '', _MOS_ALLOWHTML);
	//	}
	//}

	if (!$previewdone && $mbPreviewBeforeSave) {
		global $mbFieldCount; // $mbFieldCount set at the top of this file
		$content_string = concatenateDisplayString($mbFieldCount, $row, $configuration[$row->configid], 0, 0);
		$HTML_MadBlanks_frontend->htmlSaveMadBlanksRecordPreview($option, $row, $content_string, $categorylimit, $authorlimit, $sortby, $sortascordesc, $limit, $limitstart, $Itemid);
	}

	else {
		// track who modified this record and when
		if (empty($row->date_entered)) { // only put in a date_entered when the record is created, never again
			$row->date_entered = date("YmdHis"); //save date in MySQL format
		}
		$row->date_modified = date("YmdHis"); //save date in MySQL format
		$my = &JFactory::getUser();

		if (empty($row->entered_by)) {
			$row->entered_by = $my->id; // id number of the current user
		}

		$row->modified_by = $my->id; // id number of the current user

		$autoapproved = false; // initialize
		$needsadminapproval = false; // initialize

		global $access;
		if ($configuration[$row->configid]->frontend_auto_approve && empty($row->approved) && !$access->canEdit) {
			$row->approved = 16777215; // this value is recognized by the getUserNameByID() function as the "auto approve" user
			$autoapproved = true;
		}
		else if (empty($configuration[$row->configid]->frontend_auto_approve) && empty($row->approved) && !$access->canEdit) {
			$needsadminapproval = true;
		}

		// store it in the db
		if (!$row -> store()) {
			echo "store error!<br />";
			echo "<script> alert('"
				.$row -> getError()
				."'); window.history.go(-1); </script>\n";
			exit();
		}

		$row->checkin();

		$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit&limit=$limit&limitstart=$limitstart&Itemid=$Itemid"), sprintf(_MBL_SAVE_RECORD_MOSMSG, madblanks_mysql_insert_id($database->_resource) ? madblanks_mysql_insert_id($database->_resource) : $row->id) . " " . ($autoapproved ? _MBL_SAVE_RECORD_AUTO_APPROVED : ($needsadminapproval ? _MBL_SAVE_RECORD_NOT_APPROVED : "")));
	}
}

/**
 * Cancels an edit operation
 */
function cancelEditMadBlanksRecordFrontEnd() {

	$option = JRequest::getVar('option');
	$limit = JRequest::getVar('limit', null);
	$limitstart = JRequest::getVar('limitstart', null);
	$showall = JRequest::getVar('showall', null);
	$categorylimit = JRequest::getVar('categorylimit', null);
	$authorlimit = JRequest::getVar('authorlimit', null);
	$sortby = JRequest::getVar('sortby', null);
	$sortascordesc = JRequest::getVar('sortascordesc', null);
	$Itemid = JRequest::getVar('Itemid');

	$database = &JFactory::getDBO();

	$row = new MadBlanksRecord($database);
	$row->bind( $_POST );
	$row->checkin();

	$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit&limit=$limit&limitstart=$limitstart&showall=$showall&Itemid=$Itemid"));
}


/**
 * List Records
 */
function userListMadBlanks() {

	//$mosHTML = new mosHTML();

	//echo "<pre>"; print_r($_REQUEST); echo "</pre>\n";

	$option = JRequest::getVar('option');
	$task = JRequest::getVar('task');
	$limit = JRequest::getVar('limit', null);
	$limitstart = JRequest::getVar('limitstart', null);
	$showall = JRequest::getVar('showall', null);
	$categorylimit = JRequest::getVar('categorylimit', null);
	$authorlimit = JRequest::getVar('authorlimit', null);
	$sortby = JRequest::getVar('sortby', null);
	$Itemid = JRequest::getVar('Itemid');

	//echo "limit1 is $limit";

	global $access;
	//$access->canEdit = 1; // override for testing
	//$access->canEditOwn = 0; // override for testing

	if ((!($access->canEdit))&&(!($access->canEditOwn))){
		$app = &JFactory::getApplication();
		$app->redirect(sefRelToAbs_madblanks("index.php?option=$option" . ($Itemid ? "&Itemid=$Itemid" : "")), JText::_('ALERTNOTAUTH'));
	}

	else {
		global $mainframe;
		$database = &JFactory::getDBO();
		$my = &JFactory::getUser();

		// passed from the dropdown menu to select records for only a particular category
		if (!$sortby) {
			$sortby = "id"; // default is to order by id descending
		}
		$sortascordescselection = JRequest::getVar('sortascordesc', 0);
		if (!$sortascordescselection) {
			$sortascordescselection = "DESC"; // default is to order by id descending
		}

		// get the total number of records
		$thequery = "SELECT count(*) FROM #__madblanks_records AS data LEFT JOIN #__madblanks_categories AS config
		ON data.configid = config.id WHERE config.published > 0 AND config.allow_frontend_editing > 0";
		if ($categorylimit) {
			$thequery .= " AND data.configid=" . (int) $categorylimit;
		}
		if ($authorlimit) {
			$thequery .= " AND data.entered_by=" . ($authorlimit == 'noauthor' ? 0 : (int) $authorlimit);
		}
		if ($access->canEditOwn) {
			$thequery .= " AND data.entered_by=" . (int) $my->id;
		}
		unset($didwhere);
		$database->setQuery($thequery);

		// set the total number of records
		$total = $database->loadResult();

		// set the number of records to display per page
		// use the configuration default if zero or not defined
		// use hard-coded value if we can't find the configuration variable

		//  If $showall is true in the URL, and results exist, all the results go on one page no matter what
		if ($showall && $total > 0) {
			$limit = $total;
			$limitstart = 0;
		}

		else {
			global $mbDefaultRecordsPerPage;
			//$limit = $limit ? $limit : ($mbDefaultRecordsPerPage ? $mbDefaultRecordsPerPage : 15);

			if (!is_numeric($limit)) {
				$limit = $mbDefaultRecordsPerPage ? $mbDefaultRecordsPerPage : 15;
			}

			$limitstart = $limitstart ? $limitstart : 0;

			// restart display at record zero if funky things happen due to changing the pulldown list limit number
			if (!(is_int($limitstart / $limit + 1)) || ($limitstart / $limit + 1 > ceil($total / $limit))) {
				$limitstart = 0;
			}
		}

		//echo "limit is $limit";

		// pageNav allows pagination of results on the frontend
		//require_once( JPATH_SITE . '/includes/pageNavigation.php' );
		//$pageNav = new mosPageNav( $total, $limitstart, $limit );

		jimport('joomla.html.pagination');
		if (version_compare(PHP_VERSION, '5.0.0', '<')) { // PHP 4
			$pageNav =& new JPagination($total, $limitstart, $limit);
		}
		else { // PHP 5
			$pageNav = new JPagination($total, $limitstart, $limit);
		}

		// build the entire link to the current page we're on, for the benefit of pageNav;
		//  the pageNav functions will add on the limit and limitstart values
		$pageNavBaseLink = "index.php?option=" . $option
		. (isset($task) ? "&task=" . $task : "")
		//. (isset($id) ? "&id=" . $id : "")
		//. (isset($random) ? "&random=" . $random : "")
		//. (isset($category) ? "&category=" . $category : "")
		//. (isset($startdatetime) ? "&startdatetime=" . $startdatetime : "")
		//. (isset($enddatetime) ? "&enddatetime=" . $enddatetime : "");
		. (isset($categorylimit) ? "&categorylimit=" . $categorylimit : "")
		. (isset($authorlimit) ? "&authorlimit=" . $authorlimit : "")
		. (isset($sortby) ? "&sortby=" . $sortby : "")
		. (isset($sortascordesc) ? "&sortascordesc=" . $sortascordesc : "")
		. (isset($limit) ? "&limit=" . $limit : "")
		. (isset($Itemid) ? "&Itemid=" . $Itemid : "")
		. (isset($limitstart) ? "&limitstart=" . $limitstart : "");

		// show which page out of how many we are looking at
		$pageNavPageWhatOfWhat = " " . _MBL_PAGE . " " . (string) ($limitstart / $limit + 1) . " " . _MBL_OF . " " . (($total == 0 || $limit == 0) ? "1" : (string) ceil($total / $limit)) . " ";

		$thequery = "SELECT data.*, concat(u.name, ' (', u.username, ')') AS editor FROM #__madblanks_records AS data
		LEFT JOIN #__users AS u ON u.id = data.checked_out LEFT JOIN #__madblanks_categories AS config
		ON data.configid = config.id WHERE config.published > 0 AND config.allow_frontend_editing > 0";
		if ($categorylimit) {
			$thequery .= " AND data.configid=" . (int) $categorylimit;
		}
		if ($authorlimit) {
			$thequery .= " AND data.entered_by=" . ($authorlimit == 'noauthor' ? 0 : (int) $authorlimit);
		}
		if ($access->canEditOwn) {
			$thequery .= " AND data.entered_by=" . (int) $my->id;
		}
		if ($sortby) {
			$thequery .= " ORDER BY data." . isValidMadBlanksVariableForSQL($sortby, 0, 'id');
			 if (strval($sortascordescselection) == "ASC" || strval($sortascordescselection) == "DESC") {
				$thequery .= " " . $sortascordescselection;
			 }
		}
		else {
			$thequery .= " ORDER BY data.id DESC";
		}
		$thequery .= " LIMIT " . (int) $limitstart . "," . (int) $limit;
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
		$database->setQuery( "SELECT id AS value,CONCAT('#',id,': ',IF(name > '',name,'&lt;" . _MBL_NO_NAME . "&gt;')) AS text FROM #__madblanks_categories WHERE published > 0 AND allow_frontend_editing > 0 ORDER BY id" );
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

		$sortascordesc = array();
		$sortascordesc[] =  JHTML::_('select.option',  'ASC', _MBL_SORT_ASCENDING );
		$sortascordesc[] =  JHTML::_('select.option',  'DESC', _MBL_SORT_DESCENDING );

		$lists['sortascordesc'] = JHTML::_('select.genericlist',  $sortascordesc, 'sortascordesc',
			'class="inputbox" size="1" onchange="document.adminForm.submit();"',
			'value', 'text', $sortascordescselection );
		unset($sortascordesc);

		// "AS" aliases in this MySQL query are turned into variables and used below in the call to selectList()
		if ($access->canEdit) {
			$database->setQuery( "SELECT DISTINCT entered_by AS value, entered_by AS text FROM #__madblanks_records WHERE 1 ORDER BY entered_by" );
		}
		else if ($access->canEditOwn) {
			$database->setQuery( "SELECT DISTINCT entered_by AS value, entered_by AS text FROM #__madblanks_records WHERE entered_by = " . intval($my->id) . " ORDER BY entered_by" );
		}

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

		// we need to know if $categorylimit is in place in order to display the note saying the list is filtered
		$HTML_MadBlanks_frontend = new HTML_MadBlanks_frontend();
		$HTML_MadBlanks_frontend->htmlUserListMadBlanks($option, $rows, $task, $pageNav, $lists, $access, $pageNavBaseLink, $pageNavPageWhatOfWhat, $limitstart, $categorylimit, $authorlimit, $limit, $sortby, $sortascordescselection, $Itemid);
	}
}

/**
 * Publish or unpublish individual Mad Blanks records
 *
 * @param integer $publish publish (1) or unpublish (0) the passed records
 */
function publishMadBlanksRecordsFrontEnd($publish=1) {

	$option = JRequest::getVar('option');
	$cid = JRequest::getVar('cid');

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

      	if (!is_array( $cid ) || count( $cid ) < 1) {
      		$action = $publish ? 'publish' : 'unpublish';
      		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
      		exit;
      	}

      	$cids = implode( ',', $cid );

      	$database->setQuery( "UPDATE #__madblanks_records SET published = ". $publish
      	. "\nWHERE id IN ($cids)"
      	// AND (checked_out=0 OR (checked_out='$my->id')
      	);
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
	$Itemid = JRequest::getVar('Itemid');

	$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit&limit=$limit&limitstart=$limitstart&Itemid=$Itemid"));
}

/**
 * Complete or uncomplete individual Mad Blanks records
 *
 * @param integer $complete complete (1) or uncomplete (0) the passed records
 */
function completeMadBlanksRecordsFrontEnd($complete=1) {

	$option = JRequest::getVar('option');
	$cid = JRequest::getVar('cid');

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

      	if (!is_array( $cid ) || count( $cid ) < 1) {
      		$action = $complete ? 'complete' : 'uncomplete';
      		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
      		exit;
      	}

      	$cids = implode( ',', $cid );

      	$database->setQuery( "UPDATE #__madblanks_records SET completed='$complete'"
      	. "\nWHERE id IN ($cids)"
      	// AND (checked_out=0 OR (checked_out='$my->id')
      	);
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
	$Itemid = JRequest::getVar('Itemid');

	$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit&limit=$limit&limitstart=$limitstart&Itemid=$Itemid"));
}

/**
 * Approve or unapprove individual Mad Blanks records
 *
 * @param integer $approve approve (1) or unapprove (0) the passed records
 */
function approveMadBlanksRecordsFrontEnd($cid, $approve=1, $doredirect=1) {

	$option = JRequest::getVar('option');

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

      	if (!is_array( $cid ) || count( $cid ) < 1) {
      		$action = $approve ? 'approve' : 'unapprove';
      		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
      		exit;
      	}

      	$cids = implode( ',', $cid );

      	// track approved by whom
      	if ($approve == 1 && $my->id) {
      		$approve = $my->id;
      	}

      	$database->setQuery( "UPDATE #__madblanks_records SET approved='$approve'"
      	. "\nWHERE id IN ($cids)"
      	// AND (checked_out=0 OR (checked_out='$my->id')
      	);
      	if (!$database->query()) {
      		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
      		exit();
	}

	if ($doredirect) {
      		// $categorylimit, $sortby, $sortascordesc, and $authorlimit are simply passed through
		//  via hidden form fields to preserve the content of the filter and sort pulldown menu lists
		$categorylimit = JRequest::getVar('categorylimit');
		$authorlimit = JRequest::getVar('authorlimit');
		$sortby = JRequest::getVar('sortby');
		$sortascordesc = JRequest::getVar('sortascordesc');
		$Itemid = JRequest::getVar('Itemid');

		$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit&limit=$limit&limitstart=$limitstart&Itemid=$Itemid"));
      	}
}

/**
 * New Mad Blanks Record
 *
 * This function presents a list of links so the user can choose which category to create a new record for.
 */
function userNewMadBlanksRecord() {

	$configid = JRequest::getVar('configid');

	if (!empty($configid)) {
		userEditMadBlanksRecord();
		return;
	}

	$option = JRequest::getVar('option');
	$Itemid = JRequest::getVar('Itemid');

	// $categorylimit, $sortby, $sortascordesc, and $authorlimit are simply passed through
	//  via hidden form fields to preserve the content of the filter and sort pulldown menu lists
	$categorylimit = JRequest::getVar('categorylimit');
	$authorlimit = JRequest::getVar('authorlimit');
	$sortby = JRequest::getVar('sortby');
	$sortascordesc = JRequest::getVar('sortascordesc');

	$database = &JFactory::getDBO();
	$database->setQuery("SELECT * FROM #__madblanks_categories WHERE published > 0 AND allow_frontend_editing > 0 ORDER BY ordering ASC");
	$rows = $database->loadObjectList();

	$HTML_MadBlanks_frontend = new HTML_MadBlanks_frontend();
	$HTML_MadBlanks_frontend->htmlUserNewMadBlanksRecord($option, $rows, $categorylimit, $sortby, $sortascordesc, $authorlimit, $Itemid);
}

/**
 * Copy an individual Mad Blanks Record
 */
function userCopyMadBlanksRecord() {

	$option = JRequest::getVar('option');
	$cid = JRequest::getVar('cid');

	// $categorylimit, $sortby, $sortascordesc, and $authorlimit are simply passed through
	//  via hidden form fields to preserve the content of the filter and sort pulldown menu lists
	$categorylimit = JRequest::getVar('categorylimit');
	$authorlimit = JRequest::getVar('authorlimit');
	$sortby = JRequest::getVar('sortby');
	$sortascordesc = JRequest::getVar('sortascordesc');
	$Itemid = JRequest::getVar('Itemid');

	$database = &JFactory::getDBO();
	if (!is_array($cid) || count($cid) < 1 || !$cid[0]) {
		echo "<script> alert('" . sprintf(_MBL_MAKE_SELECTION, JString::strtolower(_MBL_COPY)) . "'); window.location.href='index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&authorlimit=$authorlimit&sortby=$sortby&sortascordesc=$sortascordesc&limit=$limit&limitstart=$limitstart&Itemid=$Itemid&mosmsg=" . sprintf(_MBL_MAKE_SELECTION, JString::strtolower(_MBL_COPY)) . "';</script>\n";
		exit();
	}

	$row = new MadBlanksRecord($database);

	if($cid[0]){
		$row -> load($cid[0]);
		$row->id = NULL;
		$row->published = 0; // copied configuration unpublished by default
	}
	else {
		echo "<script> alert('Unable to copy (no cid[0] passed to function)'); window.history.go(-1);</script>\n";
		exit();
	}

	// store it in the db
	if (!$row -> store()) {
		echo "<script> alert('"
			.$row -> getError()
			."'); window.history.go(-1); </script>\n";
		exit();
	}

	// $categorylimit, $sortby, $sortascordesc, and $authorlimit are simply passed through
	//  via hidden form fields to preserve the content of the filter and sort pulldown menu lists
	$categorylimit = JRequest::getVar('categorylimit');
	$authorlimit = JRequest::getVar('authorlimit');
	$sortby = JRequest::getVar('sortby');
	$sortascordesc = JRequest::getVar('sortascordesc');
	$Itemid = JRequest::getVar('Itemid');

	$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit&Itemid=$Itemid"), sprintf(_MBL_RECORD_COPY_MOSMSG, $cid[0], madblanks_mysql_insert_id($database->_resource)));

}

/**
 * Delete Mad Blanks Records
 */
function userDeleteMadBlanksRecords() {

	$option = JRequest::getVar('option');
	$cid = JRequest::getVar('cid');

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
	$authorlimit = JRequest::getVar('authorlimit');
	$sortby = JRequest::getVar('sortby');
	$sortascordesc = JRequest::getVar('sortascordesc');
	$Itemid = JRequest::getVar('Itemid');

	$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php?option=$option&task=userlistrecords&categorylimit=$categorylimit&sortby=$sortby&sortascordesc=$sortascordesc&authorlimit=$authorlimit&Itemid=$Itemid"), $cid[1] ? sprintf(_MBL_RECORD_DELETE_PLURAL_MOSMSG, implode(", ", $cid)) : sprintf(_MBL_RECORD_DELETE_SINGULAR_MOSMSG, $cid[0]));
}

/**
 * Update a field via the single field update module
 */
function singleFieldInput() {

//echo "<pre>"; print_r($_REQUEST); echo "</pre>\n";	//exit;

	$option = JRequest::getVar('option');
	$task = JRequest::getVar('task');
	$thecategory = JRequest::getVar('thecategory');
	$theid = JRequest::getVar('theid');
	$thefield = JRequest::getVar('thefield');
	$single_input = JRequest::getVar('single_input', null, 'default', 'none', JREQUEST_ALLOWHTML);
	$thequery = JRequest::getVar('thequery');
	$createnewok = JRequest::getVar('createnewok');

	// validate input variables before applying them to the SQL
	$theid = intval($theid);

	// $thefield should match pattern data_xx
	if (!preg_match("/data_\d\d/", $thefield)) {
		$thefield = "null";
	}

	//$single_input = mysql_real_escape_string(htmlspecialchars(stripslashes($single_input)));
	$single_input = $database->getEscaped(htmlspecialchars(stripslashes($single_input)));

	$database = &JFactory::getDBO();
	$database->setQuery("SELECT " . $thefield . " FROM #__madblanks_records WHERE id=" . $theid);
//die($database->loadResult());
	if (!$database->loadResult()) {
		$database->setQuery("UPDATE #__madblanks_records AS data, #__madblanks_categories AS cat SET data." . $thefield . " = '" . $single_input . "', data.date_modified = '" . date("YmdHis") . "' WHERE data.configid = cat.id AND data.id=" . $theid . " AND cat.allow_frontend_module_editing > 0");
		if (!$database->query()) {
			// fail silently unless debugging (uncomment 2 lines below to debug)
			//echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			//exit();
      		}
	}

	else {

      		if ($createnewok) {
			// if it didn't work, another website user may have already filled the value in
			//  attempt to create a new record and insert into that
			$row = new MadBlanksRecord($database);

			$newrecordarray['configid'] = $thecategory;
			$newrecordarray[$thefield] = $single_input;
			$newrecordarray['date_entered'] = date("YmdHis"); //save date in MySQL format
			$newrecordarray['date_modified'] = date("YmdHis"); //save date in MySQL format

			// bind it to the table
			if (!$row -> bind($newrecordarray)) {
				//echo "<script> alert('"
				//.$row -> getError()
				//."'); window.history.go(-1); </script>\n";
				//exit();
				echo "<p>binderror: " . $row -> getError();
			}

			if (!$row -> store()) {
				//echo "store error!<br />";
				//echo "<script> alert('"
				//	.$row -> getError()
				//	."'); window.history.go(-1); </script>\n";
				//exit();
				echo "<p>storeerror: " . $row -> getError();
			}
		}

	}

	// return the website user to where he or she started
	$app = &JFactory::getApplication();$app->redirect(sefRelToAbs_madblanks("index.php" . ($thequery ? "?" . $thequery : "")));
}

/**
 * Show module(s) in the content area
 * updated to be Joomla 1.5 compatible CPH 20090523 1.1.0final
 *
 * URL variables:
 * $task showmbmod
 * $mid comma delimited list of module ids
 *
 * Other variables:
 * $moduletype only show a certain type of Mad Blanks Module (mod_madblanks_createsinglerecord for example)
 * $style module style passed to mosLoadModules()
 *
 *	Joomla 1.0:
 * 	0 = (default display) Modules are displayed in a column
 *	1 = Modules are displayed horizontally. Each module is output in the cell of a wrapper table
 *	-1 = Modules are displayed as raw output and without titles
 *	-2 = Modules are displayed in CSS format enclosed by a <div>
 *	-3 = Modules are displayed in a format that allows, for example, stretchable rounded corners. If this $style is used the name of the <div> changes from moduletable to module
 *
 *	Joomla 1.5:
 *	'table' = Wrapped by table (column)
 *	'horz' = Wrapped by table (horizontal)
 *	'xhtml' = Wrapped by Divs
 *	'rounded' = Wrapped by Multiple Divs
 *	'none' = No wrapping (raw output)
 *	'outline' = Add outline to the module (same effect as adding tp=1 to the URL)
 *
 *	Joomla 1.5 template-specific:
 *	For each Joomla 1.5 template, there is a file <Joomla_root>/templates/<template_name>/html/modules.php
 *	 If in that file for the template currently in use there are functions named modChrome_STYLE,
 *	 you can use 'STYLE' as the $style argument below, where STYLE is replaced with the actual function name
 *
 *	 For example, the JA_purity template has such a function named modChrome_jarounded,
 *	 so use 'jarounded' as the $style argument
 *
 * @param mixed $moduletype type of module to show (example: mod_madblanks_createsinglerecord)
 * @param string $style module style; the style is optional
 */
function showMBLCSRModules($moduletype='', $chrome='') { // $chrome -2 default

	// buffer the entire output of this function so that a HTML page title can be added
	//ob_start();
	//echo "<pre>A"; print_r($_REQUEST); echo "Z</pre>\n";//exit;
	// establish a comma delimited list of module ids that we're going to show

	$mid = JRequest::getVar('mid', '');

	global $mainframe;
	$params =& $mainframe->getPageParameters('com_madblanks');
	$param_moduleid = $params->get('moduleid');
	$param_categoryid = $params->get('categoryid');
	if (!$mid && $param_moduleid) {
		$mid = $param_moduleid;
		if (is_numeric($mid) && is_numeric($param_categoryid)) {
			$_REQUEST['mbcsr'.$mid.'configid'] = $param_categoryid;
		}
	}
	//echo "<pre>"; print_r($_REQUEST); echo "</pre>\n";
	// validate the $mid variable
	$mid = preg_replace("/\D/", ",", $mid); // replace anything that is not a decimal digit with a comma

	// make global the Mad Blanks configuration variables for the style of
	//  the DIV surrounding all the modules output, chrome, and modules types allowed
	global $mbModuleWithinComponentStyle, $mbModuleWithinComponentChrome, $mbModuleWithinComponentTypes;

	if (empty($chrome)) {
		$chrome = $mbModuleWithinComponentChrome;
	}

	if (is_string($moduletype)) {
		// replace anything that is not a word character with a comma
		$moduletype = preg_replace("/\W/", ",", $moduletype);
	}

	// convert $moduletype to an array if necessary
	if(!empty($moduletype) && is_string($moduletype)) {
		$moduletype = explode(",", $moduletype);
	}
	else {
		$moduletype = explode(",", $mbModuleWithinComponentTypes);

	}

	// if it's still empty for some reason, use hard coded defaults:
	if(empty($moduletype) || (count($moduletype) == 1 && empty($moduletype[0]))) {
		// allow all types of Mad Blanks modules to appear this way by default
		$moduletype = array('mod_madblanks_createsinglerecord', 'mod_madblanks_singlefieldinput', 'mod_madblanks_display', 'mod_madblanks_menu');
	}

	if (class_exists('JFactory')) { // Joomla 1.5.x implementation


		if (empty($mid)) {
			//echo "1 ";
			echo _MBL_MODULE_UNAVAILABLE;
		}

		else {
			$db =& JFactory::getDBO();

			$db->setQuery("SELECT title,module FROM #__modules WHERE id IN (" . $mid . ") AND published = 1 ORDER BY FIELD( id, " . $mid . ")");
			$rows = $db->loadObjectList();

			$pageTitleAnnexation = ''; // initialize;

			echo "<div style=\"" . $mbModuleWithinComponentStyle . "\">\n";
			foreach ($rows as $row) {
				// confirm module type was requested
				if (in_array($row->module, $moduletype)) {

					$module = JModuleHelper::getModule(str_replace('mod_', '', $row->module), $row->title);

					$document = &JFactory::getDocument();
					$renderer = $document->loadRenderer('module');

					echo $renderer->render($module, array("style" => $chrome));

					$pageTitleAnnexation .= ($pageTitleAnnexation ? ", " : "") . $row->title;
				}
			}
			echo "</div>\n";

			if ($pageTitleAnnexation) {
				setMadBlanksPageTitle($pageTitleAnnexation);
			}
		}
	}

	// The showMBLCSRModules() function will not work in Joomla 1.5 because it is missing the initModules() function
	// should never get here
	else if (!function_exists('initModules')) {
		echo "<em>Your version of Joomla! does not support this method of viewing modules.</em>";
		return;
	}

	else { // Joomla 1.0.x implementation

		if (empty($mid)) {
			//echo "1 ";
			echo _MBL_MODULE_UNAVAILABLE;
		}

		else {

			$showthesequizzes = explode(",", $mid);

			//echo "\$showthesequizzes before is_numeric<br />";
			//echo "<pre>";
			//print_r($showthesequizzes);
			//echo "</pre>";

			// remove non-numeric module ids from the array
			$j = count($showthesequizzes);
			for ($i = 0; $i < $j; $i++) {
				//echo "looking at $i";
				if (!(is_numeric($showthesequizzes[$i]))) {
					//echo ", unsetting $i";
					unset($showthesequizzes[$i]);
				}
				//echo "<br />";
			}

			//echo "\$showthesequizzes after is_numeric<br />";
			//echo "<pre>";
			//print_r($showthesequizzes);
			//echo "</pre>";


			if (empty($showthesequizzes)) {
				//echo "2 ";
				echo _MBL_MODULE_UNAVAILABLE;
			}

			else {

				$modulesIndexedByID = array();
				$allModules =& initModules();

				//echo "\$GLOBALS['_MOS_MODULES']<br />";
				//echo "<pre>";
				//print_r($GLOBALS['_MOS_MODULES']);
				//echo "</pre>";

				// $GLOBALS['_MOS_MODULES'] contains an array of module positions (left, right, top, etc.)
				foreach ($GLOBALS['_MOS_MODULES'] as $thispositionkey => $thisposition) {
					// $thisposition contains an array of module objects, each of which contains descriptive information about a module
					foreach ($thisposition as $moduleindex => $moduleobject) {
						$modulesIndexedByID[$moduleobject->id] = array("position" => $thispositionkey, "object_index" => $moduleindex, "type" => $moduleobject->module);
					}
				}

				//echo "\$modulesIndexedByID<br />";
				//echo "<pre>";
				//print_r($modulesIndexedByID);
				//echo "</pre>";

				//echo "\$moduletype<br />";
				//echo "<pre>";
				//print_r($moduletype);
				//echo "</pre>";

				foreach ($showthesequizzes as $showthisquiz) { // $showthisquiz is one of the id numbers we are searching for

					//echo "<br /><br />showthisquiz is $showthisquiz";
					// only load modules of the proper type this way (as set by the function argument)
					if (isset($modulesIndexedByID[(int)$showthisquiz]) && in_array($modulesIndexedByID[(int)$showthisquiz]['type'], $moduletype)) {
						//echo "<br />the type is A" . $modulesIndexedByID[(int)$showthisquiz]['type'] . "B";
						$GLOBALS['_MOS_MODULES']['madblanksloadmodule'][] = $GLOBALS['_MOS_MODULES'][$modulesIndexedByID[(int)$showthisquiz]['position']][$modulesIndexedByID[(int)$showthisquiz]['object_index']];
					}
				}

				//echo "<br /><br />\$GLOBALS['_MOS_MODULES'] final time<br />";
				//echo "<pre>";
				//print_r($GLOBALS['_MOS_MODULES']);
				//echo "</pre>";

				if (empty($GLOBALS['_MOS_MODULES']['madblanksloadmodule'])) {
					//echo "3 ";
					echo _MBL_MODULE_UNAVAILABLE;
				}

				else {
					$header_titles = array(); // initialize
					foreach($GLOBALS['_MOS_MODULES']['madblanksloadmodule'] as $one_module) {
						if ($one_module->showtitle) {
							$header_titles[] = $one_module->title;
						}
					}
					$header_titles = implode(", ", $header_titles);
					//echo "header_titles are $header_titles";
					setMadBlanksPageTitle($header_titles);

					echo "<div class=\"module\" style=\"" . $mbModuleWithinComponentStyle . "\">\n";
					mosLoadModules('madblanksloadmodule', $chrome);
					echo "\n</div>\n";

				}
			}
		}
	}
}