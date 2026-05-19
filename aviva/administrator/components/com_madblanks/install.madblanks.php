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
 * This file contains code to run at install time.
 * 
 * file version 1.10.0 20110301
 *
 * @package Mad_Blanks_Component
 * @author Chris Hallett <chris@madblanks.org>
 * @copyright Chris Hallett March 1, 2011
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 
 * @version 1.4.2
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * This function is called when the component is installed.
 */
function com_install() {
	// file operations
	chdir("../");

	$database = &JFactory::getDBO(); 

	// change backend administrator menu image
	$database->setQuery("SELECT id FROM #__components WHERE admin_menu_link = 'option=com_madblanks&task=editconfiguration'");
	$id = $database->loadResult();
	$database->setQuery("UPDATE #__components SET admin_menu_img = 'js/ThemeOffice/config.png' WHERE id=$id");
	$database->query();
	
	// change backend administrator menu image
	$database->setQuery("SELECT id FROM #__components WHERE admin_menu_link = 'option=com_madblanks&task=popupreferencewindow'");
	$id = $database->loadResult();
	$database->setQuery("UPDATE #__components SET admin_menu_img = 'js/ThemeOffice/content.png' WHERE id=$id");
	$database->query();
	
	/* BEGIN additions to the categories table, if needed */
	
	// add restrict_viewing_to_creator to categories table if not present
	// added in Mad Blanks 1.0.0 RC2
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'restrict_viewing_to_creator'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_cat_table_args[] = "ADD restrict_viewing_to_creator tinyint(1) NOT NULL default 0";
	}
	
	// add allow_viewing_creatorless_records to categories table if not present
	// added in Mad Blanks 1.0.0 RC2
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'allow_viewing_creatorless_records'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_cat_table_args[] = "ADD allow_viewing_creatorless_records tinyint(1) NOT NULL default 1";
	}

	// add admins_see_all_creators to categories table if not present
	// added in Mad Blanks 1.0.0 RC2
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'admins_see_all_creators'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_cat_table_args[] = "ADD admins_see_all_creators tinyint(1) NOT NULL default 0";
	}
	
	// add allow_html_input to categories table if not present
	// added in Mad Blanks 1.1.0 Beta 1
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'allow_html_input'");
	$upgrade100to110 = false; 
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$upgrade100to110 = true; // Upgrade is from version 1.0.0 to version 1.1.0
		$alter_cat_table_args[] = "ADD allow_html_input tinyint(1) NOT NULL default 0";
	}
	
	// add default_score_script to categories table if not present
	// added in Mad Blanks 1.1.0 Beta 3
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'default_score_script'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_cat_table_args[] = "ADD default_score_script mediumint(8) unsigned NOT NULL";
	}

	// add frontend_show_in_csr_list to categories table if not present
	// added in Mad Blanks 1.1.0 final CPH 20090523
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'frontend_show_in_csr_list'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_cat_table_args[] = "ADD frontend_show_in_csr_list tinyint(1) default 1 NOT NULL";
	}

	// add archive_score_script to categories table if not present
	// added in Mad Blanks 1.1.0 final CPH 20090523
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'archive_score_script'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_cat_table_args[] = "ADD archive_score_script mediumint(8) unsigned NOT NULL";
	}

	// add archive_score_script to categories table if not present
	// added in Mad Blanks 1.1.0 final CPH 20090524
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'css_archive_score_script'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_cat_table_args[] = "ADD css_archive_score_script text NOT NULL";
	}

	// add category_message1 to categories table if not present
	// added in Mad Blanks 1.2.0 CPH 20090807
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'category_message1'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_cat_table_args[] = "ADD category_message1 text NOT NULL";
	}

	// add css_category_message1 to categories table if not present
	// added in Mad Blanks 1.2.0 CPH 20090807
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'css_category_message1'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_cat_table_args[] = "ADD css_category_message1 text NOT NULL";
	}

	// add category_message2 to categories table if not present
	// added in Mad Blanks 1.2.0 CPH 20090807
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'category_message2'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_cat_table_args[] = "ADD category_message2 text NOT NULL";
	}

	// add css_category_message2 to categories table if not present
	// added in Mad Blanks 1.2.0 CPH 20090807
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'css_category_message2'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_cat_table_args[] = "ADD css_category_message2 text NOT NULL";
	}

	// add user_logged_save to categories table if not present
	// added in Mad Blanks 1.4.0 Beta 2 CPH 20100217
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'user_logged_save'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_cat_table_args[] = "ADD user_logged_save varchar(20) NOT NULL";
	}

	// add user_not_logged_save to categories table if not present
	// added in Mad Blanks 1.4.0 Beta 2 CPH 20100217
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'user_not_logged_save'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_cat_table_args[] = "ADD user_not_logged_save varchar(20) NOT NULL";
	}
	
	// add select_random_fields_number to categories table if not present
	// added in Mad Blanks 1.4.0 Beta 4 CPH 20100326
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'select_random_fields_number'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_cat_table_args[] = "ADD select_random_fields_number mediumint(8) unsigned NOT NULL";
	}

	// add hide_record_content to categories table if not present
	// added in Mad Blanks 1.4.2 CPH 20110219
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'hide_record_content'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_cat_table_args[] = "ADD hide_record_content tinyint(1) NOT NULL default '0'";
	}

	if (!empty($alter_cat_table_args)) {
		echo "<hr />\n";
		$alter_cat_table_args = implode(", ", $alter_cat_table_args);
		$database->setQuery("ALTER TABLE #__madblanks_categories " . $alter_cat_table_args);
		if($database->query()) {
			echo "<div style=\"color: green;\">Successfully upgraded Mad Blanks categories
			database table to the latest version.</div>";
		}
		else {
			echo "<div style=\"color: red;\">Automatic database upgrade failed.</div>
			<p>Manually run the following SQL query on the database before proceeding:</p>"
			. $database->getQuery();
		}
		echo "<hr />\n";
	}
	
	// add #__madblanks_aux table if not present (redundant to install.mysql.sql)
	// added in Mad Blanks 1.4.0 Beta 6 CPH 20100615
	$database->setQuery("CREATE TABLE IF NOT EXISTS `#__madblanks_aux` (
		  `configid` mediumint(8) unsigned NOT NULL default '0',
		  `completed` tinyint(1) NOT NULL default '1',
		  `approved` mediumint(8) unsigned NOT NULL default '1',
		  `published` tinyint(1) unsigned NOT NULL default '1',
		  `data` text NOT NULL,
		  `alt_label` text NOT NULL,
		  `session` bigint(11) unsigned NOT NULL
		) TYPE=MyISAM ;");
	if($database->query()) {
		echo "<div style=\"color: green;\"><!-- Aux table exists --></div>";
	}
	else {
		echo "<div style=\"color: red;\">Could not add Mad Blanks Aux table, which is 
		needed for use with <em>expression_group</em> tags in the Score Scripting.</div>
		<p>Manually run the following SQL query on the database before proceeding:</p>"
		. $database->getQuery() . "<hr />\n";
	}
	
	/* END additions to the categories table */
	
	/* BEGIN modifications to the categories table, if needed */

	// Modify the data_XX_config columns in the database to be type TEXT
	// This modification made in Mad Blanks 1.1.0 Beta 1
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_categories LIKE 'data_%%_config'");
	$rows = $database->loadObjectList();
	$thequery = 'ALTER TABLE `#__madblanks_categories` ';
	foreach($rows as $row) {
		// look for != TEXT instead of == VARCHAR(255) as of Mad Blanks 1.1.0 Beta 2
		if (strtoupper($row->Type) != 'TEXT') {
			$thequery .= "CHANGE `" . $row->Field . "` `" . $row->Field . "` TEXT NOT NULL, ";
		}
	}
	if ($thequery != 'ALTER TABLE `#__madblanks_categories` ') {

		$database->setQuery(rtrim($thequery," ,"));

		if ($database->query()) {
			echo "<div style=\"color: green;\">Successfully updated data_XX_config fields to type 
			TEXT in the Mad Blanks categories database table.</div>";
		}
		else {
			echo "<div style=\"color: red;\">Automatic database upgrade failed.</div>
			<p>Manually run the following SQL query on the database before proceeding:</p>"
			. $database->getQuery();
		}
		echo "<hr />\n";
	}
	
	/* END modifications to the categories table */
	
	// add sample score scripts to score scripts table if the table is empty
	// added in Mad Blanks 1.1.0 Beta 1
	$database->setQuery("SELECT COUNT(*) FROM #__madblanks_scorescripts");
	$tablecheck = $database->loadResult();
	if (empty($tablecheck)) {
		$database->setQuery("INSERT INTO `#__madblanks_scorescripts` ( `id` , `name` , `date_created` , `ordering` , `published` , `scorescript` )
		VALUES (
		'1' , 'Generic Score Script #1 (give percentage correct and review all responses)', '2007-08-30 00:00:00', '1', '1', '<p>You answered [:number_of_correct_answers:] correctly out of [:total_answers_in_category:] possible. Your score is <span style=\"font-size: larger;\">[:percentage_correct:]%</span>.</p>\n\n[:each:answer:<start>:]<p style=\"font-size: smaller;\">Your answer to &quot;[:name:]&quot; was &quot;[:user_response:]&quot;, which is [:<start_correct>:]correct![:<end_correct>:][:<start_incorrect>:]incorrect. The correct response was  &quot;[:correct_value:]&quot;.[:<end_incorrect>:]</p>[:each:answer:<end>:]'
		), (
		'2' , 'Generic Score Script #2 (give percentage correct and review incorrect responses)', '2007-08-30 00:00:00', '2', '1', '<p>You answered [:number_of_correct_answers:] correctly out of [:total_answers_in_category:] possible. Your score is <span style=\"font-size: larger;\">[:percentage_correct:]%</span>.</p>\n\n[:each:answer:<start>:][:<start_incorrect>:]<p style=\"font-size: smaller;\">Your answer to &quot;[:name:]&quot; was &quot;[:user_response:]&quot;. The correct response was &quot;[:correct_value:]&quot;.</p>[:<end_incorrect>:][:each:answer:<end>:]'
		), (
		'3' , 'Generic Score Script #3 (use when a type A point value is assigned to each question)', '2007-08-30 00:00:01', '3', '1', '<p>You earned [:total_points_earned_a:] type A points out of a possible [:total_points_possible_a:].</p>\n\n<p>Your knowledge of this topic is\n\n[:points_a_range:0-24:<start>:]poor.[:points_a_range:0-24:<end>:]\n[:points_a_range:25-49:<start>:]average.[:points_a_range:25-49:<end>:]\n[:points_a_range:50-74:<start>:]good.[:points_a_range:50-74:<end>:]\n[:points_a_range:75-100:<start>:]excellent![:points_a_range:75-100:<end>:]\n\n</p>'
		)");
	
		if($database->query()) {
			if ($upgrade100to110) {	// only display this message if we are upgrading and not doing a fresh install
				echo "<div style=\"color: green;\">Successfully added example score scripts to the Mad Blanks score scripts database table.</div>";
				echo "\n<hr />\n";
			}	
		}
		else {
			echo "<div style=\"color: red;\">Automatic insertion of example score scripts failed.</div>
			<p>Manually run the following SQL query on the database before proceeding <b>(optional)</b>:</p>"
			. $database->getQuery();
			echo "\n<hr />\n";
		}
	}
	
	/* BEGIN additions to the records table, if needed */
	
	// add session to records table if not present
	// added in Mad Blanks 1.2.0 CPH 20090807
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_records LIKE 'session'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_rec_table_args[] = "ADD session bigint(11) unsigned NOT NULL";
	}

	// add scodata1 to records table if not present
	// added in Mad Blanks 1.2.2 CPH 20091007
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_records LIKE 'scodata1'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_rec_table_args[] = "ADD scodata1 text NOT NULL";
	}

	// add scodata2 to records table if not present
	// added in Mad Blanks 1.2.2 CPH 20091007
	$database->setQuery("SHOW COLUMNS FROM #__madblanks_records LIKE 'scodata2'");
	$columncheck = $database->loadObjectList();
	if (empty($columncheck)) {
		$alter_rec_table_args[] = "ADD scodata2 text NOT NULL";
	}

	if (!empty($alter_rec_table_args)) {
		$alter_rec_table_args = implode(", ", $alter_rec_table_args);
		$database->setQuery("ALTER TABLE #__madblanks_records " . $alter_rec_table_args);
		if($database->query()) {
			echo "<div style=\"color: green;\">Successfully upgraded Mad Blanks records
			database table to the latest version.</div>";
		}
		else {
			echo "<div style=\"color: red;\">Automatic database upgrade failed.</div>
			<p>Manually run the following SQL query on the database before proceeding:</p>"
			. $database->getQuery();
		}
		echo "<hr />\n";
	}
	
	/* END additions to the records table */
		

?>	

<h2 align="center">You have installed the Mad Blanks component.</h2>

<h3>Welcome to Mad Blanks!</h3>

<div style="text-align: left; margin: 1em 0; font-size: 12pt;">Mad Blanks is one of those products that can do so much that it can be hard to explain its capabilities
succinctly. The first thing to do if you're not sure if Mad Blanks can do what you want is to post on the <em>How Do I...
</em> board of the Mad Blanks Support forum at <a href="http://www.madblanks.org/" target="_blank"> www.madblanks.org</a>.
</div>

<div style="text-align: left; margin: 1em 0; font-size: 12pt;">The most popular use of Mad Blanks is to administer quizzes, surveys, and assessments. Mad Blanks includes
a number of ways of scoring quizzes or tests and significant flexibility through the creation of custom Score Scripts.
Various ways of assigning points to quiz answers can be used, or freeform responses can be accepted.</div>

<div style="text-align: left; margin: 1em 0; font-size: 12pt;">You can also use Mad Blanks as a forms component. When the user submits a form, it will (with default
settings) be saved in the database in the <em>jos_madblanks_records</em> table (replace <b>jos_</b> with your database prefix if different). The Score Script can perform calculations on
the user's input and store or email those results too, if needed.</div>

<div style="text-align: left; margin: 1em 0; font-size: 12pt;">The submitted data (and scoring results, if applicable) of Mad Blanks submissions can be shared publicly on
the front end or kept private to the administrators.</div>

<h3>The Mad Blanks Website</h3>

<div style="text-align: left; margin: 1em; font-size: 12pt; border: 2px outset black; padding: 1em; color: #894545; background-color: #d3d3d3;">For documentation, examples, and support, please visit <a href="http://www.madblanks.org/" target="_blank">
www.madblanks.org</a>. <span style="font-size: larger; font-style: italic;">Please go ahead and ask your questions on the
support forum there!</span></div>

<div style="text-align: left; margin: 1em 0; font-size: 12pt;">Thank you for installing Mad Blanks.</div><br /><br />
<?php
}