<link rel="stylesheet" title="Style CSS" href="cwcalendar.css" type="text/css" media="all" />
<script type="text/javascript">
  var formatSplitter = "-";
  var monthFormat = "mmm";
  var yearFormat = "yy";
</script>
<script type="text/javascript" src="calendar.js"></script>

 <script language="JavaScript"> 
function openNewWindow(URLtoOpen, windowName, windowFeatures) {
newWindow=window.open(URLtoOpen, windowName, windowFeatures); }

 function isValid() { 

   var msg = "";
   
   if (kontaktFormular.eMail.value.indexOf("@") < 1 ||
       kontaktFormular.eMail.value.indexOf(".") < 1) {
     msg += "- E-mail address is incorrect.\n";
   }
   
   if(kontaktFormular.vorName.value == "") {
     msg += "- Empty field: First Name\n";
   }

   if(kontaktFormular.nachName.value == "") {
     msg += "- Empty field: Last Name\n";
   }

   if(kontaktFormular.gebDatum.value == "") {
     msg += "- Empty field: Date of Birth\n";
   }

   if(kontaktFormular.betreff1.value == "") {
     msg += "- Empty field: Phone\n";
   }

   if(kontaktFormular.beginn.value == "") {
     msg += "- Empty field: Starting Date:\n";
   }


   
   if(msg == "") {
     return true;   
   }
   alert(msg);
   return false;
 }

</script>

        <h2 align="left"><strong>Registration</strong></h2>
        <p><?php

  $formularAnzeigen = false;
  if (!empty($_POST["senden"]) && (
      empty($_POST["vorName"]) ||
      empty($_POST["nachName"]) ||
      empty($_POST["gebDatum"]) ||
      empty($_POST["geschlecht"]) ||
      empty($_POST["eMail"]) ||
      empty($_POST["betreff1"]) ||
      empty($_POST["adresse"]) ||
      empty($_POST["betreff2"]) ||
      empty($_POST["level"]) ||
      empty($_POST["programm"]) ||
      empty($_POST["dauer"]) ||
      empty($_POST["unterkunft"]) ||
      empty($_POST["kopie"]) ||
      empty($_POST["beginn"]))) {
    $formularAnzeigen = true;
    echo '<span style="color: #FF0000; font-size: x-large;">Please fill out everything.</span></br></br>';
  } else if (!empty($_POST["senden"]) &&
             !isEmail($_POST["eMail"])) {
    $formularAnzeigen = true;  
    echo '<span style="color: #FF0000; font-size: x-large;">The email address is not correct.</span>';
  } else if (empty($_POST["senden"])) {
    $formularAnzeigen = true;  
  }
  if ($formularAnzeigen) {
?>
<!--anfang infos 1-->  
<td colspan="2"><strong>
        Please complete the form below, we will then email you a secure link for payment.
        </br>For further information please click <a href="index.php?option=com_content&amp;view=article&amp;id=26:further-info">here.</a> <br /> <br />
        <font color="red">Please fill in all the fields.</font><br /><br />
        </strong></td>
<!--ende infos 1--> 


<form name="kontaktFormular" method="post" action="<?=$_SERVER[PHP_SELF]; ?>" onSubmit="return isValid()">
  <table width="650" border="0" class="regtable" bordercolor="#FFCC00" style="background-color:#FFFFCC" cellpadding="6" cellspacing="6">
  
<!--anfang vorName-->  
    <tr>
    <td colspan="4"> <!-- start of 1st column -->
    
    
    <strong>
        First Name:
      </strong>
      <input name="vorName" type="text" value="<?=$_POST['vorName']; ?>" size="15" />
      <br/>
      
<!--ende vorName-->

<!--anfang nachName-->    

      <strong>
        Last Name:
      </strong>
      <input name="nachName" type="text" value="<?=$_POST['nachName']; ?>" size="15"  />
      <br/>
<!--ende nachName-->
<!--anfang gebDatum-->

      <strong>
        Date of Birth:
   
      <input name="gebDatum" type="text" id="Gebdatum" value="<?=$_POST['gebDatum']; ?>" size="15" />
	  <br/>
<!--ende gebDatum--> 
<!--anfang geschlecht-->

      <strong>
        Gender 
      </strong>
      <input type = 'Radio' Name ='geschlecht' id="geschlecht" value= 'Male'>Male
      <input type = 'Radio' Name ='geschlecht' id="geschlecht" value= 'Female'>Female
       <br/>
<!--ende gebschlecht-->
<!--anfang eMail-->        
  
      <strong>
        Email:
      </strong>
      <input name="eMail" type="text" id="eMail" value="<?=$_POST['eMail']; ?>" size="15"  />
      <br/><br/>
<!--ende eMail-->
<!--anfang betreff1-->

      <strong>
        Phone:
      </strong>
      <input name="betreff1" type="text" id="betreff1" value="<?=$_POST['betreff1']; ?>" size="15" />
      <br />
<!--ende betreff1-->  
<!--anfang adresse-->
 
      <strong>
        Address:
      </strong>
      <textarea name="adresse" cols="10" rows="2"><?=$_POST['adresse']; ?></textarea>
       <br />
<!--ende adresse-->
<!--anfang beruf-->
  <strong>
        Occupation:
      </strong>
      <input name="beruf" type="text" id="beruf" value="<?=$_POST['beruf']; ?>" size="15" />
       <br />
       
       
<!--ende beruf-->  
</td>  <!-- end of 1st column -->
 <td colspan="2"> <!-- start of 2st column -->
<!--anfang betreff2-->    
  
      <strong> <br />I would like to learn:</strong>
      <select name="betreff2" id="betreff2">
        <option<?=($_POST['betreff2']=='Deutsch')?' selected':' '?>>German</option>
        <option<?=($_POST['betreff2']=='Englisch')?' selected':' '?>>English</option>
        <option<?=($_POST['betreff2']=='Italian')?' selected':' '?>>Italian</option>
        <option<?=($_POST['betreff2']=='Französisch')?' selected':' '?>>French</option>
        <option<?=($_POST['betreff2']=='Spanisch')?' selected':' '?>>Spanish</option>
        <option<?=($_POST['betreff2']=='Chinesisch')?' selected':' '?>>Chinese</option>
        <option<?=($_POST['betreff2']=='Japanisch')?' selected':' '?>>Japanese</option>
      </select>
      <br/>
<!--ende betreff2-->
<!--anfang programm-->    
      <strong>
        Program: </strong> 
        <select name="programm" id="programm">
        <option<?=($_POST['programm']=='Programm A')?' selected':' '?>>German Program A</option>
        <option<?=($_POST['programm']=='Programm B')?' selected':' '?>>German Program B</option>
        <option<?=($_POST['programm']=='Programm C')?' selected':' '?>>German Program C</option>
        <option<?=($_POST['programm']=='Programm D')?' selected':' '?>>German Program D</option>
        <option<?=($_POST['programm']=='Programm E')?' selected':' '?>>German Program E</option>
        <option<?=($_POST['programm']=='Programm F')?' selected':' '?>>German Program F</option>
        <option<?=($_POST['programm']=='andere')?' selected':' '?>>other Languages</option>
      </select>
      <br />
      
<!--ende programm-->
<!--anfang beginn-->    
    <strong>
       Starting Date:
      </strong>
      <input name="beginn" id="date" type="text" value="<?=$_POST['beginn']; ?>" size="15" onclick='fPopCalendar("date")'/>
       <br />
<!--ende beginn-->
<!--anfang dauer-->    
    <strong>
        Ending Date:
          </strong>
      <input name="dauer" id="date2" type="text" value="<?=$_POST['beginn']; ?>" size="15" onclick='fPopCalendar("date2")'/>
     <br />
<!--ende dauer-->
<!--anfang unterkunft-->    
	<strong>
        Housing Preference:</strong>
      <select name="unterkunft" id="unterkunft">
        <option<?=($_POST['unterkunft']=='keine Präferenz')?' selected':' '?>>Appartement single room</option>
        <option<?=($_POST['unterkunft']=='Appartment Doppelzimmer')?' selected':' '?>>Appartement double room</option>
        <option<?=($_POST['unterkunft']=='Gastfamilie Einzelzimmer')?' selected':' '?>>Guest family single room</option>
        <option<?=($_POST['unterkunft']=='Appartment Einzelzimmer')?' selected':' '?>>Any room available</option>
        <option<?=($_POST['unterkunft']=='Ich brauche keine Unterkunft')?' selected':' '?>>Don´t need housing</option>

      </select>
      </br>
      
<!--ende unterkunft-->

<!--anfang level-->    
    <strong>Estimated Language Level:</strong>
      <select name="level" id="level">
        <option<?=($_POST['level']=='Anfänger 1')?' selected':' '?>>Total Beginner</option>
        <option<?=($_POST['level']=='Anfänger 2')?' selected':' '?>>Lower Beginner</option>
        <option<?=($_POST['level']=='Anfänger 3')?' selected':' '?>>Upper Beginner</option>
        <option<?=($_POST['level']=='Untere Mittelstufe')?' selected':' '?>>Pre Intermediate</option>       
        <option<?=($_POST['level']=='Untere Mittelstufe')?' selected':' '?>>Lower Intermediate</option>
        <option<?=($_POST['level']=='Obere Mittelstufe')?' selected':' '?>>Upper Intermediate</option>
        <option<?=($_POST['level']=='Untere Fortgeschrittene')?' selected':' '?>>Lower Advanced</option>
        <option<?=($_POST['level']=='Obere Fortgeschrittene')?' selected':' '?>>Upper Advanced</option>
      </select></br>
      
<!--ende level-->

<!--start LastCourse-->  
  
     <strong>My last German course was :</strong>
      <select name="day" id="day">
    <?php
       for($day=0;$day<=12;$day++) {
       echo "<option>$day</option>\n\t";
      }
      ?>
      </select> 
      <select name="period" id="period">
          <option<?=($_POST['last_course']=='weeks')?' selected':' '?>>week(s)</option>
          <option<?=($_POST['last_course']=='months')?' selected':' '?>>month(s)</option>
      </select>
      ago
      </br>
      
<!--end LastCourse-->  

<!--start Place-->    

	  <strong>My last German course was in:</strong>
       <select name="place" id="place">
        <option<?=($_POST['place']=='Germany')?' selected':' '?>>Germany</option>
        <option<?=($_POST['place']=='Austria')?' selected':' '?>>Austria</option>
        <option<?=($_POST['place']=='Switzerland')?' selected':' '?>>Switzerland</option>
        <option<?=($_POST['place']=='non-German')?' selected':' '?>>a non-German speaking country</option>
      </select></br>
<!--end Place-->

<!--anfang nachricht-->      
  <strong>
        Comments:
      </strong>
      <textarea name="nachricht" cols="22" rows="5"><?=$_POST['nachricht']; ?></textarea>
      </br></td>
      </tr>

<!--ende nachricht-->

<!--anfang infos 2-->        
   <strong> <br /> 
        Please ensure that you have entered all information correctly, and please read our <a href="PDF/terms_and_conditions.pdf" target="_blank">terms and conditions</a> below, before clicking on "register".
        </strong><strong> <br /> 
    Following your online registration, you will receive an email from us immediately for verification purpose. Please reply to this verification email.<br /><br />

    Once we receive your email reply, we will confirm your registration within 24 hours.<br /><br />

    In case you do not find our verification email in your inbox, please check your junk/spam folder. It´s possible that your computer has misplaced it there as it does not yet recognize A-viva.
        </strong>
<!--ende infos 2-->  
<!--anfang kopie-->        
    
      <br /><input name="kopie" type="checkbox" value="checked" <?=$_POST['kopie']; ?>> <strong class="agbhighlight">YES, I have read and accept the <a href="PDF/terms_and_conditions.pdf" target="_blank">terms and conditions</a>.</strong>

<!--ende kopie--> 
  <button class="button" onclick="history.go(-1);">Back</button><!-- END content -->
        <div align="center">
        <br />
          <input name="senden" type="submit" value="register" />
        </div>
            </table></form>    


<?php
  echo'';
  } else {
    $eMail = '
    
Hello '.$_POST['vorName'].',

Thank you for registering with A-viva.
Please confirm your email address by replying back to this email, so that
we can proceed with your registration.
       
First Name: '.$_POST['vorName'].'
Last Name: '.$_POST['nachName'].'
Date of Birth: '.$_POST['gebDatum'].'
Gender: '.$_POST['geschlecht'].'
Phone: '.$_POST['betreff1'].'
Address: '.$_POST['adresse'].'
Occupation: '.$_POST['beruf'].'
Language: '.$_POST['betreff2'].'
Program: '.$_POST['programm'].'
Starting Date: '.$_POST['beginn'].'
Ending Date: '.$_POST['dauer'].'
Housing Preferences: '.$_POST['unterkunft'].'
Language Level: '.$_POST['level'].'
Your last German course was: '.$_POST['day'].' '.$_POST['period'].' ago,
in '.$_POST['place'].' .

Comments:
'.$_POST['nachricht'].'

Terms and Conditions: '.$_POST['kopie'].'
Email: '.$_POST['eMail'].'


Kind regards,
    
A-viva Team

_____________________________
A-viva Sprachschule
Rotlintstraße 64
60316 Frankfurt
Tel.: 069 9434 0963
Fax: 069 9753 92624
www.a-viva.net
info@a-viva.net';

###############################################################################
#
# E-mail Formular + Autoresponder by Matthias Kannengiesser
# Copyright 2001
# Update: 10.03.2006
#
###############################################################################
#
#
# Mail an Webmaster  ##########################################################
#
# Add your E-mail right here
#
$MailTo="simospar@gmail.com";
#
# Formating Date   ############################################################
#
$nowDay=date("m.d.Y");
$nowClock=date("H:i:s");
#
# Formating Body content ######################################################
#
$FormContent="
Registration has been recieved on $nowDay at $nowClock:\n\n
STUDENT'S PERSONAL INFOMARTION ---------------------------------------------\n
Language Chosen: $_POST[betreff2]
Firstname: $_POST[vorName]
Lastname: $_POST[nachName]
E-mail: $_POST[eMail]
Telephone: $_POST[betreff1]
Address: $_POST[adresse]\n
Birth Date: $_POST[gebDatum]
Occupation: $_POST[beruf]\n
LEVEL, PROGRAM AND HOUSING -------------------------------------------------\n
Level estimation: $_POST[level]
Program selected: $_POST[programm]

Housing preference: $_POST[unterkunft]
Starting date: $_POST[beginn]\n
Ending date: $_POST[dauer]

*********
 
*********

Comments: $_POST[nachricht]\n
----------------------------------------------------------------------------\n
";
#
#
$Subject="$_POST[vorName] $_POST[nachName]'s registration";
mail($MailTo, "$Subject", $FormContent, "From: $_POST[eMail]");
#
#
# Autoresponder   #############################################################
#
#
   $contents ="
   Dear $_POST[vorName]\n
   Thank you for registering with A-viva. 
   Please confirm your email address by replying back to this email, so that
   we may proceed with your registration.\n
   A-viva
   www.a-viva.net";
   mail( "$_POST[eMail]", "A-viva Confirmation email", "$contents\n\n","From:info@a-viva.net\n" );
#
#
# Flashsignal Variable   ######################################################
#
#
#$signal=1;
#echo "signal=$signal";
#
#
###############################################################################
    
    if (@mail("info@a-viva.net",
         "Neue Registrierung",
         $eMail)) {
      echo "Thank you for your registration.<br /><br />";
    } else {
      echo "Email transfer does not work right now, please try again later.<br />";
    }
    if ($_POST['kopie']) {
      if (@mail($_POST['eMail'],
           "Registration A-viva",
           $eMail)) {
        echo " We have just sent you a verification email. Please make sure that you <br />
    respond to the email, so that we can proceed with your registration. <br /><br />

      A-viva Team";
      }
    }
  }
  
  function isEmail($email) {
    $nonascii      = "\x80-\xff"; 
    $nqtext        = "[^\\$nonascii\015\012\"]";
    $qchar         = "\\[^$nonascii]";
    $protocol      = "(?:mailto:)";
    $normuser      = "[a-zA-Z0-9][a-zA-Z0-9_.-]*";
    $quotedstring  = "\"(?:$nqtext|$qchar)+\"";
    $user_part     = "(?:$normuser|$quotedstring)";
    $dom_mainpart  = "[a-zA-Z0-9][a-zA-Z0-9._-]*\.";
    $dom_subpart   = "(?:[a-zA-Z0-9][a-zA-Z0-9._-]*\.)*";
    $dom_tldpart   = "[a-zA-Z]{2,5}";
    $domain_part   = "$dom_subpart$dom_mainpart$dom_tldpart";
    $regex         = "$protocol?$user_part\@$domain_part";
    if (preg_match("/^$regex$/",$email)) {
      return true;
    }
    return false;
  }
  
  
?>
    </p>
      </div>
      <!-- END content -->
    </div><!-- BEGIN #footer -->
    
  </div>
<p class="impressum"> <br><br><br><br><br>
<a href="impressum.html" target="_blank">Impressum</a></p>


