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
 * This file contains classes and support functions.
 * 
 * file version 1.24.0 20110301
 *
 * @package Mad_Blanks_Component
 * @author Chris Hallett <chris@madblanks.org>
 * @copyright Chris Hallett March 1, 2011
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 
 * @version 1.4.2
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// enumerate global variables for Joomla! 1.5
global $mbAllowBlankRandomFields, $mbShowHTMLTitleTagData, $mbComponentTitle, $mbFieldCount, $mbHideCheckedOut,
$mbAcceptGoogleChartTOS, $mbIncludeCustomizationFile;

if (file_exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php')) {
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

/**
 * @package Mad_Blanks_Component
 */
class MadBlanksCategory extends JTable {
/* define needed variables from the database here with initial values as needed */

	var $id = null;
	var $name = null;
	var $default_title = null;
	var $name_for_randomized = null;
	var $show_home_link_for_randomized = 1;
	var $date_created = null;
	var $notes = null;
	var $allow_randomizer = 0;
	var $show_category_title = 0;
	var $show_individual_title = 1;  
	var $show_entered_by = 1; // Default 1 (Yes) as of 1.2.1 CPH 20090830 	
	var $show_date_created = 1;  	
	var $show_modified_by = 0;  	
	var $show_modified_date = 0;  	
	var $show_self_link = 1;  	
	var $show_self_button = 0;  
	var $show_home_link = 0;
	
	var $allow_html_input = 0;
	var $allow_frontend_editing = 1;
	var $allow_frontend_module_editing = 1;
	var $allow_frontend_viewing = 1;
	var $allow_frontend_module_viewing = 1;
	var $frontend_show_in_list = 1;
	var $frontend_show_in_csr_list = 1;
	var $allow_random_tag = 1;
	var $allow_lookup_tag = 1;
	
	var $frontend_auto_approve = 0;
	var $allow_module_approve = 1; // Default 1 (Yes) as of 1.2.1 CPH 20090830
	var $allow_module_publish = 1;
	var $alwaysshowbeforeandafter = 0;
	
	var $ordering = null;
	var $published = null;
	var $checked_out = null;
	var $checked_out_time = null;
	var $master_css = null;
	var $container_div_css = null;
	
	var $data_01_name = null; 
	var $data_01_partofspeech = null;
	var $data_01_use = 0;  
	var $data_01_before = null;  
	var $data_01_after = null;
	var $data_01_config = null;
		
	var $data_02_name = null; 
	var $data_02_partofspeech = null;
	var $data_02_use = 0;  
	var $data_02_before = null;  
	var $data_02_after = null;  
	var $data_02_config = null;
	
	var $data_03_name = null; 
	var $data_03_partofspeech = null;
	var $data_03_use = 0;  
	var $data_03_before = null;  
	var $data_03_after = null;  
	var $data_03_config = null;
	
	var $data_04_name = null; 
	var $data_04_partofspeech = null;
	var $data_04_use = 0;  
	var $data_04_before = null;  
	var $data_04_after = null;  
	var $data_04_config = null;
	
	var $data_05_name = null; 
	var $data_05_partofspeech = null;
	var $data_05_use = 0;  
	var $data_05_before = null;  
	var $data_05_after = null;  
	var $data_05_config = null;
	
	var $data_06_name = null; 
	var $data_06_partofspeech = null;
	var $data_06_use = 0;  
	var $data_06_before = null;  
	var $data_06_after = null;  
	var $data_06_config = null;
	
	var $data_07_name = null; 
	var $data_07_partofspeech = null;
	var $data_07_use = 0;  
	var $data_07_before = null;  
	var $data_07_after = null;  
	var $data_07_config = null;
	
	var $data_08_name = null; 
	var $data_08_partofspeech = null;
	var $data_08_use = 0;  
	var $data_08_before = null;  
	var $data_08_after = null;  
	var $data_08_config = null;
	
	var $data_09_name = null; 
	var $data_09_partofspeech = null;
	var $data_09_use = 0;  
	var $data_09_before = null;  
	var $data_09_after = null;  
	var $data_09_config = null;
	
	var $data_10_name = null; 
	var $data_10_partofspeech = null;
	var $data_10_use = 0;  
	var $data_10_before = null;  
	var $data_10_after = null;  
	var $data_10_config = null;
	
	var $data_11_name = null; 
	var $data_11_partofspeech = null;
	var $data_11_use = 0;  
	var $data_11_before = null;  
	var $data_11_after = null;  
	var $data_11_config = null;
		
	var $data_12_name = null; 
	var $data_12_partofspeech = null;
	var $data_12_use = 0;  
	var $data_12_before = null;  
	var $data_12_after = null;  
	var $data_12_config = null;
		
	var $data_13_name = null; 
	var $data_13_partofspeech = null;
	var $data_13_use = 0;  
	var $data_13_before = null;  
	var $data_13_after = null;  
	var $data_13_config = null;
		
	var $data_14_name = null; 
	var $data_14_partofspeech = null;
	var $data_14_use = 0;  
	var $data_14_before = null;  
	var $data_14_after = null;  
	var $data_14_config = null;
		
	var $data_15_name = null; 
	var $data_15_partofspeech = null;
	var $data_15_use = 0;  
	var $data_15_before = null;  
	var $data_15_after = null;  
	var $data_15_config = null;
		
	var $data_16_name = null; 
	var $data_16_partofspeech = null;
	var $data_16_use = 0;  
	var $data_16_before = null;  
	var $data_16_after = null;  
	var $data_16_config = null;
		
	var $data_17_name = null; 
	var $data_17_partofspeech = null;
	var $data_17_use = 0;  
	var $data_17_before = null;  
	var $data_17_after = null;  
	var $data_17_config = null;
	
	var $data_18_name = null; 
	var $data_18_partofspeech = null;
	var $data_18_use = 0;  
	var $data_18_before = null;  
	var $data_18_after = null;  
	var $data_18_config = null;
		
	var $data_19_name = null; 
	var $data_19_partofspeech = null;
	var $data_19_use = 0;  
	var $data_19_before = null;  
	var $data_19_after = null;  
	var $data_19_config = null;
		
	var $data_20_name = null; 
	var $data_20_partofspeech = null;
	var $data_20_use = 0;  
	var $data_20_before = null;  
	var $data_20_after = null;  
	var $data_20_config = null;
		
	var $data_21_name = null; 
	var $data_21_partofspeech = null;
	var $data_21_use = 0;  
	var $data_21_before = null;  
	var $data_21_after = null;  
	var $data_21_config = null;
		
	var $data_22_name = null; 
	var $data_22_partofspeech = null;
	var $data_22_use = 0;  
	var $data_22_before = null;  
	var $data_22_after = null;  
	var $data_22_config = null;
		
	var $data_23_name = null; 
	var $data_23_partofspeech = null;
	var $data_23_use = 0;  
	var $data_23_before = null;  
	var $data_23_after = null;  
	var $data_23_config = null;
		
	var $data_24_name = null; 
	var $data_24_partofspeech = null;
	var $data_24_use = 0;  
	var $data_24_before = null;  
	var $data_24_after = null;  
	var $data_24_config = null;
		
	var $data_25_name = null; 
	var $data_25_partofspeech = null;
	var $data_25_use = 0;  
	var $data_25_before = null;  
	var $data_25_after = null;  
	var $data_25_config = null;
	
	var $restrict_viewing_to_creator = 0;
	var $allow_viewing_creatorless_records = 1;
	var $admins_see_all_creators = 0;
	
	var $default_score_script = null; // added in 1.1.0 Beta 3
	var $archive_score_script = null; // added in 1.1.0 Final
	var $css_archive_score_script = "border: 1px solid lightgray; background-color: azure; padding: 5px; margin-top: 1em;"; // added in 1.1.0 Final
	var $hide_record_content = 0;
	
	var $category_message1 = null; // added in 1.2.0 20090807
	var $css_category_message1 = null; // added in 1.2.0 20090807
	var $category_message2 = null; // added in 1.2.0 20090807
	var $css_category_message2 = null; // added in 1.2.0 20090807
	
	var $user_logged_save = 'new'; // added in 1.4.0 Beta 2 20100217
	var $user_not_logged_save = 'new'; // added in 1.4.0 Beta 2 20100217
	var $select_random_fields_number = null; // added in 1.4.0 Beta 4 20100326
		
	function __construct(&$db){
		parent::__construct('#__madblanks_categories', 'id', $db);
	}
}

/**
 * @package Mad_Blanks_Component
 */
class MadBlanksRecord extends JTable {
/* define needed variables from the var $database here with initial values as needed */

	var $id = null;
	var $configid = null;
	var $date_entered = null;
	var $entered_by = null;
	var $author_alias = null;
	var $date_modified = null;
	var $modified_by = null;
	var $title = null;
	var $show_category_title = -1;
	var $show_individual_title = -1;  
	var $show_entered_by = -1;  	
	var $show_date_created = -1;  	
	var $show_modified_by = -1;  	
	var $show_modified_date = -1;  	
	var $show_self_link = -1;  	
	var $show_self_button = -1;
	var $show_home_link = -1;
	var $alwaysshowbeforeandafter = -1;
	var $completed = 0;
	var $approved = 0;
	var $published = 0;
	var $checked_out = null;
	var $checked_out_time = null;
	var $show_in_random = 1;
	var $sticky = null;
	var $ordering = 0;
	
	var $data_01 = null;
	var $data_02 = null;
	var $data_03 = null;
	var $data_04 = null;
	var $data_05 = null;
	var $data_06 = null;
	var $data_07 = null;
	var $data_08 = null;
	var $data_09 = null;
	var $data_10 = null;
	var $data_11 = null;
	var $data_12 = null;
	var $data_13 = null;
	var $data_14 = null;
	var $data_15 = null;
	var $data_16 = null;
	var $data_17 = null;
	var $data_18 = null;
	var $data_19 = null;
	var $data_20 = null;
	var $data_21 = null;
	var $data_22 = null;
	var $data_23 = null;
	var $data_24 = null;
	var $data_25 = null;
	var $notes = null;
	
	var $session = null;
	var $scodata1 = null;
	var $scodata2 = null;
		
	function __construct(&$db){
		parent::__construct('#__madblanks_records', 'id', $db);
	}
}

/**
 * This class defines an object used to pass display data for each record 
 * to be displayed to the concatenateDisplayString function
 * 
 * @package Mad_Blanks_Component
 */
class MadBlanksRecordDisplay {
/* define needed variables here with initial values as needed */
	var $category_title = null;
	var $random_button = null;
	var $record_title = null;
	var $created_date = null;
	var $entered_by = null;
	var $modified_by = null;
	var $modified_date = null;
	var $content_string = null;
	var $home_link = null;
	var $self_link_string = null;
}

/**
 * @package Mad_Blanks_Component
 */
class MadBlanksScoreScript extends JTable {
/* define needed variables from the database here with initial values as needed */
	
	var $id = null;
	var $name = null;
	var $date_created = null;
	var $notes = null;
	var $ordering = null;
	var $published = null;
	var $checked_out = null;
	var $checked_out_time = null;
	var $scorescript = null;
		
	function __construct(&$db){
		parent::__construct('#__madblanks_scorescripts', 'id', $db);
	}
}

/**
 * @package Mad_Blanks_Component
 */
class MadBlanksTimeout extends JTable {
/* define needed variables from the database here with initial values as needed */
	
	var $id = null;
	var $category_id = null;
	var $module_id = null;
	var $user = null;
	var $madblanks_session = null;
	var $starttimestamp = null;
		
	function __construct(&$db){
		parent::__construct('#__madblanks_timeout', 'id', $db);
	}
}

/**
 * Replace specially formatted strings with corresponding HTML
 *
 * @param string $beforeorafterstring the string that comes before or after a data field 
 * when displaying the record; this will be modified and returned
 * @param string $thefield the data field, needed to determine if it has any punctuation
 * @param object $datarow needed for parseLookupTag function
 * @param integer $apply_master_css needed for parseLookupTag function
 * @param string $theCSS needed for parseLookupTag function
 * @param object $configrow needed for parseLookupTag function
 * @param array $randomtagresultssofar array from calling function used to cache random tag results so they can be reused
 * @param integer $checkboxsep1 needed when calling the dataFieldToQuizFormat() function
 * @param integer $checkboxsep2 needed when calling the dataFieldToQuizFormat() function
 * @param integer $ba_replace_lookup parse 'random' tags 
 * @param integer $ba_replace_random parse 'lookup' tags 
 * @param integer $ba_replace_punctuation parse punctuation tags [:defaultperiod:], [:defaultexclamationpoint:], and [:defaultquestionmark:]
 * @param integer $ba_a_an_lower override text to replace [:a_or_an:] with
 * @param integer $ba_a_an_upper override text to replace [:A_or_An:] with
 * @param integer $processmultisep to override [:multisep:] special tag replacement make this 0
 * @param integer $checkboxsepa needed when calling the dataFieldToQuizFormat() function
 * @param integer $checkboxsepz needed when calling the dataFieldToQuizFormat() function
 * @param integer $checkboxsepb needed when calling the dataFieldToQuizFormat() function
 * @param integer $checkboxsepy needed when calling the dataFieldToQuizFormat() function
 * @return string
 */
function replaceSpecialCharacters($beforeorafterstring, $thefield=0, $datarow=null, $apply_master_css=0, $theCSS=null, $configrow=null, &$randomtagresultssofar, $checkboxsep1='', $checkboxsep2='', $ba_replace_lookup=1, $ba_replace_random=1, $ba_replace_punctuation=1, $ba_a_an_lower="", $ba_a_an_upper="", $processmultisep=1, $checkboxsepa='', $checkboxsepz='', $checkboxsepb='', $checkboxsepy='') {

	$beforeorafterstring = trim($beforeorafterstring);
	
	$thefield = trim($thefield);
		
	// Look for opening of special tag
	// Note our use of ===.  Simply == would not work as expected
	// if the position of '[:' was the 0th (first) character.
	if (strpos($beforeorafterstring, "[:") === false) { 
		// not found at all (as opposed to found at position zero)
		// no modification needed, unless $checkboxsepb or $checkboxsepy are non-empty
		if (($checkboxsepb || $checkboxsepy) && $processmultisep) {
			$beforeorafterstring = dataFieldToQuizFormat($beforeorafterstring, $checkboxsep1, $checkboxsep2, $checkboxsepa, $checkboxsepz, $checkboxsepb, $checkboxsepy);
		}
	} 

	else {
		if ($ba_replace_lookup) {
			// in 1.1.0b2, processmultisep was passed on to the parseLookupTag function with ($processmultisep ? 1 : 0)
			// in 1.1.0b3, let's always process multisep tags for lookup tags
			//  this will allow user_response_raw to be preserved in Score Scripts but still fully parse lookup tags
			$beforeorafterstring = parseLookupTag($beforeorafterstring, $datarow, $apply_master_css, $theCSS, $configrow, $randomtagresultssofar, 1);
		}
	
		$beforeorafterstring = parseMostRecentTag($beforeorafterstring, $configrow);
	
		if ($ba_replace_random) {
			$beforeorafterstring = parseRandomTag($beforeorafterstring, null, null, 0, $randomtagresultssofar);
		}
		$beforeorafterstring = str_replace('[:quot:]', '&quot;', $beforeorafterstring);
		$beforeorafterstring = str_replace('[:space:]', ' ', $beforeorafterstring);
		$beforeorafterstring = str_replace('[:nbsp:]', '&nbsp;', $beforeorafterstring);
		$beforeorafterstring = str_replace('[:lnbsp:]', ' ', $beforeorafterstring); // NOT A NORMAL SPACE! literal nbsp; This is U+00A0 No-Break Space
		$beforeorafterstring = str_replace('[:gt:]', '&gt;', $beforeorafterstring);
		$beforeorafterstring = str_replace('[:lt:]', '&lt;', $beforeorafterstring);
		$beforeorafterstring = str_replace('[:br:]', '<br />', $beforeorafterstring);
		$beforeorafterstring = str_replace('[:hr:]', '<hr />', $beforeorafterstring);
		$beforeorafterstring = str_replace('[:lquot:]', '"', $beforeorafterstring); // literal quotation mark
		$beforeorafterstring = str_replace('[:curlyl:]', '{', $beforeorafterstring); // left curly brace
		$beforeorafterstring = str_replace('[:curlyr:]', '}', $beforeorafterstring); // right curly brace
		$beforeorafterstring = str_replace('[:semicol:]', ';', $beforeorafterstring); // semicolon
		$beforeorafterstring = str_replace('[:colon:]', ':', $beforeorafterstring); // colon; added in 1.4.0 Beta 3 20100322
		$beforeorafterstring = str_replace('[:amp:]', '&amp;', $beforeorafterstring); // ampersand; changed from & to &amp; in 1.4.0 final 20100820
		$beforeorafterstring = str_replace('[:lamp:]', '&', $beforeorafterstring); // literal ampersand; added in 1.4.0 final 20100820
		
		if ($processmultisep && strpos($beforeorafterstring, "[:multisep:]") !== false) {
			$beforeorafterstring = dataFieldToQuizFormat($beforeorafterstring, $checkboxsep1, $checkboxsep2, $checkboxsepa, $checkboxsepz, $checkboxsepb, $checkboxsepy);
		}
		
		if ($thefield) {

			// if there is a vowel at the beginning of the field
			if (preg_match("/^[aeiouAEIOU]/", $thefield)) {
				$beforeorafterstring = str_replace("[:a_or_an:]", "an", $beforeorafterstring);
				$beforeorafterstring = str_replace("[:A_or_An:]", "An", $beforeorafterstring);
			}
			else {
				$beforeorafterstring = str_replace("[:a_or_an:]", "a", $beforeorafterstring);
				$beforeorafterstring = str_replace("[:A_or_An:]", "A", $beforeorafterstring);
			}
		}
		
		if ($ba_a_an_lower) {
				$beforeorafterstring = str_replace("[:a_or_an:]", $ba_a_an_lower, $beforeorafterstring);
		}
		
		if ($ba_a_an_upper) {
				$beforeorafterstring = str_replace("[:A_or_An:]", $ba_a_an_upper, $beforeorafterstring);
		}

		if ($thefield || $ba_replace_punctuation) {
		
			// if there is a punctuation mark at the end of the field
			if ($thefield && ((JString::strrpos($thefield, ".") === (JString::strlen($thefield)-1)) || (JString::strrpos($thefield, "!") === (JString::strlen($thefield)-1)) || (JString::strrpos($thefield, "?") === (JString::strlen($thefield)-1)))) {
				$beforeorafterstring = str_replace("[:defaultperiod:]", "", $beforeorafterstring);
				$beforeorafterstring = str_replace("[:defaultexclamationpoint:]", "", $beforeorafterstring);
				$beforeorafterstring = str_replace("[:defaultquestionmark:]", "", $beforeorafterstring);
			}
			else {
				$beforeorafterstring = str_replace("[:defaultperiod:]", ".", $beforeorafterstring);
				$beforeorafterstring = str_replace("[:defaultexclamationpoint:]", "!", $beforeorafterstring);
				$beforeorafterstring = str_replace("[:defaultquestionmark:]", "?", $beforeorafterstring);
			}
		}
	}
	return $beforeorafterstring;
}

/**
 * The following function is used to parse a 'random' tag potentially
 * contained withing a string, and to return the string with the tag 
 * replaced by a desired value. The tag is defined as follows:
 * 
 * [:random@<config>,<field>:]
 * 
 * Insert random value from configuration number <config> and field number <field>. You can 
 * provide multiple category and field number pairs to choose from by separating
 * them with additional @ characters. Examples:
 * To show a random entry for field seven in the configuration with id 2: [:random@2,7:]
 * To show a random entry for field nine in either configuration with id 2 or 3: [:random@2,9@3,9:]
 *
 * @param string $beforeorafterstring the string potentially containing a 'random' tag to be parsed;
 * this string will be modified and returned
 * @param string $randomizerstartdatetime if present, use only records that are no older than this datetime
 * @param string $randomizerenddatetime if present, use only records that are no newer than this datetime
 * @param string $straight_randomizer if present, check that the allow_randomizer bit in the categories table is set
 * @param string $randomtagresultssofar a cache of random tags that have already been matched to values; passed by reference
 * @param string $user filter from the URI needed for the SQL display query; use only records entered by named users
 * @return string
 */
function parseRandomTag($beforeorafterstring, $randomizerstartdatetime=null, $randomizerenddatetime=null, $straight_randomizer=0, &$randomtagresultssofar, $user="", $additional_sql="") {
	
	// determine if the string contains a 'random' tag at all
	if (strpos($beforeorafterstring, "[:random") !== false) {  // yes, a 'random' tag (probably) exists in the string
	
		$i = 0; // initialize 'while' loop index
	
		// limit this loop to 15 times for safety, 
		//  therefore limiting the number of 'random' tags in a field to 15
		while (preg_match("/\[:random@((\d+,\d+@?)+):\]/", $beforeorafterstring, $matches) && $i < 15) {
			$i++; // increment loop safety index

			// replace random tags that we have already seen from the cache
			$beforeorafterstring = str_replace(array_keys($randomtagresultssofar), $randomtagresultssofar, $beforeorafterstring);

			$pos = strpos($beforeorafterstring, "[:random");
			if ($pos !== false) {  // yes, a 'random' tag (probably) exists in the string
	
				preg_match("/\[:random@((\d+,\d+@?)+):\]/", $beforeorafterstring, $matches);

				// Create an array filled with (category id, field) pairs
				//$randomsourcearray = explode("@",$thestring);
				$randomsourcearray = explode("@", $matches[1]);
				
				// the $randomchoices array will be filled with all possible values to 
				//  fill the request for a random value with
				$randomchoices = array();
				// this is needed to access the $mbAllowBlankRandomFields configuration variable
				global $mbAllowBlankRandomFields;
				$database = &JFactory::getDBO();
				
				if ($straight_randomizer) {
					$straight_randomizer = "\nAND cat.allow_randomizer > 0";
				}
				else {
					$straight_randomizer = "\nAND cat.allow_random_tag > 0";
				}

				// Now gather all possibilities into an array, one element of which will be chosen at random.
				foreach ($randomsourcearray as $randomsource) {
					// $source_field_pair[0] will be the random tag category id
					// $source_field_pair[1] will be the random tag field number
					$source_field_pair  = explode(",",$randomsource);
					$thefield = sprintf('%02d', $source_field_pair[1]); // sprintf (as opposed to printf) is used to put the value into a variable
					//$thequery = getDisplayQuery($randomizerstartdatetime, $randomizerenddatetime, $user, "AND cat.data_" . $thefield . "_use > 0\nAND data.configid = " . $source_field_pair[0] . "\nAND data.show_in_random > 0" . $straight_randomizer . "\n" . $additional_sql, "", "SELECT data.data_" . $thefield);
					$thequery = getDisplayQuery($randomizerstartdatetime, $randomizerenddatetime, $user, "AND cat.data_" . $thefield . "_use > 0\nAND data.configid = " . $source_field_pair[0] . "\nAND data.show_in_random > 0" . $straight_randomizer . "\n" . $additional_sql, "", "SELECT data.data_" . $thefield . " AS thefield, cat.data_" . sprintf('%02d', $source_field_pair[1]) . "_config AS fieldconfig" );
					$database->setQuery($thequery);
					$rows = $database->loadObjectList();
					//echo "<pre>";
					//print_r($rows);
					//echo "</pre>";

					foreach ($rows as $row) {
						//if ($row->{"data_".$thefield} || $mbAllowBlankRandomFields) 
						if ($row->thefield || $mbAllowBlankRandomFields) {
							//array_push($randomchoices, $row->{"data_".$thefield});
							array_push($randomchoices, array('thefield' => $row->thefield, 'fieldconfig' => $row->fieldconfig));
						}	
					}
				}
				$randomchoice = '';
				if (!empty($randomchoices)) {
					$randomindex = array_rand($randomchoices);
					//$randomchoice = $randomchoices[$randomindex];
					//echo "<pre>\$randomchoices[\$randomindex] is\n";
					//print_r($randomchoices[$randomindex]);
					//echo "</pre>";
					
					//echo "<p>the random choice selected was " . $randomchoices[$randomindex]['thefield'] . "</p>";
					//if ((strpos($randomchoice, "[:multisep:]") !== false) || is_array($randomchoice)) {
					//if ((strpos($randomchoices[$randomindex]['thefield'], "[:multisep:]") !== false) || is_array($randomchoices[$randomindex])) {
					if (strpos($randomchoices[$randomindex]['thefield'], "[:multisep:]") !== false) {
						//$randomchoice = parseDataConfigString($result[0]->{"data_" . sprintf('%02d', $preg_result[3]) . "_config"});
						$quizparameters = parseDataConfigString($randomchoices[$randomindex]['fieldconfig']);
						$randomchoices[$randomindex]['thefield'] = dataFieldToQuizFormat($randomchoices[$randomindex]['thefield'], isset($quizparameters['checkboxsep1']) ? $quizparameters['checkboxsep1'] : '', isset($quizparameters['checkboxsep2']) ? $quizparameters['checkboxsep2'] : '', isset($quizparameters['checkboxsepa']) ? $quizparameters['checkboxsepa'] : '', isset($quizparameters['checkboxsepz']) ? $quizparameters['checkboxsepz'] : '', isset($quizparameters['checkboxsepb']) ? $quizparameters['checkboxsepb'] : '', isset($quizparameters['checkboxsepy']) ? $quizparameters['checkboxsepy'] : '');
					}

				}	
				
				// make the replacement of the random tag isolated in the preg_match 
				//  in the while loop declaration
				//$beforeorafterstring = str_replace($matches[0], $randomchoice, $beforeorafterstring);
				$beforeorafterstring = str_replace($matches[0], $randomchoices[$randomindex]['thefield'], $beforeorafterstring);

				// store the value returned by this random tag lookup 
				//  in case we want to use it again in the same record
				//$randomtagresultssofar["$matches[0]"] = $randomchoice;
				$randomtagresultssofar["$matches[0]"] = $randomchoices[$randomindex]['thefield'];
			}
			else {
				break; // the text "[:random" is not present so there is no need to continue
			}	
		} // end while loop
	}
	return $beforeorafterstring;
} /* end randomized entry parser */

/**
 * The following function is used to parse a 'lookup' tag potentially
 * contained withing a string, and to return the string with the tag 
 * replaced by the desired value. The tag is defined as follows:
 * 
 * [:lookup@<record_number>,<field>:]
 * 
 * Insert value from a specific record and field
 * Example:
 * To insert the value from field seven in the record with id 2: [:lookup@2,7:]
 * To insert the value from field ten in 'this' record (used in other fields of the same record): [:lookup@this,10:]
 *
 * The records values are taken from must be completed, approved, and published
 *
 * @param string $beforeorafterstring the string potentially containing a 'lookup' tag to be parsed;
 * this string will be modified and returned
 * @param $datarow needed to determine values of other fields in the same record for 'this' functionality
 * @param $apply_master_css whether or not to apply master css from the category row to the returned value
 * @param string $theCSS CSS declarations to be applied to the looked up value
 * @param $configrow category row from the database
 * @return string return the string with the tag, if present, replaced by the looked up text; otherwise return the original string
 */
function parseLookupTag($beforeorafterstring, $datarow=null, $apply_master_css=0, $theCSS=null, $configrow=null, &$randomtagresultssofar, $processmultisep=1) {
		
	// determine if the string contains a 'lookup' tag at all
	//$pos = strpos($beforeorafterstring, "[:lookup");
	
	if (strpos($beforeorafterstring, "[:lookup") !== false) { // yes, a 'lookup' tag (probably) exists in the string

		if (!$theCSS) {
			$theCSS = isset($configrow->master_css) ? $configrow->master_css : "";
		}
	
		$i = 0; // initialize 'while' loop index
		
		// check for valid 'lookup' tag and parse it if present
		// limit this loop to 50 times to prevent infinite looping, 
		//  therefore limiting the number of 'lookup' tags in a field or Score Script to 50
		// 1.1.0b2: adding pattern modifier 's' to enable linebreaks 
		//  to match so that score scripts can include more than one line and 
		//  contain 'lookup' tags
		//while(preg_match("/(.*)\[:lookup@(this|\d+),(\d+)(,([01]{4}))?:\](.*)/s", $beforeorafterstring, $preg_result) && $i < 15) {
		// 1.1.0rc2: add fourth argument to allow disabling of $apply_master_css (override when 4th argument is 1)
		while(preg_match("/(.*)\[:lookup@(this|\d+),((?:scodata)?\d+)((,([01]{4}))?(,([01]))?)?:\](.*)/s", $beforeorafterstring, $preg_result) && $i < 50) {
			$i++;

			// In the array $preg_result,
			//  the beginning portion of the string will be $preg_result[1]
			//  the record id will be $preg_result[2]
			//  and the field number or field name (scodataN) will be $preg_result[3]
			//  and the string formatting quadruplet, if present, will be $preg_result[6]; WAS 5 before 1.1.0rc2
			//  the apply_master_css override, if present, will be $preg_result[8]; new for 1.1.0rc2
			//  the ending portion of the string will be $preg_result[9]; WAS 6 before 1.1.0rc2
			
			if ($preg_result[8] == 1) {
				// override apply_master_css (disable applying master CSS)
				$apply_master_css = 0;
			}

			if ($preg_result[2] == "this") {
				// the value we seek is within the same record ($datarow)
				if (is_object($datarow)) {

					// 1.4.0 final 20100820 to allow looking up scodataN, only prepend data_ if the field we're looking for is numeric
					if (is_numeric($preg_result[3])) {
						$thedata = $datarow->{'data_'.sprintf('%02d', $preg_result[3])};
					}
					else {
						$thedata = $datarow->{$preg_result[3]};
					}
					
					// apply special string formatting to the field if dictated by the category configuration
					if ($configrow && is_numeric($preg_result[3])) {
						
						// make substitutions for any 'random' tags before applying the formatting
						$thedata = parseRandomTag($thedata, null, null, 0, $randomtagresultssofar);
						
						// use text field formatting function information from $configrow
						$thedata = formatField($configrow->{"data_" . sprintf('%02d', $preg_result[3]) . "_config"}, $thedata, ":", "|", $preg_result[6]);
						
						//if ((strpos($thedata, "[:multisep:]") !== false) || is_array($thedata)) {
						if ($processmultisep && strpos($thedata, "[:multisep:]") !== false) {
							$quizparameters = parseDataConfigString($configrow->{"data_" . sprintf('%02d', $preg_result[3]) . "_config"});
							$thedata = dataFieldToQuizFormat($thedata, isset($quizparameters['checkboxsep1']) ? $quizparameters['checkboxsep1'] : '', isset($quizparameters['checkboxsep2']) ? $quizparameters['checkboxsep2'] : '', isset($quizparameters['checkboxsepa']) ? $quizparameters['checkboxsepa'] : '', isset($quizparameters['checkboxsepz']) ? $quizparameters['checkboxsepz'] : '', isset($quizparameters['checkboxsepb']) ? $quizparameters['checkboxsepb'] : '', isset($quizparameters['checkboxsepy']) ? $quizparameters['checkboxsepy'] : '');
						}

					}	

					$beforeorafterstring = $preg_result[1] . ($apply_master_css ? openMasterCSS($theCSS, $datarow->configid) : "") . $thedata . ($apply_master_css ? closeMasterCSS() : "") .  $preg_result[9];
				}
				else { // $datarow did not return an object for some reason; remove the 'lookup' tag from the string
					$beforeorafterstring = $preg_result[1] . $preg_result[9];
				}
			}
			else {
				$database = &JFactory::getDBO(); 
				// 1.4.0 final 20100820 add conditional for case when not looking up field 1-25, for example scodataN
				if (is_numeric($preg_result[3])) { // look up field 1-25, original behavior prior to 1.4.0 final
					$thequery = getDisplayQuery(null, null, null, "AND cat.data_" . sprintf('%02d', $preg_result[3]) . "_use > 0\nAND data.id = " . intval($preg_result[2]) . "\nAND cat.allow_lookup_tag > 0\nLIMIT 1", null, "SELECT data.data_" . sprintf('%02d', $preg_result[3]) . " AS thedata, data.configid, cat.data_" . sprintf('%02d', $preg_result[3]) . "_config");
				}
				else { // look up scodataN, etc.
					$thequery = getDisplayQuery(null, null, null, "AND data.id = " . intval($preg_result[2]) . "\nAND cat.allow_lookup_tag > 0\nLIMIT 1", null, "SELECT data." . $preg_result[3] . " AS thedata");
				}
				$database->setQuery($thequery);
				$result = $database->loadObjectList();
				// 1.4.0 final 20100820 add conditional for case when not looking up field 1-25, for example scodataN
				if (!is_numeric($preg_result[3]) && !empty($result[0]->thedata)) {
				
					$beforeorafterstring = $preg_result[1] . ($apply_master_css ? openMasterCSS($theCSS, $datarow->configid) : "") . $result[0]->thedata . ($apply_master_css ? closeMasterCSS() : "") .  $preg_result[9];
				
				}
				else if (!empty($result[0]->thedata)) { // original 'if' prior to 1.4.0 final

					// make substitutions for any 'random' tags before applying the formatting
					$result[0]->thedata = parseRandomTag($result[0]->thedata, null, null, 0, $randomtagresultssofar);

					// use text field formatting function information from the category where the looked up data resides
					$result[0]->thedata = formatField($result[0]->{"data_" . sprintf('%02d', $preg_result[3]) . "_config"}, $result[0]->thedata, ":", "|", $preg_result[6]);
						
					// 1.1.0rc2 change call to openMasterCSS from openMasterCSS($theCSS, $result[0]->configid) : "") to openMasterCSS(null, $result[0]->configid) : "") so we are sure to look up and use the master CSS value from the target category
					$beforeorafterstring = $preg_result[1] . ($apply_master_css ? openMasterCSS(null, $result[0]->configid) : "") . $result[0]->thedata . ($apply_master_css ? closeMasterCSS() : "") . $preg_result[9];

					//if ((strpos($beforeorafterstring, "[:multisep:]") !== false) || is_array($beforeorafterstring)) {
					if ($processmultisep && strpos($beforeorafterstring, "[:multisep:]") !== false) {
						$quizparameters = parseDataConfigString($result[0]->{"data_" . sprintf('%02d', $preg_result[3]) . "_config"});
						$beforeorafterstring = dataFieldToQuizFormat($beforeorafterstring, isset($quizparameters['checkboxsep1']) ? $quizparameters['checkboxsep1'] : '', isset($quizparameters['checkboxsep2']) ? $quizparameters['checkboxsep2'] : '', isset($quizparameters['checkboxsepa']) ? $quizparameters['checkboxsepa'] : '', isset($quizparameters['checkboxsepz']) ? $quizparameters['checkboxsepz'] : '', isset($quizparameters['checkboxsepb']) ? $quizparameters['checkboxsepb'] : '', isset($quizparameters['checkboxsepy']) ? $quizparameters['checkboxsepy'] : '');
					}
				}
				
				else { // no data was looked up for the given 'lookup' tag; remove the tag from the string
					$beforeorafterstring = $preg_result[1] . $preg_result[9];
				}

			}
		}
	}
	return $beforeorafterstring;
} /* end function parseLookupTag */

/**
 * Return opening <span> tag with user supplied or default category CSS in the style attribute
 *
 * use echo to display the result
 *
 * @param string $theCSS the CSS string to use
 * @param integer $categoryid the id number of a category from which to grab the master_css
 * @return string
 */
function openMasterCSS($theCSS=null, $categoryid=null) {
	if ($theCSS) {
		return "<span style=\"" . $theCSS . "\">";
	}
	else if ($categoryid) {
		$database = &JFactory::getDBO(); 
		$database->setQuery("SELECT master_css FROM #__madblanks_categories WHERE id=" . $categoryid);
		return "<span style=\"" . $database->loadResult() . "\">";
	}
	else {
		return "<span>"; // this will match up with the closing </span> tag in closeMasterCSS()
	}	
}

/**
 * Return closing <span> tag
 *
 * use echo to display the result
 *
 * @return string
 */
function closeMasterCSS() {
	return "</span>";
}

/**
 * Return username or full name for a given user id number
 *
 * use echo to display the result
 *
 * @param integer $theid the id number associated with a Joomla registered user (from the jos_users table)
 * @param integer $thename if argument is true, return real name, otherwise return username
 * @return string
 */
function getUserNameByID($theid, $thename=0) {
	if ($theid == 16777215) {
		return _MBL_AUTO_APPROVE;
	}
	else {
		global $access;
		$database = &JFactory::getDBO();
		
		if ($thename) {
			$database->setQuery("SELECT name FROM #__users WHERE id = '" . $theid . "' LIMIT 1");
		}
		else {
			$database->setQuery("SELECT username FROM #__users WHERE id = '" . $theid . "' LIMIT 1");
		}
		if (!$database->loadResult()) {
			if ($theid) {
				//return "<em>&lt;" . _MBL_UNKNOWN . " " . _MBL_ID . ": $theid&gt;</em>"; removed in 1.1.0b2
				if (madblanks_user_is_administrator()) { // user is an admin
					return sprintf(_MBL_UNKNOWN_ID_ADMIN, $theid);
				}
				else {
					return sprintf(_MBL_UNKNOWN_ID, $theid);
				}
			}
			else {
				return "<em>&lt;" . _MBL_NO_ID_SPECIFIED . "&gt;</em>";
			}	
		}
		else {
			return $database->loadResult();
		}
	}
}

/**
 * Return category field contents based on a category id number and category field name
 *
 * use echo to display the result
 *
 * @param integer $thecategoryid the id number associated with a category (from the jos_madblanks_categories table)
 * @param string $thefieldname name of the desired category field
 * @param integer $silentonerror this flag determines whether to output error messages
 * @return string
 */
function getCategoryFieldByID($thecategoryid, $thefieldname='name', $silentonerror=0) {
	$database = &JFactory::getDBO(); 	
	$database->setQuery("SELECT " . strval($thefieldname) . " FROM #__madblanks_categories WHERE id='" . $thecategoryid . "' LIMIT 1");
	if (!$database->loadResult()) {
		if ($thecategoryid) {
			if (empty($silentonerror)) {
				return "<em>&lt;" . _MBL_CATEGORY_NAME . " #" . $thecategoryid . "&gt;</em>";
			}
			else {
				return null;
			}
		}
		else {
			if (empty($silentonerror)) {
				return "<em>&lt;" . _MBL_NO . " " . _MBL_CATEGORY_NAME . "&gt;</em>";
			}
			else {
				return null;
			}	
		}	
	}
	else {
		return $database->loadResult();
	}	
}

/**
 * Get a display variable, checking the local one (in the record) first and then the 
 * global one (in the category) if necessary
 *
 * Examples of display variables include show_category_title, show_individual_title, 
 * show_entered_by, and show_date_created. Use the existing objects rather than
 * making copies.
 * 
 * @param object &$row the record row from the database
 * @param object &$configrow the category row from the database
 * @param string $thevar the variable name as a string
 * @return integer return a 1 if the display variable is in effect, and 0 if the
 * display variable is not in effect
 */
function getDisplayConfigurationVariable(&$row, &$configrow, $thevar) {

	if (isset($row->{$thevar}) && $row->{$thevar} < 0) { // The result is -1, meaning use the global config, which is 1 or 0
		if (isset($configrow->{$thevar}) && $configrow->{$thevar}) {
			return 1;
		}	
	}
	else if (isset($row->{$thevar}) && $row->{$thevar} > 0) {
		return 1;
	}
	return 0;
}

/**
 * Get a string describing the current option setting (yes, no, or global)
 * for various display options saved in a record table row.
 *
 * -1 return global string, 1 return yes string, 0 return no string
 * $shortanswer=1 to return just the word global, yes, no, or unknown
 * use echo to display the result
 *
 * @param integer $thesetting what the variable is set to for this record
 * @param integer $shortanswer set to 1 to return shortened version (just
 * the word global, yes, no, or unknown); set to 0 to return long version
 * with _MBL_CURRENT_GLOBAL_SETTING ("Current global setting:" by default)
 * @return string
 */
function getCurrentOptionSetting($thesetting, $shortanswer=0) {
	$thereturnstring = '';
	if (isset($thesetting)) {
		if (!$shortanswer) {
			$thereturnstring = _MBL_CURRENT_GLOBAL_SETTING . " ";
		}	
		if ($thesetting < 0) { // The result is -1, meaning use the global config, which is 1 or 0
			$thereturnstring .= _MBL_GLOBAL;
		}	
		else if ($thesetting > 0) {
			$thereturnstring .= _MBL_YES;
		}
		else {	
			$thereturnstring .= _MBL_NO;
		}
	}
	else {
		$thereturnstring = _MBL_UNKNOWN;
	}	
	return $thereturnstring;
}

/**
 * Writes a common 'delete' button for a list of records; custom version for this component
 * allows JavaScript deletion warning; warning occurs if records are present in the 
 * category when deletion is attempted. Only used for Joomla! 1.0.
 * @param string $msg Postscript for the 'are you sure' message
 * @param string $task An override for the task
 * @param string $alt An override for the alt text
 */
function MadBlanksDeleteCategoryList($msg='', $task='remove', $alt='Delete') {
	$database = &JFactory::getDBO(); 
	$database->setQuery("SELECT configid, count(*) AS thecount FROM #__madblanks_records GROUP BY configid");
	$rows = $database->loadObjectList();
	$mosAdminMenus = new mosAdminMenus();
	$image2 = $mosAdminMenus->ImageCheckAdmin( 'delete_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 1 );
	?>
	<td>
		<a class="toolbar" href="javascript:function mbdelfunction(){var mbdel='';catcount = new Array();<?php 
		
		if ($rows) {
			foreach ($rows as $row) {
				echo "catcount[" . $row->configid . "]=" . $row->thecount . ";";
			}
		}	
		?>for(i=0;i<document.adminForm.elements['cid[]'].length;i++){ if (document.adminForm.elements['cid[]'][i].checked && catcount[document.adminForm.elements['cid[]'][i].value]) {var recordsp=(catcount[document.adminForm.elements['cid[]'][i].value] > 1) ? ' <?php echo _MBL_RECORD_NAME_PLURAL; ?> ' : ' <?php echo _MBL_RECORD_NAME; ?> ';var isare=(catcount[document.adminForm.elements['cid[]'][i].value] > 1) ? ' <?php echo _MBL_ARE; ?> ' : ' <?php echo _MBL_IS; ?> ';mbdel += '<?php echo _MBL_WARNING . ": " . _MBL_THERE; ?>' + isare + catcount[document.adminForm.elements['cid[]'][i].value] + recordsp + '<?php echo _MBL_IN_DATABASE_FOR . " " . _MBL_CATEGORY_NAME; ?>#' + document.adminForm.elements['cid[]'][i].value + ' <?php echo _MBL_WILL_BE_ORPHANED; ?>\n'}}return mbdel;}; if (document.adminForm.boxchecked.value == 0){ alert('<?php printf(_MBL_MAKE_SELECTION, JString::strtolower(_MBL_DELETE)); ?>'); } else if (confirm('<?php printf(_MBL_CONFIRM_QUESTION, JString::strtolower(_MBL_DELETE)); ?> <?php echo $msg;?>')){ if (!mbdelfunction() || confirm(mbdelfunction())) { submitbutton('<?php echo $task;?>');}}">
			<?php echo $image2; ?>
			<br /><?php echo $alt; ?></a>
	</td>
	<?php
}

/**
 * Writes a common 'delete' button for a list of records; custom version for this component
 * allows JavaScript deletion warning; warning occurs if records are present in the 
 * scorescript when deletion is attempted. Only used for Joomla! 1.0.
 * @param string $msg Postscript for the 'are you sure' message
 * @param string $task An override for the task
 * @param string $alt An override for the alt text
 */
/* function MadBlanksDeleteScoreScriptList($msg='', $task='remove', $alt='Delete') {
	$database = &JFactory::getDBO(); 
	$database->setQuery("SELECT configid, count(*) AS thecount FROM #__madblanks_records GROUP BY configid");
	$rows = $database->loadObjectList();
	
	$mosAdminMenus = new mosAdminMenus();
	$image2 = $mosAdminMenus->ImageCheckAdmin( 'delete_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 1 );
	?>
	<td>
		<a class="toolbar" href="javascript:function mbdelfunction(){var mbdel='';catcount = new Array();<?php 
		
		if ($rows) {
			foreach ($rows as $row) {
				echo "catcount[" . $row->configid . "]=" . $row->thecount . ";";
			}
		}	
		?>for(i=0;i<document.adminForm.elements['cid[]'].length;i++){ if (document.adminForm.elements['cid[]'][i].checked && catcount[document.adminForm.elements['cid[]'][i].value]) {var recordsp=(catcount[document.adminForm.elements['cid[]'][i].value] > 1) ? ' <?php echo _MBL_RECORD_NAME_PLURAL; ?> ' : ' <?php echo _MBL_RECORD_NAME; ?> ';var isare=(catcount[document.adminForm.elements['cid[]'][i].value] > 1) ? ' <?php echo _MBL_ARE; ?> ' : ' <?php echo _MBL_IS; ?> ';mbdel += '<?php echo _MBL_WARNING . ": " . _MBL_THERE; ?>' + isare + catcount[document.adminForm.elements['cid[]'][i].value] + recordsp + '<?php echo _MBL_IN_DATABASE_FOR . " " . _MBL_CATEGORY_NAME; ?>#' + document.adminForm.elements['cid[]'][i].value + ' <?php echo _MBL_WILL_BE_ORPHANED; ?>\n'}}return mbdel;}; if (document.adminForm.boxchecked.value == 0){ alert('<?php printf(_MBL_MAKE_SELECTION, JString::strtolower(_MBL_DELETE)); ?>'); } else if (confirm('<?php printf(_MBL_CONFIRM_QUESTION, JString::strtolower(_MBL_DELETE)); ?> <?php echo $msg;?>')){ if (!mbdelfunction() || confirm(mbdelfunction())) { submitbutton('<?php echo $task;?>');}}">
			<?php echo $image2; ?>
			<br /><?php echo $alt; ?></a>
	</td>
	<?php
}  */

/**
 * This function places category rows from the category database table as objects into an array.
 *
 * The default is to only place published category rows into the array. Set the 
 * publishedoverride flag to return all category rows regardless of whether the categories are 
 * published or not.
 * @param integer $publishedoverride flag to return all category rows instead of only published rows
 * @return array
 */
function getConfigurationArray($publishedoverride=0) {
	
	$database = &JFactory::getDBO(); 
	
	// load published configurations into an array indexed by configuration id
	$database->setQuery("SELECT * FROM #__madblanks_categories" . ($publishedoverride ? "" : " WHERE published > 0"));
	$configrows = $database->loadObjectList();
	$configuration = array();
	foreach ($configrows as $configrow) {
		$configuration[$configrow->id] = $configrow;
	}
	return $configuration;		
}

/**
 * This function is designed to take the contents of an array where the key is the name of the config value and 
 * the data is the config data and encode them for storage in the categories database table data_xx_config position.
 *
 * The values cannot contain colons or pipes!
 * 
 * The expected format of the string is data1name:data1value|data2name:data2value
 *
 * The companion function is parseDataConfigArray().
 * @param int $thecategory The category id
 * @param int $thedatanumber The data number within the category id
 * @param array $thearray The array containing new values
 * @param string $thepairseparator text separator between value name and value data; colon by default
 * @param string $thevalueseparator text separator between values; pipe by default
 * @return string
 */
function makeDataConfigString($thecategory, $thedatanumber, $thearray, $thepairseparator=":", $thevalueseparator="|") {
	$database = &JFactory::getDBO(); 

	// First, aquire the current string properties as an array
	$database->setQuery("SELECT data_" . sprintf('%02d', (int) $thedatanumber) . "_config FROM #__madblanks_categories WHERE id=" . (int) $thecategory);
	$valuearray = parseDataConfigString($database->loadResult());
	
	// Now, if the existing array is not empty, combine the new array with the existing array
	// If the input arrays have the same string keys, then the later value for that key will overwrite the previous one.
	if (!empty($valuearray)) {
		$valuearray = array_merge($valuearray, $thearray);
	}
	else {
		$valuearray = $thearray;
	}	
	
	// Third, make the new array into a string;
	$thestringtostore = '';
	if (!empty($valuearray)) {
		foreach ($valuearray as $key => $value) {
			if (!empty($thestringtostore)){
				$thestringtostore .= $thevalueseparator; // separate key/value pairs with $thevalueseparator
			}
			$thestringtostore .= $key . $thepairseparator . $value;
		}	
	}	
	return $thestringtostore;
}

/**
 * Return an array of key value pairs parsed from a string that was stored in the 
 * categories database table data_xx_config position.
 *
 * The expected format of the string is data1name:data1value|data2name:data2value
 *
 * @param array $thedata The string containing new values to be placed into the array
 * @param string $thepairseparator text separator between value name and value data; colon by default
 * @param string $thevalueseparator text separator between values; pipe by default
 * @return array
 */
function parseDataConfigString($thedata, $thepairseparator=":", $thevalueseparator="|") {
	
	if ($thedata) {
		$namevaluepairs = explode($thevalueseparator, $thedata);
		$valuearray = array();
		foreach ($namevaluepairs as $namevaluepair) {
			$namevalue = explode($thepairseparator, $namevaluepair);
			$valuearray["$namevalue[0]"] = isset($namevalue[1]) ? $namevalue[1] : null;	
		}
		return $valuearray;
	}
	else {
		return null;
	}	
}

/**
 * Apply any applicable string formatting functions to a field.
 *
 * @param mixed $thedatatodecode the configuration string from the categories, or the string already converted into an array
 * database table 'data_xx_config'
 * @param string $thefield the contents of the field to potentially modify
 * @param string $thepairseparator text separator between value name and value data; colon by default
 * @param string $thevalueseparator text separator between values; pipe by default
 * @param string $str_quadruplet a quadruplet of four characters, each is a 1 or a 0;
 * 1st char 1 means apply strtoupper, 2nd char 1: apply strtolower, 3rd char 1: apply ucwords, 4th char 1: apply ucfirst
 * if present, the directives take priority; if not present, apply all according to $thedatatodecode
 * @return string
 */
function formatField($thedatatodecode, $thefield, $thepairseparator=":", $thevalueseparator="|", $str_quadruplet="") {

	if ($str_quadruplet) {
		if (intval(substr($str_quadruplet, 0, 1))) {
			$thefield = JString::strtoupper($thefield);
		}
		if (intval(substr($str_quadruplet, 1, 1))) {
			$thefield = JString::strtolower($thefield);
		}
		if (intval(substr($str_quadruplet, 2, 1))) {
			$thefield = ucwords($thefield);
		}
		if (intval(substr($str_quadruplet, 3, 1))) {
			$thefield = ucfirst($thefield);
		}
		
	}
	
	else {
		// allow use of already-decoded array if available (added in 1.1.0b3)
		if (is_array($thedatatodecode)) {
			$configarray = $thedatatodecode;
		}
		else {
			$configarray = parseDataConfigString($thedatatodecode, $thepairseparator, $thevalueseparator);
		}
		if (!empty($configarray['strtoupper'])) {
			$thefield = JString::strtoupper($thefield);
		}
		if (!empty($configarray['strtolower'])) {
			$thefield = JString::strtolower($thefield);
		}
		if (!empty($configarray['ucwords'])) {
			$thefield = ucwords($thefield);
		}
		if (!empty($configarray['ucfirst'])) {
			$thefield = ucfirst($thefield);
		}
	}
	return $thefield;
}

/**
 * Return a query string that has been cleaned of variables associated with the Create Single Record Module
 *
 * @param string $thequery the query string to clean
 * @param string $postprefix the string the module uses to prefix all of its URI variables
 * @param integer $modulecookieid the unique identifier for this copy of the module
 * @return string the cleaned query string
 */
function cleanCreateSingleRecordModuleQueryString($thequery, $postprefix, $modulecookieid) {
	
	/* The query string is the portion of the HTTP request that follows the question mark (?). The string defined by
	this regular expression starts with an ampersand, or the beginning of the string (represented by the caret).
	Near the end of this pattern, the question mark has two different special meanings. Note that, "if a quantifier
	[in this case, the asterisk] is followed by a question mark, then it ceases to be greedy, and instead matches
	the minimum number of times possible." And, "An assertion is a test on the characters following or preceding the
	current matching point that does not actually consume any characters.... Lookahead assertions start with (?= for
	positive assertions... For example, \w+(?=;)  matches a word followed by a semicolon, but does not include the
	semicolon in the match." In this case, the pattern ends before an ampersand or the end of the string. See the
	PHP PCRE pattern syntax documentation for more details. */
	
	//echo "<p>cleanCreateSingleRecordModuleQueryString input is $thequery</p>";
	
	// 1.1.0 Beta 3
	//$thequery = preg_replace('/(&|^)((' . $postprefix . $modulecookieid . 'data_\d\d)|(' . $postprefix . $modulecookieid . 'blank_\d\d)|(' . $postprefix . $modulecookieid . 'showid)|(' . $postprefix . $modulecookieid . 'blankexists)|(' . $postprefix . $modulecookieid . 'shownosave)|(inputanotherrecord)|(' . $postprefix . 'a)|(' . $postprefix . $modulecookieid . 'configid))=.*?((?=&)|(?=$))/','',$thequery);
	
	// 1.1.0 RC1 part of Joomla 1.5 compatibility changes
	//$thequery = preg_replace('/(&|\?|^)((' . $postprefix . $modulecookieid . 'data_\d\d)|(' . $postprefix . $modulecookieid . 'blank_\d\d)|(' . $postprefix . $modulecookieid . 'showid)|(' . $postprefix . $modulecookieid . 'blankexists)|(' . $postprefix . $modulecookieid . 'shownosave)|(inputanotherrecord)|(' . $postprefix . 'a)|(' . $postprefix . $modulecookieid . 'configid))=.*?((?=&)|(?=$))/','',$thequery);
	
	// updated for regexp validation functionality in 1.1.0rc2
	//$thequery = preg_replace('/(&|\?|^)((' . $postprefix . $modulecookieid . 'data_\d\d)|(' . $postprefix . $modulecookieid . 'blank_\d\d)|(' . $postprefix . $modulecookieid . 'blankok_\d\d)|(' . $postprefix . $modulecookieid . 'invalid_\d\d)|(' . $postprefix . $modulecookieid . 'showid)|(' . $postprefix . $modulecookieid . 'blankexists)|(' . $postprefix . $modulecookieid . 'invalidexists)|(' . $postprefix . $modulecookieid . 'shownosave)|(inputanotherrecord)|(' . $postprefix . 'a)|(' . $postprefix . $modulecookieid . 'configid))=.*?((?=&)|(?=$))/','',$thequery);
	
	// added removal of nextconfigid 1.4.0 Beta 2 20100223
	$thequery = preg_replace('/(&|\?|^)((' . $postprefix . $modulecookieid . 'data_\d\d)|(' . $postprefix . $modulecookieid . 'blank_\d\d)|(' . $postprefix . $modulecookieid . 'blankok_\d\d)|(' . $postprefix . $modulecookieid . 'invalid_\d\d)|(' . $postprefix . $modulecookieid . 'showid)|(' . $postprefix . $modulecookieid . 'nextconfigid)|(' . $postprefix . $modulecookieid . 'blankexists)|(' . $postprefix . $modulecookieid . 'invalidexists)|(' . $postprefix . $modulecookieid . 'shownosave)|(inputanotherrecord)|(' . $postprefix . 'a)|(' . $postprefix . $modulecookieid . 'configid))=.*?((?=&)|(?=$))/','',$thequery);
	
	//echo "<p>cleanCreateSingleRecordModuleQueryString output is $thequery</p>"; exit;
	
	return $thequery;
}	

/**
 * Prepare a string to use to display an individual record.
 *
 * @param integer $mbFieldCount number of data fields present in the records table of the database
 * @param object $row the database row corresponding to the record to be displayed
 * @param object $configrow the database row corresponding to the category the record to be displayed belongs to
 * @param string $randomizerstartdatetime OBSOLETE if present, when calling parseRandomTag, use only records that are no older than this datetime
 * @param string $randomizerenddatetime OBSOLETE if present, when calling parseRandomTag, use only records that are no newer than this datetime
 * @return string
 */
function concatenateDisplayString($mbFieldCount, $row, $configrow, $wordwrapwidth=0, $enable_archive_scorescript=0) {

	if (empty($configrow)) {
		return "<span class=\"message\">" . _MBL_INVALID_CATEGORY . "</span>";
	}
	
	$randomtagresultssofar = array(); // array to cache random tag results
	
	$content_string = ''; // initialize

	// CPH 20110219 1.4.2 added option to hide record output and only display Archive Score Script output
	if (isset($configrow->hide_record_content) && empty($configrow->hide_record_content)) {
		for ($i=1; $i <= $mbFieldCount; $i++) {

			$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable

			$thefield = isset($row->{"data_".$theindex}) ? trim($row->{"data_".$theindex}) : "";

			if ($configrow->allow_html_input) { // when is it best to do this?
				$thefield = convertFromQuotLtGt($thefield);
			}

			// if config says to use it AND (there is something in it OR alwaysshowbeforeandafter bit is set)
			//if ($configrow->{"data_".$theindex."_use"} && ($thefield || getDisplayConfigurationVariable($row, $configrow, "alwaysshowbeforeandafter"))) {
			// 110b3 20080130 modified this to allow a field to contain 0 and still be echoed
			if ($configrow->{"data_".$theindex."_use"} && (($thefield != '') || getDisplayConfigurationVariable($row, $configrow, "alwaysshowbeforeandafter"))) {

				$dataconfigarray = parseDataConfigString($configrow->{'data_' . $theindex . '_config'});

				$thefield = replaceSpecialCharacters($thefield, 0, $row, 0, null, $configrow, $randomtagresultssofar, isset($dataconfigarray['checkboxsep1']) ? $dataconfigarray['checkboxsep1'] : '', isset($dataconfigarray['checkboxsep2']) ? $dataconfigarray['checkboxsep2'] : '', 1, 1, 1, '', '', 1, isset($dataconfigarray['checkboxsepa']) ? $dataconfigarray['checkboxsepa'] : '', isset($dataconfigarray['checkboxsepz']) ? $dataconfigarray['checkboxsepz'] : '', isset($dataconfigarray['checkboxsepb']) ? $dataconfigarray['checkboxsepb'] : '', isset($dataconfigarray['checkboxsepy']) ? $dataconfigarray['checkboxsepy'] : '');

				// process strtoupper, strtolower, ucwords, ucfirst if checked in cat config for this field
				//$thefield = formatField($configrow->{"data_".$theindex."_config"}, $thefield);
				$thefield = formatField($dataconfigarray, $thefield); // changed to use $dataconfigarray in 1.1.0b3

				if ($wordwrapwidth) {
					$thefield = wordwrap($thefield, intval($wordwrapwidth), "\n", 1);
				}

				$before = replaceSpecialCharacters(convertFromQuotLtGt($configrow->{"data_".$theindex."_before"}), $thefield, $row, 1, $configrow->master_css, $configrow, $randomtagresultssofar);

				$after = replaceSpecialCharacters(convertFromQuotLtGt($configrow->{"data_".$theindex."_after"}), $thefield, $row, 1, $configrow->master_css, $configrow, $randomtagresultssofar);

				$content_string .= $before . ($configrow->master_css ? "<span style=\"" . $configrow->master_css . "\">" : "") . $thefield . ($configrow->master_css ? "</span>" : "") . $after . " ";
			}

		} /* end for loop */ 
		$content_string = "<div style=\"" . $configrow->container_div_css . "\">" . $content_string . "</div>\n";
	}
	if ($configrow->archive_score_script && $enable_archive_scorescript) {
		
		$database = &JFactory::getDBO(); 
		
		$database->setQuery("SELECT scor.scorescript
		 FROM #__madblanks_scorescripts AS scor, #__madblanks_categories AS cat
		 WHERE cat.id = " . $configrow->id . " AND scor.id = cat.archive_score_script
		 AND scor.published > 0");
		
		$scorescript = $database->loadResult();
			
		if ($scorescript) {
		
			$quizDataArray = scoreMadBlanksQuiz ($configrow->id, $row, $scorescript, $row->id, ';', null, null, $configrow->select_random_fields_number);
			$content_string .= "<div style=\"" . $configrow->css_archive_score_script. "\">" . $quizDataArray['scorescript'] . "</div>\n";
		}	
	}
	
	return $content_string;
}


/**
 * Convert certain HTML entities to plain text characters
 *
 * @param string $textinput
 * @return string
 */
function convertFromQuotLtGt($textinput) {
	return str_replace(array('&quot;','&lt;','&gt;'), array('"','<','>'), $textinput);
}	

/**
 * Convert certain plain text characters to HTML entities
 *
 * @param string $textinput
 * @return string
 */
function convertToQuotLtGt($textinput) {
	return str_replace(array('"','<','>'), array('&quot;','&lt;','&gt;'), $textinput);
}	

/**
 * Check whether records in a certain category can be edited on the frontend
 *
 * @param integer $category the category id number of the category to check
 * @return integer returns 1 for yes, 0 for no
 */
function checkRecordFrontendEditable($category) {
	$database = &JFactory::getDBO(); 
	$database->setQuery("SELECT published, allow_frontend_editing FROM #__madblanks_categories WHERE id=" . $category);
	$rows = $database->loadObjectList();
	if ($rows[0]->published && $rows[0]->allow_frontend_editing) {
		return 1;
	}
	return 0;
}

/**
 * Check whether a Mad Blanks module is authorized to approve and publish records of a given category,
 * as determined in the categories table row for that category (allow_module_approve and
 * allow_module_publish) 
 *
 * @param integer $category
 * @return array the returned array contains two values with the keys 'allow_module_approve' and 
 * 'allow_module_publish', which are set to 0 for no (not allowed) and 1 for yes (allowed)
 */
function checkApprovePublishByModuleOK($category) {
	$database = &JFactory::getDBO(); 
	$database->setQuery("SELECT allow_frontend_module_editing, allow_module_approve, allow_module_publish FROM #__madblanks_categories WHERE id=" . $category);
	$rows = $database->loadObjectList();
	return (array) $rows[0];
}

/**
 * Set the title of the HTML page
 *
 * @param string $thetitlestring the string to be set as the title
 */
function setMadBlanksPageTitle($thetitlestring=null) {
	/**
	 * $mbShowHTMLTitleTagData comes from the configuration file
 	 */
	global $mbShowHTMLTitleTagData;
	if ($mbShowHTMLTitleTagData) {
		global $mainframe, $mbComponentTitle;
		if (is_callable(array($mainframe, 'setPageTitle'))) {
			$mainframe->setPageTitle(html_entity_decode(stripslashes($mbComponentTitle) . (($mbShowHTMLTitleTagData > 1 && $thetitlestring) ? " - " . $thetitlestring : "")));
		}	
	}
}

/**
 * Check if a record exists so it can be edited on the frontend
 *
 * @param integer $id the id of the record to check the existence of
 * @return boolean
 */
function mbRecordExistsFrontendEditAllowed($id) {
	$database = &JFactory::getDBO(); 
	$database->setQuery("SELECT data.id FROM #__madblanks_records AS data, #__madblanks_categories AS cat WHERE data.configid = cat.id AND data.id=" . (int) $id . " AND cat.allow_frontend_editing > 0");
	return (bool) $database->loadResult();
}

/**
 * Validate variables used to sort SQL queries before using them in a query
 *
 * This function uses the array_key_exists() function to search the class 
 * variables to make sure that the variable exists in the class is valid and not
 * an attempt at hacked SQL
 *
 * @param string $orderby the name of the variable to sort by; this should
 * @param boolean $usecategory if false, use MadBlanksRecord class; if
 * true, use MadBlanksCategory class
 * match a valid variable from the MadBlanksRecord class
 * @param $if_not_valid return this string if $mbvariable is not valid
 * @return string name of the variable
 */
function isValidMadBlanksVariableForSQL($mbvariable, $usecategory, $if_not_valid) {
	
	$database = &JFactory::getDBO(); 
	
	if ($usecategory) {
		$classvars = new MadBlanksCategory($database);
	}
	else {
		$classvars = new MadBlanksRecord($database);
	}
	
	// the function 'array_key_exists()' works on objects as well as arrays
	if (array_key_exists($mbvariable, $classvars)) {
		return $mbvariable;
	}
	else {
		return $if_not_valid; // order by id as the default
	}	
}

/**
 * Return a portion of an SQL query designed to limit records results to users in a comma-delimited username list
 *
 * The list may contain the value [:none:] to include anonymous records
 *
 * @param string $usernamelist a list of usernames
 * @return string
 */
function usernameListFilter($usernamelist) {
	if (!$usernamelist) {
		return '';
	}	
	$usernamelist = str_replace("[:none:]", "NO__USER__ANONYMOUS", $usernamelist);	
	// 1.4.1 CPH 20101222 allow for spaces in usernames
	// replace anything that is not a word character or a space
	// (usernames can have word characters and spaces) with a comma
	$usernamelist = preg_replace('/[^\w ]/',',',$usernamelist);
	$filter_array = explode(',', $usernamelist);
	// remove any empty array elements
	//echo "<pre>filter_array\n\n"; print_r($filter_array); echo "</pre>\n";
	$keys_to_remove = array_keys($filter_array, '');
	//echo "<pre>keys_to_remove\n\n"; print_r($keys_to_remove); echo "</pre>\n";
	foreach($keys_to_remove as $key_to_remove) {
		unset($filter_array[$key_to_remove]);
	}
	//echo "<pre>filter_array\n\n"; print_r($filter_array); echo "</pre>\n";
	// remove extraneous
	foreach($filter_array as $filter_key => $filter_value) {
		$filter_array[$filter_key] = trim($filter_value);
	}
	$include_anonymous = array_search("NO__USER__ANONYMOUS", $filter_array); // returns false or null on failure
	if (is_int($include_anonymous)) { // this is an array key
		unset($filter_array[$include_anonymous]); // remove the string--it won't make sense in the query
	}
	$usernamelist = implode(',', $filter_array);
	$usernamelist = str_replace(',', "','", $usernamelist); // surround individual values with single quotes
	$usernamelist = "\nAND " . (is_int($include_anonymous) ? '(' : '') . "data.entered_by IN(SELECT id FROM #__users WHERE username IN ('" . $usernamelist . "'))";
	if (is_int($include_anonymous)) {
		$usernamelist .= ' OR data.entered_by = 0)';
	}
	return $usernamelist;
}

/**
 * Return SQL for Datetime Filter
 * 
 * input is 'YYYY-MM-DD HH:MM:SS' or 'today' or 'today-n' where n is an integer representing a number of days ago
 *
 * @param string $sqlsnippet a portion of SQL to insert before the output datetime
 * @param string $thedatetime the datetime input
 * @param string $defaulttimeportion if there is no time portion of the datetime value, use this 'HH:MM:SS' as the time portion
 * @return string
 */
function dateTimeFilter($sqlsnippet, $thedatetime, $defaulttimeportion='00:00:00') {
	
	if ($thedatetime) { // the filter contains data
		
		$hour_min_sec = explode(":", $defaulttimeportion);
		if (!isset($hour_min_sec[0])) {
			$hour_min_sec[0] = 0;
		}	
		if (!isset($hour_min_sec[1])) {
			$hour_min_sec[1] = 0;
		}	
		if (!isset($hour_min_sec[2])) {
			$hour_min_sec[2] = 0;
		}	

		if (strpos($thedatetime, "today") !== false) {
			// the filter contains the keyword 'today'
			
			$datearray = explode("-", $thedatetime); 

			// $datearray[0] should now contain "today";
			// $datearray[1] should not exist OR should contain an integer

			if ($datearray[0] == "today") {
				if (!isset($datearray[1])) {
					$datearray[1] = 0;
				}
				$thedatetime = date("Y-m-d H:i:s", mktime(intval($hour_min_sec[0]), intval($hour_min_sec[1]), intval($hour_min_sec[2]), date("m"), date("d") - intval($datearray[1]),  date("Y")));
			}
			else {
				$thedatetime = ''; // there is a problem--throw out the filter
			}	
		}
		
		else if (!preg_match("/\d{1,4}-\d{1,2}-\d{1,2}\040\d{1,2}:\d{1,2}:\d{1,2}/", $thedatetime)) {
		
			// the string given does not include a date AND a time
			// so, use the $defaulttimeportion
			$dateinfo = getdate(strtotime($thedatetime));
			$thedatetime = date("Y-m-d H:i:s", mktime(intval($hour_min_sec[0]), intval($hour_min_sec[1]), intval($hour_min_sec[2]), $dateinfo["mon"], $dateinfo["mday"], $dateinfo["year"]));
		}
		
		else { // we have a complete date and time string validate the date
			$thedatetime = date('Y\-m\-d\ H\:i\:s',strtotime(strval($thedatetime)));
		}

		if ($thedatetime) {
			return $sqlsnippet . "'" . $thedatetime . "'";
		}
	}
	
	return "";
}	

/**
 * Get Base Display Query
 *
 * Get the sql query that is common to display queries (other than random)
 * 
 * @param string $startdatetime if present, use only records that are no older than this datetime
 * @param string $enddatetime if present, use only records that are no newer than this datetime
 * @param string $user filter from the URI needed for the SQL display query; use only records entered by named users
 * @param string $additional_sql additional SQL for the query
 * @param string $order_by_etc end portion of the query; use null to prevent the default ORDER BY string from being added
 * @param string $select select portion of the query
 * @return string
 */
function getDisplayQuery($startdatetime, $enddatetime, $user, $additional_sql="", $order_by_etc="", $select="", $offset=0, $limit=0) {
	
	// if order_by_etc and select are both blank, include the "specialordering" feature
	if ($select == "" && $order_by_etc === "") { // check for type match on $order_by_etc too -> use null to prevent the default ORDER BY string from being added
		$select = "SELECT data.*, IF(data.ordering,1,0) AS specialordering";
		$order_by_etc="ORDER BY cat.ordering ASC, data.sticky DESC, specialordering DESC, data.ordering ASC, data.date_entered DESC, data.id DESC";
	}
	// if they are blank individually, do not include the "specialordering" feature
	if ($order_by_etc === "") { // check for type match too -> use null to prevent the default ORDER BY string from being added
		$order_by_etc="ORDER BY cat.ordering ASC, data.sticky DESC, data.ordering ASC, data.date_entered DESC, data.id DESC";
	}	
	if ($select == "") {
		$select = "SELECT data.*";
	}	
	
	$my = &JFactory::getUser();
	$basequery = $select;
	
	$basequery .= "\nFROM #__madblanks_records AS data, #__madblanks_categories AS cat
	WHERE data.configid = cat.id
	AND (
		(cat.restrict_viewing_to_creator > 0 AND data.entered_by = " . $my->id . " AND " . (/* check that there is a logged in user */$my->id ? 1 : 0) . ")
		OR (cat.restrict_viewing_to_creator = 0 AND data.entered_by > 0)
		OR (cat.allow_viewing_creatorless_records > 0 AND data.entered_by = 0)
		OR (cat.admins_see_all_creators AND " . (madblanks_user_is_administrator() ? "1" : "0") . ")
	)
	AND data.completed > 0
	AND data.approved > 0
	AND data.published > 0
	AND cat.published > 0";
	//AND cat.allow_frontend_viewing > 0";
	if ($startdatetime) {
		$basequery .= dateTimeFilter("\nAND data.date_entered >= ", $startdatetime, '00:00:00');
	}
	if ($enddatetime) {
		 $basequery .= dateTimeFilter("\nAND data.date_entered <= ", $enddatetime, '23:59:59');
	}
	if ($user) {
		$basequery .= usernameListFilter($user);
	}
	global $mbHideCheckedOut;
	if (!(empty($mbHideCheckedOut))) {
		$basequery .= "\nAND cat.checked_out = 0\nAND data.checked_out = 0";
	}
	$basequery .= "\n" . $additional_sql . "\n" . $order_by_etc;
	
	// if there is no $offset, make it 0 (zero)
	if (empty($offset)) {
		$offset = 0;
	}	

	// if there is no limit (limit set to zero), don't add LIMIT to the end of the query
	if (!empty($limit)) {
		$basequery .= "\nLIMIT " . $offset . "," . $limit;	
	}	
	
	//echo "<pre>basequery\n\n"; print_r($basequery); echo "</pre>";
	
	return $basequery;
}

/**
 * Open Plugin (Mambot) Buffer
 *
 * Start output buffering; plugins (mambots) will be applied to the buffer at the call of closePluginBuffer()
 */
function openPluginBuffer() {
	ob_start();
}

/**
 * Close Plugin (Mambot) Buffer
 *
 * End output buffering; apply plugins (mambots) to the buffer and print the text
 */
function closePluginBuffer() {

	$thebuffer->text = ob_get_contents();
	
	if (!class_exists('JFactory')) { // 1.0
		global $_MAMBOTS;
		$_MAMBOTS->loadBotGroup( 'content' );
		$_MAMBOTS->trigger( 'onPrepareContent', array(&$thebuffer, null, null), true );
	}
	else { // 1.5
		$thebuffer->text = JHTML::_('content.prepare', $thebuffer->text);
	}
	
	ob_end_clean(); // end output buffering
	echo $thebuffer->text;
	return;
}

/**
 * Return a randomized record for a given category
 *
 *
 * @param integer $category category id for the source of the randomized record
 * @param string $startdatetime if present, use only records that are no older than this datetime
 * @param string $enddatetime if present, use only records that are no newer than this datetime
 * @param string $user filter from the URI needed for the SQL display query; use only records entered by named users
 * @param string $additional_sql additional SQL passed ultimately to the getDisplayQuery() function
 * @return object
 */
function makeRandomizedRecord($category, $startdatetime, $enddatetime, $user, $additional_sql="") {

	global $mbFieldCount; // set at the top of this file
	
	$database = &JFactory::getDBO();
			
	// The following query determines which fields are active in the given category;
	//  only the active fields are sent to parseRandomTag().
	$thequery = "SELECT ";
	$thecolumns = "";

	for ($i=1; $i <= $mbFieldCount; $i++) {
		$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
		if ($thecolumns) {
			$thecolumns .= ",";
		}	
		$thecolumns .= "data_" . $theindex . "_use";
	}

	$thequery .= $thecolumns . " FROM #__madblanks_categories WHERE id = " . intval($category) . " LIMIT 1";

	$database->setQuery($thequery);
	$active_fields = $database->loadObjectList();
	// create an array 0-24 of which fields are active for this category
	$active_fields = array_values((array)$active_fields[0]);

	// In this case, the category is set.
	// This for loop represents the number of data_nn fields for a record in the database
	// In this for loop, parse any randomizer tags in all data fields for this record

	$randomtagresultssofar = array(); // array to cache random tag results

	for ($i=1; $i <= $mbFieldCount; $i++) {
		if ($active_fields[$i-1]) { // only use active fields for this category
			$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
			$row["data_".$theindex] = parseRandomTag("[:random@" . $category . "," . $i . ":]", $startdatetime, $enddatetime, 1, $randomtagresultssofar, $user, $additional_sql);
		}	
	}

	// In the following code, we keep empty records created by the randomizer
	//  from being passed to the $rows object and thus keep from displaying a
	//  blank randomized record.
	(bool) $rownotempty = false;
	if (!empty($row)) {
		foreach ($row as $row_element) {
			if ($row_element != ''){
				$rownotempty = true;
				break;
			}
		}
	}

	if ($rownotempty){
		$rows[0] = (object) $row;
		$rows[0]->configid = $category;
	}
	else { // row IS empty
		$rows = null;
	}

	return $rows;
}

/**
 * Present radio buttons and other form elements for the Create Single Record module
 *
 * added 20070630
 *
 * @param array $configarray array containing advanced category variables for the particular category field
 * @param string $defaultvalue the default selection for the form element
 * @param string $thedelimiter the delimiter between multiple options for check boxes or multiple select menus
 * @param string $horizorvert show form field vertically (insert <br /> before and after the field and in between options) or horizontally (inline) (default is vertical)
 * @param string $defvaldelimiter delimiter to use when interpreting whether there is more than one answer present in the default value
 * @return string
 */
function makeQuizForm ($configarray, $defaultvalue='', $thedelimiter=';', $horizorvert='vertical', $defvaldelimiter='[:multisep:]', &$configuration) {

	$empty_array = array(); // dummy value for replaceSpecialCharacters()
	
	//echo "<pre>";
	//print_r($configarray);
	//echo "</pre>";

	$defaultvalue = strval($defaultvalue);

	if ($defaultvalue == '') {
		$dummyconfigrow = null;
		//$defaultvalue = strval(parseMostRecentTag(str_replace('[:multisep:]', ';', convertMBEscapedToLiteral($configarray['multdefault'])), $dummyconfigrow, 2));
		// modified for 1.4.0 final; we now want [:multisep:] tags returned from parseMostRecentTag() intact (3rd arg = 0)
		$defaultvalue = strval(parseMostRecentTag(convertMBEscapedToLiteral($configarray['multdefault']), $dummyconfigrow, 0));
		$defvaldelimiter = '[:multisep:]';
	}
	else if ($defaultvalue == '[:blank:]') {
		$defaultvalue = '';
	}

	// if more than one default selection, make this an array
	if (strpos($defaultvalue, $defvaldelimiter) !== false) {
		$defaultvalue = explode($defvaldelimiter, $defaultvalue);
		foreach ($defaultvalue as $obj) {
			$defarr = array('value'=>replaceSpecialCharacters($obj, 0, null, 0, null, null, $empty_array));
			$defval[] = (object) $defarr;
			$last_default = $obj;
		}
		if ($configarray['usetextarea'] == 'checkbox' || $configarray['usetextarea'] == 'multi') {
			$defaultvalue = $defval;
		}
		else { // there can only be one default for the radio and pulldown menu form input types
			$defaultvalue = $last_default;
		}
		unset($defval, $defarr, $last_default);
	}
	else {

		$defaultvalue = replaceSpecialCharacters($defaultvalue, 0, null, 0, null, null, $empty_array);

	}	
	
	if (is_string($defaultvalue)) {
		$defaultvalue = trim($defaultvalue);
	}
	
	//echo "<pre>";
	//var_dump($defaultvalue);
	//echo "</pre>"; //exit;

	// php5 compatibility
	//$mosHTML = new mosHTML();

	if (!empty($configarray['usemultchoice']) && !empty($configarray['index'])) {
	
		if (!empty($configarray['multchoice'])) {
		
			//echo "<pre>HEK1\n";
			//print_r($configarray['multchoice']);
			//echo "</pre>";

			//echo "<pre>HEK2\n";
			//print_r(convertMBEscapedToLiteral($configarray['multchoice']));
			//echo "</pre>";

			//echo "<pre>HEK3\n";
			//print_r(replaceSpecialCharacters(convertMBEscapedToLiteral($configarray['multchoice'])));
			//echo "</pre>";

			if (empty($configarray['usesqlmultchoice'])) {
				$thechoices = explode($thedelimiter, convertMBEscapedToLiteral($configarray['multchoice']));
			}
			else {

				/*** CPH 20101208 1.4.1 add capability to load options to choose from using an 
				SQL query instead of a semicolon-delimited list; if the result is one entry, split
				it into options to choose from using the $delimiter; else if the result is more
				than one entry, use each entry returned as a choice to choose from.
				***/
				if (function_exists('htmlspecialchars_decode')) {
					$thequery = htmlspecialchars_decode(convertMBEscapedToLiteral($configarray['multchoice']));
				}
				else {
					$thequery = str_replace('&quot;', '"', convertMBEscapedToLiteral($configarray['multchoice']));
				}
				
				// allow limited use of Score Script syntax 
				$quizScore = array();
				if (is_array($configuration)) {
					$quizScore['category_id'] = $configuration['id'];
					$quizScore['category_name'] = $configuration['name'];
				}
				else if (is_object($configuration)) {
					$quizScore['category_id'] = $configuration->id;
					$quizScore['category_name'] = $configuration->name;
				}
								
				ob_start();
				echo @parseScoreScript($quizScore, $thequery);
				$thequery = ob_get_contents();
				ob_end_clean();

				$database =& JFactory::getDBO(); 
				$database->setQuery($thequery);
				//$theresults = $database->loadResultArray();
				//$theresults = $database->loadObjectList();
				$theresults = $database->loadRowList();
				
				//echo "<pre>database\n\n"; print_r($database); echo "</pre>\n";
				//echo "<pre>theresults\n\n"; print_r($theresults); echo "</pre>\n";
				
                               if (count($theresults) == 1 && !isset($theresults[0][1])) {
  					$thechoices = explode($thedelimiter, $theresults[0][0]);
					
					//echo "<pre>inside count theresults == 1\n\n"; print_r($thechoices); echo "</pre>\n";
					
					// create an associative array from the $thechoices array 
					//  whose keys are the same as its values
					foreach($thechoices as $thechoice) {
						$thechoicesassoc[$thechoice] = $thechoice;
					}
					$thechoices = $thechoicesassoc;
					unset($thechoicesassoc);
					
				}
				else {
					//$thechoices = $theresults;
					
					foreach ($theresults as $theresult) {

						// if $thresult has key 1 defined, use it as the label
						if (isset($theresult[1])) {
							$thechoices[$theresult[1]] = $theresult[0];
						}
						else {
							$thechoices[$theresult[0]] = $theresult[0];
						}
					}

				}
				//echo "<pre>thechoices\n\n"; print_r($thechoices); echo "</pre>\n";
				
			}

			//echo "<pre>HEK4\n";
			//print_r($thechoices);
			//echo "</pre>";
			
			// replaceSpecialCharacters() is performed after the split into an array
			//  because this may generate semicolons in HTML entities
			//  and semicolons are the explode delimiter by default
			//for ($i = 0; $i < count($thechoices); $i++) { 
			// CPH 20101214 The array is now associative
			foreach ($thechoices as $thechoicekey => $thechoicevalue) {
				//$thechoices[$i] = replaceSpecialCharacters($thechoices[$i], 0, null, 0, null, null, $empty_array);
				$thechoices[$thechoicekey] = replaceSpecialCharacters($thechoicevalue, 0, null, 0, null, null, $empty_array);
			}
			
			//echo "<pre>HEK5\n";
			//print_r($thechoices);
			//echo "</pre>";
			
			// Create an array of options.
			foreach ($thechoices as $thechkey => $thechoice) {
			
				//echo "\nthechoice is $thechoice<hr />\n";
				
				// 1.4.0 final find out if $thechoice contains a pattern like:
				//  &amp;amp; &amp;lt; or &amp;gt;
				// if so, check if making $defaultvalue double encoded would cause it to 
				//  be equal to this choice (option to choose from)
				// and if it is,
				//  modify the defaultvalue to match
				
				if (preg_match('/&amp;[A-Za-z0-9#]*?;/', $thechoice)) {
				
					//echo "\nMATCHED $thechoice<br />\n";
				
					if ($thechoice == str_replace('&', '&amp;', $defaultvalue)) {
						$defaultvalue = str_replace('&', '&amp;', $defaultvalue);
						//echo "\nREPLACED so that \$defaultvalue is $defaultvalue<br />\n";
					}	
				}	
								
				//$quizlist[] = mosHTML::makeOption($thechoice);
				// php5 compatibility
				//$mosHTML = new mosHTML(); // done at start of function
				//$quizlist[] =  JHTML::_('select.option', $thechoice);
				$quizlist[] =  JHTML::_('select.option', convertToQuotLtGt($thechoice), empty($configarray['usesqlmultchoice']) ? '' : $thechkey);
			
			}

			if ($configarray['randomorder']) {
				shuffle($quizlist);
			}
			
			// 1.4.0 RC1 20100801 Check for input attribute
			if (isset($configarray['inputattribute']) && $configarray['inputattribute'] == 'readonly') {
				$extraattribute = 'readonly="readonly" ';
			}
			else if (isset($configarray['inputattribute']) && $configarray['inputattribute'] == 'disabled') {
				$extraattribute = 'disabled="disabled" ';
			}
			else {
				$extraattribute = '';
			}

			//echo "\n<h1>Feeding defaultvalue $defaultvalue to the form control generator</h1>\n";
			//echo "<pre>Details:\n\n"; print_r($defaultvalue); echo "</pre>\n";

			// Generate the HTML radio button list.
			//$thefield .= mosHTML::radioList( $quizlist, 'multchoice_' . $configarray['index'], 'class="inputbox"', $configarray['multdefault']);
			//$theradiolist = mosHTML::radioList( $quizlist, 'data_' . $configarray['index'] . ($configarray['ischeckbox'] == 1 ? '[]' : ''), 'class="mbradio"', $defaultvalue[count($defaultvalue)-1]);
			if ($configarray['usetextarea'] == 'checkbox' || $configarray['usetextarea'] == 'radio') {
				// php5 compatibility
				//$mosHTML = new mosHTML(); // done at start of function
				//$theradiolist = mosHTML::radioList( $quizlist, 'data_' . $configarray['index'] . ($configarray['usetextarea'] == 'checkbox' ? '[]' : ''), 'class="mbradio"', $defaultvalue);
				$theradiolist = '<div class="' . ($configarray['usetextarea'] == 'radio' ? 'mblradiocollection' : 'mblcheckboxcollection') . '">' . JHTML::_('select.radiolist', $quizlist, 'data_' . $configarray['index'] . ($configarray['usetextarea'] == 'checkbox' ? '[]' : ''), $extraattribute . 'class="mbradio mblradio"' . (!empty($configarray['submitonchange']) ? ' onclick="this.form.submit();"' : ''), 'value', 'text', $defaultvalue) . '</div>';
			}
			else if ($configarray['usetextarea'] == 'pulldown') {
				// php5 compatibility
				//$mosHTML = new mosHTML(); // done at start of function
				//$theradiolist = mosHTML::selectList( $quizlist, 'data_' . $configarray['index'], 'class="mbradio"', 'value', 'text', $defaultvalue);
				$theradiolist = JHTML::_('select.genericlist',  $quizlist, 'data_' . $configarray['index'], $extraattribute . 'class="mblpulldown"' . (!empty($configarray['submitonchange']) ? ' onchange="this.form.submit();"' : ''), 'value', 'text', $defaultvalue);
			}	
			else if ($configarray['usetextarea'] == 'multi'){
				// php5 compatibility
				//$mosHTML = new mosHTML(); // done at start of function
				//$theradiolist = mosHTML::selectList( $quizlist, 'data_' . $configarray['index'] . '[]', 'class="mbradio" multiple="multiple"', 'value', 'text', $defaultvalue);
				$theradiolist = JHTML::_('select.genericlist',  $quizlist, 'data_' . $configarray['index'] . '[]', $extraattribute . 'class="mblmultiplechoicemenu" multiple="multiple"' . (!empty($configarray['submitonchange']) ? ' onchange="this.form.submit();"' : ''), 'value', 'text', $defaultvalue);
			}	
			if ($configarray['usetextarea'] == 'checkbox') {
				$theradiolist = str_replace(array("radio", "selected=\"selected\""), array("checkbox", "checked=\"checked\""), $theradiolist);
				
				// 1.1.0 Final remove brackets and any other non-alphanumeric characters
				//  for XHTML compatibility of input "id" attribute and label "for" attribute
				preg_match_all("/id=\"(.+?)\"/", $theradiolist, $matches, PREG_SET_ORDER);
				foreach ($matches as $match) {
					$theradiolist = str_replace($match[1], preg_replace('/\W/','',$match[1]), $theradiolist);	
				}
			}
		}
	}
	
	// initialize numcolumns in case it is not already set
	if (!isset($configarray['numcolumns']) || !is_numeric($configarray['numcolumns']) || $configarray['numcolumns'] < 1) {
		$configarray['numcolumns'] = 1;
	}	
	// add linebreak between options
	// category horizorvert per field option applies
	//if (($horizorvert != "vertical" && $horizorvert != "horizontal") || $configarray['numcolumns'] > 1) {
	//	$horizorvert = "vertical";
	//}
	if ($horizorvert == "vertical" || $configarray['numcolumns'] > 1) {
		// replaced in 1.1.0rc3 CPH 20090208 $theradiolist = "<br />\n" . str_replace("</label>", "</label><br />\n", $theradiolist);
		$theradiolist = str_replace("</label>", "</label><br />\n", $theradiolist);
	}	

	
	// Begin section to split check boxes into arrays
	if (($configarray['usetextarea'] == 'checkbox' || $configarray['usetextarea'] == 'radio') && $configarray['numcolumns'] > 1) {
		
		
		//echo "<pre>theradiolist going in is\n\n"; print_r($theradiolist); echo "</pre>\n";
		
		// explode the array
		$form_option_array = explode('<br />', $theradiolist);
		array_pop($form_option_array); // remove the last (empty) element of the array
		
		
		//echo "<pre>the exploded array is \n\n"; print_r($form_option_array); echo "</pre>\n";
		
		//echo "<h1>Note that horizorvert is $horizorvert</h1>";
		
		// figure out the row count
		$rowcount = ceil((count($form_option_array) / $configarray['numcolumns']));
		
		//echo "<br />Number of rows is " . $rowcount;

		// figure out how many spaces are left over in the block
		$leftovercells = ($configarray['numcolumns'] * $rowcount) - count($form_option_array);
		
		//echo "<br />the number of left over cells is $leftovercells";
		
		
		if ($horizorvert != 'vertical') {
			for ($i = 1; $i <= $leftovercells; $i++) {
				$form_option_array[] = '&nbsp;'; // make sure the last row of the table is complete
			}
		}
		
		// if we're making vertical columns (options go down rather than across), reorder the array to correspond
		else { //$horizorvert == 'vertical'
			
			$new_form_options = array(); // initialize new array
			
			$max_j = 0; // initialize max_j
			
			for ($i = 1; $i <= $rowcount; $i++) {
			
				$j = 0; // initialize inner counter
				
				while (1) {
					
					//echo "<br />at start of while loop, i is $i j is $j and max_j is $max_j";
					
					//echo "<br />processing  $i - 1 + (" . $rowcount . " * $j) = " . chr(65 + ($i - 1 + ($rowcount * $j)));
					
					if (!isset($form_option_array[$i - 1 + ($rowcount * $j)])) {
						if ($j < $max_j) {
							//echo " j $j is less than max_j $max_j";
							$new_form_options[] = '&nbsp;';
						}
						//echo " ABORT! ";
						break;
					}
					
					
					$new_form_options[] = $form_option_array[$i - 1 + ($rowcount * $j)];
					
					$j++;
					if ($max_j < $j) {
						$max_j = $j;
					}
				}
			}
			
			$form_option_array = $new_form_options;
			unset($new_form_options);
		
		}
		
		//echo "<pre>Resulting form_option_array is\n\n"; print_r($form_option_array); echo "</pre>\n";
		
		
		// write the table containing the check boxes or radio buttons
		
		// start the table and first row
		$theradiolist = "<table class=\"mblformcolumnstable\">\n<tr class=\"mblformcolumnsrow\"><td class=\"mblformcolumnsdata\">";
		
		
		$i = 0; // initialize
		while (isset($form_option_array[$i])) {
			if (($i + 1) % (int) $configarray['numcolumns'] == 0) { // $i % X where X is the number of columns to split into
				$theradiolist .= $form_option_array[$i] . "</td></tr>\n<tr class=\"mblformcolumnsrow\"><td class=\"mblformcolumnsdata\">";
			}
			else {
				$theradiolist .= $form_option_array[$i] . '</td><td class="mblformcolumnsdata">';
			}
			$i++;		
		}
		
		// end the last row and table
		$theradiolist .= '</td></tr></table>';
		
	}
	
	return $theradiolist;
}

/**
 * Decode colons and pipes from a coded format
 *
 * Colons and pipes are used as delimiters when saving advanced field variables for categories
 *
 * @param string $thestring string containing the escaped characters
 * @return string
 */
function convertMBEscapedToLiteral($thestring) {
	// 1.1.0rc2 added backslash
	return str_replace(array("[][COLON][]","[][PIPE][]","[][BACKSLASH][]"),array(":","|","\\"),$thestring);
}

/**
 * Encode (escape) colons and pipes to a coded format
 *
 * Colons and pipes are used as delimiters when saving advanced field variables for categories
 *
 * @param string $thestring string containing the characters to encode (escape)
 * @return string
 */
function convertMBLiteralToEscaped($thestring) {
	// 1.1.0rc2 added backslash
	return str_replace(array(":","|","\\"),array("[][COLON][]","[][PIPE][]","[][BACKSLASH][]"),$thestring);
}

/**
 * Return scoring information for a Mad Blanks Quiz
 *
 * @param integer $categoryid category id for the source of the quiz
 * @param object $datarow the contents of the record to be parsed
 * @param string $scorescript the Score Script string
 * @param integer $recordid the ID number of the record being processed, if applicable
 * @param string $thedelimiter the delimiter for the per-field multiple choice category setting
 * @param integer $sco_id the ID number of the Score Script being processed, if applicable
 * @return object an object containing the scores presented in various ways...
 */
function scoreMadBlanksQuiz ($categoryid, $datarow=null, $scorescript='', $recordid=null, $thedelimiter=';', $sco_id=null, $csr_module_id=null, $select_random_fields_number=0) {

	//echo "<pre>Incoming Data Row:
	//";
	//print_r($datarow);
	//echo "</pre>";

	//echo "<pre>Incoming Cat ID:
	//";
	//print_r($categoryid);
	//echo "</pre>";

	// initialize Quiz Score Data Array
	$quizScore = array();
	$quizScore['scorescript_id'] = $sco_id;
	$quizScore['csr_module_id'] = $csr_module_id;
	$quizScore['category_id'] = $categoryid;
	$quizScore['category_name'] = '';
	$quizScore['active_fields_in_category'] = 0;
	$quizScore['total_answers_in_category'] = 0;
	$quizScore['record_id'] = $recordid;
	$quizScore['info'] = null;
	$quizScore['answer'] = null;
    	$quizScore['number_of_correct_answers'] = 0;
    	$quizScore['number_of_incorrect_answers'] = 0;
	$quizScore['ratio_correct'] = 0;
    	$quizScore['percentage_correct'] = 0;
    	
    	// question subset added 1.4.0 Beta 4 20100329
    	$quizScore['subset_ratio_correct'] = 0;
	$quizScore['subset_percentage_correct'] = 0;
    	
    	$quizScore['total_points_earned_a'] = 0;
    	$quizScore['total_points_possible_a'] = 0;
    	$quizScore['points_ratio_a'] = 0;
    	$quizScore['points_percentage_a'] = 0;
    	$quizScore['total_points_b'] = 0;
    	$quizScore['total_points_earned_b'] = 0;

    	$quizScore['total_points_all_correct_b'] = 0;
    	$quizScore['total_points_correct_ratio_b'] = 0;
    	$quizScore['total_points_correct_percentage_b'] = 0;

	$quizScore['total_sum_all_points_b'] = 0;
    	$quizScore['total_accrued_sum_ratio_b'] = 0;
    	$quizScore['total_accrued_sum_percentage_b'] = 0;

	$quizScore['datarow'] = $datarow;

    	$quizScore['rawscorescript'] = '';
	$quizScore['scorescript'] = '';
	
	//$database = &JFactory::getDBO(); 
	//$database->setQuery("SELECT allow_frontend_module_editing, allow_module_approve, allow_module_publish FROM #__madblanks_categories WHERE id=" . $category);
	//$rows = $database->loadObjectList();
	//return (array) $rows[0];
	
	/******* BEGIN section for "Select the number of fields to choose randomly" 1.4.0 Beta 4 20100326 ******/

	$my =& JFactory::getUser();
	$select_random_fields_flag = false; // initialize flag
	if ($my->id && !empty($select_random_fields_number)) {
		$configuration = getConfigurationArray();
				
		//echo "<pre>"; print_r($configuration); echo "</pre>\n";exit;
		$field_assignments = getMadBlanksFieldAssignments($my->id, (array) $configuration[$categoryid], false);
		//echo "<pre>"; var_dump($field_assignments); echo "</pre>\n";exit;

		if ($field_assignments === false) {
			$field_assignments = array(); // dummy array
		}
		else if (is_array($field_assignments)){
			$select_random_fields_flag = true; // set flag
		}
	}
	$quizScore['select_random_fields_number'] = $select_random_fields_number;

	/******* _END_ section for "Select the number of fields to choose randomly" ******/
	
	global $mbFieldCount; // set at the top of this file
	$database = &JFactory::getDBO();
		
	// The following query determines which fields are active in the given category;
	//  only the active fields are sent to parseRandomTag().
	$thequery = "SELECT ";
	$thecolumns = "";

	for ($i=1; $i <= $mbFieldCount; $i++) {
		$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
		if ($thecolumns) {
			$thecolumns .= ",";
		}	
		$thecolumns .= "data_" . $theindex . "_config,data_" . $theindex . "_use,data_" . $theindex . "_name,data_" . $theindex . "_partofspeech,data_" . $theindex . "_before,data_" . $theindex . "_after";
	}

	// adding "id" to query for use by mostrecentlookup tag CPH 20081219 (also added in 1.1.0rc2)
	$thequery .= $thecolumns . ",name,allow_html_input,id FROM #__madblanks_categories WHERE id = " . intval($categoryid) . " LIMIT 1";
	//$thequery .= $thecolumns . ",name,allow_html_input FROM #__madblanks_categories WHERE id = " . intval($categoryid) . " LIMIT 1";

	$database->setQuery($thequery);
	$all_fields = $database->loadObjectList();
	
	//echo "<pre>All Fields:
	//";
	//print_r($all_fields);
	//echo "</pre>";
	
	$quizScore['category_name'] = $all_fields[0]->name;
	$quizScore['configrow'] = (object) $all_fields[0];
	
	for ($i=1; $i <= $mbFieldCount; $i++) {
		$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
		if ($all_fields[0]->{"data_".$theindex."_use"}) {
			$quizparameters[] = parseDataConfigString($all_fields[0]->{"data_".$theindex."_config"});
			//echo "<pre>\$quizparameters\n\n";
			//print_r($quizparameters);
			//echo "</pre>";
			$quizScore['info'][$theindex]['name'] = convertFromQuotLtGt($all_fields[0]->{"data_".$theindex."_name"});
			$quizScore['info'][$theindex]['partofspeech'] = convertFromQuotLtGt($all_fields[0]->{"data_".$theindex."_partofspeech"});
			$quizScore['info'][$theindex]['cluecuehint'] = $quizScore['info'][$theindex]['partofspeech']; // 1.1.0rc3
			$quizScore['info'][$theindex]['beforetext'] = convertFromQuotLtGt($all_fields[0]->{"data_".$theindex."_before"});
			$quizScore['info'][$theindex]['aftertext'] = convertFromQuotLtGt($all_fields[0]->{"data_".$theindex."_after"});

			$quizScore['info'][$theindex]['field_number'] = (int) $theindex;
			$quizScore['info'][$theindex]['field_number_padded'] = $theindex;
			
			if ($all_fields[0]->allow_html_input) {
				$quizScore['info'][$theindex]['user_response_raw'] = convertFromQuotLtGt($datarow->{"data_".$theindex});
				//$quizScore['info'][$theindex]['user_response'] = convertFromQuotLtGt(dataFieldToQuizFormat($datarow->{"data_".$theindex}, $quizparameters[count($quizparameters)-1]['checkboxsep1'], $quizparameters[count($quizparameters)-1]['checkboxsep2'], $quizparameters[count($quizparameters)-1]['checkboxsepa'], $quizparameters[count($quizparameters)-1]['checkboxsepz'], $quizparameters[count($quizparameters)-1]['checkboxsepb'], $quizparameters[count($quizparameters)-1]['checkboxsepy']));
				// added formatField in 1.1.0b3
				$quizScore['info'][$theindex]['user_response'] = formatField($quizparameters[count($quizparameters)-1], convertFromQuotLtGt(dataFieldToQuizFormat($datarow->{"data_".$theindex}, isset($quizparameters[count($quizparameters)-1]['checkboxsep1']) ? $quizparameters[count($quizparameters)-1]['checkboxsep1'] : '', isset($quizparameters[count($quizparameters)-1]['checkboxsep2']) ? $quizparameters[count($quizparameters)-1]['checkboxsep2'] : '', isset($quizparameters[count($quizparameters)-1]['checkboxsepa']) ? $quizparameters[count($quizparameters)-1]['checkboxsepa'] : '', isset($quizparameters[count($quizparameters)-1]['checkboxsepz']) ? $quizparameters[count($quizparameters)-1]['checkboxsepz'] : '', isset($quizparameters[count($quizparameters)-1]['checkboxsepb']) ? $quizparameters[count($quizparameters)-1]['checkboxsepb'] : '', isset($quizparameters[count($quizparameters)-1]['checkboxsepy']) ? $quizparameters[count($quizparameters)-1]['checkboxsepy'] : '')));
			}
			else {
				$quizScore['info'][$theindex]['user_response_raw'] = $datarow->{"data_".$theindex};
				//$quizScore['info'][$theindex]['user_response'] = dataFieldToQuizFormat($datarow->{"data_".$theindex}, $quizparameters[count($quizparameters)-1]['checkboxsep1'], $quizparameters[count($quizparameters)-1]['checkboxsep2'], $quizparameters[count($quizparameters)-1]['checkboxsepa'], $quizparameters[count($quizparameters)-1]['checkboxsepz'], $quizparameters[count($quizparameters)-1]['checkboxsepb'], $quizparameters[count($quizparameters)-1]['checkboxsepy']);
				// added formatField in 1.1.0b3
				$quizScore['info'][$theindex]['user_response'] = formatField($quizparameters[count($quizparameters)-1], dataFieldToQuizFormat($datarow->{"data_".$theindex}, isset($quizparameters[count($quizparameters)-1]['checkboxsep1']) ? $quizparameters[count($quizparameters)-1]['checkboxsep1'] : '', isset($quizparameters[count($quizparameters)-1]['checkboxsep2']) ? $quizparameters[count($quizparameters)-1]['checkboxsep2'] : '', isset($quizparameters[count($quizparameters)-1]['checkboxsepa']) ? $quizparameters[count($quizparameters)-1]['checkboxsepa'] : '', isset($quizparameters[count($quizparameters)-1]['checkboxsepz']) ? $quizparameters[count($quizparameters)-1]['checkboxsepz'] : '', isset($quizparameters[count($quizparameters)-1]['checkboxsepb']) ? $quizparameters[count($quizparameters)-1]['checkboxsepb'] : '', isset($quizparameters[count($quizparameters)-1]['checkboxsepy']) ? $quizparameters[count($quizparameters)-1]['checkboxsepy'] : ''));
			}

			$quizScore['active_fields_in_category']++;
			
			//initialize for later use
			$quizScore['info'][$theindex]['points_b'] = 0;
			$quizScore['answer'][$theindex]['points_b'] = 0;
			$quizScore['info'][$theindex]['points_b_sum'] = 0;
			
			// was this field selected as one of the random fields? added in 1.4.0 Beta 4 20100328
			if ($select_random_fields_flag && in_array($theindex, $field_assignments)) {
				$quizScore['info'][$theindex]['in_subset'] = 1;
			}
			else {
				$quizScore['info'][$theindex]['in_subset'] = 0;
			}
			
			//echo "<p>the count-1 is " . count($quizparameters) - 1 . "</p>";
		}
	}
	
	$correctanswer = array();
	
	// $quizparameters is set above to parseDataConfigString($all_fields[0]->{"data_".$theindex."_config"});
	foreach ($quizparameters as $quizparameter) {
	
		// if there exists a correct answer...
		if ($quizparameter['multcorrect'] != '' || ($quizparameter['multcorrect'] == '' && !empty($quizparameter['blankiscorrect']))) {
			$correctanswer[$quizparameter['index']] = convertMBEscapedToLiteral($quizparameter['multcorrect']);
			$quizScore['total_answers_in_category']++;
			$quizScore['answer'][$quizparameter['index']]['name'] = $quizScore['info'][$quizparameter['index']]['name'];
			$quizScore['answer'][$quizparameter['index']]['partofspeech'] = $quizScore['info'][$quizparameter['index']]['partofspeech'];
			$quizScore['answer'][$quizparameter['index']]['cluecuehint'] = $quizScore['answer'][$quizparameter['index']]['partofspeech']; //1.1.0rc3
			$quizScore['answer'][$quizparameter['index']]['beforetext'] = $quizScore['info'][$quizparameter['index']]['beforetext'];
			$quizScore['answer'][$quizparameter['index']]['aftertext'] = $quizScore['info'][$quizparameter['index']]['aftertext'];
			$quizScore['answer'][$quizparameter['index']]['field_number'] = $quizScore['info'][$quizparameter['index']]['field_number'];
			$quizScore['answer'][$quizparameter['index']]['field_number_padded'] = $quizScore['info'][$quizparameter['index']]['field_number_padded'];
			$quizScore['answer'][$quizparameter['index']]['correct_value_raw'] = convertMBEscapedToLiteral($quizparameter['multcorrect']);
			$quizScore['answer'][$quizparameter['index']]['correct_value'] = dataFieldToQuizFormat(str_replace(";", "[:multisep:]", convertMBEscapedToLiteral($quizparameter['multcorrect'])), isset($quizparameter['checkboxsep1']) ? $quizparameter['checkboxsep1'] : '', isset($quizparameter['checkboxsep2']) ? $quizparameter['checkboxsep2'] : '', isset($quizparameter['checkboxsepa']) ? $quizparameter['checkboxsepa'] : '', isset($quizparameter['checkboxsepz']) ? $quizparameter['checkboxsepz'] : '', isset($quizparameter['checkboxsepb']) ? $quizparameter['checkboxsepb'] : '', isset($quizparameter['checkboxsepy']) ? $quizparameter['checkboxsepy'] : '');
			$quizScore['answer'][$quizparameter['index']]['correct_case_sensitive'] = empty($quizparameter['multcasecorrect']) ? '0' : '1';
			$quizScore['answer'][$quizparameter['index']]['points_possible_a'] = $quizparameter['pointvalue'];
			$quizScore['answer'][$quizparameter['index']]['in_subset'] = $quizScore['info'][$quizparameter['index']]['in_subset']; // added in 1.4.0 Beta 4 20100328
			$quizScore['total_points_possible_a'] += $quizparameter['pointvalue'];
		}
		
		// points_array contains all the different possible points values depending on the possible answers

		if (isset($quizparameter['ptsperrspns'])) {
			$points_array = explode(";", $quizparameter['ptsperrspns']);
		}
		else {
			$points_array = array(0=>'');
		}

		//echo "<pre>";
		//print_r($points_array);
		//echo "</pre>";exit;
		//}

		// initialize
		$quizScore['answer'][$quizparameter['index']]['points_all_correct_b'] = 0;

		// add section to accomodate different point levels for different responses
		// store list of possible point values

		// start the array key's counter at 1 instead of 0
		$quizScore['info'][$quizparameter['index']]['point_value_b'] = array(null);

		foreach ($points_array as $points_per_response) {
			$quizScore['info'][$quizparameter['index']]['point_value_b'][] = $points_per_response;
			// total points possible if all options are selected
			$quizScore['info'][$quizparameter['index']]['points_b_sum'] += $points_per_response;
			$quizScore['total_sum_all_points_b'] += $points_per_response;

		}
		// remove the null array element with index 0
		unset($quizScore['info'][$quizparameter['index']]['point_value_b'][0]);

		// maximum individual point value for a single response
		$quizScore['info'][$quizparameter['index']]['points_b_max'] = max($points_array);

		// minimum individual point value for a single response
		$quizScore['info'][$quizparameter['index']]['points_b_min'] = min($points_array);

		// average individual point value for a single response
		$quizScore['info'][$quizparameter['index']]['points_b_avg'] = count($points_array) > 0 ? array_sum($points_array)/count($points_array) : 0;

		// average individual point value for a single response, expressed as an integer
		$quizScore['info'][$quizparameter['index']]['points_b_avg_integer'] = round($quizScore['info'][$quizparameter['index']]['points_b_avg']);
		
		// 1.4.2 CPH 20110225 selected answer, numeric (assuming radio buttons or pulldown list)
		$quizScore['info'][$quizparameter['index']]['selected_index'] = 0; // initialize

		// 1.4.2 CPH 20110225 selected answer, padded numeric (assuming radio buttons or pulldown list)
		$quizScore['info'][$quizparameter['index']]['selected_index_padded'] = strval('00'); // initialize

		// 1.4.2 CPH 20110225 selected answer, alphabetic (assuming radio buttons or pulldown list)
		$quizScore['info'][$quizparameter['index']]['selected_index_alpha'] = 0; // initialize

		// 1.4.2 CPH 20110226 selected count, count of selected answers (assuming check boxes or multiple choice list)
		$quizScore['info'][$quizparameter['index']]['selected_count'] = 0; // initialize

		// replaced the following line on 20070930 in 1.1.0B2 to allow for special characters
		//$choices_array = explode(";", $quizparameter['multchoice']);
		$choices_array = explode($thedelimiter, convertMBEscapedToLiteral($quizparameter['multchoice']));
		// replaceSpecialCharacters() is performed after the split into an array
		//  because this may generate semicolons in HTML entities
		//  and semicolons are the explode delimiter by default

		/***/
		// CPH 20091018 added short_choices string for use with charts
		// use array_combine() to create an array to use as a lookup table:
		//  what short choice VALUE corresponds to the long choice KEY?
		if (isset($quizparameter['shortmultchoice']) && convertMBEscapedToLiteral($quizparameter['shortmultchoice']) != '') {
			$quizScore['info'][$quizparameter['index']]['short_choices'] = explode($thedelimiter, convertMBEscapedToLiteral($quizparameter['shortmultchoice']));
		}
		else {
			// if there is no content in the shortmultchoice field,
			//  then make short_choices an array the same length as the $choices_array
			$quizScore['info'][$quizparameter['index']]['short_choices'] = array();
			$quizScore['info'][$quizparameter['index']]['short_choices'] = array_pad($quizScore['info'][$quizparameter['index']]['short_choices'], count($choices_array), '');
		}
		
		// force the short choices array to be the same length as the $choices_array
		//$correction = $choices_array_length - $short_choices_array_length;
		$correction = count($choices_array) - count($quizScore['info'][$quizparameter['index']]['short_choices']);
		//echo "<br />THE NEEDED CORRECTION IS $correction";
		
		if ($correction > 0) {
			//echo "<br />PADDING short_choices, 2nd argument to array_pad is the desired length, count($choices_array)";
			$quizScore['info'][$quizparameter['index']]['short_choices'] = array_pad($quizScore['info'][$quizparameter['index']]['short_choices'], count($choices_array), '');
		}
		else if ($correction < 0) {
			//echo "<br />TRIMMING short_choices to length $correction";
			for(1; $correction < 0; $correction++) {
				array_pop($quizScore['info'][$quizparameter['index']]['short_choices']);
			}
		}
		
		//echo "<pre>keys:\n"; print_r($choices_array); echo "</pre>\n";
		//echo "<pre>values\n"; print_r($quizScore['info'][$quizparameter['index']]['short_choices']); echo "</pre>\n"; 
		
		if (function_exists('array_combine')) { // php version 5
			$quizScore['info'][$quizparameter['index']]['short_choices'] = array_combine($choices_array, $quizScore['info'][$quizparameter['index']]['short_choices']);
		}
		else { // php version 4
			$short_temp = array(); // initialize
			foreach ($choices_array as $key => $choice) {
				$short_temp[$choice] = $quizScore['info'][$quizparameter['index']]['short_choices'][$key];
			}
			$quizScore['info'][$quizparameter['index']]['short_choices'] = $short_temp;
			unset($short_temp);
		}
		
		//echo "<pre>values\n"; print_r($quizScore['info'][$quizparameter['index']]['short_choices']); echo "</pre>\n"; 
		/***/
		
		$empty_array = array(); // dummy value for replaceSpecialCharacters()
		for ($i = 0; $i < count($choices_array); $i++) { 
			$choices_array[$i] = replaceSpecialCharacters($choices_array[$i], 0, null, 0, null, null, $empty_array);
		}
			
		// start the array key's counter at 1 instead of 0
		$quizScore['info'][$quizparameter['index']]['possible_choice'] = array(null);
		$quizScore['info'][$quizparameter['index']]['possible_choice_lowercase'] = array(null);
		$quizScore['info'][$quizparameter['index']]['possible_choice_selected'] = array(null);

		foreach ($choices_array as $choice) {
			$quizScore['info'][$quizparameter['index']]['possible_choice'][] = $choice;
			$quizScore['info'][$quizparameter['index']]['possible_choice_lowercase'][] = JString::strtolower($choice);
			$quizScore['info'][$quizparameter['index']]['possible_choice_selected'][] = '0';
		}
		// remove the null array element with index 0
		unset($quizScore['info'][$quizparameter['index']]['possible_choice'][0]);
		unset($quizScore['info'][$quizparameter['index']]['possible_choice_lowercase'][0]);
		unset($quizScore['info'][$quizparameter['index']]['possible_choice_selected'][0]);
		//}
		
	}
	
	// 1.4.2 CPH 20110225a initialize array of characters for use with selected_index_alpha
	$alpha_array = _MBL_SELECTED_INDEX_ALPHA;
	
	for ($i=1; $i <= $mbFieldCount; $i++) {
		$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
		if ($all_fields[0]->{"data_".$theindex."_use"}) {
	
			$actual_answers = explode("[:multisep:]", $quizScore['info'][$theindex]['user_response_raw']);

			//echo "<pre>";
			//print_r($actual_answers);
			//echo "</pre>";
			//exit;

			// search the choices array for each actual answer
			// if the answer is present, add the point value for that answer to points_earned

			// raw double quotation marks in the answer string are converted to &quot;
			foreach ($actual_answers as $actual_answer) {
				$possiblechoiceindex = array_search(str_replace('"', '&quot;', $actual_answer), $quizScore['info'][$theindex]['possible_choice']);
				if ($possiblechoiceindex !== false) {
					$quizScore['info'][$theindex]['points_b'] += isset($quizScore['info'][$theindex]['point_value_b'][$possiblechoiceindex]) ? $quizScore['info'][$theindex]['point_value_b'][$possiblechoiceindex] : 0;
					$quizScore['answer'][$theindex]['points_b'] += isset($quizScore['info'][$theindex]['point_value_b'][$possiblechoiceindex]) ? $quizScore['info'][$theindex]['point_value_b'][$possiblechoiceindex] : 0;
					$quizScore['total_points_b'] += isset($quizScore['info'][$theindex]['point_value_b'][$possiblechoiceindex]) ? $quizScore['info'][$theindex]['point_value_b'][$possiblechoiceindex] : 0;
					$quizScore['info'][$theindex]['possible_choice_selected'][$possiblechoiceindex] = '1';
					// 1.4.2 CPH 20110225 selected answer, numeric (assuming radio buttons or pulldown list)
					$quizScore['info'][$theindex]['selected_index'] = $possiblechoiceindex; // initialize

					// 1.4.2 CPH 20110225 selected answer, padded numeric (assuming radio buttons or pulldown list)
					$quizScore['info'][$theindex]['selected_index_padded'] = strval(sprintf('%02d', $possiblechoiceindex)); // initialize

					// 1.4.2 CPH 20110225 selected answer, alphabetic (assuming radio buttons or pulldown list)
					//  use the last character in the string/array if there aren't enough choices
					if (!($possiblechoiceindex >= strlen($alpha_array) + 1)) {
						$alpha_index = $possiblechoiceindex - 1;
					}
					else {
						$alpha_index = strlen($alpha_array) - 1;
					}
					$quizScore['info'][$theindex]['selected_index_alpha'] = $alpha_array[$alpha_index]; // initialize
					
					// 1.4.2 CPH 20110226 selected count, count of selected answers (assuming check boxes or multiple choice list)
					$quizScore['info'][$theindex]['selected_count']++; // initialize

				}	
			}
		}
	}	
	
	//echo "<pre>Correct answer
	//";
	//print_r($correctanswer);
	//echo "</pre>";
	
	//echo "<pre>Datarow is:";
	//print_r($datarow);
	//echo "</pre>";
	
	// for each field where a correct answer exists:
	foreach ($correctanswer as $correctanswerkey => $correctanswervalue) {
		
		//$quizScore['answer'][$correctanswerkey]['user_response'] = $datarow->{"data_".$correctanswerkey};
		$quizScore['answer'][$correctanswerkey]['user_response_raw'] = $datarow->{"data_".$correctanswerkey};
		$quizScore['answer'][$correctanswerkey]['user_response'] = $quizScore['info'][$correctanswerkey]['user_response'];
		$quizScore['answer'][$correctanswerkey]['selected_index'] = $quizScore['info'][$correctanswerkey]['selected_index']; // added in 1.4.2 20110227
		$quizScore['answer'][$correctanswerkey]['selected_index_padded'] = $quizScore['info'][$correctanswerkey]['selected_index_padded']; // added in 1.4.2 20110227
		$quizScore['answer'][$correctanswerkey]['selected_index_alpha'] = $quizScore['info'][$correctanswerkey]['selected_index_alpha']; // added in 1.4.2 20110227
		$quizScore['answer'][$correctanswerkey]['selected_count'] = $quizScore['info'][$correctanswerkey]['selected_count']; // added in 1.4.2 20110227
		$quizScore['answer'][$correctanswerkey]['possible_choice'] = $quizScore['info'][$correctanswerkey]['possible_choice']; // added in 1.4.2 20110227
		$quizScore['answer'][$correctanswerkey]['possible_choice_selected'] = $quizScore['info'][$correctanswerkey]['possible_choice_selected']; // added in 1.4.2 20110227

		//$quizScore['answer'][$correctanswerkey]['points_possible'] = $quizScore['answer'][$correctanswerkey]['pointvalue'];
		
		//echo "1 is " . $datarow->{"data_".$correctanswerkey} . " and 2 is $correctanswervalue<br /><br />\n";
		
		// This array contains the answers selected by the user
		//$userarray = explode("[:multisep:]", $datarow->{"data_".$correctanswerkey});
		
		// 1.1.0rc3 case sensitivity NOT in effect (multcasecorrect == 0)
		if ($quizScore['answer'][$correctanswerkey]['correct_case_sensitive'] == 0) {
			//echo "<p style=\"color: red;\">case sensitivity NOT in effect for field #$correctanswerkey</p>\n";
			$userarray = explode("[:multisep:]", JString::strtolower($datarow->{"data_".$correctanswerkey}));
			$correctarray = explode(";", JString::strtolower($correctanswervalue));
		}
		
		// 1.1.0rc3 case sensitivity in effect (multcasecorrect == 1)
		else {
			//echo "<p style=\"color: green;\">case sensitivity YES IN EFFECT for field #$correctanswerkey</p>\n";
			$userarray = explode("[:multisep:]", $datarow->{"data_".$correctanswerkey});
			$correctarray = explode(";", $correctanswervalue);
		}
		
		// This array contains the correct answers
		//$correctarray = explode(";", $correctanswervalue);
		
		//echo "<pre>userarray\n";
		//print_r($userarray);
		//echo "</pre>";
		
		//echo "<pre>correctarray\n";
		//print_r($correctarray);
		//echo "</pre>";
		
		// if the user answered with the correctarray, how many points would he get
		//  in the case where there are different point values for each response?

		// search the choices array for each correct answer
		// if the answer is present, add the point value for that answer to points_earned
		foreach ($correctarray as $ca_key => $correct_answer) {

			// 1.4.0 RC1 add case sensitivity check to fix bug where points_earned_b not being calculated with case sensitivity off
			if ($quizScore['answer'][$correctanswerkey]['correct_case_sensitive'] == 0) {
				$possiblechoiceindex = array_search(JString::strtolower($correct_answer), $quizScore['info'][$correctanswerkey]['possible_choice_lowercase']);
			}	
			else {
				$possiblechoiceindex = array_search($correct_answer, $quizScore['info'][$correctanswerkey]['possible_choice']);
			}
			
			if ($possiblechoiceindex !== false) {
				if (isset($quizScore['info'][$correctanswerkey]['point_value_b'][$possiblechoiceindex])) {
					$quizScore['answer'][$correctanswerkey]['points_all_correct_b'] += $quizScore['info'][$correctanswerkey]['point_value_b'][$possiblechoiceindex];
					$quizScore['total_points_all_correct_b'] += $quizScore['info'][$correctanswerkey]['point_value_b'][$possiblechoiceindex];
				}	
				
			} 
			$empty_array = array();
			$correctarray[$ca_key] = replaceSpecialCharacters($correct_answer, 0, null, 0, null, null, $empty_array);
		}

		// This array contains all the values of $correctarray that are also present in $userarray
		//$intersectedarray = array_intersect($correctarray, $userarray);
		//echo "<pre>intersectedarray\n";
		//print_r($intersectedarray);
		//echo "</pre>";
		
		//if ($datarow->{"data_".$correctanswerkey} == $correctanswervalue) {}
		//if (implode("", $intersectedarray) == implode("", $correctarray)) {}
		
		sort($userarray);
		sort($correctarray);

		//echo "<br />userarray<pre>";
		//print_r($userarray);
		//echo "</pre>";

		//echo "<br />correctarray<pre>";
		//print_r($correctarray);
		//echo "</pre>";

		if (implode("", $userarray) == implode("", $correctarray)) {

			//echo "<br />MADE IT HERE; CORRECT";
			
			//echo "<br />intersectedarray<pre>";
			//print_r($intersectedarray);
			//echo "</pre>";
			
			//echo "<p>the arrays are equal and the answer is correct</p>";
		
			//echo "<br />$correctanswerkey is correct! the entered answer was $correctanswervalue";
			$quizScore['answer'][$correctanswerkey]['is_correct'] = 1;
			$quizScore['number_of_correct_answers']++;
			//$quizScore['total_points_earned'] += $quizScore['answer'][$correctanswerkey]['pointvalue'];
			$quizScore['total_points_earned_a'] += $quizScore['answer'][$correctanswerkey]['points_possible_a'];
			//$quizScore['answer'][$correctanswerkey]['points_earned'] = $quizScore['answer'][$correctanswerkey]['pointvalue'];
			$quizScore['answer'][$correctanswerkey]['points_earned_a'] = $quizScore['answer'][$correctanswerkey]['points_possible_a'];
			$quizScore['answer'][$correctanswerkey]['points_earned_b'] = $quizScore['answer'][$correctanswerkey]['points_all_correct_b'];
			$quizScore['total_points_earned_b'] += $quizScore['answer'][$correctanswerkey]['points_earned_b'];
		}
		else {
			//echo "<p>the arrays are not equal and the answer is INCORRECT</p>";
			
			//echo "<br />$correctanswerkey is NOT correct! the entered answer was " . $datarow->{"data_".$correctanswerkey} . " and the correct answer was $correctanswervalue";
			$quizScore['answer'][$correctanswerkey]['is_correct'] = 0;
			$quizScore['number_of_incorrect_answers']++;
			$quizScore['answer'][$correctanswerkey]['points_earned_a'] = 0;
			$quizScore['answer'][$correctanswerkey]['points_earned_b'] = 0;
		}
	
		// 1.4.2 20110227 add [:answer:n:possible_choice_correct:m:]
		$quizScore['answer'][$correctanswerkey]['possible_choice_correct'] = array(); // initialize
		foreach($quizScore['info'][$correctanswerkey]['possible_choice'] as $possible_choice_key => $possible_choice_value) {
		

			//if ($quizScore['answer'][$correctanswerkey]['correct_case_sensitive'] == 0) {
			//	$possible_choice_checkmarked = array_search(JString::strtolower($possible_choice_value), $quizScore['info'][$correctanswerkey]['possible_choice_lowercase']);
			//}	
			//else {
			//	$possible_choice_checkmarked = array_search($possible_choice_value, $quizScore['info'][$correctanswerkey]['possible_choice']);
			//}
			
			// is it checked?
			if (isset($quizScore['info'][$correctanswerkey]['possible_choice_selected'][$possible_choice_key]) && $quizScore['info'][$correctanswerkey]['possible_choice_selected'][$possible_choice_key]) {
				// yes
				$status_checked = true;
			}
			else {
				// no
				$status_checked = false;
			}
			
			//echo "<h1 style=\"color: purple;\">correctanswerkey: {$correctanswerkey} possible_choice_key: {$possible_choice_key} possible_choice_value: {$possible_choice_value} status_checked: " . ($status_checked ? 'true' : 'false') . "</h1>\n";
			
			// now search for $possible_choice_value in the correctarray
			if ($quizScore['answer'][$correctanswerkey]['correct_case_sensitive'] == 0) {
				$exists_in_correctarray = array_search(JString::strtolower($possible_choice_value), $correctarray);
			}	
			else {
				$exists_in_correctarray = array_search($possible_choice_value, $correctarray);
			}

			// does its value exist in $correctarray?
			if ($exists_in_correctarray !== false) {
				// yes
				//echo "<h1>EXISTS IN CORRECTARRAY</h1>";
				$exists_in_correctarray = true;
			}
			else {
				// no
				//echo "<h1>NOT EXISTS IN CORRECTARRAY</h1>";
				$exists_in_correctarray = false;
			}
			
			// is the value supposed to be there and it is there?
			if ($exists_in_correctarray && $status_checked) { // entry is correct
				$quizScore['answer'][$correctanswerkey]['possible_choice_correct'][$possible_choice_key] = 1;
			}
			// is the value supposed to be there and it is not there?
			else if ($exists_in_correctarray && !$status_checked) { // entry is NOT correct
				$quizScore['answer'][$correctanswerkey]['possible_choice_correct'][$possible_choice_key] = 0;
			}			
			// is the value not supposed to be there and it is there?
			else if (!$exists_in_correctarray && $status_checked) { // entry is NOT correct
				$quizScore['answer'][$correctanswerkey]['possible_choice_correct'][$possible_choice_key] = 0;
			}			
			// is the value not supposed to be there and it is not there?
			else if (!$exists_in_correctarray && !$status_checked) { // entry is correct
				$quizScore['answer'][$correctanswerkey]['possible_choice_correct'][$possible_choice_key] = 1;
			}
			// code should never go here
			else {
				$quizScore['answer'][$correctanswerkey]['possible_choice_correct'][$possible_choice_key] = 0;
			}
		}
	}

	if ($quizScore['total_answers_in_category'] > 0) {
		$quizScore['ratio_correct'] = $quizScore['number_of_correct_answers'] / $quizScore['total_answers_in_category'];
		$quizScore['percentage_correct'] = round($quizScore['number_of_correct_answers'] / $quizScore['total_answers_in_category'] * 100);

	}

	// question subset added 1.4.0 Beta 4 20100329
	if ($quizScore['select_random_fields_number'] > 0) {
		$quizScore['subset_ratio_correct'] = $quizScore['number_of_correct_answers'] / $quizScore['select_random_fields_number'];
		$quizScore['subset_percentage_correct'] = round($quizScore['number_of_correct_answers'] / $quizScore['select_random_fields_number'] * 100);
	}	
    	
	// CPH 20090520 1.1.0final add abs to allow use of negative points
	if (abs($quizScore['total_points_possible_a']) > 0) {
		$quizScore['points_ratio_a'] = $quizScore['total_points_earned_a'] / $quizScore['total_points_possible_a'];
		$quizScore['points_percentage_a'] = round($quizScore['total_points_earned_a'] / $quizScore['total_points_possible_a'] * 100);
	}

	// CPH 20090520 1.1.0final add abs to allow use of negative points
	if (abs($quizScore['total_points_all_correct_b']) > 0) {
		$quizScore['total_points_correct_ratio_b'] = $quizScore['total_points_earned_b'] / $quizScore['total_points_all_correct_b'];
		$quizScore['total_points_correct_percentage_b'] = round($quizScore['total_points_earned_b'] / $quizScore['total_points_all_correct_b'] * 100);
	}

	// CPH 20090520 1.1.0final add abs to allow use of negative points
	if (abs($quizScore['total_sum_all_points_b']) > 0) {
		$quizScore['total_accrued_sum_ratio_b'] = $quizScore['total_points_b'] / $quizScore['total_sum_all_points_b'];
		$quizScore['total_accrued_sum_percentage_b'] = round($quizScore['total_points_b'] / $quizScore['total_sum_all_points_b'] * 100);
	}

	$quizScore['rawscorescript'] = $scorescript;


	//echo "<pre>Quiz Score Data before parseScoreScript() is:
	//";
	//print_r($quizScore);
	//echo "</pre>";

	$quizScore['scorescript'] = parseScoreScript($quizScore, $scorescript);
	
	//echo "\n<hr />\n" . $quizScore['scorescript'] . "\n<hr />\n";

	//echo "<pre>Quiz Score Data is:
	//";
	//print_r($quizScore);
	//echo "</pre>";

	return $quizScore;
}

/**
 * Parse a Score Script (score a quiz or other user input)
 *
 * Note that this function is called recursively as needed; the $quizScore array stays constant (called by reference)
 *
 * @param array $quizScore array containing scoring information for the quiz based on the category settings from the function scoreMadBlanksQuiz()
 * @param string $scorescript the raw Score Script input
 * @param boolean $pssdebug enable or disable display of debugging information for the function
 * @return string the translated Score Script ready for viewing by the user
 */
function parseScoreScript(&$quizScore, $scorescript, $pssdebug=0) {

	//echo "<pre>";
	//print_r($quizScore);
	//echo "</pre>";

	if ($pssdebug) {
		global $pssIterationAtBeginning, $pssIterationAtEnd, $pssMaxRecursionLevel;
		if (!isset($pssIterationAtBeginning)) {
			// initialize variables that will allow us to track iterations and recursion level
			$pssIterationAtBeginning = 0;
			$pssIterationAtEnd = 0;
			$pssMaxRecursionLevel = 0;
			// begin debug background color div 'buttermilk'
			echo "\n<div style=\"border: 1px solid black; background-color: #fef1b5; max-width: 80%;\">
			<div style=\"font-size: larger; text-align: center; font-weight: bold; border: 1px dashed red; margin: 0 0 1em 0;\">BEGIN parseScoreScript() DEBUG OUTPUT</div>\n";
			
			$app =& JFactory::getApplication();
			$app->enqueueMessage('Entering parseScoreScript');
			/*
			jimport('joomla.error.log');
			$log =& JLog::getInstance('sco.php');
			$entry = array(
				'LEVEL' => '1',
				'STATUS' => 'LOADED SCORE SCRIPT',
				'COMMENT' => 'no comment'
			);
			$log->addEntry($entry);
			*/
		}	

		$pssIterationAtBeginning++;

		//echo " parseScoreScript() was called (entered parseScoreScript() $pssIterationAtBeginning times, returned parseScoreScript() $pssIterationAtEnd times, begin recursion level " . ($pssIterationAtBeginning - $pssIterationAtEnd) . "); ";
		pssDebugMessage('psscall_called1returned2recursionlevel3', $pssIterationAtBeginning, $pssIterationAtEnd, $pssIterationAtBeginning - $pssIterationAtEnd);

		//echo " \$scorescript input is \n<div style=\"border: 1px solid blue; color: blue;\">\n" 
		//. htmlspecialchars($scorescript) . "\n</div>\n";
		pssDebugMessage('scorescriptinput1', $scorescript);
	}

	// To use alternate double parenthesis syntax in place of angle
	//  brackets, uncomment the line below
	// example: [:comment:((start)):] and [:comment:((end)):] 
	//$scorescript = str_replace(array('((', '))'), array('<', '>'), $scorescript);

	// CPH 20091007
	// First, include a file relative to Joomla's root and parse it as part of the Score Script
	if (strpos($scorescript, "[:include:<") !== false) {  // an 'include' tag probably exists in the string
	
		if (preg_match_all("/\[:include:<(.+)>:\]/", $scorescript, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				
				$file = JPATH_SITE . $match[1];
				$fd = fopen($file,"r");
				$file_contents = fread($fd, filesize($file));
				fclose($fd);
								
				$scorescript = str_replace($match[0], $file_contents, $scorescript);
				unset($file);
			}
		}
	
	}

	// Next, replace comment tags
	if (strpos($scorescript, "[:comment:<") !== false) {  // a 'comment' tag probably exists in the string
		
		if ($pssdebug) {
			//echo " we appear to have found at least one comment tag; ";
			pssDebugMessage('appearfoundatleastone1', 'comment tag');
		}	
		
		// ungreedy quantifier to capture comments (.*?) over multiple lines (s)
		preg_match_all("/\[:comment:<start>:\](.*?)\[:comment:<end>:\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if ($pssdebug) {
			//echo " we found " . count($matches) . " actual sets of comment tags; ";
			pssDebugMessage('foundactual12', count($matches), 'sets of comment tags');
		}
		
		foreach ($matches as $match_key => $match) {
			
			if ($pssdebug) {
				//echo " removing <span style=\"color: red;\">"
				//. htmlspecialchars($match[0]) . "</span> from \$scorescript (set $match_key); ";
				pssDebugMessage('removing12withindex3', 'set of comment tags', $match[0], $match_key);
			}
			
			$scorescript = str_replace($match[0], "", $scorescript);
		}

	}
	
	// Next, collect expressions
	if (strpos($scorescript, "<expression") !== false) {  // an 'expression' tag probably exists in the string

		if ($pssdebug) {
			//echo " we appear to have found at least one expression definition; ";
			pssDebugMessage('appearfoundatleastone1', 'expression definition');
		}	

		unset($matches);
		//preg_match_all("/\<expression:(\d+)\>(.*?)\<\/expression\>/s", $scorescript, $matches, PREG_SET_ORDER);
		// 20100509a added expression groups, ability to name expression anything, case insensitive
		//GOOD preg_match_all("/\<expression:([a-zA-Z0-9_]+)(:([a-zA-Z0-9_]+))??\>(.*?)\<\/expression\>/s", $scorescript, $matches, PREG_SET_ORDER);
		//BAD preg_match_all("/\<expression:([a-zA-Z0-9_]+)(?::([a-zA-Z0-9_]+)(?::([a-zA-Z0-9_]+))?)??\>(.*?)\<\/expression\>/s", $scorescript, $matches, PREG_SET_ORDER);
		//preg_match_all("/\<expression:([a-zA-Z0-9_]+)(:([a-zA-Z0-9_]+))??\>(.*?)\<\/expression\>/s", $scorescript, $matches, PREG_SET_ORDER);
		//preg_match_all("/\<expression((?::\w*?)+)\>(.*?)\<\/expression\>/s", $scorescript, $matches, PREG_SET_ORDER);

		preg_match_all("/\<expression((?::[^:]*?)+)\>(.*?)\<\/expression\>/s", $scorescript, $matches, PREG_SET_ORDER);
		
		
		if ($pssdebug) {
			//echo " we found " . count($matches) . " actual expression definitions; ";
			pssDebugMessage('foundactual12', count($matches), 'expression definitions');
		}

		foreach ($matches as $match) {
			//echo "<pre>Expressions pre:\n";
			//var_dump($match);
			//echo "</pre>\n";
			
			$match = array_merge(array($match[0], $match[2]), explode(':', ltrim($match[1], ':')));
			
			//echo "<pre>Expressions post:\n";
			//var_dump($match);
			//echo "</pre>\n";
			
			// older: $match[1] is the expression identifier
			// older: $match[2] is the contents of the expression

			// old: $match[1] is the expression identifier
			// old: $match[3] (if present) is the group the expression belongs to
			// old: $match[4] is the contents of the expression
			
			// new: $match[1] is the contents of the expression
			// new: $match[2] is the expression identifier
			// new: $match[3] (if present) is the group the expression belongs to
			// new: $match[4] (if present) is the alternative name (short name) of the expression
			
			global ${'mbexpression' . JString::strtolower($match[2])};
			${'mbexpression' . JString::strtolower($match[2])} = $match[1];
			if ($pssdebug) {
				//echo pssDebugStart() . 'Setting expression ' . pssDebugStyleString('mbexpression' . JString::strtolower($match[2]), 'identifier') . ' to ' . pssDebugStyleString($match[1], 'set_to')  . pssDebugEnd();
				pssDebugMessage('setting12to3', 'expression', JString::strtolower($match[2]), $match[1]);
			}
			if (!empty($match[3])) {
				global ${'mbexpression__group' . JString::strtolower($match[3])};
				//global ${'mbexpression__group_shortnames' . JString::strtolower($match[3])};
				// add the contents of the expression to the array for the group (case insensitive group name)
				
				// if a short name is available, use it as the array element's index
				if (isset($match[4]) && $match[4] != '') {
					${'mbexpression__group' . JString::strtolower($match[3])}['___' . $match[4]] = parseScoreScript($quizScore, $match[1]);
				}
				else {
					${'mbexpression__group' . JString::strtolower($match[3])}[] = parseScoreScript($quizScore, $match[1]);
				}	
				
				
				//${'mbexpression__group_shortnames' . JString::strtolower($match[3])}[] = $match[4];
			}
			$scorescript = str_replace($match[0], '', $scorescript);
		}
		//echo "<pre>Final expressions array:\n";
		//print_r($mbexpressions);
		//echo "</pre>\n";

		//echo "<pre>Final expressions group victor:\n";
		//print_r(${'mbexpression__groupvictor'});
		//echo "</pre>\n";

	}
	
	// Next, replace "global" tags that never change context.
	$scorescript = str_replace("[:scorescript_id:]", $quizScore['scorescript_id'], $scorescript); // added in 1.3.0 Beta 1 CPH 20091023
	$scorescript = str_replace("[:csr_module_id:]", $quizScore['csr_module_id'], $scorescript); // added in 1.3.0 Beta 1 CPH 20091023
	
	$scorescript = str_replace("[:category_id:]", $quizScore['category_id'], $scorescript);
	$scorescript = str_replace("[:record_id:]", $quizScore['record_id'], $scorescript);
	$scorescript = str_replace("[:category_name:]", $quizScore['category_name'], $scorescript);
	$scorescript = str_replace("[:total_answers_in_category:]", $quizScore['total_answers_in_category'], $scorescript);
	$scorescript = str_replace("[:number_of_correct_answers:]", $quizScore['number_of_correct_answers'], $scorescript);
	$scorescript = str_replace("[:number_of_incorrect_answers:]", $quizScore['number_of_incorrect_answers'], $scorescript);
	$scorescript = str_replace("[:ratio_correct:]", $quizScore['ratio_correct'], $scorescript);
	$scorescript = str_replace("[:percentage_correct:]", $quizScore['percentage_correct'], $scorescript);
	
	// question subset added 1.4.0 Beta 4 20100329
	$scorescript = str_replace('[:subset_ratio_correct:]', $quizScore['subset_ratio_correct'], $scorescript);
	$scorescript = str_replace('[:subset_percentage_correct:]', $quizScore['subset_percentage_correct'], $scorescript);

	$scorescript = str_replace("[:total_points_possible_a:]", $quizScore['total_points_possible_a'], $scorescript);
	$scorescript = str_replace("[:total_points_earned_a:]", $quizScore['total_points_earned_a'], $scorescript);
	$scorescript = str_replace("[:points_ratio_a:]", $quizScore['points_ratio_a'], $scorescript);
	$scorescript = str_replace("[:points_percentage_a:]", $quizScore['points_percentage_a'], $scorescript);
	
	$scorescript = str_replace("[:total_points_b:]", $quizScore['total_points_b'], $scorescript);
	$scorescript = str_replace("[:total_points_earned_b:]", $quizScore['total_points_earned_b'], $scorescript);

	$scorescript = str_replace("[:total_points_all_correct_b:]", $quizScore['total_points_all_correct_b'], $scorescript);
	$scorescript = str_replace("[:total_points_correct_ratio_b:]", $quizScore['total_points_correct_ratio_b'], $scorescript);
	$scorescript = str_replace("[:total_points_correct_percentage_b:]", $quizScore['total_points_correct_percentage_b'], $scorescript);
	$scorescript = str_replace("[:total_sum_all_points_b:]", $quizScore['total_sum_all_points_b'], $scorescript);
	$scorescript = str_replace("[:total_accrued_sum_ratio_b:]", $quizScore['total_accrued_sum_ratio_b'], $scorescript);
	$scorescript = str_replace("[:total_accrued_sum_percentage_b:]", $quizScore['total_accrued_sum_percentage_b'], $scorescript);
	
	$scorescript = str_replace('[:rawcomment:<start>:]', '', $scorescript);
	$scorescript = str_replace('[:rawcomment:<end>:]', '', $scorescript);
	
	$scorescript = str_replace('[:pi:]', pi(), $scorescript); // added in 1.4.0 Beta 3 20100322
	
	$scorescript = str_replace('[:subset_count:]', $quizScore['select_random_fields_number'], $scorescript); // added in 1.4.0 Beta 4 20100328

	// user-related tags added in 1.1.0 RC1
	$my =& JFactory::getUser();

	$scorescript = str_replace("[:user_id_number:]", $my->id, $scorescript);
	$scorescript = str_replace("[:user_name:]", $my->username, $scorescript);
	$scorescript = str_replace("[:user_full_name:]", $my->name, $scorescript);
	$scorescript = str_replace("[:user_email:]", $my->email, $scorescript);
	$scorescript = str_replace("[:user_type:]", $my->usertype, $scorescript);
	$scorescript = str_replace("[:user_register_date:]", $my->registerDate, $scorescript);
	$scorescript = str_replace("[:user_last_visit_date:]", $my->lastvisitDate, $scorescript);
	$scorescript = str_replace("[:user_is_guest:]", $my->id == 0 ? 1 : 0, $scorescript);
	
	// user-related tags added in 1.2.2 CPH 20091007
	$scorescript = str_replace('[:user_ip_address:]', isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '', $scorescript);
	$scorescript = str_replace('[:user_host:]', isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : '', $scorescript);
	$scorescript = str_replace('[:user_user_agent:]', isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '', $scorescript);
	$scorescript = str_replace('[:user_referer:]', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '', $scorescript);
	
	/* BEGIN TIME INTERVAL TAGS */
	
	if (strpos($scorescript, "[:timeout:") !== false) {  // yes, an 'timeout' tag (probably) exists in the string
	
		unset($matches); // is this necessary?
		preg_match_all("/\[:timeout((?::(?:userorsession|timeout)\{[^\}]*?\})*):\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if (!empty($matches)) {

			if ($pssdebug) {
				echo " we found " . count($matches) . " actual timeout tags; ";
				echo "<br />Begin timeout tags foreach<br />\n";
				$pssTimeoutIndex = 1;
			}

			foreach ($matches as $match) {
				
				unset($timeout_tag_data); // Reset the variable that will hold the components of the timeout function call this loop
				
				if ($pssdebug) {
					echo "<hr />timeout tag number $pssTimeoutIndex:<br />\n";
				}	
				//echo "<pre>";
				//print_r($match);
				//echo "</pre>";
				
				// $match[1] starts with a colon and contains (curly brace colon)-delimited timeout elements
				$timeout_elements = preg_split("/(?<=}):/s", ltrim($match[1], ":"));

				if ($pssdebug) {
					echo "<br />timeout elements:<pre>";
					print_r($timeout_elements);
					echo "</pre>\n";
				}		

				$timeout_tag_data = array();

				foreach ($timeout_elements as $timeout_element) {

					// userorsession (not an array)
					if (strpos($timeout_element, "userorsession{") !== false) {
						// ungreedy quantifier (.*?) over multiple lines (s)
						preg_match("/userorsession{(.*?)}/s", $timeout_element, $timeout_element_match);
						if (isset($timeout_element_match[1]) && $timeout_element_match[1] != "") {
							// if userorsession is already filled, don't fill it again
							$timeout_tag_data['userorsession'] = empty($timeout_tag_data['userorsession']) ? parseScoreScript($quizScore, $timeout_element_match[1]) : $timeout_tag_data['userorsession'];
							continue;
						}	
					}
				
					// timeout (not an array)
					if (strpos($timeout_element, "timeout{") !== false) {
						// ungreedy quantifier (.*?) over multiple lines (s)
						preg_match("/timeout{(.*?)}/s", $timeout_element, $timeout_element_match);
						if (isset($timeout_element_match[1]) && $timeout_element_match[1] != "") {
							// if timeout is already filled, don't fill it again
							$timeout_tag_data['timeout'] = empty($timeout_tag_data['timeout']) ? parseScoreScript($quizScore, $timeout_element_match[1]) : $timeout_tag_data['timeout'];
							continue;
						}	
					}

				}	
				if ($pssdebug) {
					echo "<br />timeout tag data array before defaults get filled in:<pre>";
					print_r($timeout_tag_data);
					echo "</pre>\n";
				}	


				if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php')) {
				/**
				 * Include the component configuration file
				 */
					include JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php';
				}

				if (!isset($timeout_tag_data['userorsession'])) {
					if (isset($mbDefaultSSTimeoutUserOrSession)) {
						$timeout_tag_data['userorsession'] = parseScoreScript($quizScore, $mbDefaultSSTimeoutUserOrSession);
					}	
					else {
						$timeout_tag_data['userorsession'] = 'session';
					}
				}
				// validate
				if (!($timeout_tag_data['userorsession'] == 'session' || $timeout_tag_data['userorsession'] == 'user')) {
					$timeout_tag_data['userorsession'] = 'session'; // 'session' by default
				}
				if (!isset($timeout_tag_data['timeout'])) {
					if (isset($mbDefaultSSTimeoutTimeout)) {
						$timeout_tag_data['timeout'] = parseScoreScript($quizScore, $mbDefaultSSTimeoutTimeout);
					}
					else {
						$timeout_tag_data['timeout'] = 'now'; // 'now' by default will always return 0 (OK)
					}
				}

				if ($pssdebug) {
					echo "<br />timeout tag data array, with defaults from the config file filled in and points validated as numeric (0 if not):<pre>";
					print_r($timeout_tag_data);
					echo "</pre>";
					echo '<br />Attempting to determine whether interval specified by ' . $timeout_tag_data['timeout'] . ' has passed for the ' . $timeout_tag_data['userorsession'];
				}

				//= getCSRBeginTime($newrecordcategory, &$moduleid, $userorsession='session', $getwhat='interval', $timeout=0) {
				$timeout_result = getCSRBeginTime($quizScore['category_id'], $quizScore['csr_module_id'], $timeout_tag_data['userorsession'], 'interval', $timeout_tag_data['timeout']);
				
				if ($pssdebug) {
					// Looking at the code, the return value does not tell us anything useful
					echo '<br />timeout function returned: ';
					var_dump($timeout_result);
				}
			
				// remove the tag from the Score Script
				// 1 means timed out
				// 0 means not timed out (OK)
				$scorescript = str_replace($match[0], $timeout_result, $scorescript);
				
				if ($pssdebug) {
					$pssTimeoutIndex++;
				}	
			} // end foreach $matches as $match
		} // end if (!empty($matches))
	} // end if strpos [:timeout:
	/* END TIME INTERVAL TAGS */
	
	// Next, replace standard non-dynamic info tags
	//$pos = strpos($scorescript, "[:info:");
	if (strpos($scorescript, "[:info:") !== false) {  // yes, an 'info' array tag (probably) exists in the string		
		
		if ($pssdebug) {
			echo " we appear to have found at least one info tag; ";
		}	
		
		unset($matches);
		// 1.4.2 20110228 CPH changed ending of regex from :((\d+):)*\] to :((\d+):)?\]
		preg_match_all("/\[:info:(\d+):(name|partofspeech|cluecuehint|beforetext|aftertext|user_response|user_response_raw|possible_choice|possible_choice_selected|point_value_b|points_b|points_b_sum|points_b_max|points_b_min|points_b_avg|points_b_avg_integer|in_subset|selected_index|selected_index_padded|selected_index_alpha|selected_count):((\d+):)?\]/", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual info tags; ";
		}

		foreach ($matches as $match) {
			//echo "<pre>Matches are:
			//";
			//print_r($match);
			//echo "</pre>";
			
			// 20080124 110b3
			// added the following conditional and its else to prevent error messages when the requested info field is not defined
			if (isset($quizScore['info'][sprintf('%02d', $match[1])][$match[2]])) {
				if (isset($match[4])) {
					$scorescript = str_replace($match[0], $quizScore['info'][sprintf('%02d', $match[1])][$match[2]][$match[4]], $scorescript);
				}
				else {
					$scorescript = str_replace($match[0], $quizScore['info'][sprintf('%02d', $match[1])][$match[2]], $scorescript);
				}
			}
			// data needed to replace the tag is not present, so replace it with an empty string
			else {
				$scorescript = str_replace($match[0], "", $scorescript);
			}
		}
	}
	
	// Next, replace "each" tags
	//$pos = strpos($scorescript, "[:each");
	if (strpos($scorescript, "[:each") !== false) {  // yes, an 'each' array tag (probably) exists in the string		
		
		if ($pssdebug) {
			echo " we appear to have found at least one set of 'each' tags; ";
		}	
		
		// Replace "each info" tags
		unset($matches);
		
    		// PREG_SET_ORDER Orders results so that $matches[0] is an array of first set of matches,
    		//  $matches[1] is an array of second set of matches, and so on.
		// in each matching array, array position zero is the entire match and array position one is in between 
		//  the parentheses, without the start and end tags
		preg_match_all("/\[:each:info:<start>(:subset)??:\](.*?)\[:each:info:<end>:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual sets of 'each info' tags; ";
		}

		//echo "<pre>\n'EACH INFO' MATCHES START NEXT LINE\n";
		//print_r($matches);
		//echo "\n'EACH INFO' MATCHES END PREV LINE\n</pre>";
		
		foreach ($matches as $match) {
			
			$concatenated_info_string = ''; // initialize

			foreach($quizScore['info'] as $info_array) {
			
				// check for :subset flag and only run this iteration of the loop if this field is in the subset 1.4.0 Beta 4 20100329
				if ($match[1] != '' && !$info_array['in_subset']) {
					continue;
				}
				
				//echo "<pre>Info Array is:\n";
				//print_r($info_array);
				//echo "</pre>\n";
				
				$parsed_info_iteration = str_replace("[:name:]",$info_array['name'],$match[2]);
				$parsed_info_iteration = str_replace("[:partofspeech:]",$info_array['partofspeech'],$parsed_info_iteration);
				$parsed_info_iteration = str_replace("[:cluecuehint:]",$info_array['partofspeech'],$parsed_info_iteration); // 1.1.0rc3
				$parsed_info_iteration = str_replace("[:beforetext:]",$info_array['beforetext'],$parsed_info_iteration);
				$parsed_info_iteration = str_replace("[:aftertext:]",$info_array['aftertext'],$parsed_info_iteration);
				$parsed_info_iteration = str_replace("[:field_number:]",$info_array['field_number'],$parsed_info_iteration);
				$parsed_info_iteration = str_replace("[:field_number_padded:]",$info_array['field_number_padded'],$parsed_info_iteration);
				$parsed_info_iteration = str_replace("[:user_response:]",$info_array['user_response'],$parsed_info_iteration);
				$parsed_info_iteration = str_replace("[:user_response_raw:]",$info_array['user_response_raw'],$parsed_info_iteration);
				
				$parsed_info_iteration = str_replace("[:points_b:]",$info_array['points_b'],$parsed_info_iteration);

				$parsed_info_iteration = str_replace("[:points_b_sum:]",$info_array['points_b_sum'],$parsed_info_iteration);
				$parsed_info_iteration = str_replace("[:points_b_max:]",$info_array['points_b_max'],$parsed_info_iteration);
				$parsed_info_iteration = str_replace("[:points_b_min:]",$info_array['points_b_min'],$parsed_info_iteration);
				$parsed_info_iteration = str_replace("[:points_b_avg:]",$info_array['points_b_avg'],$parsed_info_iteration);
				$parsed_info_iteration = str_replace("[:points_b_avg_integer:]",$info_array['points_b_avg_integer'],$parsed_info_iteration);
				
				$parsed_info_iteration = str_replace('[:in_subset:]',$info_array['in_subset'],$parsed_info_iteration); // added in 1.4.0 Beta 4 20100328
				
				$parsed_info_iteration = str_replace("[:selected_index:]",$info_array['selected_index'],$parsed_info_iteration); // added in 1.4.2 20110227
				$parsed_info_iteration = str_replace("[:selected_index_padded:]",$info_array['selected_index_padded'],$parsed_info_iteration); // added in 1.4.2 20110227
				$parsed_info_iteration = str_replace("[:selected_index_alpha:]",$info_array['selected_index_alpha'],$parsed_info_iteration); // added in 1.4.2 20110227
				$parsed_info_iteration = str_replace("[:selected_count:]",$info_array['selected_count'],$parsed_info_iteration); // added in 1.4.2 20110227

				//[:accrued_sum_ratio_b:] The actual accrued type B points divided by the sum of all type B points from every option
				// CPH 20090520 1.1.0final add abs to allow use of negative points
				$parsed_info_iteration = str_replace("[:accrued_sum_ratio_b:]", abs($info_array['points_b_sum']) > 0 ? $info_array['points_b'] / $info_array['points_b_sum'] : 0, $parsed_info_iteration);

				//[:accrued_sum_percentage_b:] The actual accrued type B points divided by the sum of all type B points from every option, expressed as a rounded whole number percentage
				// CPH 20090520 1.1.0final add abs to allow use of negative points
				$parsed_info_iteration = str_replace("[:accrued_sum_percentage_b:]", abs($info_array['points_b_sum']) > 0 ? round($info_array['points_b'] / $info_array['points_b_sum'] * 100) : 0, $parsed_info_iteration);

				// The e modifier makes preg_replace()  treat the replacement parameter as PHP code after the appropriate references substitution is done.
				preg_replace('/\[:point_value_b:(\d+):\]/e', '$parsed_info_iteration = isset($info_array["point_value_b"]["$1"]) ? str_replace("$0", $info_array["point_value_b"][$1], $parsed_info_iteration) : str_replace("$0", "", $parsed_info_iteration);', $parsed_info_iteration);
				preg_replace('/\[:possible_choice:(\d+):\]/e', '$parsed_info_iteration = isset($info_array["possible_choice"]["$1"]) ? str_replace("$0", $info_array["possible_choice"][$1], $parsed_info_iteration) : str_replace("$0", "", $parsed_info_iteration);', $parsed_info_iteration);
				preg_replace('/\[:possible_choice_selected:(\d+):\]/e', '$parsed_info_iteration = isset($info_array["possible_choice_selected"]["$1"]) ? str_replace("$0", $info_array["possible_choice_selected"][$1], $parsed_info_iteration) : str_replace("$0", "", $parsed_info_iteration);', $parsed_info_iteration);

				$concatenated_info_string .= $parsed_info_iteration;
			}
			
			// CPH 20090520 1.1.0final replaced bug in next line $matches[0] should be $match[0]
			$scorescript = str_replace($match[0], $concatenated_info_string, $scorescript);
		}

		
		//echo "<pre>\nincoming scorescript starts next line:\n";
		//print_r($scorescript);
		//echo "\nincoming scorescript ended prev line\n</pre>";
		
		// Replace "each answer" tags
		unset($matches);
		
    		// PREG_SET_ORDER Orders results so that $matches[0] is an array of first set of matches,
    		//  $matches[1] is an array of second set of matches, and so on.
		// in each matching array, array position zero is the entire match and array position one is in between 
		//  the parentheses, without the start and end tags
		preg_match_all("/\[:each:answer:<start>(:subset)??:\](.*?)\[:each:answer:<end>:\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if ($pssdebug) {
			echo " we found " . count($matches) . " actual sets of 'each answer' tags; ";
		}

		//echo "<pre>matches:\n";
		//print_r($matches);
		//echo "\n</pre>\n";

		// For each set of each answer start and end tags and the string in between, do this:
		foreach ($matches as $match) {
		
			//echo "Here is the data on the set of each answer start and end 
			//tags and the string in between for this time around:";
			//echo "<pre>match:\n";
			//print_r($match);
			//echo "\n</pre>\n";
			
			$concatenated_answer_string = ''; // initialize

			
			// For each question that has a correct answer, do this:
			foreach($quizScore['answer'] as $answer_index => $answer_array) {
			
				// $quizScore['answer'][XX]['name'] where XX is a field index number in the range 01-25 (by 
				//  default) is only defined if that field has a correct answer specified
				if (!isset($answer_array['name'])) {
					// there is no answer defined for this field index, and
					//  therefore no need to do this iteration of the foreach
					continue;
				}
				
				// check for :subset flag and only run this iteration of the loop if this field is in the subset 1.4.0 Beta 4 20100329
				if ($match[1] != '' && !$answer_array['in_subset']) {
					continue;
				}	
				
				//echo "<pre>answer_array at start of foreach loop\n";
				//print_r($answer_array);
				//echo "</pre>";
				
				//$this_iteration = $match[1]; // initialize
				$this_iteration = $match[2]; // initialize
			
				//echo "<br /><br />THIS_ITERATION SHOULD SHOW UP FINE, FULLY INTACT ORIGINAL: A" . $this_iteration . "Z<br /><br />";

				//echo "<hr size=\"10\"/><p>We are starting a loop for question number $answer_index, which has a correct answer.
				//The text between the 'each answer start' and 'each answer end' tags that we are looking for special 
				//tags in is A" . $this_iteration . "Z</p>\n";
				
				// begin is correct or incorrect special tags section
				unset($correctsections);
				preg_match_all("/\[:<start_correct>:\](.*?)\[:<end_correct>:\]/s", $this_iteration, $correctsections, PREG_SET_ORDER);

				if ($pssdebug) {
					echo " we found " . count($correctsections) . " actual pairs of start_correct and end_correct tags; ";
				}

				//echo "<p>Looking for &lt;start_correct&gt; and &lt;end_correct&gt; tags in this_iteration;
				//here is what we found:<pre>\n";
				//print_r($correctsections);
				//echo "</pre>";

				foreach ($correctsections as $correctsection) {
					if ($quizScore['answer'][$answer_index]['is_correct']) {
						//echo "here1";
						
						//echo "<p>This answer (" . $answer_index . ") is correct.
						//We are therefore going to take the 
						//&lt;start_correct&gt; and &lt;end_correct&gt; 
						//tags and what is
						//between them and process their contents with parseAnswerIteration().
						//We are starting with this_iteration as A<font color=\"purple\">" . $this_iteration . "</font>Z.</p>";
						
						$this_iteration = str_replace($correctsection[0], parseAnswerIteration($answer_array, $correctsection[1]), $this_iteration);
						//$this_iteration = parseAnswerIteration($answer_array, $correctsection[1]);

						//echo "<p>Now this_iteration looks like
						//A<font color=\"red\">" . $this_iteration . "</font>Z.</p>";


					}
					else { // the text is not relevant so delete it

						//echo "<p>This answer (" . $answer_index . ") is INCORRECT.
						//We are therefore going to take the 
						//&lt;start_correct&gt; and &lt;end_correct&gt; 
						//tags and what is
						//between them and delete the whole thing from the string.
						//We are starting with this_iteration as A<font color=\"purple\">" . $this_iteration . "</font>Z.</p>";

						$this_iteration = str_replace($correctsection[0], "", $this_iteration);

						//echo "<p>Now this_iteration looks like
						//A<font color=\"red\">" . $this_iteration . "</font>Z.</p>";
					}
				}

				//echo "<p>this_iteration is now A<font color=\"orange\">" . $this_iteration . "</font>Z.</p>";

				unset($incorrectsections);
				preg_match_all("/\[:<start_incorrect>:\](.*?)\[:<end_incorrect>:\]/s", $this_iteration, $incorrectsections, PREG_SET_ORDER);

				if ($pssdebug) {
					echo " we found " . count($incorrectsections) . " actual pairs of start_incorrect and end_incorrect tags; ";
				}
				//echo "<p>Looking for &lt;start_incorrect&gt; and &lt;end_incorrect&gt; tags in this_iteration;
				//here is what we found:<pre>\n";
				//print_r($incorrectsections);
				//echo "</pre>";

				foreach ($incorrectsections as $incorrectsection) {
					if (!$quizScore['answer'][$answer_index]['is_correct']) {
					
						//echo "<p>This answer (" . $answer_index . ") is INCORRECT.
						//We are therefore going to take the 
						//&lt;start_incorrect&gt; and &lt;end_incorrect&gt; 
						//tags and what is
						//between them and process their contents with parseAnswerIteration().
						//We are starting with this_iteration as A<font color=\"purple\">" . $this_iteration . "</font>Z.</p>";
					
					
						$this_iteration = str_replace($incorrectsection[0], parseAnswerIteration($answer_array, $incorrectsection[1]), $this_iteration);

						//echo "<p>Now this_iteration looks like
						//A<font color=\"red\">" . $this_iteration . "</font>Z.</p>";
					}	
					else { // the text is not relevant so delete it
						
						//echo "<p>This answer (" . $answer_index . ") is CORRECT.
						//We are therefore going to take the 
						//&lt;start_incorrect&gt; and &lt;end_incorrect&gt; 
						//tags and what is
						//between them and delete the whole thing from the string.
						//We are starting with this_iteration as A<font color=\"purple\">" . $this_iteration . "</font>Z.</p>";
						
						$this_iteration = str_replace($incorrectsection[0], "", $this_iteration);
					
						//echo "<p>Now this_iteration looks like
						//A<font color=\"red\">" . $this_iteration . "</font>Z.</p>";
					}
				}
				// end is correct or incorrect special tags section

				//echo "<p>Now we are going to process any tags that we have not yet parsed</p>";
				//echo "<pre>answer_array before call\n";
				//print_r($answer_array);
				//echo "</pre>";
				
				// now catch any tags we haven't yet parsed
				$this_iteration = parseAnswerIteration($answer_array, $this_iteration);
				
				//echo "<p>Now this_iteration looks like
				//A<font color=\"red\">" . $this_iteration . "</font>Z.
				//We are now appending it to concatenated_answer_string, and we will go 
				//to the next QUESTION THAT HAS AN ANSWER in the loop if there is one</p>";
				
				$concatenated_answer_string .= $this_iteration;

				//echo "<p>We are ENDING a loop for question number $answer_index, which has a correct answer.
				//Concatenated answer string is 
				//now <font color=\"midnightblue\">" . $concatenated_answer_string . "</font>.</p>\n";
			
			} // END For each question that has a correct answer, do this
			
			// too late here? $concatenated_answer_string .= parseAnswerIteration($answer_array, $this_iteration);
			// This line was in error; fixed in 1.1.0rc3 CPH 20090207: $scorescript = str_replace($matches[0], $concatenated_answer_string, $scorescript);
			$scorescript = str_replace($match[0], $concatenated_answer_string, $scorescript);
			
		} // END For each set of each answer start and end tags and the string in between, do this
		
		// too late here? $scorescript = str_replace($matches[0], $concatenated_answer_string, $scorescript);

	} // END the if conditional looking for "[:each"


	// after replacing each tags, now replace operator tags

	// start with arithmetic tags	[:arithmetic:{1}:+:{1}:]
	if (strpos($scorescript, "[:arithmetic:") !== false) {  // yes, an arithmetic operator tag (probably) exists in the string
		
		if ($pssdebug) {
			echo " we appear to have found at least one arithmetic tag; ";
		}
		
		unset($matches);
		preg_match_all("/\[:arithmetic:{(.*?)}:(\+|\-|\*|\/|\%):{(.*?)}:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual arithmetic tags; ";
		}
		
		foreach ($matches as $match) {
			
			//echo "<pre>arithmetic tag contents:\n";
			//print_r($match);
			//echo "</pre>";
			
			// process any special tags within the arithmetic tag
			if ($pssdebug) {
				echo " parseScoreScript() is now being called to process the arithmetic tag first operand; ";
			}
			$match[1] = parseScoreScript($quizScore, $match[1]);
			if ($pssdebug) {
				echo " parseScoreScript() is now being called to process the arithmetic tag second operand; ";
			}
			$match[3] = parseScoreScript($quizScore, $match[3]);
			
			if ($match[2] == "+") {
				if ($pssdebug) {
					echo "replacing arithmetic tag ". pssDebugReplaceThisString($match[0]) . " with " . pssDebugReplacedString($match[1] + $match[3]) . "; ";
				}
				$scorescript = str_replace($match[0], $match[1] + $match[3], $scorescript);	
			}	
			else if ($match[2] == "-") {
				if ($pssdebug) {
					echo "replacing arithmetic tag ". pssDebugReplaceThisString($match[0]) . " with " . pssDebugReplacedString($match[1] - $match[3]) . "; ";
				}
				$scorescript = str_replace($match[0], $match[1] - $match[3], $scorescript);	
			}	
			else if ($match[2] == "*") {
				if ($pssdebug) {
					echo "replacing arithmetic tag ". pssDebugReplaceThisString($match[0]) . " with " . pssDebugReplacedString($match[1] * $match[3]) . "; ";
				}
				$scorescript = str_replace($match[0], $match[1] * $match[3], $scorescript);	
			}	
			else if ($match[2] == "/") {
				if (intval($match[3]) != 0) {
					if ($pssdebug) {
						echo "replacing arithmetic tag ". pssDebugReplaceThisString($match[0]) . " with " . pssDebugReplacedString($match[1] / $match[3]) . "; ";
					}
					$scorescript = str_replace($match[0], $match[1] / $match[3], $scorescript);
				}
				else {
					if ($pssdebug) {
						echo " arithmetic tag divide (/) by zero error--replacing arithmetic tag ". pssDebugReplaceThisString($match[0]) . " with " . pssDebugReplacedString("NaN") . "; ";
					}
					// NaN means "not a number"
					$scorescript = str_replace($match[0], "NaN", $scorescript);
				}
			}	
			else if ($match[2] == "%") {
				if (intval($match[3]) != 0) {
					if ($pssdebug) {
						echo "replacing arithmetic tag ". pssDebugReplaceThisString($match[0]) . " with " . pssDebugReplacedString($match[1] % $match[3]) . "; ";
					}
					$scorescript = str_replace($match[0], $match[1] % $match[3], $scorescript);
				}
				else {
					if ($pssdebug) {
						echo " arithmetic tag divide (%) by zero error--replacing arithmetic tag ". pssDebugReplaceThisString($match[0]) . " with " . pssDebugReplacedString("NaN") . "; ";
					}
					// NaN means "not a number"
					$scorescript = str_replace($match[0], "NaN", $scorescript);
				}
			}
			else { // should never get here
				if ($pssdebug) {
					echo " arithmetic tag regexp matched an invalid tag (" . $match[0] . ")!; ";
				}	
				$scorescript = str_replace($match[0], "", $scorescript);
			}	
		}
	}

	// process the replace tag; added in 1.4.1 20101005
	if (strpos($scorescript, '[:replace:') !== false || strpos($scorescript, '[:ireplace:') !== false) {  // yes, a replace tag (probably) exists in the string
		if ($pssdebug) {
			echo " we appear to have found at least one replace tag; ";
		}
		
		unset($matches);
		preg_match_all("/\[:(ireplace|replace):{(.*?)}:{(.*?)}:<start>:\](.*?)\[:\\1:<end>:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual replace tags; ";
		}
		
		foreach ($matches as $match) {
			$outer_to_replace = $match[0];
			$inner_to_replace = parseScoreScript($quizScore, $match[2]);
			$inner_replacement = parseScoreScript($quizScore, $match[3]);
			$inner_replace_text = parseScoreScript($quizScore, $match[4]);
			if ($match[1] == 'ireplace') {
				// JString class should handle PHP 4 or 5
				$outer_replacement = JString::str_ireplace($inner_to_replace, $inner_replacement, $inner_replace_text);
			}
			else {
				$outer_replacement = str_replace($inner_to_replace, $inner_replacement, $inner_replace_text);
			}
			$scorescript = str_replace($outer_to_replace, $outer_replacement, $scorescript);
		}
		unset($outer_to_replace, $inner_to_replace, $inner_replacement, $inner_replace_text, $outer_replacement);
	}

	// Next, replace rawurlencode tags
	if ((strpos($scorescript, "[:urlencode:<") !== false) || strpos($scorescript, "[:rawurlencode:<") !== false) {  // a 'rawurlencode' tag probably exists in the string
		
		if ($pssdebug) {
			//echo " we appear to have found at least one (raw)url encode/decode tag; ";
			pssDebugMessage('appearfoundatleastone1', '(raw)url encode/decode tag');
		}	
		
		// ungreedy quantifier to capture rawurlencodes (.*?) over multiple lines (s)
		preg_match_all("/\[:((?:raw)?url(?:en|de)code):<start>:\](.*?)\[:\\1:<end>:\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if ($pssdebug) {
			//echo " we found " . count($matches) . " actual sets of (raw)url encode/decode tags; ";
			pssDebugMessage('foundactual12', count($matches), 'sets of (raw)url encode/decode tags');
		}
		
		foreach ($matches as $match_key => $match) {
		
			//echo "<pre>"; print_r($match); echo "</pre>\n";
			
			if ($pssdebug) {
				//echo " removing <span style=\"color: red;\">"
				//. htmlspecialchars($match[0]) . "</span> from \$scorescript (set $match_key); ";
				pssDebugMessage('removing12withindex3', 'set of ' . $match[1] . ' tags', $match[0], $match_key);
			}
			
			if ($match[1] == 'rawurlencode') {
				$scorescript = str_replace($match[0], rawurlencode($match[2]), $scorescript);
			}
			else if ($match[1] == 'urlencode'){
				$scorescript = str_replace($match[0], urlencode($match[2]), $scorescript);
			}
			else if ($match[1] == 'rawurldecode'){
				$scorescript = str_replace($match[0], rawurldecode($match[2]), $scorescript);
			}
			else if ($match[1] == 'urldecode'){
				$scorescript = str_replace($match[0], urldecode($match[2]), $scorescript);
			}
		}

	}

	// process the sqrt tag; added in 1.4.0 Beta 3 20100322
	if (strpos($scorescript, '[:sqrt:') !== false) {  // yes, a sqrt tag (probably) exists in the string
		if ($pssdebug) {
			echo " we appear to have found at least one sqrt tag; ";
		}
		
		unset($matches);
		preg_match_all("/\[:sqrt:{(.*?)}:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual sqrt tags; ";
		}
		
		//echo "<pre>"; print_r($matches); echo "</pre>\n";
		foreach ($matches as $match) {
			$scorescript = str_replace($match[0], sqrt(parseScoreScript($quizScore, trim($match[1]))), $scorescript);
		}
	}

	// process the numeric tag; added in 1.4.0 Beta 3 20100322
	if (strpos($scorescript, '[:numeric:') !== false) {  // yes, a numeric tag (probably) exists in the string
		if ($pssdebug) {
			echo " we appear to have found at least one numeric tag; ";
		}
		
		unset($matches);
		preg_match_all("/\[:numeric:{(.*?)}:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual numeric tags; ";
		}
		
		//echo "<pre>"; print_r($matches); echo "</pre>\n";
		foreach ($matches as $match) {
			$scorescript = str_replace($match[0], intval(is_numeric(parseScoreScript($quizScore, trim($match[1])))), $scorescript);
		}
	}

	// process the abs tag; added in 1.4.0 Beta 3 20100322
	if (strpos($scorescript, '[:abs:') !== false) {  // yes, a abs tag (probably) exists in the string
		if ($pssdebug) {
			echo " we appear to have found at least one abs tag; ";
		}
		
		unset($matches);
		preg_match_all("/\[:abs:{(.*?)}:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual abs tags; ";
		}
		
		//echo "<pre>"; print_r($matches); echo "</pre>\n";
		foreach ($matches as $match) {
			$scorescript = str_replace($match[0], abs(parseScoreScript($quizScore, trim($match[1]))), $scorescript);
		}
	}

	// process the exp tag; added in 1.4.0 Beta 3 20100322
	if (strpos($scorescript, '[:exp:') !== false) {  // yes, a exp tag (probably) exists in the string
		if ($pssdebug) {
			echo " we appear to have found at least one exp tag; ";
		}
		
		unset($matches);
		preg_match_all("/\[:exp:{(.*?)}:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual exp tags; ";
		}
		
		//echo "<pre>"; print_r($matches); echo "</pre>\n";
		foreach ($matches as $match) {
			$scorescript = str_replace($match[0], exp(parseScoreScript($quizScore, trim($match[1]))), $scorescript);
		}
	}

	// process the ceil tag; added in 1.4.0 RC1 20100801
	if (strpos($scorescript, '[:ceil:') !== false) {  // yes, a ceil tag (probably) exists in the string
		if ($pssdebug) {
			echo " we appear to have found at least one ceil tag; ";
		}
		
		unset($matches);
		preg_match_all("/\[:ceil:{(.*?)}:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual ceil tags; ";
		}
		
		//echo "<pre>"; print_r($matches); echo "</pre>\n";
		foreach ($matches as $match) {
			$scorescript = str_replace($match[0], ceil(parseScoreScript($quizScore, trim($match[1]))), $scorescript);
		}
	}

	// process the floor tag; added in 1.4.0 RC1 20100801
	if (strpos($scorescript, '[:floor:') !== false) {  // yes, a floor tag (probably) exists in the string
		if ($pssdebug) {
			echo " we appear to have found at least one floor tag; ";
		}
		
		unset($matches);
		preg_match_all("/\[:floor:{(.*?)}:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual floor tags; ";
		}
		
		//echo "<pre>"; print_r($matches); echo "</pre>\n";
		foreach ($matches as $match) {
			$scorescript = str_replace($match[0], floor(parseScoreScript($quizScore, trim($match[1]))), $scorescript);
		}
	}

	// process the pow tag; added in 1.4.0 Beta 3 20100322
	if (strpos($scorescript, '[:pow:') !== false) {  // yes, a pow tag (probably) exists in the string
		if ($pssdebug) {
			echo " we appear to have found at least one pow tag; ";
		}
		
		unset($matches);
		preg_match_all("/\[:pow:{(.*?)}:{(.*?)}:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual pow tags; ";
		}
		
		//echo "<pre style=\"background-color: yellow;\">"; print_r($matches); echo "</pre>\n";
		foreach ($matches as $match) {
			$scorescript = str_replace($match[0], pow(parseScoreScript($quizScore, trim($match[1])), parseScoreScript($quizScore, trim($match[2]))), $scorescript);
		}
	}

	// process the log tag; added in 1.4.0 Beta 3 20100322
	if (strpos($scorescript, '[:log:') !== false) {  // yes, a log tag (probably) exists in the string
		if ($pssdebug) {
			echo " we appear to have found at least one log tag; ";
		}
		
		unset($matches);
		preg_match_all("/\[:log:{(.*?)}(:{(.*?)})*:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual log tags; ";
		}
		
		//echo "<pre style=\"background-color: yellow;\">"; print_r($matches); echo "</pre>\n";
		foreach ($matches as $match) {
			$scorescript = str_replace($match[0], log(parseScoreScript($quizScore, trim($match[1])), isset($match[3]) && $match[3] ? parseScoreScript($quizScore, trim($match[3])) : M_E), $scorescript);
		}
	}

	// process the round tag; added in 1.4.0 RC1 20100731
	// round($val, $precision, $mode);
	if (strpos($scorescript, '[:round:') !== false) {  // yes, a log tag (probably) exists in the string
		if ($pssdebug) {
			echo " we appear to have found at least one round tag; ";
		}
		
		unset($matches);
		// note that PHP function round accepts 3rd argument 'mode' only for PHP >=5.3;
		//  therefore, we accept two arguments
		preg_match_all("/\[:round:{([^}]*?)}(?::{([^}]*?)})?:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual round tags; ";
		}
		
		foreach ($matches as $match) {
			
			//echo "<p>The match[1] this time around is <b>" . $match[1] . "</b>, which translates to <b>" . parseScoreScript($quizScore, trim($match[1])) . "</b>.</p>\n";
			//echo "<p>The match[2] this time around is <b>" . (isset($match[2]) ? $match[2] : '&lt;doesn\'t exist&gt;') . "</b>, which translates to <b>" . (isset($match[2]) ? parseScoreScript($quizScore, trim($match[2])) : 0) . "</b>.</p>\n<hr />\n";
			
			//$val = parseScoreScript($quizScore, trim($match[1]));
			//$precision = isset($match[2]) ? parseScoreScript($quizScore, trim($match[2])) : 0;
			// PHP >= 5.3 only: $mode = isset($match[3]) ? constant(parseScoreScript($quizScore, trim($match[3]))) : PHP_ROUND_HALF_UP;
			
			$scorescript = str_replace($match[0], round(parseScoreScript($quizScore, trim($match[1])), isset($match[2]) ? parseScoreScript($quizScore, trim($match[2])) : 0), $scorescript);
		}
	}

	// process the sum tag; added in 1.4.0 Beta 3 20100322
	if (strpos($scorescript, '[:sum:') !== false) {  // yes, a sum tag (probably) exists in the string
		if ($pssdebug) {
			echo " we appear to have found at least one sum tag; ";
		}
		
		unset($matches);
		preg_match_all("/\[:sum((:{(.*?)})+):\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual sum tags; ";
		}
		
		//echo "<pre>"; print_r($matches); echo "</pre>\n";
		foreach ($matches as $match) {
			$parts = parseScoreScript($quizScore, trim($match[1], ':{}'));
			//echo "<h1>parts is $parts</h1>";
			$parts = explode('}:{', $parts);
			//echo "<pre>"; print_r($parts); echo "</pre>\n";
			
			$scorescript = str_replace($match[0], array_sum($parts), $scorescript);
			
		}
		unset($parts);
	}

	// process the product tag; added in 1.4.0 RC1 20100729
	if (strpos($scorescript, '[:product:') !== false) {  // yes, a product tag (probably) exists in the string
		if ($pssdebug) {
			echo " we appear to have found at least one product tag; ";
		}
		
		unset($matches);
		preg_match_all("/\[:product((:{(.*?)})+):\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual product tags; ";
		}
		
		//echo "<pre>"; print_r($matches); echo "</pre>\n";
		foreach ($matches as $match) {
			$parts = parseScoreScript($quizScore, trim($match[1], ':{}'));
			//echo "<h1>parts is $parts</h1>";
			$parts = explode('}:{', $parts);
			//echo "<pre>"; print_r($parts); echo "</pre>\n";
			if (count($parts) > 0) {
				$product = 1;
			}
			else {
				$product = 0;
			}	
			foreach ($parts as $part) {
				$product = $product * $part;
			}
			
			$scorescript = str_replace($match[0], $product, $scorescript);
			
		}
		unset($parts, $product);
	}

	// process the average tag; added in 1.4.0 final 20100917
	if (strpos($scorescript, '[:average:') !== false) {  // yes, a average tag (probably) exists in the string
		if ($pssdebug) {
			echo " we appear to have found at least one average tag; ";
		}
		
		unset($matches);
		preg_match_all("/\[:average((:{(.*?)})+):\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual average tags; ";
		}
		
		//echo "<pre>"; print_r($matches); echo "</pre>\n";
		foreach ($matches as $match) {
			$parts = parseScoreScript($quizScore, trim($match[1], ':{}'));
			//echo "<h1>parts is $parts</h1>";
			$parts = explode('}:{', $parts);
			//echo "<pre>"; print_r($parts); echo "</pre>\n";
			
			if (count($parts)) {
				$scorescript = str_replace($match[0], array_sum($parts)/count($parts), $scorescript);
			}
			else {
				$scorescript = str_replace($match[0], '0', $scorescript);
			}
			
		}
		unset($parts);
	}

	// second set of operator tags: comparison tags	[:comparison:{x}:>:{y}:{do_true}:{do_false}:]
	if (strpos($scorescript, "[:comparison:") !== false) {  // yes, a comparison operator tag (probably) exists in the string
		
		if ($pssdebug) {
			echo " we appear to have found at least one comparison tag; ";
		}
		
		unset($matches);
		preg_match_all("/\[:comparison:{(.*?)}:(\=\=|eq|\!\=|\<\>|ne|\>|gt|\<|lt|\>\=|ge|\<\=|le):{(.*?)}:{(.*?)}:{(.*?)}:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual comparison tags; ";
		}

		foreach ($matches as $match) {
			
			//echo "<pre>comparison tag contents:\n";
			//print_r($match);
			//echo "</pre>";
			
			// process any special tags within the arithmetic tag
			if ($pssdebug) {
				echo " parseScoreScript() is now being called to process the comparison tag first item to compare; ";
			}
			$match[1] = parseScoreScript($quizScore, $match[1]);
			if ($pssdebug) {
				echo " parseScoreScript() is now being called to process the comparison tag second item to compare; ";
			}
			$match[3] = parseScoreScript($quizScore, $match[3]);
			
			$dotrueorfalse = null;

			if ($match[2] == "==" || $match[2] == "eq") {
				if ($match[1] == $match[3]) {
					$dotrueorfalse = true;
				}
				else {
					$dotrueorfalse = false;
				}
			}	
			else if ($match[2] == "!=" || $match[2] == "<>" || $match[2] == "ne") {
				if ($match[1] != $match[3]) {
					$dotrueorfalse = true;
				}
				else {
					$dotrueorfalse = false;
				}
			}	
			else if ($match[2] == ">" || $match[2] == "gt") {
				if ($match[1] > $match[3]) {
					$dotrueorfalse = true;
				}
				else {
					$dotrueorfalse = false;
				}
			}	
			else if ($match[2] == "<" || $match[2] == "lt") {
				if ($match[1] < $match[3]) {
					$dotrueorfalse = true;
				}
				else {
					$dotrueorfalse = false;
				}
			}	
			else if ($match[2] == ">=" || $match[2] == "ge") {
				if ($match[1] >= $match[3]) {
					$dotrueorfalse = true;
				}
				else {
					$dotrueorfalse = false;
				}
			}
			else if ($match[2] == "<=" || $match[2] == "le") {
				if ($match[1] <= $match[3]) {
					$dotrueorfalse = true;
				}
				else {
					$dotrueorfalse = false;
				}
			}
			else { // should never get here
				if ($pssdebug) {
					echo " comparison tag regexp matched an invalid tag (" . $match[0] . ")!; ";
				}	
			}
			if ($dotrueorfalse == true) {
				if ($pssdebug) {
					echo " parseScoreScript() is now being called to process the comparison tag 'do what if true'; ";
				}
				$match[4] = parseScoreScript($quizScore, $match[4]);
				if ($pssdebug) {
					echo "replacing comparison tag " . pssDebugReplaceThisString($match[0]) . " with " . pssDebugReplacedString($match[4]) . "; ";
				}	
				$scorescript = str_replace($match[0], $match[4], $scorescript);
			}	
			else if ($dotrueorfalse == false) {
				if ($pssdebug) {
					echo " parseScoreScript() is now being called to process the comparison tag 'do what if false'; ";
				}
				$match[5] = parseScoreScript($quizScore, $match[5]);
				if ($pssdebug) {
					echo "replacing comparison tag " . pssDebugReplaceThisString($match[0]) . " with " . pssDebugReplacedString($match[5]) . "; ";
				}	
				$scorescript = str_replace($match[0], $match[5], $scorescript);
			}
			else { // should never get here
				if ($pssdebug) {
					echo "replacing comparison tag " . pssDebugReplaceThisString($match[0]) . "</span> with an empty string; ";
				}	
				$scorescript = str_replace($match[0], "", $scorescript);
			}
		}
	}
	
	if (strpos($scorescript, "[:logical:") !== false) {  // yes, a logical operator tag (probably) exists in the string
		
		if ($pssdebug) {
			echo " we appear to have found at least one logical tag; ";
		}
		
		unset($matches);
		preg_match_all("/\[:logical:{(.*?)}:(and|or|xor|not|\!|\&\&|\|\||true|false):{(.*?)}:{(.*?)}:{(.*?)}:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual logical tags; ";
		}
		
		foreach ($matches as $match) {
			
			//echo "<pre>logical tag contents:\n";
			//print_r($match);
			//echo "</pre>";
			
			// process any special tags within the arithmetic tag
			if ($pssdebug) {
				echo " parseScoreScript() is now being called to process the logical tag first item to compare; ";
			}
			$match[1] = parseScoreScript($quizScore, $match[1]);
			if ($pssdebug) {
				echo " parseScoreScript() is now being called to process the logical tag second item to compare; ";
			}
			$match[3] = parseScoreScript($quizScore, $match[3]);

			$dotrueorfalse = null;
			
			if ($match[2] == "and" || $match[2] == "&&") {
				if ($match[1] && $match[3]) {
					$dotrueorfalse = true;
				}
				else {
					$dotrueorfalse = false;
				}
			}	
			else if ($match[2] == "or" || $match[2] == "||") {
				if ($match[1] || $match[3]) {
					$dotrueorfalse = true;
				}
				else {
					$dotrueorfalse = false;
				}
			}	
			else if ($match[2] == "xor") {
				if ($match[1] xor $match[3]) {
					$dotrueorfalse = true;
				}
				else {
					$dotrueorfalse = false;
				}
			}	
			else if ($match[2] == "not" || $match[2] == "!" || $match[2] == 'false') {
				if (!$match[1]) {
					$dotrueorfalse = true;
				}
				else {
					$dotrueorfalse = false;
				}
			}
			else if ($match[2] == 'true') { // CPH 20100101 1.4.0 Beta 1 added true and false
				if ($match[1]) {
					$dotrueorfalse = true;
				}
				else {
					$dotrueorfalse = false;
				}
			}
			else { // should never get here
				if ($pssdebug) {
					echo " logical tag regexp matched an invalid tag (" . $match[0] . ")!; ";
				}	
				$scorescript = str_replace($match[0], "", $scorescript);
			}	
			if ($dotrueorfalse == true) {
				if ($pssdebug) {
					echo " parseScoreScript() is now being called to process the logical tag 'do what if true'; ";
				}
				$match[4] = parseScoreScript($quizScore, $match[4]);
				if ($pssdebug) {
					echo "replacing logical tag " . pssDebugReplaceThisString($match[0]) . " with " . pssDebugReplacedString($match[4]) . "; ";
				}	
				$scorescript = str_replace($match[0], $match[4], $scorescript);
			}
			else if ($dotrueorfalse == false) {
				if ($pssdebug) {
					echo " parseScoreScript() is now being called to process the logical tag 'do what if false'; ";
				}
				$match[5] = parseScoreScript($quizScore, $match[5]);
				if ($pssdebug) {
					echo "replacing logical tag " . pssDebugReplaceThisString($match[0]) . " with " . pssDebugReplacedString($match[5]) . "; ";
				}	
				$scorescript = str_replace($match[0], $match[5], $scorescript);
			}
			else { // should never get here
				if ($pssdebug) {
					echo "replacing logical tag " . pssDebugReplaceThisString($match[0]) . " with an empty string; ";
				}	
				$scorescript = str_replace($match[0], "", $scorescript);
			}
		}
	}


	// now that we've gone through the operator tags once, replace expressions and parse again
	if (strpos($scorescript, "[:expression:") !== false) {  // an 'expression' tag probably exists in the string
		unset($matches);
		//preg_match_all("/\[:expression:(\d+):\]/s", $scorescript, $matches, PREG_SET_ORDER);
		// 20100509 allow any value for an expression identifier, not just digits
		//preg_match_all("/\[:expression:([a-zA-Z0-9_]+):\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		// 1.4.1 CPH 20101219 add ability to pass arguments into the expression tag
		preg_match_all("/\[:expression:([a-zA-Z0-9_]+)((?::{(?:.*?)})*):\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual expression tags (as opposed to expression definitions); ";
		}
		
		//echo "<pre>matches\n\n"; print_r($matches); echo "</pre>\n";
		
		foreach ($matches as $match) {
		
			//echo "<pre>match\n\n"; print_r($match); echo "</pre>\n";
			
			$parts = trim($match[2], ':{}');
			if ($parts != '') {
				$parts = explode('}:{', $parts);
				foreach ($parts as $partkey => $partval) {
					$parts[$partkey] = parseScoreScript($quizScore, $partval);
				}
			}	
			
			//echo "<pre>parts\n\n"; print_r($parts); echo "</pre>\n";
		
			global ${'mbexpression' . JString::strtolower($match[1])};
			// $scorescript = str_replace($match[0], ${'mbexpression' . $match[1]}, $scorescript);
			if (isset(${'mbexpression' . JString::strtolower($match[1])})) {
				
				$theexpression = ${'mbexpression' . JString::strtolower($match[1])};
				if (is_array($parts)) {
					
					// replace the expression arguments in the expression
					//  for example, <expression:a1>My name is [:1:].</expression>
					//  [:expression:a1:{John Doe}:]
					//  outputs: My name is John Doe.
					foreach($parts as $partkey => $partval) {
						$theexpression = str_replace('[:' . ($partkey + 1) . ':]', $partval, $theexpression);
					}
				
				}
								
				if ($pssdebug) {
					//echo pssDebugStart() . 'replacing expression tag ' . pssDebugStyleString($match[0], 'replace_this') . " with expression " . pssDebugStyleString(${'mbexpression' . JString::strtolower($match[1])}, 'replace_with') . ' and parsing the entire Score Script again;' . pssDebugEnd();
					pssDebugMessage('replace12with34', 'expression tag', $match[0], 'expression tag contents', $theexpression);
				}
				// case insensitive expression identifier
				$scorescript = parseScoreScript($quizScore, str_replace($match[0], $theexpression, $scorescript));
			}
			else {
				if ($pssdebug) {
					
					echo pssDebugErrorString("expression tag " . pssDebugStyleString($match[0], 'replace_this') . " does not have a corresponding expression!; NOT parsing the entire Score Script again; ");
				}	
			}
		}
	}

//	echo "the scorescript we are working with is <pre>" . $scorescript . "</pre>\n";
		
	if (strpos($scorescript, "[:answer") !== false) {  // yes, an 'answer' array tag (probably) exists in the string
		
		if ($pssdebug) {
			echo " we appear to have found at least one tag that begins with <b>[:answer</b>; ";
		}	
		
		unset($matches);
		preg_match_all("/\[:answer:(\d+):<start_correct>:\](.*?)\[:answer:\\1:<end_correct>:\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if ($pssdebug) {
			echo " we found " . count($matches) . " actual pairs of answer start_correct/end_correct tags; ";
		}
		
		//echo "<pre>START_CORRECT Matches are:
		//";
		//print_r($matches);
		//echo "</pre>\n";
		
		foreach ($matches as $match) {
			// CPH 20090526 1.1.0final added isset to avoid undefined index PHP Notice
			if (isset($quizScore['answer'][sprintf('%02d', $match[1])]['is_correct']) && $quizScore['answer'][sprintf('%02d', $match[1])]['is_correct']) {
				
				//echo "\nNOW PROCESSING CORRECT " . $match[1] . "<br /><br />";
				
				//echo "\n<hr /><pre>The string we want to replace is A$match[0]Z</pre><hr/>\n";
				
				
				$scorescript = str_replace($match[0], parseScoreScript($quizScore, $match[2]), $scorescript);
			}
			else { // the text is not relevant so delete it
				$scorescript = str_replace($match[0], "", $scorescript);
			}
		}


		// Begin section to process based on how many are correct
		unset($matches);
		preg_match_all("/\[:answers_correct:(\d+):<start>:\](.*?)\[:answers_correct:\\1:<end>:\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if ($pssdebug) {
			echo " we found " . count($matches) . " actual pairs of answers_correct start/end tags; ";
		}
		
		//echo "<pre>ANSWERS_CORRECT Matches are:
		//";
		//print_r($matches);
		//echo "</pre>\n";

		//echo "<p>The total number correct this time around was " . $quizScore['number_of_correct_answers'] . ".</p>";
		
		foreach ($matches as $match) {
			//echo "<p>The match[1] this time around is " . $match[1] . ".</p>\n";
			if ($match[1] == $quizScore['number_of_correct_answers']) {
				$scorescript = str_replace($match[0], parseScoreScript($quizScore, $match[2]), $scorescript);
			}
			else { // the text is not relevant so delete it
				$scorescript = str_replace($match[0], "", $scorescript);
			}
		}
		// End section to process based on how many are correct

		unset($matches);
		preg_match_all("/\[:answer:(\d+):<start_incorrect>:\](.*?)\[:answer:\\1:<end_incorrect>:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual pairs of answer start_incorrect/end_incorrect tags; ";
		}

		//echo "<pre>START_INCORRECT Matches are:
		//";
		//print_r($matches);
		//echo "</pre>\n";
		
		foreach ($matches as $match) {
			// CPH 20090526 1.1.0final added isset to avoid undefined index PHP Notice
			if (isset($quizScore['answer'][sprintf('%02d', $match[1])]['is_correct']) && !$quizScore['answer'][sprintf('%02d', $match[1])]['is_correct']) {
			
				//echo "\nNOW PROCESSING INCORRECT " . $match[1] . "<br /><br />";
				//echo "\n<hr /><pre>The string we want to replace is A$match[0]Z</pre><hr/>\n";
				//echo "\n<hr /><pre>The string we want___replaced is A" . $scorescript . "Z</pre><hr/>\n";
				//echo "scorescript is now $scorescript";
			
				$scorescript = str_replace($match[0], parseScoreScript($quizScore, $match[2]), $scorescript);
				
				//echo "<br /><br />AND NOW THE RESULT THAT WE WANTED IS HERE: " . $scorescript . "<br /><br />";
			}	
			else { // the text is not relevant so delete it
				$scorescript = str_replace($match[0], "", $scorescript);
			}
		}
				
		unset($matches);
		// 1.4.2 20110228 CPH added end of regex :((\d+):)?\]
		preg_match_all("/\[:answer:(\d+):(name|partofspeech|cluecuehint|beforetext|aftertext|correct_value|correct_value_raw|correct_case_sensitive|user_response|user_response_raw|is_correct|points_possible_a|points_earned_a|points_earned_b|in_subset|selected_index|selected_index_padded|selected_index_alpha|selected_count|possible_choice|possible_choice_selected|possible_choice_correct):((\d+):)?\]/", $scorescript, $matches, PREG_SET_ORDER);

		if ($pssdebug) {
			echo " we found " . count($matches) . " actual answer tags; ";
		}

		foreach ($matches as $match) {
			//echo "<pre>Matches are:
			//";
			//print_r($match);
			//echo "</pre>";
			
			// removed in 1.4.2 CPH 20110228
			//$scorescript = str_replace($match[0], isset($quizScore['answer'][sprintf('%02d', $match[1])][$match[2]]) ? $quizScore['answer'][sprintf('%02d', $match[1])][$match[2]] : '', $scorescript);
			
			// added in 1.4.2 CPH 20110228
			// added the following conditional and its else to prevent error messages when the requested answer field is not defined
			if (isset($quizScore['answer'][sprintf('%02d', $match[1])][$match[2]])) {
				if (isset($match[4])) {
					$scorescript = str_replace($match[0], $quizScore['answer'][sprintf('%02d', $match[1])][$match[2]][$match[4]], $scorescript);
				}
				else {
					$scorescript = str_replace($match[0], $quizScore['answer'][sprintf('%02d', $match[1])][$match[2]], $scorescript);
				}
			}
			
		}
	}

	// Begin section to process based on points range type A when called outside of any other tags
	if (strpos($scorescript, "[:points_a_range:") !== false) {  // yes, a 'points_a_range' tag (probably) exists in the string

		if ($pssdebug) {
			echo " we appear to have found at least one set of points_a_range start/end tags when called outside of any other tags; ";
		}

		unset($matches);
		//preg_match_all("/\[:points_a_range:((\d+)-(\d+)):<start>:\](.*?)\[:points_a_range:\\1:<end>:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		// CPH 20110219 1.4.2 add ability to use decimal points and precede range numbers with - or + [integers in PHP may optionally be preceded by a sign (- or +)]
		preg_match_all("/\[:points_a_range:(([-+]?(?:(?:\d+)|(?:\d+\.\d+)|(?:\.\d+)))-([-+]?(?:(?:\d+)|(?:\d+\.\d+)|(?:\.\d+)))):<start>:\](.*?)\[:points_a_range:\\1:<end>:\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if ($pssdebug) {
			echo " we found " . count($matches) . " actual pairs of points_a_range start/end tags when called outside of any other tags; ";
		}

		foreach ($matches as $match) {
			//echo "<p>The match[1] this time around is " . $match[1] . ".</p>\n";
			//echo "<p>The match[2] this time around is " . $match[2] . ".</p>\n";
			//echo "<p>The match[3] this time around is " . $match[3] . ".</p>\n";
			if ($match[2] <= $quizScore['total_points_earned_a'] && $match[3] >= $quizScore['total_points_earned_a']) {
				$scorescript = str_replace($match[0], parseScoreScript($quizScore, $match[4]), $scorescript);
			}
			else { // the text is not relevant so delete it
				$scorescript = str_replace($match[0], "", $scorescript);
			}
		}
	}	

	// Begin section to process based on points range type B when called outside of any other tags
	if (strpos($scorescript, "[:points_b_range:") !== false) {  // yes, a 'points_b_range' tag (probably) exists in the string

		if ($pssdebug) {
			echo " we appear to have found at least one set of points_b_range start/end tags when called outside of any other tags; ";
		}

		unset($matches);
		//preg_match_all("/\[:points_b_range:((\d+)-(\d+)):<start>:\](.*?)\[:points_b_range:\\1:<end>:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		// CPH 20110219 1.4.2 add ability to use decimal points and precede range numbers with - or + [integers in PHP may optionally be preceded by a sign (- or +)]
		preg_match_all("/\[:points_b_range:(([-+]?(?:(?:\d+)|(?:\d+\.\d+)|(?:\.\d+)))-([-+]?(?:(?:\d+)|(?:\d+\.\d+)|(?:\.\d+)))):<start>:\](.*?)\[:points_b_range:\\1:<end>:\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if ($pssdebug) {
			echo " we found " . count($matches) . " actual pairs of points_b_range start/end tags when called outside of any other tags; ";
		}

		foreach ($matches as $match) {
			//echo "<p>The match[1] this time around is " . $match[1] . ".</p>\n";
			//echo "<p>The match[2] this time around is " . $match[2] . ".</p>\n";
			//echo "<p>The match[3] this time around is " . $match[3] . ".</p>\n";
			if ($match[2] <= $quizScore['total_points_b'] && $match[3] >= $quizScore['total_points_b']) {
				$scorescript = str_replace($match[0], parseScoreScript($quizScore, $match[4]), $scorescript);
			}
			else { // the text is not relevant so delete it
				$scorescript = str_replace($match[0], "", $scorescript);
			}
		}
	}	

	// 1.4.0 RC1 20100730 Add section to process custom points range
	// For example [:custom_range:{[:expression:1:]}:0-49:<start>:]Expression 1 is between 0 and 49[:custom_range:0-49:<end>:]
	if (strpos($scorescript, "[:custom_range:") !== false) {  // yes, a 'points_b_range' tag (probably) exists in the string

		if ($pssdebug) {
			echo " we appear to have found at least one set of points_b_range start/end tags when called outside of any other tags; ";
		}

		unset($matches);
		//preg_match_all("/\[:custom_range:{(.*?)}:((\d+)-(\d+)):<start>:\](.*?)\[:custom_range:\\2:<end>:\]/s", $scorescript, $matches, PREG_SET_ORDER);
		// CPH 20110219 1.4.2 add ability to use decimal points and precede range numbers with - or + [integers in PHP may optionally be preceded by a sign (- or +)]
		preg_match_all("/\[:custom_range:{(.*?)}:(([-+]?(?:(?:\d+)|(?:\d+\.\d+)|(?:\.\d+)))-([-+]?(?:(?:\d+)|(?:\d+\.\d+)|(?:\.\d+)))):<start>:\](.*?)\[:custom_range:\\2:<end>:\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if ($pssdebug) {
			echo " we found " . count($matches) . " actual pairs of custom_range start/end tags; ";
		}

		foreach ($matches as $match) {
			//echo "<p>The match[1] this time around is " . $match[1] . ".</p>\n";
			//echo "<p>The match[2] this time around is " . $match[2] . ".</p>\n";
			//echo "<p>The match[3] this time around is " . $match[3] . ".</p>\n";
			//echo "<p>The match[4] this time around is " . $match[4] . ".</p>\n";
			//echo "<p>The match[5] this time around is " . $match[5] . ".</p>\n";
			$parseMatchOne = parseScoreScript($quizScore, $match[1]);
			if ($parseMatchOne >= parseScoreScript($quizScore, $match[3]) && $parseMatchOne <= parseScoreScript($quizScore, $match[4])) {
				$scorescript = str_replace($match[0], parseScoreScript($quizScore, $match[5]), $scorescript);
			}
			else { // the text is not relevant so delete it
				$scorescript = str_replace($match[0], '', $scorescript);
			}
			unset($parseMatchOne);
		}
	}	

	// Format string enclosed in tags using sprintf():
	if (strpos($scorescript, "[:printf:") !== false) {  // yes, a 'printf' tag (probably) exists in the string

		if ($pssdebug) {
			echo " we appear to have found at least one printf tag; ";
		}

		unset($matches);
		preg_match_all("/\[:printf:(.+?):<start>:\](.*?)\[:printf:<end>:\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if ($pssdebug) {
			echo " we found " . count($matches) . " actual pairs of printf start/end tags; ";
		}

		foreach ($matches as $match) {
			//echo "<p>The match[0] this time around is A" . htmlspecialchars($match[0]) . "Z.</p>\n";
			//echo "<p>The match[1] this time around is " . $match[1] . ".</p>\n";
			//echo "<p>The match[2] this time around is " . $match[2] . ".</p>\n";
			//echo "<p>The match[3] this time around is " . $match[3] . ".</p>\n";
			if ($pssdebug) {
				echo '<br />Replacing printf: ' . $match[0];
			}
			$scorescript = str_replace($match[0], sprintf($match[1], parseScoreScript($quizScore, $match[2])), $scorescript);
		}
	}	

	// 1.4.2 CPH 20110226 Add section to process various filters
	// filter types: no_html, database_escape, no_whitespace
	if (strpos($scorescript, '[:filter:') !== false) {  // yes, a 'filter' tag (probably) exists in the string

		if ($pssdebug) {
			echo " we appear to have found at least one set of points_b_range start/end tags when called outside of any other tags; ";
		}

		unset($matches);
		preg_match_all("/\[:filter:(.+?):<start>:\](.*?)\[:filter:<end>:\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if ($pssdebug) {
			echo " we found " . count($matches) . " actual pairs of filter start/end tags; ";
		}

		foreach ($matches as $match) {
			//echo "<p>The match[1] this time around is " . $match[1] . ".</p>\n";
			//echo "<p>The match[2] this time around is " . $match[2] . ".</p>\n";
			$filter_types = trim(parseScoreScript($quizScore, $match[1]));
			$filter_types = explode('|', $filter_types);
			$filtered = trim(parseScoreScript($quizScore, $match[2]));
			$filter_flag = false; // flag to indicate whether any filtering actually took place (meaning the [:filter: tag was valid)					
			
			foreach ($filter_types as $filter_type) {

				$filter = trim($filter_type);
				
				if (empty($filter)) {
					continue;
				}
				
				if ($filter == 'no_html') {
					$filtered = strip_tags($filtered);
					$filter_flag = true;
					//echo "<h1 style=\"color: red;\">no_html</h1>\n";
				}
				if ($filter == 'database_escape') {
					$database =& JFactory::getDBO();
					$filtered = $database->getEscaped($filtered);
					$filter_flag = true;
					//echo "<h1 style=\"color: red;\">database_escape</h1>\n";
				}
				if ($filter == 'no_whitespace') {
					$filtered = preg_replace('/\s/s', '', $filtered);
					$filter_flag = true;
					//echo "<h1 style=\"color: red;\">no_whitespace</h1>\n";
				}
				if ($filter == 'no_whitespace_outside_tags') {

					$split_content = preg_split('#(\<(\w+?)\>.*?\</\2\>|\<.+ /\>|\[:.+?:\])#s', $filtered, null, PREG_SPLIT_DELIM_CAPTURE);
					$spliced_output = ''; // initialize
					for ($split_index = 0; $split_index < count($split_content); $split_index++) {
					
						// 0, 3, 6, 9, 12, 15... remove whitespace
						if ($split_index % 3 == 0) {
							$spliced_output .= preg_replace('/\s/s', '', $split_content[$split_index]);	
						}
						// 1, 4, 7, 10, 13, 16... keep as is
						else if ($split_index % 3 == 1) {
							$spliced_output .= $split_content[$split_index];
						}
						// 2, 5, 8, 11, 14, 17... ignore
						//else if ($split_index % 3 == 2) {
						//	$spliced_output .= '';
						//}
					
					}
					
					$filtered = $spliced_output;
					$filter_flag = true;
				}
			}	
			if ($filter_flag) {
				$scorescript = str_replace($match[0], $filtered, $scorescript);
			}
		}
		unset($filter_types, $filtered, $filter_flag);
	}	

	// BEGIN EMAIL SECTION
	
        // At this point all irrelevant portions of the Score Script have been removed, so send emails if they are still here
        // A basic email takes the form: mosMail( $from, $fromname, $recipient, $subject, $body);
	// An email with all options: mosMail( $from, $fromname, $recipient, $subject, $body, $mode=0, $cc=NULL, $bcc=NULL, $attachment=NULL, $replyto=NULL, $replytoname=NULL );
	// recipient, cc, bcc, attachment, replyto, and replytoname can all be arrays
         
	if (strpos($scorescript, "[:email:") !== false) {  // yes, an 'email' tag (probably) exists in the string

		if ($pssdebug) {
			echo " we appear to have found at least one email tag; ";
		}

		unset($matches);
		// ungreedy quantifier (.*?) over multiple lines (s)
		preg_match_all("/\[:email((?::(?:from|to|subject|body|html_mode|cc|bcc|attachment|reply_to|success_message|failure_message|reference_key)\{[^\}]*?\})*):\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if ($pssdebug) {
			echo " we found " . count($matches) . " actual email tags; ";
			echo "<br />Begin email foreach<br />\n";
			$pssEmailIndex = 1;
		}

		foreach ($matches as $match) { // This loops for each email tag found

			unset($email_message); // Reset the variable that will hold the components of the email this loop

			if ($pssdebug) {
				echo "<hr />Email tag number $pssEmailIndex:<br />\n";
			}	
			//echo "<pre>";
			//print_r($match);
			//echo "</pre>";

			//echo "\n<br />match[0] is " . $match[0] . "\n<br />\nmatch[1] is " . $match[1] . "<br />\n";

			// $match[1] starts with a colon and contains (curly brace colon)-delimited email elements
			$email_elements = preg_split("/(?<=}):/s", ltrim($match[1], ":"));

			if ($pssdebug) {
				echo "<br />Email elements:<pre>";
				print_r($email_elements);
				echo "</pre>\n";
			}		

			$email_message = array();

			foreach ($email_elements as $email_element) {

				// from and fromname (not arrays)
				if (strpos($email_element, "from{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/from{((.*?)(?:;(.*?))*)}/s", $email_element, $email_element_match);
					if (isset($email_element_match[2])) {
						$email_message['from'] = parseScoreScript($quizScore, $email_element_match[2]);
						$email_message['fromname'] = isset($email_element_match[3]) ? parseScoreScript($quizScore, $email_element_match[3]) : "";
						continue;
					}	
				}

				// to (array)
				if (strpos($email_element, "to{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/(?<!reply_)to{(.*?)}/s", $email_element, $email_element_match);
					if (isset($email_element_match[1]) && $email_element_match[1] != "") {
						$to = explode(",", parseScoreScript($quizScore, $email_element_match[1]));
						if (isset($email_message['recipient'])) {
							$email_message['recipient'] = array_merge($email_message['recipient'], $to);
						}
						else {
							$email_message['recipient'] = $to;
						}
						continue;
					}	
				}

				// subject (not an array)
				if (strpos($email_element, "subject{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/subject{(.*?)}/s", $email_element, $email_element_match);
					if (isset($email_element_match[1]) && $email_element_match[1] != "") {
						// if subject is already filled, don't fill it again
						$email_message['subject'] = empty($email_message['subject']) ? parseScoreScript($quizScore, $email_element_match[1]) : $email_message['subject'];
						continue;
					}	
				}

				// body (not an array)
				if (strpos($email_element, "body{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/body{(.*?)}/s", $email_element, $email_element_match);
					if (isset($email_element_match[1]) && $email_element_match[1] != "") {
						// if body is already filled, don't fill it again
						$email_message['body'] = empty($email_message['body']) ? parseScoreScript($quizScore, $email_element_match[1]) : $email_message['body'];
						continue;
					}	
				}

				// mode (not an array)
				if (strpos($email_element, "html_mode{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/html_mode{(.*?)}/s", $email_element, $email_element_match);
					if (isset($email_element_match[1]) && $email_element_match[1] != "") {
						$html_mode = parseScoreScript($quizScore, $email_element_match[1]);
						// if html_mode is already set, don't set it again
						$email_message['mode'] = !isset($email_message['mode']) ? (empty($html_mode) ? 0 : 1) : $email_message['html_mode'];
						continue;
					}	
				}

				// cc (array)
				if (strpos($email_element, "cc{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/(?<!b)cc{(.*?)}/s", $email_element, $email_element_match);
					if (isset($email_element_match[1]) && $email_element_match[1] != "") {
						$cc = explode(",", parseScoreScript($quizScore, $email_element_match[1]));
						if (isset($email_message['cc'])) {
							$email_message['cc'] = array_merge($email_message['cc'], $cc);
						}
						else {
							$email_message['cc'] = $cc;
						}
						continue;
					}	
				}

				// bcc (array)
				if (strpos($email_element, "bcc{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/bcc{(.*?)}/s", $email_element, $email_element_match);
					if (isset($email_element_match[1]) && $email_element_match[1] != "") {
						$bcc = explode(",", parseScoreScript($quizScore, $email_element_match[1]));
						if (isset($email_message['bcc'])) {
							$email_message['bcc'] = array_merge($email_message['bcc'], $bcc);
						}
						else {
							$email_message['bcc'] = $bcc;
						}
						continue;
					}	

				}

				// attachment (array)
				if (strpos($email_element, "attachment{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/attachment{(.*?)}/s", $email_element, $email_element_match);
					if (isset($email_element_match[1]) && $email_element_match[1] != "") {
						$attachment = explode(",", parseScoreScript($quizScore, $email_element_match[1]));
						if (isset($email_message['attachment'])) {
							$email_message['attachment'] = array_merge($email_message['attachment'], $attachment);
						}
						else {
							$email_message['attachment'] = $attachment;
						}
						continue;
					}

				}

				// replyto and replytoname (arrays)
				if (strpos($email_element, "reply_to{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/reply_to{(.*?)}/s", $email_element, $email_element_match);
					if (isset($email_element_match[1]) && $email_element_match[1] != "") {
						$reply_tos = explode(",", parseScoreScript($quizScore, $email_element_match[1]));

						foreach ($reply_tos as $reply_to) {
							$address_name = explode(";", $reply_to);
							$email_message['replyto'][] = isset($address_name[0]) ? $address_name[0] : "";
							$email_message['replytoname'][] = isset($address_name[1]) ? $address_name[1] : "";
						}
						continue;

						//echo "<br /><pre>email_element_match[2] is " . $email_element_match[2] . "</pre><br />\n"; // this is the email address
						//$email_message['replyto'][] = parseScoreScript($quizScore, $email_element_match[2]);
						//$email_message['replytoname'][] = isset($email_element_match[3]) ? parseScoreScript($quizScore, $email_element_match[3]) : "";
						//continue;
					}
				}

				// success message (not an array) (not for mosMail function)
				if (strpos($email_element, "success_message{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/success_message{(.*?)}/s", $email_element, $email_element_match);
					if (isset($email_element_match[1]) && $email_element_match[1] != "") {
						// if success_message is already filled, don't fill it again
						$email_message['success_message'] = empty($email_message['success_message']) ? parseScoreScript($quizScore, $email_element_match[1]) : $email_message['success_message'];
						continue;
					}	
				}

				// failure message (not an array) (not for mosMail function)
				if (strpos($email_element, "failure_message{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/failure_message{(.*?)}/s", $email_element, $email_element_match);
					if (isset($email_element_match[1]) && $email_element_match[1] != "") {
						// if failure_message is already filled, don't fill it again
						$email_message['failure_message'] = empty($email_message['failure_message']) ? parseScoreScript($quizScore, $email_element_match[1]) : $email_message['failure_message'];
						continue;
					}	
				}

				// reference key (not an array) (not for mosMail function)
				if (strpos($email_element, 'reference_key{') !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/reference_key{(.*?)}/s", $email_element, $email_element_match);
					if (isset($email_element_match[1]) && $email_element_match[1] != '') {
						// if reference_key is already filled, don't fill it again
						$email_message['reference_key'] = empty($email_message['reference_key']) ? parseScoreScript($quizScore, $email_element_match[1]) : $email_message['reference_key'];
						continue;
					}	
				}
			}

			if ($pssdebug) {
				echo '<br />Email message array before defaults get filled in:<pre>';
				print_r($email_message);
				echo "</pre>\n";
			}	

			if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php')) {
			/**
			 * Include the component configuration file
			 */
				include JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php';
			}

			//global $mbDefaultSSEmailFrom, $mbDefaultSSEmailTo, $mbDefaultSSEmailSubject,
			//$mbDefaultSSEmailBody, $mbDefaultSSEmailCC, $mbDefaultSSEmailBCC,
			//$mbDefaultSSEmailAttachment, $mbDefaultSSEmailReplyTo;

			if (!isset($email_message['from'])) {
				if (!empty($mbDefaultSSEmailFrom)) {
					$address_name = explode(";", parseScoreScript($quizScore, $mbDefaultSSEmailFrom));
					$email_message['from'] = $address_name[0];
					$email_message['fromname'] = isset($address_name[1]) ? $address_name[1] : "";
				}
				else {
					global $mosConfig_mailfrom, $mosConfig_fromname;
					$email_message['from'] = $mosConfig_mailfrom;
					$email_message['fromname'] = $mosConfig_fromname;
				}
			}
			if (!isset($email_message['recipient'])) {
				if (!empty($mbDefaultSSEmailTo)) {
					$tos = explode(",", parseScoreScript($quizScore, $mbDefaultSSEmailTo));
					if (count($tos) > 1) {
						foreach ($tos as $to) {
							$email_message['recipient'][] = $to;
						}
					}
					else {
						$email_message['recipient'] = $tos[0];
					}
				}
				else {
					global $mosConfig_mailfrom;
					$email_message['recipient'] = $mosConfig_mailfrom;
				}
			}
			if (!isset($email_message['subject'])) {
				if (isset($mbDefaultSSEmailSubject)) {
					$email_message['subject'] = parseScoreScript($quizScore, $mbDefaultSSEmailSubject);
				}	
				else {
					$email_message['subject'] = "";
				}
			}
			if (!isset($email_message['body'])) {
				if (isset($mbDefaultSSEmailBody)) {
					$email_message['body'] = parseScoreScript($quizScore, $mbDefaultSSEmailBody);
				}	
				else {
					$email_message['body'] = "";
				}
			}
			if (!isset($email_message['mode'])) {
				if (isset($mbDefaultSSEmailMode)) {
					$email_message['mode'] = parseScoreScript($quizScore, $mbDefaultSSEmailMode);
				}	
				else {
					$email_message['mode'] = 0; // plain text as fallback default
				}
			}
			if (!isset($email_message['cc'])) {
				if (isset($mbDefaultSSEmailCC)) {
					if (empty($mbDefaultSSEmailCC)) {
						$email_message['cc'] = null;
					}
					else {
						$ccs = explode(",", parseScoreScript($quizScore, $mbDefaultSSEmailCC));
						foreach ($ccs as $cc) {
							$email_message['cc'][] = $cc;
						}
						unset($ccs);
					}	
				}	
				else {
					$email_message['cc'] = null;
				}
			}
			if (!isset($email_message['bcc'])) {
				if (isset($mbDefaultSSEmailBCC)) {
					if (empty($mbDefaultSSEmailBCC)) {
						$email_message['bcc'] = null;
					}
					else {
						$bccs = explode(",", parseScoreScript($quizScore, $mbDefaultSSEmailBCC));
						foreach ($bccs as $bcc) {
							$email_message['bcc'][] = $bcc;
						}
						unset($bccs);
					}
				}
				else {
					$email_message['bcc'] = null;
				}
			}
			if (!isset($email_message['attachment'])) {
				if (isset($mbDefaultSSEmailAttachment)) {
					if (empty($mbDefaultSSEmailAttachment)) {
						$email_message['attachment'] = null;
					}
					else {
						$attachments = explode(",", parseScoreScript($quizScore, $mbDefaultSSEmailAttachment));
						foreach ($attachments as $attachment) {
							$email_message['attachment'][] = $attachment;
						}
						unset($attachments);
					}
				}
				else {
					$email_message['attachment'] = null;
				}
			}
			if (!isset($email_message['replyto'])) {
				if (isset($mbDefaultSSEmailReplyTo)) {
					if (empty($mbDefaultSSEmailReplyTo)) {
						$email_message['replyto'] = null;
						$email_message['replytoname'] = null;
					}
					else {
						$replytos = explode(",", parseScoreScript($quizScore, $mbDefaultSSEmailReplyTo));
						foreach ($replytos as $replyto) {
							$address_name = explode(";", $replyto);
							$email_message['replyto'][] = $address_name[0];
							$email_message['replytoname'][] = isset($address_name[1]) ? $address_name[1] : "";
						}
					}
				}	
				else {
					$email_message['replyto'] = null;
					$email_message['replytoname'] = null;
				}
			}
			if (!isset($email_message['success_message'])) {
				if (isset($mbDefaultSSEmailSuccess)) {
					$email_message['success_message'] = parseScoreScript($quizScore, $mbDefaultSSEmailSuccess);
				}	
				else {
					$email_message['success_message'] = "";
				}
			}
			if (!isset($email_message['failure_message'])) {
				if (isset($mbDefaultSSEmailFailure)) {
					$email_message['failure_message'] = parseScoreScript($quizScore, $mbDefaultSSEmailFailure);
				}	
				else {
					$email_message['failure_message'] = "";
				}
			}
			if (!isset($email_message['reference_key'])) {
				$email_message['reference_key'] = crc32($match[0]);
			}

			if ($pssdebug) {
				echo "<br />Email message array as ready to feed to JUtility::sendMail, with defaults filled in:<pre>";
				print_r($email_message);
				echo "</pre>";
			}

			// WARNING: EMAIL ATTACHMENTS ARE DISABLED UNLESS THE NEXT LINE IS REMOVED OR COMMENTED OUT
			$email_message['attachment'] = null;

			// An email with all options: mosMail( $from, $fromname, $recipient, $subject, $body, $mode=0, $cc=NULL, $bcc=NULL, $attachment=NULL, $replyto=NULL, $replytoname=NULL );	
			if ($pssdebug) {
				echo "<br />Attempting to send email with JUtility::sendMail...\n";
			}
			
			if (!checkEmailTagInStoredList($email_message['reference_key'])) {			
				unset($jsendmailstatus);
				$jsendmailstatus = JUtility::sendMail($email_message['from'], $email_message['fromname'], $email_message['recipient'], $email_message['subject'], $email_message['body'], $email_message['mode'], $email_message['cc'], $email_message['bcc'], $email_message['attachment'], $email_message['replyto'], $email_message['replytoname']);
			}
			else {
				$jsendmailstatus = false;
				if ($pssdebug) {
					echo "<br />Aborting sending email because this email tag has already been sent...\n";
				}	
			}

			if ($pssdebug) {
				echo "<br />Email sending returned " . ($jsendmailstatus ? "true.\n" : "false.\n");
			}

			if (isset($jsendmailstatus) && empty($jsendmailstatus) && isset($email_message['failure_message'])) { // failure
				$scorescript = str_replace($match[0], $email_message['failure_message'], $scorescript);
			}

			else if ($jsendmailstatus && isset($email_message['success_message'])) { // success
				addEmailTagToStoredList($email_message['reference_key']); // remember that this email tag has already been processed
				$scorescript = str_replace($match[0], $email_message['success_message'], $scorescript);
			}

			else { // undetermined or no success/failure text available; use empty string
				$scorescript = str_replace($match[0], '', $scorescript);
			}	

			if ($pssdebug) {
				$pssEmailIndex++;
			}	

		}
		if ($pssdebug) {
			echo "<br />End email foreach<br />\n";
		}
	}	
	// END EMAIL SECTION

	// Process scodataX tags - this data is written to the scodataX field of the Mad Blanks record, where X is a positive integer
	if (strpos($scorescript, "<logdata") !== false) {  // an 'scodataX' tag probably exists in the string

		if ($pssdebug) {
			echo " we appear to have found at least one logdata definition; ";
		}	

		unset($matches);
		preg_match_all("/\<logdata:(\d+)(:overwrite)?\>(.*?)\<\/logdata\>/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual logdata definitions; ";
		}

		foreach ($matches as $match) {
			//echo "<pre>logdata definitions:\n";
			//print_r($match);
			//echo "</pre>\n";
			
			$logdata_identifier = $match[1];
			$logdata_overwrite_flag = $match[2];
			$logdata_content = $match[3];
			
			//echo "<p>\$logdata_identifier is $logdata_identifier</p>";
			//echo "<p>\$logdata_overwrite_flag is $logdata_overwrite_flag</p>";
			//echo "<p>\$logdata_content is $logdata_content</p>";
			
			// write the data to the record
			$database = &JFactory::getDBO(); 
			$blankarray = array();
			
			if (empty($logdata_overwrite_flag)) {
				// only write to scodataX if it's empty
				$database->setQuery('UPDATE #__madblanks_records SET scodata' . $logdata_identifier . " = '" . $database->getEscaped(replaceSpecialCharacters(parseScoreScript($quizScore, $logdata_content), 0, null, 0, null, null, $blankarray)) . "' WHERE id = " . $quizScore['record_id'] . ' AND scodata' . $logdata_identifier . " = ''");
				//echo "<p>only write to scodataX if it's empty</p>";
			}
			else {
				// write or overwrite scodataX 
				$database->setQuery('UPDATE #__madblanks_records SET scodata' . $logdata_identifier . " = '" . mysql_real_escape_string(replaceSpecialCharacters($logdata_content, 0, null, 0, null, null, $blankarray)) . "' WHERE id = " . $quizScore['record_id']);
				//echo "<p>write or overwrite scodataX</p>";
			}
			
			$database->query();
			
			$scorescript = str_replace($match[0], "", $scorescript);
		}
	}

	// BEGIN AGGREGATE SECTION
	
        // At this point all irrelevant portions of the Score Script have been removed,
        //  so process aggregate statistics if they are still here
         
	// yes, an 'aggregate' tag (probably) exists in the string
	// OR yes, an expression_group tag (probably) exists in the string
	if (strpos($scorescript, "[:aggregate:") !== false || strpos($scorescript, "[:expression_group:") !== false) {

		if ($pssdebug) {
			echo " we appear to have found at least one aggregate/expression_group tag; ";
		}

		unset($matches); // is this necessary?
		// ungreedy quantifier (.*?) over multiple lines (s)
		preg_match_all("/\[:(aggregate|expression_group)((?::(?:function|field|category|table|where|query|ignore_empty_records|cast|cast_for_ordering|concat_separator|chart_size|chart_type|chart_color|chart_no_response_label|data_labels|chart_value|chart_label|title|title_attributes|completedapprovedpublished|value|order_by|group_name|member|debug)\{[^\}]*?\})*):\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if ($pssdebug) {
			echo " we found " . count($matches) . " actual aggregate tags; ";
			echo "<br />Begin aggregate foreach<br />\n";
			$pssAggregateIndex = 1;
		}

		//echo "<pre>Aggregate tag matches:\n\n"; print_r($matches); echo "</pre>\n";
		
		foreach ($matches as $match) { // This loops for each aggregate tag found
		
			//echo '<p style="color: green;">Entering aggregate tag found foreach for ' . $match[0] . '</p>';
			
			if ($match[1] == 'expression_group') {
				$aggregate_mode = 'expression';
			}
			else {
				$aggregate_mode = 'aggregate';
			}
			
			unset($aggregate_tag_data); // Reset the variable that will hold the components of the aggregate this loop

			if ($pssdebug) {
				echo "<hr />Aggregate tag number $pssAggregateIndex:<br />\n";
			}	
			//echo "<pre>";
			//print_r($match);
			//echo "</pre>";

			// $match[1] contains either 'aggregate' or 'expression_group'
			// $match[2] starts with a colon and contains (curly brace colon)-delimited aggregate elements
			$aggregate_elements = preg_split("/(?<=}):/s", ltrim($match[2], ":"));

			if ($pssdebug) {
				echo "<br />Aggregate elements:<pre>";
				print_r($aggregate_elements);
				echo "</pre>\n";
			}		

			$aggregate_tag_data = array();

			// fill aggregate elements with values
			foreach ($aggregate_elements as $aggregate_element) {

				// function (not an array)
				if (strpos($aggregate_element, "function{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/function{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if function is already filled, don't fill it again
						$aggregate_tag_data['function'] = empty($aggregate_tag_data['function']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['function'];
						continue;
					}	
				}

				// field (not an array)
				// 20100511 add group_name as alternative that means the same thing for use with [:expression_group... tag
				if (strpos($aggregate_element, "field{") !== false || strpos($aggregate_element, 'group_name{') !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					// ?: means non-capturing parentheses
					preg_match("/(?:field|group_name){(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if field is already filled, don't fill it again
						$aggregate_tag_data['field'] = empty($aggregate_tag_data['field']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['field'];
						continue;
					}	
				}

				// category (not an array)
				if (strpos($aggregate_element, "category{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/category{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if category is already filled, don't fill it again
						$aggregate_tag_data['category'] = empty($aggregate_tag_data['category']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['category'];
						continue;
					}	
				}

				// table (not an array)
				if (strpos($aggregate_element, "table{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/table{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if table is already filled, don't fill it again
						$aggregate_tag_data['table'] = empty($aggregate_tag_data['table']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['table'];
						continue;
					}	
				}

				// where (not an array)
				if (strpos($aggregate_element, "where{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/where{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if where is already filled, don't fill it again
						$aggregate_tag_data['where'] = empty($aggregate_tag_data['where']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['where'];
						continue;
					}	
				}

				// query (not an array)
				if (strpos($aggregate_element, "query{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/query{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if query is already filled, don't fill it again
						$aggregate_tag_data['query'] = empty($aggregate_tag_data['query']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['query'];
						continue;
					}	
				}
				// ignore_empty_records (not an array)
				if (strpos($aggregate_element, "ignore_empty_records{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/ignore_empty_records{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if ignore_empty_records is already filled, don't fill it again
						$aggregate_tag_data['ignore_empty_records'] = empty($aggregate_tag_data['ignore_empty_records']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['ignore_empty_records'];
						continue;
					}	
				}
				// cast (not an array)
				if (strpos($aggregate_element, "cast{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/cast{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if cast is already filled, don't fill it again
						$aggregate_tag_data['cast'] = empty($aggregate_tag_data['cast']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['cast'];
						continue;
					}	
				}
				// cast_for_ordering (not an array)
				if (strpos($aggregate_element, "cast_for_ordering{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/cast_for_ordering{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if cast_for_ordering is already filled, don't fill it again
						$aggregate_tag_data['cast_for_ordering'] = empty($aggregate_tag_data['cast_for_ordering']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['cast_for_ordering'];
						continue;
					}	
				}
				// concat_separator (not an array)
				// note that it may be desired to have an empty string as the concat_separator
				if (strpos($aggregate_element, "concat_separator{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/concat_separator{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1])) {
						// if concat_separator is already filled, don't fill it again
						$aggregate_tag_data['concat_separator'] = !isset($aggregate_tag_data['concat_separator']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['concat_separator'];
						continue;
					}	
				}
				// chart_size (not an array)
				if (strpos($aggregate_element, "chart_size{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/chart_size{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if chart_size is already filled, don't fill it again
						$aggregate_tag_data['chart_size'] = empty($aggregate_tag_data['chart_size']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['chart_size'];
						continue;
					}	
				}
				// chart_type (not an array)
				if (strpos($aggregate_element, "chart_type{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/chart_type{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if chart_type is already filled, don't fill it again
						$aggregate_tag_data['chart_type'] = empty($aggregate_tag_data['chart_type']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['chart_type'];
						continue;
					}	
				}
				// chart_color (not an array)
				if (strpos($aggregate_element, "chart_color{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/chart_color{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if chart_color is already filled, don't fill it again
						$aggregate_tag_data['chart_color'] = empty($aggregate_tag_data['chart_color']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['chart_color'];
						continue;
					}	
				}
				// chart_no_response_label (not an array)
				// DIFFERENT CODE THAN PREVIOUS CONDITIONALS
				if (strpos($aggregate_element, "chart_no_response_label{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/chart_no_response_label{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1])) { // allow this one to be an empty string // && $aggregate_element_match[1] != "") {
						// if chart_no_response_label is already filled, don't fill it again
						$aggregate_tag_data['chart_no_response_label'] = empty($aggregate_tag_data['chart_no_response_label']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['chart_no_response_label'];
						continue;
					}	
				}
				if (strpos($aggregate_element, "data_labels{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/data_labels{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if data_labels is already filled, don't fill it again
						$aggregate_tag_data['data_labels'] = empty($aggregate_tag_data['data_labels']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['data_labels'];
						continue;
					}	
				}
				if (strpos($aggregate_element, "chart_value{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/chart_value{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if chart_value is already filled, don't fill it again
						$aggregate_tag_data['chart_value'] = empty($aggregate_tag_data['chart_value']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['chart_value'];
						continue;
					}	
				}
				if (strpos($aggregate_element, "chart_label{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/chart_label{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if chart_label is already filled, don't fill it again
						$aggregate_tag_data['chart_label'] = empty($aggregate_tag_data['chart_label']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['chart_label'];
						continue;
					}	
				}
				if (strpos($aggregate_element, "title{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/title{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if title is already filled, don't fill it again
						$aggregate_tag_data['title'] = empty($aggregate_tag_data['title']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['title'];
						continue;
					}	
				}
				if (strpos($aggregate_element, "title_attributes{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/title_attributes{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if title_attributes is already filled, don't fill it again
						$aggregate_tag_data['title_attributes'] = empty($aggregate_tag_data['title_attributes']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['title_attributes'];
						continue;
					}	
				}
				if (strpos($aggregate_element, "completedapprovedpublished{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/completedapprovedpublished{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if completedapprovedpublished is already filled, don't fill it again
						$aggregate_tag_data['completedapprovedpublished'] = empty($aggregate_tag_data['completedapprovedpublished']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['completedapprovedpublished'];
						continue;
					}	
				}
				if (strpos($aggregate_element, "value{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/value{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if value is already filled, don't fill it again
						$aggregate_tag_data['value'] = empty($aggregate_tag_data['value']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['value'];
						continue;
					}	
				}
				if (strpos($aggregate_element, "order_by{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/order_by{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if order_by is already filled, don't fill it again
						$aggregate_tag_data['order_by'] = empty($aggregate_tag_data['order_by']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['order_by'];
						continue;
					}	
				}
				
				if (strpos($aggregate_element, "member{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/member{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if order_by is already filled, don't fill it again
						$aggregate_tag_data['member'] = empty($aggregate_tag_data['member']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['member'];
						continue;
					}	
				}

				if (strpos($aggregate_element, "debug{") !== false) {
					// ungreedy quantifier (.*?) over multiple lines (s)
					preg_match("/debug{(.*?)}/s", $aggregate_element, $aggregate_element_match);
					if (isset($aggregate_element_match[1]) && $aggregate_element_match[1] != "") {
						// if order_by is already filled, don't fill it again
						$aggregate_tag_data['debug'] = empty($aggregate_tag_data['debug']) ? parseScoreScript($quizScore, $aggregate_element_match[1]) : $aggregate_tag_data['debug'];
						continue;
					}	
				}

			}

			if ($pssdebug) {
				echo "<br />Aggregate tag data array before defaults get filled in:<pre>";
				print_r($aggregate_tag_data);
				echo "</pre>\n";
			}	

			if (file_exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php')) {
			/**
			 * Include the component configuration file
			 */
				include JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php';
			}

			/*** FILL IN DEFAULTS FOR AGGREGATE ELEMENTS ***/
			
			if (!isset($aggregate_tag_data['function'])) {
				if (isset($mbDefaultSSAggregateFunction) && $mbDefaultSSAggregateFunction != '') {
					$aggregate_tag_data['function'] = parseScoreScript($quizScore, $mbDefaultSSAggregatefunction);
				}	
				else {
					$aggregate_tag_data['function'] = '';
				}
			}
			if (!isset($aggregate_tag_data['field'])) {
				if (isset($mbDefaultSSAggregateField) && $mbDefaultSSAggregateField != '') {
					$aggregate_tag_data['field'] = parseScoreScript($quizScore, $mbDefaultSSAggregatefield);
				}	
				else {
					$aggregate_tag_data['field'] = '';
				}
			}
			if (!isset($aggregate_tag_data['category'])) {
				if (isset($mbDefaultSSAggregateCategory) && $mbDefaultSSAggregateCategory != '') {
					$aggregate_tag_data['category'] = parseScoreScript($quizScore, $mbDefaultSSAggregatecategory);
				}	
				else {
					$aggregate_tag_data['category'] = '';
				}
			}
			if (!isset($aggregate_tag_data['table'])) {
				if (isset($mbDefaultSSAggregateTable) && $mbDefaultSSAggregateTable != '') {
					$aggregate_tag_data['table'] = parseScoreScript($quizScore, $mbDefaultSSAggregatetable);
				}	
				else {
					$aggregate_tag_data['table'] = '';
				}
			}
			if (!isset($aggregate_tag_data['where'])) {
				if (isset($mbDefaultSSAggregateWhere) && $mbDefaultSSAggregateWhere != '') {
					$aggregate_tag_data['where'] = parseScoreScript($quizScore, $mbDefaultSSAggregatewhere);
				}	
				else {
					$aggregate_tag_data['where'] = '';
				}
			}
			if (!isset($aggregate_tag_data['query'])) {
				if (isset($mbDefaultSSAggregateQuery) && $mbDefaultSSAggregateQuery != '') {
					$aggregate_tag_data['query'] = parseScoreScript($quizScore, $mbDefaultSSAggregatequery);
				}	
				else {
					$aggregate_tag_data['query'] = '';
				}
			}
			if (!isset($aggregate_tag_data['ignore_empty_records'])) {
				if (isset($mbDefaultSSAggregateIgnoreEmptyRecords) && $mbDefaultSSAggregateIgnoreEmptyRecords != '') {
					$aggregate_tag_data['ignore_empty_records'] = parseScoreScript($quizScore, $mbDefaultSSAggregateIgnoreEmptyRecords);
				}	
				else {
					$aggregate_tag_data['ignore_empty_records'] = '';
				}
			}
			if (!isset($aggregate_tag_data['cast'])) {
				if (isset($mbDefaultSSAggregateCast) && $mbDefaultSSAggregateCast != '') {
					$aggregate_tag_data['cast'] = parseScoreScript($quizScore, $mbDefaultSSAggregateCast);
				}	
				else {
					$aggregate_tag_data['cast'] = '';
				}
			}
			if (!isset($aggregate_tag_data['cast_for_ordering'])) {
				if (isset($mbDefaultSSAggregateCastForOrdering) && $mbDefaultSSAggregateCastForOrdering != '') {
					$aggregate_tag_data['cast_for_ordering'] = parseScoreScript($quizScore, $mbDefaultSSAggregateCastForOrdering);
				}	
				else {
					$aggregate_tag_data['cast_for_ordering'] = '';
				}
			}
			// note that it may be desired for the concat_separator to be an empty string
			if (!isset($aggregate_tag_data['concat_separator'])) {
				if (isset($mbDefaultSSAggregateConcatSeparator)) {
					$aggregate_tag_data['concat_separator'] = parseScoreScript($quizScore, $mbDefaultSSAggregateConcatSeparator);
				}	
				else {
					$aggregate_tag_data['concat_separator'] = ', '; // hard coded default: comma space
				}
			}
			if (!isset($aggregate_tag_data['chart_size'])) {
				if (isset($mbDefaultSSAggregateChartSize) && $mbDefaultSSAggregateChartSize != '') {
					$aggregate_tag_data['chart_size'] = parseScoreScript($quizScore, $mbDefaultSSAggregateChartSize);
				}	
				else {
					$aggregate_tag_data['chart_size'] = '250x100'; // hard coded default: 250x100
				}
			}
			if (!isset($aggregate_tag_data['chart_type'])) {
				if (isset($mbDefaultSSAggregateChartType) && $mbDefaultSSAggregateChartType != '') {
					$aggregate_tag_data['chart_type'] = parseScoreScript($quizScore, $mbDefaultSSAggregateChartType);
				}	
				else {
					$aggregate_tag_data['chart_type'] = '';
				}
			}
			if (!isset($aggregate_tag_data['chart_color'])) {
				if (isset($mbDefaultSSAggregateChartColor) && $mbDefaultSSAggregateChartColor != '') {
					$aggregate_tag_data['chart_color'] = parseScoreScript($quizScore, $mbDefaultSSAggregateChartColor);
				}	
				else {
					$aggregate_tag_data['chart_color'] = '';
				}
			}
			if (!isset($aggregate_tag_data['chart_no_response_label'])) {
				if (isset($mbDefaultSSAggregateChartNoResponseLabel) && $mbDefaultSSAggregateChartNoResponseLabel != '') {
					$aggregate_tag_data['chart_no_response_label'] = parseScoreScript($quizScore, $mbDefaultSSAggregateChartNoResponseLabel);
				}	
				else {
					$aggregate_tag_data['chart_no_response_label'] = '<No response>';
				}
			}
			if (!isset($aggregate_tag_data['data_labels'])) {
				if (isset($mbDefaultSSAggregateChartDataLabels) && $mbDefaultSSAggregateChartDataLabels != '') {
					$aggregate_tag_data['data_labels'] = parseScoreScript($quizScore, $mbDefaultSSAggregateChartDataLabels);
				}	
				else {
					$aggregate_tag_data['data_labels'] = 'normal';
				}
			}
			if (!isset($aggregate_tag_data['chart_value'])) {
				if (isset($mbDefaultSSAggregateChartValue) && $mbDefaultSSAggregateChartValue != '') {
					$aggregate_tag_data['chart_value'] = parseScoreScript($quizScore, $mbDefaultSSAggregateChartValue);
				}	
				else {
					$aggregate_tag_data['chart_value'] = '';
				}
			}
			if (!isset($aggregate_tag_data['chart_label'])) {
				if (isset($mbDefaultSSAggregateChartLabel) && $mbDefaultSSAggregateChartLabel != '') {
					$aggregate_tag_data['chart_label'] = parseScoreScript($quizScore, $mbDefaultSSAggregateChartLabel);
				}	
				else {
					$aggregate_tag_data['chart_label'] = '';
				}
			}
			if (!isset($aggregate_tag_data['title'])) {
				if (isset($mbDefaultSSAggregateChartTitle) && $mbDefaultSSAggregateChartTitle != '') {
					$aggregate_tag_data['title'] = parseScoreScript($quizScore, $mbDefaultSSAggregateChartTitle);
				}	
				else {
					$aggregate_tag_data['title'] = '';
				}
			}
			if (!isset($aggregate_tag_data['title_attributes'])) {
				if (isset($mbDefaultSSAggregateChartTitleAttributes) && $mbDefaultSSAggregateChartTitleAttributes != '') {
					$aggregate_tag_data['title_attributes'] = parseScoreScript($quizScore, $mbDefaultSSAggregateChartTitleAttributes);
				}	
				else {
					$aggregate_tag_data['title_attributes'] = '';
				}
			}
			if (!isset($aggregate_tag_data['completedapprovedpublished'])) {
				if (isset($mbDefaultSSAggregateCompletedApprovedPublished) && $mbDefaultSSAggregateCompletedApprovedPublished != '') {
					$aggregate_tag_data['completedapprovedpublished'] = parseScoreScript($quizScore, $mbDefaultSSAggregateCompletedApprovedPublished);
				}	
				else {
					$aggregate_tag_data['completedapprovedpublished'] = '';
				}
			}
			if (!isset($aggregate_tag_data['value'])) {
				if (isset($mbDefaultSSAggregateValue) && $mbDefaultSSAggregateValue != '') {
					$aggregate_tag_data['value'] = parseScoreScript($quizScore, $mbDefaultSSAggregateValue);
				}	
				else {
					$aggregate_tag_data['value'] = '';
				}
			}
			if (!isset($aggregate_tag_data['order_by'])) {
				if (isset($mbDefaultSSAggregateOrderBy) && $mbDefaultSSAggregateOrderBy != '') {
					$aggregate_tag_data['order_by'] = parseScoreScript($quizScore, $mbDefaultSSAggregateOrderBy);
				}	
				else {
					$aggregate_tag_data['order_by'] = '';
				}
			}
			if (!isset($aggregate_tag_data['member'])) {
				if (isset($mbDefaultSSAggregateMember) && $mbDefaultSSAggregateMember != '') {
					$aggregate_tag_data['member'] = parseScoreScript($quizScore, $mbDefaultSSAggregateMember);
				}	
				else {
					$aggregate_tag_data['member'] = '';
				}
			}
			if (!isset($aggregate_tag_data['debug'])) {
				if (isset($mbDefaultSSAggregateDebug) && $mbDefaultSSAggregateDebug != '') {
					$aggregate_tag_data['debug'] = parseScoreScript($quizScore, $mbDefaultSSAggregateDebug);
				}	
				else {
					$aggregate_tag_data['debug'] = '';
				}
			}

			if ($pssdebug) {
				echo "<br />Aggregate tag data array, with defaults from the config file filled in:<pre>";
				print_r($aggregate_tag_data);
				echo "</pre>";
			}

			/*** BEGIN AGGREGATE OPTION VALIDATION SECTION ***/
			
			// establish defaults for "aggregate tag data" that are not 
			//  specified in the tag itself or in the configuration file
			
			if (array_search(JString::strtoupper($aggregate_tag_data['function']),
			array('AVG', 'AVG-DISTINCT', 'COUNT', 'COUNT-DISTINCT', 'MAX', 'MIN',
			'SUM', 'STD', 'MODE', 'CONCAT', 'CONCAT-DISTINCT', 'GOOGLE-CHART', 'GOOGLE-CHART-PERCENTAGE',
			'MEDIAN', 'MEDIAN-DISTINCT', 'COUNT-VALUE', 'COUNT-VALUE-RATIO', 'COUNT-VALUE-PERCENTAGE', 'SQL',
			'SET-MEMBER')
			) === false) {
				// this one's required to be specified;
				//  if it's not in the list of valid functions, continue the 'foreach'
				//  aggregate tag with empty string below
				continue; // continue the 'foreach' ($matches as $match)						
			}
			// field: no further validation required (it's in a conditional below or it's not)
			//  however, if it's empty continue the 'foreach' now
			if ($aggregate_tag_data['field'] == '' && $aggregate_tag_data['chart_type'] != 'gom' && strtoupper($aggregate_tag_data['function']) != 'SQL') {
				// this one's required to be specified unless we're doing a Google-o-meter;
				//  if it's not continue
				continue; // continue the 'foreach' ($matches as $match)						
			}
			if ($aggregate_tag_data['category'] == '' || $aggregate_tag_data['category'] == 'this') {
				$aggregate_tag_data['category'] = $quizScore['category_id'];
			}
			if ($aggregate_tag_data['table'] == '') {
				if ($aggregate_mode == 'expression') {
					$aggregate_tag_data['table'] = '#__madblanks_aux';
				}
				else {
					$aggregate_tag_data['table'] = '#__madblanks_records';
				}
			}
			if ($aggregate_tag_data['where'] == '') {
				// 20100513 add session check to WHERE clause when using [:expression_group...
				if ($aggregate_mode == 'expression') {
					if (empty($session)) {
						$session = getMadBlanksSession();
					}	
					$aggregate_tag_data['where'] = "session = '$session'";
				}
				else {
					$aggregate_tag_data['where'] = 1;
				}	
			}
			// query: no further validation required
			//if ($aggregate_tag_data['query'] == '') {
			//	$aggregate_tag_data['query'] = '';
			//}
			if (JString::strtoupper($aggregate_tag_data['ignore_empty_records']) == 'TRUE') {
				$aggregate_tag_data['ignore_empty_records'] = true; // boolean
			}
			else {
				$aggregate_tag_data['ignore_empty_records'] = false; // boolean
			}
			
			if ($aggregate_tag_data['cast'] == '') {
			//	// if empty string or invalid, assume it's a SIGNED integer
			//	if ($pssdebug) {
			//		echo '<br />$aggregate_tag_data[\'cast\'] is empty string; therefore assigning cast type SIGNED';
			//	}
			//	$aggregate_tag_data['cast'] = 'SIGNED';
			}
			else {
				$aggregate_tag_data['cast'] = JString::strtoupper($aggregate_tag_data['cast']);
				// the cast must START with one of the following;
				$cast_array = array('SIGNED', 'BINARY', 'CHAR', 'DATE', 'DATETIME', 'DECIMAL', 'TIME', 'UNSIGNED');
				//  some of these will allow for additional parameters 
				//  so we're only checking the beginning of the string
				foreach ($cast_array as $type) {
					if (strpos($aggregate_tag_data['cast'], $type) === 0) {
						// matched OK
						if ($pssdebug) {
							echo '<br />$aggregate_tag_data[\'cast\'] is OK';
						}
						break;
					}
					if ($type == $cast_array[count($cast_array) - 1]) {
					//	// didn't match OK
					//	// if empty string or invalid, assume it's a SIGNED integer
					//	if ($pssdebug) {
					//		echo '<br />$aggregate_tag_data[\'cast\'] is not in the list of valid types; therefore assigning cast type SIGNED';
					//	}
					//	$aggregate_tag_data['cast'] = 'SIGNED';
						$aggregate_tag_data['cast'] = '';
					}
				}
			}
			if ($aggregate_tag_data['cast_for_ordering'] != '') {

				$aggregate_tag_data['cast_for_ordering'] = JString::strtoupper($aggregate_tag_data['cast_for_ordering']);
				// the cast_for_ordering must START with one of the following;
				//  some of these will allow for additional parameters 
				//  so we're only checking the beginning of the string
				$cast_for_ordering_array = array('SIGNED', 'BINARY', 'CHAR', 'DATE', 'DATETIME', 'DECIMAL', 'TIME', 'UNSIGNED');
				foreach ($cast_for_ordering_array as $type) {
					if (strpos($aggregate_tag_data['cast_for_ordering'], $type) === 0) {
						// matched OK
						if ($pssdebug) {
							echo '<br />$aggregate_tag_data[\'cast_for_ordering\'] is OK';
						}
						break;
					}
					if ($type == $cast_for_ordering_array[count($cast_for_ordering_array) - 1]) {
						// didn't match OK
						$aggregate_tag_data['cast_for_ordering'] = '';
					}
				}
			}
			
			// concat_separator: default of ', ' specified above; no further validation required
			//if ($aggregate_tag_data['concat_separator'] == '') {
			//	$aggregate_tag_data['concat_separator'] = '';
			//}
			
			// chart_size: no further validation required
			//if ($aggregate_tag_data['chart_size'] == '') {
			//	$aggregate_tag_data['chart_size'] = '';
			//}

			if (array_search(JString::strtolower($aggregate_tag_data['chart_type']),
				array('p3', 'p', 'pc', 'bhs', 'bvs', 'bhg', 'bvg',
				'bhs', 'lc', 'ls', 'lxy', 'v', 's', 'rs', 'gom')
				) === false) {
				$aggregate_tag_data['chart_type'] = 'p3'; // 3d pie chart is the default
			}
			else {
				$aggregate_tag_data['chart_type'] = JString::strtolower($aggregate_tag_data['chart_type']);
			}
			
			// chart_color: no further validation required
			//if ($aggregate_tag_data['chart_color'] == '') {
			//	$aggregate_tag_data['chart_color'] = '';
			//}

			// chart_no_response_label: no further validation required
			//if ($aggregate_tag_data['chart_no_response_label'] == '') {
			//	$aggregate_tag_data['chart_no_response_label'] = '';
			//}

			if (array_search(JString::strtolower($aggregate_tag_data['data_labels']),
			array('normal', 'short')
			) === false) {
				$aggregate_tag_data['data_labels'] = 'normal';
			}
			else {
				$aggregate_tag_data['data_labels'] = JString::strtolower($aggregate_tag_data['data_labels']);
			}
			
			// chart_value: no further validation required
			//if ($aggregate_tag_data['chart_value'] == '') {
			//	$aggregate_tag_data['chart_value'] = '';
			//}
			
			// chart_label: no further validation required
			//if ($aggregate_tag_data['chart_label'] == '') {
			//	$aggregate_tag_data['chart_label'] = '';
			//}

			// title: no further validation required
			//if ($aggregate_tag_data['title'] == '') {
			//	$aggregate_tag_data['title'] = '';
			//}

			// title_attributes: no further validation required
			//if ($aggregate_tag_data['title_attributes'] == '') {
			//	$aggregate_tag_data['title_attributes'] = '';
			//}
			
			if (!preg_match('/^([10x])([10x])([10x])$/i', $aggregate_tag_data['completedapprovedpublished'], $cap_matches)) {
				// require that records are completed, approved, and published by default
				if ($pssdebug) {
					echo '<br />invalid: completedapprovedpublished{' . $aggregate_tag_data['completedapprovedpublished'] . '}';
				}
				$cap_matches = array('111', '1', '1', '1');
			}
			else {
				// ensure we have all lowercase x
				//$aggregate_tag_data['completedapprovedpublished'] = JString::strtolower($aggregate_tag_data['completedapprovedpublished']);
				
				if ($pssdebug) {
					echo '<br />valid completedapprovedpublished{' . $cap_matches[0] . '}';
				}

			}
			// specify portion of WHERE clause corresponding to the set condition:
			if ($pssdebug) {
				echo '<br />$cap_matches are <pre>' . var_dump($cap_matches, 1) . '</pre>';
			}
			$cap = ''; // initialize
			// completed
			if ($cap_matches[1] == '0') {
				$cap .= "\nAND completed = 0";
			}
			else if ($cap_matches[1] == '1') {
				$cap .= "\nAND completed > 0";
			}
			// approved
			if ($cap_matches[2] == '0') {
				$cap .= "\nAND approved = 0";
			}
			else if ($cap_matches[2] == '1') {
				$cap .= "\nAND approved > 0";
			}
			// published
			if ($cap_matches[3] == '0') {
				$cap .= "\nAND published = 0";
			}
			else if ($cap_matches[3] == '1') {
				$cap .= "\nAND published > 0";
			}
			if ($pssdebug) {
				echo '<br />$cap string for WHERE clause is: <em>' . $cap . '</em>';
			}
			
			// value: no further validation required
			//if ($aggregate_tag_data['value'] == '') {
			//	$aggregate_tag_data['value'] = '';
			//}

			// order_by
			
			// $aggregate_tag_data['order_by'] should contain: 
			//  A.) ASC to sort from low to high or A to Z, 
			//  B.) DESC to sort from high to low or Z to A, 
			//  C.) OR the text that would follow ORDER BY in a MySQL query
			
			// 1.4.0 final Remove forced CAST, only apply it if specified in the aggregate/expression_group tag
			if ($aggregate_tag_data['cast_for_ordering'] != '') {
				$order_by_this = 'CAST(' . ($aggregate_mode == 'expression' ? 'data' : $aggregate_tag_data['field']) . ' as ' . $aggregate_tag_data['cast_for_ordering'] . ')';
			}
			else {
				$order_by_this = ($aggregate_mode == 'expression' ? 'data' : $aggregate_tag_data['field']);				
			}	
			if ($pssdebug) {
				echo '<br />$order_by_this is <b>' . $order_by_this . '</b> based on field <b>' . ($aggregate_mode == 'expression' ? 'data' : $aggregate_tag_data['field']) . '</b> and cast_for_ordering <b>' . $aggregate_tag_data['cast_for_ordering'] . '</b></em>';
			}
			
			if ($aggregate_tag_data['order_by'] == '') {
				$order_by = '';
			}
			
			else if ($aggregate_tag_data['order_by'] == 'ASC') {
				$order_by = "\nORDER BY " . $order_by_this . ' ASC';
			}
			else if ($aggregate_tag_data['order_by'] == 'DESC') {
				$order_by = "\nORDER BY " . $order_by_this . ' DESC';
			}
			else {
				$order_by ="\nORDER BY " . $aggregate_tag_data['order_by'];
			}
			if ($pssdebug) {
				echo '<br />$order_by clause based on input of &quot;' . $aggregate_tag_data['order_by'] . '&quot; is: <em>' . $order_by . '</em>';
			}
			
			// member
			if (!is_numeric($aggregate_tag_data['member'])) {
				$aggregate_tag_data['member'] = 1;
			}


			/*** END AGGREGATE OPTION VALIDATION SECTION ***/
			

			if ($pssdebug) {
				echo "<br />Final aggregate tag data array:<pre>";
				print_r($aggregate_tag_data);
				echo "</pre>";
			}

			//echo "<pre>"; var_dump($aggregate_tag_data); echo "</pre>\n";

			/*** BEGIN EXPRESSION GROUP TEMPORARY TABLE SECTION ***/
			// 20100511 if this is an expression_group tag, store temporary data 
			//  in the database #_madblanks_aux table with the corresponding data now
			// this data should be removed using cleanAuxExpressionGroupTable() upon looping again 
			//  (either by calling 'continue' or at the end of the foreach '$matches as $match' loop)
			if ($aggregate_mode == 'expression') {
				
				if (empty($session)) {
					$session = getMadBlanksSession();
				}
				$expression_group = $aggregate_tag_data['field'];
				establishAuxExpressionGroupTable($aggregate_tag_data, $quizScore, $session);
				
			}
			
			/*** END EXPRESSION GROUP TEMPORARY TABLE SECTION ***/

			//global $mbAcceptGoogleChartTOS;
			$aggregate_query = null; // initialize
			
			// 1.4.0 final Remove forced CAST, only apply it if specified in the aggregate/expression_group tag
			if ($aggregate_tag_data['cast'] != '') {
				$select_this = 'CAST(' . $aggregate_tag_data['field'] . ' as ' . $aggregate_tag_data['cast'] . ')';
			}
			else {
				$select_this = $aggregate_tag_data['field'];
			}	

			// 1.4.0 Final CPH 20100427 moved conditional check for a custom function to be the last
			//  in the else if chain; this way custom query can be used inside other options...
			if ($aggregate_tag_data['function'] == '') {
				if ($pssdebug) {
					echo '<br />No valid aggregate function specified';
				}
				$aggregate_query = null;
			}
			// check for a custom query; if present, use it
			else if ($aggregate_tag_data['function'] == 'SQL' && $aggregate_tag_data['query'] != '') {
				if ($pssdebug) {
					echo '<br />Custom aggregate query specified';
				}
				if ($aggregate_tag_data['where'] == 1) {
					$aggregate_query = $aggregate_tag_data['query'];
				}
				else {
					// if there is a custom WHERE clause, use it as part of the specified query
					$aggregate_query = $aggregate_tag_data['query'] . ' WHERE ' . $aggregate_tag_data['where'] . $cap . $order_by;	
				}
			}
			else if ($aggregate_tag_data['field'] == '' && $aggregate_tag_data['chart_type'] != 'gom') {
				if ($pssdebug) {
					echo '<br />No aggregate field specified';
				}
				$aggregate_query = null;
			}
			else if ($aggregate_tag_data['function'] == 'MODE') {

				$aggregate_query = 'SELECT ' . $aggregate_tag_data['field'] . ', count(' . $aggregate_tag_data['field'] . ') AS qty 
				FROM `' . $aggregate_tag_data['table'] .
				'` WHERE configid = ' . $aggregate_tag_data['category'] .
				' AND ' . $aggregate_tag_data['where'] .
				$cap .
				($aggregate_tag_data['ignore_empty_records'] ? ' AND ' . $aggregate_tag_data['field'] . ' != \'\'' : '') .
				' GROUP BY ' . $aggregate_tag_data['field'] .
				' ORDER BY qty DESC 
				LIMIT 1';
				if ($pssdebug) {
					echo '<br />Built mode query: ' . $aggregate_query;
				}
			}
			
			// CONCAT, MEDIAN
			else if ($aggregate_tag_data['function'] == 'CONCAT' || $aggregate_tag_data['function'] == 'CONCAT-DISTINCT' || $aggregate_tag_data['function'] == 'MEDIAN' || $aggregate_tag_data['function'] == 'MEDIAN-DISTINCT') {
				if ($aggregate_tag_data['function'] == 'MEDIAN' || $aggregate_tag_data['function'] == 'MEDIAN-DISTINCT') {
					$aggregate_tag_data['concat_separator'] = ',';
				}
				$aggregate_query = 'SELECT GROUP_CONCAT(' . (($aggregate_tag_data['function'] == 'CONCAT-DISTINCT' || $aggregate_tag_data['function'] == 'MEDIAN-DISTINCT') ? 'DISTINCT ' : '') . $select_this /*$aggregate_tag_data['field']*/ . 
				' ' . $order_by .
				' SEPARATOR "' . $aggregate_tag_data['concat_separator'] . '")' .
				' FROM `' . $aggregate_tag_data['table'] . '`' . 
				' WHERE configid = ' . $aggregate_tag_data['category'] .
				' AND ' . $aggregate_tag_data['where'] .
				$cap .
				($aggregate_tag_data['ignore_empty_records'] ? ' AND ' . $aggregate_tag_data['field'] . ' != \'\'' : '');

				//echo "<pre>\$aggregate_query\n"; print_r($aggregate_query); echo "</pre>\n";
				
				if ($aggregate_tag_data['debug'] || $pssdebug) {
					echo '<br /><br />Built query: ' . $aggregate_query;
				}
			}
			
			else if ($aggregate_tag_data['function'] == 'SET-MEMBER') {
				
				$aggregate_query = 'SELECT ' . (($aggregate_tag_data['data_labels'] == 'short' && $aggregate_mode == 'expression') ? 'alt_label' : $aggregate_tag_data['field']) .
				' FROM `' . $aggregate_tag_data['table'] . '`' .
				' WHERE configid = ' . $aggregate_tag_data['category'] .
				' AND ' . $aggregate_tag_data['where'] .
				$cap .
				($aggregate_tag_data['ignore_empty_records'] ? ' AND ' . $aggregate_tag_data['field'] . ' != \'\'' : '') .
				' ' . $order_by .
				' LIMIT ' . ((int) $aggregate_tag_data['member'] - 1) . ', 1';

				//echo "<pre>\$aggregate_query\n"; print_r($aggregate_query); echo "</pre>\n";

				if ($pssdebug) {
					echo '<br />Built query: ' . $aggregate_query;
				}
			}
			
			else if (($aggregate_tag_data['function'] == 'GOOGLE-CHART' || $aggregate_tag_data['function'] == 'GOOGLE-CHART-PERCENTAGE') && strtolower($mbAcceptGoogleChartTOS) == 'yes') {
				
				if ($aggregate_tag_data['chart_type'] == 'gom') {
					$chd = $aggregate_tag_data['chart_value'];	
				}
				
				else {
				
					if ($aggregate_tag_data['query']) {
					
						$aggregate_query = $aggregate_tag_data['query'];
					
					}
					
					else {
					
						$aggregate_query = 'SELECT ' . $aggregate_tag_data['field'] . ' as chl, count(*) as chd' .
						' FROM ' . $aggregate_tag_data['table'] .
						' WHERE configid = ' . $aggregate_tag_data['category'] .
						' AND ' . $aggregate_tag_data['where'] .
						$cap .
						($aggregate_tag_data['ignore_empty_records'] ? ' AND ' . $aggregate_tag_data['field'] . ' != \'\'' : '') .
						' GROUP BY ' . $aggregate_tag_data['field'] .
						$order_by;
					
					}

					//echo "<pre>\$aggregate_query\n"; print_r($aggregate_query); echo "</pre>\n";
					//echo "<p>The QUERY is "; var_dump($aggregate_tag_data['query']); echo "</p>";
					if ($pssdebug) {
						echo '<p>The QUERY for ' . $aggregate_tag_data['function'] . ' is ' . $aggregate_query . '</p>';
					}	


					$database = &JFactory::getDBO();
					$database->setQuery($aggregate_query);
					//$aggregate_result = $database->loadResult();
					$aggregate_results = $database->loadObjectList();
					//echo "<pre>\n\$aggregate_results are\n\n"; print_r($aggregate_results); echo "</pre>\n";

					if ($aggregate_tag_data['debug'] || $pssdebug) {
						if ($database->stderr()) {
							echo '<br />Query: ' . $aggregate_query . '<br />Return status: ' . $database->stderr();
						}
						else {
							echo '<br />Query: ' . $aggregate_query . '<br />Query successful';
						}
					}

					$chdsum = 0; // initialize
					//if ($aggregate_tag_data['function'] == 'GOOGLE-CHART-PERCENTAGE') {

					// establish how many total results there are so we can calculate percentage
					foreach ($aggregate_results as $aggregate_result) {

						$chdsum	+= $aggregate_result->chd;

					}

					foreach ($aggregate_results as $aggregate_key => $aggregate_result) {
					
						//echo '<br />$aggregate_key is ';
						//var_dump($aggregate_key);
						//echo 'and $aggregate_result is ';
						//var_dump($aggregate_result);
						
						//echo "<pre>quizScore is\n\n"; print_r($quizScore); echo "</pre>\n";

						if ($aggregate_result->chl == '') {
							$aggregate_results[$aggregate_key]->chl = $aggregate_tag_data['chart_no_response_label'];
							$aggregate_results[$aggregate_key]->chl_short = $aggregate_tag_data['chart_no_response_label'];
							$aggregate_results[$aggregate_key]->chl_empty = true;

						}
						else {
							$aggregate_results[$aggregate_key]->chl_empty = false;
							if ($aggregate_mode != 'expression') { // short choices will not exist this way for aggregate groups
								
								preg_match("/data_(\d\d)/", $aggregate_tag_data['field'], $shortlabels);

								//echo '<pre>the short choices are: ' . print_r($quizScore['info'][$shortlabels[1]]['short_choices']) . '</pre>';
								//echo '<br />the short choice for this loop is A' . $quizScore['info'][$shortlabels[1]]['short_choices'][$aggregate_result->chl] . 'Z<br />';
								//var_dump($aggregate_result->chl);

								if (isset($quizScore['info'][$shortlabels[1]]['short_choices'][$aggregate_result->chl])) {
									$aggregate_results[$aggregate_key]->chl_short = $quizScore['info'][$shortlabels[1]]['short_choices'][$aggregate_result->chl];
								}
								else { // come up with some default value for chl_short
									if (is_numeric($aggregate_result->chl)) {
										$aggregate_results[$aggregate_key]->chl_short = $aggregate_result->chl;
									}
									else {
										$words = str_word_count($aggregate_result->chl, 1);
										$aggregate_results[$aggregate_key]->chl_short = $words[0];
										unset($words);
									}
								}

								//unset($shortlabels);
							}
							else if ($aggregate_mode == 'expression') {
							
								//echo "<br />Final aggregate tag data array:<pre>";
								//print_r($aggregate_tag_data);
								//echo "</pre>";
				
								//what do we know about the expression at this point?
								// we need to know the expression identifier
								// once we know the identifier we can look up the short label
								
								
								
								//global ${'mbexpression__group_shortnames' . JString::strtolower($expression_group)};
								//echo "<pre>SHORT NAMES!\n\n"; print_r(${'mbexpression__group_shortnames' . JString::strtolower($expression_group)}); echo "</pre>\n";
							
								//$aggregate_results[$aggregate_key]->chl_empty = false;
								//preg_match("/data_(\d\d)/", $aggregate_tag_data['field'], $shortlabels);

								//echo '<pre>the short choices are: ' . print_r($quizScore['info'][$shortlabels[1]]['short_choices']) . '</pre>';
								//echo '<br />the short choice for this loop is A' . $quizScore['info'][$shortlabels[1]]['short_choices'][$aggregate_result->chl] . 'Z<br />';
								//var_dump($aggregate_result->chl);

								//if (isset($quizScore['info'][$shortlabels[1]]['short_choices'][$aggregate_result->chl])) {
								
								//$expression_group is the name of the expression group
								global ${'mbexpression__group' . JString::strtolower($expression_group)};
								
								// the chart label is contained in $aggregate_result->chl
								
								
								//if (isset($quizScore['info'][$shortlabels[1]]['short_choices'][$aggregate_result->chl])) {
								
								$theshortlabelkey = parseScoreScript($quizScore, array_search($aggregate_result->chl, ${'mbexpression__group' . JString::strtolower($expression_group)}));
								
								// the keys where there is a short label start with three underscores
								if (strpos($theshortlabelkey, '___') !== false && strpos($theshortlabelkey, '___') == 0) {
									//$aggregate_results[$aggregate_key]->chl_short = $quizScore['info'][$shortlabels[1]]['short_choices'][$aggregate_result->chl];
									$aggregate_results[$aggregate_key]->chl_short = substr($theshortlabelkey, 3); // remove the three underscores
									
									//echo '<h1>assigned index ' . array_search($aggregate_result->chl, ${'mbexpression__group' . JString::strtolower($expression_group)}) . ' after searching for ' . $aggregate_result->chl . ' in array <pre>'; var_dump(${'mbexpression__group' . JString::strtolower($expression_group)}); echo '</pre></h1>';
								}
								else { // come up with some default value for chl_short
									if (is_numeric($aggregate_result->chl)) {
										$aggregate_results[$aggregate_key]->chl_short = $aggregate_result->chl;
									}
									else {
										$words = str_word_count($aggregate_result->chl, 1);
										//echo "<pre>words are\n\n"; print_r($words); echo "</pre>\n";
										// take only the first word in the phrase, assuming there is a phrase
										$aggregate_results[$aggregate_key]->chl_short = $words[0];
										unset($words);
									}
								}
							}
							unset($shortlabels);
						}
						$aggregate_results[$aggregate_key] -> chl_percentage = $aggregate_result->chl . ' (' . round(($aggregate_result->chd / $chdsum) * 100) . '%)';
						$aggregate_results[$aggregate_key] -> chl_short_percentage = $aggregate_result->chl_short . ' (' . round(($aggregate_result->chd / $chdsum) * 100) . '%)';
						$aggregate_results[$aggregate_key] -> chd_percentage = round(($aggregate_result->chd / $chdsum) * 100);
					}
					
					//echo "<pre>"; print_r($aggregate_results); echo "</pre>\n";
					//}	

					//echo "<br />\$chdsum is $chdsum";

					$chl = ''; // initialize chart labels as a STRING
					$chd = ''; // initialize chart data as a STRING

					if ($aggregate_tag_data['data_labels'] == 'short') {
						$chlshort = '_short';
					}
					else {
						$chlshort = '';
					}

					foreach ($aggregate_results as $aggregate_result) {

						//echo "<br />starting loop chd is $chd and chl is $chl";

						//$chl .= ($chl ? '|' : '') . ($aggregate_result->chl == '' ? '(no response)' : $aggregate_result->chl);

						if ($aggregate_tag_data['function'] == 'GOOGLE-CHART-PERCENTAGE') {

							//echo "<br />doing percentage chd is " . var_dump($chd);
							//$chd .= ($chd != '' ? ',' : '') . (($aggregate_result->chd == '' || $chdsum == 0) ? '0' : strval(round(($aggregate_result->chd / $chdsum) * 100)));

							$chl .= ($chl ? '|' : '') . $aggregate_result->{'chl' . $chlshort . '_percentage'};
							$chd .= ($chd != '' ? ',' : '') . $aggregate_result->chd_percentage;

						}
						else {

							//echo "<br />doing non-percentage chd  " . var_dump($chd);
							//$chd .= ($chd != '' ? ',' : '') . ($aggregate_result->chd == '' ? '0' : $aggregate_result->chd);
							if ($aggregate_result->chl_empty && $aggregate_tag_data['chart_no_response_label'] == '') {
								$chl .= '|';
							}
							else {
								$chl .= (($chl != '' && $chl != '|') ? '|' : '') . $aggregate_result->{'chl' . $chlshort};
							}

							$chd .= ($chd != '' ? ',' : '') . $aggregate_result->chd;

						}

						//echo "<br />ending loop chd is $chd and chl is $chl";

					}

					//// if short labels available, use those instead
					//echo "<pre>quizScore"; print_r($quizScore); echo "</pre>\n";
					//preg_match("/data_(\d\d)/", $aggregate_tag_data['field'], $shortmatches);
					//echo "<pre>SHORTMATCHES"; print_r($shortmatches); echo "</pre>\n";
					//if (preg_match("/data_(\d\d)/", $aggregate_tag_data['field'], $shortmatches) && $quizScore['info'][$shortmatches[1]]['short_choices'] != '') {
					//	$chl = $quizScore['info'][$shortmatches[1]]['short_choices'];
					//}
					//unset($shortmatches);

					//echo "<br />final \$chd is " . var_dump($chd);
					
					// 1.4.0 Final CPH 20100418a encode non-ASCII characters
					$chl = rawurlencode($chl);
					//echo "<br />final \$chl is "; var_dump($chl);
					
				} // end else (non-GOM branch)
				
				$cht = $aggregate_tag_data['chart_type'];
				//$cht = 'bvg'; 	// chart type
						// 'p3'		3d pie chart
						// 'p'		2d pie chart
						// 'bhs'	Horizontal bar chart, with stacked bars.
						// 'bvs'	Vertical bar chart, with stacked bars.
						// 'bhg'	Horizontal bar chart, with grouped bars. 
						// 'bvg'	Vertical bar chart, with grouped bars. 
						
				// use chbh=a to automatically size the widths of bars in bar charts, otherwise default 23px width

				//$chs = '300x100'; // chart size; example default '250x100';
				$chs = $aggregate_tag_data['chart_size'];
				if ($aggregate_tag_data['chart_size']) {
					$chart_color = "&amp;chco=" . $aggregate_tag_data['chart_color'];
				}
				else {
					$chart_color = '';
				}
				$chart_axis_labels = ''; // initialize
				if (array_search(JString::strtolower($cht),
				array('bhs', 'bvs', 'bhg', 'bvg')
				) !== false) { // chart is a bar chart
					$label_type = 'chxl';
					$chart_auto_width = '&amp;chbh=a';
					if ($aggregate_tag_data['function'] == 'GOOGLE-CHART-PERCENTAGE') {
						// 1.4.0 RC1 20100729 two indexed axes, swap for vertical
						if (JString::strtolower($cht) == 'bhs' || JString::strtolower($cht) == 'bhg') {
							$chxt = 'x,y';
						}
						else {
							$chxt = 'y,x';
						}
						$chart_axis_labels = '&amp;chxt=' . $chxt . '&amp;chxr=0,0,100'; // for bar chart percentage mode only
					}
				}
				else { // chart is a pie chart or Google-o-meter
					$label_type = 'chl';
					$chart_auto_width = '';
				}
				
				if ($aggregate_tag_data['chart_label'] != '' || $aggregate_tag_data['chart_type'] == 'gom') {
					// override previously assigned labels
					$chl = $aggregate_tag_data['chart_label'];
				}
				else {
					if (!isset($chl)) {
						$chl = '';
					}
				}
				
				if ($aggregate_tag_data['title'] != '') {
					
					//Specify a space with a plus sign (+).
					//Use a pipe character (|) to force a line break.

					$chart_title = '&amp;chtt=' . str_replace(array(' ', '<br>', '<br />', '[:br:]', "\n"), array('+', '|', '|', '|', '|'), $aggregate_tag_data['title']);
					
					if ($aggregate_tag_data['title_attributes'] != '') {
						$chart_title .= '&amp;chts=' . $aggregate_tag_data['title_attributes'];
					}
				}
				else {
					$chart_title = '';
				}

				if ($chd == '') { // if there is no data to display ...
					$chart = '';
					if ($pssdebug) {
						echo "<br />NO DATA FOR CHART; removing the aggregate chart tag from the Score Script";
					}
				}
				else {
					// 1.4.0 RC1 20100729 if the chart is a horizontal bar chart, reverse the order of the labels
					if (JString::strtolower($cht) == 'bhs' || JString::strtolower($cht) == 'bhg') {
						$chl = explode('%7C', $chl); // %7C is the urlencoded pipe character
						$chl = array_reverse($chl);
						$chl = implode('%7C', $chl);
					}
					
					// chart [0-9] subdomain described at http://code.google.com/apis/chart/docs/making_charts.html#enhancements
					//  not actually supported as of 20100908
					//static $chart_subdomain = 0;
					
					// use chxl for axis labels, chl for pie chart labels
					$chart = "<img src=\"http://chart.apis.google.com/chart?chs=$chs&amp;chd=t:$chd&amp;cht=$cht&amp;" . ($label_type == 'chxl' ? 'chxl=1:%7C' : 'chl=') . "$chl$chart_color$chart_auto_width$chart_axis_labels$chart_title&chf=bg,s,FFFFFF00\" />";
					//$chart_subdomain >= 9 ? $chart_subdomain = 0 : $chart_subdomain++;
				}	

				$scorescript = str_replace($match[0], $chart, $scorescript);

				if ($aggregate_mode == 'expression') {
					cleanAuxExpressionGroupTable($session, $aggregate_tag_data['category']);
				}	
				continue; // continue the 'foreach' ($matches as $match)						
				
			}
			
			else if (($aggregate_tag_data['function'] == 'GOOGLE-CHART' || $aggregate_tag_data['function'] == 'GOOGLE-CHART-PERCENTAGE') && strtolower($mbAcceptGoogleChartTOS) != 'yes') {
				$scorescript = str_replace($match[0], '<em>&lt;Google Charts not enabled in configuration&gt;</em>', $scorescript);
				if ($aggregate_mode == 'expression') {
					cleanAuxExpressionGroupTable($session, $aggregate_tag_data['category']);
				}	
				continue; // continue the 'foreach' ($matches as $match)						
			}
			
			else if ($aggregate_tag_data['function'] == 'COUNT-DISTINCT') {
				$aggregate_query = 'SELECT COUNT(DISTINCT(' . $select_this . ')) FROM `' . $aggregate_tag_data['table'] . '` WHERE configid = ' . $aggregate_tag_data['category'] . ' AND ' . $aggregate_tag_data['where'] . $cap . ($aggregate_tag_data['ignore_empty_records'] ? ' AND ' . $aggregate_tag_data['field'] . ' != \'\'' : '');
				if ($pssdebug) {
					echo '<br />Built query: ' . $aggregate_query;
				}
			}
			else if ($aggregate_tag_data['function'] == 'AVG-DISTINCT') {
				$aggregate_query = 'SELECT AVG(DISTINCT(' . $select_this . ')) FROM `' . $aggregate_tag_data['table'] . '` WHERE configid = ' . $aggregate_tag_data['category'] . ' AND ' . $aggregate_tag_data['where'] . $cap . ($aggregate_tag_data['ignore_empty_records'] ? ' AND ' . $aggregate_tag_data['field'] . ' != \'\'' : '');
				if ($pssdebug) {
					echo '<br />Built query: ' . $aggregate_query;
				}
			}


			else if ($aggregate_tag_data['function'] == 'COUNT-VALUE' || $aggregate_tag_data['function'] == 'COUNT-VALUE-RATIO' || $aggregate_tag_data['function'] == 'COUNT-VALUE-PERCENTAGE') {
			
				if ($aggregate_tag_data['value'] == '') {
					//we need a value to be specified; if it is not, continue the loop
					if ($aggregate_mode == 'expression') {
						cleanAuxExpressionGroupTable($session, $aggregate_tag_data['category']);
					}	
					continue; // continue the 'foreach' ($matches as $match)						
				}
				
				$aggregate_query = 'SELECT count(*)' .
				' FROM ' . $aggregate_tag_data['table'] .
				' WHERE configid = ' . $aggregate_tag_data['category'] .
				' AND ' . $aggregate_tag_data['where'] .
				' AND ' . $aggregate_tag_data['field'] . ' = "' . $aggregate_tag_data['value'] . '"' .
				$cap .
				($aggregate_tag_data['ignore_empty_records'] ? ' AND ' . $aggregate_tag_data['field'] . ' != \'\'' : '');

				if ($aggregate_tag_data['debug'] || $pssdebug) {
					echo '<br />Built ' . $aggregate_tag_data['function'] . ' query: ' . $aggregate_query;
				}

				$database = &JFactory::getDBO(); 
				$database->setQuery($aggregate_query);
				$result = $database->loadResult();

				if ($aggregate_tag_data['function'] == 'COUNT-VALUE-RATIO' || $aggregate_tag_data['function'] == 'COUNT-VALUE-PERCENTAGE') {
					$aggregate_query = 'SELECT count(*)' .
					' FROM ' . $aggregate_tag_data['table'] .
					' WHERE configid = ' . $aggregate_tag_data['category'] .
					' AND ' . $aggregate_tag_data['where'] .
					$cap .
					($aggregate_tag_data['ignore_empty_records'] ? ' AND ' . $aggregate_tag_data['field'] . ' != \'\'' : '');

					if ($aggregate_tag_data['debug'] || $pssdebug) {
						echo '<br />Built ' . $aggregate_tag_data['function'] . ' query: ' . $aggregate_query;
					}

					$database = &JFactory::getDBO(); 
					$database->setQuery($aggregate_query);
					$total_result = $database->loadResult();
				}	

				if ($aggregate_tag_data['function'] == 'COUNT-VALUE-RATIO') {
					if ($total_result == 0) {
						$result = 0;
					}
					else {
						$result = $result/$total_result;
					}
				}
				else if ($aggregate_tag_data['function'] == 'COUNT-VALUE-PERCENTAGE') {
					if ($total_result == 0) {
						$result = 0;
					}
					else {
						$result = round(($result/$total_result) * 100);
					}
				}
				
				$scorescript = str_replace($match[0], $result, $scorescript);
				if ($aggregate_mode == 'expression') {
					cleanAuxExpressionGroupTable($session, $aggregate_tag_data['category']);
				}	
				continue; // continue the 'foreach' ($matches as $match)						
			}

			// use the following conditional for 'AVG', 'COUNT', 'MAX', 'MIN', 'SUM', 'STD'
			else { // build the query from the constituent parts
				$aggregate_query = 'SELECT ' . $aggregate_tag_data['function'] . '(' . $select_this . ') FROM `' . $aggregate_tag_data['table'] . '` WHERE configid = ' . $aggregate_tag_data['category'] . ' AND ' . $aggregate_tag_data['where'] . $cap . ($aggregate_tag_data['ignore_empty_records'] ? ' AND ' . $aggregate_tag_data['field'] . ' != \'\'' : '');
				if ($aggregate_tag_data['debug'] || $pssdebug) {
					echo '<br />Built query: ' . $aggregate_query;
				}
			}

			// If it's not null, process aggregate data query:
			if (!is_null($aggregate_query)) {
				$database = &JFactory::getDBO(); 
				$database->setQuery($aggregate_query);
				$aggregate_result = $database->loadResult();
				
				//echo "aggregate_query was not null; aggregate_result is $aggregate_result";
				//$aggregate_result = $database->loadObjectList();

				// Calculate MEDIAN from concatenated results
				if ($aggregate_tag_data['function'] == 'MEDIAN' || $aggregate_tag_data['function'] == 'MEDIAN-DISTINCT') {
					// we should have a comma delimited list of values
					$median_array = explode(',', $aggregate_result);
					sort($median_array);
					$median_values = count($median_array);
					
					if ($pssdebug) {
						echo "<pre>median array after sort:\n"; print_r($median_array); echo "</pre>\n\$median_array % 2 is " . $median_array % 2 . "<br />\n";
					}	
					
					if (count($median_array) % 2 == 1) { // odd number of values
						if ($pssdebug) {
							echo "<br />ODD number of values";
							echo "<br />using round(\$median_values/2)-1 = round($median_values/2)-1: " . (round($median_values/2)-1);
						}	
						$aggregate_result = $median_array[round($median_values/2)-1];
					}
					else { // even number of values; average the two middle results
						if ($pssdebug) {
							echo "<br />EVEN number of values";
							echo "<br />using (\$median_array[\$median_values/2-1] + \$median_array[\$median_values/2]) / 2<br />
							(\$median_array[$median_values/2-1] + \$median_array[$median_values/2]) / 2<br />
							(\$median_array[" . ($median_values/2-1) . "] + \$median_array[" . ($median_values/2) . "]) / 2<br />
							 " . ($median_array[$median_values/2-1] + $median_array[$median_values/2]) / 2;
						}	 
						$aggregate_result = ($median_array[$median_values/2-1] + $median_array[$median_values/2]) / 2;
					}
				}

				if ($pssdebug) {
					if ($database->stderr()) {
						echo '<br />Query return status: ' . $database->stderr();
					}
					else {
						echo '<br />Query successful';
					}
					echo '<br />Replacing aggregate tag with query result ' . $aggregate_result;
				}
				// replace the tag from the Score Script with the query output
				$scorescript = str_replace($match[0], $aggregate_result, $scorescript);
			}	
			// If it IS null, remove the tag from the Score Script:
			else {
				if ($pssdebug) {
					echo '<br />Replacing aggragate tag with empty string';
				}
				$scorescript = str_replace($match[0], '', $scorescript);
			}
			
			if ($pssdebug) {
				$pssAggregateIndex++;
			}
			
			/*** BEGIN EXPRESSION GROUP TEMPORARY TABLE CLEANUP SECTION ***/
			// 20100511 if this is an expression_group tag, create a temporary table with the corresponding data now
			if ($aggregate_mode == 'expression') {
			
				cleanAuxExpressionGroupTable($session, $aggregate_tag_data['category']);

			}
			/*** END EXPRESSION GROUP TEMPORARY TABLE CLEANUP SECTION ***/
		
			//echo '<p style="color: red;">Exiting aggregate tag found foreach for ' . $match[0] . '</p><hr />';
		
		}
		if ($pssdebug) {
			echo "<br />End aggregate foreach<br />\n";
		}
	}	
	
	// END AGGREGATE SECTION

	// Next, replace date tags
	if (strpos($scorescript, "[:date:") !== false) {  // yes, a 'date' tag (probably) exists in the string
		if ($pssdebug) {
			echo " we appear to have found at least one date tag; ";
		}	
		unset($matches);
		// [:date:<date_format>:date_adjustment:]
		preg_match_all("/\[:date:(?:<(.*?)>(?::((?:[^:])*?))?)??(?::)?\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if ($pssdebug) {
			echo " we found " . count($matches) . " actual date tags; ";
		}

		//echo "<pre>\n";
		//print_r($matches);
		//echo "</pre>";

		foreach ($matches as $match) {

			if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php')) {
			/**
			 * Include the component configuration file
			 */
				include JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php';
			}

			if ((isset($match[2]) && empty($match[2]) && $match[2] != '0') || !isset($match[2])) { // Testing for zero as a string
				$timeadjustment =  $mbDefaultSSDateAdjustment ? $mbDefaultSSDateAdjustment : 0;
			}
			else if ($match[2] == '0') {
				$timeadjustment = 0;
			}
			else {
				$timeadjustment = $match[2];
			}
			$adjustedstamp = time(); // initialize timestamp
			if (!empty($timeadjustment)) {
				$adjustedstamp = strtotime($timeadjustment, $adjustedstamp);
			}
			$datetime_format = (isset($match[1]) && $match[1]) ? $match[1] : ($mbDefaultSSDateFormat ? $mbDefaultSSDateFormat : "");
			if ($datetime_format == '') {
				if (defined('_DATE_FORMAT_LC2')) {
					$datetime_format = _DATE_FORMAT_LC2;
				}
				else {
					$datetime_format = "%d %b %Y %I:%M&nbsp;%p";
				}
			}	
			$scorescript = str_replace($match[0], strftime($datetime_format, $adjustedstamp), $scorescript);
		}
	}

	/* BEGIN COUNT CHARACTER SECTION */
	if (strpos($scorescript, "<countcharacter") !== false) {  // a 'countcharacter' tag probably exists in the string

		if ($pssdebug) {
			echo " we appear to have found at least one countcharacter definition; ";
		}	

		unset($matches);
		preg_match_all("/\<countcharacter:(.+?)\>(.*?)\<\/countcharacter\>/s", $scorescript, $matches, PREG_SET_ORDER);
		
		if ($pssdebug) {
			echo " we found " . count($matches) . " actual countcharacter definitions; ";
		}

		foreach ($matches as $match) {
			//echo "<pre>countcharacter definition:\n";
			//echo htmlspecialchars(print_r($match,1));
			//echo "</pre>\n";

			// THE SEARCH IS CASE SENSITIVE

			// the character(s) to count the number of occurrences of is $match[1]
			// the 'haystack' is $match[2]
			
			$scorescript = str_replace($match[0], substr_count(parseScoreScript($quizScore, $match[2]), $match[1]), $scorescript);
		}
	}
	/* END COUNT CHARACTER SECTION */
	
	/* ASSIGN ALPHA USER POINTS */
	// CPH 20091022 1.3.0 Beta 1
	// Assign points to a user using the Alpha User Points extension for Joomla!
	//preg_match_all("/\[:alphauserpoints{(.*?)}:\]/", $scorescript, $matches, PREG_SET_ORDER);
	
	if (strpos($scorescript, "[:alphauserpoints:") !== false) {  // yes, an 'alphauserpoints' tag (probably) exists in the string
	
		unset($matches); // is this necessary?
		preg_match_all("/\[:alphauserpoints((?::(?:function|reference_key|note|points)\{[^\}]*?\})*):\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if (!empty($matches)) {
			if (class_exists('JConfig') && file_exists(JPATH_SITE.DS.'components'.DS.'com_alphauserpoints'.DS.'helper.php')) {
				if ($pssdebug) {
					echo '<br />Alpha user points helper.php file DOES EXIST';
				}
				require_once (JPATH_SITE.DS.'components'.DS.'com_alphauserpoints'.DS.'helper.php');
			}
			else {
				if ($pssdebug) {
					echo '<br />Not running Joomla! 1.5 OR Alpha user points helper.php file does NOT exist';
				}
			}

			if ($pssdebug) {
				echo " we found " . count($matches) . " actual alphauserpoints tags; ";
				echo "<br />Begin alphauserpoints tags foreach<br />\n";
				$pssAlphaUserPointsIndex = 1;
			}

			foreach ($matches as $match) {
				
				unset($alphauserpoints_tag_data); // Reset the variable that will hold the components of the alphauserpoints function call this loop
				
				if ($pssdebug) {
					echo "<hr />Alpha User Points tag number $pssAlphaUserPointsIndex:<br />\n";
				}	
				//echo "<pre>";
				//print_r($match);
				//echo "</pre>";
				
				// $match[1] starts with a colon and contains (curly brace colon)-delimited alphauserpoints elements
				$alphauserpoints_elements = preg_split("/(?<=}):/s", ltrim($match[1], ":"));

				if ($pssdebug) {
					echo "<br />Alpha User Points elements:<pre>";
					print_r($alphauserpoints_elements);
					echo "</pre>\n";
				}		

				$alphauserpoints_tag_data = array();

				foreach ($alphauserpoints_elements as $alphauserpoints_element) {

					// function (not an array)
					if (strpos($alphauserpoints_element, "function{") !== false) {
						// ungreedy quantifier (.*?) over multiple lines (s)
						preg_match("/function{(.*?)}/s", $alphauserpoints_element, $alphauserpoints_element_match);
						if (isset($alphauserpoints_element_match[1]) && $alphauserpoints_element_match[1] != "") {
							// if function is already filled, don't fill it again
							$alphauserpoints_tag_data['function'] = empty($alphauserpoints_tag_data['function']) ? parseScoreScript($quizScore, $alphauserpoints_element_match[1]) : $alphauserpoints_tag_data['function'];
							continue;
						}	
					}
				
					// points (not an array)
					if (strpos($alphauserpoints_element, "points{") !== false) {
						// ungreedy quantifier (.*?) over multiple lines (s)
						preg_match("/points{(.*?)}/s", $alphauserpoints_element, $alphauserpoints_element_match);
						if (isset($alphauserpoints_element_match[1]) && $alphauserpoints_element_match[1] != "") {
							// if points is already filled, don't fill it again
							$alphauserpoints_tag_data['points'] = empty($alphauserpoints_tag_data['points']) ? parseScoreScript($quizScore, $alphauserpoints_element_match[1]) : $alphauserpoints_tag_data['points'];
							continue;
						}	
					}

					// note (not an array)
					if (strpos($alphauserpoints_element, "note{") !== false) {
						// ungreedy quantifier (.*?) over multiple lines (s)
						preg_match("/note{(.*?)}/s", $alphauserpoints_element, $alphauserpoints_element_match);
						if (isset($alphauserpoints_element_match[1])){ // allow this one to be an empty string && $alphauserpoints_element_match[1] != "") {
							// if note is already filled, don't fill it again
							$alphauserpoints_tag_data['note'] = empty($alphauserpoints_tag_data['note']) ? parseScoreScript($quizScore, $alphauserpoints_element_match[1]) : $alphauserpoints_tag_data['note'];
							continue;
						}	
					}

					// reference_key (not an array)
					if (strpos($alphauserpoints_element, "reference_key{") !== false) {
						// ungreedy quantifier (.*?) over multiple lines (s)
						preg_match("/reference_key{(.*?)}/s", $alphauserpoints_element, $alphauserpoints_element_match);
						if (isset($alphauserpoints_element_match[1]) && $alphauserpoints_element_match[1] != "") {
							// if reference_key is already filled, don't fill it again
							$alphauserpoints_tag_data['reference_key'] = empty($alphauserpoints_tag_data['reference_key']) ? parseScoreScript($quizScore, $alphauserpoints_element_match[1]) : $alphauserpoints_tag_data['reference_key'];
							continue;
						}	
					}
				}	
				if ($pssdebug) {
					echo "<br />Alpha User Points tag data array before defaults get filled in:<pre>";
					print_r($alphauserpoints_tag_data);
					echo "</pre>\n";
				}	


				if (file_exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php')) {
				/**
				 * Include the component configuration file
				 */
					include JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php';
				}

				if (!isset($alphauserpoints_tag_data['function'])) {
					if (isset($mbDefaultSSAlphaUserPointsFunction)) {
						$alphauserpoints_tag_data['function'] = parseScoreScript($quizScore, $mbDefaultSSAlphaUserPointsFunction);
					}	
					else {
						$alphauserpoints_tag_data['function'] = 'plgaup_quizpoints_madblanks';
					}
				}
				if (!isset($alphauserpoints_tag_data['points'])) {
					if (isset($mbDefaultSSAlphaUserPointsPoints)) {
						$alphauserpoints_tag_data['points'] = parseScoreScript($quizScore, $mbDefaultSSAlphaUserPointsPoints);
					}	
				}
				// validate this to be numeric; if it's not, assign 0 points
				if (!is_numeric($alphauserpoints_tag_data['points'])) {
					$alphauserpoints_tag_data['points'] = 0;
				}	

				if (!isset($alphauserpoints_tag_data['note'])) {
					if (isset($mbDefaultSSAlphaUserPointsNote)) {
						$alphauserpoints_tag_data['note'] = parseScoreScript($quizScore, $mbDefaultSSAlphaUserPointsNote);
					}	
					else {
						$alphauserpoints_tag_data['note'] = 'Mad Blanks ' . ucwords(_MBL_CATEGORY_NAME) . ' #' . $quizScore['category_id'] . ' ' . ucwords(_MBL_SCORESCRIPT_NAME) . ' #' . $quizScore['scorescript_id'];
					}
				}

				if (!isset($alphauserpoints_tag_data['reference_key'])) {
					if (isset($mbDefaultSSAlphaUserPointsReferenceKey)) {
						$alphauserpoints_tag_data['reference_key'] = parseScoreScript($quizScore, $mbDefaultSSAlphaUserPointsReferenceKey);
					}	
					else {
						// no default reference key (user can get points for this as many times as s/he loads the Score Script)
						$alphauserpoints_tag_data['reference_key'] = '';
					}
				}

				if ($pssdebug) {
					echo "<br />alphauserpoints tag data array, with defaults from the config file filled in and points validated as numeric (0 if not):<pre>";
					print_r($alphauserpoints_tag_data);
					echo "</pre>";
					echo '<br />Attempting to award ' . $alphauserpoints_tag_data['points'] . ' Alpha User points to the current user.';
				}

				// despite the documentation not mentioning this, apparently we have to provide 
				//  the 'referrerid' a.k.a. 'referreid' as the 2nd parameter to the newpoints() function
				$database = &JFactory::getDBO();
				//$my = &JFactory::getUser();

				$database->setQuery('SELECT referreid FROM #__alpha_userpoints WHERE userid = ' . $my->id);
				$referrerid = $database->loadResult();
				if ($pssdebug) {
					echo '<br />Retrieved Alpha User Points referreid ' . $referrerid . ' for userid ' . $my->id;
					echo '<br />Calling AlphaUserPointsHelper::newpoints(' . $alphauserpoints_tag_data['function'] . ', ' . $referrerid . ', ' . $alphauserpoints_tag_data['reference_key'] . ', ' . $alphauserpoints_tag_data['note'] . ', ' . $alphauserpoints_tag_data['points'] . ');';
				}
				$aup_result = AlphaUserPointsHelper::newpoints($alphauserpoints_tag_data['function'], $referrerid, $alphauserpoints_tag_data['reference_key'], $alphauserpoints_tag_data['note'], $alphauserpoints_tag_data['points']);
				if ($pssdebug) {
					// Looking at the code, the return value does not tell us anything useful
					echo '<br />Alpha User Points function returned: ';
					var_dump($aup_result);
				}
			
				// remove the tag from the Score Script
				$scorescript = str_replace($match[0], '', $scorescript);
				
				if ($pssdebug) {
					$pssAlphaUserPointsIndex++;
				}	
			} // end foreach $matches as $match
		} // end if (!empty($matches))
	} // end if strpos [:alphauserpoints:
	/* END ASSIGN ALPHA USER POINTS */

	if (strpos($scorescript, "[:popupwindow:") !== false) {  // yes, a 'popupwindow' tag (probably) exists in the string
		if ($pssdebug) {
			echo " we appear to have found at least one popupwindow tag; ";
		}	
		unset($matches);

		preg_match_all("/\[:popupwindow:{(.+?)}(:{(.+?)})*:\]/s", $scorescript, $matches, PREG_SET_ORDER);

		if ($pssdebug) {
			echo " we found " . count($matches) . " actual popupwindow tags; ";
		}

		//echo "<pre>\n";
		//print_r($matches);
		//echo "</pre>";

		foreach ($matches as $matchkey => $match) {

	        	$scorescript = str_replace($match[0], "
	        	
	        	<script language=\"JavaScript\">
				mbwin" . $matchkey . " = window.open('javascript:\"" . parseScoreScript($quizScore, addslashes($match[1])) . "\"', \"mbpopup" . $matchkey . "\", \"" . (isset($match[3]) ? $match[3] : '') . "\");
				mbwin" . $matchkey . ".focus();
	        	</script>
	        	
	        	", $scorescript);
	        }	

	}

	// 1.4.0 Beta 2 CPH 20100225
	// delete the just-submitted record
	if (strpos($scorescript, '[:delete_record:]') !== false) {
		if ($quizScore['record_id']) {
			$database =& JFactory::getDBO();
			if ($my->id == 0 ? 1 : 0) { // guest
				$database->setQuery('DELETE FROM #__madblanks_records WHERE configid = ' . $quizScore['category_id'] . ' AND id = ' . $quizScore['record_id'] . ' AND session = ' . getMadBlanksSession() . ' LIMIT 1');
			}
			else { // registered
				$database->setQuery('DELETE FROM #__madblanks_records WHERE configid = ' . $quizScore['category_id'] . ' AND id = ' . $quizScore['record_id'] . ' AND entered_by = ' . $my->id . ' LIMIT 1');
			}
			//$hekquery = $database->getQuery();
			//echo "<pre>"; print_r($hekquery); echo "</pre>\n";exit;
			$database->query();
		}
		$scorescript = str_replace('[:delete_record:]', '', $scorescript);
	}

        // At this point all irrelevant portions of the Score Script have been removed,
        //  so do a redirect if it is still here
	if (strpos($scorescript, '[:redirect') !== false) {  // yes, a redirect tag (probably) exists in the string
		if (preg_match("/\[:redirect:<(.+)>:\]/", $scorescript, $match)) {
			$app = &JFactory::getApplication();$app->redirect($match[1]);
		}
	}	
        
	//echo "<pre>\nA\n";
	//print_r($scorescript);
	//echo "\nendA\n</pre>";

        // At this point all irrelevant portions of the Score Script have been removed, 
        //  so store nextconfig variable (which category for CSR to display next) if it is still here
        // 1.2.0 CPH 20090811 add capability to pre-fill data variables in the next category: <data_XX=Y>
	//if (preg_match("/\[:nextcategory:(\d+):\]/", $scorescript, $match)) {
	if (preg_match("/\[:nextcategory:(\d+)(:<(.+)>)??:\]/", $scorescript, $match)) {
		//echo "<div style=\"border: 1px solid red;\">$scorescript</div>\n";
		//echo "<pre>"; print_r($match); echo "</pre>\n";
		if (isset($match[1]) && is_numeric($match[1])) {
			$quizScore['nextconfigid'] = $match[1];
		}
		if (isset($match[3])) {
			$quizScore['nextconfiguri'] = $match[3];
		}
		$scorescript = str_replace($match[0], '', $scorescript);
	}

	//echo "<pre>\nA\n";
	//print_r($scorescript);
	//echo "\nendA\n</pre>";
	// replaceSpecialCharacters arguments are: $beforeorafterstring, $thefield=0, $datarow=null, $apply_master_css=0, $theCSS=null, $configrow=null, &$randomtagresultssofar, $checkboxsep1='', $checkboxsep2='', $ba_replace_lookup=1, $ba_replace_random=1, $ba_replace_punctuation=1, $ba_a_an_lower="", $ba_a_an_upper="", $processmultisep=1
	// 3rd input to replaceSpecialCharacters is $datarow, which is needed for 'this' functionality of lookup tags
	// 6th input is configrow, which is also needed for 'this' functionality of lookup tags
	// 15th input is $processmultisep; setting to zero overrides [:multisep:] processing for the sake of preserving user_response_raw
	//  note that as of 1.1.0b3, [:multisep:] tags will still be processed even with this flag at zero when calling parseLookupTags() from replaceSpecialCharacters()

	$blankarray = array();
	$scorescript = replaceSpecialCharacters($scorescript, 0, $quizScore['datarow'], 0, null, $quizScore['configrow'], $blankarray, '', '', 1, 1, 1, '', '', 0);

	//echo "<pre>\nB\n";
	//print_r($scorescript);
	//echo "\nendB\n</pre>";
	
	//echo "<h1>Scorescript:</h1><h3 align=\"center\" style=\"max-width: 4in;\">" . $scorescript . "</h1>\n";


	// The very last thing to do is to replace the rawscorescript tag
	if (strpos($scorescript, '[:rawscorescript:]') !== false) {

		$scorescript = str_replace('[:rawscorescript:]', htmlspecialchars($quizScore['rawscorescript']), $scorescript);

		// Replace "raw" comment tags to eliminate areas to display from 
		//  the raw Score Script for use with the [:rawscorescript:] tag

		if (strpos($quizScore['rawscorescript'], '[:rawcomment:<') !== false) {  // a 'rawcomment' tag probably exists in the string

			if ($pssdebug) {
				echo " we appear to have found at least one &quot;raw&quot; comment tag; ";
			}	

			// ungreedy quantifier to capture comments (.*?) over multiple lines (s)
			preg_match_all("/\[:rawcomment:<start>:\](.*?)\[:rawcomment:<end>:\]/s", $quizScore['rawscorescript'], $matches, PREG_SET_ORDER);

			if ($pssdebug) {
				echo ' we found ' . count($matches) . ' actual sets of &quot;raw&quot; comment tags; ';
			}

			foreach ($matches as $match_key => $match) {

				if ($pssdebug) {
					echo ' removing <span style="color: red;">'
					. htmlspecialchars($match[0]) . "</span> from \$scorescript (set $match_key); ";
				}

				$scorescript = str_replace(htmlspecialchars($match[0]), '', $scorescript);
			}
		}
	}

	if ($pssdebug) {
		$pssIterationAtEnd++;
		if (($pssIterationAtBeginning - $pssIterationAtEnd + 1) > $pssMaxRecursionLevel) {
			$pssMaxRecursionLevel = $pssIterationAtBeginning - $pssIterationAtEnd + 1;
		}
		//echo "<br />returning from parseScoreScript() (entered parseScoreScript() $pssIterationAtBeginning times, returned parseScoreScript() $pssIterationAtEnd times, end recursion level " . ($pssIterationAtBeginning - $pssIterationAtEnd + 1) . ", max recursion level up to this point: " . $pssMaxRecursionLevel . ") \$scorescript output is \n<div style=\"border: 1px solid purple; color: purple;\">\n" 
		//. htmlspecialchars($scorescript) . "\n</div>\n";
		pssDebugMessage('pssreturn_called1returned2recursionlevel3maxrecursionlevel4', $pssIterationAtBeginning, $pssIterationAtEnd, $pssIterationAtBeginning - $pssIterationAtEnd + 1, $pssMaxRecursionLevel);
		pssDebugMessage('scorescriptoutput1', $scorescript);
		
		if (($pssIterationAtBeginning - $pssIterationAtEnd + 1) == 1) {
			echo "<div style=\"font-size: larger; text-align: center; font-weight: bold; border: 1px dashed red; margin: 1em 0 0 0;\">END parseScoreScript() DEBUG OUTPUT</div>
			</div>\n"; // end debug background color div
		}
	}
			
	return $scorescript;

}

/**
 * Parse data about a particular answer for a category field
 *
 * @param array $answer_array array containing data about the category field settings
 * @param string $input text from a Score Script requiring interpretation dependent on correct answer settings for the category field
 * @return string
 */
function parseAnswerIteration ($answer_array, $input) {

	//echo "<pre>\$answer_array\n";
	//print_r($answer_array);
	//echo "</pre>";

	//echo "<p>The parseAnswerIteration input is A<font color=\"green\">" . $input . "</font>Z.</p>\n";

	$parsed_answer_iteration = str_replace("[:name:]",$answer_array['name'],$input);
	$parsed_answer_iteration = str_replace("[:partofspeech:]",$answer_array['partofspeech'],$parsed_answer_iteration);
	$parsed_answer_iteration = str_replace("[:cluecuehint:]",$answer_array['partofspeech'],$parsed_answer_iteration); // 1.1.0rc3
	$parsed_answer_iteration = str_replace("[:beforetext:]",$answer_array['beforetext'],$parsed_answer_iteration);
	$parsed_answer_iteration = str_replace("[:aftertext:]",$answer_array['aftertext'],$parsed_answer_iteration);
	$parsed_answer_iteration = str_replace("[:field_number:]",$answer_array['field_number'],$parsed_answer_iteration);
	$parsed_answer_iteration = str_replace("[:field_number_padded:]",$answer_array['field_number_padded'],$parsed_answer_iteration);
	$parsed_answer_iteration = str_replace("[:user_response:]",$answer_array['user_response'],$parsed_answer_iteration);
	$parsed_answer_iteration = str_replace("[:user_response_raw:]",$answer_array['user_response_raw'],$parsed_answer_iteration);
	$parsed_answer_iteration = str_replace("[:correct_value:]",$answer_array['correct_value'],$parsed_answer_iteration);
	$parsed_answer_iteration = str_replace("[:correct_value_raw:]",$answer_array['correct_value_raw'],$parsed_answer_iteration);
	$parsed_answer_iteration = str_replace("[:correct_case_sensitive:]",$answer_array['correct_case_sensitive'],$parsed_answer_iteration);
	$parsed_answer_iteration = str_replace("[:is_correct:]",$answer_array['is_correct'],$parsed_answer_iteration);
	$parsed_answer_iteration = str_replace("[:points_possible_a:]",$answer_array['points_possible_a'],$parsed_answer_iteration);
	$parsed_answer_iteration = str_replace("[:points_earned_a:]",$answer_array['points_earned_a'],$parsed_answer_iteration);
	$parsed_answer_iteration = str_replace("[:points_earned_b:]",$answer_array['points_earned_b'],$parsed_answer_iteration);
	$parsed_answer_iteration = str_replace("[:points_b:]",$answer_array['points_b'],$parsed_answer_iteration);
	$parsed_answer_iteration = str_replace("[:points_all_correct_b:]",$answer_array['points_all_correct_b'],$parsed_answer_iteration);
	
	$parsed_answer_iteration = str_replace('[:in_subset:]',$answer_array['in_subset'],$parsed_answer_iteration); // added in 1.4.0 Beta 4 20100328
	
	$parsed_answer_iteration = str_replace("[:selected_index:]",$answer_array['selected_index'],$parsed_answer_iteration); // added in 1.4.2 20110227
	$parsed_answer_iteration = str_replace("[:selected_index_padded:]",$answer_array['selected_index_padded'],$parsed_answer_iteration); // added in 1.4.2 20110227
	$parsed_answer_iteration = str_replace("[:selected_index_alpha:]",$answer_array['selected_index_alpha'],$parsed_answer_iteration); // added in 1.4.2 20110227
	$parsed_answer_iteration = str_replace("[:selected_count:]",$answer_array['selected_count'],$parsed_answer_iteration); // added in 1.4.2 20110227

	// The total earned type B points divided by total type B points the user would earn if the answer were completely correct
	// CPH 20090520 1.1.0final add abs to allow use of negative points
	$parsed_answer_iteration = str_replace("[:points_correct_ratio_b:]", abs($answer_array['points_all_correct_b']) > 0 ? $answer_array['points_earned_b'] / $answer_array['points_all_correct_b'] : 0, $parsed_answer_iteration);
	
	// The total earned type B points divided by total type B points the user would earn if the answer were completely correct, expressed as a rounded whole number percentage
	// CPH 20090520 1.1.0final add abs to allow use of negative points
	$parsed_answer_iteration = str_replace("[:points_correct_percentage_b:]", abs($answer_array['points_all_correct_b']) > 0 ? round($answer_array['points_earned_b'] / $answer_array['points_all_correct_b'] * 100) : 0, $parsed_answer_iteration);
	
	// 1.4.2 CPH 20110228 added each:answer possible_choice, possible_choice_selected, possible_choice_correct
	// The e modifier makes preg_replace()  treat the replacement parameter as PHP code after the appropriate references substitution is done.
	preg_replace('/\[:possible_choice:(\d+):\]/e', '$parsed_answer_iteration = isset($answer_array["possible_choice"]["$1"]) ? str_replace("$0", $answer_array["possible_choice"][$1], $parsed_answer_iteration) : str_replace("$0", "", $parsed_answer_iteration);', $parsed_answer_iteration);
	preg_replace('/\[:possible_choice_selected:(\d+):\]/e', '$parsed_answer_iteration = isset($answer_array["possible_choice_selected"]["$1"]) ? str_replace("$0", $answer_array["possible_choice_selected"][$1], $parsed_answer_iteration) : str_replace("$0", "", $parsed_answer_iteration);', $parsed_answer_iteration);
	preg_replace('/\[:possible_choice_correct:(\d+):\]/e', '$parsed_answer_iteration = isset($answer_array["possible_choice_correct"]["$1"]) ? str_replace("$0", $answer_array["possible_choice_correct"][$1], $parsed_answer_iteration) : str_replace("$0", "", $parsed_answer_iteration);', $parsed_answer_iteration);
		
	//echo "<p>The parseAnswerIteration OUTPUT is A<font color=\"blue\">" . $parsed_answer_iteration . "</font>Z.</p>\n";
	
	return $parsed_answer_iteration;
}

/**
 * Change a semicolon-delimited list into a human readable list of quiz responses
 *
 * for example if $data_field is "alpha;beta;gamma", $checkboxsep1 is ",[:space:]" and $checkboxsep2 is "[:space:]and[:space:]"
 * then the output is "alpha, beta, and gamma"
 *
 * @param mixed $data_field this is one of the data_xx fields from a Mad Blanks record that presumably has more than one quiz response as a result of multiple checkboxes having been selected; it is an array or a semicolon-delimited list
 * @param string $checkboxsep1 separator in between checkbox responses except the last two
 * @param string $checkboxsep2 separator in between the last two checkbox responses
 * @param string $checkboxsepa separator before first checkbox response when more than one response is selected
 * @param string $checkboxsepz separator after last checkbox response when more than one response is selected
 * @param string $checkboxsepb separator before first checkbox response when only one response is selected
 * @param string $checkboxsepy separator after last checkbox response when only one response is selected
 * @param string $separator separator in between answers in the $data_field
 * @return string human readable list of quiz responses
 */
function dataFieldToQuizFormat($data_field, $checkboxsep1, $checkboxsep2, $checkboxsepa, $checkboxsepz, $checkboxsepb, $checkboxsepy, $separator='[:multisep:]') {

	if (!is_array($data_field)) {
		$data_field = explode($separator, $data_field);
	}
	
	$numberofselections = count($data_field);

	$randomtagarray = array();

	if ($numberofselections > 1) {
		$theoutput = replaceSpecialCharacters(convertMBEscapedToLiteral($checkboxsepa), 0, null, 0, null, null, $randomtagarray);
	}
	else {
		$theoutput = replaceSpecialCharacters(convertMBEscapedToLiteral($checkboxsepb), 0, null, 0, null, null, $randomtagarray);
	}

	for ($j=0; $j < $numberofselections; $j++) {
		$theoutput .= $data_field[$j];
		if ($j == $numberofselections - 2) {
			$theoutput .= replaceSpecialCharacters(convertMBEscapedToLiteral($checkboxsep2), 0, null, 0, null, null, $randomtagarray);
		}
		else if ($j < $numberofselections - 1) {
			$theoutput .= replaceSpecialCharacters(convertMBEscapedToLiteral($checkboxsep1), 0, null, 0, null, null, $randomtagarray);
		}
	}
	
	if ($numberofselections > 1) {
		$theoutput .= replaceSpecialCharacters(convertMBEscapedToLiteral($checkboxsepz), 0, null, 0, null, null, $randomtagarray);
	}
	else {
		$theoutput .= replaceSpecialCharacters(convertMBEscapedToLiteral($checkboxsepy), 0, null, 0, null, null, $randomtagarray);
	}

	return $theoutput;
}

/**
 * Format a string that will be replaced (when debugging Score Scripts)
 *
 * Translate any characters that are special in HTML to their entity equivalents and format color, border and/or 
 * other css properties with a div or span tag
 *
 * @param string $thestring the string that is being replaced
 * @return string the string that is being replaced in pretty format
 */
function pssDebugReplaceThisString($thestring) {
	return "<span style=\"color: orange; background-color: black; border: 2px solid black;\">" . htmlspecialchars($thestring) . "</span>";
}

/**
 * Format a string that is a replacement for something else (when debugging Score Scripts)
 *
 * Translate any characters that are special in HTML to their entity equivalents and format color, border and/or 
 * other css properties with a div or span tag
 *
 * @param string $thestring the string that is the replacement
 * @return string the string that is the replacement in pretty format
 */
function pssDebugReplacedString($thestring) {
	return "<span style=\"color: #00ff00; background-color: black; border: 2px solid black;\">" . htmlspecialchars($thestring) . "</span>";
}

/**
 * Format a string that explains an error (when debugging Score Scripts)
 *
 * Format color, border and/or 
 * other css properties with a div or span tag
 *
 * @param string $thestring the string that is the error message
 * @return string the string that is the error message in pretty format
 */
function pssDebugErrorString($thestring) {
	return "<span style=\"font-size: larger; font-weight: bold; color: red; background-color: white; border: 2px solid yellow;\">" . $thestring . "</span>"; // seattle salmon
}

/**
 * Start an individual Score Script debug string
 *
 * @return string the string to start the debug message
 */
function pssDebugStart() {
	return "<div style=\"border: 1px solid black; background-color: #fffafa; margin-top: 5px; line-height: 2; padding: 0 5px;\">\n";
}

/**
 * Start an individual Score Script debug string
 *
 * @return string the string to end the debug message
 */
function pssDebugEnd() {
	return "</div>\n\n";
}

/**
 * Display or log an individual Score Script debug string
 *
 * @param string $theclass what type of debug message is this
 * @param array $message_pieces piece of the debug message
 * @return string the completed error message string (if applicable)
 */
function pssDebugMessage($theclass, $piece1='', $piece2='', $piece3='', $piece4='', $piece5='', $piece6='', $piece7='', $piece8='') {
	
	$theoutput = pssDebugStart();
	
	// sprintf strings are stored in $theclasses
	// FOR USE WITH SPRINTF, USE %% IN PLACE OF %
	$formats = array(
	
	'scorescriptoutput1' => 'Score Script output is:' . pssDebugStyleString('%1$s', 'scorescriptoutput'),
	'scorescriptinput1' => 'Score Script input is:' . pssDebugStyleString('%1$s', 'scorescriptinput'),
	'psscall_called1returned2recursionlevel3' => '<span style="color: purple; font-size: larger;"><b>Calling</b> parseScoreScript(); entered parseScoreScript() ' . pssDebugStyleString('%1$s', 'highlight') . ' times, returned parseScoreScript() ' . pssDebugStyleString('%2$s', 'highlight') . ' times, begin recursion level ' . pssDebugStyleString('%3$s', 'highlight') . '.</span>',
	'pssreturn_called1returned2recursionlevel3maxrecursionlevel4' => '<span style="color: purple; font-size: larger;"><b>Returning from</b> parseScoreScript(); entered parseScoreScript() ' . pssDebugStyleString('%1$s', 'highlight') . ' times, returned parseScoreScript() ' . pssDebugStyleString('%2$s', 'highlight') . ' times, end recursion level ' . pssDebugStyleString('%3$s', 'highlight') . ', max recursion level up to this point ' . pssDebugStyleString('%4$s', 'highlight') . '.</span>',
	'removing12withindex3' => 'Removing ' . pssDebugStyleString('%1$s', 'highlight') . ' ' . pssDebugStyleString('%2$s', 'remove_this') . ' (index ' . pssDebugStyleString('%3$s', 'highlight') . ') from the Score Script.',
	'foundactual12' => 'We found ' . pssDebugStyleString('%1$s', 'number_found') . ' actual ' . pssDebugStyleString('%2$s', 'highlight') . '.',
	'appearfoundatleastone1' => 'We appear to have found at least one ' . pssDebugStyleString('%1$s', 'highlight') . '.',
	'replace12with34' => 'Replacing ' . pssDebugStyleString('%1$s', 'highlight') . ' ' . pssDebugStyleString('%2$s', 'replace_this') . ' with ' . pssDebugStyleString('%3$s', 'highlight') . ' ' . pssDebugStyleString('%4$s', 'replace_with') . '.',
	'setting12to3' => 'Setting ' . pssDebugStyleString('%1$s', 'highlight') . ' ' . pssDebugStyleString('%2$s', 'identifier') . ' to ' . pssDebugStyleString('%3$s', 'set_to') . '.'
	
	);
	
	if (!array_key_exists(strtolower($theclass), $formats)) {
		$theclass='replace12with34'; // set default here
	}
	
	// pad the message pieces array to guarantee it has five entries
	//$message_pieces = array_pad($message_pieces, 5, '');
	
	$theoutput .= sprintf($formats[$theclass], htmlspecialchars($piece1), htmlspecialchars($piece2), htmlspecialchars($piece3), htmlspecialchars($piece4), htmlspecialchars($piece5), htmlspecialchars($piece6), htmlspecialchars($piece7), htmlspecialchars($piece8)); 
	
	$theoutput .= pssDebugEnd();
	
	if (1) {
		// return the error message
		echo $theoutput;
		return;
	
	}
	else {
		// log the error message
		return;
	}
}

/**
 * Format a Score Script debug string
 *
 * Format color, border and/or 
 * other css properties with a div or span tag
 *
 * @param string $thestring the string that is the debug message
 * @param string $theclass the type of debug message
 * @return string the string that is the debug message in pretty format
 */
function pssDebugStyleString($thestring, $theclass='highlight') {
	
	$classes = array(
	'highlight' => 'padding: 1px; background-color: yellow;',
	'error' => 'padding: 1px; font-size: larger; font-weight: bold; color: red; background-color: white; border: 2px solid yellow;',
	'replace_this' => 'padding: 1px; color: orange; background-color: black; border: 2px solid black;',
	'replace_with' => 'padding: 1px; color: #00ff00; background-color: black; border: 2px solid black;',
	'identifier' => 'padding: 1px; background-color: #adff2f;',
	'set_to' => 'padding: 1px; background-color: #7fffd4;',
	'remove_this' => 'padding: 1px; color: red;',
	'number_found' => 'padding: 1px; background-color: orange; color: blue; font-size: larger;',
	'scorescriptoutput' => 'padding: 1em; color: purple; display: block; white-space: pre; max-width: 10cm; max-height: 8cm; overflow: scroll;',
	'scorescriptinput' => 'padding: 1em; color: blue; display: block; white-space: pre; max-width: 10cm; max-height: 8cm; overflow: scroll;'
	);
	if (!array_key_exists(strtolower($theclass), $classes)) {
		$theclass='highlight';
	}
	// FOR USE WITH SPRINTF, USE %% IN PLACE OF literal %
	return '<span style="' . str_replace('%', '%%', $classes[$theclass]) . '">' . $thestring . '</span>';
}

/**
 * Return a Search Engine Friendly (SEF) URL
 *
 * This function is needed for Joomla 1.5 due to a bug in the legacy sefRelToAbs function in Joomla 1.5
 *
 * @param string $url a non-SEF URL
 * @return string the SEF URL equivalent to the non-SEF input URL
 */
function sefRelToAbs_madblanks($value) {
	
	// JRoute class only exists in Joomla 1.5
	if (class_exists('JRoute')) {
		return JRoute::_($value, false);
		
	}
	else {
		return sefRelToAbs($value);
	}
}

/**
 * Do a redirect for the Create Single Record module with special requirements for Joomla 1.5
 * This function no longer in use as of 1.4.0 Beta 2; flag for removal
 *
 * @param string $value a URL to redirect to
 */
function mosRedirect_createsinglerecord($value, $enable1_5=1) {

	// Joomfish compatibility fix added 1.1.0final
	//  Joomfish (when installed) was rewriting URLs passed to this function that contained "index.php"
	//  see http://www.madblanks.org/index.php?option=com_smf&Itemid=6&topic=239.0
	$value = str_replace("iinnddeexx", "index", $value);
	
	// echo "incoming redirect to is $value<br />"; //exit;

 	// check for and do this section only for Joomla 1.5
	if (class_exists('JRoute') && $enable1_5) {
		// Joomla 1.5 with sef 1 and sef_rewrite 0?
		if (class_exists('JFactory') && $app =& JFactory::getApplication() && $app->getCfg('sef') == 1 && $app->getCfg('sef_rewrite') == 0) {

			if (strpos($value, "index.php?") !== false) { 
				// only use everything AFTER index.php
				//$value = substr($value, 10);
				$value = explode("index.php?", $value);
				$value = $value[1];
				echo "new1 value is $value<br />";

				if (strpos($value, "&") !== false) { 
					$value = preg_replace('/&/', '?', $value, 1);
				}

			}
		}

		else if (class_exists('JFactory') && $app =& JFactory::getApplication() && $app->getCfg('sef') == 1 && $app->getCfg('sef_rewrite') == 1) {

			if (strpos($value, "index.php?") !== false) { 
				// only use everything AFTER index.php
				//$value = substr($value, 10);
				$value = str_replace("index.php?", "", $value);
				//echo "new3 value is $value<br />";

				if (strpos($value, "&") !== false) { 
					$value = preg_replace('/&/', '?', $value, 1);
				}	

			}
		}	

		// this line takes care of the index page case where there is nothing beyond the root address of the site
		$splitbyslashes = explode("/", $value);

		// remove and return last element of array
		$lastportion = array_pop($splitbyslashes);

		$firstportion = implode("/", $splitbyslashes);

		$lastportion = explode("?", $lastportion);

		$firstoflastportion = isset($lastportion[0]) ? $lastportion[0] : '';

		$secondoflastportion = isset($lastportion[1]) ? $lastportion[1] : '';

		// if there exists an equals sign in the firstoflastportion
		if (strpos($firstoflastportion, "=") !== false) {
			//the URL to redirect to is rewritten
			$value = $firstportion . "?" . $firstoflastportion . "&" . $secondoflastportion;
		}

		else {
			//the URL to redirect to is NOT rewritten
			//$value = $value;
		}

	}
	
	$app = &JFactory::getApplication();$app->redirect($value);
}

/**
 * The following function is used to parse a 'mostrecentlookup' tag potentially
 * contained withing a string, and to return the string with the tag 
 * replaced by the desired value. The tag is defined as follows:
 * 
 * [:mostrecentlookup@<field>,<optional_category>,<optional_user_id>,<optional_format>:]
 * 
 * Insert value from a field in the most recently saved record
 *
 * The records values are taken from must be completed, approved, and published
 *
 * @param string $beforeorafterstring the string potentially containing a 'lookup' tag to be parsed;
 * this string will be modified and returned
 * @param $configrow category row from the database
 * @param $processmultisep flag: =1 convert [:multisep:] tags to "plain English", =2 convert [:multisep:] tags to semicolons
 * @return string return the string with the tag, if present, replaced by the looked up text; otherwise return the original string
 */
//function parseMostRecentTag($beforeorafterstring, $datarow=null, $apply_master_css=0, $theCSS=null, $configrow=null, &$randomtagresultssofar, $processmultisep=1) {
function parseMostRecentTag($beforeorafterstring, &$configrow, $processmultisep=1) {

	//echo "<pre>\$configrow\n"; print_r($configrow); echo "</pre>\n";
		
	// determine if the string contains a 'mostrecentlookup' tag at all
	if (strpos($beforeorafterstring, "[:mostrecentlookup") !== false) { // yes, a 'lookup' tag (probably) exists in the string

		$database = &JFactory::getDBO(); 

		$i = 0; // initialize 'while' loop index
		
		// [:mostrecentlookup@<field>,<optional_category>,<optional_user_id>,<optional_format>:]
		// check for valid 'mostrecentlookup' tag and parse it if present
		// limit this loop to 500 times to prevent infinite loops, 
		//  therefore limiting the number of 'mostrecentlookup' tags in a field or Score Script to 500
		// pattern modifier 's' enables linebreaks 
		//  to match so that Score Scripts can include more than one line and 
		//  contain 'lookup' tags
		while(preg_match("/(.*)\[:mostrecentlookup@(\d+|scodata\d+)(,(this|\d+)(,(\w+)(,([01]{4}))?)?)?:\](.*)/s", $beforeorafterstring, $preg_result) && $i < 500) {
			$i++;

			//\$beforeorafterstring is <pre>BEGIN$beforeorafterstringEND</pre>
			//echo "<pre>\$preg_result for loop number $i:\n"; print_r($preg_result); echo "</pre>"; //\nNow returning"; return;

			// In the array $preg_result,
			//  the beginning portion of the string will be $preg_result[1]
			//  the field number (must be present) will be $preg_result[2]
			//  the category, if present, will be $preg_result[4]
			//  the user_id, if present, will be $preg_result[6]
			//  the string formatting quadruplet, if present, will be $preg_result[8]
			//  the ending portion of the string will be $preg_result[9]
			
			if (is_numeric($preg_result[2])) {
				$record_field = 'data_' . sprintf('%02d', $preg_result[2]);
			}
			else {
				$record_field = $preg_result[2];
			}	

			// make sure we have a numeric category
			// if ($preg_result[4] == '' || $preg_result[4] == "this") {
			if (!is_numeric($preg_result[4]) && $configrow) {
				//echo "<p>Setting \$preg_result[4] = " . $configrow->id . ".</p>\n";
				$preg_result[4] = $configrow->id;
			}
			
			$session_lookup = ''; // initialize
			
			// 1.2.2 CPH 20091007
			if ($preg_result[6] == 'userorsession') {
			//if the user IS logged in, we want the profile to consist of the latest data 
			// belonging to that user
			//if the user is NOT logged in, we want the profile to consist of the latest data
			// from the current session
				
				$my = &JFactory::getUser();
				if ($my->username) {
					// the user is logged in
					$preg_result[6] = $my->username;
				}
				
				else {
					// the user is not logged in
					$session_lookup = "\nAND data.session = " . getMadBlanksSession();
					$preg_result[6] = '';
				}
			}
			// 1.2.1 CPH 20090830 allow for looking up record owned by 'any' user (or no user), even if the user is logged in
			else if ($preg_result[6] == 'any') {
				$preg_result[6] = '';
			}
			// make sure we have a text user name
			else if ($preg_result[6] == '' || $preg_result[6] == 'this') {
				
				$my = &JFactory::getUser();

				$preg_result[6] = $my->username;
			}
			// 1.2.0 CPH 20090809 add capability to lookup most recent from the current session
			else if ($preg_result[6] == 'currentsession') {
				$session_lookup = "\nAND data.session = " . getMadBlanksSession();
				$preg_result[6] = '';
			}
			else if (is_numeric($preg_result[6])) {
				$database->setQuery("SELECT username FROM #__users WHERE id = '" . $preg_result[6] . "' LIMIT 1");
				$preg_result[6] = $database->loadResult();
			}
			
			$querymostrecent = getDisplayQuery("", "", $preg_result[6], "\nAND data.configid = " . $preg_result[4] . $session_lookup, 'ORDER BY data.id DESC LIMIT 2', 'SELECT data.' . $record_field);

			$database->setQuery($querymostrecent);
			//echo "<p>The query is " . $database->getQuery() . "</p>";//exit;
			
			//$thedata = $database->loadResult();
			//echo "<p>The query result is " . $thedata . "</p>";
			
			$queryresult = $database->loadObjectList();

			//echo "<p>The query result is <pre>"; print_r($queryresult); echo "</pre></p><hr />\n";
			//echo "The answer is " . $queryresult[1]->{"data_" . sprintf('%02d', $preg_result[2])} . ".";
			
			// If we are dealing with the current category, and a second newest record exists, 
			//  then the result we are looking for is the 2nd newest, because the newest 
			//  is the one we just saved and have access to through normal Score Script variables
			if ($configrow && $configrow->id == $preg_result[4] && isset($queryresult[1])) {
				$thedata = $queryresult[1]->{$record_field};
			}
			
			// Otherwise, the result is the newest in the given category
			else {
				$thedata = isset($queryresult[0]->{$record_field}) ? $queryresult[0]->{$record_field} : '';
			}
			
			// 1.2.1 CPH 20090830 (added 'if' conditional)
			// dataFieldToQuizFormat wasn't working properly because configrow of current
			//  category was being used;
			//  Score Script calling this function has a category ID specified in $configrow->id,
			//  which is the category calling the Score Script,
			//  but it is not the correct category ID for the looked up tag, so compensate here,
			//  allowing for configrow to stay the same the whole time the function is running,
			//  but also for $configrowlocal to change with each iteration of the 'while' loop
			if (isset($configrow->id) && $configrow->id == $preg_result[4]) {
				$configrowthisiteration =& $configrow;
			}
			else {
				if (!isset($configuration)) { // only do this once per call of this function
					$configuration = getConfigurationArray();
				}	
				$configrowthisiteration =& $configuration[$preg_result[4]];
			}
			if ($configrowthisiteration && is_numeric($record_field)) {
				
				// make substitutions for any 'random' tags before applying the formatting
				$thedata = parseRandomTag($thedata, null, null, 0, $randomtagresultssofar);
						
				// use text field formatting function information from $configrowthisiteration
				$thedata = formatField($configrowthisiteration->{"data_" . sprintf('%02d', $preg_result[2]) . "_config"}, $thedata, ":", "|", $preg_result[8]);
			
				// use text field formatting function information from the category where the looked up data resides
				//$result[0]->thedata = formatField($result[0]->{"data_" . sprintf('%02d', $preg_result[2]) . "_config"}, $result[0]->thedata, ":", "|", $preg_result[8]);
				
				if ($processmultisep == 1 && strpos($thedata, "[:multisep:]") !== false) {
					$quizparameters = parseDataConfigString($configrowthisiteration->{"data_" . sprintf('%02d', $preg_result[2]) . "_config"});
					$thedata = dataFieldToQuizFormat($thedata, isset($quizparameters['checkboxsep1']) ? $quizparameters['checkboxsep1'] : '', isset($quizparameters['checkboxsep2']) ? $quizparameters['checkboxsep2'] : '', isset($quizparameters['checkboxsepa']) ? $quizparameters['checkboxsepa'] : '', isset($quizparameters['checkboxsepz']) ? $quizparameters['checkboxsepz'] : '', isset($quizparameters['checkboxsepb']) ? $quizparameters['checkboxsepb'] : '', isset($quizparameters['checkboxsepy']) ? $quizparameters['checkboxsepy'] : '');
				}
				// added 1.2.2 CPH 20091007 for reading default value in makeQuizForm() semicolon-delimited
				else if ($processmultisep == 2) {
					$thedata = str_replace('[:multisep:]', ';', $thedata);
				}
			}
			// 1.4.0 RC2 20100810 add else if to fix bug where [:multisep:] was not being converted 
			//  to semicolon when mostrecentlookup tag is the default value for a CSR form field
			else if ($processmultisep == 2) {
				$thedata = str_replace('[:multisep:]', ';', $thedata);
			}
								
			$beforeorafterstring = $preg_result[1] . $thedata . $preg_result[9];
	
		} // end while loop
	}		

	return $beforeorafterstring;
	
} /* end function parseMostRecentTag */

/**
 * Add slashes if necessary to configuration file values when saving the configuration file
 *
 * As long as we're using single quoted strings, everything is fine except that
 *  Joomla 1.0.x adds an extra \ to a ' or a " or a \ when using mosGetParam and magic quotes OFF
 *
 * @param string $thestring string to process
 * @return string $thestring processed string
 */
function mblconfig_addslashes($thetext) {

	//echo "<br />input text is $thetext, !get_magic_quotes_gpc() is " . (get_magic_quotes_gpc() ? 0 : 1);

	//if (class_exists('JFactory') && (get_magic_quotes_gpc() ? 0 : 1)) {
		$thetext = addslashes($thetext);
	//}
	
	$thetext = str_replace('\"', '"', $thetext);
	
	//echo "<br />output text is $thetext";
	
	return $thetext;
}

/**
 * Return the ID of the last inserted database row, allowing for mysql or mysqli database type
 *
 * @param string $theinput the resource to determine the database row ID for
 * @return string the returned database row ID
 */
function madblanks_mysql_insert_id($theinput) {

	if (class_exists('JFactory') && $conf =& JFactory::getConfig() && $conf->getValue('config.dbtype') == 'mysqli') {
		return mysqli_insert_id($theinput);
	}
	else {
		return mysql_insert_id($theinput);
	}	

}

/**
 * Get an integer that represents the user's session
 *
 * @return int the session representation
 */
function getMadBlanksSession() {

	if (class_exists('JConfig')) {
		$fac =& JSession::getInstance(null, null);
		$session_token = $fac->getToken();
	}
	else {
		global $mainframe;
		$session_token = $mainframe->_session->session_id;
	}
	//die(sprintf("%u", crc32(md5($session_token))));
	return sprintf("%u", crc32(md5($session_token)));
}

/**
 * Get the contents of a CSS style attribute designed to show a color somewhere between black and white
 *
 * @param int $value the number to represent as a color
 * @param int $max the maximum value of the color scale
 * @return string the contents of the generated CSS style attribute
 */
function getHexStyleAttributeByPercentage($value, $max) {

	if ($max != 0) {
		$percentage = $value/$max;
	}
	
	else {
		$percentage = 0;
	}
	
	$maincolor = dechex($percentage * 16777215);
	//$backgroundcolor = 'ffffff';
	
	//return "color: #$maincolor; background-color: #$backgroundcolor;";
	return "color: #$maincolor;";
}

function writeCSRBeginTime($newrecordcategory, &$moduleid) {

/* At the point in mod_madblanks_createsinglerecord.php when the $newrecordcategory (that's the ID number of the category)
that is going to be used is known (near line 752 where currently there is commented out code: //echo "<p>\$newrecordcategory
is $newrecordcategory</p>\n";, I would write the following to a new record in that table:

    * The Mad Blanks category ID ($newrecordcategory)
    * The session ID from the getMadBlanksSession() function
    * The time (perhaps using MySQL's NOW() function)
*/

	$database = &JFactory::getDBO();
	$user = &JFactory::getUser();
	
	$row = new MadBlanksTimeout($database);
	$row->category_id = $newrecordcategory;
	$row->user = $user->id;
	$row->module_id = $moduleid;
	$row->madblanks_session = getMadBlanksSession();
	$row->startdatetime = date("Y-m-d\ H:i:s");
	$row->starttimestamp = time();
	
	if (!$row -> store()) {
		// error storing CSR begin time
		//echo "\n<h1>writeCSRBeginTime() store error!</h1>";
		//if ($database->stderr()) {
		//	echo '<br />Query return status: ' . $database->stderr();
		//}
		//else {
		//	echo '<br />Query successful';
		//}
	}
}

function getCSRBeginTime($newrecordcategory, &$moduleid, $userorsession='session', $getwhat='interval', $timeout=0) {

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	
	if ($userorsession == 'session') {
		$where = "\nWHERE madblanks_session = " . getMadBlanksSession();
	}
	else {
		$where = "\nWHERE user = " . $my->id;
	}
		
	$getwhat = 'interval'; // this is all we're supporting for now

	$database->setQuery('SELECT starttimestamp FROM #__madblanks_timeout' . $where . ' AND category_id = ' . 
	$newrecordcategory . ' AND module_id = ' . $moduleid . "\nORDER BY starttimestamp ASC\nLIMIT 1");
	$debug_data = $database->loadObjectList();
	
	//echo "<pre>\ngetCSRBeginTime query output:\n"; print_r($debug_data); echo "</pre>\n";

	$database->setQuery('SELECT starttimestamp FROM #__madblanks_timeout' . $where . ' AND category_id = ' . 
	$newrecordcategory . ' AND module_id = ' . $moduleid . "\nORDER BY starttimestamp ASC\nLIMIT 1");
	$starttimestamp = $database->loadResult();

	/*
	
	We now have the UNIX timestamp for when the sessionuser or logged in user first loaded
	the CSR module.
	
	We want to add the time provided by $timeout;
	 if that amount of time has passed or is over that amount, return FALSE
	 if that amount of time has NOT passed yet, return TRUE
	
	*/
	
	// the timeout is relative to the start time
	$timeout = strtotime($timeout, $starttimestamp);

	// 1 means timed out
	// 0 means not timed out (OK)

	$time_remaining = $timeout - time();
	
	//echo "\n<br /><h1>time remaining (in seconds) is $timeout - " . time() . " = $time_remaining</h1>";
	
	if ($time_remaining < 0) {
		return 1;
	}
	else {
		return 0;
	}	
}

function clearExpiredTimeoutData($plain_english_time_interval) {
	
	// don't do this if $plain_english_time_interval is 0
	if (!($plain_english_time_interval == 0 && is_numeric($plain_english_time_interval))) {
		// delete records where the time they were created plus the human_readable_time
		//  is less than the current time

		// created at 12
		// time interval 2
		// time now 3
		// = YES delete

		// created at 12
		// time interval 2
		// time now 1
		// = NO delete

		// convert the plain English time interval to seconds
		$time_interval_seconds = strtotime($plain_english_time_interval) - time();

		$database = &JFactory::getDBO();
		$database->setQuery('DELETE FROM `#__madblanks_timeout` WHERE (DATE_ADD(FROM_UNIXTIME(`starttimestamp`), INTERVAL ' . $time_interval_seconds . ' SECOND) < \'' . date("Y-m-d\ H:i:s") . '\')');
		$database->query();
	}	
	
}

function madblanks_user_is_administrator() {
	$user_type =& JFactory::getUser();
	if ($user_type->usertype == "Super Administrator" || $user_type->usertype == "Administrator") {
		return 1;
	}
	else {
		return 0;
	}
}

/**
 * Determine whether or not it is OK for the Create Single Record module to write a new record
 *
 * @param int $configid the ID number of the Mad Blanks category to check the settings of
 * @param mixed an object or array containing the settings for the category (the same category as given in $configid)
 * @return array an array the first element of which is either a boolean allow or deny, or an integer containing the ID number of the Mad Blanks record to overwrite, and the second element of which is the ID number of the Score Script to display if a record cannot be written
 */
function approveCSRSave(&$configid, $category_array) {
	$category_array = (array)$category_array;
	
	// First, determine whether or not the user is logged in
	$my =& JFactory::getUser();
	$database =& JFactory::getDBO();
	
	//echo "<pre>"; print_r($my); echo "</pre>\n";exit;
	
	if (isset($category_array['user_not_logged_save']) && isset($category_array['user_logged_save'])) { // if we already have the $category_array, we don't need to look up the data in the database
		
		// if the category was created before Mad Blanks 1.4.0 Beta 2, these will be empty strings;
		//  if that's the case, use the default value for this setting, which is 'new'
		if ($category_array['user_not_logged_save'] == '') {
			//die('hek3');
			$category_array['user_not_logged_save'] = 'new';
		}
		if ($category_array['user_logged_save'] == '') {
			//die('hek4');
			$category_array['user_logged_save'] = 'new';
		}
		
		if ($my->guest) {
			$action = $category_array['user_not_logged_save'];
		}
		else {
			$action = $category_array['user_logged_save'];
		}
	}
	else { // look up the needed information directly from the database

		if ($my->guest) { // guest
			$database->setQuery('SELECT user_not_logged_save FROM #__madblanks_categories WHERE id = ' . intval($configid));
		}
		else { // registered user
			$database->setQuery('SELECT user_logged_save FROM #__madblanks_categories WHERE id = ' . intval($configid));
		}

		$action = $database->loadResult();
		
		// if the category was created before Mad Blanks 1.4.0 Beta 2, these will be empty strings;
		//  if that's the case, use the default value for this setting, which is 'new'
		if ($action == '') {
			$action = 'new';
		}
	}
	
	// 1.4.0 Beta 6 break the user_logged_save or the user_not_logged_save from the category 
	//  into its two parts CPH 20100611
	//  (the action [new, overwrite, disallowoverwrite, or disallowwrite] and the Score Script id)
	$permission_scorescript = explode(';', $action);
	if (!isset($permission_scorescript[0])) {
		$permission_scorescript[0] = 'new'; // new is the default
	}
	if (!isset($permission_scorescript[1])) {
		$permission_scorescript[1] = 0; // 0 (no Score Script selected) is the default
	}
	
	if ($permission_scorescript[0] == 'new') {
		return array(true, $permission_scorescript[1]);
	}
	
	else if ($permission_scorescript[0] == 'overwrite' || $permission_scorescript[0] == 'disallowoverwrite') {
		if ($my->guest) { // guest
			$database->setQuery('SELECT id FROM #__madblanks_records WHERE configid = ' . $configid . ' AND session = ' . getMadBlanksSession() . ' ORDER BY date_entered DESC LIMIT 1');
		}
		else { // registered user
			$database->setQuery('SELECT id FROM #__madblanks_records WHERE configid = ' . $configid . ' AND entered_by = ' . $my->id . ' ORDER BY date_entered DESC LIMIT 1');
		}
		$result = $database->loadResult();
		if ($result == NULL) {
			// there is no pre-existing record, so go ahead and create a new one
			return array(true, $permission_scorescript[1]);
		}
		else if (is_numeric($result)) {
			if ($permission_scorescript[0] == 'overwrite') {
				// there is a pre-existing record, so return the ID number of it
				return array(intval($result), $permission_scorescript[1]);
			}
			else { //$permission_scorescript[0] == 'disallowoverwrite'
				// there is a pre-existing record, so return false to disallow writing another one
				return array(false, $permission_scorescript[1]);
			}	
		}
		else { // should never get here
			return array(false, $permission_scorescript[1]);
		}	
	}
	
	else if ($permission_scorescript[0] == 'disallowwrite') {
		return array(false, $permission_scorescript[1]);
	}
	
	// should never get here
	return array(false, $permission_scorescript[1]);
}

/**
 * Add the reference key for a given email tag to the list of stored reference keys
 *  The purpose is to avoid duplicate emails
 *
 * @param mixed $reference_key the unique reference_key of the Score Script email tag
 */
function addEmailTagToStoredList(&$reference_key) {

	global $mbStoredEmailTags;
	$mbStoredEmailTags[] = $reference_key;
	$mbStoredEmailTags = array_unique($mbStoredEmailTags);

}

/**
 * Check whether the reference key for a given email tag exists in the list of stored reference keys
 *  The purpose is to avoid duplicate emails
 *
 * @param mixed $reference_key the unique reference_key of the Score Script email tag
 * @return bool true if the reference_key exists in the array, false otherwise
 */
function checkEmailTagInStoredList(&$reference_key) {
	
	global $mbStoredEmailTags;

	if (is_array($mbStoredEmailTags)) {
		return in_array($reference_key, $mbStoredEmailTags);
	}
	else {
		return false;
	}	

}

/**
 * Save a record from the create single record module
 */
function newRecordModuleSave() {

	//$JURI = new JURI();
	//echo "JURI::getQuery(); is " . $JURI->getQuery(); exit;
	
//	echo "<pre>request\n";
//	print_r($_REQUEST);
//	echo "</pre>";
//	echo "</pre>"; exit;
	
//	echo "<pre>";
//	print_r($GLOBALS);
//	echo "</pre>";

//	echo "<pre>post\n";
//	print_r($_POST);
//	echo "</pre>";
//	echo "</pre>"; exit;
	
	global $mbFieldCount, $mbTimeoutDataTimeToLive;
	$database = &JFactory::getDBO();
	
	// clean up #__madblanks_timeout data
	clearExpiredTimeoutData($mbTimeoutDataTimeToLive);
	
	// URL requires decoding if SEO is in use
	if ($app =& JFactory::getApplication() && $app->getCfg('sef')) {
		for ($i=0; $i <= $mbFieldCount; $i++) {
			$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
			if (isset($_POST['data_' . $theindex])) {
				if (!is_array($_POST['data_' . $theindex])) {
					// changed this line in 1.1.0 RC2 to remove addslashes: $_REQUEST['data_' . $theindex] = get_magic_quotes_gpc() ? addslashes(urldecode($_REQUEST['data_' . $theindex])) : urldecode($_REQUEST['data_' . $theindex]);
					//$_POST['data_' . $theindex] = urldecode($_POST['data_' . $theindex]);
					//echo urldecode($_REQUEST['data_' . $theindex]) . " ";
					$_POST['data_' . $theindex] = get_magic_quotes_gpc() ? stripslashes(urldecode($_POST['data_' . $theindex])) : urldecode($_POST['data_' . $theindex]);
				}
				else {
					for ($j = 0; $j < count($_POST['data_' . $theindex]); $j++) {
						$_POST['data_' . $theindex][$j] = get_magic_quotes_gpc() ? stripslashes(urldecode($_POST['data_' . $theindex][$j])) : urldecode($_POST['data_' . $theindex][$j]);
					}
				}
			}
		}
	}


	//echo "<pre>";
	//print_r($_POST);
	//echo "</pre>"; //exit;

	$option = JRequest::getVar('option', null, 'post');
	$task = JRequest::getVar('task', null, 'post');
	$thequerystring = JRequest::getVar('thequery', null, 'post');
	
	// 1.1.0 Final CPH 20090517
	// The query string should normally be the part after the ? but not always... so compensate here
	$thequerystring = str_replace("?", "&", $thequerystring);
	
	$configid = JRequest::getVar('configid', null, 'post');
	$nextconfigid = JRequest::getVar('nextconfigid', null, 'post');
	$nextconfiguri = JRequest::getVar('nextconfiguri', '', null, 'post');
	$completed = JRequest::getVar('completed', null, 'post');
	$inputanotherrecord = JRequest::getVar('inputanotherrecord', null, 'post');
	$modulecookieid = JRequest::getVar('modulecookieid', null, 'post');
	$timeframe = JRequest::getVar('timeframe', null, 'post');
	$submit_times_per_cookie = JRequest::getVar('submit_times_per_cookie', null, 'post');
	$allowblankvalues = JRequest::getVar('allowblankvalues', null, 'post');
	$promptfortitle = JRequest::getVar('promptfortitle', null, 'post');
	$saverecord = JRequest::getVar('saverecord', 1, 'post');
	$multchoicefieldlist = JRequest::getVar('multchoicefieldlist', null, 'post');
	
	// Comes in as a comma-delimited list of field numbers utilizing multiple choice; make this into an array.
	if ($multchoicefieldlist) {
		$multchoicefieldlist = explode(",", $multchoicefieldlist);
	}	

	$configuration = getConfigurationArray();
	
	$my =& JFactory::getUser();
	
	/******* BEGIN section for "Select the number of fields to choose randomly" 1.4.0 Beta 4 20100326 ******/
	
	$select_random_fields_number = false; // initialize flag
	$field_assignments = getMadBlanksFieldAssignments($my->id, (array) $configuration[$configid], false);
	//echo "<pre>"; var_dump($field_assignments); echo "</pre>\n";exit;
	
	if ($field_assignments === false) {
		$field_assignments = array(); // dummy array
	}
	else if (is_array($field_assignments)){
		$select_random_fields_number = true; // set flag
	}
	
	/******* _END_ section for "Select the number of fields to choose randomly" ******/

	$postprefix = "mbcsr"; // prefix for the variables used by this module, must match same var in module php file
	
	$modulecookieid = (int) $modulecookieid; // enforce this variable as an integer
	
	$database->setQuery("SELECT * FROM #__madblanks_categories WHERE id=" . intval($configid) . " AND allow_frontend_module_editing > 0");
	$configrows = $database->loadObjectList();

	// not saving the record (yet)
	if (!$completed || !$saverecord || $inputanotherrecord) {
		
		$completedvarsstring = '';
		if (!$inputanotherrecord) {
			
			$blankexists = false;
			$invalidexists = false;
			for ($i=0; $i <= $mbFieldCount; $i++) {
				$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
				if ($i==0 || $configrows[0]->{"data_".$theindex."_use"}) { // if config says to use it
				
					// if $select_random_fields_number in effect, check if this field should be active
					// but make sure we still collect a title if applicable
					if ($i != 0 && $select_random_fields_number && !in_array($theindex, $field_assignments)) {
						continue;
					}

					if ($i != 0 && isset($_POST['data_' . $theindex]) && is_array($_POST['data_' . $theindex])) {
						${"data_" . $theindex} = get_magic_quotes_gpc() ? stripslashes(implode("[:multisep:]", $_POST['data_' . $theindex])) : implode("[:multisep:]", $_POST['data_' . $theindex]);
					}
					
					else {
						${"data_" . $theindex} = get_magic_quotes_gpc() ? stripslashes(JRequest::getVar("data_" . $theindex, null, 'post', 'none', JREQUEST_ALLOWRAW)) : JRequest::getVar("data_" . $theindex, null, 'post', 'none', JREQUEST_ALLOWRAW);
						//echo "data_" . $theindex . " is " . ${"data_" . $theindex} . "<br />\n";
						//exit;
					}

					// 1.1.0rc2 added check for isset($_REQUEST["invalid_" . $theindex]) and isset($_REQUEST["blankok_" . $theindex])
					if (isset($_POST["data_" . $theindex]) || isset($_POST["blank_" . $theindex]) || isset($_POST["invalid_" . $theindex]) || isset($_POST["blankok_" . $theindex]) || (is_array($multchoicefieldlist) && in_array($theindex, $multchoicefieldlist))) {
						
						//echo "i is $i and we are here1; " . ${"data_" . $theindex} . " <br />";
						
						if ($i != 0) {
							$dataconfigarray = parseDataConfigString($configuration[$configid]->{'data_' . $theindex . '_config'});
						}	
						
						// 1.1.0rc2 added regexp validate functionality
						if ($i != 0 && isset($dataconfigarray['validateenable']) && ($dataconfigarray['validateenable'] == 'both' || $dataconfigarray['validateenable'] == 'server') && $dataconfigarray['validateregexp'] != '') {
						
							//preg_match(convertFromQuotLtGt(convertMBEscapedToLiteral($dataconfigarray['validateregexp'])), ${"data_" . $theindex}, $matches);
							
							// 1.2.1 CPH 20090906
							// for the case of check boxes or multiple choice menu, allow for more than
							//  one answer to have been given and check each answer against the regexp
							$individual_answers = explode('[:multisep:]', ${'data_' . $theindex});

							foreach ($individual_answers as $individual_answer) {

								preg_match(convertFromQuotLtGt(convertMBEscapedToLiteral($dataconfigarray['validateregexp'])), $individual_answer, $matches);
								if (isset($matches) && empty($matches)) {
									// the regexp is in effect and did not match
									break;
								}
							}

							if (isset($matches) && empty($matches)) { // the regexp is in effect and did not match
								$invalidfieldspresent = true;
								$completedvarsstring .= "&" . $postprefix . $modulecookieid . "invalid_" . $theindex . "=1";
								// 1.4.0 final 20100917 present the user's data again so it can be corrected, instead of wiping it out
								if (empty($dataconfigarray['validatewipe'])) {
									$completedvarsstring .= '&' . $postprefix . $modulecookieid . 'data_' . $theindex . '=' . urlencode(stripslashes(${'data_' . $theindex}));
								}
								else {
									// do NOT send mbcsrYYdata_XX information to the CSR to allow the user to edit her response
								}	
								
								if (!$invalidexists) {
									$completedvarsstring .= "&" . $postprefix . $modulecookieid . "invalidexists=1";
									$invalidexists = true;
								 }

							}
							else {
								// if we have a blank value that successfully passed the regexp, set the blankok flag for this field
								if (${"data_" . $theindex} == '') {	
									$completedvarsstring .= "&" . $postprefix . $modulecookieid . "blankok_" . $theindex . "=1";
								}
								else {
									$completedvarsstring .= "&" . $postprefix . $modulecookieid . "data_" . $theindex . "=" . urlencode(stripslashes(${"data_" . $theindex}));
								}
							}
							unset($matches);
						}

						else {
							//if (!empty(${"data_" . $theindex})) { // removed in 110b3
							if (isset(${"data_" . $theindex}) && ${"data_" . $theindex} != "") { // 110b3 changed to allow user to fill in a value of 0
								 $completedvarsstring .= "&" . $postprefix . $modulecookieid . "data_" . $theindex . "=" . urlencode(stripslashes(${"data_" . $theindex}));
								 //echo "i is $i and we are here2 " .  ${"data_" . $theindex} . "<br />";
							}
							else { // it's an empty string
								 $completedvarsstring .= "&" . $postprefix . $modulecookieid . "blank_" . $theindex . "=1";
								 //echo "i is $i and we are here3<br />";

								 // add blankexists variable to the string if not already there
								 if (!$blankexists) {
									$completedvarsstring .= "&" . $postprefix . $modulecookieid . "blankexists=1";
									$blankexists = true;
									//echo "i is $i and we are here4<br />";
								 }
							}
						        //exit;
						}

					}
				}	
			} //exit;
		}
		
		// remove variables associated with this module from the query string
		$thequerystring = cleanCreateSingleRecordModuleQueryString($thequerystring, $postprefix, $modulecookieid);
		
		// display without saving IF we are allowing blank values or we are not and there are no blank values
		if ($completed && !$invalidexists && ($allowblankvalues ? 1 : ($blankexists ? 0 : 1))) {
			//$newquery = $thequerystring . ($thequerystring ? $completedvarsstring : ltrim($completedvarsstring, "&"));
			//$newquery .= ($newquery ? "&" : "") . $postprefix . $modulecookieid . "shownosave=1&" . $postprefix . $modulecookieid . "configid=" . $configid;

			// 1.4.0 Beta 2 20100226 substitute these variables for the redirect
			$newquery = /* $thequerystring . ($thequerystring ? $completedvarsstring :*/ ltrim($completedvarsstring, "&")/*)*/;
			$newquery .= ($newquery ? "&" : "") . $postprefix . $modulecookieid . "shownosave=1&" . $postprefix . $modulecookieid . "configid=" . $configid;

			// 1.4.0 Beta 2 20100226 place variables that were formerly put in URL in holding array
			parse_str($newquery, $holding_array);
			
			// 1.4.0 Beta 2 20100226 add variables from holding array to $_REQUEST
			$_REQUEST = array_merge($_REQUEST, $holding_array);
			
			//echo "<pre>"; print_r($_REQUEST); echo "</pre>\n";exit;

			//die("newquery is $newquery");
			//die('<br />' . sefRelToAbs_madblanks("iinnddeexx.php" . ($newquery ? "?" . $newquery : "")));
			//die($completedvarsstring);

			/*
			if (strpos($thequerystring, 'com_content') !== false) { // no SEF redirect in content area of website
				mosRedirect_createsinglerecord("iinnddeexx.php" . ($newquery ? "?" . $newquery : ""));
			}
			else {
				mosRedirect_createsinglerecord(sefRelToAbs_madblanks("iinnddeexx.php" . ($newquery ? "?" . $newquery : "")));
			}
			*/
			return;
		}
		else {
			//echo "completedvarsstring is $completedvarsstring"; exit;
			//$newquery = $thequerystring . ($thequerystring ? $completedvarsstring : ltrim($completedvarsstring, "&"));
			//$newquery .= ($configid ? "&" . $postprefix . $modulecookieid . "configid=" . $configid : "");
			$newquery = /* $thequerystring . ($thequerystring ? $completedvarsstring :*/ ltrim($completedvarsstring, "&")/*)*/;
			$newquery .= ($configid ? "&" . $postprefix . $modulecookieid . "configid=" . $configid : "");
			
			// CPH 20090519 1.1.0final; change configid here for daisychain to another quiz 
			//  this code is for use with button to add next record
			if ($nextconfigid && is_numeric($nextconfigid)) {
				// append nextconfigid to redirect URL
				$newquery .= ($nextconfigid ? "&" . $postprefix . $modulecookieid . "nextconfigid=" . $nextconfigid : "") . ($nextconfiguri ? "&" . preg_replace('/data_(\d\d)=/', $postprefix . $modulecookieid . "data_\\1=", $nextconfiguri) : '');
			}	

			// 1.4.0 Beta 2 20100226 place variables that were formerly put in URL in holding array
			parse_str($newquery, $holding_array);
			
			// 1.4.0 Beta 2 20100226 add variables from holding array to $_REQUEST
			$_REQUEST = array_merge($_REQUEST, $holding_array);

			/*
			if (strpos($thequerystring, 'com_content') !== false) { // no SEF redirect in content area of website
				mosRedirect_createsinglerecord("iinnddeexx.php" . ($newquery ? "?" : "") . $newquery);
			}
			else {
				//echo "newquery is $newquery";
				mosRedirect_createsinglerecord(sefRelToAbs_madblanks("iinnddeexx.php" . ($newquery ? "?" : "") . $newquery));
			}
			*/
			return;
		}	
	}
	
	// save the record
	else {

		// implode array into a string if multiple answers were selected
		for ($i=1; $i <= $mbFieldCount; $i++) {
			$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
			// 'isset' check is required so 'is_array' check doesn't generate a notice level error
			if ($configrows[0]->{"data_".$theindex."_use"} && isset($_POST['data_' . $theindex]) && is_array($_POST['data_' . $theindex])) {
				
				// if $select_random_fields_number in effect, check if this field should be active
				if ($i != 0 && $select_random_fields_number && !in_array($theindex, $field_assignments)) {
					continue;
				}
				
				$_POST['data_' . $theindex] = implode("[:multisep:]", $_POST['data_' . $theindex]);
			}
		}
		
		$row = new MadBlanksRecord($database);

		//echo "<pre>\nthe POST vars are:\n";
		//print_r($_POST);
		//echo "</pre>";

		//echo "<pre>\nthe REQUEST vars are:\n";
		//print_r($_REQUEST);
		//echo "</pre>"; exit;

		$_POST['session'] = getMadBlanksSession();
		
		// bind POST variables to the table
		//if (!$row -> bind($_POST)) {
		if (!$row -> bind($_POST)) { // $_POST has been processed to compensate for SEO if applicable
			//echo "<script> alert('"
			//.$row -> getError()
			//."'); window.history.go(-1); </script>\n";
			//exit();
			echo "<p>binderror: " . $row -> getError();
		}
		
		//echo "<pre>\nrow is\n";
		//print_r($row);
		//echo "</pre>"; exit;

		// do blank check here if enabled check category config for which fields are used make sure those are all not empty
		// put flags in the URL to indicate which fields are blank and need to be entered and redisplay to the user

		// as of 1.1.0rc2 always do this conditional so we can also check for form validation
		//if ($allowblankvalues < 1) {

			$database->setQuery("SELECT * FROM #__madblanks_categories WHERE id=" . intval($configid) . " AND allow_frontend_module_editing > 0");
			$configrows = $database->loadObjectList();
			global $mbFieldCount;
			$completedvarsstring = '';
			for ($i=0; $i <= $mbFieldCount; $i++) {
				$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable

				if ($i == 0 || $configrows[0]->{"data_".$theindex."_use"}) { // if config says to use it
				
					// if $select_random_fields_number in effect, check if this field should be active
					// but make sure we still collect a title if applicable
					if ($i != 0 && $select_random_fields_number && !in_array($theindex, $field_assignments)) {
						continue;
					}

					if ($i == 0 && !$promptfortitle) {
						continue; // continue 'for' loop (blank check of title is irrelevant if not using a title)
					}	
					
					//$thefield = JRequest::getVar('data_' . $theindex, '', 'post');
					//$thefield = JRequest::getVar('data_' . $theindex, '', 'post', 'none', JREQUEST_ALLOWRAW);
					$thefield = convertToQuotLtGt(JRequest::getVar('data_' . $theindex, '', 'post', 'none', JREQUEST_ALLOWRAW));
					JRequest::setVar('data_' . $theindex, $thefield, 'post', true);
					

					if ($i != 0 && isset($configuration[$configid])) {
						$dataconfigarray = parseDataConfigString($configuration[$configid]->{'data_' . $theindex . '_config'});
					}
					else {
						$dataconfigarray = array(); // blank array
					}	

					//echo "<pre>"; print_r($dataconfigarray); echo "</pre>\n";
					
					// deal with a regular expression on this field if present
					// regexps take precedence over blanks
					if ($i != 0 && isset($dataconfigarray['validateenable']) && ($dataconfigarray['validateenable'] == 'both' || $dataconfigarray['validateenable'] == 'server') && $dataconfigarray['validateregexp'] != '') {
					
						
						// 1.2.1 CPH 20090906
						// for the case of check boxes or multiple choice menu, allow for more than
						//  one answer to have been given and check each answer against the regexp
						$individual_answers = explode('[:multisep:]', $thefield);
												
						foreach ($individual_answers as $individual_answer) {

							// 1.4.0 final add call to convertFromQuotLtGt on $individual_answer when checking a regexp in whole record at a time mode
							preg_match(convertFromQuotLtGt(convertMBEscapedToLiteral($dataconfigarray['validateregexp'])), convertFromQuotLtGt($individual_answer), $matches);
							if (isset($matches) && empty($matches)) {
								// the regexp is in effect and did not match
								break;
							}
						}
						
						if (isset($matches) && empty($matches)) { // the regexp is in effect and did not match
							$invalidfieldspresent = true;
							$completedvarsstring .= "&" . $postprefix . $modulecookieid . "invalid_" . $theindex . "=1";
							// 1.4.0 final 20100917 present the user's data again so it can be corrected, instead of wiping it out
							if (empty($dataconfigarray['validatewipe'])) {
								$completedvarsstring .= "&" . $postprefix . $modulecookieid . "data_" . $theindex . "=" . $thefield;
							}
							else {
								// do NOT send mbcsrYYdata_XX information to the CSR to allow the user to edit her response
							}	
						}
						else {
							if ($thefield == '') {
								$completedvarsstring .= "&" . $postprefix . $modulecookieid . "blankok_" . $theindex . "=1";
							}
							else {
								$completedvarsstring .= "&" . $postprefix . $modulecookieid . "data_" . $theindex . "=" . $thefield;
							}
							
						}
						unset($matches);
					}
					
					// no regular expression to worry about; look for a blank value if not allowed
					else if ($allowblankvalues < 1) { // if not allowing blanks
		
						//if  ($thefield) { // 110b3 change to allow 0 to be entered
						 if  ($thefield != '') {

							if (is_array($thefield)) {
								$thefield = implode("[:multisep:]", $thefield);
							}
							$completedvarsstring .= "&" . $postprefix . $modulecookieid . "data_" . $theindex . "=" . $thefield;
						}
						else {
							$blankfieldspresent = true;
							$completedvarsstring .= "&" . $postprefix . $modulecookieid . "blank_" . $theindex . "=1";
						}
					}					

				}

			}

			if (!empty($blankfieldspresent) || !empty($invalidfieldspresent)) {

				// remove variables associated with this module from the query string
				$thequerystring = cleanCreateSingleRecordModuleQueryString($thequerystring, $postprefix, $modulecookieid);


				//die(ltrim($completedvarsstring, '&') . ($configid ? '&' . $postprefix . $modulecookieid . 'configid=' . $configid : '') . (isset($blankfieldspresent) && $blankfieldspresent ? '&' . $postprefix . $modulecookieid . 'blankexists=1' : '') . (isset($invalidfieldspresent) && $invalidfieldspresent ? '&' . $postprefix . $modulecookieid . 'invalidexists=1' : ''));
				$newquery = ltrim($completedvarsstring, '&') . ($configid ? '&' . $postprefix . $modulecookieid . 'configid=' . $configid : '') . (isset($blankfieldspresent) && $blankfieldspresent ? '&' . $postprefix . $modulecookieid . 'blankexists=1' : '') . (isset($invalidfieldspresent) && $invalidfieldspresent ? '&' . $postprefix . $modulecookieid . 'invalidexists=1' : '');

				// 1.4.0 Beta 2 20100226 place variables that were formerly put in URL in holding array
				parse_str($newquery, $holding_array);

				$alt_holding_array = preg_split('/(?:&)?(' . $postprefix . $modulecookieid . '\w+)=/', $newquery, null, PREG_SPLIT_DELIM_CAPTURE);
				if (empty($alt_holding_array[0])) {
					array_shift($alt_holding_array); // remove first element, which will be empty, and reindex the array
					
					//echo "<pre>\$alt_holding_array\n\n"; print_r($alt_holding_array); echo "</pre>\n";
					
					$aha_length = count($alt_holding_array);
					for($aha_index = 0; $aha_index < $aha_length; $aha_index++) {
					
						if ($aha_index % 2 == 0) { // even
							// as a double check, make sure the even numbered array elements
							//  start with $postprefix . $modulecookieid
							if (strpos($alt_holding_array[$aha_index], $postprefix . $modulecookieid) === 0) {
								$aha_key = $alt_holding_array[$aha_index];
							}
							else {
								$aha_error = true;
								break;
							}	
						}
						else { // odd
							$new_holding_array[$aha_key] = $alt_holding_array[$aha_index];
						}
					}

					//echo "<pre>\$new_holding_array\n\n"; print_r($new_holding_array); echo "</pre>\n";					
					
					// if there were no apparent errors, use $new_holding_array in place of $holding_array
					if (empty($aha_error)) {
						$holding_array = $new_holding_array;
					}	
				}
				else { // should never get here, but if we do, we'll use the original $holding_array

				}

				//echo "<pre>\$holding_array after being modified\n\n"; print_r($holding_array); echo "</pre>\n";

				// 1.4.0 Beta 2 20100226 add variables from holding array to $_REQUEST
				$_REQUEST = array_merge($_REQUEST, $holding_array);

				/*
				if (strpos($thequerystring, 'com_content') !== false) { // no SEF redirect in content area of website
					mosRedirect_createsinglerecord("iinnddeexx.php?" . $thequerystring . ($thequerystring ? $completedvarsstring : ltrim($completedvarsstring, "&")) . ($configid ? "&" . $postprefix . $modulecookieid . "configid=" . $configid : "") . (isset($blankfieldspresent) && $blankfieldspresent ? "&" . $postprefix . $modulecookieid . "blankexists=1" : "") . (isset($invalidfieldspresent) && $invalidfieldspresent ? "&" . $postprefix . $modulecookieid . "invalidexists=1" : ""));
				}
				else {
					mosRedirect_createsinglerecord(sefRelToAbs_madblanks("iinnddeexx.php?" . $thequerystring . ($thequerystring ? $completedvarsstring : ltrim($completedvarsstring, "&")) . ($configid ? "&" . $postprefix . $modulecookieid . "configid=" . $configid : "") . (isset($blankfieldspresent) && $blankfieldspresent ? "&" . $postprefix . $modulecookieid . "blankexists=1" : "") . (isset($invalidfieldspresent) && $invalidfieldspresent ? "&" . $postprefix . $modulecookieid . "invalidexists=1" : "")));
				}
				*/
				
				return;
			}
		// (ends on next line) as of 1.1.0rc2 always do this conditional so we can also check for form validation
		//}
		
		if (empty($row->date_entered)) { // only put in a date_entered when the record is created, never again
			$row->date_entered = date("YmdHis"); //save date in MySQL format
		}
		$row->date_modified = date("YmdHis"); //save date in MySQL format
		
		$row->entered_by = $my->id; // id number of the current user	
		$row->modified_by = $my->id; // id number of the current user	
		
//		$row->title = stripslashes(JRequest::getVar('data_00', null, 'post'));

		global $mbFieldCount;
		for ($i=1; $i <= $mbFieldCount; $i++) {
			$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable
			// must use $_POST and not $_REQUEST to make use of prior array to string conversions
			//$row->{"data_" . $theindex} = stripslashes(mosGetParam($_POST, "data_" . $theindex, null));
			// 1.1.0b2 must use REQUEST // 1.1.0rc3 must use POST // 1.4.0 final 20100819 change JREQUEST_ALLOWHTML to JREQUEST_ALLOWRAW to enable < character being saved
			$row->{'data_' . $theindex} = convertToQuotLtGt(stripslashes(JRequest::getVar('data_' . $theindex, null, 'post', 'none', JREQUEST_ALLOWRAW)));
		}	

		$approve_publish_check = checkApprovePublishByModuleOK($row->configid);
		
		if ($approve_publish_check['allow_module_approve']) {
			$autoapprove = JRequest::getVar('autoapprove', 0, 'post');
			$row->approved = $autoapprove ? 16777215 : 0; // 16777215 is recognized by the getUserNameByID() function as the "auto approve" user
		}
		else {
			$row->approved = 0;
		}
		if ($approve_publish_check['allow_module_publish']) {
			$autopublish = JRequest::getVar('autopublish', 0, 'post');
			$row->published = $autopublish ? 1 : 0;
		}	
		else {
			$row->published = 0;
		}
		
		// get true, false, or a record number to overwrite
		$allow_save = approveCSRSave($row->configid, isset($configuration[$row->configid]) ? $configuration[$row->configid] : 0);
		//echo "return value was ";
		//var_dump($allow_save); exit;
		
		$idtoshow = 0; // initialize
		
		if ($approve_publish_check['allow_frontend_module_editing'] && $allow_save[0]) {

			if (is_int($allow_save[0])) {
				// we're overwriting a record
				$row->id = $allow_save[0];
			}
			
			//echo "<pre>\nrow just before store\n";
			//print_r($row);
			//echo "</pre>"; //exit;
			//echo " storing $row->id ";
			if (!$row -> store()) {
				//echo "store error!<br />";
				//echo "<script> alert('"
				//	.$row -> getError()
				//	."'); window.history.go(-1); </script>\n";
				//exit();
				echo '<div>storeerror: ' . $row -> getError() . '</div>';
			}
			
		}

		if (!is_int($allow_save[0])) {
			$idtoshow = madblanks_mysql_insert_id($database->_resource);
		}
		else {
			$idtoshow = $allow_save[0];			
		}
		//echo " idtoshow is $idtoshow ";				
		//var_dump(madblanks_mysql_insert_id($database->_resource));exit;

		if ($submit_times_per_cookie) { // if there is a limit, set cookie
			$submit_times_this_cookie = JRequest::getVar($postprefix . $modulecookieid, '0', 'cookie');
			setcookie($postprefix . $modulecookieid, $submit_times_this_cookie + 1, time()+$timeframe);
		}

		// return the website user to where he or she started      	
		// remove variables associated with this module from the query string
		//echo "<p>cleanCreateSingleRecordModuleQueryString _input is $thequerystring</p>";
		$thequerystring = cleanCreateSingleRecordModuleQueryString($thequerystring, $postprefix, $modulecookieid);
		//echo "<p>cleanCreateSingleRecordModuleQueryString output is $thequerystring</p>"; exit;
		
		// 1.4.0 Beta 2 20100226 substitute these variables for the redirect
		$_REQUEST[$postprefix . $modulecookieid . 'showid'] = $idtoshow;
		$_REQUEST[$postprefix . 'a'] = getMadBlanksSession();

		/*
		if (strpos($thequerystring, 'com_content') !== false) { // no SEF redirect in content area of website
			//mosRedirect_createsinglerecord(sefRelToAbs_madblanks("index.php?" . $thequerystring) . $postprefix . $modulecookieid . "showid," . mysql_insert_id($database->_resource) . "/" . $postprefix . "a," . sprintf("%u", crc32(md5($mainframe->_session->session_id))) . "/");
			mosRedirect_createsinglerecord("iinnddeexx.php?" . $thequerystring . ($thequerystring ? "&" : "") . $postprefix . $modulecookieid . "showid=" . $idtoshow . "&" . $postprefix . "a=" . getMadBlanksSession());
		}
		
		else {
			mosRedirect_createsinglerecord(sefRelToAbs_madblanks("iinnddeexx.php?" . $thequerystring . ($thequerystring ? "&" : "") . $postprefix . $modulecookieid . "showid=" . $idtoshow . "&" . $postprefix . "a=" . getMadBlanksSession()));
		}
		*/
		return;
	}	
}

/**
 * Check whether the reference key for a given email tag exists in the list of stored reference keys
 *  The purpose is to avoid duplicate emails sent from a Score Script
 *
 * @param int $user_id the unique id number of the current user
 * @param array $configuration an array containing the configuration for the Mad Blanks category at hand
 * @return mixed an array of field assignments (two digits with leading zeroes) for the given user_id and category_id, or FALSE if there is no logged in user or $writeifnone is false
 */
function getMadBlanksFieldAssignments($user_id=0, $configuration, $writeifnone=false) {

	if ($user_id == 0) {
		return false;
	}
	
	// first, check if there is an entry in the database for this user and this category
	$database =& JFactory::getDBO();
	$database->setQuery('SELECT field_numbers FROM #__madblanks_fieldassignments WHERE user_id = ' . $user_id . ' AND category_id = ' . $configuration['id'] . ' LIMIT 1');
	//echo $database->getQuery();
	$field_assignments = $database->loadResult();

	if (!empty($field_assignments)) {
		$field_assignments = explode(',', $field_assignments); // make into an array
	}
	else {
		//echo "<pre>"; print_r($configuration); echo "</pre>\n";

		$field_assignments = array(); // initialize
		global $mbFieldCount;
		for ($i=1; $i <= $mbFieldCount; $i++) {

			$theindex = sprintf('%02d', $i); // sprintf (as opposed to printf) is used to put the value into a variable

			if ($configuration["data_" . $theindex . "_use"]) {

				$field_assignments[$theindex] = 1;
				//echo "<p>field $theindex is active</p>\n";
			}
		}

		if ($configuration['select_random_fields_number'] > 0) {
			$field_assignments = array_rand($field_assignments, $configuration['select_random_fields_number']);
			// 1.4.0 RC1 20100713 if array_rand's 2nd argument is 1, it doesn't return an array, and we want an array
			if (!is_array($field_assignments)) {
				$field_assignments = array($field_assignments);
			}
		}
		else {
			$field_assignments = '';
		}

		//echo "<pre> The final field assignments will be "; print_r($field_assignments); echo "</pre>\n";

		//$database->setQuery('UPDATE #__madblanks_fieldassignments SET field_numbers = \'' . implode(',', $field_assignments) . '\' WHERE user_id = ' . $my->id . ' LIMIT 1');

		if ($writeifnone) {
			$database->setQuery('INSERT INTO #__madblanks_fieldassignments 
			(`id`, `user_id`, `session_id`, `category_id`, `field_numbers`)
			VALUES (NULL, ' . $user_id . ', 0, ' . $configuration['id'] . ', \'' . implode(',', $field_assignments) . '\')');
			//echo $database->getQuery();
			$database->query();
		}
		else {
			return false;
		}
	}
	return $field_assignments;
}

function establishAuxExpressionGroupTable(&$aggregate_tag_data, &$quizScore, $session) {


	//echo '<h1>start_up</h1>';
	$database =& JFactory::getDBO();
	$group_name = $database->getEscaped($aggregate_tag_data['field']);
	//echo "<br />group name is $group_name";
	$aggregate_tag_data['field'] = 'data';

	global ${'mbexpression__group' . $group_name};

	//echo "<pre>LOOK HERE\n\n"; print_r(${'mbexpression__group' . $group_name}); echo "</pre>\n";

	if (count(${'mbexpression__group' . $group_name}) > 0) {

		//if (empty($session)) {
		//	$session = getMadBlanksSession();
		//}	
		$thequery = ' INSERT INTO `#__madblanks_aux` (`configid`, `data`, `alt_label`, `session`)
		VALUES ';

		foreach (${'mbexpression__group' . $group_name} as $group_item_key => $group_item) {
		
			//echo "<br />group_item_key is $group_item_key";
			//echo "<br />group_item is $group_item";
		
			$thequery .= "('" . $aggregate_tag_data['category'] . "', '" . parseScoreScript($quizScore, $group_item) . "', '" . ((strpos($group_item_key, '___') !== false && strpos($group_item_key, '___') == 0) ? str_replace("'", "\'", substr($group_item_key, 3)) : '') . "', '$session'), ";
		}
		$thequery = rtrim($thequery, ', ');


		//$thequery .= '; SELECT * FROM `#__madblanks_temporary_expression_group`';

		//echo "start_up query was $thequery";
		$database->setQuery($thequery);
		$database->query();
		//echo $database->getQuery();
		//echo $database->stderr();

	}
	//$rows = $database->loadObjectList();

	//$database->setQuery('SELECT * FROM `#__madblanks_temporary_expression_group`');
	//$rows = $database->loadObjectList();
	//echo "<pre>\nthis should be it\n\n"; var_dump($rows); echo "</pre>\n";

	//echo '<br />executed the query ' . $database->getQuery();


}

function cleanAuxExpressionGroupTable($session, $category) {

	//echo '<h1>clean_up</h1>';

	$database =& JFactory::getDBO();
	//$thequery = "DELETE FROM `#__madblanks_aux` WHERE session = '$session' AND configid = " . $aggregate_tag_data['category'];
	$thequery = "DELETE FROM `#__madblanks_aux` WHERE session = '$session' AND configid = " . $category;
	$database->setQuery($thequery);
	$database->query();

	//echo '<br />executed the cleanup query ' . $database->getQuery();
}

/**
 * Set page title for the back end
 *
 * @since 1.4.1
 * @param string $pagetitle string that identifies the purpose of the page
 */
function setMadBlanksBackEndPageTitle($pagetitle='') {	
	$app =& JFactory::getApplication();
	$document =& JFactory::getDocument();
	if ($pagetitle != 'Mad Blanks') {
		$document->setTitle(($pagetitle ? $pagetitle. ' - Mad Blanks - ' : '') . $app->getCfg('sitename'));
	}
	else {
		$document->setTitle(($pagetitle ? $pagetitle. ' - ' : '') . $app->getCfg('sitename'));
	}
}

/**
 * Write JavaScript links to copy category field settings to the next field or all fields
 *
 * @since 1.4.2
 * @param string $theindex the two-digit field identifier (may have leading zero)
 * @param array $field_arrays array of arrays, each containing [0] the field names with # as the index number and [1] the form field type (input, textarea, pulldown, radio, checkbox, multi)
 * @param string $css_declarations css declarations to apply in the style element of the output div
 */
function copyMbCatFieldSetting($theindex, $field_arrays, $css_declarations='font-size: 7pt; margin: 2px 5px;') {

	global $mbFieldCount;
	
	if (!is_array($field_arrays)) {
		return;
	}
	
	$copytonext = ''; // initialize
	$copytobelow = ''; // initialize
	$copytoall = ''; // initialize
	
	foreach($field_arrays as $field_array) {
	
		$this_field_name = str_replace('#', $theindex, $field_array[0]);
		$next_field_name = str_replace('#', sprintf('%02d', $theindex + 1), $field_array[0]);
		$generic_field_name = $field_array[0];
		$field_type = $field_array[1];

		if ($theindex < $mbFieldCount) {
			$copytonext .= "copyMBFieldSetting('{$this_field_name}', '{$next_field_name}', '{$field_type}');";
		}
		
		if ($theindex > 1 && $theindex < $mbFieldCount - 1) {
			$copytobelow .= "copyMBFieldToAll('{$this_field_name}', '{$generic_field_name}', '{$field_type}', " . intval($theindex + 1) . ");";
		}

		$copytoall .= "copyMBFieldToAll('{$this_field_name}', '{$generic_field_name}', '{$field_type}', 1);";
	}

	echo '<div style="' . $css_declarations . '">';
	if ($copytonext) {
		echo '&bull;&nbsp;<a href="javascript:void(0);" onclick="' . $copytonext . '">' . _MBL_FIELD_COPY_TO_NEXT . '</a>';
	}
	if ($copytobelow) {
		echo '<br />&bull;&nbsp;<a href="javascript:void(0);" onclick="' . $copytobelow . '">' . _MBL_FIELD_COPY_TO_ALL_BELOW . '</a>';
	}
	echo '<br />&bull;&nbsp;<a href="javascript:void(0);" onclick="' . $copytoall . '">' . _MBL_FIELD_COPY_TO_ALL . '</a>';
	echo '</div>';

}

if (!empty($mbIncludeCustomizationFile) && file_exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanks.custom.php')) {
/**
 * Include the customization file
 */
	include JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanks.custom.php';
}
