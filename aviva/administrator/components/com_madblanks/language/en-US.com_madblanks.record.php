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
 * by Mad Blanks that can be inserted into record fields.
 * This file is inserted into the record edit screen as a reference.
 * This file can be translated and copied to a file of the same name with
 * 'english' replaced by the new language in the filename.
 * 
 * file version 1.2.0 20100106
 *
 * @package Mad_Blanks_Component
 * @author Chris Hallett <chris@madblanks.org>
 * @copyright Chris Hallett March 1, 2011
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 
 * @version 1.4.2
 */

defined('_JEXEC') or die('Direct Access to this location is not allowed.');
?>

<p><b>Key to special tags in the text that comes before and after (for reference only):</b></p>
<dl>
<dt>[:defaultperiod:]</dt>
<dd>If there is a question mark, exclamation point, or period as the last character 
of the field, leave it as is. If there is not, put a period.</dd>

<dt>[:defaultquestionmark:]</dt>
<dd>If there is a question mark, exclamation point, or period as the last character 
of the field, leave it as is. If there is not, put a question mark.</dd>

<dt>[:defaultexclamationpoint:]</dt>
<dd>If there is a question mark, exclamation point, or period as the last character 
of the field, leave it as is. If there is not, put an exclamation point.</dd>
<dl>


<p><b>You can use the following special tags in the fields on this page:</b></p>
<dl>
<dt>[:quot:]</dt>
<dd>Quotation mark</dd>

<dt>[:space:]</dt>
<dd>Space (useful at the beginning or end of the field because normal spaces are trimmed off the ends)</dd>

<dt>[:nbsp:]</dt>
<dd>Nonbreaking space</dd>

<dt>[:lt:]</dt>
<dd>Less-than sign</dd>

<dt>[:gt:]</dt>
<dd>Greater-than sign</dd>

<dt>[:br:]</dt>
<dd>Linebreak (new line)</dd>
</dl>


<p><b>You can use the following special tags to insert values from other fields into the fields on this page:</b></p>
<dl>
<dt>[:random@&lt;category id&gt;,&lt;field&gt;:]</dt>
<dd>

Insert the value from field number &lt;field&gt; in a record chosen at random in the category with id number &lt;category
id&gt;. You can provide multiple category/field pairs for the randomizer to choose from by separating them with
additional @ characters. Examples:<br /> To show a random entry for field seven in the category with id two: <tt>
[:random@2,7:]</tt><br /> To show a random entry for field nine in either the category with id two or the category with
id three: <tt>[:random@2,9@3,9:] </tt><br /> To show a random entry for field seven in category five, field four in
category ten, or field two in category one: <tt>[:random@5,7@10,4@1,2:]</tt><br />

<p><b>Note:</b> Once a tag is used, the value that tag returned is remembered
for the rest of the record processing. Therefore, if you use the same tag again within the same record, the same result
will be returned. If you want to create a newly randomized result, you must use a different tag. For example, instead of
using <tt>[:random@2,7:]</tt> again, use <tt>[:random@2,7@2,7:]</tt>.</p>

<p><b><a href="javascript: popupWindow( '<?php echo JUri::base(); ?>/administrator/index3.php?option=com_madblanks&amp;task=showreferencewindow', 'madblankscatref', screen.width/2, screen.height*0.667, 'yes' );">Click this link to open the <?php echo _MBL_CATEGORY_NAME_PLURAL;?> reference window.</a></b></p>
</dd>


<dt>[:lookup@&lt;record&nbsp;id&gt;,&lt;field&gt;:]</dt>
<dd>

<p>Insert the looked up value from record number &lt;record&nbsp;id&gt; and field number &lt;field&gt; within that record.
You can also use the keyword <em>this</em> in place of a record number to refer to the currently displayed record.
Examples:<br />To show the entry in record
#123 for field seven: <tt>[:lookup@123,7:]</tt><br />To show the entry for field nine of the currently displayed record:
<tt>[:lookup@this,9:]</tt></p>

<p>Note that the looked up value will appear exactly as it does in the looked up field, including the effects of any
field text formatting functions that may have been applied. To override the field text formatting functions that were
applied to the original and to optionally apply new field text formatting functions, append an additional argument within
the lookup tag as follows:</p>

<p><tt>[:lookup@&lt;record&nbsp;id&gt;,&lt;field&gt;,nnnn:]</tt></p>

<p>Here, each n is a zero or a one. All four digits as zeroes will cause <b>no</b> field text formatting functions to be
applied.
<br>The first n, set to 1, will cause &quot;<?php echo _MBL_APPLY_FORMATTING_STRTOUPPER;?>&quot; to be applied to the looked up value.
<br>The second n, set to 1, will cause &quot;<?php echo _MBL_APPLY_FORMATTING_STRTOLOWER;?>&quot; to be applied to the looked up value.
<br>The third n, set to 1, will cause &quot;<?php echo _MBL_APPLY_FORMATTING_UCWORDS;?>&quot; to be applied to the looked up value.
<br>The fourth n, set to 1, will cause &quot;<?php echo _MBL_APPLY_FORMATTING_UCFIRST;?>&quot; to be applied to the looked up value.</p>

<p>Examples:<br />To show the entry in record
#123 for field seven with <b>no</b> field text formatting functions applied, even though they may be applied in the
original field: <tt>[:lookup@123,7,0000:]</tt><br />To show the entry for field nine of the currently displayed record,
with &quot;<?php echo _MBL_APPLY_FORMATTING_UCWORDS;?>&quot; applied: <tt>[:lookup@this,9,0010:]</tt></p> </dd>

</dl>

<hr />

<p><b>IMPORTANT:</b> The text that appears in <b><font color="#0000ff">BLUE</font></b> will already display automatically
when a record is viewed on the front end. When entering data, be sure to adjust prepositions, other helper words, and
capitalization accordingly and to not repeat words that are already here in blue.</p>