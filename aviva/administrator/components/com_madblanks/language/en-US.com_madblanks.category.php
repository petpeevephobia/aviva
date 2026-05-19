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
 * file version 1.3.0 20100106
 *
 * @package Mad_Blanks_Component
 * @author Chris Hallett <chris@madblanks.org>
 * @copyright Chris Hallett March 1, 2011
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 
 * @version 1.4.2
 */

defined('_JEXEC') or die('Direct Access to this location is not allowed.');
?>

<dl><!-- definition list -->

<dt>[:quot:]</dt>
<dd>Quotation mark (do not use a normal quotation mark unless it is part of an HTML tag)</dd>

<dt>[:space:]</dt>
<dd>Space (useful at the beginning or end of the field because normal spaces are trimmed off the ends)</dd>

<dt>[:nbsp:]</dt>
<dd>Nonbreaking space</dd>

<dt>[:semicol:]</dt>
<dd>Semicolon (useful in semicolon-delimited lists)</dd>

<dt>[:lt:]</dt>
<dd>Less-than sign (do not use a normal less-than sign unless it is part of an HTML tag)</dd>

<dt>[:gt:]</dt>
<dd>Greater-than sign (do not use a normal greater-than sign unless it is part of an HTML tag)</dd>

<dt>[:br:]</dt>
<dd>Linebreak (new line)</dd>

<dt>[:a_or_an:]</dt>
<dd>Use this to automatically use the correct indefinite article based on the content of the field. If the field starts
with a vowel, this tag is replaced by "an"; otherwise this tag is replaced by "a".</dd>

<dt>[:A_or_An:]</dt>
<dd>Uppercase version of the indefinite article tag. If the field starts
with a vowel, this tag is replaced by "An"; otherwise this tag is replaced by "A".</dd>

<dt>[:defaultperiod:]</dt>
<dd>If there is a question mark, exclamation point, or period as the last character 
of the field, leave it as is. If there is not, put a period.</dd>

<dt>[:defaultquestionmark:]</dt>
<dd>If there is a question mark, exclamation point, or period as the last character 
of the field, leave it as is. If there is not, put a question mark.</dd>

<dt>[:defaultexclamationpoint:]</dt>
<dd>If there is a question mark, exclamation point, or period as the last character 
of the field, leave it as is. If there is not, put an exclamation point.</dd>

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
You can use the keyword <b>this</b> in place of a record id number to refer to the currently displayed record. You can
also use <b>scodata<em>N</em></b>, (where <em><b>N</b></em> is normally 1 or 2) in place of a field number to look up data
that was logged in the record by a Score Script.<br />

<br />Examples:<br />To show the entry in record
#123 for field seven: <tt>[:lookup@123,7:]</tt><br />To show the entry for field nine of the currently displayed record:
<tt>[:lookup@this,9:]</tt></p>

<p>Note that the looked up value will appear exactly as it does in the looked up field, including the effects of any
field text formatting functions that may have been applied. To override the field text formatting functions that were
applied to the original and to optionally apply new field text formatting functions, append an optional third argument within
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
with &quot;<?php echo _MBL_APPLY_FORMATTING_UCWORDS;?>&quot; applied: <tt>[:lookup@this,9,0010:]</tt></p>

<p><tt>[:lookup@&lt;record&nbsp;id&gt;,&lt;field&gt;,nnnn, m:]</tt></p>

<p>The optional fourth argument to the lookup tag, represented here as <i><b>m</b></i>, when set to <b>1</b>, will prevent the
per-category setting <em>CSS declarations, separated by semicolons, to apply to each record data field when displayed</em> 
from being applied to the looked up value. This argument should either be set to <b>1</b> or it should be left off completely from the lookup tag.</p>
</dd>

</dl>