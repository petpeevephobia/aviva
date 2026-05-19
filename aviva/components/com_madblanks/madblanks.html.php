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
 * This file is for generating HTML for the frontend.
 * 
 * file version 1.7.1 20100920
 *
 * @package Mad_Blanks_Component
 * @author Chris Hallett <chris@madblanks.org>
 * @copyright Chris Hallett March 1, 2011
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 
 * @version 1.4.2
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// enumerate global variables for Joomla! 1.5
global $mbComponentTitle, $mbCustomTitleText, $mbShowFooterComponentHomeLink, $mbFieldCount, $mbColor1, $mbColor2,
$mbFrontendInputFieldSize, $mbEnteredByLongFormat, $mbApplyContentPlugins, $mbEnableShowAllLink,
$mbEnableCategoriesLinks, $mbEnableRandomizerLinks, $mbEnableSpecificRecordBox, $mbEnableEditRecordsLink,
$mbEnableCreateSingleRecordLinks, $mbEnableRecordListShowAll;

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


if (isset($madBlanksMenuOption)) {
	$option = $madBlanksMenuOption; // added $option here for compatibility with mod_madblanks_menu
}
else {
	$option = JRequest::getVar('option'); // added $option here for compatibility with mod_madblanks_menu
}

require_once($mainframe->getPath('class', $option)); // added $option here for compatibility with mod_madblanks_menu

/**
 * @package Mad_Blanks_Component
 */
class HTML_MadBlanks_frontend {

/**
 * Show a Mad Blanks menu page with links to view featured records, all records, records
 * from published categories, randomly assembled records from published categories configured
 * for randomization, form input field to go to a specific record number, and link to edit 
 * records if logged in user is authorized
 *
 * @param string $option Joomla option string from URL
 * @param string $theerrormsg error message to display to the website user
 * @param object &$rows published category rows from the categories table
 * @param object &$featuredrows an object containing rows of records as determined by 
 * the $mbFeaturedRecords configuration variable
 * @param object $access access control list data
 * @param integer $Itemid
 * @param integer $somethingtodisplay
 * @param string $alternateformname string to replace the default form name (each module has a different name so that every form on the page is unique)
 */
function htmlShowMadBlanksDefault($option, $theerrormsg, &$rows, &$featuredrows, $access, $Itemid, $somethingtodisplay, $alternateformname='', &$csrlist) {
	global $mbComponentTitle, $mbCustomTitleText, $mbEnableShowAllLink, $mbEnableCategoriesLinks,
	$mbEnableRandomizerLinks, $mbEnableSpecificRecordBox, $mbEnableEditRecordsLink,
	$mbEnableCreateSingleRecordLinks;
	
	echo "\n<form class=\"mblform\" action=\"index.php\" method=\"post\" name=\"" . (empty($alternateformname) ? "adminForm" : $alternateformname) . "\">";

	if (!empty($mbComponentTitle)) {
		echo "<div class=\"mbcomponenttitle\">" . htmlspecialchars(stripslashes($mbComponentTitle)) . "</div>\n";
	}

	if (!empty($mbCustomTitleText)) {
		$randomtagresultssofar = array(); // array to cache random tag results
		echo "<div class=\"mbcustomtitletext\">" . replaceSpecialCharacters(stripslashes($mbCustomTitleText), 0, null, 0, null, null, $randomtagresultssofar) . "</div>\n";
	}
	
	if ($theerrormsg){
		echo "<div class=\"madblanksusermessage\">$theerrormsg</div>\n";
	}
	
	if (!empty($featuredrows)){
		?>
		<p><?php echo _MBL_SHOW_FEATURED . " " . _MBL_RECORD_NAME_PLURAL . ":"; ?></p>
		<?php 
	
		echo "<ul class=\"mblul\">\n";
		foreach ($featuredrows as $featuredrow) {
			foreach ($rows as $row){
				if ($row->id == $featuredrow->configid) {
					$thedefaulttitle = $row->default_title;
				}
			}
			echo "<li class=\"mblli\"><a class=\"mbla\" href=\"" . sefRelToAbs_madblanks("index.php?option=$option&amp;task=showmadblanks&id=" . $featuredrow->id . "&amp;Itemid=$Itemid") . "\">" . ($featuredrow->title ? $featuredrow->title : $thedefaulttitle)  . " (#" . $featuredrow->id . ")</a></li>\n";
		}
		echo "</ul>\n";
	}
	
	// CPH 20090523 added for 1.1.0final
	if ($mbEnableCreateSingleRecordLinks) {
		
		echo "<p class=\"mblp\">" . _MBL_CHOOSE_CSR_CATEGORY . "</p>";
	
		if (!empty($csrlist)) {
			echo "<ul class=\"mblul\">\n";
			foreach ($csrlist as $link) {
				echo "<li class=\"mblli\">" . $link . "</li>\n";
			}
			echo "</ul>\n";
		}
		else {
			echo "<div class=\"madblanksusermessageleft\">" . _MBL_NO_CSR_LINKS_TO_DISPLAY . "</div>\n";
		}
	}

	if ($mbEnableShowAllLink) {
		?>

		<p class="mblp"><?php echo _MBL_SHOW_ALL . " " . _MBL_RECORD_NAME_PLURAL . ":"; ?></p>

		<?php
		if (!empty($somethingtodisplay)) {	
			echo "<ul class=\"mblul\">\n";
			echo "<li class=\"mblli\"><a class=\"mbla\" href=\"" . sefRelToAbs_madblanks("index.php?option=$option&amp;task=showmadblanks&amp;Itemid=$Itemid") . "\">" .  _MBL_SHOW_ALL . "</a></li>\n";
		}
		else {
			echo "<div class=\"madblanksusermessageleft\">" . _MBL_NO_RECORDS_TO_DISPLAY . "</div>\n";
		}
		echo "</ul>\n";
	}	
	
	if ($mbEnableCategoriesLinks) {
		?>
		<p class="mblp"><?php echo _MBL_CHOOSE_CATEGORY; ?></p>
	
		<?php 
		if (!empty($rows) && !empty($somethingtodisplay)) {
			echo "<ul class=\"mblul\">\n";
			foreach ($rows as $row) {
				echo "<li class=\"mblli\"><a class=\"mbla\" href=\"" . sefRelToAbs_madblanks("index.php?option=$option&amp;task=showmadblanks&amp;category=" . $row->id . "&amp;Itemid=$Itemid") . "\">" . /* sprintf(_MBL_SHOW_CATEGORY_NUMBER, $row->id) . */ ($row->name ? $row->name : sprintf(_MBL_SHOW_CATEGORY_NUMBER, $row->id)) . "</a></li>\n";
			}
			echo "</ul>\n";
		}
		else {
			echo "<div class=\"madblanksusermessageleft\">" . _MBL_NO_CATEGORIES_TO_DISPLAY . "</div>\n";
		}
	}	
	?>
	
	<?php 
	if ($mbEnableRandomizerLinks) {
		$HTML_MadBlanks_frontend = new HTML_MadBlanks_frontend();
		$HTML_MadBlanks_frontend->htmlMakeRandomizerLinkList($option, $Itemid); 
	} 
	
	
	if ($mbEnableSpecificRecordBox || ($mbEnableEditRecordsLink && ($access->canEdit || $access->canEditOwn))) {
		?>

		<p class="mblp"><?php echo _MBL_OTHER_OPTIONS; ?></p>

		<?php
		if (!empty($somethingtodisplay)) {	
			?>

			<ul class="mblul">
			<li class="mblli"><?php 
			if ($mbEnableSpecificRecordBox) { 
				echo _MBL_GO_TO_SPECIFIC_RECORD; ?>&nbsp; <input size="5" name="therecord" value="" class="inputbox mbltherecord" /> <input type="submit" name="gotorecord" value="<?php echo _MBL_SUBMIT_BUTTON; ?>" class="button mblsubmitbutton" /></li>
				<?php 
			}
			
			if ($mbEnableEditRecordsLink && ($access->canEdit || $access->canEditOwn)) {
			?>		
				<li class="mblli"><a class="mbla" href="<?php echo sefRelToAbs_madblanks("index.php?option=$option&amp;task=userlistrecords" . ($Itemid ? "&Itemid=$Itemid" : "")); ?>"><?php echo _MBL_EDIT . " " . _MBL_RECORD_NAME_PLURAL; ?></a></li>
			<?php
			}
			?>
			</ul>

			<?php 
		}
		else {
			echo "<div class=\"madblanksusermessageleft\">" . _MBL_NO_RECORDS_TO_DISPLAY . "</div>\n";
		}
	}	
	?>
	
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	</form>
<?php
	return;
}	

/**
 * Main HTML display routine 
 *
 * The following variables are collected in the $displayrow object for each record
 * to display, collected in the $displayrows array, and passed to this HTML generator function,
 * 
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
 *
 * If there are a number of records per page equal to or less than the total, we don't need pageNav,
 * so it hasn't been defined in madblanks.php... check for the existence of $pageNav before
 * attempting to echo any page navigation links
 *
 * @param object $displayrows
 * @param string $option Joomla option string from URL
 * @param string $task Joomla task string from URL
 * @param string $thetitlestring title to display at the top of the page
 * @param object $pageNav Joomla! page navigation data
 * @param string $pageNavBaseLink base link to return to the same data, without page navigation variables included
 * @param string $pageNavPageWhatOfWhat which page this is out of how many
 */
function htmlShowMadBlanks(&$displayrows, $option, $task, $thetitlestring, $Itemid, &$pageNav, $pageNavBaseLink=null, $pageNavPageWhatOfWhat=null) {

	global $mbComponentTitle, $mbCustomTitleText, $mbShowFooterComponentHomeLink, 
	$mbApplyContentPlugins, $mbEnableRecordListShowAll;
	
	// if plugin (mambot) application is configured for all output at once mode,
	//  then prepare the plugin buffer
	if ($mbApplyContentPlugins > 1) {
		openPluginBuffer();
	}	

	if (!empty($mbComponentTitle)) {
		echo "<div class=\"mbcomponenttitle\">" . htmlspecialchars(stripslashes($mbComponentTitle)) . "</div>\n";
	}

	if (!empty($mbCustomTitleText)) {
		$randomtagresultssofar = array(); // array to cache random tag results
		echo "<div class=\"mbcustomtitletext\">" . replaceSpecialCharacters(stripslashes($mbCustomTitleText), 0, null, 0, null, null, $randomtagresultssofar) . "</div>\n";
	}
	
	echo "<input type=\"hidden\" name=\"option\" value=\"" . $option . "\" />
	<input type=\"hidden\" name=\"task\" value=\"" . $task . "\" />\n";

	if (!empty($thetitlestring)) {
		echo "<div class=\"thetitlestring\">" . $thetitlestring . "</div>\n";
	}

	if ($pageNav) {

		// 1.4.0 Beta 1 CPH 20100106
		$app = &JFactory::getApplication();
		$router = &$app->getRouter();
	        $uri = new JURI($pageNavBaseLink);
        	$router->setVars($uri->_vars);

		// 1.2.1 CPH 20090907 fix page navigation in J1.5 after different Display# selected
		//$writepageslinks = $pageNav->getPagesLinks($pageNavBaseLink);
		$writepageslinks = $pageNav->getPagesLinks();
		
		?>

		<p class="mblp" align="center"><?php echo $pageNavPageWhatOfWhat . " &nbsp; " 
		. $writepageslinks; 
		
	
		if ($mbEnableRecordListShowAll) {
			?> &nbsp; <a class="mbla" href="<?php echo sefRelToAbs_madblanks($pageNavBaseLink . "&amp;showall=true"); ?>" class="pagenav"><?php echo _MBL_SHOW_ALL; ?></a>
			<?php
		}
	
	}
	
	foreach($displayrows as $displayrow) {
		
		// This if-else block of code allows us to alternate the background color of the displayed records
		//  using default Joomla css classes
		if (!isset($alternatingrowclass) || $alternatingrowclass == "sectiontableentry2") {
			$alternatingrowclass =  "sectiontableentry1";
		}
		else {
			$alternatingrowclass =  "sectiontableentry2";
		}

		// if plugin (mambot) application is configured for per record mode,
		//  then prepare the plugin buffer
		if ($mbApplyContentPlugins == 1) {
			openPluginBuffer();
		}	
		
		// In the div below, we assign two classes to the same div
		// TO MAKE YOUR OWN LAYOUT, recreate the <div> below with your own HTML
		
		// The following PHP variables are available for the record layout:
		// $displayrow->record_id
		// $displayrow->category_id
		// $displayrow->category_title
		// $displayrow->random_button
		// $displayrow->record_title
		// $displayrow->created_date
		// $displayrow->entered_by
		// $displayrow->modified_by
		// $displayrow->modified_date
		// $displayrow->content_string
		// $displayrow->home_link
		// $displayrow->self_link_string
		// $displayrow->text
		// $displayrow->scodata1
		// $displayrow->scodata2
		// { $displayrow->scodataN } where N equals up to 100, if present in the <prefix>_madblanks_records table in the database
		// $displayrow->self_url
		// { $displayrow->row } unlike the others, this is a PHP object that contains details about the record


		//echo "<br />The displayrow count is " . count($displayrows);
		/* BEGIN EXPERIMENTAL CODE FOR JCOMMENTS INTEGRATION
		$comment_link = '&nbsp;'; // initialize
		$do_main_comments = false; // initialize
		$comments = JPATH_BASE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
		if (file_exists($comments)) {
			require_once($comments);
			if (count($displayrows) > 1) {

				$comments_count = JComments::getCommentsCount($displayrow->record_id, 'com_madblanks');
				
				//echo JComments::showComments($displayrow->record_id, 'com_madblanks', 'the title');
				$comment_link = '<div class="mblcommentslink"><a href="' . $displayrow->self_url . '#mblresult' . $displayrow->record_id . '">View/Add Comments (' . $comments_count . ')</a></div>';


			}
			else if (count($displayrows) == 1){
				$do_main_comments = true;
			}
		} */

		?>
		<div class="mbdisplayblock <?php echo $alternatingrowclass; ?>">
		<table class="mbltable" border="0" width="100%" cellpadding="5" cellspacing="4">

			<tr class="mbltr">
			<td class="mbltd" colspan="2" align="left" valign="top">
				<table class="mbltable" border="0" width="100%">
				
					<tr class="mbltr">
					<td class="mbltd" align="left" valign="top"><span class="mblrowkey" style="font-size: xx-small;"><?php if (isset($displayrow->originalkey)) { echo $displayrow->originalkey; } ?></span></td>
					<td align="right" class="madblankstitle mbltd"><?php echo $displayrow->category_title; ?></td>
					</tr>
				
				</table>
			</td>
			<td class="mbltd" align="right"><?php echo $displayrow->random_button; ?></td>
			</tr>

			<tr class="mbltr">
			<td align="left" colspan="2" class="madblankstitle mbltd"><?php echo $displayrow->record_title; ?></td>
			<td align="right" class="madblankstitle mbltd"><?php echo $displayrow->created_date; ?></td>
			</tr>

			<tr class="mbltr">
			<td class="mbltd" width="33%" align="left"><?php echo $displayrow->entered_by; ?></td>
			<td class="mbltd" width="34%" align="center"><?php echo $displayrow->modified_by; ?></td>
			<td class="mbltd" width="33%" align="right"><?php echo $displayrow->modified_date; ?></td>
			</tr>

			<tr class="mbltr">
			<td colspan="3" class="madblankstext mbltd"><a name="mblresult<?php echo $displayrow->record_id; ?>"></a><?php echo $displayrow->text; ?></td>
			</tr>

			<tr class="mbltr">
			<td class="mbltd" colspan="2"><?php echo $displayrow->home_link; ?></td>
			<?php /* SUBSTITUTE JCOMMENTS LINK <td class="mbltd"><?php echo $comment_link; ?></td> */ ?>
			<?php /* <td class="mbltd">&nbsp;</td> */ ?>
			<td align="right" class="madblankslink mbltd"><?php echo $displayrow->self_link_string; ?></td>
			</tr>

		</table>
		
		
		
		<?php /* JCOMMENTS SHOW MAIN COMMENTS FOR THIS ITEM
		if ($do_main_comments) {
			//echo "<br />calling comments for " . $displayrow->record_id;		
			$lang =& JFactory::getLanguage();
			$lang->load('com_jcomments');
			echo JComments::show($displayrow->record_id, 'com_madblanks', 'Mad Blanks Records Comments');
		}
		*/
		?>
		
		</div>

	<?php
		// if plugin (mambot) application is configured for per record mode,
		//  then close the plugin buffer
		if ($mbApplyContentPlugins == 1) {
			closePluginBuffer();
		}	

	} // end foreach loop
	
	//echo "<h1>pageNavBaseLink is $pageNavBaseLink</h1>";
	
	if ($pageNav) {
	
		// 1.4.0 Final 20100429 adminForm needed only for $pageNav->getLimitBox()
		echo "<form class=\"mblform\" action=\"$pageNavBaseLink\" method=\"post\" name=\"madblankspagenav\">";

	?>
		<p class="mblp" align="center"><?php echo _MBL_DISPLAY_NR . " " . $pageNav->getLimitBox($pageNavBaseLink)
		. " &nbsp; " . $pageNav->getPagesCounter() . "<br />" . $writepageslinks;
		
		if ($mbEnableRecordListShowAll) {
			echo " &nbsp; <a href=\"" . sefRelToAbs_madblanks($pageNavBaseLink . "&amp;showall=true") . "\" class=\"pagenav\">" . _MBL_SHOW_ALL . "</a>";
		}
		?>
		
		</p>
	<?php 
	
		// close adminForm needed only for $pageNav->getLimitBox()
		echo "</form>"; // close the form after the page nav links and pulldown menu
	}
	// Show link to component home at the bottom of the page if enabled in the configuration
	echo $mbShowFooterComponentHomeLink ? "<p class=\"mblp\" align=\"center\"><a class=\"mbla\" href=\"" . sefRelToAbs_madblanks("index.php?option=" . $option . ($Itemid ? "&amp;Itemid=$Itemid" : "")) . "\">" . _MBL_COMPONENT_HOME_LINK_TEXT . "</a></p>" : "";
	
	// if plugin (mambot) application is configured for all output at once mode,
	//  then close the plugin buffer
	if ($mbApplyContentPlugins > 1) {
		closePluginBuffer();
	}
	
} // end function htmlShowMadBlanks

/**
 * Display list of links for each published category... click one to display a randomized record for that category
 *
 * @param string $option Joomla option string from URL
 */
function htmlMakeRandomizerLinkList($option, $Itemid='') {
	$database = &JFactory::getDBO(); 
	echo "<p class=\"mblp\">" . _MBL_CHOOSE_RANDOM_CATEGORY . "</p>\n";
	$database->setQuery("SELECT id,name FROM #__madblanks_categories WHERE published > 0 AND allow_frontend_viewing > 0 AND allow_randomizer > 0 AND frontend_show_in_list > 0 ORDER BY date_created ASC");
	$rows = $database->loadObjectList();
	if (!empty($rows)) {
		echo "<ul class=\"mblul\">\n";
		foreach ($rows as $row) {
			echo "<li class=\"mblli\"><a class=\"mbla\" href=\"" . sefRelToAbs_madblanks("index.php?option=$option" . ($Itemid ? "&amp;Itemid=$Itemid" : "") . "&amp;task=showmadblanks&amp;random=true&amp;category=" . $row->id) . "\">" . _MBL_SHOW_RANDOM_CATEGORY . " " . ($row->name ? $row->name : _MBL_CATEGORY_NAME . " #" . $row->id) . "</a></li>\n";
		}
		echo "</ul>";
	}
	else {
		echo "<div class=\"madblanksusermessageleft\">" . _MBL_NO_RANDOM_CATEGORY . "</div>\n";
	}	
	return;
}	

/**
 * Display front end error message
 *
 * @param string $theerror the error message to display
 */
function htmlDisplayFrontEndError($theerror, $option) {
	header('HTTP/1.0 404 Not Found'); // 1.4.0 Final CPH 20100418
	global $mbShowFooterComponentHomeLink;
	$Itemid = JRequest::getVar('Itemid');
	echo "<div class=\"madblanksusermessage\">" . $theerror . "</div>";
	echo $mbShowFooterComponentHomeLink ? "<p class=\"mblp\" align=\"center\"><a class=\"mbla\" href=\"" . sefRelToAbs_madblanks("index.php?option=" . $option . "&amp;Itemid=$Itemid") . "\">" . _MBL_COMPONENT_HOME_LINK_TEXT . "</a></p>" : "";	
}	

/**
 * Edit an individual Mad Blanks record (frontend)
 * 
 * @param string $option Joomla option string from URL
 * @param object &$row the row from the database for an individual record
 * @param object &$configrow the row from the database for the record's category
 * @param integer $configid the category id number for this record
 * @param string $categorylimit simply passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $authorlimit simply passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $sortby simply passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $sortascordesc simply passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param integer $limit how many records to display
 * @param integer $limitstart how many records to skip when displaying records
 * @param object $access access control list data
 */
function htmlUserEditMadBlanksRecord ($option, &$row, &$configrow, $configid, $categorylimit, $authorlimit, $sortby, $sortascordesc, $limit, $limitstart, $access, $Itemid) {

if (empty($configrow)) {
	echo "<div class=\"message\">" . _MBL_INVALID_CATEGORY . "</div>";
}
	
//mosCommonHTML::loadOverlib();
JHTML::_('behavior.tooltip');

global $mbFrontendInputFieldSize;
if (!isset($mbFrontendInputFieldSize)) {
	$mbFrontendInputFieldSize = 40;
}

	if (!isset($row->configid)) {
		if ($configid) {
			$row->configid = $configid;
		}
		else {
			die ('Unknown configuration. Go back.');
		}	
	}	
	
	//mosCommonHTML::loadCalendar();
	JHTML::_('behavior.calendar');
?>

<form class="mblform" action="index.php?option=<?php echo $option; /* Include option=$option to get the mosPathway() $Itemid path to work */ ?>" method="post" name="adminForm">
<table class="mbltable" class="adminheading">
<tr class="mbltr">
<th class="mblth">
<?php 
$thepagetitle = $row->id ? _MBL_EDIT : _MBL_NEW;
$thepagetitle .= " " . _MBL_RECORD_NAME;
$thepagetitle .= $row->id ? " #" . $row->id . " " : " ";
$thepagetitle .= _MBL_USING_CATEGORY;
$thepagetitle .= " #" . $row->configid . " (" . getCategoryFieldByID($row->configid) . ")";
echo $thepagetitle;
setMadBlanksPageTitle($thepagetitle);
?>
</th>
<td class="mbltd" align="right">
	<table class="mbltable" cellpadding="0" cellspacing="3" border="0" id="toolbar">

	<tr class="mbltr" height="60" valign="middle" align="center">
	
	<?php
	if (!$row->approved && $row->id && $access->canEdit) {
	?>
		<td class="mbltd">
		
		<?php
		/* 
		
		<a class="toolbar" onmouseover="return overlib('<center><?php echo _MBL_QUICK_APPROVE; ?></center>', CAPTION, '');" onmouseout="return nd();" href="javascript:submitbutton('quickapproverecord');" >
		<img src="<?php echo JUri::base(); ?>/images/apply_f2.png" alt="<?php echo _MBL_APPROVE; ?>" align="middle" name="quickapproverecord" border="0" />
		echo JHTML::_('tooltip', $tooltip, $title, $image, $text, $href, $link);
		
		*/
		
		echo JHTML::_('tooltip', JText::_('_MBL_QUICK_APPROVE'), '', '../../../images/apply_f2.png', '', "javascript:submitbutton('quickapproverecord');", true);
		
		?>
		
		</a>
		</td>
	<?php
	}
	?>
	
	<td class="mbltd">
	
	<?php
	
	/*
	<a class="toolbar" onmouseover="return overlib('<center><?php echo _MBL_SAVE; ?></center>', CAPTION, '');" onmouseout="return nd();" href="javascript:submitbutton('saverecord');" >
	<img src="<?php echo JUri::base(); ?>/images/save_f2.png" alt="<?php echo _MBL_SAVE; ?>" align="middle" name="save" border="0" /></a>
	*/
	
	echo JHTML::_('tooltip', JText::_('_MBL_SAVE'), '', '../../../images/save_f2.png', '', "javascript:submitbutton('saverecord');", true);
	
	?>
	</td>
	<td class="mbltd">
	
	<?php
	
	/*
	<a class="toolbar" onmouseover="return overlib('<center><?php echo _MBL_CANCEL; ?></center>', CAPTION, '');" onmouseout="return nd();" href="javascript:submitbutton('canceleditrecord');" >
	<img src="<?php echo JUri::base(); ?>/images/cancel_f2.png" alt="<?php echo _MBL_CANCEL; ?>" align="middle" name="cancel" border="0" /></a>
	*/
	
	echo JHTML::_('tooltip', JText::_('_MBL_CANCEL'), '', '../../../images/cancel_f2.png', '', "javascript:submitbutton('canceleditrecord');", true);
	
	?>
	</td>
	</tr>
	</table>
</td>
</tr>
</table>

<div class="userinputwide">
<table border="0" cellpadding="3" cellspacing="0" class="adminlist mbcrunch">

<?php

if ($access->canEdit) { // if user has administrator privileges

?>

<tr class="sectiontableentry1 mbltr">
<td class="mbltd">&nbsp;</td>
<td class="mbltd" align="right"><b><?php echo _MBL_APPROVED; ?></b>:</td>
<td class="mbltd">
<?php
// if already approved, preserve the id number of the user who approved it
// if not already approved, and yes option is chosen now, set to -1 and change it to current user's id in the save record function
$my = &JFactory::getUser();

//$thearray = array(mosHTML::makeOption('0', _MBL_NO),mosHTML::makeOption(($row->approved ? $row->approved : $my->id), _MBL_YES));
$thearray = array(JHTML::_('select.option', '0', _MBL_NO), JHTML::_('select.option', ($row->approved ? $row->approved : $my->id), _MBL_YES));
echo "<pre>"; print_r($thearray); echo "</pre>\n";
//echo mosHTML::radioList($thearray, "approved", "", $row->id ? $row->approved : $my->id); // new records aleady approved by default in the backend
echo JHTML::_('select.radiolist', $thearray, "approved", '', 'value', 'text', $row->id ? $row->approved : $my->id); // new records aleady approved by default in the backend

//if ($row->approved) { // Show which user approved by
//        printf(_MBL_APPROVED_BY, getUserNameByID($row->approved, 1) . " [" . getUserNameByID($row->approved, 0) ."]");
//}
?>
</td>
<td class="mbltd">&nbsp;</td>
</tr>

<?php
} // end 'if' conditional

else {
?>
<input type="hidden" name="approved" value="<?php echo $row->approved; ?>" />
<?php
}
?>

<tr class="sectiontableentry2 mbltr">
<td class="mbltd">&nbsp;</td>
<td class="mbltd" align="right"><b><?php echo _MBL_COMPLETED; ?></b>:</td>
<td class="mbltd"><?php echo JHTML::_('select.booleanlist', 'completed', '', ($row->completed ? '1' : '0')); ?></td>
<td class="mbltd">&nbsp;</td>
</tr>

<tr class="sectiontableentry1 mbltr">
<td class="mbltd">&nbsp;</td>
<td align="right" class="mbltd"><b><?php echo ucwords(_MBL_PUBLISHED); ?></b>:</td>
<td class="mbltd"><?php echo JHTML::_('select.booleanlist',  'published', '', ($row->published ? '1' : '0')); ?></td>
<td class="mbltd">&nbsp;</td>
</tr>

<tr class="sectiontableentry2 mbltr">
<td class="mbltd">&nbsp;</td>
<td class="mbltd" align="right"><?php echo _MBL_TITLE; ?>:</td>
<td class="mbltd" colspan="2"><input size="<?php echo $mbFrontendInputFieldSize; ?>" name="title" class="inputbox mbltitle" value="<?php echo $row->title; ?>" /></td>
</tr>

<tr class="sectiontableentry1 mbltr">
<td class="mbltd">&nbsp;</td>
<td class="mbltd" align="right"><?php echo _MBL_AUTHOR_ALIAS ?>:</td>
<td class="mbltd" colspan="2"><input size="<?php echo $mbFrontendInputFieldSize; ?>" name="author_alias" class="inputbox mblauthoralias" value="<?php echo $row->author_alias; ?>" /></td>
</tr>

<tr class="sectiontableentry2 mbltr">
<td class="mbltd" width="5%">&nbsp;</td>
<td class="mbltd" width="30%" align="right"><?php echo _MBL_CHANGE_CREATION_DATE . " " . _MBL_CREATION_DATE_FORMAT; ?></td>
<td class="mbltd" width="25%" nowrap="nowrap">
<input class="inputbox mbldateentered" type="text" name="date_entered" id="date_entered" size="25" maxlength="19" value="<?php echo $row->date_entered; ?>" />
<input type="reset" class="button mblreset" value="..." onClick="return showCalendar('date_entered', 'y-mm-dd');">
</td>
<td class="mbltd" width="40%">&nbsp;</td>
</tr>

<table border="0" cellpadding="5" cellspacing="0" class="adminlist mbcrunch" style="width: 100%;">

<tr class="mbltr">
<th class="mblth" width="5"><?php echo _MBL_FIELD; ?> #</th>
<th class="mblth"><?php echo _MBL_FIELD_NAME; ?></th>
<th class="mblth"><?php echo _MBL_BEFORE_TEXT; ?></th>
<th class="mblth"><?php echo _MBL_FIELD_TEXT; ?></th>
<th class="mblth"><?php echo _MBL_AFTER_TEXT; ?></th>
</tr>

<?php 
// for loop represents the number of fields in the database
global $mbFieldCount; // $mbFieldCount set at the top of this file
$therowclass = null; // initialize

for ($i=1; $i <= $mbFieldCount; $i++) {

	$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
	
	$configarray = parseDataConfigString($configrow->{"data_".$theindex."_config"});

	if ($configrow->{"data_".$theindex."_use"}) {
		//$activefieldlist .= $activefieldlist ? ",'" . $theindex . "'" : "'" . $theindex . "'";
		$editingafield = true;

		$therowclass = $therowclass!=2 ? 2 : 1; // alternating row color each time we output a row

		$blankarray = array();
		//$beforestring = $configrow->{"data_".$theindex."_before"} ? replaceSpecialCharacters($configrow->{"data_".$theindex."_before"}, 0, null, 0, null, null, $blankarray) : "&nbsp;";
		$beforestring = $configrow->{"data_".$theindex."_before"} ? $configrow->{"data_".$theindex."_before"} : "&nbsp;";
		//$afterstring = $configrow->{"data_".$theindex."_after"} ? replaceSpecialCharacters($configrow->{"data_".$theindex."_after"}, 0, null, 0, null, null, $blankarray) : "&nbsp;";
		$afterstring = $configrow->{"data_".$theindex."_after"} ? $configrow->{"data_".$theindex."_after"} : "&nbsp;";
		?>

		<tr class="sectiontableentry<?php echo $therowclass ?> mbltr">
		<td class="mbltd"><?php echo $i; ?>
		<td class="mbltd"><?php echo $configrow->{"data_".$theindex."_name"} ? $configrow->{"data_".$theindex."_name"} : "Data # " . $i ?>: </td>
		<td class="mbltd" align="right"><font color="#0000ff"><?php echo $beforestring ?></font></td>
		<td class="mbltd"><?php 
		
		if ($configarray['usetextarea'] == 1) {
			echo "<textarea class=\"inputbox\" cols=\"" . ($configarray['textareawidth'] ? $configarray['textareawidth'] : ($mbDefaultTextareaWidth ? $mbDefaultTextareaWidth : 45)) . "\" rows=\"" . ($configarray['textareaheight'] ? $configarray['textareaheight'] : ($mbDefaultTextareaHeight ? $mbDefaultTextareaHeight : 3)) . "\" name=\"data_" . $theindex . "\">" . $row->{"data_".$theindex} . "</textarea>\n";
		}
		else {
			echo "<input class=\"inputbox\" size=\"" . $mbFrontendInputFieldSize . "\" name=\"data_" . $theindex . "\" value=\"" . convertToQuotLtGt($row->{"data_".$theindex}) . "\" />";
		}	
		
		?></td>
		<td class="mbltd"><font color="#0000ff"><?php echo $afterstring; ?></font></td>
		</tr>

	<?php
	} /* end if statement */

} /* end for loop */ 
$therowclass = $therowclass!=2 ? 2 : 1; // alternating row color based on the last value from the for loop

if (empty($editingafield)) {
	echo "<tr class=\"mbltr\"><td class=\"mbltd\" colspan=\"4\">" . _MBL_NO_ACTIVE_FIELDS . "</td></tr>\n";
}
?>

<tr class="mbltr"><td class="mbltd" colspan="4"><hr /></td></tr>

<tr class="sectiontableentry<?php echo $therowclass; ?> mbltr">
<td class="mbltd" colspan="2"><?php echo _MBL_NOTES_NOT_VISIBLE_ON_WEBSITE; ?></td>
<td class="mbltd">&nbsp;</td>
<td class="mbltd"><textarea class="inputbox" cols="<?php echo $mbFrontendInputFieldSize - 8; ?>" rows="10" name="notes"><?php echo $row->notes; ?></textarea></td>
<td class="mbltd">&nbsp;</td>
</tr>

</table>
</div>

<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
<input type="hidden" name="configid" value="<?php echo $row->configid; ?>" />

<?php /* data that does not appear in the simplified frontend edit form is stored in hidden form fields  */ ?>
<input type="hidden" name="entered_by" value="<?php echo $row->entered_by; ?>" />
<input type="hidden" name="date_modified" value="<?php echo $row->date_modified; ?>" />
<input type="hidden" name="modified_by" value="<?php echo $row->modified_by; ?>" />
<input type="hidden" name="show_category_title" value="<?php echo $row->show_category_title; ?>" />
<input type="hidden" name="show_individual_title" value="<?php echo $row->show_individual_title; ?>" />
<input type="hidden" name="show_entered_by" value="<?php echo $row->show_entered_by; ?>" />
<input type="hidden" name="show_date_created" value="<?php echo $row->show_date_created; ?>" />
<input type="hidden" name="show_modified_by" value="<?php echo $row->show_modified_by; ?>" />
<input type="hidden" name="show_modified_date" value="<?php echo $row->show_modified_date; ?>" />
<input type="hidden" name="show_self_link" value="<?php echo $row->show_self_link; ?>" />
<input type="hidden" name="show_self_button" value="<?php echo $row->show_self_button; ?>" />
<input type="hidden" name="show_home_link" value="<?php echo $row->show_home_link; ?>" />
<input type="hidden" name="alwaysshowbeforeandafter" value="<?php echo $row->alwaysshowbeforeandafter; ?>" />
<input type="hidden" name="show_in_random" value="<?php echo $row->show_in_random; ?>" />
<input type="hidden" name="sticky" value="<?php echo $row->sticky; ?>" />
<input type="hidden" name="ordering" value="<?php echo $row->ordering; ?>" />

<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="categorylimit" value="<?php echo $categorylimit; ?>" />
<input type="hidden" name="authorlimit" value="<?php echo $authorlimit; ?>" />
<input type="hidden" name="sortby" value="<?php echo $sortby; ?>" />
<input type="hidden" name="sortascordesc" value="<?php echo $sortascordesc; ?>" />
<input type="hidden" name="limit" value="<?php echo $limit; ?>" />
<input type="hidden" name="limitstart" value="<?php echo $limitstart; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />

</form>

<?php

}

/**
 * Preview a record before saving it, with options to reedit and cancel.
 *
 * @param string $option Joomla option string from URL
 * @param object &$row the row from the database for the record to preview
 * @param string $content_string the data in the record assembled into a string as it will be displayed on the website
 * @param string $categorylimit simply passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $authorlimit simply passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $sortby simply passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $sortascordesc simply passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param integer $limit how many records to display
 * @param integer $limitstart how many records to skip when displaying records
 */ 
function htmlSaveMadBlanksRecordPreview($option, &$row, $content_string, $categorylimit, $authorlimit, $sortby, $sortascordesc, $limit, $limitstart, $Itemid) {
	
	//mosCommonHTML::loadOverlib();
	JHTML::_('behavior.tooltip');
		
	setMadBlanksPageTitle(_MBL_PREVIEW_SCREEN);
	?>
	<form class="mblform mblpreview" action="index.php?option=<?php echo $option; /* Include option=$option to get the mosPathway() $Itemid path to work */ ?>" method="post" name="adminForm">
		<div align="right">
		<table cellpadding="0" cellspacing="3" border="0" id="toolbar">
		<tr height="60" valign="middle" align="center">
		<td>&nbsp;</td>
		<td>
		<a class="toolbar" href="javascript:document.adminForm.previewdone.value=1; submitbutton('saverecord');" onmouseover="return overlib('<center><?php echo _MBL_SAVE; ?></center>', CAPTION, '');" onmouseout="return nd();" href="javascript:submitbutton('quickapproverecord');">
		<img src="<?php echo JUri::base(); ?>/images/save_f2.png" alt="Save" align="middle" name="save" border="0" /></a>
		</td>
		<td>
		<a class="toolbar" href="javascript:submitbutton('usereditrecord');" onmouseover="return overlib('<center><?php echo _MBL_EDIT; ?></center>', CAPTION, '');" onmouseout="return nd();" href="javascript:submitbutton('quickapproverecord');">
		<img src="<?php echo JUri::base(); ?>/images/edit_f2.png" alt="Edit" align="middle" name="edit" border="0" /></a>
		</td>
		<td>
		<a class="toolbar" href="javascript:submitbutton('canceleditrecord');" onmouseover="return overlib('<center><?php echo _MBL_CANCEL; ?></center>', CAPTION, '');" onmouseout="return nd();" href="javascript:submitbutton('quickapproverecord');">
		<img src="<?php echo JUri::base(); ?>/images/cancel_f2.png" alt="Cancel" align="middle" name="cancel" border="0" /></a>
		</td>
		</tr>
		</table>
		</div>
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
	<input type="hidden" name="reeditpreview" value="1" />
	<input type="hidden" name="previewdone" value="0" />
	<input type="hidden" name="categorylimit" value="<?php echo $categorylimit; ?>" />
	<input type="hidden" name="authorlimit" value="<?php echo $authorlimit; ?>" />
	<input type="hidden" name="sortby" value="<?php echo $sortby; ?>" />
	<input type="hidden" name="sortascordesc" value="<?php echo $sortascordesc; ?>" />
	<input type="hidden" name="limit" value="<?php echo $limit; ?>" />
	<input type="hidden" name="limitstart" value="<?php echo $limitstart; ?>" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />


	</form>

	<table border="0" cellpadding="3" cellspacing="0" class="adminheading">
	<tr><th><?php echo _MBL_PREVIEW_SCREEN ?></th></tr>
	</table>

	<p class="madblanksusermessage"><?php echo _MBL_PREVIEW_NOTICE; ?></p>	


	<div style="margin: auto; max-width: 60%; min-height: 1in; padding: 2em;"><?php echo $content_string; ?></div>

	<?php
}

/**
 * List Mad Blanks records (frontend)
 * 
 * @param string $option Joomla option string from URL
 * @param object &$rows the rows from the database for the categories
 * @param string $task component task string from URL
 * @param object $pageNav Joomla page navigation data (which page number of how many pages, number of records displayed per page)
 * @param array &$lists the component needs to know which filters are in place when showing the list again
 * @param object $access access control list data
 * @param string $pageNavBaseLink base link to return to the same data, without page navigation variables included
 * @param string $pageNavPageWhatOfWhat which page this is out of how many
 * @param integer $limitstart how many records to skip when displaying records
 * @param string $categorylimit passed to this function htmlso we can notify user if the list is filtered
 * @param string $authorlimit passed to this function htmlso we can notify user if the list is filtered
 * @param integer $limit how many records to display
 * @param string $sortby simply passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $sortascordesc simply passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $Itemid Joomla identifier used to associate a web page with a menu item
 * @param integer $substring_length the number of characters to show in data previews for list items
 */
function htmlUserListMadBlanks($option, &$rows, $task, $pageNav, &$lists, $access, $pageNavBaseLink=null, $pageNavPageWhatOfWhat=null, $limitstart=null, $categorylimit=NULL, $authorlimit=NULL, $limit=null, $sortby=NULL, $sortascordesc=NULL, $Itemid=null, $substring_length=255) {

	// set HTML <title> data if set in configuration
	setMadBlanksPageTitle(_MBL_LIST_RECORDS_TITLE);
	//mosCommonHTML::loadOverlib();
	JHTML::_('behavior.tooltip');
	global $mainframe, $mbShowFooterComponentHomeLink;
	$my = &JFactory::getUser();

?>
<form class="mblform" action="index.php?option=<?php echo $option; /* Include option=$option to get the mosPathway() $Itemid path to work */ ?>" method="post" name="adminForm">

<table class="mbltable" align="right" cellpadding="0" cellspacing="3" border="0" id="toolbar">

	<tr height="60" valign="middle" align="center">
	
	<td>
	<?php
	/*
	<a class="toolbar" onmouseover="return overlib('<center><?php echo _MBL_COMPLETE; ?></center>', CAPTION, '');" onmouseout="return nd();" 
		href="javascript:submitbutton('completerecord');" >
	<img src="<?php echo JUri::base(); ?>/images/apply_f2.png" alt="<?php echo _MBL_COMPLETE; ?>" align="middle" name="completerecord" border="0" /></a>
	*/
	echo JHTML::_('tooltip', JText::_('_MBL_COMPLETE'), '', '../../../images/apply_f2.png', '', "javascript:submitbutton('completerecord');", true);
	?>
	</td>
	<td>
	<?php
	/*
	<a class="toolbar"onmouseover="return overlib('<center><?php echo _MBL_UNCOMPLETE; ?></center>', CAPTION, '');" onmouseout="return nd();" 
		href="javascript:submitbutton('uncompleterecord');" >
	<img src="<?php echo JUri::base(); ?>/images/unpublish_f2.png" alt="<?php echo _MBL_UNCOMPLETE; ?>" align="middle" name="uncompleterecord" border="0" /></a>
	*/
	echo JHTML::_('tooltip', JText::_('_MBL_UNCOMPLETE'), '', '../../../images/unpublish_f2.png', '', "javascript:submitbutton('uncompleterecord');", true);
	?>
	</td>


	<?php
	if ($access->canEdit) {
	?>
		<td>
		<?php
		/*
	
		<a class="toolbar" onmouseover="return overlib('<center><?php echo _MBL_APPROVE; ?></center>', CAPTION, '');" onmouseout="return nd();" 
			href="javascript:submitbutton('approverecord');" >
		<img src="<?php echo JUri::base(); ?>/images/apply_f2.png" alt="<?php echo _MBL_APPROVE; ?>" align="middle" name="approverecord" border="0" /></a>
		
		
		*/
		echo JHTML::_('tooltip', JText::_('_MBL_APPROVE'), '', '../../../images/apply_f2.png', '', "javascript:submitbutton('approverecord');", true);
		?>
		</td>
		<td>
		<?php
		/*
	
		<a class="toolbar" onmouseover="return overlib('<center><?php echo _MBL_UNAPPROVE; ?></center>', CAPTION, '');" onmouseout="return nd();" 
			href="javascript:submitbutton('unapproverecord');" >
		<img src="<?php echo JUri::base(); ?>/images/unpublish_f2.png" alt="<?php echo _MBL_UNAPPROVE; ?>" align="middle" name="unapproverecord" border="0" /></a>
		*/
		echo JHTML::_('tooltip', JText::_('_MBL_UNAPPROVE'), '', '../../../images/unpublish_f2.png', '', "javascript:submitbutton('unapproverecord');", true);
		?>
		</td>
	<?php
	}
	?>
	
	<td>
	<?php
	/*
	
	<a class="toolbar" onmouseover="return overlib('<center><?php echo _MBL_PUBLISH; ?></center>', CAPTION, '');" onmouseout="return nd();" 
		href="javascript:submitbutton('publishrecord');" >
	<img src="<?php echo JUri::base(); ?>/images/publish_f2.png" alt="<?php echo _MBL_PUBLISH; ?>" align="middle" name="publishrecord" border="0" /></a>
	*/
	echo JHTML::_('tooltip', JText::_('_MBL_PUBLISH'), '', '../../../images/publish_f2.png', '', "javascript:submitbutton('publishrecord');", true);
	?>
	</td>
	<td>
	<?php
	/*
	
	<a class="toolbar" onmouseover="return overlib('<center><?php echo _MBL_UNPUBLISH; ?></center>', CAPTION, '');" onmouseout="return nd();" 
		href="javascript:submitbutton('unpublishrecord');" >
	<img src="<?php echo JUri::base(); ?>/images/unpublish_f2.png" alt="<?php echo _MBL_UNPUBLISH; ?>" align="middle" name="unpublishrecord" border="0" /></a>
	*/
	echo JHTML::_('tooltip', JText::_('_MBL_UNPUBLISH'), '', '../../../images/unpublish_f2.png', '', "javascript:submitbutton('unpublishrecord');", true);
	?>
	</td>
	<td>
	<?php
	/*
	<a class="toolbar" onmouseover="return overlib('<center><?php echo _MBL_NEW; ?></center>', CAPTION, '');" onmouseout="return nd();" 
		href="javascript:submitbutton('usernewrecord');" >
	<img src="<?php echo JUri::base(); ?>/images/new_f2.png" alt="<?php echo _MBL_NEW; ?>" align="middle" name="usernewrecord" border="0" /></a>
	*/
	echo JHTML::_('tooltip', JText::_('_MBL_NEW'), '', '../../../images/new_f2.png', '', "javascript:submitbutton('usernewrecord');", true);
	?>
	</td>
	<td>
	<?php
	/*
	<a class="toolbar" onmouseover="return overlib('<center><?php echo _MBL_EDIT; ?></center>', CAPTION, '');" onmouseout="return nd();" 
		href="javascript:submitbutton('usereditrecordcid');" >
	<img src="<?php echo JUri::base(); ?>/images/edit_f2.png" alt="<?php echo _MBL_EDIT; ?>" align="middle" name="usereditrecordcid" border="0" /></a>
	*/
	echo JHTML::_('tooltip', JText::_('_MBL_EDIT'), '', '../../../images/edit_f2.png', '', "javascript:submitbutton('usereditrecordcid');", true);
	?>
	</td>
	<td>
	<?php
	/*
	<a class="toolbar" onmouseover="return overlib('<center><?php echo _MBL_COPY; ?></center>', CAPTION, '');" onmouseout="return nd();" 
		href="javascript:submitbutton('usercopyrecord');" >
	<img src="<?php echo JUri::base(); ?>/administrator/images/copy_f2.png" alt="<?php echo _MBL_COPY; ?>" align="middle" name="usercopyrecord" border="0" /></a>
	*/
	echo JHTML::_('tooltip', JText::_('_MBL_COPY'), '', '../../../administrator/images/copy_f2.png', '', "javascript:submitbutton('usercopyrecord');", true);
	?>
	</td>
	<td>
	<?php
	/*
	
	<a class="toolbar" onmouseover="return overlib('<center><?php echo _MBL_DELETE; ?></center>', CAPTION, '');" onmouseout="return nd();" 
		href="javascript:submitbutton('userdeleterecords');" >
	<img src="<?php echo JUri::base(); ?>/administrator/images/delete_f2.png" alt="<?php echo _MBL_DELETE; ?>" align="middle" name="userdeleterecords" border="0" /></a>
	*/
	echo JHTML::_('tooltip', JText::_('_MBL_DELETE'), '', '../../../administrator/images/delete_f2.png', '', "javascript:submitbutton('userdeleterecords');", true);
	?>
	</td>
	</tr>

</table>

<br clear="all" />
	
<table width="100%" border="0" align="right">
<tr>
	<th style="background-position: 0% 0%; vertical-align: top;"><div style="margin-top: 10px"><h2><?php echo _MBL_LIST_RECORDS_TITLE; ?></h2></div></th>
	<td align="right">
	
	<table border="0" class="mbcrunch" align="right">
		<tr>
		<td align="right">
		<?php 
		if ($categorylimit || $authorlimit) { 
			echo '<span class="filtered_warning">' . _MBL_LIST_IS_FILTERED . '&nbsp;&#8594;&nbsp;&nbsp;&nbsp;</span>';
		} 
		echo $lists['categorylimit'];
		echo $lists['authorlimit'];
		?>
		</td>
		</tr>
		<tr>
		<td align="right">
		<?php
		echo "&nbsp;&nbsp;&nbsp;" . _MBL_SORT_BY . "&nbsp;&nbsp;";
		echo $lists['sortby'];
		?>
		</td>
		</tr>
		<tr>
		<td align="right">
		<?php
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
		value="<?php echo _MBL_SUBMIT_BUTTON; ?>" class="button" onClick="submitbutton('usereditrecord');return false;" />
		</td>
		</tr>
	</table>
	
	</td>
</tr>
</table>	

<?php
	if ($pageNav) {
	
		$app = &JFactory::getApplication();
		$router = &$app->getRouter();
	        $uri = new JURI($pageNavBaseLink);
        	$router->setVars($uri->_vars);
	
	?>
		<br clear="all" /><div class="mbcrunch" align="center"><?php echo $pageNavPageWhatOfWhat . " &nbsp; " 
		. str_replace(array("&lt; ", " &gt;"), array("&lt;&nbsp;", "&nbsp;&gt;"), $pageNav->getPagesLinks()); ?> &nbsp; <a href="<?php echo sefRelToAbs_madblanks($pageNavBaseLink . "&amp;showall=true"); ?>" class="pagenav"><?php echo _MBL_SHOW_ALL; ?></a></div>
	<?php
	}
	?>

<div class="userinputwide">
<table cellpadding="4" cellspacing="0" border="0" class="adminlist mbcrunch">
<tr><th colspan="12" align="center" style="background: url(); border-style: hidden;"><?php echo "&nbsp;"; /* $pageNav->getPagesCounter() .  " &nbsp; &nbsp; &nbsp; " . $pageNav->getPagesLinks(); */ ?></th></tr>
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
<th><?php echo ucwords(_MBL_SORT_PULLDOWN_COMPLETED); ?></th>
<th><?php echo ucwords(_MBL_SORT_PULLDOWN_APPROVED); ?></th>
<th><?php echo ucwords(_MBL_SORT_PULLDOWN_PUBLISHED); ?></th>
</tr>

<?php
	if ($rows) {
		$k = 1;
		for($i=0; $i < count( $rows ); $i++) {
		$row = $rows[$i];
		jimport('joomla.html.html.grid');
		$checked = str_replace('src="images/checked_out.png"', 'src="administrator/images/checked_out.png"', JHTML::_('grid.checkedout', $row, $i) /* mosCommonHTML::CheckedOutProcessing( $row, $i )*/ );
	   ?>
		<tr class="sectiontableentry<?php echo $k; ?>">
		<td><?php echo $i + 1 + $limitstart; ?></td>
		<td><?php echo $checked; ?></td>
		<td><?php echo (intval($row->date_entered) ? JHTML::_('date', $row->date_entered, JText::_('DATE_FORMAT_LC2')) : "<em>&lt;" . _MBL_NO_DATE . "&gt;</em>"); ?></td>
		<td align="center"><?php echo (trim($row->configid) ? $row->configid : "<em>&lt;" . _MBL_NO . " " . _MBL_CATEGORY_NAME . "&gt;</em>"); ?></td>
		<td><?php echo trim($row->id) ? $row->id : "<em>&lt;" . _MBL_NO . " " . _MBL_ID . "&gt;</em>"; ?></td>
		<td><?php global $mbEnteredByLongFormat; echo $row->entered_by ? getUserNameByID($row->entered_by, $mbEnteredByLongFormat) : ($row->author_alias ? $row->author_alias : "<em>&lt;" . _MBL_NO_AUTHOR . "&gt;</em>"); ?></td>
		<td>
		<?php
		if ( $row->checked_out && ( $row->checked_out != $my->id )) {
			echo wordwrap(trim($row->title) ? $row->title : "<em>&lt;" . JString::strtolower(_MBL_NO . " " . _MBL_TITLE) . "&gt;</em>", 30, "\n", 1);
		}
		else {
			$link =  'index.php?option=com_madblanks&task=usereditrecord&id=' . $row->id;
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
			if ($Itemid) {
				$link .= "&Itemid=" . $Itemid;
			}	
			?>
			<a href="<?php echo sefRelToAbs_madblanks($link); ?>"><?php echo wordwrap((trim($row->title) ? $row->title : "<em>&lt;" . JString::strtolower(_MBL_NO . " " . _MBL_TITLE) . "&gt;</em>"), 30, "\n", 1); ?></a>
			<?php
		}
		?>
		</td>
		<td><?php echo wordwrap((trim($row->data_01) ? (JString::strlen($row->data_01) >= $substring_length + 6 ? JString::substr($row->data_01, 0, $substring_length) . ".&nbsp;.&nbsp;." : JString::substr($row->data_01, 0, $substring_length + 6)) : "<em>&lt;" . _MBL_NO_DATA . "&gt;</em>"), 30, "\n", 1); ?></td>	
		<td><?php echo wordwrap((trim($row->data_02) ? (JString::strlen($row->data_02) >= $substring_length + 6 ? JString::substr($row->data_02, 0, $substring_length) . ".&nbsp;.&nbsp;." : JString::substr($row->data_02, 0, $substring_length + 6)) : "<em>&lt;" . _MBL_NO_DATA . "&gt;</em>"), 30, "\n", 1); ?></td>
		<td align="center">
		<?php
			if ($row->completed == "1") {
				echo "<a href=\"javascript: void(0);\" onClick=\"return listItemTask('cb$i','uncompleterecord')\"><img src=\"administrator/images/tick.png\" border=\"0\" /></a>";
			} 
			else {
				echo "<a href=\"javascript: void(0);\" onClick=\"return listItemTask('cb$i','completerecord')\"><img src=\"administrator/images/publish_x.png\" border=\"0\" /></a>";
			}
		?>
		</td>

		   <?php
			echo "<td align=\"center\">";
			if ($row->approved > 0) {
				echo ($access->canEdit ? "<a href=\"javascript: void(0);\" onClick=\"return listItemTask('cb$i','unapproverecord')\">" : "") . "<img src=\"administrator/images/tick.png\" border=\"0\" />" . ($access->canEdit ? "</a>" : "");
			}
			else {
				echo ($access->canEdit ? "<a href=\"javascript: void(0);\" onClick=\"return listItemTask('cb$i','approverecord')\">" : "") . "<img src=\"administrator/images/publish_x.png\" border=\"0\" />" . ($access->canEdit ? "</a>" : "");
			}
			echo "</td>\n";
		   ?>

		<td align="center">
	   <?php
		if ($row->published == "1") {
		echo "<a href=\"javascript: void(0);\" onClick=\"return listItemTask('cb$i','unpublishrecord')\"><img src=\"administrator/images/tick.png\" border=\"0\" /></a>";
		} else {
		echo "<a href=\"javascript: void(0);\" onClick=\"return listItemTask('cb$i','publishrecord')\"><img src=\"administrator/images/publish_x.png\" border=\"0\" /></a>";
		}
	   ?>
		</td>
		<?php $k = $k == 1 ? 2 : 1; ?>
		</tr>
<?php 		}
	}
	else {
		echo '<div class="madblanksusermessage">' . _MBL_NO_RECORDS_USER . "</div>\n";
	}	

?>
</table>
</div>

<?php 

if ($pageNav) {
	?>
		<div class="mbcrunch" align="center"><?php echo _MBL_DISPLAY_NR . " " . $pageNav->getLimitBox($pageNavBaseLink)
		. " &nbsp; " . $pageNav->getPagesCounter() . "<br />" 
		. str_replace(array("&lt; ", " &gt;"), array("&lt;&nbsp;", "&nbsp;&gt;"), $pageNav->getPagesLinks($pageNavBaseLink))
		. " &nbsp; <a href=\"" . sefRelToAbs_madblanks($pageNavBaseLink . "&amp;showall=true") . "\" class=\"pagenav\">" . _MBL_SHOW_ALL . "</a>"; ?>
		</div>
	<?php 
	}
	?>

<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="<?php echo $task; ?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="hidemainmenu" value="0" />
<input type="hidden" name="configid" value="0" />
<?php /* limit already in pulldown <input type="hidden" name="limit" value="<?php echo $limit; ?>" /> */ ?>
<input type="hidden" name="limitstart" value="<?php echo $limitstart; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
</form> 

<?php
echo $mbShowFooterComponentHomeLink ? "<p align=\"center\"><a href=\"" . sefRelToAbs_madblanks("index.php?option=" . $option . "&amp;Itemid=$Itemid") . "\">" . _MBL_COMPONENT_HOME_LINK_TEXT . "</a></p>" : "";
}


/**
 * Create a new Mad Blanks record (frontend)
 * 
 * @param string $option Joomla option string from URL
 * @param string $categorylimit simply passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $sortby simply passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $sortascordesc simply passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 * @param string $authorlimit simply passed through via hidden form fields to preserve the content of the filter and sort pulldown menu lists
 */
function htmlUserNewMadBlanksRecord($option, &$rows, $categorylimit, $sortby, $sortascordesc, $authorlimit, $Itemid) {
	
	// set HTML <title> data if set in configuration
	setMadBlanksPageTitle(ucwords(_MBL_NEW . " - " . _MBL_RECORD_NAME . " " . _MBL_CATEGORY_NAME_PLURAL));
	
	//mosCommonHTML::loadOverlib(); // for the cancel button
	JHTML::_('behavior.tooltip');

	?>
	<form action="index.php?option=<?php echo $option; /* Include option=$option to get the mosPathway() $Itemid path to work */ ?>" method="post" name="adminForm">
	
	<table align="right" cellpadding="0" cellspacing="3" border="0" id="toolbar">
	<tr height="60" valign="middle" align="center">
	<td>
	<a class="toolbar" onmouseover="return overlib('<center><?php echo _MBL_CANCEL; ?></center>', CAPTION, '');" onmouseout="return nd();" 
		href="javascript:submitbutton('userlistrecords');" >
	<img src="<?php echo JUri::base(); ?>/images/cancel_f2.png" alt="<?php echo _MBL_CANCEL; ?>" align="middle" name="userlistrecords" border="0" /></a>
	</td>
	</tr>
	</table>
	
	<ul>
	<?php
	$didbreak = false;
	if (!empty($rows)) {
		foreach ($rows as $row) {
			if ($row->published == 0 && !$didbreak) {
				echo "\n</ul>\n<br />\n<ul>\n";
				$didbreak = true;
			}
			echo "<li><a href=\"" . sefRelToAbs_madblanks("index.php?option=$option&amp;task=usereditrecord&amp;configid=$row->id&amp;categorylimit=$categorylimit&amp;sortby=$sortby&amp;sortascordesc=$sortascordesc&amp;authorlimit=$authorlimit&amp;Itemid=$Itemid") . "\">" . sprintf(_MBL_NEW_RECORD_LINK_TEXT, $row->name ? _MBL_CATEGORY_NAME . " #" . $row->id . ": " . $row->name : _MBL_CATEGORY_NAME . " #" . $row->id) . "</a></li>\n";
		}
	}
	else {
		echo "<div class=\"madblanksusermessage\">" . _MBL_NO_CATEGORIES_NEW_RECORD . "</div>\n";
	}
	?>
	</ul>
	<input type="hidden" name="categorylimit" value="<?php echo $categorylimit; /* pass on filter data for list */ ?>" />
	<input type="hidden" name="sortby" value="<?php echo $sortby; /* pass on filter data for list */ ?>" />
	<input type="hidden" name="sortascordesc" value="<?php echo $sortascordesc; /* pass on filter data for list */ ?>" />
	<input type="hidden" name="authorlimit" value="<?php echo $authorlimit; /* pass on filter data for list */ ?>" />
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
	</form>
	<?php
}	

} // end class HTML_MadBlanks_frontend