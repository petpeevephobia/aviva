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
 * This file contains instructions for the special tags understood
 * by Mad Blanks that can be inserted into category fields.
 * This file is inserted into the category edit screen as a reference.
 * This file can be translated and copied to a file of the same name with
 * 'english' replaced by the new language in the filename.
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
?>

<b>Special tags:</b> These are available to use in the <?php echo ucwords(_MBL_SCORESCRIPT_NAME_PLURAL); ?>

<dl><!-- definition list -->

<dt><span style="color: blue;">[:quot:]</span></dt>
<dd>Quotation mark (HTML entity &#039;&amp;quot;&#039;; do not use a normal quotation mark unless it is part of an HTML tag)</dd>

<dt><span style="color: blue;">[:lquot:]</span></dt>
<dd>Literal quotation mark (as opposed to the HTML entity - see <b>[:quot:]</b>)</dd>

<dt><span style="color: blue;">[:space:]</span></dt>
<dd>Space (useful at the beginning or end of the field because normal spaces are trimmed off the ends)</dd>

<dt><span style="color: blue;">[:nbsp:]</span></dt>
<dd>Nonbreaking space (HTML entity &#039;&amp;nbsp;&#039;)</dd>

<dt><span style="color: blue;">[:lnbsp:]</span></dt>
<dd>Literal nonbreaking space (U+00A0 as opposed to the HTML entity - see <b>[:nbsp:]</b>)</dd>

<dt><span style="color: blue;">[:amp:]</span></dt>
<dd>Ampersand (HTML entity &#039;&amp;amp;&#039;)</dd>

<dt><span style="color: blue;">[:lamp:]</span></dt>
<dd>Literal ampersand (as opposed to the HTML entity - see <b>[:amp:]</b>)</dd>

<dt><span style="color: blue;">[:lt:]</span></dt>
<dd>Less-than sign (do not use a normal less-than sign unless it is part of an HTML tag)</dd>

<dt><span style="color: blue;">[:gt:]</span></dt>
<dd>Greater-than sign (do not use a normal greater-than sign unless it is part of an HTML tag)</dd>

<dt><span style="color: blue;">[:br:]</span></dt>
<dd>Linebreak (new line)</dd>

<dt><span style="color: blue;">[:curlyl:]</span></dt>
<dd>Left curly bracket <b>{</b></dd>

<dt><span style="color: blue;">[:curlyr:]</span></dt>
<dd>Right curly bracket <b>}</b></dd>

<dt><span style="color: blue;">[:colon:]</span></dt>
<dd>Colon</dd>

<dt><span style="color: blue;">[:random@<b><i>category_id</i></b>,<b><i>field</i></b>:]</span></dt>
<dd>

Insert the value from field number <b><i>field</i></b> in a record chosen at random in the category with id number 
<b><i>category_id</i></b>. You can provide multiple category/field pairs for the randomizer to choose from by separating them with
additional @ characters. Examples:<br /> To show a random entry for field seven in the category with id two: <tt>
<span style="color: blue;">[:random@2,7:]</span></tt><br /> To show a random entry for field nine in either the category with id two or the category with
id three: <tt><span style="color: blue;">[:random@2,9@3,9:]</span> </tt><br /> To show a random entry for field seven in category five, field four in
category ten, or field two in category one: <tt><span style="color: blue;">[:random@5,7@10,4@1,2:]</span></tt><br />

<p><b>Note:</b> Once a tag is used, the value that tag returned is remembered
for the rest of the record processing. Therefore, if you use the same tag again within the same record, the same result
will be returned. If you want to create a newly randomized result, you must use a different tag. For example, instead of
using <tt><span style="color: blue;">[:random@2,7:]</span></tt> again, use <tt><span style="color: blue;">[:random@2,7@2,7:]</span></tt>.</p>

<p><b><a href="javascript: popupWindow( '<?php echo JUri::base(); ?>/administrator/index3.php?option=com_madblanks&amp;task=showreferencewindow', 'madblankscatref', screen.width/2, screen.height*0.667, 'yes' );">Click this link to open the <?php echo _MBL_CATEGORY_NAME_PLURAL;?> reference window.</a></b></p>
</dd>

<dt><span style="color: blue;">[:lookup@<b><i>record_id</i></b>,<b><i>field</i></b>:]</span></dt>
<dd>

<p>Insert the looked up value from record number <b><i>record_id</i></b> and field number <b><i>field</i></b> within that
record. You can use the keyword <b>this</b> in place of a record id number to refer to the currently displayed record. You
can also use <b>scodata<em>N</em></b>, (where <em><b>N</b></em> is normally 1 or 2) in place of a field number to look up
data that was logged in the record by a Score Script.<br />

<br />Examples:<br />To show the entry in record
#123 for field seven: <tt><span style="color: blue;">[:lookup@123,7:]</span></tt><br />To show the entry for field nine of the currently displayed record:
<tt><span style="color: blue;">[:lookup@this,9:]</span></tt></p>

<p>Note that the looked up value will appear exactly as it does in the looked up field, including the effects of any
field text formatting functions that may have been applied. To override the field text formatting functions that were
applied to the original and to optionally apply new field text formatting functions, append an additional argument within
the lookup tag as follows:</p>

<p><tt><span style="color: blue;">[:lookup@<b><i>record_id</i></b>,<b><i>field</i></b>,<b><i>nnnn</i></b>:]</span></tt></p>

<p>Here, each n is a zero or a one. All four digits as zeroes will cause <b>no</b> field text formatting functions to be
applied.
<br>The first n, set to 1, will cause &quot;<?php echo _MBL_APPLY_FORMATTING_STRTOUPPER;?>&quot; to be applied to the looked up value.
<br>The second n, set to 1, will cause &quot;<?php echo _MBL_APPLY_FORMATTING_STRTOLOWER;?>&quot; to be applied to the looked up value.
<br>The third n, set to 1, will cause &quot;<?php echo _MBL_APPLY_FORMATTING_UCWORDS;?>&quot; to be applied to the looked up value.
<br>The fourth n, set to 1, will cause &quot;<?php echo _MBL_APPLY_FORMATTING_UCFIRST;?>&quot; to be applied to the looked up value.</p>

<p>Examples:<br />To show the entry in record
#123 for field seven with <b>no</b> field text formatting functions applied, even though they may be applied in the
original field: <tt><span style="color: blue;">[:lookup@123,7,0000:]</span></tt><br />To show the entry for field nine of the currently displayed record,
with &quot;<?php echo _MBL_APPLY_FORMATTING_UCWORDS;?>&quot; applied: <tt><span style="color: blue;">[:lookup@this,9,0010:]</span></tt></p> </dd>

<dt><span style="color: blue;">[:mostrecentlookup@<b><i>field</i></b>,<b><i>category (optional)</i></b>,<b><i>user_name</i></b> OR <b><i>user_id</i></b> OR <b>any</b> OR <b>currentsession</b> OR <b>userorsession <i>(optional)</i></b>,<b><i>format (optional)</i></b>:]</span></dt>
<dd>

<p>Insert the looked up value from a field in the most recently added record <b>that is completed, approved, and published</b>
in a certain category, either by the currently logged in user, any user/no user, a specified user, or from the current
session. You can also use the keyword <i>this</i> in place of the category or the
user_id to refer to the category currently being used or the currently logged-in user, respectively.</p>

<p>Examples:<br />To show the contents of field three in the most recently saved record in the current category by the
currently logged-in user, or by any user or no user (<i>no author</i>) if there is no user currently logged in: <tt><span
style="color: blue;"> [:mostrecentlookup@3:] </span></tt><br />To show the contents of field seven for the most recently
saved record that is completed, approved, and published by the currently logged-in user, or by any user or no user (<i>no
author</i>) if there is no user currently logged in, in category ten: <tt><span style="color: blue;">
[:mostrecentlookup@7,10:] </span></tt> <br />To show the contents of field twenty-five for the record most recently saved by
the user with username <i>user1</i> in category five: <tt> <span style="color: blue;">[:mostrecentlookup@25,5,user1:]</span>
</tt><br />To show the contents of field fourteen for the record most recently saved in the current session in category
seven: <tt><span style="color: blue;"> [:mostrecentlookup@14,7,currentsession:]</span></tt><br />To show the contents of
field fifteen for the record most recently saved by the current user if logged in, OR in the current session if no user is
logged in, in category eight: <tt><span style="color: blue;"> [:mostrecentlookup@15,8,userorsession:]</span></tt><br />Note
that the <i> user_id</i> can also be Joomla!'s id number for the user: <tt><span style="color: blue;">
[:mostrecentlookup@25,5,63:]</span></tt><br />To show the contents of field three in the most recently saved record in the
current category by <b>any user</b> or <b>no user</b> (anonymous), even if there <b>is </b> a currently logged-in user: <tt>
<span style="color: blue;"> [:mostrecentlookup@3,this,any:]</span></tt></p>

<p>Note that in the above examples, the looked up value will appear exactly as it does in the looked up field, including the effects
of any field text formatting functions that may have been applied. To override the field text formatting functions that were applied
to the original and to optionally apply new field text formatting functions, append an additional argument within the
mostrecentlookup tag as follows:</p>

<p><tt><span style="color: blue;">[:mostrecentlookup@<b><i>field</i></b>,<b><i>category</i></b>,<b><i>user_id</i></b>,<b><i>nnnn</i></b>:]</span></tt></p>

<p>Here, each n is a zero or a one. All four digits as zeroes will cause <b>no</b> field text formatting functions to be
applied.
<br>The first n, set to 1, will cause &quot;<?php echo _MBL_APPLY_FORMATTING_STRTOUPPER;?>&quot; to be applied to the looked up value.
<br>The second n, set to 1, will cause &quot;<?php echo _MBL_APPLY_FORMATTING_STRTOLOWER;?>&quot; to be applied to the looked up value.
<br>The third n, set to 1, will cause &quot;<?php echo _MBL_APPLY_FORMATTING_UCWORDS;?>&quot; to be applied to the looked up value.
<br>The fourth n, set to 1, will cause &quot;<?php echo _MBL_APPLY_FORMATTING_UCFIRST;?>&quot; to be applied to the looked up value.</p>

<p>Examples:<br />To show the contents of field three in the most recently saved record in the current category by the
currently logged-in user, or by no user (<i>no author</i>) if there is no user currently logged in, with <b>no</b> field text
formatting functions applied, even though they may be applied in the original field: <tt> <span style="color: blue;">
[:mostrecentlookup@3,this,this,0000:]</span></tt><br />To show the contents of field twenty-five in the record most recently
saved in category five by the user with username <i>user1</i>, with &quot;<?php echo _MBL_APPLY_FORMATTING_STRTOLOWER;?>
&quot; applied: <tt><span style="color: blue;">[:mostrecentlookup@25,5,user1,0100:] </span> </tt> </p> </dd>

<dt><span style="color: blue;">[:comment:&lt;start&gt;:]</span>Some comment text<span style="color: blue;">[:comment:&lt;end&gt;:]</span></dt>
<dd>A comment</dd>

<dt><span style="color: blue;">[:category_id:]</span></dt>
<dd>The ID number of the category</dd>

<dt><span style="color: blue;">[:category_name:]</span></dt>
<dd>The name of the category</dd>

<dt><span style="color: blue;">[:record_id:]</span></dt>
<dd>The id number of the record that is currently being scored (available if the Create Single Record module parameter labeled <b>Save the record inputted by the user?</b> is set to <em>Save in the database</em>)</dd>

<dt><span style="color: blue;">[:scorescript_id:]</span></dt>
<dd>The ID number of the Score Script</dd>

<dt><span style="color: blue;">[:csr_module_id:]</span></dt>
<dd>The Joomla! ID number of the Mad Blanks Create Single Record module that was used to present the form to the user</dd>

<dt><span style="color: blue;">[:number_of_correct_answers:]</span></dt>
<dd>The number of questions the user answered <b>correctly</b></dd>

<dt><span style="color: blue;">[:number_of_incorrect_answers:]</span></dt>
<dd>The number of questions the user answered <b>incorrectly</b></dd>

<dt><span style="color: blue;">[:total_answers_in_category:]</span></dt>
<dd>The number of questions in the category that have correct answers</dd>

<dt><span style="color: blue;">[:ratio_correct:]</span></dt>
<dd>The number of correct responses divided by the number of questions with correct answers</dd>

<dt><span style="color: blue;">[:percentage_correct:]</span></dt>
<dd>The number of correct responses divided by the number of questions with correct answers, expressed as a rounded whole number percentage</dd>

<dt><span style="color: blue;">[:total_points_earned_a:]</span></dt>
<dd>The total type A points earned by the user for the entire quiz (type A point values are specified <b>per question</b>)</dd>

<dt><span style="color: blue;">[:total_points_possible_a:]</span></dt>
<dd>The total possible type A points that the user can earn</dd>
    	
<dt><span style="color: blue;">[:points_ratio_a:]</span></dt>
<dd>The number of type A points earned divided by the number of type A points possible to earn</dd>

<dt><span style="color: blue;">[:points_percentage_a:]</span></dt>
<dd>The number of type A points earned divided by the number of type A points possible to earn, expressed as a rounded whole number percentage</dd>

<dt><span style="color: blue;">[:total_points_b:]</span></dt>
<dd>The total type B points from all selected answers in every question (point values that are specified for each <b>response</b> to a particular question)</dd>

<dt><span style="color: blue;">[:total_points_earned_b:]</span></dt>
<dd>The total type B points from all correct questions (point values that are specified for each <b>response</b> to a particular question)</dd>

<dt><span style="color: blue;">[:total_points_all_correct_b:]</span></dt>
<dd>The total type B points the user would earn if only correct answers for all questions are all selected</dd>

<dt><span style="color: blue;">[:total_points_correct_ratio_b:]</span></dt>
<dd>The total type B points from all correct questions divided by total type B points the user would earn if all answers were answered correctly</dd>

<dt><span style="color: blue;">[:total_points_correct_percentage_b:]</span></dt>
<dd>The total type B points from all correct questions divided by total type B points the user would earn if all answers were answered correctly, expressed as a rounded whole number percentage</dd>

<dt><span style="color: blue;">[:total_sum_all_points_b:]</span></dt>
<dd>The sum of all type B points from every option in every question</dd>

<dt><span style="color: blue;">[:total_accrued_sum_ratio_b:]</span></dt>
<dd>The actual accrued type B points divided by the sum of all type B points from every option in every question</dd>

<dt><span style="color: blue;">[:total_accrued_sum_percentage_b:]</span></dt>
<dd>The actual accrued type B points divided by the sum of all type B points from every option in every question, expressed as a rounded whole number percentage</dd>

<dt><span style="color: blue;">[:printf:<b><i>xyz</i></b>:&lt;start&gt;:]</span>String to be formatted with PHP's printf() function<span style="color: blue;">[:printf:&lt;end&gt;:]</span></dt>
<dd>

<p>Format the string between the opening and closing tags according to the format <b><i>xyz</i></b>. The syntax is
the same as that used by PHP's printf() and sprintf() functions.
See <a href="http://php.net/sprintf" target="_blank">http://php.net/sprintf</a> for format syntax.</p>

<p>One use of this feature is to format a number with leading or trailing zeroes. Examples:</p>

<p>[:printf:%07.1f:&lt;start&gt;:]497.1[:printf:&lt;end&gt;:] => displays as 00497.1</p>
<p>[:printf:%01.2f:&lt;start&gt;:]497.1[:printf:&lt;end&gt;:] => displays as 497.10</p>

</dd>

<!-- added in 1.4.2 -->
<dt><span style="color: blue;">[:filter:<b><i>filter_name</i></b>:&lt;start&gt;:]</span>String to be filtered<span style="color: blue;">[:filter:&lt;end&gt;:]</span></dt>
<dd>

<p>Filter the content between the opening and closing tags according to the filter name <b><i>xyz</i></b>.
Supported filters are:</p>

	<dl>

	<dt>no_html</dt>
	<dd>Remove all HTML and PHP tags</dd>

	<dt>database_escape</dt>
	<dd>Make a string safe for use in a database query</dd>

	<dt>no_whitespace</dt>
	<dd>Remove all whitespace (spaces, tabs, newlines, etc.)</dd>

	<dt>no_whitespace_outside_tags</dt>
	<dd>Remove all whitespace outside of HTML and Score Script tags</dd>

	</dl>
	
<p>More than one filter can be applied by separating filter names with <b>|</b></p>

</dd>


<dt><span style="color: blue;">[:redirect:&lt;<b><i>xyz</i></b>&gt;:]</span></dt>
<dd>Redirect to relative or absolute URL <b><i>xyz</i></b>.</dd>

<dt><span style="color: blue;">[:nextcategory:<b><i>n</i></b>:]</span></dt> <dd>After displaying the current Score
Script, automatically direct the Create Single Record module to take input for category number <b><i>n</i></b> next.
If <b><i>n</i></b> is <b>0</b> (zero), show no further categories. Use this feature to string together multiple
quizzes or surveys one after another.<br /><br />Optionally use <span style="color: blue;">[:nextcategory:<b><i>n</i></b>:&lt;data_<b><i>XX</i></b>=<b><i>Y</i></b>&gt;:]</span>, where <b><i>XX</i></b> is a field ID number (with leading zero
if needed) and <b><i>Y</i></b> is the value of that data field to be preloaded when the next category loads<br /><br
/> Example 1: [:nextcategory:2:&lt;data_01=hello&gt;:] =&gt; load category 2 next with data_01 pre-filled with the value hello
when the category loads <br /><br /> Example 2: [:nextcategory:3:&lt;data_01=hello&amp;data_02=123&gt;:] =&gt; load category 3
next with data_01 pre-filled with the value <em>hello</em> and data_02 pre-filled with the value <em>123</em> when
the category loads

</dd>

<dt><span style="color: blue;">[:info:<b><i>n</i></b>:<b><i>tagname</i></b>:]</span></dt>
<dd><p>This is a piece of information about question/user response number <b><i>n</i></b>.
Replace <b><i>tagname</i></b> with any of the following:</p>
	<dl>
	<dt>name</dt>
	<dd>The name of the field (the question or prompt to the user)</dd>
	<!-- Removed in 1.1.0rc3 dt>partofspeech</dt>
	<dd>The &quot;part of speech hint&quot; for the field</dd -->
	<dt>cluecuehint</dt>
	<dd>The clue/cue/hint for the field</dd>
	<dt>beforetext</dt>
	<dd>The text that comes before the user's response</dd>
	<dt>aftertext</dt>
	<dd>The text that comes after the user's response</dd>
	<dt>user_response</dt>
	<dd>The user's response to this question or prompt</dd>
	<dt>user_response_raw</dt>
	<dd>The user's response to this question or prompt before processing the multiple response separators</dd>
	<dt>points_b</dt>
	<dd>The sum of the type B point values of the user's selected responses for this question</dd>
	<dt>points_b_sum</dt>
	<dd>The sum of the type B point values of all the configured responses for this question or prompt</dd>
	<dt>points_b_max</dt>
	<dd>The type B point value of the configured response with the highest point value</dd>
	<dt>points_b_min</dt>
	<dd>The type B point value of the configured response with the lowest point value</dd>
	<dt>points_b_avg</dt>
	<dd>The average type B point value of all the configured responses</dd>
	<dt>points_b_avg_integer</dt>
	<dd>The average type B value of all the configured responses, rounded to the nearest integer</dd>
	<dt>possible_choice:<b><i>m</i></b></dt>
	<dd>The <b><i>mth</i></b> possible response to the question (from the &quot;List the options to be shown for multiple choice&quot; list)</dd>
	<dt>possible_choice_selected:<b><i>m</i></b></dt>
	<dd>If the <b><i>mth</i></b> possible response to the question (from the &quot;List the options to be shown for multiple choice&quot; list) was actually selected by the user, this is <b>1</b> (one). If it was not actually selected by the user, this is <b>0</b> (zero).</dd>
	<dt>point_value_b:<b><i>m</i></b></dt>
	<dd>The point value for the <b><i>mth</i></b> possible response to the question (from the &quot;Type B points&quot; list)</dd>
	<dt>in_subset</dt>
	<dd>This is <b>1</b> if the field is part of the subset or <b>0</b> otherwise</dd>
	<!-- Below added in 1.4.2 20110227 -->
	<dt>selected_index</dt>
	<dd>When using radio buttons or the pulldown menu, this will be <b>1</b> if the 1st possible choice was selected, <b>2</b> if the 2nd possible choice was selected, <b>3</b> if the 3rd possible choice was selected, etc., or <b>0</b> if no choice was selected; note that only one index is given, even if more than one is selected, so this is best used with radio buttons or the pulldown menu</dd>
	<dt>selected_index_padded</dt>
	<dd>The same as <em>selected_index</em>, except that the given value is always two digits, with a leading zero added if necessary; note that only one index is given, even if more than one is selected, so this is best used with radio buttons or the pulldown menu</dd>
	<dt>selected_index_alpha</dt>
	<dd>The same as <em>selected_index</em>, except that letters are used instead of numbers; this is customizable via the language file value <em>_MBL_SELECTED_INDEX_ALPHA</em>; by default, this will be <b>A</b> if the 1st possible choice was selected, <b>B</b> if the 2nd possible choice was selected, <b>C</b> if the 3rd possible choice was selected, etc., or <b>0</b> if no choice was selected; note that only one index is given, even if more than one is selected, so this is best used with radio buttons or the pulldown menu</dd>
	<dt>selected_count</dt>
	<dd>The number of responses that were selected from the possible choices, useful when used with check boxes or the multiple choice menu</dd>
	</dl>
</dd>

<dt><span style="color: blue;">[:answer:<b><i>n</i></b>:<b><i>tagname</i></b>:]</span></dt>
<dd><p>This is a piece of information about question/user response number <b><i>n</i></b>, which has a correct answer.</p>
<p><span style="font-weight: bold; background-color: yellow;">If a Mad Blanks field does not have a
&quot;Correct response&quot; defined on the category edit page, this tag will not be available for that field.</span></p>
<p>Replace <b><i>tagname</i></b> with any of the following:</p>
	<dl>
	<dt>name</dt>
	<dd>The name of the field (the question or prompt to the user)</dd>
	<!-- Removed in 1.1.0rc3 dt>partofspeech</dt>
	<dd>The &quot;part of speech hint&quot; for the field</dd -->
	<dt>cluecuehint</dt>
	<dd>The clue/cue/hint for the field</dd>
	<dt>beforetext</dt>
	<dd>The text that comes before the user's response</dd>
	<dt>aftertext</dt>
	<dd>The text that comes after the user's response</dd>
	<dt>correct_value</dt>
	<dd>The correct response to this question or prompt</dd>
	<dt>correct_value_raw</dt>
	<dd>The correct response to this question or prompt before processing the multiple response separators</dd>
	<dt>correct_case_sensitive</dt>
	<dd>If the correct response to this question or prompt must be entered with exact case, this is <b>1</b> (one); if the response does not need to match case exactly, this is <b>0</b> (zero)</dd>
	<dt>user_response</dt>
	<dd>The user's response to this question or prompt</dd>
	<dt>user_response_raw</dt>
	<dd>The user's response to this question or prompt before processing the multiple response separators</dd>
	<dt>is_correct</dt>
	<dd>This is <b>1</b> (one) if the user's response is correct and <b>0</b> (zero) if the user's response is incorrect</dd>
	<dt>points_possible_a</dt>
	<dd>The type A (per question) points possible to earn for this question</dd>
	<dt>points_earned_a</dt>
	<dd>The number of type A (per question) points the user earned for this question/response (applies if user answered correctly, otherwise this is 0 [zero])</dd>
	<dt>points_earned_b</dt>
	<dd>The number of type B (per response) points the user earned for this question/response (applies if user answered correctly, otherwise this is 0 [zero])</dd>
	<dt>in_subset</dt>
	<dd>This is <b>1</b> if the field is part of the subset or <b>0</b> otherwise</dd>
	<!-- Below added in 1.4.2 20110227 -->
	<dt>selected_index</dt>
	<dd>When using radio buttons or the pulldown menu, this will be <b>1</b> if the 1st possible choice was selected, <b>2</b> if the 2nd possible choice was selected, <b>3</b> if the 3rd possible choice was selected, etc., or <b>0</b> if no choice was selected; note that only one index is given, even if more than one is selected, so this is best used with radio buttons or the pulldown menu</dd>
	<dt>selected_index_padded</dt>
	<dd>The same as <em>selected_index</em>, except that the given value is always two digits, with a leading zero added if necessary; note that only one index is given, even if more than one is selected, so this is best used with radio buttons or the pulldown menu</dd>
	<dt>selected_index_alpha</dt>
	<dd>The same as <em>selected_index</em>, except that letters are used instead of numbers; this is customizable via the language file value <em>_MBL_SELECTED_INDEX_ALPHA</em>; by default, this will be <b>A</b> if the 1st possible choice was selected, <b>B</b> if the 2nd possible choice was selected, <b>C</b> if the 3rd possible choice was selected, etc., or <b>0</b> if no choice was selected; note that only one index is given, even if more than one is selected, so this is best used with radio buttons or the pulldown menu</dd>
	<dt>selected_count</dt>
	<dd>The number of responses that were selected from the possible choices, useful when used with check boxes or the multiple choice menu</dd>
	<dt>possible_choice:<b><i>m</i></b></dt>
	<dd>The <b><i>mth</i></b> possible response to the question (from the &quot;List the options to be shown for multiple choice&quot; list)</dd>
	<dt>possible_choice_selected:<b><i>m</i></b></dt>
	<dd>If the <b><i>mth</i></b> possible response to the question (from the &quot;List the options to be shown for multiple choice&quot; list) was actually selected by the user, this is <b>1</b> (one). If it was not actually selected by the user, this is <b>0</b> (zero).</dd>
	<dt>possible_choice_correct:<b><i>m</i></b></dt>
	<dd>For use with check boxes or the multiple choice menu: If the <b><i>mth</i></b> possible response to the question (from the &quot;List the options to be shown for multiple choice&quot; list) was individually correct, this is <b>1</b> (one), otherwise, this is <b>0</b> (zero). Note that it is possible for a check box to be considered correct (1) when it is not checked.</dd>
	</dl>
</dd>
<dt><span style="color: blue;">[:answers_correct:<b><i>n</i></b>:&lt;start&gt;:]</span>Some HTML/text that may include other special tags<span style="color: blue;">[:answers_correct:<b><i>n</i></b>:&lt;end&gt;:]</span></dt>
<dd>
<p>When the number of correct answers is <b><i>n</i></b> in the quiz response to be scored, display the HTML/text in
between these two tags. The text may include other special tags. Examples:</p>
<p>
<tt><span style="color: blue;">[:answers_correct:0:&lt;start&gt;:]</span></tt>&lt;p&gt;Because you answered ZERO questions correctly, you are seeing this.&lt;/p&gt;<tt><span style="color: blue;">[:answers_correct:0:&lt;end&gt;:]</span></tt><br />
<tt><span style="color: blue;">[:answers_correct:2:&lt;start&gt;:]</span></tt>&lt;p&gt;Because you answered TWO questions correctly, you are seeing this.&lt;/p&gt;<tt><span style="color: blue;">[:answers_correct:2:&lt;end&gt;:]</span></tt>
</p>
</dd>

<dt><span style="color: blue;">[:points_a_range:<b><i>n<sub>1</sub></i></b>-<b><i>n<sub>2</sub></i></b>:&lt;start&gt;:]</span>Some HTML/text that may include other special tags<span style="color: blue;">[:points_a_range:<b><i>n<sub>1</sub></i></b>-<b><i>n<sub>2</sub></i></b>:&lt;end&gt;:]</span></dt>
<dd>
<p>When the type A points earned as determined by the category setup is in the range including <b><i>n<sub>1</sub></i></b>-<b><i>n<sub>2</sub></i></b>,
display the HTML/text in between these two tags. The text may include other special tags. Examples:</p>
<p>
<tt><span style="color: blue;">[:points_a_range:0-49:&lt;start&gt;:]</span></tt>&lt;p&gt;Because you earned between zero and forty nine points, you are seeing this.&lt;/p&gt;<tt><span style="color: blue;">[:points_a_range:0-49:&lt;end&gt;:]</span></tt><br />
<tt><span style="color: blue;">[:points_a_range:900-950:&lt;start&gt;:]</span></tt>&lt;p&gt;Because you earned between nine hundred and nine hundred fifty points, you are seeing this.&lt;/p&gt;<tt><span style="color: blue;">[:points_a_range:900-950:&lt;end&gt;:]</span></tt>
</p>
</dd>

<dt><span style="color: blue;">[:points_b_range:<b><i>n<sub>1</sub></i></b>-<b><i>n<sub>2</sub></i></b>:&lt;start&gt;:]</span>Some HTML/text that may include other special tags<span style="color: blue;">[:points_b_range:<b><i>n<sub>1</sub></i></b>-<b><i>n<sub>2</sub></i></b>:&lt;end&gt;:]</span></dt>
<dd>
<p>When the type B points earned as determined by the category setup is in the range including <b><i>n<sub>1</sub></i></b>-<b><i>n<sub>2</sub></i></b>,
display the HTML/text in between these two tags. The text may include other special tags. Examples:</p>
<p>
<tt><span style="color: blue;">[:points_b_range:0-49:&lt;start&gt;:]</span></tt>&lt;p&gt;Because you earned between zero and forty nine points, you are seeing this.&lt;/p&gt;<tt><span style="color: blue;">[:points_b_range:0-49:&lt;end&gt;:]</span></tt><br />
<tt><span style="color: blue;">[:points_b_range:900-950:&lt;start&gt;:]</span></tt>&lt;p&gt;Because you earned between nine hundred and nine hundred fifty points, you are seeing this.&lt;/p&gt;<tt><span style="color: blue;">[:points_b_range:900-950:&lt;end&gt;:]</span></tt>
</p>
</dd>

<dt><span style="color: blue;">[:custom_range:{<b><em>input</em></b>}:<b><i>n<sub>1</sub></i></b>-<b><i>n<sub>2</sub></i></b>:&lt;start&gt;:]</span>Some HTML/text that may include other special tags<span style="color: blue;">[:custom_range:<b><i>n<sub>1</sub></i></b>-<b><i>n<sub>2</sub></i></b>:&lt;end&gt;:]</span></dt>
<dd>
<p>When the <b><em>input</em></b> is in the range including <b><i>n<sub>1</sub></i></b>-<b><i>n<sub>2</sub></i></b>,
display the HTML/text in between these two tags. The text may include other special tags. Examples:</p>
<p>
<tt><span style="color: blue;">[:custom_range:{450}:900-950:&lt;start&gt;:]</span></tt>&lt;p&gt;If 450 were in the range including 900-950, you would see this. (Since it is not, you won't see any output here.)&lt;/p&gt;<tt><span style="color: blue;">[:custom_range:900-950:&lt;end&gt;:]</span></tt><br />
<tt><span style="color: blue;">[:custom_range:{[:percentage_correct:]}:0-49:&lt;start&gt;:]</span></tt>&lt;p&gt;If the percentage correct is between 0 and 49 inclusive, you are seeing this.&lt;/p&gt;<tt><span style="color: blue;">[:custom_range:0-49:&lt;end&gt;:]</span></tt>
</p>
</dd>

<dt><span style="color: blue;">[:answer:<b><i>n</i></b>:&lt;start_correct&gt;:]</span>Some HTML/text that may include other special tags<span style="color: blue;">[:answer:<b><i>n</i></b>:&lt;end_correct&gt;:]</span></dt>
<dd>
<p>
When the response for field number <b><i>n</i></b> is <b>correct</b>, display the text in between these two tags.
The text may include other special tags. Examples:</p>
<p>
<tt><span style="color: blue;">[:answer:5:&lt;start_correct&gt;:]</span></tt>&lt;p&gt;Your answer to question number five was correct.&lt;/p&gt;<tt><span style="color: blue;">[:answer:5:&lt;end_correct&gt;:]</span></tt><br />
<tt><span style="color: blue;">[:answer:10:&lt;start_correct&gt;:]</span></tt>&lt;p&gt;Your answer to question number ten was correct.&lt;/p&gt;<tt><span style="color: blue;">[:answer:10:&lt;end_correct&gt;:]</span></tt>
</p>
</dd>

<dt><span style="color: blue;">[:answer:<b><i>n</i></b>:&lt;start_incorrect&gt;:]</span>Some HTML/text that may include other special tags<span style="color: blue;">[:answer:<b><i>n</i></b>:&lt;end_incorrect&gt;:]</span></dt>
<dd>
<p>
When the response for field number <b><i>n</i></b> is <b>incorrect</b>, display the text in between these two tags.
The text may include other special tags. Examples:</p>
<p>
<tt><span style="color: blue;">[:answer:5:&lt;start_incorrect&gt;:]</span></tt>&lt;p&gt;Your answer to question number five was WRONG.&lt;/p&gt;<tt><span style="color: blue;">[:answer:5:&lt;end_incorrect&gt;:]</span></tt><br />
<tt><span style="color: blue;">[:answer:10:&lt;start_incorrect&gt;:]</span></tt>&lt;p&gt;Your answer to question number ten was WRONG.&lt;/p&gt;<tt><span style="color: blue;">[:answer:10:&lt;end_incorrect&gt;:]</span></tt>
</p>
</dd>

<dt><span style="color: blue;">[:each:info:&lt;start&gt;:]</span>Some HTML/text that also includes one or more of the following special tags<span style="color: blue;">[:each:info:&lt;end&gt;:]</span><br />
OR<br />
<span style="color: blue;">[:each:info:&lt;start&gt;:subset:]</span> (Will only loop for fields that are in the subset as specified in the category, if a subset is in use) <span style="color: blue;">[:each:info:&lt;end&gt;:]</span></dt>
<dd>
	<p>This is a block of HTML/text that loops and is output once for each field. It may 
	contain any of the following special tags:</p>
	<dl>
	<dt><span style="color: blue;">[:name:]</span></dt>
	<dd>The name of the field (the question or prompt to the user)</dd>

	<!-- Removed in 1.1.0rc3 dt><span style="color: blue;">[:partofspeech:]</span></dt>
	<dd>The &quot;part of speech hint&quot; for the field</dd -->

	<dt><span style="color: blue;">[:cluecuehint:]</span></dt>
	<dd>The clue/cue/hint for the field</dd>

	<dt><span style="color: blue;">[:beforetext:]</span></dt>
	<dd>The text that comes before the user's response</dd>

	<dt><span style="color: blue;">[:aftertext:]</span></dt>
	<dd>The text that comes after the user's response</dd>

	<dt><span style="color: blue;">[:field_number:]</span></dt>
	<dd>The ID number of the field</dd>

	<dt><span style="color: blue;">[:field_number_padded:]</span></dt>
	<dd>The two digit ID number of the field that may have a leading zero added</dd>

	<dt><span style="color: blue;">[:user_response:]</span></dt>
	<dd>The user's response to this question or prompt</dd>

	<dt><span style="color: blue;">[:user_response_raw:]</span></dt>
	<dd>The user's response to this question or prompt before processing the multiple response separators</dd>

	<dt><span style="color: blue;">[:points_b:]</span></dt>
	<dd>The type B point value of the selected responses for this question</dd>

	<dt><span style="color: blue;">[:points_b_sum:]</span></dt>
	<dd>The sum of the point values for all the responses</dd>

	<dt><span style="color: blue;">[:points_b_max:]</span></dt>
	<dd>The point value of the response with the highest point value</dd>

	<dt><span style="color: blue;">[:points_b_min:]</span></dt>
	<dd>The point value of the response with the lowest point value</dd>

	<dt><span style="color: blue;">[:points_b_avg:]</span></dt>
	<dd>The average point value of all the responses</dd>

	<dt><span style="color: blue;">[:points_b_avg_integer:]</span></dt>
	<dd>The average value of all the responses, rounded to the nearest integer</dd>
	
	<dt><span style="color: blue;">[:possible_choice:<b><i>n</i></b>:]</span></dt>
	<dd>The <b><i>nth</i></b> possible response to the question (from the &quot;List the options to be shown for multiple choice&quot; list)</dd>

	<dt><span style="color: blue;">[:possible_choice_selected:<b><i>n</i></b>:]</span></dt>
	<dd>If the <b><i>nth</i></b> possible response to the question (from the &quot;List the options to be shown for multiple choice&quot; list) was actually selected by the user, this is <b>1</b> (one). If it was not actually selected by the user, this is <b>0</b> (zero).</dd>

	<dt><span style="color: blue;">[:point_value_b:<b><i>n</i></b>:]</span></dt>
	<dd>The point value for the <b><i>nth</i></b> possible response to the question (from the &quot;Is there a point value&quot; list)</dd>
		
	<dt><span style="color: blue;">[:accrued_sum_ratio_b:]</span></dt>
	<dd>The actual accrued type B points divided by the sum of all type B points from every option</dd>

	<dt><span style="color: blue;">[:accrued_sum_percentage_b:]</span></dt>
	<dd>The actual accrued type B points divided by the sum of all type B points from every option, expressed as a rounded whole number percentage</dd>

	<dt><span style="color: blue;">[:in_subset:]</span></dt>
	<dd>This is <b>1</b> if the current field being looped is part of the subset, or <b>0</b> otherwise</dd>

	<!-- Below added in 1.4.2 20110227 -->
	<dt><span style="color: blue;">[:selected_index:]</span></dt>
	<dd>When using radio buttons or the pulldown menu, this will be <b>1</b> if the 1st possible choice was selected, <b>2</b> if the 2nd possible choice was selected, <b>3</b> if the 3rd possible choice was selected, etc., or <b>0</b> if no choice was selected; note that only one index is given, even if more than one is selected, so this is best used with radio buttons or the pulldown menu</dd>

	<dt><span style="color: blue;">[:selected_index_padded:]</span></dt>
	<dd>The same as <em>selected_index</em>, except that the given value is always two digits, with a leading zero added if necessary; note that only one index is given, even if more than one is selected, so this is best used with radio buttons or the pulldown menu</dd>

	<dt><span style="color: blue;">[:selected_index_alpha:]</span></dt>
	<dd>The same as <em>selected_index</em>, except that letters are used instead of numbers; this is customizable via the language file value <em>_MBL_SELECTED_INDEX_ALPHA</em>; by default, this will be <b>A</b> if the 1st possible choice was selected, <b>B</b> if the 2nd possible choice was selected, <b>C</b> if the 3rd possible choice was selected, etc., or <b>0</b> if no choice was selected; note that only one index is given, even if more than one is selected, so this is best used with radio buttons or the pulldown menu</dd>

	<dt><span style="color: blue;">[:selected_count:]</span></dt>
	<dd>The number of responses that were selected from the possible choices, useful when used with check boxes or the multiple choice menu</dd>

	</dl>
</dd>

<dt><span style="color: blue;">[:each:answer:&lt;start&gt;:]</span>Some HTML/text that also includes one or more of the following special tags<span style="color: blue;">[:each:answer:&lt;end&gt;:]</span><br />
OR<br />
<span style="color: blue;">[:each:answer:&lt;start&gt;:subset:]</span> (Will only loop for fields that are in the subset as specified in the category, if a subset is in use) <span style="color: blue;">[:each:answer:&lt;end&gt;:]</span></dt></dt>
<dd>
	<p>This is a block of HTML/text that loops and is output once for each field that has a correct answer.</p>
	
	<p><span style="font-weight: bold; background-color: yellow;">If a particular Mad Blanks field does not have a
	&quot;Correct response&quot; defined on the category edit page, that field will not iterated for this loop.</span></p>
	
	<p>This HTML/text may contain any of the following special tags:</p>
	
	<dl>
	<dt><span style="color: blue;">[:&lt;start_correct&gt;:]</span>Some HTML/text that may include other special tags<span style="color: blue;">[:&lt;end_correct&gt;:]</span></dt>
	<dd>When the response for field of the current loop is <b>correct</b>, display the text in between these two tags.
	The text may include other special tags, including the ones below.</dd>
	
	<dt><span style="color: blue;">[:&lt;start_incorrect&gt;:]</span>Some HTML/text that may include other special tags<span style="color: blue;">[:&lt;end_incorrect&gt;:]</span></dt>
	<dd>When the response for the field of the current loop is <b>incorrect</b>, display the text in between these two tags.
	The text may include other special tags, including the ones below.</dd>

	<dt><span style="color: blue;">[:name:]</span></dt>
	<dd>The name of the field (the question or prompt to the user)</dd>

	<!-- Removed in 1.1.0rc3 dt><span style="color: blue;">[:partofspeech:]</span></dt>
	<dd>The &quot;part of speech hint&quot; for the field</dd -->

	<dt><span style="color: blue;">[:cluecuehint:]</span></dt>
	<dd>The clue/cue/hint for the field</dd>

	<dt><span style="color: blue;">[:beforetext:]</span></dt>
	<dd>The text that comes before the user's response</dd>

	<dt><span style="color: blue;">[:aftertext:]</span></dt>
	<dd>The text that comes after the user's response</dd>

	<dt><span style="color: blue;">[:field_number:]</span></dt>
	<dd>The ID number of the field</dd>

	<dt><span style="color: blue;">[:field_number_padded:]</span></dt>
	<dd>The two digit ID number of the field that may have a leading zero added</dd>

	<dt><span style="color: blue;">[:correct_value:]</span></dt>
	<dd>The correct response to this question or prompt</dd>

	<dt><span style="color: blue;">[:correct_value_raw:]</span></dt>
	<dd>The correct response to this question or prompt before processing the multiple response separators</dd>

	<dt><span style="color: blue;">[:correct_case_sensitive:]</span></dt>
	<dd>If the correct response to this question or prompt must be entered with exact case, this is <b>1</b> (one); if the response does not need to match case exactly, this is <b>0</b> (zero)</dd>

	<dt><span style="color: blue;">[:user_response:]</span></dt>
	<dd>The user's response to this question or prompt</dd>

	<dt><span style="color: blue;">[:user_response_raw:]</span></dt>
	<dd>The user's response to this question or prompt before processing the multiple response separators</dd>

	<dt><span style="color: blue;">[:is_correct:]</span></dt>
	<dd>This is <b>1</b> (one) if the user's response is correct and <b>0</b> (zero) if the user's response is incorrect</dd>

	<dt><span style="color: blue;">[:points_earned_a:]</span></dt>
	<dd>The number of type A (awarded per question) points the user earned for this question</dd>

	<dt><span style="color: blue;">[:points_possible_a:]</span></dt>
	<dd>The number of type A points possible to earn for this question</dd>

	<dt><span style="color: blue;">[:points_earned_b:]</span></dt>
	<dd><b>If</b> the question was answered correctly, this is the number of type B points (awarded per response within each question) the user earned; otherwise, this is 0 (zero)</dd>

	<dt><span style="color: blue;">[:points_all_correct_b:]</span></dt>
	<dd>The number of type B points the user would earn if only correct answers were selected for this question</dd>

	<dt><span style="color: blue;">[:points_correct_ratio_b:]</span></dt>
	<dd>The total earned type B points divided by total type B points the user would earn if the answer were completely correct</dd>
	
	<dt><span style="color: blue;">[:points_correct_percentage_b:]</span></dt>
	<dd>The total earned type B points divided by total type B points the user would earn if the answer were completely correct, expressed as a rounded whole number percentage</dd>

	<dt><span style="color: blue;">[:in_subset:]</span></dt>
	<dd>This is <b>1</b> if the current field being looped is part of the subset, or <b>0</b> otherwise</dd>

	<!-- Below added in 1.4.2 20110227 -->
	<dt><span style="color: blue;">[:selected_index:]</span></dt>
	<dd>When using radio buttons or the pulldown menu, this will be <b>1</b> if the 1st possible choice was selected, <b>2</b> if the 2nd possible choice was selected, <b>3</b> if the 3rd possible choice was selected, etc., or <b>0</b> if no choice was selected; note that only one index is given, even if more than one is selected, so this is best used with radio buttons or the pulldown menu</dd>

	<dt><span style="color: blue;">[:selected_index_padded:]</span></dt>
	<dd>The same as <em>selected_index</em>, except that the given value is always two digits, with a leading zero added if necessary; note that only one index is given, even if more than one is selected, so this is best used with radio buttons or the pulldown menu</dd>

	<dt><span style="color: blue;">[:selected_index_alpha:]</span></dt>
	<dd>The same as <em>selected_index</em>, except that letters are used instead of numbers; this is customizable via the language file value <em>_MBL_SELECTED_INDEX_ALPHA</em>; by default, this will be <b>A</b> if the 1st possible choice was selected, <b>B</b> if the 2nd possible choice was selected, <b>C</b> if the 3rd possible choice was selected, etc., or <b>0</b> if no choice was selected; note that only one index is given, even if more than one is selected, so this is best used with radio buttons or the pulldown menu</dd>

	<dt><span style="color: blue;">[:selected_count:]</span></dt>
	<dd>The number of responses that were selected from the possible choices, useful when used with check boxes or the multiple choice menu</dd>
	
	<dt><span style="color: blue;">[:possible_choice:<b><i>m</i></b>:]</span></dt>
	<dd>The <b><i>mth</i></b> possible response to the question (from the &quot;List the options to be shown for multiple choice&quot; list)</dd>
	
	<dt><span style="color: blue;">[:possible_choice_selected:<b><i>m</i></b>:]</span></dt>
	<dd>If the <b><i>mth</i></b> possible response to the question (from the &quot;List the options to be shown for multiple choice&quot; list) was actually selected by the user, this is <b>1</b> (one). If it was not actually selected by the user, this is <b>0</b> (zero).</dd>
	
	<dt><span style="color: blue;">[:possible_choice_correct:<b><i>m</i></b>:]</span></dt>
	<dd>For use with check boxes or the multiple choice menu: If the <b><i>mth</i></b> possible response to the question (from the &quot;List the options to be shown for multiple choice&quot; list) was individually correct, this is <b>1</b> (one), otherwise, this is <b>0</b> (zero). Note that it is possible for a check box to be considered correct (1) when it is not checked.</dd>

	</dl>
</dd>

<dt><span style="color: blue;">[:email:]</span></dt>
<dd>
<p>This special tag is used to send an email message. The email settings on the Mail tab of the Global Configuration of your Joomla! installation govern what method is used to send the email. One or more of the following elements can be added to the email special tag. Each entry must be separated by a colon. See the examples below the explanations of the email elements.</p>
	
	<dl>

	<dt><span style="color: blue;">from{address@example.com}</span> OR <span style="color: blue;">from{address@example.com;From Name}</span></dt>
	<dd>The from address of the email message; This is a single email address, optionally followed by a semicolon and a name associated with the email address; This field can contain special tags that would be found in a Score Script and resolve to the desired content; If not specified in the special tag and if no default is specified in the value of the Mad Blanks configuration variable <em>mbDefaultSSEmailFrom</em>, the 'Mail From' email address and 'From Name' name in the Joomla! configuration are used</dd>
	
	<dt><span style="color: blue;">to{address@example.com}</span> OR <span style="color: blue;">to{address1@example.com, address2@example.com, address3@example.com, ...}</span></dt>
	<dd>One or more email addresses to send the email message to; This is a single address or a comma-delimited list of email addresses; This field can contain special tags that would be found in a Score Script and resolve to the desired content; If not specified in the special tag and if no default is specified in the value of the Mad Blanks configuration variable <em>mbDefaultSSEmailTo</em>, the 'Mail From' email address in the Joomla! configuration is used</dd>

	<dt><span style="color: blue;">subject{The Subject}</span></dt>
	<dd>The subject of the email message; This field can contain special tags that would be found in a Score Script and resolve to the desired content; If not specified in the special tag, the value of the Mad Blanks configuration variable <em>mbDefaultSSEmailTo</em> is used as the subject</dd>

	<dt><span style="color: blue;">body{The Body}</span></dt>
	<dd>The body of the email message; This field can contain special tags that would be found in a Score Script and resolve to the desired content; If not specified in the special tag, the value of the Mad Blanks configuration variable <em>mbDefaultSSEmailBody</em> is used as the body</dd>

	<dt><span style="color: blue;">html_mode{0}</span> OR <span style="color: blue;">html_mode{1}</span></dt>
	<dd>The mode of the email message; This value is <b>0</b> for a plain text email or <b>1</b> for an email that uses HTML. This field can contain special tags that would be found in a Score Script and resolve to the desired content; If not specified in the special tag, the value of the Mad Blanks configuration variable <em>mbDefaultSSEmailMode</em> is used as the mode</dd>

	<dt><span style="color: blue;">cc{address@example.com}</span> OR <span style="color: blue;">cc{address1@example.com, address2@example.com, address3@example.com, ...}</span></dt>
	<dd>One or more email addresses to send a 'carbon copy' of the email message to; This is a single address or a comma-delimited list of email addresses; This field can contain special tags that would be found in a Score Script and resolve to the desired content; If not specified in the special tag, the value of the Mad Blanks configuration variable <em>mbDefaultSSEmailCC</em> is used</dd>

	<dt><span style="color: blue;">bcc{address@example.com}</span> OR <span style="color: blue;">bcc{address1@example.com, address2@example.com, address3@example.com, ...}</span></dt>
	<dd>One or more email addresses to send a 'blind carbon copy' of the email message to; This is a single address or a comma-delimited list of email addresses; This field can contain special tags that would be found in a Score Script and resolve to the desired content; If not specified in the special tag, the value of the Mad Blanks configuration variable <em>mbDefaultSSEmailBCC</em> is used</dd>
	
	<dt><span style="color: blue;">attachment{/path/filename}</span> OR <span style="color: blue;">attachment{/path1/filename1,/path2/filename2}</span></dt>
	<dd>The filename of one or more attachments to the email message; This is a single file name or a comma-delimited list of file names, the format of which are server-dependent; This field can contain special tags that would be found in a Score Script and resolve to the desired content; If not specified in the special tag, the value of the Mad Blanks configuration variable <em>mbDefaultSSEmailBCC</em> is used; WARNING: EMAIL ATTACHMENTS MUST BE EXPLICITLY ENABLED by commenting out a line in madblanks.class.php labeled with the following: "WARNING: EMAIL ATTACHMENTS ARE DISABLED UNLESS THE NEXT LINE IS REMOVED OR COMMENTED OUT"</dd>

	<dt><span style="color: blue;">reply_to{reply@example.com}</span> OR <span style="color: blue;">reply_to{reply@example.com;Reply Name}</span> OR <span style="color: blue;">reply_to{reply1@example.com, reply2@example.com}</span> OR <span style="color: blue;">reply_to{reply1@example.com;Reply Name One, reply2@example.com;Reply Name Two}</span></dt>
	<dd>One or more 'Reply To' addresses for the email message; This is a single address or a comma-delimited list of email addresses; each email address can optionally be followed by a semicolon and a name associated with the email address; This field can contain special tags that would be found in a Score Script and resolve to the desired content; If not specified in the special tag, the value of the Mad Blanks configuration variable <em>mbDefaultSSEmailAttachment</em> is used</dd>

	<dt><span style="color: blue;">success_message{text/HTML and/or Score Script tags}</span></dt>
	<dd>This text/HTML replaces the email special tag in the Score Script when sending the email is successful; This field can contain special tags that would be found in a Score Script and resolve to the desired content; If not specified in the special tag, the value of the Mad Blanks configuration variable <em>mbDefaultSSEmailSuccess</em> is used</dd>

	<dt><span style="color: blue;">failure_message{text/HTML and/or Score Script tags}</span></dt>
	<dd>This text/HTML replaces the email special tag in the Score Script when sending the email fails; This field can contain special tags that would be found in a Score Script and resolve to the desired content; If not specified in the special tag, the value of the Mad Blanks configuration variable <em>mbDefaultSSEmailFailure</em> is used</dd>

	</dl>

<p>Note that curly brackets cannot be included inside any of the above tags. Instead, use [:curlyl:] and [:curlyr:].
<p>Examples:</p>
<p>
<tt><span style="color: blue;">[:email:]</span></tt> This email message uses all default values from the Mad Blanks configuration variables.<br />
<tt><span style="color: blue;">[:email:to{user@example.com}:bcc{administrator@example.com}:]</span></tt> This email message specifies one 'to' email address and one 'blind carbon copy' email address and uses the default values from the Mad Blanks configuration variables for all the other elements of the email message.<br />
<tt><span style="color: blue;">[:email:from{from@example.com;From Name}:to{to1@example1.com,to2@example.com,to3@example.com}:subject{This is the Subject}:body{&lt;h1&gt;This is the Body.&lt;/h1&gt; It includes &lt;b&gt;HTML&lt;/b&gt;}:html_mode{1}:cc{cc1@example.com,cc2@example.com,cc3@example.com}:success_message{The email was sent successfully.}:failure_message{&lt;h1&gt;The message could not be sent. Check for errors in the email special tag.&lt;/h1&gt;}:attachment{/tmp/image1.jpg}:reply_to{reply1@example.com;Reply One Name,reply2@example.com;Reply Two Name}:bcc{bcc@example.com}:]</span></tt> This is a complex example that uses all of the available elements of an email message. Note that the elements do not have to appear in a particular order.
</p>
</dd>


<dt><span style="color: blue;">[:date:]</span></dt>
<dd>
<p>
Insert a datestamp/timestamp into the Score Script. There are three possible forms of this tag:
</p>
	<dl>

	<dt><span style="color: blue;">[:date:]</span></dt>
	<dd>Display the default date and time according to the value of the Mad Blanks configuration variable <em>mbDefaultSSDateFormat</em>, which uses the syntax of PHP's strftime function (see http://php.net/strftime); If that variable is not specified, <b>_DATE_FORMAT_LC2</b> from Joomla's relevant language file will be used, if available, or <b>%d %b %Y %I:%M %p</b> will be used. The offset value of the Mad Blanks configuration variable <em>mbDefaultSSDateAdjustment</em> will also be used. If not specified, an offset of zero will be used.</dd>

	<dt><span style="color: blue;">[:date:&lt;<em>format</em>&gt;:]</span></dt>
	<dd>Display the date and time according to the format <em>format</em>, which is placed inside a pair of angle brackets; The syntax is according to PHP's strftime function (see http://php.net/strftime). The value of the Mad Blanks configuration variable <em>mbDefaultSSDateAdjustment</em> will also be used. If not specified, an offset of zero will be used.</dd>

	<dt><span style="color: blue;">[:date:&lt;<em>format</em>&gt;:<em>offset</em>:]</span></dt>
	<dd>Display the date and time according to the format <em>format</em>; The syntax is according to PHP's strftime function (see http://php.net/strftime). A plain English time adjustment <em>offset</em> is specified. This is accomplished via PHP's strtotime function (see http://php.net/strtotime).This is useful if the server is in a different time zone than your website or if the server clock is incorrect and out of your control. Examples for the <em>offset</em>: <b>-5 hours</b> or <b>+2min +25sec</b></dd>

	</dl>
</dd>

<dt><span style="color: blue;">[:arithmetic:{<b><i>1st operand</i></b>}:<b><i>operator</i></b>:{<b><i>2nd operand</i></b>}:]</span></dt>
<dd>
<p>This is the arithmetic operator tag. It allows you to perform arithmetic within a Score Script. The <b><i>1st operand</i></b> and <b><i>2nd operand</i></b> are replaced with the values to perform the arithmetic on. These operands can include special tags within the curly brackets ({}). Replace <b><i>operator</i></b> with any of the following:</p>
	<dl>

	<dt>+</dt>
	<dd>Add <b><i>1st operand</i></b> to <b><i>2nd operand</i></b></dd>

	<dt>-</dt>
	<dd>Subtract <b><i>2nd operand</i></b> from <b><i>1st operand</i></b></dd>

	<dt>*</dt>
	<dd>Multiply <b><i>1st operand</i></b> by <b><i>2nd operand</i></b></dd>

	<dt>/</dt>
	<dd>Divide <b><i>1st operand</i></b> by <b><i>2nd operand</i></b></dd>

	<dt>%</dt>
	<dd>Modulus operator - get the remainder when dividing <b><i>1st operand</i></b> by <b><i>2nd operand</i></b></dd>

	</dl>
	
	<p>Examples:</p>
		
	<tt><span style="color: blue;">[:arithmetic:{3}:+:{2}:]</span></tt> Add 3 to 2. (The result displayed in the Score Script is <em>5</em>.)<br />
	
	<tt><span style="color: blue;">[:arithmetic:{[:info:1:user_response:]}:*:{[:info:2:user_response:]}:]</span></tt> Multiply the user's response for field 1 by the user's response for field 2 and display the result in the Score Script.

</dd>

<dt><span style="color: blue;">[:sum:{<b><i>1st number to add</i></b>}:{<b><i>2nd number to add</i></b>}:{<b>n<i>th number to add</i></b>}:]</span></dt>
<dd>
<p>The <em>sum</em> tag allows you to add numbers together. Unlike the <em>arithmetic</em> tag, it takes any number of arguments.</p>

<p>Examples:<br />
<tt><span style="color: blue;">[:sum:{1}:{2}:]</span></tt> displays as <b>3</b><br />
<tt><span style="color: blue;">[:sum:{1}:{2}:{3}:{4}:{5}:{6}:{7}:{8}:]</span></tt> displays as <b>36</b><br />
<tt><span style="color: blue;">[:sum:{[:info:1:user_response:]}:{[:info:2:user_response:]}:{[:info:3:user_response:]}:]</span></tt> displays as the sum of the user's responses to question #1, question #2, and question #3</p>
</dd>

<dt><span style="color: blue;">[:product:{<b><i>1st number to multiply</i></b>}:{<b><i>2nd number to multiply</i></b>}:{<b>n<i>th number to multiply</i></b>}:]</span></dt>
<dd>
<p>The <em>product</em> tag allows you to multiply numbers together. Unlike the <em>arithmetic</em> tag, it takes any number of arguments.</p>

<p>Examples:<br />
<tt><span style="color: blue;">[:product:{1}:{2}:]</span></tt> displays as <b>2</b><br />
<tt><span style="color: blue;">[:product:{1}:{2}:{3}:{4}:{5}:{6}:{7}:{8}:]</span></tt> displays as <b>40320</b><br />
<tt><span style="color: blue;">[:product:{[:info:1:user_response:]}:{[:info:2:user_response:]}:{[:info:3:user_response:]}:]</span></tt> displays as the product of the user's responses to question #1, question #2, and question #3</p>
</dd>

<dt><span style="color: blue;">[:average:{<b><i>1st number to average</i></b>}:{<b><i>2nd number to average</i></b>}:{<b>n<i>th number to average</i></b>}:]</span></dt>
<dd>
<p>The <em>average</em> tag allows you to calculate the <em>arithmetic mean</em> of a set of numbers. The tag takes any
number of arguments. Note that additional central tendency measurements such as <b>MODE</b> and <b>MEDIAN</b> are
available through use of the <em>aggregate</em> or <em>expression_group</em> tags.</p>

<p>Examples:<br />
<tt><span style="color: blue;">[:average:{1}:{2}:]</span></tt> displays as <b>1.5</b><br />
<tt><span style="color: blue;">[:average:{1}:{2}:{3}:{4}:{5}:{6}:{7}:{8}:]</span></tt> displays as <b>4.5</b><br />
<tt><span style="color: blue;">[:average:{[:info:1:user_response:]}:{[:info:2:user_response:]}:{[:info:3:user_response:]}:]</span></tt> displays as the average of the user's responses to question #1, question #2, and question #3</p>
</dd>

<dt><span style="color: blue;">[:comparison:{<b><i>1st operand</i></b>}:<b><i>operator</i></b>:{<b><i>2nd operand</i></b>}:{<b><i>true</i></b>}:{<b><i>false</i></b>}:]</span></dt>
<dd>
<p>This is the comparison operator tag. It allows you to perform comparisons within a Score Script. The <b><i>1st operand</i></b> and <b><i>2nd operand</i></b> are compared according to the <b><i>operator</i></b> being used. If the comparison is true, the entire tag is replaced with <b><i>true</i></b>. If the comparison is false, the entire tag is replaced with <b><i>false</i></b>. The operands and <b><i>true</i></b> and <b><i>false</i></b> can include special tags within the curly brackets ({}). Replace <b><i>operator</i></b> with any of the following:</p>
	<dl>

	<dt><tt>==&nbsp; &nbsp; &nbsp; &nbsp;eq</tt></dt>
	<dd>True if <i>1st operand</i> equals <i>2nd operand</i></dd>

	<dt><tt>!=&nbsp; &nbsp; &nbsp; &nbsp;&lt;&gt;&nbsp; &nbsp; &nbsp; &nbsp;ne</tt></dt>
	<dd>True if <i>1st operand</i> is not equal to <i>2nd operand</i></dd>

	<dt><tt> &lt;&nbsp; &nbsp; &nbsp; &nbsp;lt</tt></dt>
	<dd>True if <i>1st operand</i> is less than <i>2nd operand</i></dd>

	<dt><tt> &gt;&nbsp; &nbsp; &nbsp; &nbsp;gt</tt></dt>
	<dd>True if <i>1st operand</i> is greater than <i>2nd operand</i></dd>

	<dt><tt>&lt;=&nbsp; &nbsp; &nbsp; &nbsp;le</tt></dt>
	<dd>True if <i>1st operand</i> is less than or equal to <i>2nd operand</i></dd>

	<dt><tt>&gt;=&nbsp; &nbsp; &nbsp; &nbsp;ge</tt></dt>
	<dd>True if <i>1st operand</i> is greater than or equal to <i>2nd operand</i></dd>

	</dl>
	
	<p>Examples:</p>
		
	<tt><span style="color: blue;">[:comparison:{3}:<:{2}:{Three is less than two.}:{Three is not less than two.}:] </span></tt> Compare 3 to 2. Since 3 is not less than 2, the result is false. Therefore the entire tag is replaced with <em>Three is not less than two.</em><br />

	<tt><span style="color: blue;">[:comparison:{[:info:1:user_response:]}:!=:{[:info:2:user_response:]}:{You entered two different values.}:{You entered the same value twice.}:]</span></tt> Find out if the user's response for field 1 and the user's response for field 2 are not equal. If they are not equal, the entire tag is replaced with <em>You entered two different values.</em>. If they are equal, the entire tag is replaced with <em>You entered the same value twice.</em>.

	<tt><span style="color: blue;">[:comparison:{[:info:1:user_response:]}:&gt;=:{[:info:2:user_response:]}:{[:total_points_earned_a:]}:{[:total_points_earned_b:]}:]</span></tt> Find out if the user's response for field 1 is greater than or equal to the user's response for field 2. If the comparison is true, the entire tag is replaced with the total type a points earned. If the condition is false, the entire tag is replaced with the total type b points earned.

</dd>

<dt><span style="color: blue;">[:logical:{<b><i>1st operand</i></b>}:<b><i>operator</i></b>:{<b><i>2nd operand</i></b>}:{<b><i>true</i></b>}:{<b><i>false</i></b>}:]</span></dt>
<dd>
<p>This is the logical operator tag. It allows you to perform logic within a Score Script. Each operand is classified as TRUE (a non-zero value) or FALSE (zero or doesn't exist). The logical condition corresponding to the <b><i>operator</i></b> is then calculated. If the condition is true, the entire tag is replaced with <b><i>true</i></b>. If the condition is false, the entire tag is replaced with <b><i>false</i></b>. The operands and <b><i>true</i></b> and <b><i>false</i></b> can include special tags within the curly brackets ({}). Replace <b><i>operator</i></b> with any of the following:</p>
	<dl>

	<dt><tt>and&nbsp; &nbsp; &nbsp; &nbsp;&&</tt></dt>
	<dd>True if <b><i>1st operand</i></b> and <b><i>2nd operand</i></b> are both TRUE</dd>

	<dt><tt>or &nbsp; &nbsp; &nbsp; &nbsp;||</tt></dt>
	<dd>True if <b><i>1st operand</i></b> is TRUE or <b><i>2nd operand</i></b> is TRUE</dd>

	<dt><tt>xor</tt></dt>
	<dd>True if <b><i>1st operand</i></b> is TRUE or <b><i>2nd operand</i></b> is TRUE, unless both are true in which case the condition is false</dd>

	<dt><tt>true</tt></dt>
	<dd>True if <b><i>1st operand</i></b> is TRUE; <b><i>2nd operand</i></b> is ignored</dd>

	<dt><tt>not&nbsp; &nbsp; &nbsp; &nbsp;!&nbsp; &nbsp; &nbsp; &nbsp;false</tt></dt>
	<dd>True if <b><i>1st operand</i></b> is FALSE; <b><i>2nd operand</i></b> is ignored</dd>

	</dl>
	
	<p>Examples:</p>
	
	<tt><span style="color: blue;">[:logical:{1}:and:{2}:{Yes}:{No}:] </span></tt> Check if 1 and 2 are both TRUE (a non-zero value). Since they both are, the result is true. Therefore the entire tag is replaced with <em>Yes</em>.<br />

	<tt><span style="color: blue;">[:logical:{[:info:1:user_response:]}:or:{[:info:2:user_response:]}:{At least one of the values you entered is TRUE.}:{You did not enter any TRUE values.}:]</span></tt> Check if either the user's response for field 1 or the user's response for field 2 is TRUE (a non-zero value). If one or both are TRUE, the entire tag is replaced with <em>At least one of the values you entered is TRUE.</em>. If neither of the responses is TRUE, the entire tag is replaced with <em>You did not enter any TRUE values.</em>.<br />

	<tt><span style="color: blue;">[:logical:{[:info:1:user_response:]}:!:{}:{[:date:&lt;%m/%d/%y&gt;:]}:{[:date:&lt;%d/%m/%y&gt;:]}:]</span></tt> Check if the user's response for field 1 is FALSE (zero or doesn't exist). If so, the entire tag is replaced with the date in month/day/year format. Otherwise, the entire tag is replaced with the date in day/month/year format. Note that the contents of <b><i>2nd operand</i></b>, had they been present, would have been ignored.

</dd>

<dt><span style="color: blue;">&lt;expression:<b><i>name</i></b>&gt;An expression containing text/HTML and/or special tags&lt;/expression&gt;</span>
<br />OR OPTIONALLY
<br /><span style="color: blue;">&lt;expression:<b><i>name</i></b>:<b><i>group_name</i></b>&gt;An expression containing text/HTML and/or special tags&lt;/expression&gt;</span>
<br />OR OPTIONALLY
<br /><span style="color: blue;">&lt;expression:<b><i>name</i></b>:<b><i>group_name</i></b>:<b><i>alternative_expression_text</i></b>&gt;An expression containing text/HTML and/or special tags&lt;/expression&gt;</span>
</dt>
<dd>

<p>This is an expression declaration, used to define expressions that can be used elsewhere in the Score Script. <span
style="color: red;">Expression declarations should only be made outside of any other Score Script tags (at the root level of
the Score Script); they are always processed first by Mad Blanks when calculating Score Script output</span>. An expression
can be a simple text string and it can contain special tags. Replace <b><i>name</i></b> with a unique non-zero whole number,
or a name consisting of letters, digits, and the underscore; this same name will be used in the corresponding expression special
tag to recall the contents of the expression declaration. Replace <b><i>group_name</i></b>, if present, with a unique group
name for the expression; this will allow expressions that are members of the same group to be sorted and used as the basis
to calculate statistics using the <em>expression_group </em> tag. Replace <b><i>alternative_expression_text</i></b>, if
present, with alternative text for the expression (for use with the <em>data_labels</em> element of the 
<em>expression_group</em> tag [specifically, <b>data_labels{short}</b>])</p>

	<p>Examples:</p>
	<p>
	
	<tt><span style="color: blue;">&lt;expression:1&gt;This is a simple expression in the form of text.&lt;/expression&gt;</span></tt> The expression declaration contains text.<br />

	<tt><span style="color: blue;">&lt;expression:2&gt;[:arithmetic:{[:answer:1:user_response:]}:/:{[:answer:2:user_response:]}:]&lt;/expression&gt;</span></tt> The expression declaration contains a special tag.<br />
	
	<tt><span style="color: blue;">&lt;expression:alpha&gt;The value stored in expression beta is [:expression:beta:]&lt;/expression&gt;</span></tt> The expression declaration includes the output of another expression.
	</p>
</dd>

<dt><span style="color: blue;">[:expression:<b><i>name</i></b>:]</span></dt>
<dd>

<p>This is an expression tag, which is replaced with the contents of the corresponding expression definition. The <b><i>name</i></b> can be specified directly or it can be derived from simple Score Script tags that evaluate to the name of the desired expression.</p></dd>

<dt><span style="color: blue;">[:user_id_number:]</span></dt>
<dd>The system ID number of the user (<em>0</em> if the user is not logged in)</dd>

<dt><span style="color: blue;">[:user_name:]</span></dt>
<dd>The username of the user (blank if the user is not logged in)</dd>

<dt><span style="color: blue;">[:user_full_name:]</span></dt>
<dd>The full name of the user (blank if the user is not logged in)</dd>

<dt><span style="color: blue;">[:user_email:]</span></dt>
<dd>The email address of the user (blank if the user is not logged in)</dd>

<dt><span style="color: blue;">[:user_type:]</span></dt>
<dd>The user type (blank if the user is not logged in)</dd>

<dt><span style="color: blue;">[:user_register_date:]</span></dt>
<dd>The date the user registered (blank if the user is not logged in)</dd>

<dt><span style="color: blue;">[:user_last_visit_date:]</span></dt>
<dd>The date the user last visited (blank if the user is not logged in)</dd>

<dt><span style="color: blue;">[:user_is_guest:]</span></dt>
<dd>This is <b>1</b> (one) if the user is a guest (not logged in) or <b>0</b> (zero) if the user is logged in</dd>

<dt><span style="color: blue;">[:user_ip_address:]</span></dt>
<dd>The user's IP address (if available from the web server)</dd>

<dt><span style="color: blue;">[:user_host:]</span></dt>
<dd>The user's host name (if available from the web server - in Apache you'll need <em>HostnameLookups On</em> inside httpd.conf)</dd>

<dt><span style="color: blue;">[:user_user_agent:]</span></dt>
<dd>The &quot;user agent&quot; web browser information from the user's web browser (if available from the web server)</dd>

<dt><span style="color: blue;">[:user_referer:]</span></dt>
<dd>The address of the web page the user was on before submitting the form to reach the Score Script (if available from the web server)</dd>

<dt><span style="color: blue;">&lt;logdata:<b><i>n</i></b>&gt;</span>Data from the Score Script to log as part of the Mad Blanks record<span style="color: blue;">&lt;/logdata&gt;</span>
<br />OR OPTIONALLY
<br /><dt><span style="color: blue;">&lt;logdata:<b><i>n</i></b>:overwrite&gt;</span>Data from the Score Script to log as part of the Mad Blanks record<span style="color: blue;">&lt;/logdata&gt;</span></dt>
<dd>

<p>Log the output between the opening and closing <em>logdata</em> tags to the Mad Blanks record. Normally, <em>logdata:1
</em> and <em>logdata:2</em> are supported. (Advanced: You can add additional columns to the <em>prefix</em>_madblanks_records database table like <em>scodata3</em>, <em>scodata4</em>, etc., and write to those fields too.) This has <b>no effect</b> if the Create Single Record module's parameter labeled
<em>Save the record inputted by the user?</em> is set to <b>Display only; don't save in the database</b>. Any data that can
be generated natively by the Score Script can be saved this way. If there is already logged data in a Mad Blanks record, it
will not be overwritten unless <b>overwrite</b> is specified as part of the tag.</p>

	<p>Examples:</p>
	<p>
	
	<tt><span style="color: blue;">&lt;logdata:1&gt;[:percentage_correct:]&lt;/logdata&gt;</span></tt>
	Logs the user's &quot;percentage correct&quot; score in the record's <em>scodata1</em> field<br />

	<tt><span style="color: blue;">&lt;logdata:2&gt;IP address: [:user_ip_address:]<br /> Browser
	Information: [:user_user_agent:]&lt;/logdata&gt;</span></tt> Logs the user's IP address and web
	browser information along with some labeling text in the record's <em>scodata2</em> field; note that
	the linebreak is also saved<br />

	<tt><span style="color: blue;">
	&lt;logdata:1:overwrite&gt;[:sum:{[:info:1:user_response:]}:{[:info:2:user_response:]}:]&lt;/logdata&gt;</span></tt> Logs the sum of the user's responses to questions 1 and 2 in the record's
	<em>scodata1</em> field; because of the <b>overwrite</b> flag, the data is logged even if there is
	already data present in the field
	
	</p>
</dd>


<dt><span style="color: blue;">[:aggregate:]</span></dt>
<dd>

<p>This special tag is used to calculate and display aggregate data from multiple records in a Mad Blanks category. One or
more of the following elements can be added to the <em>aggregate</em> special tag. Each entry must be
separated by a colon. See the examples below the explanations of the aggregate elements.</p>

<p>The curly braces can have text/digits inside them and/or other Score Script tags.</p>
	
	<dl>

	<dt><span style="color: blue;">function{<em>function name</em>}</span></dt>
	<dd>
	
	The function name specifies the type of aggregate data to calculate and display. This tag element is <b>REQUIRED</b>
	to be specified. The types are as follows:
		
		<dl>
		
		<dt>AVG</dt>
		<dd>The average (mean) of all the values meeting the criteria specified in the other tag elements</dd>
		
		<dt>AVG-DISTINCT</dt>
		<dd>The average (mean) of all the distinct values (repeated values are ignored) meeting the criteria specified in the other tag elements</dd>
		
		<dt>COUNT</dt>
		<dd>How many answers there are that meet the criteria specified in the other tag elements</dd>
		
		<dt>COUNT-DISTINCT</dt>
		<dd>How many distinct answers (repeated values are ignored) there are that meet the criteria specified in the other tag elements</dd>
		
		<dt>MAX</dt>
		<dd>The highest value that meets the criteria specified in the other tag elements</dd>
		
		<dt>MIN</dt>
		<dd>The lowest value that meets the criteria specified in the other tag elements</dd>
		
		<dt>SUM</dt>
		<dd>The sum of all the values that meet the criteria specified in the other tag elements</dd>
		
		<dt>STD</dt>
		<dd>The population standard deviation of all the values that meet the criteria specified in the other tag elements</dd>
		
		<dt>MODE</dt>
		<dd>The value that appears most often in the data that meets the criteria specified in the other tag elements. <b>Only one mode will be shown, even though more than one may exist in the data</b></dd>
		
		<dt>CONCAT</dt>
		<dd>Show each value in a dataset in sequence one after another</dd>
		
		<dt>CONCAT-DISTINCT</dt>
		<dd>Show each distinct value (repeated values are ignored) in a dataset in sequence one after another</dd>
		
		<dt>GOOGLE-CHART</dt>
		<dd>Show an image of a chart generated by the Google Chart API based on data specified in the other tag elements</dd>
		
		<dt>GOOGLE-CHART-PERCENTAGE</dt>
		<dd>Show an image of a chart generated by the Google Chart API based on data specified in the other tag elements, where the data is represented as a percentage relative to the other data in a dataset</dd>
		
		<dt>MEDIAN</dt>
		<dd>The middle value calculated after numerically ordering the data specified in the other tag elements</dd>
		
		<dt>MEDIAN-DISTINCT</dt>
		<dd>The middle value calculated after numerically ordering the data specified in the other tag elements, where repeated values are ignored</dd>
		
		<dt>COUNT-VALUE</dt>
		<dd>The count of how many times a particular value appears in the data set that meets the criteria specified in the other tag elements</dd>
		
		<dt>COUNT-VALUE-RATIO</dt>
		<dd>The ratio of how many times a particular value appears relative to the total number of values in the data set that meets the criteria specified in the other tag elements</dd>
		
		<dt>COUNT-VALUE-PERCENTAGE</dt>
		<dd>The percentage of how many times a particular value appears relative to the total number of values in the data set that meets the criteria specified in the other tag elements</dd>
		
		<dt>SQL</dt>
		<dd>Show the output from an SQL query manually specified in the <em>query</em> tag element</dd>

		<dt>SET-MEMBER</dt>
		<dd>Use in conjunction with the <em>order_by</em> tag element and the <em>member</em> tag element to pick a member of the set/group; for example, use this to show the 2nd highest number in a group (for example, a logged score stored in <em>scodata1</em>) by setting <em>order_by</em> to <b>DESC</b> and setting <em>member</em> to <b>2</b>
		</dl>
	</dd>

	<dt><span style="color: blue;">field{<em>database_field</em>}</span></dt>
	<dd>A field name from the <em>jos_madblanks_records</em> table in the database that will be the source of aggregate data.
	
	The following fields are among those available, where data_XX corresponds to a field specified in a Mad Blanks
	category, and scodataX corresponds to data logged in Mad Blanks records using the <b>&lt;logdata:<em>n</em>&gt;&lt;/logdata&gt;</b> tags.
	
	<ul>
		<li>data_01</li>
		<li>data_02</li>
		<li>data_03</li>
		<li>data_04</li>
		<li>data_05</li>
		<li>data_06</li>
		<li>data_07</li>
		<li>data_08</li>
		<li>data_09</li>
		<li>data_10</li>
		<li>data_11</li>
		<li>data_12</li>
		<li>data_13</li>
		<li>data_14</li>
		<li>data_15</li>
		<li>data_16</li>
		<li>data_17</li>
		<li>data_18</li>
		<li>data_19</li>
		<li>data_20</li>
		<li>data_21</li>
		<li>data_22</li>
		<li>data_23</li>
		<li>data_24</li>
		<li>data_25</li>
		<li>scodata1</li>
		<li>scodata2</li>
	</ul>
	</dd>

	<dt><span style="color: blue;">category{<em>Mad Blanks category ID number</em>}</span></dt>
	<dd>The ID number of the Mad Blanks category for which to calculate aggregate data. If <em>this</em> is specified, or no value is specified, the current category is used.</dd>

	<dt><span style="color: blue;">table{<em>database table</em>}</span></dt>
	<dd>The database table to use. If not specified, <em>jos_madblanks_records</em> (if you are using a different database prefix, it will be substituted for <em>jos</em>) is used as the default</dd>

	<dt><span style="color: blue;">where{<em>the contents of a MySQL 'WHERE' clause</em>}</span></dt>
	<dd>The text of a MySQL 'WHERE' clause that follows the word <em>WHERE</em>; this can be used to customize which data is taken into account when calculating aggregate results</dd>

	<dt><span style="color: blue;">query{<em>MySQL query</em>}</span></dt>
	<dd>Use this to specify an entire MySQL query for use in calculating aggregate data</dd>

	<dt><span style="color: blue;">ignore_empty_records{true}</span></dt>
	<dd>Set this to <b>true</b> to ignore responses where there is no answer filled in. Use this, for example, to exclude survey responses with no answer when calculating an average value.</dd>
	
	<dt><span style="color: blue;">cast{<em>MySQL data type</em>}</span></dt>
	<dd>Specify how to treat the data. Use one of <b>BINARY(<em>N</em>)</b>, <b>CHAR(<em>N</em>)</b>,
	<b>DATE</b>, <b>DATETIME</b>, <b>DECIMAL(<em>M</em>, <em>D</em>)</b>, <b>SIGNED</b>, <b>TIME</b>, <b>UNSIGNED</b>.
	The optional
	argument <em>N</em> for types <em>BINARY</em> and <em>CHAR</em> causes MySQL to use no more than <em>N</em> bytes
	or <em>N</em> characters respectively for the cast. For type <em>DECIMAL</em>, you should specify
	<em><b>M</b></em>, the maximum total number of digits (the precision) and <em><b>D</b></em>, the number of digits to
	the right of the decimal point (the scale). See the MySQL documentation regarding the <em>CAST</em> function for more details.
	See also the <em>cast_for_ordering</em> element.</dd>

	<dt><span style="color: blue;">cast_for_ordering{<em>MySQL data type</em>}</span></dt>
	<dd>Specify how to treat the data when being ordered by the database. Use the same values as for <em>cast</em>.</dd>

	<dt><span style="color: blue;">concat_separator{<em>separator text</em>}</span></dt>
	<dd>Specify text to use in between values when using <em>function{CONCAT}</em> or <em>function{CONCAT-DISTINCT}</em></dd>

	<dt><span style="color: blue;">chart_size{<em>width</em>x<em>height</em>}</span></dt>
	<dd>Specify the overall chart image size in pixels. Take labels into account when considering chart image size.</dd>

	<dt><span style="color: blue;">chart_type{<em>chart type code</em>}</span></dt>
	<dd>The chart type:
	
		<dl>
			<dt>p</dt>
			<dd>Two dimensional pie chart</dd>
		
			<dt>p3</dt>
			<dd>Three dimensional pie chart</dd>

			<dt>bhs</dt>
			<dd>Horizontal bar chart</dd>
		
			<dt>bvs</dt>
			<dd>Vertical bar chart</dd>
		
			<dt>gom</dt>
			<dd>Google-o-meter (thermometer)</dd>
		</dl>
	
	</dd>

	<dt><span style="color: blue;">chart_color{<em>one or more colors in RGB format, separated by commas</em>}</span></dt>
	<dd>Specify one or more colors to define the colors or extrapolated color gradient used by the chart. Use RGB format. Examples: <em>0000FF</em> or <em>008000,FFFF00</em></dd>

	<dt><span style="color: blue;">chart_no_response_label{<em>Text to use for blank responses</em>}</span></dt>
	<dd>Specify text to use to represent the portion of the data set that has no response associated with it; <b>&lt;No response&gt;</b> is the default.</dd>

	<dt><span style="color: blue;">data_labels{<em>normal</em> or <em>short</em>}</span></dt>
	<dd>Use the <em>normal</em> responses as specified in the Mad Blanks category for each field (&quot;List the options to be shown for multiple choice...&quot;) as labels on the chart or use the <em>short</em> versions of the labels (&quot;Short versions of the above options...&quot;)</dd>

	<dt><span style="color: blue;">chart_value{<em>number between 0 and 100</em>}</span></dt>
	<dd>For the Google-o-meter (thermometer-style) chart, this is an integer between 0 and 100, inclusive.</dd>

	<dt><span style="color: blue;">chart_label{<em>Label text</em>}</span></dt>
	<dd>For the Google-o-meter (thermometer-style) chart, this is the label that will show up next to the arrow.</dd>

	<dt><span style="color: blue;">title{<em>Title text</em>}</span></dt>
	<dd>Title text for a chart</dd>

	<dt><span style="color: blue;">title_attributes{<em>&lt;color&gt;,&lt;font size&gt;</em>}</span></dt>
	<dd>The color in RGB format, a comma, and the font size in points of the chart title; Example: <b>0000FF,20</b></dd>

	<dt><span style="color: blue;">completedapprovedpublished{<em>three character code</em>}</span></dt>
	<dd>
	
	Determine which Mad Blanks records are included in the aggregate calculation. This tag element is specified with
	three characters corresponding to the completed, approved, and published flags, respectively, of the Mad Blanks
	records. Each character is a <b>1</b>, <b>0</b> or <b>x</b>. The <b>1</b> means true, the <b>0</b> means false, and
	the <b>x</b> means &quot;don't care&quot;
	
	<br /><br />
	
	Examples:<br /> To only consider records that are completed, approved, and published, use <b>111</b> (This is the default.)
	<br />To only consider records that are published, and if you don't care if they are completed or approved, use <b>xx1</b>
	<br />To only consider records that are NOT published, but are completed and approved, use <b>110</b>
	
	</dd>

	<dt><span style="color: blue;">value{<em>text</em>}</span></dt>
	<dd>The value to be counted when using function <b>COUNT-VALUE</b>, <b>COUNT-VALUE-RATIO</b>, or <b>COUNT-VALUE-PERCENTAGE</b></dd>

	<dt><span style="color: blue;">order_by{<em>ASC</em> or <em>DESC</em> or <em>the portion of a MySQL query that would come after ORDER BY</em>}</span></dt>
	<dd><b>ASC</b> to sort from low to high or A to Z, <b>DESC</b> to sort from high to low or Z to A, OR the text that would follow <em>ORDER BY</em> in a MySQL query
	<br />
	<br />
	Notes:
	<br />
	You can use <b>order_by{chd ASC}</b> to order a Google bar chart by shorter to longer bars
	<br />
	You can use <b>order_by{chd DESC}</b> to order a Google bar chart by longer to shorter bars
	<br />
	You can use, for example, <b>order_by{FIND_IN_SET(data_01, 'Choice1,Choice3,Choice2,Choice4') ASC}</b> to always order a Google bar chart a certain way
	</dd>
	
	<dt><span style="color: blue;">member{<em>number</em>}</span></dt>
	<dd>For use with the SET-MEMBER function, use this tag element to specify which member of the ordered set to show</dd>

	</dl>

<p>Note that curly brackets cannot be included inside any of the above tag elements. Instead, use [:curlyl:] and [:curlyr:].
<p>Examples:</p>
<p>
<tt><span style="color: blue;">[:aggregate:function{MAX}:field{data_03}:]</span></tt> Display the maximum value found in any Mad Blanks record in field #3 using default critera (current category, records are completed, approved, and published)<br />
<tt><span style="color: blue;">[:aggregate:function{AVG}:field{data_03}:category{this}:ignore_empty_records{true}:]</span></tt> Display the average (mean) value of all the responses to field #3 in Mad Blanks records in the current category, ignoring records that have no response<br />
<tt><span style="color: blue;">[:aggregate:function{GOOGLE-CHART-PERCENTAGE}:chart_type{p3}:field{data_04}:chart_size{500x100}:chart_color{008000}:chart_no_response_label{No answer}:]</span></tt> Show the percentages of each answer given for field #4 in a three dimensional pie chart sized 500x100 pixels, with an overall color of green (008000) and the segment corresponding to no answer given labeled with &quot;No answer&quot;

</p>
</dd>

<dt><span style="color: blue;">[:expression_group:]</span></dt> <dd> <p>This special tag is nearly identical in form and
function to the <em>aggregate</em> tag, except that it is used to calculate aggregate statistics for groups of 
<b>expressions</b> defined in the current Score Script, rather than statistics based on records that have been submitted.
Instead of the <b>field</b> tag element as used in the aggregate tag, use the <b>group_name</b> element the same way to
choose which named group of <em>expression</em> tags to work with. As with the <em>aggregate</em> tag, each tag element
entry must be separated by a colon.</p>

<p> Examples:</p>

<p>

<tt><span style="color: blue;">[:expression_group:group_name{victor}:function{MAX}:]</span></tt> Display the maximum
value found among the expressions in the expression group named <em>victor</em>

<br /> 

<tt><span style="color: blue;">[:expression_group:group_name{victor}:function{COUNT}:]</span>
</tt> Display the count of how many expressions there are in the expression group named <em>victor</em>

<br />

<tt><span style="color: blue;">[:expression_group:function{GOOGLE-CHART-PERCENTAGE}:group_name{victor}:chart_type{p3}:chart_size{500x100}:chart_color{008000}:]</span></tt>

Show the percentages of each value given among the members of the expression group named <em>victor</em> in a three
dimensional pie chart sized 500x100 pixels, with an overall color of green (008000)

<br />

<tt><span style="color: blue;">[:expression_group:function{CONCAT}:group_name{tango}:concat_separator{[:semicol:]}:]</span>
</tt> Show a list of all the values held in the expressions that belong to expression group <em>tango</em>, separated by
semicolons

<br />

<tt><span style="color: blue;">
[:expression_group:function{CONCAT}:group_name{tango}:ignore_empty_records{true}:order_by{DESC}:]</span></tt> Show a list of
all the values held in the expressions that belong to expression group <em>tango</em>, ignoring any expressions without a
value (empty expressions), in descending (highest to lowest) order; note that by default Mad Blanks will assume the entries
are <em>SIGNED</em> integers and sort them accordingly

<br />

<tt><span style="color: blue;">
[:expression_group:function{CONCAT}:group_name{tango}:ignore_empty_records{true}:cast{CHAR}:order_by{ASC}:]</span></tt> Show
a list of all the values held in the expressions that belong to expression group <em>tango</em>, ignoring any expressions
without a value (empty expressions), in ascending (lowest to highest, or A to Z) order; note that by default Mad Blanks will
assume the entries are numbers and sort them accordingly, but in this case the use of the <b>cast{CHAR}</b> element tells
Mad Blanks to treat the expressions as characters, or words, and therefore to sort them alphabetically

<br />

<tt><span style="color: blue;">[:expression_group:order_by{DESC}:function{SET-MEMBER}:group_name{charlie}:cast{DECIMAL(5,2)}:ignore_empty_records{true}:member{1}:]</span></tt>

Take all the expressions in expression group <em>charlie</em>, sort them in descending (higher to lower) order, ignoring any
expressions without a value (empty expressions), and treating the data as a decimal number with 5 total digits and 2 digits
to the right of the decimal point, and return the <b>first</b> member of the set (set member 1)

<br />

<tt><span style="color: blue;">[:expression_group:order_by{DESC}:function{SET-MEMBER}:group_name{charlie}:cast{DECIMAL(5,2)}:ignore_empty_records{true}:member{2}:]</span></tt>

Take all the expressions in expression group <em>charlie</em>, sort them in descending (higher to lower) order, ignoring any
expressions without a value (empty expressions), and treating the data as a decimal number with 5 total digits and 2 digits
to the right of the decimal point, and return the <b>second</b> member of the set (set member 2)

<br />

<tt><span style="color: blue;">[:expression_group:order_by{DESC}:function{SET-MEMBER}:group_name{charlie}:cast{DECIMAL(5,2)}:ignore_empty_records{true}:member{3}:data_labels{short}:]</span></tt>

Take all the expressions in expression group <em>charlie</em>, sort them in descending (higher to lower) order, ignoring any
expressions without a value (empty expressions), and treating the data as a decimal number with 5 total digits and 2 digits
to the right of the decimal point, and return the <b>third</b> member of the set (set member 3); instead of the value of the
set member, the <em>data_labels{short}</em> element will cause the &quot;short label&quot; for the expression to be shown
instead

</p>
</dd>

<dt><span style="color: blue;">[:alphauserpoints:points{<em>number of points</em>}:]</span></dt>
<dd>

<p>This special tag is used to award or subtract points using the Alpha User Points framework. Mad Blanks awards points
using the "Mad Blanks Score Script" rule. (Upload the file <em>plgaup_quizpoints_madblanks.zip</em> to the Alpha User Points
component as a new rule to add it to the rules available to Alpha User Points.)</p>

<p>The curly braces can have text/digits inside them and/or other Score Script tags.</p>

<p>Each tag element described below must be separated by a colon. See the examples below the explanations of the
alphauserpoints elements.</p>
	
	<dl>

	<dt><span style="color: blue;">points{<em>number of points</em>}</span></dt>
	<dd>The number of points to add or subtract from the user's tally</dd>

	<dt><span style="color: blue;">reference_key{<em>text</em>}</span></dt>
	<dd>This is a unique &quot;reference key&quot;; Alpha Points will only award the points to the user one time per
	unique reference key. Therefore, you should use a reference key when you want the user to only be able to earn
	points once, for example, for taking a particular quiz.</dd>

	<dt><span style="color: blue;">note{<em>text</em>}</span></dt>
	<dd>Notes about the points awarded; this shows up in the &quot;data&quot; field when looking at a user's details in
	the Alpha User Points component back end.</dd>

	<dt><span style="color: blue;">function{<em>function name</em>}</span></dt>
	<dd>Advanced: Assign points using a different rule by specifying the rule's function name</dd>
	
	</dl>

<p>Note that curly brackets cannot be included inside any of the above tags. Instead, use [:curlyl:] and [:curlyr:].
<p>Examples:</p>
<p>
<tt><span style="color: blue;">[:alphauserpoints:points{5}:]</span></tt> Award the logged in user (if any) five Alpha User Points<br />
<tt><span style="color: blue;">[:alphauserpoints:points{-1}:]</span></tt> Subtract one point from the tally of the logged in user (if any)<br />
<tt><span style="color: blue;">[:alphauserpoints:points{[:percentage_correct:]}:reference_key{quiz1}:]</span></tt> Award the logged in user (if any) points equivalent to the percentage correct s/he scored on a Mad Blanks quiz. Uses reference key 'quiz1' so that if the user takes the quiz again, points will not be awarded again.<br />
<tt><span style="color: blue;">[:alphauserpoints:points{10}:reference_key{quiz2}:note{The user's answer to question 10 was [:info:10:user_response:]}:]</span></tt> Award 10 points to the logged in user (if any); uses reference key quiz2 so the user will not be awarded more points for taking the same quiz again; adds a note to the user's point details<br />
<tt><span style="color: blue;">[:alphauserpoints:points{7}:function{sysplgaup_content}:]</span></tt> Award the logged in user (if any) seven Alpha User Points using the &quot;Content&quot; rule.<br />
</p>
</dd>

<dt><span style="color: blue;">[:timeout:timeout{<em>relative time</em>}:]</span></dt>
<dd>

<p>This special tag displays a <b>1</b> if a specified time between when the user first loaded the Create Single Record module and now has already passed, or a <b>0</b> if the timeout has not yet occurred (the user still has time to complete the task). The <b>1</b> or <b>0</b> output can be used as input to other Score Script tags such as the <em>comparison</em> tag.</p>

<h3>Important note: The timeout tag cannot be used for a timeout longer than half the time specified in the <em>mbTimeoutDataTimeToLive</em> Mad Blanks configuration variable. (The <em>mbTimeoutDataTimeToLive</em> Mad Blanks configuration variable is set to <em>2 hours</em> by default.)</h3>

<p>The curly braces can have text/digits inside them and/or other Score Script tags.</p>

<p>Each tag element described below must be separated by a colon. See the examples below the explanations of the
timeout elements.</p>
	
	<dl>

	<dt><span style="color: blue;">timeout{<em>relative time</em>}</span></dt>
	<dd>This is an amount of time given to a user to complete his or her task. The amount of time is given in plain English. See the examples below. This tag element makes use of PHP's <em>strtotime()</em> function. See http://php.net/strtotime for more details.</dd>

	<dt><span style="color: blue;">userorsession{<em>user</em> or <em>session</em>}</span></dt>
	<dd>Setting this to <em>user</em> compares the given timeout to when the logged in user first accessed the Create
	Single Record module for this category and copy of the Create Single Record module. <em>Session</em> is the default,
	and uses the time when the Create Single Record module was first accessed during the current browser session.
	The non-logged in user can use a different web browser or wait for the session to time out in order to gain access
	to the quiz/survey/etc. again.</dd>
	
	</dl>

<p>Note that Joomla's <em>Global Configuration -> System -> Session Settings -> Session Lifetime</em> setting must be long 
enough to accommodate your desired timeout.</p>

<p>Note also that curly brackets cannot be included inside any of the above tags. Instead, use <em>[:curlyl:]</em> and 
<em>[:curlyr:]</em>.</p>

<p>Examples:</p>
<p>
<tt><span style="color: blue;">[:timeout:timeout{30 seconds}:]</span></tt> If the session user loads the Score Script 30 seconds or less than from the time s/he loaded the Create Single Record module, this will be <b>0</b>. Otherwise it will be <b>1</b>.<br />
<tt><span style="color: blue;">[:timeout:userorsession{user}:timeout{30 seconds}:]</span></tt> If the logged in user loads the Score Script 30 seconds or less than from the time s/he loaded the Create Single Record module, this will be <b>0</b>. Otherwise it will be <b>1</b>.<br />
<tt><span style="color: blue;">[:timeout:userorsession{session}:timeout{3 minutes 30 seconds}:]</span></tt> If the session user loads the Score Script 3 minutes and 30 seconds or less than from the time s/he loaded the Create Single Record module, this will be <b>0</b>. Otherwise it will be <b>1</b>.<br />
<tt><span style="color: blue;">[:timeout:userorsession{user}:timeout{1 hour}:]</span></tt> If the session user loads the Score Script one hour or less than from the time s/he loaded the Create Single Record module, this will be <b>0</b>. Otherwise it will be <b>1</b>.<br />
<tt><span style="color: blue;">[:comparison:{[:timeout:timeout{1 hour}:]}:==:{1}:{An hour or longer has passed since you started the survey.}:{Less than an hour has passed since you started the survey.}:]</span></tt> This is a practical example of showing a message in the Score Script based on whether the timeout has occurred or not.
</p>
</dd>

<dt><span style="color: blue;">[:include:&lt;<em>filename</em>&gt;:]</span></dt>
<dd>Include a file relative to Joomla's root that contains Score Script code and parse it as part of the Score Script</dd>

<dt><span style="color: blue;">&lt;countcharacter:<b><em>x</em></b>&gt;</span><em>some Score Script content that can include other special tags</em><span style="color: blue;">&lt;/countcharacter&gt;</span></dt>
<dd>Takes the content between the opening and closing tags and counts the number of times the (case-sensitive) character <b><em>x</em></b> occurs in that space, replacing the tags and everything between them with the resulting integer</dd>

<dt><br /><span style="color: blue;">[:popupwindow:{<b><i>window text/HTML content</i></b>}:{<b><i>window features and settings</i></b>}:]</span></dt>
<dd>

<p>Note that the popupwindow uses JavaScript to open the window, and is therefore not a reliable method to present
information to a website user. JavaScript may be disabled in her or his browser, and popup windows may be blocked. 
Double quotation marks should not be used in the content of the popupwindow. Instead, substitute single quotation
marks inside HTML tags and the [:quot:] special tag otherwise.</p>

<p>Examples:</p>

	<span style="color: blue;">[:popupwindow:{If it was not blocked, this window has just popped up.}:]</span>
	Simple example using plain text; <b>DON'T USE DOUBLE QUOTATION MARKS IN YOUR TEXT</b>,
	instead substitute single quotation marks<br />
	<span style="color: blue;">[:popupwindow:{&lt;b&gt;This is the &lt;span style='color: red;'&gt;popup window&lt;/span&gt; for category [:category_name:]&lt;/b&gt;}:{height=200, width=500, resizable=yes}:]</span>
	Example using HTML and special tags in the first argument and comma delimited window
	features in the second argument; these window features are the same as would be used for the third
	argument of JavaScript's window.open() method and are as follows:
	
	<table border="0">
	<tr><td colspan="2"><em>Note: non-numerical values can be set to <b>yes</b> or <b>no</b></em></td></tr>
	<tr><td>height</td><td>the height (in pixels) of the window's document display area</td></tr>
	<tr><td>left</td><td>the X coordinate (in pixels) of the window</td></tr>
	<tr><td>location</td><td>show the input field for entering URLs into the browser</td></tr>
	<tr><td>menubar</td><td>show the menu bar</td></tr>
	<tr><td>resizable</td><td>allow window to be resized</td></tr>
	<tr><td>scrollbars</td><td>show horizontal and vertical scrollbars when they are necessary</td></tr>
	<tr><td>status</td><td>show the status line</td></tr>
	<tr><td>toolbar</td><td>show the toolbar (back/forward buttons, etc.)</td></tr>
	<tr><td>top</td><td>the Y coordinate (in pixels) of the window</td></tr>
	<tr><td>width</td><td>the width (in pixels) of the window's document display area</td></tr>
	</table>
	
	<p>Note that JavaScript is not the same from browser to browser and some of these features may be unavailable in
	particular browsers.</p>

</dd>

<dt><span style="color: blue;">[:sqrt:{<em>operand</em>}:]</span></dt>
<dd>The square root of <em>operand</em></dd>

<dt><span style="color: blue;">[:pi:]</span></dt>
<dd>The value of Pi (approximately 3.141593)</em></dd>

<dt><span style="color: blue;">[:exp:{<em>operand</em>}:]</span></dt>
<dd>This tag is replaced with <b>e</b> raised to the power of <em>operand</em>; note that <b>e</b> is the base of the natural system of logarithms, or approximately 2.718282</dd>

<dt><span style="color: blue;">[:log:{<em>operand</em>}:{<em>base</em>}:]</span></dt>
<dd>Calculate the logarithm of <em>operand</em> using the base <em>base</em>; if <em>base</em> is not given, it defaults to <em>e</em> and so to the natural logarithm</dd>

<dt><span style="color: blue;">[:abs:{<em>operand</em>}:]</span></dt>
<dd>The absolute value of <em>operand</em></dd>

<dt><span style="color: blue;">[:pow:{<em>base</em>}:{<em>exp</em>}:]</span></dt>
<dd><em>Base</em> raised to the power of <em>exp</em></dd>

<dt><span style="color: blue;">[:round:{<em>value</em>}:{<em>precision</em>}:]</span></dt>
<dd><em>Value</em> rounded to the number of decimal places specified by <em>precision</em>; if <em>precision</em> is not given, 0 (zero) will be used as the precision, resulting in rounding to the nearest integer</dd>

<dt><span style="color: blue;">[:ceil:{<em>value</em>}:]</span></dt>
<dd>This tag is replaced with the next highest integer value by rounding up <em>value</em> if necessary</dd>

<dt><span style="color: blue;">[:floor:{<em>value</em>}:]</span></dt>
<dd>This tag is replaced with the next lowest integer value by rounding down <em>value</em> if necessary</dd>

<dt><span style="color: blue;">[:numeric:{<em>input</em>}:]</span></dt>
<dd>This tag is replaced with <b>1</b> if <em>input</em> is numeric or <b>0</b> otherwise</dd>


<dt><span style="color: blue;">[:subset_count:]</span></dt>
<dd>The number of questions in the subset as defined on the category edit page</dd>

<dt><span style="color: blue;">[:subset_ratio_correct:]</span></dt>
<dd>The number of correct responses divided by the number of questions in the subset with correct answers</dd>

<dt><span style="color: blue;">[:subset_percentage_correct:]</span></dt>
<dd>The number of correct responses divided by the number of questions in the subset with correct answers, expressed as a rounded whole number percentage</dd>

<dt><span style="color: blue;">[:subset_count:]</span></dt>
<dd>The number of questions in the subset as defined on the category edit page</dd>

<dt><span style="color: blue;">[:delete_record:]</span></dt>
<dd>Delete the record that was just submitted (if applicable); for example, use this with the <em>comparison</em> tag to delete the record if a certain criterion is not met in the user's submission</dd>


<dt><span style="color: blue;">[:replace:{<em>string to search for</em>}:{<em>replacement string
</em>}:&lt;start&gt;:]<em>Score Script content on which to perform the case-sensitive search and replace (may
contain other Score Script tags) </em>[:replace:&lt;end&gt;:]</span></dt>
<dd>

<p>Perform a case-sensitive search and replace. Use the <b>[:space:]</b> tag when searching for spaces to
replace.</p>

<p>Examples:</p>

<p>
<tt><span style="color: blue;">[:replace:{[:space:]}:{%20}:&lt;start&gt;:]Al Pacino[:replace:&lt;end&gt;:]</tt></span>
Replace the space in <em>Al Pacino</em> with the string <em>%20</em>. The end result is <b>Al%20Pacino</b>.<br />
<tt><span style="color: blue;">[:replace:{ain}:{ent}:&lt;start&gt;:]The rain in SPAIN falls mainly on the
plain.[:replace:&lt;end&gt;:]</tt></span> Replace all instances of lowercase <em>ain</em> in the Score Script
content with <b>ent</b>. The end result is <b>The rent in SPAIN falls mently on the plent.</b>
</p>

</dd>

<dt><span style="color: blue;">[:ireplace:{<em>string to search for</em>}:{<em>replacement string
</em>}:&lt;start&gt;:]<em>Score Script content on which to perform the case-insensitive search and replace
(may contain other Score Script tags)
</em>[:ireplace:&lt;end&gt;:]</span></dt>
<dd>

<p>Perform a case-insensitive search and replace. Use the <b>[:space:]</b> tag when searching for spaces to
replace.</p>

<p>Example:</p>

<p>
<tt><span style="color: blue;">[:ireplace:{ain}:{ent}:&lt;start&gt;:]The rain in SPAIN falls mainly on the
plain.[:ireplace:&lt;end&gt;:]</tt></span> Replace all instances of lowercase and/or uppercase <em>ain</em>
in the Score Script content with <b>ent</b>. The end result is <b>The rent in SPent falls mently on the
plent.</b>
</p>

</dd>

<dt><span style="color: blue;">[:urlencode:&lt;start&gt;:]</span>Text to URL-encode<span style="color: blue;">[:urlencode:&lt;end&gt;:]</span></dt>
<dd>URL-encode the input, replacing spaces with <b>+</b></dd>

<dt><span style="color: blue;">[:rawurlencode:&lt;start&gt;:]</span>Text to URL-encode<span style="color: blue;">[:rawurlencode:&lt;end&gt;:]</span></dt>
<dd>URL-encode the input, replacing spaces with <b>%20</b></dd>

<dt><span style="color: blue;">[:urldecode:&lt;start&gt;:]</span>Text to URL-decode<span style="color: blue;">[:urldecode:&lt;end&gt;:]</span></dt>
<dd>Decode URL-encoded input, replacing <em>+</em> symbols with spaces</dd>

<dt><span style="color: blue;">[:rawurldecode:&lt;start&gt;:]</span>Text to URL-decode<span style="color: blue;">[:rawurldecode:&lt;end&gt;:]</span></dt>
<dd>Decode URL-encoded input</dd>

</dl>
