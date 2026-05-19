<?php 
	defined('_JEXEC') or die('Restricted access'); 
	
	global $mainframe ;
        
    $context   = 'com_jquarks.setofquestions.custom.list.' ;
    $search    = $mainframe->getUserStateFromRequest( $context.'search', 'search', '', 'string') ;
    $search    = JString::strtolower($search) ;
    
	$urlCountQuestions = "index.php?option=com_jquarks&controller=setsofquestions&view=setofquestions&task=countQuestions" ;

$ajax = <<<DOC
	
	var AJAX_QUEUE = [];

	Ajax = Ajax.extend({
 
	    initialize: function( url, options ) {
	        this.parent( url, options );
	        this.ready = false;
	        this.output = '';
	    },
	 
	    onComplete: function() {
	        this.ready = true;
	        this.parent();
	    }
	 
	});

	window.addEvent( 'domready', function() {
 
        $('filter_category_random').addEvent( 'change', function() {
			
        	$('availablenumber_ajaxLoading').empty().removeClass('hide') ;
            $('needednumber').value = '' ;
			
        	var a = new Ajax('{$urlCountQuestions}', {
                        method: 'get',
                        data:{ 'categoryId': $('filter_category_random').value },
                        onComplete: function( response ) {
                            
                        	var resp = Json.evaluate( response );
						 	$('availablenumber').value = resp.nbrQuestions ;
						 	
						 	while ( AJAX_QUEUE.length ) {
 
						        // If the oldest request in the queue is not ready, do nothing.
						        if ( !AJAX_QUEUE[0].ready ) break;
						 
						        // Pop the request from the queue.
						        r = AJAX_QUEUE.shift();
						 
						        // Only output to document when queue is empty.
						        if ( !AJAX_QUEUE.length ) {
						            $('availablenumber_ajaxLoading').addClass('hide') ;
						        }
						 
							}
						 	
                        }
                        
            })
            AJAX_QUEUE.push( a );
            a.request();
            
		});
	})
DOC;

	$doc = & JFactory::getDocument();
	$doc->addScriptDeclaration( $ajax );
		
?>
<style>
	.hide { display: none ;}
</style>

<script language="javascript" type="text/javascript">

	function getXhr()
	{
		var xhr = null;
		if(window.XMLHttpRequest) {
			xhr = new XMLHttpRequest();
		} 
		else if(window.ActiveXObject)
		{ 
			try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} 
		else 
		{
			alert("NO_SUPPORT_XMLHTTPREQUEST");
			xhr = false;
		}
		return xhr;
	}

	function clearMessages()
	{
		// remove joomla messages
		statusMessage = document.getElementsByTagName('dl') ;
		if (statusMessage.length == 2)
		{
			JoomlaStatusMessage = statusMessage[0] ;
			JoomlaStatusMessage.parentNode.removeChild(JoomlaStatusMessage) ; 
		}
		
		// clear JQuarks messages
		messageDiv = document.getElementById('message') ;
		messageDiv.style.display = "none" ;

		var successList = document.getElementById('successList') ;
		successList.innerHTML = '' ;

		var errorList = document.getElementById('errorList') ;
		errorList.innerHTML = '' ;

		var noticeList = document.getElementById('noticeList') ;
		noticeList.innerHTML = '' ;
	}
	
	function addNotices(notices)
	{
		messageDiv = document.getElementById('message') ;
		messageDiv.style.display = "block" ;

		var noticeList = document.getElementById('noticeList') ;

		var noticeUL = document.createElement("UL") ;
		var noticeLI = new Array(notices.length) ;
		
		var i ;
		for (i = 0 ; i < notices.length ; i++)
		{	
			noticeLI[i] = document.createElement("LI") ;
			noticeLI[i].innerHTML = notices[i].message ; 
			noticeUL.appendChild(noticeLI[i]) ;
		}

		noticeList.appendChild(noticeUL) ;
	}

	function addError(error)
	{
		messageDiv = document.getElementById('message') ;
		messageDiv.style.display = "block" ;
	
		var errorList = document.getElementById('errorList') ;
		
		var errorUL = document.createElement("UL") ;
		var errorLI = document.createElement("LI") ; 

		errorLI.innerHTML = error ; 
		errorUL.appendChild(errorLI) ;
	
		errorList.appendChild(errorUL) ;
	}
	
	function addErrors(errors)
	{
		messageDiv = document.getElementById('message') ;
		messageDiv.style.display = "block" ;

		errorList = document.getElementById('errorList') ;
		
		var errorUL = document.createElement("UL") ;
		var errorLI = new Array(errors.length) ; 
		
		var i ;
		for (i = 0 ; i < errors.length ; i++)
		{	
			errorLI[i] = document.createElement("LI") ;
			errorLI[i].innerHTML = errors[i].message ; 
			errorUL.appendChild(errorLI[i]) ;
		}

		errorList.appendChild(errorUL) ;
	}

	function addSuccess()
	{
		messageDiv = document.getElementById('message') ;
		messageDiv.style.display = "block" ;

		var successList = document.getElementById('successList') ;

		var successUL = document.createElement("UL") ;
		var successLI = document.createElement("LI") ;
		successLI.innerHTML = "<?php echo JText::_('QUESTION_ASSIGNATION_STATE_CHANGED') ; ?>" ;
		successUL.appendChild(successLI) ; 
		successList.appendChild(successUL) ;
	}

	function submitSwitchAssignQuestion(questionId, soqId) 
	{
		clearMessages() ;
		
		var xhr = getXhr();
		
		xhr.onreadystatechange = function(){
			
	        if(xhr.readyState == 4 && xhr.status == 200)
		    {
	            try //Internet Explorer
	            {
		            xmlDoc= new ActiveXObject("Microsoft.XMLDOM");
	            	xmlDoc.async="false";
	            	xmlDoc.loadXML(xhr.responseText);
	            }
	            catch(e)
	            {
		            try //Firefox, Mozilla, Opera, etc.
		            {
			            parser= new DOMParser();
		                xmlDoc=parser.parseFromString(xhr.responseText,"text/xml");
		            } catch(e) {
			            alert(e.message) ; 
			        }
	        	}
			  
	        	var message = eval ("(" + xhr.responseText + ")")  ;

	        	// updating the image icon
	            image = document.getElementById('row'+questionId).getElementsByTagName('td')[2].getElementsByTagName('img')[0] ;
			    pattern = new RegExp("images/publish_x.png") ;

			    if ( message.errors.length == 0 ) 
				{
					if (message.notices.length > 0 ) {
						addNotices(message.notices) ;
					}
					
				    if ( pattern.test(image.src) ) {
					    image.src = "images/tick.png" ; 
				    } else {
				    	image.src = "images/publish_x.png" ;
				    }    

				    addSuccess() ;
				    
			    } else {
			    	addErrors(message.errors) ;
			    }
	     	}
		} 			

		xhr.open("GET","index.php?option=com_jquarks&controller=setsofquestions&view=setofquestions&task=assignQuestion&questionId="+questionId+"&soqId="+soqId,true);
        xhr.send(null);
	}
	
	function filter_questions() 
	{
		clearMessages() ;
		
		soqId = <?php echo $this->setOfQuestions->id ; ?> ;
		var xhr = getXhr();

		xhr.onreadystatechange = function(){
		 
	      if(xhr.readyState == 4 && xhr.status == 200)
		  {
	       	  var questionsList = document.getElementById('questionsList').getElementsByTagName('tbody')[0];
				
			  numberOfRow = questionsList.getElementsByTagName('tr').length ;			
			 
			  for (i = 0 ; i < numberOfRow ; i++) {
				  questionsList.deleteRow(0) ;
			  }
			
	    	  var questions = eval ("(" + xhr.responseText + ")")  ;

	    	  unassigned = "<?php echo JText::_('UNASSIGNED_SET') ;?>" ; 
			  assigned = "<?php echo JText::_('UNASSIGNED_SET') ;?>" ;
			  
	    	  for (i = 0 ; i < questions.questions.length ; i++ ) 
		      {
				 questionsList.insertRow(i) ;
				 currentRow = questionsList.getElementsByTagName('tr')[i] ;
			
				 currentRow.id = "row"+questions.questions[i].id ;

				 if ( i%2 == 0 ) {
					currentRow.className = "row0" ;
				 } else {
					currentRow.className = "row1" ;
				 }
				 
				 // creating the cell to be used
				 currentRow.insertCell(0);
				 currentRow.insertCell(1);
				 currentRow.insertCell(2);
				 currentRow.insertCell(3);
				 currentRow.insertCell(4);
				 
				  currentRow.cells[0].innerHTML = i+1 ;
				  currentRow.cells[1].innerHTML = "<a href=\"index.php?option=com_jquarks&view=question&task=edit&cid[]=" + questions.questions[i].id + "\"><code>" + questions.questions[i].value + "</code></a>" ;
				  currentRow.cells[2].align = "center" ;

				  if (questions.questions[i].assigned_id == 0) {
					  currentRow.cells[2].innerHTML = "<a onclick=\"submitSwitchAssignQuestion(" + questions.questions[i].id + ","+ soqId +");\" href=\"javascript:void(0)\"><img src=\"images/publish_x.png\" alt=\"" + unassigned + "\" title=\"" + unassigned + "\" /></a>" ;
				  } else  {
					  currentRow.cells[2].innerHTML = "<a onclick=\"submitSwitchAssignQuestion(" + questions.questions[i].id + ","+ soqId +");\" href=\"javascript:void(0)\"><img src=\"images/tick.png\" alt=\"" + assigned + "\" title=\"" + assigned + "\" /></a>" ;
				  } 
				  
				  currentRow.cells[3].innerHTML = questions.questions[i].category ;
				  currentRow.cells[4].innerHTML = questions.questions[i].id ;
			  }
	         
	     	}
		} 			
		
		/*xhr.open("POST","index.php", true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');*/
		category = document.getElementById('filter_category_custom') ;
		filter_category = category.options[category.selectedIndex].value ;

		assigned = document.getElementById('filter_assigned') ;
		filter_assigned = assigned.options[assigned.selectedIndex].value ;

		search = document.getElementById('search').value ;
		
		xhr.open("GET","index.php?option=com_jquarks&controller=setsofquestions&view=setofquestions&task=filter_questions&cid[]="+ <?php echo $this->setOfQuestions->id; ?> +"&filter_category_custom="+filter_category+"&filter_assigned="+filter_assigned+"&search="+search,true);
        xhr.send(null);
	}
	
	function submitbutton(pressbutton) 
	{
		clearMessages() ;
		
		var form = document.adminForm;

		if (pressbutton == 'cancel') 
		{
			submitform( pressbutton );
			return;
		}
	
		// do field validation
		if ("" == form.title.value) 
		{
			addError("<?php echo JText::_('PLEASE_PROVIDE_A_TITLE_FOR_THE_SET_OF_QUESTIONS') ; ?>") ;
			return false ;
		}

		if ( form.needednumber.value == '' || isNaN(form.needednumber.value) || parseInt(form.needednumber.value) < 0 || form.needednumber.value == null ) 
		{
			addError("<?php echo JText::_('ENTER_POSITIVE_NUMBER_OF_QUESTIONS') ; ?>") ;
			form.needednumber.focus() ;
		    form.needednumber.select() ;
			
			return false ;
		}

		if ( parseInt(form.availablenumber.value) < parseInt(form.needednumber.value))
		{
			addError("<?php echo JText::_('NOT_ENOUGH_QUESTIONS_AVAILABLE') ; ?>") ;
            form.needednumber.focus() ;
            form.needednumber.select() ;
            return false ;
		}

		if ("-1" == form.filter_category_random.value)
		{
			addError("<?php echo JText::_('PLEASE_SELECT_A_CATEGORY') ; ?>") ;
			return false ;
		}
		
		submitform( pressbutton );
	}

	function resetFilters() 
	{
		$('search').value=''; 
		$('filter_assigned').value='';
		$('filter_category_custom').value='-1'; 
		document.adminForm.submit();
		return true;
	}

</script>

<form action="index.php" method="post" name="adminForm" id="adminForm">	
	<div id="message" style="display:none;">
		<dl id="system-message">
			<dt class="notice">Notice</dt>
			<dd id="noticeList" class="notice message fade"></dd>

			<dt class="error">Error</dt>
			<dd id="errorList" class="error message fade"></dd>
			
			<dt class="message">Message</dt>
			<dd id="successList" class="message message fade"></dd>
		</dl>
	</div>
	<div class="col100">
		<fieldset class="adminfrom">
			<legend><?php echo JText::_( 'SET_OF_QUESTIONS' ); ?></legend>
			<table class="admintable" width="100%">
				<tr valign="top">
					<td >
					<table class="admintable">
					<tr>
						<td width="100" align="right" class="key">
							<label for="title">
								<?php echo JText::_( 'TITLE' ) ; ?>:
							</label>
						</td>
					
						<td>
							<input class="text_area" name="title" id="title" size="30" value="<?php echo $this->setOfQuestions->title ; ?>"/>						
						</td>
					</tr>
					<tr>
						<td width="100" align="right" class="key">
							<?php echo JText::_( 'TYPE' ) ; ?>:
						</td>	
						<td>
							<input class="radio" type="radio" name="soqtype" id="soqtypec" value="0" <?php if ( $this->setOfQuestions->type == 'custom' ) echo 'checked' ;?> onclick="submitbutton('changeType'); " /><label for="soqtypec"><?php echo JText::_('CUSTOM') ?></label>
							<input class="radio" type="radio" name="soqtype" id="soqtyper" value="1" <?php if ( $this->setOfQuestions->type == 'random' ) echo 'checked' ;?> onclick="submitbutton('changeType'); " /><label for="soqtyper"><?php echo JText::_('RANDOM') ?></label>
						</td>
					</tr>	
					</table>
					</td>
				</tr>			
			</table>			
		</fieldset>
		
		<div style="<?php if ( $this->setOfQuestions->type != 'custom'  ) : echo 'display:none;' ; endif ; ?>">
		<fieldset class="adminform">	
			<legend><?php echo JText::_('QUESTIONS') ; ?></legend>
			<table>
			<tr>
				<td align="left" width="100%">
					<?php echo JText::_( 'FILTER' );  ?>:
					<input type="text" name="search" id="search" value="<?php echo $search ; ?>" onclick="this.value=''" class="text_area"  />
					<button onclick="filter_questions();"><?php echo JText::_( 'GO' ); ?></button>				
					<button onclick="resetFilters();"><?php echo JText::_( 'RESET_FILTER' ); ?></button>
				</td>
				<td nowrap="nowrap">
					<?php
						echo $this->lists['status'] ;
					?>
				</td>
				<td nowrap="nowrap">
					<?php
						echo $this->lists['categoriesCustom'] ;
					?>
				</td>
			</tr>
			</table>				
				
			<table class="adminlist"  id="questionsList">
				<thead>
					<tr>
						<th width="20">
							<?php echo JText::_( 'NUM' ); ?>
						</th>			
						<th>
							<?php echo JHTML::_( 'grid.sort', 'Statement', 'statement', $this->lists['order_Dir'], $this->lists['order']); ?>
						</th>
						<th width="10%">
							<?php echo JHTML::_('grid.sort',  'assigned', 'assigned_id', $this->lists['order_Dir'], $this->lists['order']); ?>
						</th>			
						<th width="10%">
							<?php echo JHTML::_('grid.sort',  'Category', 'category', $this->lists['order_Dir'], $this->lists['order']); ?>						
						</th>
						<th width="5">
							<?php echo JHTML::_('grid.sort',  'ID', 'id', $this->lists['order_Dir'], $this->lists['order']); ?>						
						</th>
					</tr>
				</thead>	
				<tbody>
				<?php 
				$k = 0;
				for ($i = 0, $n = count( $this->questions ) ; $i < $n ; $i++) :
					$row =& $this->questions[$i];
					$link = JRoute::_( 'index.php?option=com_jquarks&view=question&task=edit&cid[]='. $row->id );
					?>
					<tr id=<?php echo "row$row->id" ; ?> class="<?php echo "row$k"; ?>">
						<td align="center">
							<?php echo $i+1; ?>
						</td>			
						<td>
							<a href="<?php echo JRoute::_( $link ); ?>"><?php echo $row->statement; ?></a>
						</td>	
						<td  align=center> 
							<?php if ( $row->assigned_id ) : ?>
										<a href="javascript:void(0)" onclick="submitSwitchAssignQuestion(<?php echo $row->id ; ?>,<?php echo $this->setOfQuestions->id ;?>);" ><img title="<?php echo JText::_('UNASSIGN_SET') ;?>" alt="<?php echo JText::_('UNASSIGN_SET') ;?>" src="images/tick.png" /></a>
							<?php else : ?>
										<a href="javascript:void(0)" onclick="submitSwitchAssignQuestion(<?php echo $row->id ; ?>,<?php echo $this->setOfQuestions->id ;?>);" ><img title="<?php echo JText::_('ASSIGN_SET') ;?>" alt="<?php echo JText::_('ASSIGN_SET') ;?>" src="images/publish_x.png"/></a>
							<?php endif ; ?>
						</td>
						<td>
							<?php if ($row->category) :
									 echo $row->category ;
								  else :
								  	 echo JText::_('UNCATEGORIZED') ;
								  endif ; 
							?>
						</td>
						<td>
							<?php echo $row->id ; ?>
						</td>
					</tr>
					<?php
					$k = 1 - $k;
				endfor ; 
				?>		
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5">
							<?php echo $this->pageNav->getListFooter() ; ?>
						</td>
					</tr>
				</tfoot>
			</table>
		</fieldset>
		</div>
	
		<div style="<?php if ( $this->setOfQuestions->type != 'random' ) : echo 'display:none;' ; endif ; ?>"> 		
			<fieldset class="adminform">
				<legend><?php echo JText::_('CATEGORIES') ; ?></legend>
				<table class="admintable">
					<tbody>
						<tr>
							<td width="100" align="right" class="key">
								<label for="filter_category_random">
									<?php echo JText::_( 'SELECT_CATEGORY' ) ; ?>:
								</label>
							</td>
							<td>
								<?php echo $this->lists['categoriesRandom'] ; ?>
							</td>	
						</tr>
						<tr>
							<td width="100" align="right" class="key">
								<?php echo JText::_( 'NUMBER_OF_QUESTION_IN_CATEGORY' ) ; ?>:
							</td>
							<td>
								<input style="background-color:#DDDDDD;" size="4" readonly="readonly" name="availablenumber" id="availablenumber" value="<?php echo $this->categoryQuestionCount ; ?>"/>
							    <img id="availablenumber_ajaxLoading" src="components/com_jquarks/assets/images/ajax-loader.gif" class="hide" />
							</td>
						</tr>
						<tr>
							<td width="100" align="right" class="key">
								<label for="needednumber">
									<?php echo JText::_( 'NUMBER_QUESTIONS' ) ; ?>:
								</label>
							</td>
							<td>
							    <?php if ($this->setOfQuestions->nquestions) : ?>
                                    <input class="text_area" size="4" maxlength="4" name="needednumber" id="needednumber" value="<?php echo $this->setOfQuestions->nquestions ; ?>" />								    
								<?php else : ?>
								    <input class="text_area" size="4" maxlength="4" name="needednumber" id="needednumber" value="0" />
								<?php endif ; ?>
							</td>
						</tr>
					</tbody>	
				</table>	
			</fieldset>
		</div>	
	</div>
	
	<div class="clr"></div>
 
	<input type="hidden" name="option" value="com_jquarks"/>
	<input type="hidden" name="cid[]" value="<?php echo $this->setOfQuestions->id; ?>" />
	<input type="hidden" name="questionId" value="" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="type" value="<?php echo $this->setOfQuestions->type ; ?>" />
	<input type="hidden" name="controller" value="setsofquestions" />
	<input type="hidden" name="view" value="setofquestions" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>