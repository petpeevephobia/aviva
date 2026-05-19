<link rel="stylesheet" title="Style CSS" href="cwcalendar.css" type="text/css" media="all" />
<script type="text/javascript">
  var formatSplitter = " ";
  var monthFormat = "mmm";
  var yearFormat = "yyyy";
</script>

<script language="JavaScript"> 
function openNewWindow(URLtoOpen, windowName, windowFeatures) {
newWindow=window.open(URLtoOpen, windowName, windowFeatures); }
function popitup(url) {
	newwindow=window.open(url,'name','height=561,width=867');
	if (window.focus) {newwindow.focus()}
	return false;
}
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

        <p><?php
  
  $formularAnzeigen = false;
  if (!empty($_POST["senden"]) && (
      empty($_POST["vorName"]) ||
     // empty($_POST["nachName"]) || ; Commented on 24/8/11 by Simos.
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
    echo '<span style="color: #FF0000; font-size: x-large;">Please fill out everything.</span>';
   /*   echo "<script type=\"text/javascript\">";
   echo "alert (\"Please fill out everything\");"; 
   echo  "</script>"; */
   
  } else if (!empty($_POST["senden"]) &&
             !isEmail($_POST["eMail"])) {
    $formularAnzeigen = true;  
    echo '<span style="color: #FF0000; font-size: x-large;">The email address is not correct.</span>';
  } else if (empty($_POST["senden"])) {
    $formularAnzeigen = true;  
  }
  if ($formularAnzeigen) {
?>
<form name="kontaktFormular" method="post" action="<?=$_SERVER[PHP_SELF]; ?>" onSubmit="return isValid()">
  <table width="680" border="0" class="regtable">

<!--anfang vorName-->  
    <tr>
      <td><div align="center"></div></td>
      <td><strong>
        First & Last Name:
      </strong></td>
      <td>
      <input name="vorName" type="text" size="30" value="<?=$_POST['vorName']; ?>" /></td>

      <td width="35%">

        </td>        
    </tr>

    <tr>
      <td><div align="center"></div></td>
      <td><strong>
        Nationality:
      </strong></td>
      <td><input name="nationality" type="text" size="30" id="nationality" value="<?=$_POST['nationality']; ?>" size="20" /></td>
      <td>
      </td>          
    </tr>
<!--ende nationality--> 
<!--anfang gebDatum-->
    <tr>
      <td><div align="center"></div></td>
      <td><strong>
        Date of Birth (mm.dd.yy):
      </strong></td>
      <td><input name="gebDatum" type="text" size="30" id="Gebdatum" value="<?=$_POST['gebDatum']; ?>" size="20" /></td>
      <td>
      </td>          
    </tr>
<!--ende gebDatum--> 
<!--anfang geschlecht-->
    <tr>
      <td><div align="center"></div></td>
      <td><strong>
        Gender:
      </strong></td>
        <td><input type = 'Radio' Name ='geschlecht' id="geschlecht" value= 'Male'>Male
         &nbsp;&nbsp;&nbsp; <input type = 'Radio' Name ='geschlecht' id="geschlecht" value= 'Female'>Female
         </td> 
      <td>
      </td>
    </tr>
<!--ende gebschlecht-->
<!--anfang eMail-->        
    <tr>
      <td><div align="center"></div></td>
      <td><strong>
        Email:
      </strong></td>
      <td><input name="eMail" type="text" size="30" id="eMail" value="<?=$_POST['eMail']; ?>" /></td>
      <td>
      </td>      
    </tr>
<!--ende eMail-->
<!--anfang betreff1-->
    <tr>
      <td><div align="center"></div></td>
      <td><strong>
        Phone:
      </strong></td>
      <td><input name="betreff1" type="text" size="30" id="betreff1" value="<?=$_POST['betreff1']; ?>" size="20" /></td>
      <td>
      </td>          
    </tr>
<!--ende betreff1-->  
<!--anfang adresse-->
    <tr>
      <td><div align="center"></div></td>
      <td><strong>
        Address:
      </strong></td>
      <td><textarea name="adresse" cols="23" rows="1"><?=$_POST['adresse']; ?></textarea></td>
      <td>
      </td>
    </tr>
<!--ende adresse-->
<!--anfang beruf-->
    <tr>
      <td><div align="center"></div></td>
      <td><strong>
        Occupation:
      </strong></td>
      <td><input name="beruf" type="text" size="30" id="beruf" value="<?=$_POST['beruf']; ?>" size="20" /></td>
      <td>
      </td>          
    </tr>
<!--ende beruf-->   
<!--anfang betreff2-->    
    <tr>
      <td><div align="center"></div></td>
      <td><strong>I would like to learn:</strong></td>
      <td><select name="betreff2" id="betreff2">
        <option<?=($_POST['betreff2']=='Deutsch')?' selected':' '?>>German</option>
        <option<?=($_POST['betreff2']=='Englisch')?' selected':' '?>>English</option>
        <option<?=($_POST['betreff2']=='Französisch')?' selected':' '?>>French</option>
        <option<?=($_POST['betreff2']=='Italian')?' selected':' '?>>Italian</option>
        <option<?=($_POST['betreff2']=='Spanisch')?' selected':' '?>>Spanish</option>
        <option<?=($_POST['betreff2']=='Greek')?' selected':' '?>>Greek</option>
        <option<?=($_POST['betreff2']=='Chinesisch')?' selected':' '?>>Chinese</option>
        <option<?=($_POST['betreff2']=='Japanisch')?' selected':' '?>>Japanese</option>
        <option<?=($_POST['betreff2']=='Polish')?' selected':' '?>>Polish</option>
        <option<?=($_POST['betreff2']=='Russian')?' selected':' '?>>Russian</option>
        <option<?=($_POST['betreff2']=='Other')?' selected':' '?>>Other</option>
      </select>
      <strong>   &nbsp;&nbsp;&nbsp; Level:</strong>
      <select name="level" id="level">
        <option<?=($_POST['level']=='Anfänger 1')?' selected':' '?>>Total Beginner</option>
        <option<?=($_POST['level']=='Anfänger 2')?' selected':' '?>>Lower Beginner</option>
        <option<?=($_POST['level']=='Anfänger 3')?' selected':' '?>>Upper Beginner</option>
        <option<?=($_POST['level']=='Untere Mittelstufe')?' selected':' '?>>Lower Intermediate</option>
        <option<?=($_POST['level']=='Obere Mittelstufe')?' selected':' '?>>Upper Intermediate</option>
        <option<?=($_POST['level']=='Untere Fortgeschrittene')?' selected':' '?>>Lower Advanced</option>
        <option<?=($_POST['level']=='Obere Fortgeschrittene')?' selected':' '?>>Upper Advanced</option>
      </select></td>
      </td>
      <td>
      </td>          
    </tr>
<!--ende betreff2-->
<!--anfang level-->    
    <tr>
      <td><div align="center"></div></td>
      <td>
      <td>
      </td>          
    </tr>
<!--ende level-->
<!--anfang programm-->    
    <tr>
      <td><div align="top"></div></td>
      <td><strong>
        Program: </strong> <br /></td>
      <td><select name="programm" id="programm">
        <option<?=($_POST['programm']=='Programm A')?' selected':' '?>>German Program A</option>
        <option<?=($_POST['programm']=='Programm B')?' selected':' '?>>German Program B</option>
        <option<?=($_POST['programm']=='Programm C')?' selected':' '?>>German Program C</option>
        <option<?=($_POST['programm']=='Programm D')?' selected':' '?>>German Program D</option>
        <option<?=($_POST['programm']=='Programm E')?' selected':' '?>>German Program E</option>
        <option<?=($_POST['programm']=='Programm F')?' selected':' '?>>German Program F</option>
        <option<?=($_POST['programm']=='English Evening')?' selected':' '?>>English Evening Classes</option>
        <option<?=($_POST['programm']=='French Evening')?' selected':' '?>>French Evening Classes</option>
        <option<?=($_POST['programm']=='Italian Evening')?' selected':' '?>>Italian Evening Classes</option>
        <option<?=($_POST['programm']=='Spanish Evening F')?' selected':' '?>>Spanish Evening Classes</option>
        <option<?=($_POST['programm']=='Greek Evening')?' selected':' '?>>Greek Evening Classes</option>
        <option<?=($_POST['programm']=='Chinese Evening')?' selected':' '?>>Chinese Evening Classes</option>
        <option<?=($_POST['programm']=='Japanese Evening')?' selected':' '?>>Japanese Evening Classes</option>   
        <option<?=($_POST['programm']=='Russian Evening')?' selected':' '?>>Russian Evening Classes</option>
        <option<?=($_POST['programm']=='Polish Evening')?' selected':' '?>>Polish Evening Classes</option>
        <option<?=($_POST['programm']=='andere')?' selected':' '?>>Other Languages</option>
        
      </select>
      <td>
      <span title="Please click here for more info." style="cursor: help; border-bottom: 1px dashed #000000;"><a href="/chart.php" onclick="return popitup('/chart.php')"
	>Chart</a></span>
      </td>          
    </tr>
<!--ende programm-->
<!--anfang beginn-->    
    <tr>
      <td><div align="top"></div></td>
      <td><strong>
        Starting Date:
      </strong></td>
      <td><input name="beginn" id="date" type="text" value="<?=$_POST['beginn'];   ?>" size="10" onclick='fPopCalendar("date")'/>
      <strong>
        Ending Date:</strong> <input name="dauer" id="date2" type="text" value="<?=$_POST['beginn']; ?>" size="10" onclick='fPopCalendar("date2")'/>
      </td>
      <td></td>
      <td>
      
       </td>     
    </tr>
<!--ende beginn-->

<!--anfang unterkunft-->    
    <tr>
      <td><div align="top"></div></td>
      <td><strong>
        Housing:</strong></td>
      <td><select name="unterkunft" id="unterkunft">
       <option<?=($_POST['unterkunft']=='keine Präferenz')?' selected':' '?>>Apartment single room</option>
        <option<?=($_POST['unterkunft']=='Appartment Doppelzimmer')?' selected':' '?>>Apartment double room</option>
        <option<?=($_POST['unterkunft']=='Gastfamilie Einzelzimmer')?' selected':' '?>>Guest family single room</option>
        <option<?=($_POST['unterkunft']=='Appartment Einzelzimmer')?' selected':' '?>>Any room available</option>
        <option<?=($_POST['unterkunft']=='Ich brauche keine Unterkunft')?' selected':' '?>>Don´t need housing</option>
      </select>
      <td>
      </td>          
    </tr>
<!--ende unterkunft-->

<!--start VisaCard-->
<tr>
      <td><div align="top"></div></td>
      <td><strong>
      Visa:</strong></td>
  
       <td><select name="visa" id="visa">
          <option<?=($_POST['visa']=='No')?' selected':' '?>>I do not need a visa for Germany</option>
          <option<?=($_POST['visa']=='No')?' selected':' '?>>I already have a visa for Germany</option>    
          <option<?=($_POST['visa']=='Yes')?' selected':' '?>>I need to extend my visa, please help</option>
         <option<?=($_POST['visa']=='Yes')?' selected':' '?>>I need a visa to come to Germany, please help</option>
      </select>
      <td>
      <span title="More information on Visa.You can apply for a Visa from there and there and there blah blah blah.We are happy to assist you on that!" style="cursor: help; border-bottom: 1px dashed #000000;"><a href="visainfo.html">More Info</a></span>

      </td>
   </tr>
 <!--end VisaCard-->      
<!--anfang nachricht-->      
    <tr>
      <td><div align="center"></div></td>
      <td><strong>
        Comments:
      </strong></td>
      <td><textarea name="nachricht" cols="20" rows="1"><?=$_POST['nachricht']; ?></textarea></td>
      <td>
        &nbsp;
      </td>          
    </tr>
<!--ende nachricht-->       

<!--anfang kopie-->        
    <tr>
      <td><div align="center"></div></td>
      <td colspan="3"><br /><input name="kopie" type="checkbox" value="checked" <?=$_POST['kopie']; ?>> <strong class="agbhighlight">I have read and accept the <a href="PDF/terms_and_conditions.pdf" target="_blank">terms and conditions</a>.</strong></td>
      <td>
        </td>
      <td>
      </td>          
    </tr>
<!--ende kopie--> 
    <tr>
      <td colspan="3">
        <div align="center">
        <br />
          <input name="senden" type="submit" value="register" />
        </div>
      </td>          
      <td>&nbsp;</td>          
    </tr>
  </table>
</form>

<?php
  echo'';
  } else {
    $eMail = '
    
Hello '.$_POST['vorName'].',

Thank you for registering with A-viva.
Please confirm your email address by replying back to this email, so that
we can proceed with your registration.
       
First & Last Name: '.$_POST['vorName'].'
Date of Birth: '.$_POST['gebDatum'].'
Gender: '.$_POST['geschlecht'].'
Occupation: '.$_POST['beruf'].'
Phone: '.$_POST['betreff1'].'
Address: '.$_POST['adresse'].'
Language: '.$_POST['betreff2'].'
Language Level: '.$_POST['level'].'
Program: '.$_POST['programm'].'
Starting Date: '.$_POST['beginn'].'
Ending date: '.$_POST['dauer'].'
Housing Preferences: '.$_POST['unterkunft'].'
Visa: '.$_POST['visa'].'
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
$MailTo="info@a-viva.net";
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
E-mail: $_POST[eMail]
Telephone: $_POST[betreff1]
Address: $_POST[adresse]\n
Birth Date: $_POST[gebDatum]
Occupation: $_POST[beruf]\n
LEVEL, PROGRAM AND HOUSING -------------------------------------------------\n
Level estimation: $_POST[level]
Program selected: $_POST[programm]
Housing preference: $_POST[unterkunft]\n
Starting date: $_POST[beginn]
Ending date: $_POST[dauer]
Visa: $_POST[visa]

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
        echo " We have just sent you a verification email. <b>Please make sure that you <br />
    respond to the email, so that we can proceed with your registration.</b> <br /><br />

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


