<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php
    
    $url = JRoute::_("components/com_jquarks/assets/stylesheets/jquarks_style.css");
    $document =& JFactory::getDocument();
    $document->addHeadLink($url, "stylesheet", "rel");
?>

<!-- Score and answers status -->
<?php
    $score = $this->session->score;
    $totalScore = $this->totalQuestions - $this->totalInput + $this->inputEvaluated;
    $percent = $score * 100 / $totalScore;
?>

<br />
<div class="contentheading">
 <p>
     <span class="session-title"><?php echo JText::_('QUIZ').': ' ;?></span>
    <?php echo $this->session->title; ?>
 </p>
 <p>
     <span class="session-title"><?php echo JText::_('SCORE').': ' ;?></span>
    <?php echo  round($percent, 2) . '%&nbsp;&nbsp;&nbsp;'; ?>
     <span class="note-small">
          <?php echo JText::_('INPUT_QUESTIONS_ARE_NOT_RECORDED_IN_THE_SCORE'); ?>
     </span>
 </p>
 <p>
     <span class="session-title"><?php echo JText::_('IS_UNANSWERED').': ' ; ?></span>
    <?php echo $this->session->unanswered; ?>
 </p>
</div>

<!-- Answers details -->

<br />
<div >

<?php
/*
	// Initialize email variables:
	$to = "simospar@gmail.com";
    $subject = "HTML email";
	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

    //defining format for evaluated propositions
    $li      = '<li>';
    $eli     = '</li>';
    $ligreen = '<li class="green-li">';
    $corr    = '<span class="li-highlight-green">  ('  . JText::_('GOOD')    . ')</span>';
    $incorr  = '<span class="li-highlight-red">  ('    . JText::_('WRONG')   . ')</span>';
    $omi     = '<span class="li-highlight-orange">  (' . JText::_('OMITTED') . ')</span>';


     $idq = NULL; // contains the actual question id
     foreach ($this->results as $res) :

        // show question statement if this latter doesn't exist
        $idq_temp = $res->question_id;
        if ($idq_temp != $idq)
        {
            $idq = $idq_temp;
            if ($idq != NULL) {
                echo '</ul>';
            }
            echo '<br /><span class="session-title">' . $res->statement . '</span>';
            echo '<ul class="result-list">';
        }

        switch($res->type_id) :
                case 1: // input question
                    echo $li . $res->altanswer. $eli;
                    break;

                case 2: // option question
                    if ($res->answer_id != NULL) // exists in answers
                    {
                        if($res->correct) {
                            echo $ligreen . $res->answer . $corr . $eli; //correct
                        } else {
                            echo $li . $res->answer . $incorr . $eli;  // incorrect
                        }

                    }
                    else
                    {
                        if ($res->correct) {
                            echo $ligreen . $res->answer . $eli;
                        } else {
                            echo $li . $res->answer . $eli;
                        }
                    }
                    break;

                 case 3: //checkbox question
                 case 4: // option as checkbox
                          if($res->correct) {
                              $debut = $ligreen . $res->answer;
                          } else {
                              $debut = $li      . $res->answer;
                          }
                          if (is_null($res->status))
                          {
                              $fin = $eli;
                          }
                          else
                          {
                              switch($res->status)
                              {
                                  case -2: $fin = $eli;           break;
                                  case  0: $fin = $incorr . $eli; break;
                                  case  1: $fin = $corr   . $eli; break;
                                  case  2: $fin = $omi    . $eli; break;
                              }
                          }
                          echo $debut.$fin;
                
         endswitch;
    endforeach;
    
    // Send email!
    //mail($to,$subject,$message,$headers);
    */
    ?>

</div>  

<?php    
	// Initialize email variables:
	$to = "info@a-viva.net";
	$subject = $this->session->givenname ." ". $this->session->familyname ." results.";
	//	$subject = print_r($this->session->givenname);
	//	echo $subject;

	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

    //defining format for evaluated propositions
    $li      = '<li>';
    $eli     = '</li>';
    $ligreen = '<li class="green-li">';
    $corr    = '<span style="color:green">  ('  . JText::_('GOOD')    . ')</span>';
    $incorr  = '<span style="color:red">  ('    . JText::_('WRONG')   . ')</span>';
    $omi     = '<span style="color:orange">  (' . JText::_('OMITTED') . ')</span>';

     // Show score and answer status
     $userPercent = round($percent, 2) . '%&nbsp;&nbsp;&nbsp;';
     
     $message = "Quiz: " .$this->session->title ." ";
     $message .= "<br>Score: $userPercent";
     $message .= "<br>Unanswered: " . $this->session->unanswered . "";
     
     $idq = NULL; // contains the actual question id
     foreach ($this->results as $res) 
     {

        // show question statement if this latter doesn't exist
        $idq_temp = $res->question_id;
        if ($idq_temp != $idq)
        {
            $idq = $idq_temp;
            if ($idq != NULL) {
                $message .= '</ul>';
            }
            $message .= "<br /><span class=\"session-title\">" . $res->statement . "</span>";
            $message .= "<ul class=\"result-list\">"; 
        }

          
        switch($res->type_id) :
                case 1: // input question
                    $message .= $li . $res->altanswer. $eli;
                    break;

                case 2: // option question
                    if ($res->answer_id != NULL) // exists in answers
                    {
                        if($res->correct) {
                            $message .= $ligreen . $res->answer . $corr . $eli; //correct
                        } else {
                            $message .= $li . $res->answer . $incorr . $eli;  // incorrect
                        }

                    }
                    else
                    {
                        if ($res->correct) {
                            $message .= $ligreen . $res->answer . $eli;
                        } else {
                            $message .= $li . $res->answer . $eli;
                        }
                    }
                    break;

      
       
                 case 3: //checkbox question
                 case 4: // option as checkbox
                          if($res->correct) {
                              $debut = $ligreen . $res->answer;
                          } else {
                              $debut = $li      . $res->answer;
                          }
                          if (is_null($res->status))
                          {
                              $fin = $eli;
                          }
                          else
                          {
                              switch($res->status)
                              {
                                  case -2: $fin = $eli;           break;
                                  case  0: $fin = $incorr . $eli; break;
                                  case  1: $fin = $corr   . $eli; break;
                                  case  2: $fin = $omi    . $eli; break;
                              }
                          }
                          //echo $debut.$fin;
                          $message = $debut.$fin;
      
         endswitch;
    }
    
    //echo $message; For debug purposes!
     
       
    // Send email!
    //$mail_sent =
     mail($to,$subject,$message,$headers);
	//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
    //echo $mail_sent ? "Mail sent" : "Mail failed"; 
    
?>