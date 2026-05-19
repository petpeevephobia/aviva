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
 * This file contains English language translation for the component.
 *
 * file version 1.19.0 20110301
 *
 * @package Mad_Blanks_Component
 * @author Chris Hallett <chris@madblanks.org>
 * @copyright Chris Hallett March 1, 2011
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @version 1.4.2
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php')) {
/**
 * Include the component configuration file
 */
	include JPATH_ADMINISTRATOR.DS.'components'.DS.'com_madblanks'.DS.'madblanksconfig.php';
}

/* BEGIN DEFINITIONS */

//  General
define('_MBL_RECORD_NAME', 'record');
define('_MBL_RECORD_NAME_PLURAL', 'records');
define('_MBL_CATEGORY_NAME', 'category');
define('_MBL_CATEGORY_NAME_PLURAL', 'categories');
define('_MBL_SCORESCRIPT_NAME', 'Score Script');
define('_MBL_SCORESCRIPT_NAME_PLURAL', 'Score Scripts');
define('_MBL_DATE_ENTERED_FORMAT', JText::_('DATE_FORMAT_LC'));
define('_MBL_DATE_MODIFIED_FORMAT', JText::_('DATE_FORMAT_LC2'));
define('_MBL_SUBMIT_BUTTON', 'Go');
define('_MBL_NEW', 'New');
define('_MBL_EDIT', 'Edit');
define('_MBL_COPY', 'Copy');
define('_MBL_COPY_OF', 'Copy of');
define('_MBL_APPLY', 'Apply');
define('_MBL_SAVE', 'Save');
define('_MBL_CANCEL', 'Cancel');
define('_MBL_DELETE', 'Delete');
define('_MBL_ORDERING_1', 'ordering');
define('_MBL_YES', 'Yes');
define('_MBL_NO', 'No');
define('_MBL_NONE', 'None');
define('_MBL_APPROVE', 'Approve');
define('_MBL_QUICK_APPROVE', 'Approve without edit');
define('_MBL_UNAPPROVE', 'Unapprove');
define('_MBL_COMPLETE', 'Complete');
define('_MBL_UNCOMPLETE', 'Uncomplete');
define('_MBL_PUBLISH', 'Publish');
define('_MBL_UNPUBLISH', 'Unpublish');
define('_MBL_PUBLISHED', 'published');
define('_MBL_UNPUBLISHED', 'unpublished');
define('_MBL_APPROVED', 'Approved');
define('_MBL_COMPLETED', 'Completed');
define('_MBL_APPROVED_BY', '(approved by %s)');
define('_MBL_TITLE', 'Title');
define('_MBL_ON', 'on');
define('_MBL_MODIFIED_BY', 'Modified by');
define('_MBL_DATA', 'Data');
define('_MBL_NAME', 'Name');
define('_MBL_ID', 'id');
define('_MBL_FIELD', 'Field');
define('_MBL_VARIABLE', 'variable');
define('_MBL_DESCRIPTION', 'description');
define('_MBL_SETTING', 'setting');
define('_MBL_CONFIRM_QUESTION', 'Are you sure you want to %s the selected items?');
define('_MBL_MAKE_SELECTION', 'Please make a selection from the list to %s.');
define('_MBL_LIST_IS_FILTERED', 'The list is filtered.');
define('_MBL_EMPTY_SET_REC', '<em>There are no ' . _MBL_RECORD_NAME_PLURAL . ' to list with the current filters</em>');
define('_MBL_EMPTY_SET_CAT', '<em>There are no ' . _MBL_CATEGORY_NAME_PLURAL . ' to list</em>');
define('_MBL_EMPTY_SET_SCO', '<em>There are no ' . _MBL_SCORESCRIPT_NAME_PLURAL . ' to list</em>');
define('_MBL_NEW_RECORD_LINK_TEXT', JString::ucfirst(_MBL_NEW) . " " . _MBL_RECORD_NAME . " for %s");
define('_MBL_NO_CATEGORIES_NEW_RECORD', 'Please create a ' . _MBL_CATEGORY_NAME . ' or check ' . _MBL_CATEGORY_NAME . ' permissions before making a new ' . _MBL_RECORD_NAME . '.');
define('_MBL_INVALID_CATEGORY', 'WARNING: This ' . _MBL_RECORD_NAME . ' appears to be using an invalid ' . _MBL_CATEGORY_NAME . '!');
define('_MBL_PAGE', 'Page');
define('_MBL_OF', 'of');
define('_MBL_DISPLAY_NR', 'Display #');

// If there are records in a category, a confirm dialog box is issued via JavaScript before deleting the category.
// The JavaScript warning string is concatenated from the following:
define('_MBL_WARNING', 'WARNING');
define('_MBL_THERE', 'There');
define('_MBL_ARE', 'are');
define('_MBL_IS', 'is');
define('_MBL_IN_DATABASE_FOR', 'in the database for');
define('_MBL_WILL_BE_ORPHANED', 'that will be orphaned! Delete the ' . _MBL_CATEGORY_NAME . ' anyway?');

// Frontend
define('_MBL_MODIFIED_ON', 'Modified');
define('_MBL_NO_RECORDS_TO_DISPLAY', 'No viewable ' . _MBL_RECORD_NAME_PLURAL . ' or no viewable ' . _MBL_CATEGORY_NAME_PLURAL . ' to display');
define('_MBL_NUMERIC_FORM_INPUT', 'Form input must be a number.');
define('_MBL_NO_RECORDS_USER', 'There are no accessible ' . _MBL_RECORD_NAME_PLURAL . ' for this userid with the given filters and current ' . _MBL_CATEGORY_NAME . ' permissions.');
define('_MBL_ID_SINGULAR_DOESNT_EXIST', JString::ucfirst(_MBL_RECORD_NAME) . ' #%s or its ' . _MBL_CATEGORY_NAME . ' is not ' . _MBL_PUBLISHED . ' or could not be retrieved from the database.' );
define('_MBL_ID_PLURAL_DOESNT_EXIST', JString::ucfirst(_MBL_RECORD_NAME_PLURAL) . ' #%s or their ' . _MBL_CATEGORY_NAME_PLURAL . ' are not ' . _MBL_PUBLISHED  .' or could not be retrieved from the database.' );
define('_MBL_CATEGORY_DOESNT_EXIST', 'No ' . _MBL_RECORD_NAME_PLURAL . ' to display for ' . _MBL_CATEGORY_NAME . ' #%s.' );
define('_MBL_NO_RANDOMIZIBLE_RECORDS', 'No randomizable ' . _MBL_RECORD_NAME_PLURAL . ' found for ' . _MBL_CATEGORY_NAME . ' #%s.' );
define('_MBL_CHOOSE_RANDOM_CATEGORY', 'Choose ' . _MBL_CATEGORY_NAME . ' from which to show a randomly assembled ' . _MBL_RECORD_NAME . ':');
define('_MBL_NO_RANDOM_CATEGORY', 'No randomizable ' . _MBL_CATEGORY_NAME_PLURAL . ' or no ' . _MBL_RECORD_NAME_PLURAL . ' found.');
define('_MBL_CHOOSE_CSR_CATEGORY', 'Choose a quiz or survey to fill out:');
define('_MBL_NO_CSR_LINKS_TO_DISPLAY', 'No quizzes or surveys available to fill out');
define('_MBL_SHOW_ALL', 'Show all');
define('_MBL_SHOW_FEATURED', 'Show featured');
define('_MBL_CHOOSE_CATEGORY', 'Choose a ' . _MBL_CATEGORY_NAME . ' to show:');
define('_MBL_OTHER_OPTIONS', 'Other options:');
define('_MBL_SHOW_CATEGORY_NUMBER', 'Show ' . _MBL_CATEGORY_NAME . ' #%s');
define('_MBL_SHOW_RANDOM_CATEGORY', 'Show randomized ' . _MBL_RECORD_NAME . ' for');
define('_MBL_LINK_TO_THIS', 'Link to this (#%d)'); // text for link back to the same record; %d OR %1$d is the id number of the record
define('_MBL_COMPONENT_HOME_LINK_TEXT', htmlspecialchars(stripslashes($mbComponentTitle)) . ' Home');
define('_MBL_ENTERED_OR_AUTHORED_BY', 'Entered by'); // 1.2.1 CPH 20090830 'Entered by'; was 'Entered/Authored by'
define('_MBL_BUTTON_SHOW_ANOTHER_RANDOM_TEXT', 'Randomize Again');
define('_MBL_RANDOMIZED_ENTRY_TITLE','%s (Randomized entry)'); // %s is the category title
define('_MBL_MAIN_SCREEN_DISABLED', '<p style="color: gray;"><em>[Disabled]</em></p>');
define('_MBL_MODULE_UNAVAILABLE', '<em>No requested module or the requested module or modules is unavailable.</em>'); // CPH 20090520 1.1.0final changed from 'The requested module or modules is unavailable.'

// Backend default screen
define('_MBL_BACKEND_WELCOME', 'Welcome to the ' . $mbComponentTitle . ' administration area.');
define('_MBL_BACKEND_RECORDS', ucwords('List ' . _MBL_RECORD_NAME_PLURAL));
define('_MBL_BACKEND_CATEGORIES', ucwords('List ' . _MBL_CATEGORY_NAME_PLURAL));
define('_MBL_BACKEND_CONFIGURATION', 'Edit Configuration');
define('_MBL_BACKEND_SCORESCRIPTS', 'List ' . ucwords(_MBL_SCORESCRIPT_NAME_PLURAL));

// Backend mosmsg messages
define('_MBL_SAVE_CATEGORY_MOSMSG', ucwords(_MBL_CATEGORY_NAME) . ' #%s was saved on ' . JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC2')) . '.');
define('_MBL_CATEGORY_COPY_MOSMSG', ucwords(_MBL_CATEGORY_NAME) . ' with ID# %1$s has been copied to ' . _MBL_CATEGORY_NAME . ' with ID# %2$s.');
define('_MBL_CATEGORY_DELETE_SINGULAR_MOSMSG', 'The ' . _MBL_CATEGORY_NAME . ' (ID# %s) has been deleted.');
define('_MBL_CATEGORY_DELETE_PLURAL_MOSMSG', 'The ' . _MBL_CATEGORY_NAME_PLURAL . ' (ID#s %s) have been deleted.');

define('_MBL_SAVE_SCORESCRIPT_MOSMSG', ucwords(_MBL_SCORESCRIPT_NAME) . ' #%s was saved on ' . JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC2')) . '.');
define('_MBL_SCORESCRIPT_COPY_MOSMSG', ucwords(_MBL_SCORESCRIPT_NAME) . ' with ID# %1$s has been copied to ' . _MBL_SCORESCRIPT_NAME . ' with ID# %2$s.');
define('_MBL_SCORESCRIPT_DELETE_SINGULAR_MOSMSG', 'The ' . _MBL_SCORESCRIPT_NAME . ' (ID# %s) has been deleted.');
define('_MBL_SCORESCRIPT_DELETE_PLURAL_MOSMSG', 'The ' . _MBL_SCORESCRIPT_NAME_PLURAL . ' (ID#s %s) have been deleted.');

define('_MBL_RECORD_DELETE_SINGULAR_MOSMSG', 'The ' . _MBL_RECORD_NAME . ' (ID# %s) has been deleted.');
define('_MBL_RECORD_DELETE_PLURAL_MOSMSG', 'The ' . _MBL_RECORD_NAME_PLURAL . ' (ID#s %s) have been deleted.');
define('_MBL_RECORD_NOT_FOUND_MOSMSG', 'The requested ' . _MBL_RECORD_NAME . ' does not exist or its ' . _MBL_CATEGORY_NAME . ' configuration was not found.');
define('_MBL_RECORD_DOESNT_EXIST', 'The requested ' . _MBL_RECORD_NAME . ' does not exist or cannot be edited on the frontend.');
define('_MBL_SAVE_RECORD_MOSMSG', 'The ' . _MBL_RECORD_NAME . ' (#%s) has been saved on ' . JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC2')));
define('_MBL_SAVE_RECORD_AUTO_APPROVED','The ' . _MBL_RECORD_NAME . ' has been automatically approved.');
define('_MBL_SAVE_RECORD_NOT_APPROVED','The ' . _MBL_RECORD_NAME . ' is enqueued for approval by an administrator.');
define('_MBL_RECORD_COPY_MOSMSG', 'The ' . _MBL_RECORD_NAME . ' with ID# %1$s has been copied to the ' . _MBL_RECORD_NAME . ' with ID# %2$s.');
define('_MBL_CONFIG_OPEN_FAIL_MOSMSG', 'Operation Failed: Could not open %s');
define('_MBL_CONFIG_NOT_WRITABLE_MOSMSG', 'The configuration file is NOT writable!');
define('_MBL_CONFIG_NOT_SAVED_MOSMSG', 'The configuration file could not be saved!');
define('_MBL_CONFIG_SAVED_MOSMSG', 'The configuration file was saved!');
define('_MBL_CATEGORY_VALIDATION_ERROR', 'WARNING: Not saved! Please fill in name for field number %s or deactivate the field.<br />');

// Frontend mosmsg messages
define('_MBL_CONFIG_UNEDITABLE_FRONTEND', 'The ' . _MBL_CATEGORY_NAME . ' the ' . _MBL_RECORD_NAME . ' belongs to does not exist or is not editable on the frontend.');

// Backend Score Scripts
define('_MBL_LIST_SCORESCRIPTS_TITLE', 'List of ' . ucwords(_MBL_SCORESCRIPT_NAME_PLURAL));
define('_MBL_NAME_FOR_THIS_SCORESCRIPT', 'Name for this ' . ucwords(_MBL_SCORESCRIPT_NAME) . ':');
define('_MBL_SCORESCRIPT_EDIT_TITLE', ucwords(_MBL_SCORESCRIPT_NAME) . ' (This is what the website user will see after finishing the quiz. Special tags [listed above] and HTML can be used in this field.)');

// Backend common to edit category screen, edit record screen, and category reference window
define('_MBL_FIELD_NAME', 'Field Name (or Quiz Question)');
define('_MBL_PART_OF_SPEECH', 'Clue/Cue/Hint'); // 1.1.0rc3 changed from 'Part of Speech
define('_MBL_BEFORE_TEXT', 'Text/HTML that comes before');
define('_MBL_FIELD_TEXT', 'The field');
define('_MBL_AFTER_TEXT', 'Text/HTML that comes after');

// Backend edit category screen
define('_MBL_NAME_FOR_THIS_CATEGORY', 'Name for this ' . _MBL_CATEGORY_NAME . ':');
define('_MBL_DEFAULT_TITLE_FOR_THIS_CATEGORY', 'Default title for ' . _MBL_RECORD_NAME_PLURAL . ' using this ' . _MBL_CATEGORY_NAME . ':');
define('_MBL_SELECT_RANDOM_FIELDS_NUMBER', 'Ask randomized subset (only works for users who are logged in to the front end): Select the number of fields to choose randomly for this ' . _MBL_CATEGORY_NAME . ' (0 to disable):');
define('_MBL_DEFAULT_SCORESCRIPT_FOR_THIS_CATEGORY', 'Default ' . _MBL_SCORESCRIPT_NAME . ' to use for this ' . _MBL_CATEGORY_NAME . ' to respond to the user immediately after filling out the Mad Blanks Create Single Record module form:');
define('_MBL_ARCHIVE_SCORESCRIPT_FOR_THIS_CATEGORY', 'Archive ' . _MBL_SCORESCRIPT_NAME . ' to use for this ' . _MBL_CATEGORY_NAME . ' when displaying ' . _MBL_RECORD_NAME_PLURAL . ' later using the component or the Mad Blanks Display module:');
define('_MBL_CSS_ARCHIVE_SCORESCRIPT', 'CSS declarations, separated by semicolons, for the Archive ' . _MBL_SCORESCRIPT_NAME . ' output when displayed following each ' . _MBL_RECORD_NAME . ' (each ' . _MBL_RECORD_NAME . ' includes the <em>' . _MBL_BEFORE_TEXT . '</em> and <em>' . _MBL_AFTER_TEXT . '</em> for each field as configured in the ' . _MBL_CATEGORY_NAME . '). Applies ONLY to the component and the Mad Blanks Display module.');
define('_MBL_HIDE_RECORD_CONTENT', 'When displaying Mad Blanks ' . _MBL_RECORD_NAME_PLURAL . ' on the front end (with the component or the Mad Blanks Display module), hide the normal ' . _MBL_RECORD_NAME . ' output?');
define('_MBL_HIDE_RECORD_CONTENT_YES', 'Display ONLY the Archive  ' . _MBL_SCORESCRIPT_NAME . ' output; you can use the Archive ' . _MBL_SCORESCRIPT_NAME . ' to create your own layout of how each ' . _MBL_RECORD_NAME . ' is presented to the user, including any dynamic content you may include via ' . _MBL_SCORESCRIPT_NAME . ' tags');
define('_MBL_HIDE_RECORD_CONTENT_NO', 'Display the full ' . _MBL_RECORD_NAME_PLURAL . ', including the <em>' . _MBL_BEFORE_TEXT . ' ' . JString::strtolower(_MBL_FIELD_TEXT) . '</em> and the <em>' . _MBL_AFTER_TEXT . ' ' . JString::strtolower(_MBL_FIELD_TEXT) . '</em> for each field, and also the output from the Archive  ' . _MBL_SCORESCRIPT_NAME . ', if any (default)');
define('_MBL_FOR_THIS_CATEGORY', 'For ' . _MBL_RECORD_NAME_PLURAL . ' using this ' . _MBL_CATEGORY_NAME . ', ');
define('_MBL_NAME_FOR_RANDOMIZED', 'Title to use for ' . _MBL_RECORD_NAME_PLURAL . ' randomized using this ' . _MBL_CATEGORY_NAME . ':');
define('_MBL_NUMBER_OF_RECORDS_THIS_CATEGORY', 'The ' . _MBL_RECORD_NAME . ' count for this ' . _MBL_CATEGORY_NAME . ' is %5$s, of which %1$s are completed, %2$s are approved, and %3$s are published, with %4$s meeting all three criteria.');

define('_MBL_CATEGORY_MESSAGES_TO_USER', 'Instructions to the website user for this ' . _MBL_CATEGORY_NAME); // added in 1.2.0 20090807
define('_MBL_CATEGORY_MESSAGE1', 'Instructions/Message to the user for this ' . _MBL_CATEGORY_NAME . '; message appears at the TOP of the Create Single Record module; message can contain HTML'); // added in 1.2.0 20090807
define('_MBL_CSS_CATEGORY_MESSAGE1', 'CSS declarations, separated by semicolons, for the DIV surrounding the TOP Instructions/Message'); // added in 1.2.0 20090807
define('_MBL_CATEGORY_MESSAGE2', 'Instructions/Message to the user for this ' . _MBL_CATEGORY_NAME . '; message appears at the BOTTOM of the Create Single Record module; message can contain HTML'); // added in 1.2.0 20090807
define('_MBL_CSS_CATEGORY_MESSAGE2', 'CSS declarations, separated by semicolons, for the DIV surrounding the BOTTOM Instructions/Message'); // added in 1.2.0 20090807

define('_MBL_SCORESCRIPT_SETTINGS', 'Choose which ' . _MBL_SCORESCRIPT_NAME_PLURAL . ' to view/process<br />1.) immediately after a ' . _MBL_RECORD_NAME . ' is filled out using the Create Single Record module, and<br />2.) when a ' . _MBL_RECORD_NAME . ' is viewed later');

define('_MBL_APPEARANCE_SETTINGS', 'Choose which information appears with ' . _MBL_RECORD_NAME_PLURAL . ' on the frontend (applies to the component only&mdash;not the modules)');
define('_MBL_STYLE_SETTINGS', 'CSS style settings (these settings apply when a ' . _MBL_RECORD_NAME . ' is viewed by the component or the modules)');
define('_MBL_VIEW_EDIT_PERMISSIONS','Viewing and editing permissions');
define('_MBL_RANDOMIZATION_SETTINGS', 'Randomization settings');
define('_MBL_NOTES_SETTINGS', 'Administrator\'s notes');
define('_MBL_SPECIAL_TAG_DESCRIPTIONS_CAT', 'Special tags reference section: these special tags are available to use in the <em>' . _MBL_BEFORE_TEXT . ' ' . JString::strtolower(_MBL_FIELD_TEXT) . '</em> and <em>' . _MBL_AFTER_TEXT . ' ' . JString::strtolower(_MBL_FIELD_TEXT) . '</em>');
define('_MBL_SPECIAL_TAG_DESCRIPTIONS_SCO', 'Special tags reference section: these special tags are available to use in the ' . _MBL_SCORESCRIPT_NAME);
define('_MBL_FIELD_SETTINGS', 'Field configuration settings: activated fields must have a <em>Field Name</em> specified');

define('_MBL_LOGGED_USER', 'user');
define('_MBL_NOT_LOGGED_VISITOR', 'visitor');
define('_MBL_USER_LOGGED_SAVE', 'For the Create Single Record module: If the user is logged in on the front end (use the user\'s ID number to associate  ' . _MBL_RECORD_NAME_PLURAL . ' with the current ' . _MBL_LOGGED_USER . '): ');
define('_MBL_USER_LOGGED_NOSAVE_SCORESCRIPT', 'If the '. _MBL_LOGGED_USER . ' cannot write a new ' . _MBL_RECORD_NAME . ', show this ' . _MBL_SCORESCRIPT_NAME . ' instead of the <em>' . JString::ucfirst(_MBL_CATEGORY_NAME) . ' already filled out or not available</em> error message specified in the <b>Create Single Record module</b> parameters:');
define('_MBL_USER_NOT_LOGGED_SAVE', 'For the Create Single Record module: If the user is <em>not</em> logged in on the front end (use the Joomla! session to associate ' . _MBL_RECORD_NAME_PLURAL . ' with the current ' . _MBL_NOT_LOGGED_VISITOR . '): ');
define('_MBL_USER_NOT_LOGGED_NOSAVE_SCORESCRIPT', 'If the ' . _MBL_NOT_LOGGED_VISITOR . ' cannot write a new ' . _MBL_RECORD_NAME . ', show this ' . _MBL_SCORESCRIPT_NAME . ' instead of the <em>' . JString::ucfirst(_MBL_CATEGORY_NAME) . ' already filled out or not available</em> error message specified in the <b>Create Single Record module</b> parameters:');
define('_MBL_RECORD_CREATE_NEW', 'Create a new ' . _MBL_RECORD_NAME . ' each time');
define('_MBL_RECORD_OVERWRITE', 'Overwrite the ' . _MBL_RECORD_NAME . ' most recently entered by this %s');
define('_MBL_RECORD_DISALLOW_OVERWRITE', 'Prevent writing another ' . _MBL_RECORD_NAME . ' if one exists for this %s');
define('_MBL_RECORD_DISALLOW_WRITE', 'Prevent writing any ' . _MBL_RECORD_NAME_PLURAL . ' at all');
define('_MBL_RECORD_DISALLOW_SCORESCRIPT', '&amp;lt;no error ' . _MBL_SCORESCRIPT_NAME . ' specified - show CSR error message (' . JString::ucfirst(_MBL_CATEGORY_NAME) . ' already filled out or not available)&amp;gt;');

define('_MBL_ALLOW_FRONTEND_EDITING', 'allow ' . _MBL_RECORD_NAME_PLURAL . ' to be created and edited on the frontend (using the component)?');
define('_MBL_ALLOW_FRONTEND_MODULE_EDITING', 'allow ' . _MBL_RECORD_NAME_PLURAL . ' to be created and edited by the component\'s modules?');
define('_MBL_ALLOW_FRONTEND_VIEWING', 'allow ' . _MBL_RECORD_NAME_PLURAL . ' to be viewed on the frontend by the component?');
define('_MBL_ALLOW_FRONTEND_MODULE_VIEWING', 'allow ' . _MBL_RECORD_NAME_PLURAL . ' to be viewed on the frontend by the modules?');
define('_MBL_FRONTEND_SHOW_IN_LIST', 'Show this ' . _MBL_CATEGORY_NAME . ' in the list on the main component page? (If set to No, ' . _MBL_RECORD_NAME_PLURAL . ' can still be accessed via the &quot;'. _MBL_SHOW_ALL . '&quot; link or directly using URL variables.)');
define('_MBL_FRONTEND_SHOW_IN_CSR_LIST', 'Show this ' . _MBL_CATEGORY_NAME . ' in the list of surveys/quizzes available to take on the main component page? This will only work if the <em>mbCreateSingleRecordPosition</em> Mad Blanks configuration variable is set and there is an active copy of the Mad Blanks Create Single Record module published in that position.');
define('_MBL_ALLOW_HTML_INPUT', 'allow HTML tags to be displayed as HTML in the  ' . _MBL_RECORD_NAME . ' fields? If set to Yes, you are trusting your users\' HTML. If set to <b>No </b>(<b>recommended</b>), &lt; will be converted to <em>&amp;lt;</em> and &gt; will be converted to <em>&amp;gt;</em>.');
define('_MBL_ALLOW_RANDOM_TAG', 'allow ' . _MBL_RECORD_NAME_PLURAL . ' that are completed, approved, and published to be viewed via &quot;random&quot; tags (regardless of the allow frontend viewing setting and the allow randomizer setting)?');
define('_MBL_ALLOW_LOOKUP_TAG', 'allow ' . _MBL_RECORD_NAME_PLURAL . ' that are completed, approved, and published to be viewed via &quot;lookup&quot; tags (regardless of the allow frontend viewing setting)?');
define('_MBL_FRONTEND_AUTO_APPROVE', 'automatically approve ' . _MBL_RECORD_NAME_PLURAL . ' saved by non-administrator users (does not apply to modules)?');
define('_MBL_ALLOW_MODULE_APPROVE', 'allow ' . _MBL_RECORD_NAME_PLURAL . ' to be automatically approved by the component\'s modules?');
define('_MBL_ALLOW_MODULE_PUBLISH', 'allow ' . _MBL_RECORD_NAME_PLURAL . ' to be automatically published by the component\'s modules?');
define('_MBL_ALLOW_RANDOMIZER', 'allow randomized ' . _MBL_RECORD_NAME_PLURAL . '?');
define('_MBL_RESTRICT_VIEWING_TO_CREATOR', 'restrict viewing to the user who created/entered the ' . _MBL_RECORD_NAME . ' (does not apply to anonymous ' . _MBL_RECORD_NAME_PLURAL . ')?');
define('_MBL_ALLOW_VIEWING_CREATORLESS_RECORDS', 'allow viewing of anonymous ' . _MBL_RECORD_NAME_PLURAL . '?');
define('_MBL_ADMINS_SEE_ALL_CREATORS', 'administrators see ' . _MBL_RECORD_NAME_PLURAL . ' regardless of creator on the frontend?');

define('_MBL_SHOW_HIDE', '[+/-] Show/hide');
define('_MBL_SHOW_HIDE_ADVANCED_ALL', '[+/-] Show/hide advanced options for all fields');
define('_MBL_SHOW_HIDE_ADVANCED', '[+/-] Show/hide advanced options for this field');
define('_MBL_APPLY_FORMATTING_FUNCTIONS', 'Apply functions to format the field text when displaying it in the frontend:');
define('_MBL_APPLY_FORMATTING_STRTOUPPER', 'ALL UPPERCASE');
define('_MBL_APPLY_FORMATTING_STRTOLOWER', 'all lowercase');
define('_MBL_APPLY_FORMATTING_UCWORDS', 'Each Word Uppercase');
define('_MBL_APPLY_FORMATTING_UCFIRST', 'First word uppercase');
define('_MBL_USE_THIS_FIELD', 'Field activated?');
define('_MBL_TEXTAREA_WIDTH', 'TEXTAREA width (used by the component back end and for task=usereditrecord on the front end):');
define('_MBL_TEXTAREA_HEIGHT', 'TEXTAREA height (used by the component back end and for task=usereditrecord on the front end):');
define('_MBL_PARTOFSPEECH', 'Clue/Cue/Hint (optional):'); // 1.1.0rc3 changed from 'Part of Speech (optional):'
define('_MBL_VERTICAL', 'Vertical (default)');
define('_MBL_HORIZONTAL', 'Horizontal');

define('_MBL_INPUT_TYPE', 'What type of form input does this field use?');
define('_MBL_USE_INPUT', 'Text field (default)');
define('_MBL_USE_TEXTAREA', 'Textarea');
define('_MBL_USE_RADIO', 'Radio buttons');
define('_MBL_USE_CHECKBOX', 'Check boxes');
define('_MBL_USE_PULLDOWN', 'Pulldown menu');
define('_MBL_USE_MULTIPLE_MENU', 'Multiple choice menu');
define('_MBL_USE_HIDDEN', 'Hidden');

define('_MBL_INUPT_SIZE_WIDTH', 'Length or Width:');
define('_MBL_INUPT_SIZE_HEIGHT', 'Height:');

define('_MBL_INUPT_SIZES', 'Set the length of ' . _MBL_USE_INPUT . ' or the width and height of ' . _MBL_USE_TEXTAREA . '; <b>leave blank to use Create Single Record module settings, web browser defaults, or CSS file</b>; back end textarea size is set separately (see <em>TEXTAREA height</em> and <em>TEXTAREA width</em> below)');
define('_MBL_HORIZORVERT', 'Show ' . _MBL_USE_RADIO . ' / ' . _MBL_USE_CHECKBOX . ' vertically (down) or horizontally (across):');
define('_MBL_RADIO_CHECKBOX_NUMCOLUMNS', 'Number of columns to use for ' . _MBL_USE_RADIO . ' or ' . _MBL_USE_CHECKBOX . ':');

define('_MBL_NO_DEFAULT_SCORESCRIPT', '- No Default ' . _MBL_SCORESCRIPT_NAME . ' -');
define('_MBL_NO_ARCHIVE_SCORESCRIPT', '- No Archive ' . _MBL_SCORESCRIPT_NAME . ' -');

define('_MBL_VALIDATE_ENABLE', 'Enable form validation for this field? (Check that the user\'s entry in the Create Single Record module for this field is acceptable)');
define('_MBL_VALIDATE_ENABCLIENT', 'Client-side only (using JavaScript)');
define('_MBL_VALIDATE_ENABSERVER', 'Server-side only');
define('_MBL_VALIDATE_ENABBOTH', 'Full (Recommended validation mode)');
define('_MBL_VALIDATE_REGEXP', 'Regular expression (Perl-compatible) that must match field contents; include delimiters around the pattern (use forward slashes as delimiters for compatibility with JavaScript) and any flags (optional) after the closing delimiter (examples: <span style="color: blue; font-weight: bold; font-size: larger;">/^\d+$/</span> to require one or more digits only; <span style="color: blue; font-weight: bold; font-size: larger;">/^[A-Z]{2}$/</span> to require two capital letters only</span>); <span style="color: blue; font-weight: bold; font-size: larger;">/^a/i</span> to require that the field begin with <em>A</em> or <em>a</em>; <span style="color: red;">note that an invalid pattern entered here may cause PHP warnings</span>:');
define('_MBL_VALIDATE_ERRMSG', 'Error message to display to user if field contents are not valid:');
define('_MBL_VALIDATE_DEFAULT_ERRMSG', 'Please double check your input.');
define('_MBL_VALIDATE_DOWIPE', 'If the user\'s response is not valid, allow the user to edit the existing response (applies to server-side form validation only)?');
define('_MBL_VALIDATE_WIPE_YES', 'Erase the user\'s answer for this question before prompting her or him again');
define('_MBL_VALIDATE_WIPE_NO', 'Allow the user to edit the existing (but not valid) answer');

// Category per-field settings
define('_MBL_USE_MULTIPLECHOICE', 'Enable the following multiple choice answers? (In order to use these, one of <em>' . _MBL_USE_RADIO . '</em>, <em>' . _MBL_USE_CHECKBOX . '</em>, <em>' . _MBL_USE_PULLDOWN . '</em>, or <em>' . _MBL_USE_MULTIPLE_MENU . '</em> must be selected above.)'); // prior to 1.1.0rc2 this value was 'Does this field use a multiple choice answer?'
define('_MBL_USE_SQL_MULTIPLECHOICE', 'Advanced: The <em>List the options...</em> setting can be a MySQL Query that results in a.) a single field result containing a semicolon-delimited list of options, b.) a mutiple-row single column result, in which case each row is one option, or c.) a multiple row two-column result, in which case the first column is the set of options and the second column is the set of labels; be careful that your query does not reveal security-sensitive information; supports limited ' . _MBL_SCORESCRIPT_NAME . ' syntax (for example, use of the <em>mostrecentlookup</em> tag)');
define('_MBL_USE_MULTIPLECHOICE_YES', 'Enabled'); 
define('_MBL_USE_MULTIPLECHOICE_NO', 'Disabled'); 
define('_MBL_USE_SQL_MULTIPLECHOICE_YES', 'MySQL Query'); 
define('_MBL_USE_SQL_MULTIPLECHOICE_NO', 'Manually entered above (default)'); 
define('_MBL_CHECKBOX_SEPARATOR_A', 'Text/HTML that appears before the first check box (or multiple choice menu) response when MORE THAN ONE check box response is selected by the user (this is used when displaying the user\'s multiple responses in text form; special tags can be used):'); // added in 1.1.0b3
define('_MBL_CHECKBOX_SEPARATOR_B', 'Text/HTML that appears before the response when ONLY ONE response is selected, or manually entered, by the user (this is used when displaying the user\'s response in text form; special tags can be used):'); // added in 1.1.0b3
define('_MBL_CHECKBOX_SEPARATOR_1', 'Separator (text/HTML) in between check box (or multiple choice menu) responses except the last two (this is used when displaying the user\'s multiple responses in text form; special tags can be used; for example, use <span style="color: blue;">,[:space:]</span> here):');
define('_MBL_CHECKBOX_SEPARATOR_2', 'Separator (text/HTML) in between the last two check box (or multiple choice menu) responses (this is used when displaying the user\'s multiple responses in text form; special tags can be used; for example, use <span style="color: blue;">[:space:]and[:space:]</span> here):');
define('_MBL_CHECKBOX_SEPARATOR_Z', 'Text/HTML that appears after the last check box (or multiple choice menu) response when MORE THAN ONE check box response is selected by the user (this is used when displaying the user\'s multiple responses in text form; special tags can be used):'); // added in 1.1.0b3
define('_MBL_CHECKBOX_SEPARATOR_Y', 'Text/HTML that appears after the response when ONLY ONE response is selected, or manually entered, by the user (this is used when displaying the user\'s response in text form; special tags can be used):'); // added in 1.1.0b3
define('_MBL_USE_RANDOMORDER', 'Display radio button, check box, or menu options to the website user in random order?');
define('_MBL_USE_RANDOMORDER_YES', 'Show the options in random order');
define('_MBL_USE_RANDOMORDER_NO', 'Show the options in the order they are listed');
define('_MBL_SUBMIT_ON_CHANGE', 'Submit the form when this element of the form is changed by the user (only applies if this field uses check boxes, radio buttons, a pulldown menu, or a multiple choice menu; requires that JavaScript be available and compatible in the user\'s web browser)?');
define('_MBL_SUBMIT_ON_CHANGE_YES', 'Submit on change');
define('_MBL_SUBMIT_ON_CHANGE_NO', 'The user changing this selection does NOT submit the form');
define('_MBL_MULTIPLECHOICE_LIST', '<p>List the options to be shown for multiple choice (if one of <em>' . _MBL_USE_RADIO . '</em>, <em>' . _MBL_USE_CHECKBOX . '</em>, <em>' . _MBL_USE_PULLDOWN . '</em>, or  <em>' . _MBL_USE_MULTIPLE_MENU . '</em> is enabled); separate each entry with a semicolon. Do not put spaces around the semicolons. For a literal semicolon, use <b>[:semicol:]</b>.</p><p>Example: <span style="color: blue;">Yes;No;Maybe so;Could be</span></p>');
define('_MBL_SHORTMULTIPLECHOICE_LIST', '<p>Short / alternate versions of the above options (optional) separated by semicolons and corresponding to the options above (there should be the same number of options here and above); do not put spaces around the semicolons</p>');
define('_MBL_MULTIPLECHOICE_DEFAULT', '<p><em>Default</em> response (optional): Is there a default (pre-selected) option? Copy the option <b>exactly</b> as it appears in the semicolon-delimited list, or leave blank for no default. For more than one pre-selected answer (if using check boxes or the multiple choice menu), separate the default selections with semicolons. Do not put spaces around the semicolons.</p><p>Example: <span style="color: blue;">Maybe so</span></p><p>Note that the <em>mostrecentlookup</em> special tag can be used here. For example, use <span style="color: blue;">[:mostrecentlookup@1,11,currentsession:]</span> to look up the most recently entered answer that is completed, approved, and published for field #1 in Mad Blanks category #11 by the current user (whether logged in or not) during the current visit to the website. See the documentation in the <em>Special tags quick reference section</em> on the Score Script edit page (when editing a Score Script) for more details about the <em>mostrecentlookup</em> special tag and all of its options.</p>');
define('_MBL_MULTIPLECHOICE_USE_LAST_TIME', 'Click here to use the value the website user entered the last time she or he filled out the form as the default value.');
define('_MBL_MULTIPLECHOICE_USE_LAST_SAVE', 'Available after saving the category: ' . _MBL_MULTIPLECHOICE_USE_LAST_TIME);
define('_MBL_MULTIPLECHOICE_CORRECT', '<p><em>Correct</em> response (optional): Is there ONE correct option or ONE correct <em>group</em> of options that MUST be selected (or typed in) for this question to be answered &quot;correctly&quot; by the website user? This may apply if, for example, this is a quiz question with RIGHT and WRONG answers. Copy the option <b>exactly</b> as it appears in the semicolon-delimited list, or <b>exactly</b> as it should be typed by the user, or leave blank if no one answer is correct. If more than one option is required to be selected for a correct answer, list them separated by semicolons. Do not put spaces around the semicolons.</p><p>Example #1: <span style="color: blue;">Yes</span> &nbsp; &nbsp; &nbsp; &nbsp; Example #2: <span style="color: blue;">Maybe&nbsp;so;Could&nbsp;be</span></p>');
define('_MBL_MULTIPLECHOICE_BLANK_IS_CORRECT', '<p>Check the box if giving no response (blank) is correct</p>');
define('_MBL_MULTIPLECHOICE_CASE_CORRECT', '<p>Is the correct option case sensitive?</p>');
define('_MBL_MULTIPLECHOICE_CASE_CORRECT_YES', 'Case sensitive (the user\'s answer must match exactly)');
define('_MBL_MULTIPLECHOICE_CASE_CORRECT_NO', 'Not case sensitive');
define('_MBL_MULTIPLECHOICE_POINTVALUE', '<p><b>Type A points, awarded per question (optional):</b> Enter a point value to be awarded for this question when it is correct (i.e. the options selected equal the correct answer[s] entered above).</p>'); // 1.1.0rc2 changed 'below' to 'above'
define('_MBL_POINTVALUE_PER_RESPONSE', '<p><b>Type B points, awarded per response within the question (optional):</b> List point values for each individual option, separated by semicolons. Do not put spaces around the semicolons. There should be the same number of values here as there are multiple choice options above.</p>'); // 1.1.0rc2 added "multiple choice"
define('_MBL_FORM_INPUT_ATTRIBUTE', 'Set form control attribute for this field');
define('_MBL_FORM_INPUT_ATTRIBUTE_NORMAL', 'Normal');
define('_MBL_FORM_INPUT_ATTRIBUTE_READONLY', 'Read Only');
define('_MBL_FORM_INPUT_ATTRIBUTE_DISABLED', 'Disabled');
define('_MBL_FORM_ELEMENT_STYLE', 'Set a CSS style for this form element');
define('_MBL_FIELD_COPY_TO_NEXT', 'Copy&nbsp;to&nbsp;next');
define('_MBL_FIELD_COPY_TO_ALL_BELOW', 'Copy&nbsp;to&nbsp;all&nbsp;below');
define('_MBL_FIELD_COPY_TO_ALL', 'Copy&nbsp;to&nbsp;all');
define('_MBL_FIELD_MARGIN_MARKER', 'Editing<br />Field&nbsp;#%1$d'); // %1$d is replaced with the field number

// Backend edit individual record screen
define('_MBL_USE_ENTRY_WHEN_RANDOMIZING', 'Use this entry when randomizing');
define('_MBL_SELECT_AUTHOR', '- No Author -');
define('_MBL_USING_CATEGORY', 'using ' . _MBL_CATEGORY_NAME . '');
define('_MBL_USE_GLOBAL', 'Use global setting for ' . _MBL_CATEGORY_NAME); // used for yes/no/global radio button global description
define('_MBL_STICKY', 'Is this ' . _MBL_RECORD_NAME . ' sticky? (show at top of results)');
define('_MBL_ORDERING', 'Optional display order (use this to change the order in which ' . _MBL_RECORD_NAME_PLURAL . ' are displayed [in the component only; modules are unaffected], or leave at zero for default ordering by date then id) (Hint: These numbers need not be consecutive.)');
define('_MBL_AUTHOR_ALIAS', 'Author Alias');
define('_MBL_LOGGED_SCORESCRIPT_DATA', 'Logged Score Script Data');

// Backend common to edit individual record screen and record list
define('_MBL_SESSION_NUMBER', 'Session:');

// Backend edit individual record screen and Category reference window
define('_MBL_NO_ACTIVE_FIELDS', '<div align="center" class="error">No fields are configured for this ' . _MBL_CATEGORY_NAME . '.</div>');

// Backend edit configuration variables screen
define('_MBL_EDIT_CONFIGURATION', 'Edit Configuration Variables');
define('_MBL_RESET_CONFIGURATION', 'Reset to Default Configuration');
define('_MBL_RESET_CONFIRM', 'Overwrite all configuration data with the default settings?');
define('_MBL_WRITEABLE', 'Writeable');
define('_MBL_UNWRITEABLE', 'Unwriteable');
define('_MBL_CONFIGURATION_FILE_NOTICE', 'These configuration variables are saved in the following file, which can be edited directly if necessary:<br /><font color="#00009c"><b>&lt;Joomla! root directory&gt;/administrator/components/com_madblanks/madblanksconfig.php</b></font>');
define('_MBL_CONFIGURATION_WRITE_STATUS', 'The configuration file is: %s');
//define('_MBL_CONFIGURATION_LANGUAGE_NOTICE', 'Mad Blanks currently will use the <b>%1$s</b> language file (if it exists) at:<br /><font color="#00009c"><b>&lt;Joomla! root directory&gt;/administrator/components/com_madblanks/language/%1$s.php</font><br />To change this, change the site\'s default language.');
define('_MBL_MBCOMPONENTTITLE', 'Component title; Default is <em>Mad Blanks Component</em>');
define('_MBL_MBFIELDCOUNT', 'Number of supported data fields in the component\'s tables (<b>do not change this</b> unless you have modified the <em>#__madblanks_categories</em> and <em>#__madblanks_records</em> tables in the Joomla! database AND the two class definitions MadBlanksCategory and MadBlanksRecord in the file madblanks.class.php); Default is 25');
define('_MBL_MBCOLOR1', 'First alternating row color for category reference window, examples: lightgray or #d3d3d3; Default is <em>#d3d3d3</em>');
define('_MBL_MBCOLOR2', 'Second alternating row color for category reference window, examples: lightblue or #add8e6; Default is <em>#add8e6</em>');
define('_MBL_MBENTEREDBYLONGFORMAT', 'User names for authors, set this to 0; Full names for authors, set this to 1 (Yes); Default is 0 (No)');
define('_MBL_MBMODIFIEDBYLONGFORMAT', 'User names for modified_by, set this to 0; Full names for modified_by, set this to 1 (Yes); Default is 0 (No)');
define('_MBL_MBALLOWBLANKRANDOMFIELDS', 'Allow blank fields to be used when assembling randomized results; Default is 0 (No); to turn on, set to 1 (Yes)');
define('_MBL_MBDEFAULTRECORDSPERPAGE', 'How many ' . _MBL_RECORD_NAME_PLURAL . ' to display per page on the frontend (changeable by user with pulldown menu); use 5, 10, 15, 20, 25, 30, or 50 to match one of the values on the pulldown menu; Default is 15');
define('_MBL_MBDISPLAYRESULTNUMBERING', 'Show numbering of returned ' . _MBL_RECORD_NAME_PLURAL . ' in frontend? To turn on, set to 1 (Yes); Default is 0 (No)');
define('_MBL_MBFRONTENDPAGENAVALWAYSON', 'ALWAYS show pagination of returned ' . _MBL_RECORD_NAME_PLURAL . ' in frontend, regardless of how many there are; Default is 0 (No); to turn on, set to 1 (Yes)');
define('_MBL_MBFEATUREDRECORDS', 'Commma delimited list of specific ' . _MBL_RECORD_NAME_PLURAL . ' that are linked to from the component home; for example: 18 to link to ' . _MBL_RECORD_NAME . ' #18 or 1,5,12 to link to ' . _MBL_RECORD_NAME_PLURAL . ' #1, 5, and 12; links to ' . _MBL_RECORD_NAME_PLURAL . ' will appear in the order listed; Default is blank');
define('_MBL_MBPREVIEWBEFORESAVE', 'Show preview before saving a ' . _MBL_RECORD_NAME . ' in the backend; Default is 1 (Yes); to turn off, set to 0 (No)');
define('_MBL_MBDEFAULTNUMCOLUMNS', 'Default number of columns for check box and radio buttons; Default is 1');
define('_MBL_MBDEFAULTTEXTAREAWIDTH', 'Default textarea width (cols) for entering data; Default is 45');
define('_MBL_MBDEFAULTTEXTAREAHEIGHT', 'Default textarea height (rows) for entering data; Default is 3');
define('_MBL_MBSHOWDISPLAYINGWHATTITLE', 'Show ' . _MBL_RECORD_NAME . ' or ' . _MBL_CATEGORY_NAME . ' title(s) currently displayed at the top; Default is 1 (Yes); to turn off, set to 0 (No)');
define('_MBL_MBSHOWHTMLTITLETAGDATA', 'Show a Mad Blanks title (title of the HTML page) in the browser title bar; set to 0 to turn off, set to 1 for component title only, set to 2 for component title and ' . _MBL_CATEGORY_NAME . '/' . _MBL_RECORD_NAME . ' titles; Default is 2');
define('_MBL_MBCUSTOMTITLETEXT', 'HTML and/or text to show at the top of the page under the component title and \'showing what\' title; Mad Blanks special tags (including \'random\' and \'lookup\' tags) can be used in this field; Default is blank');
define('_MBL_MBFRONTENDINPUTFIELDSIZE', 'Size of input fields when editing ' . _MBL_RECORD_NAME_PLURAL . ' on the frontend; Default is 35');
define('_MBL_MBSHOWFOOTERCOMPONENTHOMELINK', 'Show link to the component home at the bottom of the page; Default is 1 (Yes); to turn off, set to 0 (No)');
define('_MBL_MBAPPLYCONTENTPLUGINS', 'Apply content plugins (mambots) to the rendered text of Mad Blanks; Default is 0 (disabled); to apply to each ' . _MBL_RECORD_NAME . ' separately, set to 1 (inefficient); to apply to all component or module output at once, set to 2 (most efficient)');
define('_MBL_MBHIDECHECKEDOUT', 'Hide ' . _MBL_RECORD_NAME_PLURAL . ' when they or their ' . _MBL_CATEGORY_NAME_PLURAL . ' are checked out and in the process of being edited. Default is 0 (No); to turn on, set to 1 (Yes)');
define('_MBL_MBWORDWRAPWIDTH', 'Force wrapping of data fields displayed by the component if they contain a word that exceeds this number of characters; Default is 75; To disable, set to 0');
define('_MBL_MBENABLEMAINSCREEN', 'Enable the main component screen on the front end? Default is 1 (Yes); to turn off, set to 0 (No)');

define('_MBL_MBENABLECREATESINGLERECORDLINKS', 'Enable the &quot;' . _MBL_CHOOSE_CSR_CATEGORY . '&quot; link on the main component screen on the front end? Default is 1 (Yes); to turn off, set to 0 (No)');
define('_MBL_MBCREATESINGLERECORDPOSITION', 'The module position given to the copy of the Mad Blanks Create Single Record module used for filling in quizzes/surveys via the component\'s menu; Default is <em>madblanks</em>');

define('_MBL_MBENABLESHOWALLLINK', 'Enable the "' . _MBL_SHOW_ALL . '" link on the main component screen on the front end? Default is 1 (Yes); to turn off, set to 0 (No)');
define('_MBL_MBENABLECATEGORIESLINKS', 'Enable the ' . _MBL_CATEGORY_NAME . ' links on the main component screen on the front end? Default is 1 (Yes); to turn off, set to 0 (No)');
define('_MBL_MBENABLERANDOMIZERLINKS', 'Enable the randomized records links on the main component screen on the front end? Default is 1 (Yes); to turn off, set to 0 (No)');
define('_MBL_MBENABLESPECIFICRECORDBOX', 'Enable the "Go to specific record id number" input box on the main component screen on the front end? Default is 1 (Yes); to turn off, set to 0 (No)');
define('_MBL_MBENABLEEDITRECORDSLINK', 'Enable the "' . _MBL_EDIT . ' ' . _MBL_RECORD_NAME_PLURAL . '" link on the main component screen on the front end? Default is 1 (Yes); to turn off, set to 0 (No)');
define('_MBL_MBEDITTHRESHOLD', 'Access level at which users have the ability to edit '. _MBL_RECORD_NAME_PLURAL . ' on the frontend; Default is 1 (special); to set to registered, set to 0');
define('_MBL_MBENABLERECORDLISTSHOWALL', 'Enable the "'. _MBL_SHOW_ALL . '" link when showing '. _MBL_RECORD_NAME_PLURAL . ' on the frontend (task=showmadblanks); Default is 1 (Yes); to turn off, set to 0 (No)');
define('_MBL_MBSTARTPAGE', 'Specify a Mad Blanks page that the component starts on; This consists of additional URI variables for this base URI: "' . str_replace('/administrator', '', JUri::base()) . 'index.php?option=com_madblanks&Itemid=x" where x is the Itemid (if available); Default is blank');
define('_MBL_MBMODULEWITHINCOMPONENTSTYLE', 'CSS declarations, separated by semicolons, for the DIV surrounding modules when they are included via the component using (in the URL) task=showmbmod and mid=[a comma-delimited list of module id numbers]; Default is blank');
define('_MBL_MBMODULEWITHINCOMPONENTCHROME', "Module chrome style for modules when they are included via the component using (in the URL) task=showmbmod and mid=[a comma-delimited list of module id numbers]; Default is -2; Choices are:

<ul>
<li>
Joomla! 1.5:
	<ul>
	<li><b>none</b> = No wrapping (raw output)</li>
	<li><b>table</b> = Wrapped by table (column)</li>
	<li><b>horz</b> = Wrapped by table (horizontal)</li>
	<li><b>xhtml</b> = Wrapped by Divs</li>
	<li><b>rounded</b> = Wrapped by Multiple Divs</li>
	<li><b>outline</b> = Add outline to the module (same effect as adding tp=1 to the URL)</li>
	</ul>
</li>
<li>
Joomla! 1.5 template-specific:
	<p>For each Joomla! 1.5 template, there is a file &lt;Joomla_root&gt;/templates/&lt;template_name&gt;/html/modules.php</p>
	 <p>If in that file for the template currently in use there are functions named modChrome_<em>STYLE</em>,
	 you can use <em>STYLE</em> as the chrome name, where STYLE is replaced with the actual function name.</p>
	
	 <p>For example, the JA_purity template has such a function named modChrome_jarounded,
	 so you can use <b>jarounded</b> as the chrome name.</p>
</li>
</ul>");
define('_MBL_MBMODULEWITHINCOMPONENTTYPES', 'Comma-delimited list of module types allowed to be included via the component using (in the URL) task=showmbmod and mid=[a comma-delimited list of module id numbers]; Default is <em>mod_madblanks_createsinglerecord,mod_madblanks_singlefieldinput,mod_madblanks_display,mod_madblanks_menu</em>');
define('_MBL_MBDEFAULTSEPARATOR1', 'Default ' . _MBL_CHECKBOX_SEPARATOR_1 . ' ONLY APPLIES TO NEW ' . JString::strtoupper(_MBL_CATEGORY_NAME_PLURAL) . '. Default is <em>,[:space:]</em>');
define('_MBL_MBDEFAULTSEPARATOR2', 'Default ' . _MBL_CHECKBOX_SEPARATOR_2 . ' ONLY APPLIES TO NEW ' . JString::strtoupper(_MBL_CATEGORY_NAME_PLURAL) . '. Default is <em>[:space:]and[:space:]</em>');

define('_MBL_MBDEFAULTSSEMAILFROM', "Default 'From' for emails sent from " . _MBL_SCORESCRIPT_NAME_PLURAL . "; This is a single email address, optionally followed by a semicolon and a name associated with the email address; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank, in which case the 'Mail From' email address and 'From Name' name in the Joomla! configuration are used as the default"); // added in 1.1.0b3
define('_MBL_MBDEFAULTSSEMAILTO', "Default 'To' for emails sent from " . _MBL_SCORESCRIPT_NAME_PLURAL . "; This is a single address or a comma-delimited list of email addresses; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank, in which case the 'Mail From' email address in the Joomla! configuration is used as the default"); // added in 1.1.0b3
define('_MBL_MBDEFAULTSSEMAILSUBJECT', "Default 'Subject' for emails sent from " . _MBL_SCORESCRIPT_NAME_PLURAL . "; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is <em>Mad Blanks Score Script</em>"); // added in 1.1.0b3
define('_MBL_MBDEFAULTSSEMAILBODY', "Default 'Body' for emails sent from " . _MBL_SCORESCRIPT_NAME_PLURAL . "; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank"); // added in 1.1.0b3
define('_MBL_MBDEFAULTSSEMAILMODE', "Default 'Mode' for emails sent from " . _MBL_SCORESCRIPT_NAME_PLURAL . ";  This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is 0 for plain text; to set to HTML, set to 1"); // added in 1.1.0b3
define('_MBL_MBDEFAULTSSEMAILCC', "Default 'CC' for emails sent from " . _MBL_SCORESCRIPT_NAME_PLURAL . "; This is a single address or a comma-delimited list of email addresses; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank"); // added in 1.1.0b3
define('_MBL_MBDEFAULTSSEMAILBCC', "Default 'BCC' for emails sent from " . _MBL_SCORESCRIPT_NAME_PLURAL . "; This is a single address or a comma-delimited list of email addresses; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank"); // added in 1.1.0b3
define('_MBL_MBDEFAULTSSEMAILATTACHMENT', "Default 'Attachment' for emails sent from " . _MBL_SCORESCRIPT_NAME_PLURAL . "; This is a single file name or a comma-delimited list of file names, the format of which are server-dependent; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank; WARNING: EMAIL ATTACHMENTS MUST BE EXPLICITLY ENABLED by commenting out a line in madblanks.class.php labeled with the following: \"WARNING: EMAIL ATTACHMENTS ARE DISABLED UNLESS THE NEXT LINE IS REMOVED OR COMMENTED OUT\""); // added in 1.1.0b3
define('_MBL_MBDEFAULTSSEMAILREPLYTO', "Default 'Reply To' for emails sent from " . _MBL_SCORESCRIPT_NAME_PLURAL . "; This is a single address or a comma-delimited list of email addresses; each email address can optionally be followed by a semicolon and a name associated with the email address; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank"); // added in 1.1.0b3
define('_MBL_MBDEFAULTSSEMAILSUCCESS', "Default success message for emails sent from " . _MBL_SCORESCRIPT_NAME_PLURAL . "; This text/HTML replaces the email special tag when sending the email is successful; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank"); // added in 1.1.0b3
define('_MBL_MBDEFAULTSSEMAILFAILURE', "Default failure message for emails sent from " . _MBL_SCORESCRIPT_NAME_PLURAL . "; This text/HTML replaces the email special tag when sending the email fails; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank"); // added in 1.1.0b3

define('_MBL_MBDEFAULTSSDATEFORMAT', "The default date/time format when using [:date:] tag in a Score Script; syntax is according to PHP's strftime function (see http://php.net/strftime); Default is blank, in which case DATE_FORMAT_LC2 will be used if available, or <b>%d %b %Y %I:%M %p</b> will be used"); // added in 1.1.0b3
define('_MBL_MBDEFAULTSSDATEADJUSTMENT', "Plain English time adjustment (offset) via PHP's strtotime function (see http://php.net/strtotime) for use with [:date:] tag in Score Scripts; useful if server is in different time zone than your website or server clock is incorrect and out of your control; Examples: &quot;-5 hours&quot; or &quot;+2min +25sec&quot;; Default is blank"); // added in 1.1.0b3

define('_MBL_MBACCEPTGOOGLECHARTTOS', '<pre>
     ***** ACCEPTANCE OF GOOGLE CHART API TERMS OF SERVICE (OPT-IN) *****
			
Mad Blanks features special tags as part of its Score Scripting architecture
 that allow you to visually graph aggregate results from the Mad Blanks records
 in a given category. You should understand that these charts are images that
 are generated remotely and served to your website by a service provided by
 Google.

In order to enable Google Charts for use in graphing data with Mad Blanks,
 you must accept the Google Chart API Terms of Service, available at
 <a href="http://code.google.com/apis/chart/terms.html" target="_blank">http://code.google.com/apis/chart/terms.html</a> (last accessed by the developer of 
 Mad Blanks on August 30, 2010).

You should also be aware of the following additional Usage Policy, published at
 <a href="http://code.google.com/apis/chart/docs/making_charts.html" target="_blank">http://code.google.com/apis/chart/docs/making_charts.html</a> (last accessed by the
 developer of Mad Blanks on August 30, 2010):

"There\'s no limit to the number of calls per day you can make to the Google Chart
 API. However, we reserve the right to block any use that we regard as abusive. If
 you think your service will make more than 250,000 API calls per day, please let
 us know by mailing an estimate to chart-api-notifications@google.com."

In the context of Mad Blanks, you are making an "API call" each time any Google
 Chart image is displayed to a user of your website in the output of a Mad Blanks
 Score Script. Even if the same image is displayed numerous times, each time it is
 displayed counts as one "API call".

TO ACCEPT THE GOOGLE CHART API TERMS OF SERVICE AND THE USAGE POLICY, change the
 value of the variable from \'NO\' to \'YES\'. Default is <em>NO</em></pre>');

define('_MBL_MBTIMEOUTDATATIMETOLIVE', 'Set the time delay after which timeout data for the ' . _MBL_SCORESCRIPT_NAME . ' <em>timeout</em> tag is removed from the <em>#__madblanks_timeout</em> table in the database. This should be at least twice as long as the longest desired timeout. The amount of time is given in plain English. (This configuration variable makes use of PHP\'s <em>strtotime()</em> function. See <a href="http://php.net/strtotime" target="_blank">http://php.net/strtotime</a> for details.) Default is <em>2 hours</em>; set to 0 (zero) to keep this data forever');
define('_MBL_MBADMINRECORDEDITRAWORFORM', 'When the administrator is editing ' . _MBL_RECORD_NAME_PLURAL . ' in the back end, set this to 0 (No) to allow raw editing with text fields only, or 1 (Yes) to enable editing with form controls as configured in the ' . _MBL_CATEGORY_NAME . ' (i.e. check boxes, radio buttons, pull down menus). The disadvantage of editing with form controls is that you cannot save a value other than one of the pre-configured responses; Default is 1 (Yes)');
define('_MBL_MBENABLEMAXPOSTORREQUESTVARSWARNING', 'Enable a warning on the category edit page when the web server may be configured to limit the number of POST or REQUEST variables (possibly due to Suhosin or similar software being installed on the web server); To enable the warning, set this to 1 (Yes); To disable the warning, set this to 0 (No); Default is 1 (Yes)');
define('_MBL_MBINCLUDECUSTOMIZATIONFILE', 'Include the customization file <em>&lt;Joomla_root&gt;/administrator/components/com_madblanks/madblanks.custom.php</em>; to include the file, set this to 1 (Yes); Default is 0 (No)');

define('_MBL_MASTER_CSS', 'CSS declarations, separated by semicolons, to apply to each ' . _MBL_RECORD_NAME . ' data field when displayed; use this, for example, to make filled in words bold and/or colored:');
define('_MBL_CONTAINER_DIV_CSS', 'CSS declarations, separated by semicolons, for the DIV surrounding the ' . _MBL_RECORD_NAME . ' when displayed in the component and modules; use this, for example, to apply a border, colors, margins, padding, and/or a background image with the appropriate CSS code:');

// Backend common to individual category and individual records screen
define('_MBL_CHANGE_CREATION_DATE', 'Change creation/entered date');
define('_MBL_CREATION_DATE_FORMAT', '(YYYY-MM-DD&nbsp;HH:MM:SS):'); // a text string to show the user how to enter the created date in MySQL format
define('_MBL_SHOW_CATEGORY_TITLE', 'show ' . _MBL_CATEGORY_NAME . ' title?');
define('_MBL_SHOW_INDIVIDUAL_TITLE', 'show individual title?');
define('_MBL_SHOW_ENTERED_BY', 'show who entered/authored by?');
define('_MBL_SHOW_DATE_CREATED', 'show date entered/created?');
define('_MBL_SHOW_MODIFIED_BY', 'show who modified by?');
define('_MBL_SHOW_MODIFIED_DATE', 'show date modified?');
define('_MBL_SHOW_SELF_LINK', 'show link back to the same ' . _MBL_RECORD_NAME . '?');
define('_MBL_SHOW_SELF_BUTTON', 'show randomize button that links back to the same ' . _MBL_RECORD_NAME . '?');
define('_MBL_SHOW_HOME_LINK_RANDOMIZED', 'show link to component home for randomized ' . _MBL_RECORD_NAME_PLURAL . '?');
define('_MBL_ALWAYSSHOWBEFOREANDAFTER', 'always show the before and after text, even if the field entry is blank?');
define('_MBL_SHOW_HOME_LINK', 'show link to component home?');
define('_MBL_NOTES_NOT_VISIBLE_ON_WEBSITE', 'Notes:<br />(not visible on website)');
define('_MBL_CHECKED_OUT_ERROR', 'The %1$s (%2$s) is currently being edited by another user (%3$s).');

// Category reference window
define('_MBL_OPEN', 'Open');
define('_MBL_CATEGORIES_REFERENCE', ucwords(_MBL_CATEGORY_NAME_PLURAL) . ' Reference');
define('_MBL_NO_CATEGORIES_TO_DISPLAY', 'No viewable ' . _MBL_CATEGORY_NAME_PLURAL . '.');
define('_MBL_CLOSE_WINDOW', 'Close Window');
define('_MBL_NO_PUBLISHED_CATEGORIES_TO_DISPLAY', 'No ' . _MBL_PUBLISHED . ' ' . _MBL_CATEGORY_NAME_PLURAL . ' to display.');
define('_MBL_NO_UNPUBLISHED_CATEGORIES_TO_DISPLAY', 'No ' . _MBL_UNPUBLISHED . ' ' . _MBL_CATEGORY_NAME_PLURAL . ' to display.');

// Class file functions
define('_MBL_GLOBAL', 'Global'); // used in class file-> getCurrentOptionSetting()
define('_MBL_CURRENT_GLOBAL_SETTING', 'Current global setting:'); // used in class file-> getCurrentOptionSetting()
define('_MBL_UNKNOWN', 'Unknown'); // used in class file-> getCurrentOptionSetting()
define('_MBL_UNKNOWN_ID', '<em>&lt;Unknown ID</em>&gt;'); // shows for non-admin users; use %s for the id number
define('_MBL_UNKNOWN_ID_ADMIN', '<em>&lt;Unknown ID: %s</em>&gt;'); // shows for admin users; use %s for the id number
define('_MBL_NO_ID_SPECIFIED', 'no id specified');
define('_MBL_AUTO_APPROVE', 'auto approve'); // name of user that automatically approves records

// Backend preview before saving screen
define('_MBL_PREVIEW_SCREEN', ucwords(_MBL_RECORD_NAME) . ' Preview'); // ucwords() does capitalization of all words in a string
define('_MBL_PREVIEW_NOTICE', 'The ' . _MBL_RECORD_NAME . ' appears below with formatting for its ' . _MBL_CATEGORY_NAME . ' (defined by the  per-field ' . _MBL_CATEGORY_NAME . ' settings <em>' . _MBL_BEFORE_TEXT . ' ' .  JString::strtolower(_MBL_FIELD_TEXT) . '</em> and <em>' . _MBL_AFTER_TEXT . ' ' .  JString::strtolower(_MBL_FIELD_TEXT) . '</em>) applied. The ' . _MBL_RECORD_NAME . ' will not be saved until you click the ' . _MBL_SAVE . ' button. To edit, click the ' . _MBL_EDIT . ' button.');

// Backend category list
define('_MBL_LIST_CATEGORIES_TITLE', 'List of ' . ucwords(_MBL_CATEGORY_NAME_PLURAL)); // ucwords() does capitalization of all words in a string
define('_MBL_CREATED_DATE', 'Created Date');
define('_MBL_NUMBER_OF_RECORDS', '# of Records');
define('_MBL_NO_ID', 'no id');

// Backend record list
define('_MBL_NO_AUTHOR', 'no author');
define('_MBL_NO_AUTHOR_LIST', '- No Author -');
define('_MBL_NO_DATA', 'no data');

// Backend common to category and record lists
define('_MBL_NO_DATE', 'unknown date');

// Backend common to category lists and various select lists
define('_MBL_NO_NAME', 'no name specified');

// Score Script characters for use with Score Script tag [:info:n:selected_index_alpha:]
define('_MBL_SELECTED_INDEX_ALPHA', 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz_');

// Backend record list
define('_MBL_LIST_RECORDS_TITLE', 'List of ' . ucwords(_MBL_RECORD_NAME_PLURAL)); // ucwords() does capitalization of all words in a string
define('_MBL_ALL_CATEGORIES', '- All ' . _MBL_CATEGORY_NAME_PLURAL . ' -');
define('_MBL_ALL_AUTHORS', '- All Authors -');
define('_MBL_CHOOSE_SORT_CRITERIA', '- Choose sort by criteria -');
define('_MBL_SORT_BY', 'Sort by:');
define('_MBL_SORT_ASCENDING', 'Sort ascending (low to high, A-Z)');
define('_MBL_SORT_DESCENDING', 'Sort descending (high to low, Z-A)');
define('_MBL_GO_TO_SPECIFIC_RECORD', 'Go to specific ' . _MBL_RECORD_NAME . ' id number:');
define('_MBL_SORT_PULLDOWN_ID', 'ID number');
define('_MBL_SORT_PULLDOWN_CONFIGID', _MBL_CATEGORY_NAME . ' ID');
define('_MBL_SORT_PULLDOWN_DATE_ENTERED', 'date entered');
define('_MBL_SORT_PULLDOWN_ENTERED_BY', 'entered/ authored by');
define('_MBL_SORT_PULLDOWN_AUTHOR_ALIAS', 'author alias');
define('_MBL_SORT_PULLDOWN_DATE_MODIFIED', 'date modified');
define('_MBL_SORT_PULLDOWN_MODIFIED_BY', 'modified by');
define('_MBL_SORT_PULLDOWN_TITLE', 'title');
define('_MBL_SORT_PULLDOWN_SHOW_CATEGORY_TITLE', 'show ' . _MBL_CATEGORY_NAME . ' title');
define('_MBL_SORT_PULLDOWN_SHOW_INDIVIDUAL_TITLE', 'show individual title');
define('_MBL_SORT_PULLDOWN_SHOW_ENTERED_BY', 'show entered by');
define('_MBL_SORT_PULLDOWN_SHOW_DATE_CREATED', 'show date created');
define('_MBL_SORT_PULLDOWN_SHOW_MODIFIED_BY', 'show modified by');
define('_MBL_SORT_PULLDOWN_SHOW_MODIFIED_DATE', 'show modified date');
define('_MBL_SORT_PULLDOWN_SHOW_SELF_LINK', 'show self link');
define('_MBL_SORT_PULLDOWN_SHOW_SELF_BUTTON', 'show randomize button');
define('_MBL_SORT_PULLDOWN_SHOW_HOME_LINK', 'show component home link');
define('_MBL_SORT_PULLDOWN_ALWAYSSHOWBEFOREANDAFTER', 'always show before and after text');
define('_MBL_SORT_PULLDOWN_COMPLETED', 'completed');
define('_MBL_SORT_PULLDOWN_APPROVED', 'approved');
define('_MBL_SORT_PULLDOWN_PUBLISHED', 'published');
define('_MBL_SORT_PULLDOWN_CHECKED_OUT', 'checked out');
define('_MBL_SORT_PULLDOWN_CHECKED_OUT_TIME', 'checked out time');
define('_MBL_SORT_PULLDOWN_SHOW_IN_RANDOM', 'use in randomized');
define('_MBL_SORT_PULLDOWN_STICKY', 'sticky (show at top of results)');
define('_MBL_SORT_PULLDOWN_ORDERING', 'ordering');
define('_MBL_SORT_PULLDOWN_DATA_01', 'data field 01');
define('_MBL_SORT_PULLDOWN_DATA_02', 'data field 02');
define('_MBL_SORT_PULLDOWN_DATA_03', 'data field 03');
define('_MBL_SORT_PULLDOWN_DATA_04', 'data field 04');
define('_MBL_SORT_PULLDOWN_DATA_05', 'data field 05');
define('_MBL_SORT_PULLDOWN_DATA_06', 'data field 06');
define('_MBL_SORT_PULLDOWN_DATA_07', 'data field 07');
define('_MBL_SORT_PULLDOWN_DATA_08', 'data field 08');
define('_MBL_SORT_PULLDOWN_DATA_09', 'data field 09');
define('_MBL_SORT_PULLDOWN_DATA_10', 'data field 10');
define('_MBL_SORT_PULLDOWN_DATA_11', 'data field 11');
define('_MBL_SORT_PULLDOWN_DATA_12', 'data field 12');
define('_MBL_SORT_PULLDOWN_DATA_13', 'data field 13');
define('_MBL_SORT_PULLDOWN_DATA_14', 'data field 14');
define('_MBL_SORT_PULLDOWN_DATA_15', 'data field 15');
define('_MBL_SORT_PULLDOWN_DATA_16', 'data field 16');
define('_MBL_SORT_PULLDOWN_DATA_17', 'data field 17');
define('_MBL_SORT_PULLDOWN_DATA_18', 'data field 18');
define('_MBL_SORT_PULLDOWN_DATA_19', 'data field 19');
define('_MBL_SORT_PULLDOWN_DATA_20', 'data field 20');
define('_MBL_SORT_PULLDOWN_DATA_21', 'data field 21');
define('_MBL_SORT_PULLDOWN_DATA_22', 'data field 22');
define('_MBL_SORT_PULLDOWN_DATA_23', 'data field 23');
define('_MBL_SORT_PULLDOWN_DATA_24', 'data field 24');
define('_MBL_SORT_PULLDOWN_DATA_25', 'data field 25');
define('_MBL_SORT_PULLDOWN_NOTES', 'notes');
define('_MBL_SORT_PULLDOWN_SESSION', 'session');
define('_MBL_SORT_PULLDOWN_SCODATA1', 'logged score script data 1');
define('_MBL_SORT_PULLDOWN_SCODATA2', 'logged score script data 2');
