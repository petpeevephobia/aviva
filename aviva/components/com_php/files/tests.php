
 <style>
	.listQuizzes li {list-style:none ; }
	.listQuizzes img {vertical-align: bottom; }
	.quiz {margin-bottom: 20px ;}
	.quiz li {margin-bottom: 2px; }
</style>
<td valign="top">
<h2><strong>Tests</strong></h2>

<font color="#990000"><h2><b>German Tests</b></h2></font><br>


<ul class="listQuizzes">
	 	
  <li class="quiz">
     
    <h4><strong>A1 Lower Beginner:</strong></h4><br/>

	<!-- Create 1st form -->
	<form name="quiz_info" method="post">
	<?php 
	//$link =  JRoute::_('index.php?option='. $option . '&controller=quiz&layout=default') ;
	echo '<input id="proceedButton" name="proceedButton" value="Take the test online" type="submit" />' ;
	echo '<a href="PDF/A1_Schritte.pdf"><strong>&nbsp;&nbsp;&nbsp;Download as PDF</strong></a></p>'
	?>
	
    <input type="hidden" name="option" value="com_jquarks" />
    <input type="hidden" name="id" value="1"/>
    <input type="hidden" name="task" value="showQuiz" />
    <input type="hidden" name="view" value="quiz" />
    <input type="hidden" name="layout" value="default" />
    <?php echo JHTML::_( 'form.token' );  ?>
    </form>
	</li>
			
	<li class="quiz">
	<h4><strong>A2 Upper Beginner:</strong></h4><br/>
	<!-- Create 2nd form -->
	<form name="quiz_info" method="post">
	<?php 
	echo '<input id="proceedButton" name="proceedButton" value="Take the test online" type="submit" />' ;
    echo '<a href="PDF/A2_Schritte.pdf"><strong>&nbsp;&nbsp;&nbsp;Download as PDF</strong></a></p>';
	?>
	
    <input type="hidden" name="option" value="com_jquarks" />
    <input type="hidden" name="id" value="2"/>
    <input type="hidden" name="task" value="showQuiz" />
    <input type="hidden" name="view" value="quiz" />
    <input type="hidden" name="layout" value="default" />
    <?php echo JHTML::_( 'form.token' );  ?>
    </form>
	</li>
	
		<li class="quiz">
	<h4><strong>B1 / B2 Pre-Intermediate / Intermediate:</strong></h4><br/>
	<!-- Create 3rd form -->
	<form name="quiz_info" method="post">
	<?php 
	echo '<input id="proceedButton" name="proceedButton" value="Take the test online" type="submit" />' ;
	echo '<a href="PDF/B1_Schritte.pdf"><strong>&nbsp;&nbsp;&nbsp;Download as PDF</strong></a></p>';
	?>
	
    <input type="hidden" name="option" value="com_jquarks" />
    <input type="hidden" name="id" value="3"/>
    <input type="hidden" name="task" value="showQuiz" />
    <input type="hidden" name="view" value="quiz" />
    <input type="hidden" name="layout" value="default" />
    <?php echo JHTML::_( 'form.token' );  ?>
    </form>
	</li>
