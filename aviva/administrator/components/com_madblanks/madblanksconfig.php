<?php
/**
 * @package Mad_Blanks_Component
 * In single quoted strings, use \' for an apostrophe and \\ for a backslash
 */
$mbComponentTitle = 'Tests Component'; //Component title; Default is Mad Blanks Component
$mbFieldCount = 25; //Number of supported data fields in the component's tables (do not change this unless you have modified the #__madblanks_categories and #__madblanks_records tables in the Joomla! database AND the two class definitions MadBlanksCategory and MadBlanksRecord in the file madblanks.class.php); Default is 25
$mbColor1 = '#d3d3d3'; //First alternating row color for category reference window, examples: lightgray or #d3d3d3; Default is #d3d3d3
$mbColor2 = '#add8e6'; //Second alternating row color for category reference window, examples: lightblue or #add8e6; Default is #add8e6
$mbEnteredByLongFormat = 0; //User names for authors, set this to 0; Full names for authors, set this to 1 (Yes); Default is 0 (No)
$mbModifiedByLongFormat = 0; //User names for modified_by, set this to 0; Full names for modified_by, set this to 1 (Yes); Default is 0 (No)
$mbAllowBlankRandomFields = 0; //Allow blank fields to be used when assembling randomized results; Default is 0 (No); to turn on, set to 1 (Yes)
$mbDefaultRecordsPerPage = 15; //How many records to display per page on the frontend (changeable by user with pulldown menu); use 5, 10, 15, 20, 25, 30, or 50 to match one of the values on the pulldown menu; Default is 15
$mbDisplayResultNumbering = 0; //Show numbering of returned records in frontend? To turn on, set to 1 (Yes); Default is 0 (No)
$mbFrontendPageNavAlwaysOn = 0; //ALWAYS show pagination of returned records in frontend, regardless of how many there are; Default is 0 (No); to turn on, set to 1 (Yes)
$mbFeaturedRecords = ''; //Commma delimited list of specific records that are linked to from the component home; for example: 18 to link to record #18 or 1,5,12 to link to records #1, 5, and 12; links to records will appear in the order listed; Default is blank
$mbPreviewBeforeSave = 1; //Show preview before saving a record in the backend; Default is 1 (Yes); to turn off, set to 0 (No)
$mbDefaultNumColumns = 1; //Default number of columns for check box and radio buttons; Default is 1
$mbDefaultTextareaHeight = 3; //Default textarea height (rows) for entering data; Default is 3
$mbDefaultTextareaWidth = 45; //Default textarea width (cols) for entering data; Default is 45
$mbShowDisplayingWhatTitle = 1; //Show record or category title(s) currently displayed at the top; Default is 1 (Yes); to turn off, set to 0 (No)
$mbShowHTMLTitleTagData = 2; //Show a Mad Blanks title (title of the HTML page) in the browser title bar; set to 0 to turn off, set to 1 for component title only, set to 2 for component title and category/record titles; Default is 2
$mbCustomTitleText = 'Test your skills..'; //HTML and/or text to show at the top of the page under the component title and 'showing what' title; Mad Blanks special tags (including 'random' and 'lookup' tags) can be used in this field; Default is blank
$mbFrontendInputFieldSize = 35; //Size of input fields when editing records on the frontend; Default is 35
$mbShowFooterComponentHomeLink = 0; //Show link to the component home at the bottom of the page; Default is 1 (Yes); to turn off, set to 0 (No)
$mbApplyContentPlugins = 0; //Apply content plugins (mambots) to the rendered text of Mad Blanks; Default is 0 (disabled); to apply to each record separately, set to 1 (inefficient); to apply to all component or module output at once, set to 2 (most efficient)
$mbHideCheckedOut = 0; //Hide records when they or their categories are checked out and in the process of being edited. Default is 0 (No); to turn on, set to 1 (Yes)
$mbWordWrapWidth = 75; //Force wrapping of data fields displayed by the component if they contain a word that exceeds this number of characters; Default is 75; To disable, set to 0
$mbEnableMainScreen = 1; //Enable the main component screen on the front end? Default is 1 (Yes); to turn off, set to 0 (No)
$mbEnableCreateSingleRecordLinks = 1; //Enable the &quot;Choose a quiz or survey to fill out:&quot; link on the main component screen on the front end? Default is 1 (Yes); to turn off, set to 0 (No)
$mbCreateSingleRecordPosition = 'madblanks'; //The module position given to the copy of the Mad Blanks Create Single Record module used for filling in quizzes/surveys via the component's menu; Default is madblanks
$mbEnableShowAllLink = 1; //Enable the "Show all" link on the main component screen on the front end? Default is 1 (Yes); to turn off, set to 0 (No)
$mbEnableCategoriesLinks = 1; //Enable the category links on the main component screen on the front end? Default is 1 (Yes); to turn off, set to 0 (No)
$mbEnableRandomizerLinks = 1; //Enable the randomized records links on the main component screen on the front end? Default is 1 (Yes); to turn off, set to 0 (No)
$mbEnableSpecificRecordBox = 1; //Enable the "Go to specific record id number" input box on the main component screen on the front end? Default is 1 (Yes); to turn off, set to 0 (No)
$mbEnableEditRecordsLink = 1; //Enable the "Edit records" link on the main component screen on the front end? Default is 1 (Yes); to turn off, set to 0 (No)
$mbEditThreshold = 1; //Access level at which users have the ability to edit records on the frontend; Default is 1 (special); to set to registered, set to 0
$mbEnableRecordListShowAll = 1; //Enable the "Show all" link when showing records on the frontend (task=showmadblanks); Default is 1 (Yes); to turn off, set to 0 (No)
$mbStartPage = ''; //Specify a Mad Blanks page that the component starts on; This consists of additional URI variables for this base URI: "http://localhost/aviva/index.php?option=com_madblanks&Itemid=x" where x is the Itemid (if available); Default is blank
$mbModuleWithinComponentStyle = ''; //CSS declarations, separated by semicolons, for the DIV surrounding modules when they are included via the component using (in the URL) task=showmbmod and mid=[a comma-delimited list of module id numbers]; Default is blank
$mbModuleWithinComponentChrome = '-2'; /* Module chrome style for modules when they are included via the component using (in the URL) task=showmbmod and mid=[a comma-delimited list of module id numbers]; Default is -2; Choices are:



Joomla! 1.5:
	
	none = No wrapping (raw output)
	table = Wrapped by table (column)
	horz = Wrapped by table (horizontal)
	xhtml = Wrapped by Divs
	rounded = Wrapped by Multiple Divs
	outline = Add outline to the module (same effect as adding tp=1 to the URL)
	


Joomla! 1.5 template-specific:
	For each Joomla! 1.5 template, there is a file &lt;Joomla_root&gt;/templates/&lt;template_name&gt;/html/modules.php
	 If in that file for the template currently in use there are functions named modChrome_STYLE,
	 you can use STYLE as the chrome name, where STYLE is replaced with the actual function name.
	
	 For example, the JA_purity template has such a function named modChrome_jarounded,
	 so you can use jarounded as the chrome name.

*/
$mbModuleWithinComponentTypes = 'mod_madblanks_createsinglerecord,mod_madblanks_singlefieldinput,mod_madblanks_display,mod_madblanks_menu'; //Comma-delimited list of module types allowed to be included via the component using (in the URL) task=showmbmod and mid=[a comma-delimited list of module id numbers]; Default is mod_madblanks_createsinglerecord,mod_madblanks_singlefieldinput,mod_madblanks_display,mod_madblanks_menu
$mbDefaultSeparator1 = ',[:space:]'; //Default Separator (text/HTML) in between check box (or multiple choice menu) responses except the last two (this is used when displaying the user's multiple responses in text form; special tags can be used; for example, use ,[:space:] here): ONLY APPLIES TO NEW CATEGORIES. Default is ,[:space:]
$mbDefaultSeparator2 = '[:space:]and[:space:]'; //Default Separator (text/HTML) in between the last two check box (or multiple choice menu) responses (this is used when displaying the user's multiple responses in text form; special tags can be used; for example, use [:space:]and[:space:] here): ONLY APPLIES TO NEW CATEGORIES. Default is [:space:]and[:space:]
$mbDefaultSSEmailFrom = ''; //Default 'From' for emails sent from Score Scripts; This is a single email address, optionally followed by a semicolon and a name associated with the email address; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank, in which case the 'Mail From' email address and 'From Name' name in the Joomla! configuration are used as the default
$mbDefaultSSEmailTo = ''; //Default 'To' for emails sent from Score Scripts; This is a single address or a comma-delimited list of email addresses; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank, in which case the 'Mail From' email address in the Joomla! configuration is used as the default
$mbDefaultSSEmailSubject = 'Mad Blanks Score Script'; //Default 'Subject' for emails sent from Score Scripts; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is Mad Blanks Score Script
$mbDefaultSSEmailBody = ''; //Default 'Body' for emails sent from Score Scripts; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank
$mbDefaultSSEmailMode = '0'; //Default 'Mode' for emails sent from Score Scripts;  This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is 0 for plain text; to set to HTML, set to 1
$mbDefaultSSEmailCC = ''; //Default 'CC' for emails sent from Score Scripts; This is a single address or a comma-delimited list of email addresses; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank
$mbDefaultSSEmailBCC = ''; //Default 'BCC' for emails sent from Score Scripts; This is a single address or a comma-delimited list of email addresses; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank
$mbDefaultSSEmailAttachment = ''; //Default 'Attachment' for emails sent from Score Scripts; This is a single file name or a comma-delimited list of file names, the format of which are server-dependent; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank; WARNING: EMAIL ATTACHMENTS MUST BE EXPLICITLY ENABLED by commenting out a line in madblanks.class.php labeled with the following: "WARNING: EMAIL ATTACHMENTS ARE DISABLED UNLESS THE NEXT LINE IS REMOVED OR COMMENTED OUT"
$mbDefaultSSEmailReplyTo = ''; //Default 'Reply To' for emails sent from Score Scripts; This is a single address or a comma-delimited list of email addresses; each email address can optionally be followed by a semicolon and a name associated with the email address; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank
$mbDefaultSSEmailSuccess = ''; //Default success message for emails sent from Score Scripts; This text/HTML replaces the email special tag when sending the email is successful; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank
$mbDefaultSSEmailFailure = ''; //Default failure message for emails sent from Score Scripts; This text/HTML replaces the email special tag when sending the email fails; This field can contain special tags that would be found in a Score Script and resolve to the desired content; Default is blank
$mbDefaultSSDateFormat = ''; //The default date/time format when using [:date:] tag in a Score Script; syntax is according to PHP's strftime function (see http://php.net/strftime); Default is blank, in which case DATE_FORMAT_LC2 will be used if available, or %d %b %Y %I:%M %p will be used
$mbDefaultSSDateAdjustment = ''; //Plain English time adjustment (offset) via PHP's strtotime function (see http://php.net/strtotime) for use with [:date:] tag in Score Scripts; useful if server is in different time zone than your website or server clock is incorrect and out of your control; Examples: &quot;-5 hours&quot; or &quot;+2min +25sec&quot;; Default is blank
$mbAcceptGoogleChartTOS = 'NO'; /*
     ***** ACCEPTANCE OF GOOGLE CHART API TERMS OF SERVICE (OPT-IN) *****
			
Mad Blanks features special tags as part of its Score Scripting architecture
 that allow you to visually graph aggregate results from the Mad Blanks records
 in a given category. You should understand that these charts are images that
 are generated remotely and served to your website by a service provided by
 Google.

In order to enable Google Charts for use in graphing data with Mad Blanks,
 you must accept the Google Chart API Terms of Service, available at
 http://code.google.com/apis/chart/terms.html (last accessed by the developer of 
 Mad Blanks on August 30, 2010).

You should also be aware of the following additional Usage Policy, published at
 http://code.google.com/apis/chart/docs/making_charts.html (last accessed by the
 developer of Mad Blanks on August 30, 2010):

"There's no limit to the number of calls per day you can make to the Google Chart
 API. However, we reserve the right to block any use that we regard as abusive. If
 you think your service will make more than 250,000 API calls per day, please let
 us know by mailing an estimate to chart-api-notifications@google.com."

In the context of Mad Blanks, you are making an "API call" each time any Google
 Chart image is displayed to a user of your website in the output of a Mad Blanks
 Score Script. Even if the same image is displayed numerous times, each time it is
 displayed counts as one "API call".

TO ACCEPT THE GOOGLE CHART API TERMS OF SERVICE AND THE USAGE POLICY, change the
 value of the variable from 'NO' to 'YES'. Default is NO*/
$mbTimeoutDataTimeToLive = '2 hours'; //Set the time delay after which timeout data for the Score Script timeout tag is removed from the #__madblanks_timeout table in the database. This should be at least twice as long as the longest desired timeout. The amount of time is given in plain English. (This configuration variable makes use of PHP's strtotime() function. See http://php.net/strtotime for details.) Default is 2 hours; set to 0 (zero) to keep this data forever
$mbAdminRecordEditRawOrForm = 1; //When the administrator is editing records in the back end, set this to 0 (No) to allow raw editing with text fields only, or 1 (Yes) to enable editing with form controls as configured in the category (i.e. check boxes, radio buttons, pull down menus). The disadvantage of editing with form controls is that you cannot save a value other than one of the pre-configured responses; Default is 1 (Yes)
$mbEnableMaxPostOrRequestVarsWarning = 1; //Enable a warning on the category edit page when the web server may be configured to limit the number of POST or REQUEST variables (possibly due to Suhosin or similar software being installed on the web server); To enable the warning, set this to 1 (Yes); To disable the warning, set this to 0 (No); Default is 1 (Yes)
$mbIncludeCustomizationFile = 0; //Include the customization file &lt;Joomla_root&gt;/administrator/components/com_madblanks/madblanks.custom.php; to include the file, set this to 1 (Yes); Default is 0 (No)

?>
