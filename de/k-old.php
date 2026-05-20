<?php
    /* PHP Kontaktformular

       Copyright 2005 by texmedia
       Markus Scherner
       http://www.texmedia.de

       Dieses Script darf für eigene Bedürfnisse angepasst und verändert werden sowie
       kostenlos benutzt werden. Gerne dürfen Sie dieses Script auch kostenlos
       verteilen und weitergeben, sofern unser texmedia Copyright in der Datei unverändert
       enthalten bleibt.
    */

    //-> BITTE ANPASSEN

    $pbetreff[0] = 'Bitte wählen Sie...';
    $pbetreff[1] = 'Programme';
    $pbetreff[2] = 'Reisen';
	$pbetreff[3] = 'Jobs';
	$pbetreff[4] = 'Andere';


    $empfaenger = 'info@a-viva.net';       // Dorthin werden Nachrichten geschickt
    $absender   = 'Kontaktformular';            // Absenderanzeige des Kontaktformulars

    $newpoint   = '<img src="./pics/stop.gif" width="16" height="16" align="absmiddle">&nbsp;';   // Fehlergrafik

    //--------------------------------------------------------------------------------------------------------------

    // Voreinstellung per Parameterübergabe
    if(isset($_GET['betreff']) && (int)$_GET['betreff']>0 && (int)$_GET['betreff']<count($pbetreff))
        $pflichtbetreff = true;

    if(isset($_POST['submit'])) {
        if(empty($_POST['name']))  {
            $Nachricht .= $newpoint."Bitte geben Sie Ihren <b>Namen</b> ein.<br>\n";
        } elseif(strlen($_POST['name']) < 2) {
            $Nachricht .= $newpoint."Ihren <b>Namen</b> hat bestimmt mehr als eine Buchstabe :-)<br>\n";
        }
        if(empty($_POST['land']))  {
            $Nachricht .= $newpoint."Geben Sie bitte Ihr <b>Land</b> ein.<br>\n";
        }
		if(empty($_POST['email']) && empty($_POST['telefon']))  {
            $Nachricht .= $newpoint."Bitte geben Sie Ihre <b>eMail</b> oder <b>Telefonnummer</b> ein, wenn Sie wollen das wir uns mit Ihnen in Kontakt setzen.<br>";
        } elseif(!empty($_POST['email']) && !empty($_POST['email']) && !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([a-z0-9-]+\.){1,3}([a-z0-9-]{2,3})$",$_POST['email'])) {
            $Nachricht .= $newpoint."Bitte geben Sie eine gültige <b>eMail</b> Adresse ein.<br>\n";
        } elseif(!empty($_POST['telefon']) && eregi("[^- /0-9]",$_POST['telefon'])) {
            $Nachricht .= $newpoint."Ihre <b>Telefonnummer</b> kann nur aus Zahlen bestehen.<br>\n";
        } elseif(!empty($_POST['telefon']) && strlen($_POST['telefon'])<3) {
            $Nachricht .= $newpoint."Ihre <b>Telefonnummer</b> wurde nicht korrekt eingegeben.<br>\n";
        }
		if(empty($_POST['betreff']))  {
            $Nachricht .= $newpoint."Wählen Si bitte ein <b>Betreff</b>.<br>\n";
        }
        if(empty($_POST['text']))  {
            $Nachricht .= $newpoint."Sie haben keine <b>Nachricht</b> hinterlassen.<br>\n";
        }

        if(!$Nachricht) {
            // Mailinhalt definieren:
            $Text  = "Folgende Nachricht wurde durch den Kontaktformular geschickt:\n";
            $Text .= "Name: ".$_POST['name']. " aus ".$_POST['land']."\n";
            $Text .= ($_POST['email'])   ? "Email: ".$_POST['email']."\n"     : "Email: not specified\n";
            $Text .= ($_POST['telefon']) ? "Telephone: ".$_POST['telefon']."\n" : "Telephone: not specified\n";
            $Text .= "Subject: ".$pbetreff[1]."\n\n";
            $Text .= str_repeat('-',70)."\n".strip_tags($_POST['text'])."\n";


            // Header definieren
            $dateiname      = $_FILES['anhang']['tmp_name'];
            $dateiname_mail = $_FILES['anhang']['name'];

            $absender = ($_POST['email']) ? $_POST['email'] : $absender;

            $header  = "From: $absender\nReply-To: ".$_POST['email'];

            // Anhang vorhanden?
            if($dateiname) {
                $trenner = md5(uniqid(time()));
                $header .= "\n";
                $header .= "MIME-Version: 1.0";
                $header .= "\n";
                $header .= "Content-Type: multipart/mixed; boundary=$trenner";
                $header .= "\n\n";
                $header .= "This is a multi-part message in MIME format";
                $header .= "\n";
                $header .= "--$trenner";
                $header .= "\n";
                $header .= "Content-Type: text/plain";
                $header .= "\n";
                $header .= "Content-Transfer-Encoding: 8bit";
                $header .= "\n\n";
                $header .= $Text;
                $header .= "\n";
                $header .= "--$trenner";
                $header .= "\n";
                $header .= "Content-Type: ".$_FILES['anhang']['type']."; name=$dateiname_mail";
                $header .= "\n";
                $header .= "Content-Transfer-Encoding: base64";
                $header .= "\n";
                $header .= "Content-Disposition: attachment; filename=$dateiname_mail";
                $header .= "\n\n";
                $dateiinhalt = fread(fopen($dateiname, "r"), filesize($dateiname));
                $header .= chunk_split(base64_encode($dateiinhalt));
                $header .= "\n";
                $header .= "--$trenner--";

            // Keinen Anhang, nur Mail
            } else {
                $header .= "\nContent-Type: text/plain";
                $header .= "\nContent-Transfer-Encoding: 8bit";
                $header .= "\n\n".$Text;
            }

            //-> Alles ok, Mail verschicken.
            mail($empfaenger,$pbetreff[(int)$_POST['betreff']], $header);
            $gesendet = true;
        }
    }

//----------------------------------------------------------------------------------------------------
// Hier erfolgt die html-Ausgabe. Diese kann beliebig angepasst werden.
// Allerdings bitte darauf achten, dass die PHP-Befehle unverändert bleiben.

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title></title>


<script type="text/javascript">

 

  var _gaq = _gaq || [];

  _gaq.push(['_setAccount', 'UA-3676646-1']);

  _gaq.push(['_trackPageview']);

 

  (function() {

    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);

  })();

 

</script>
</head>

<body>
<table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" width="100%">

  <?php if(!$gesendet): ?>

  <tr>
    <td width="100%">Bitte schicken Sie uns eine E-Mail mit Ihrer Anfrage und wir werden diese so schnell wie m&ouml;glich beantworten. <br></td></tr>

  <?php endif;?>

  <tr><td width="100%"><font color="red"><br>
    <?php print $Nachricht;?><br></font></td></tr>
  <tr><td width="100%"><?php if(!$gesendet): ?>

      <form method="POST" enctype="multipart/form-data" name="kontakt" action="<?php print $Scriptpfad;?>">
        <input type="hidden" value="1" name="submit">
        <table width="100%" border="0">
          <tr>
            <td width="20%" align="right" valign="middle" nowrap><font color="black">Ihr Name &nbsp;</font></td>
              <td width="80%"><input type="text" name="name" size="20" value="<?php print htmlentities($_POST['name']);?>" tabindex="1"></td></tr>
          <tr>
            <td width="20%" align="right" valign="middle" nowrap><font color="black">Land</font><font color="black">&nbsp;&nbsp;</font></td>
              <td width="80%"><input type="text" name="land" size="20" value="<?php print htmlentities($_POST['land']);?>" tabindex="2"></td></tr>
          <tr>
          <tr>
            <td width="20%" align="right" valign="middle" nowrap><font color="black">E-</font><font color="black">M</font><font color="black">ail&nbsp;&nbsp;</font></td>
              <td width="80%"><input type="text" name="email" size="20" value="<?php print htmlentities($_POST['email']);?>" tabindex="3"></td></tr>
          <tr>
            <td width="20%" align="right" valign="middle" nowrap><font color="black">Telefon</font><font color="black">&nbsp;&nbsp;</font></td>
              <td width="80%"><input type="text" name="telefon" size="20" value="<?php print htmlentities($_POST['telefon']);?>" tabindex="4"></td></tr>
          <tr>
            <td width="20%" align="right" valign="middle" nowrap><font color="black">Anfrage</font><font color="black">&nbsp;&nbsp;</font></td>
              <td width="80%"><?php
                    if(!$pflichtbetreff) {
                        print '<select size="1" name="betreff" tabindex="5">';

                        while(list($a,$b) = each($pbetreff))
                            if($a == $_REQUEST['betreff'])
                                print '<option value="'.$a.'" selected>'.$b.'</option>';
                            else
                                print '<option value="'.$a.'">'.$b.'</option>';
                        print '</select>';
                    } else {
                        print $pbetreff[(int)$_GET['betreff']];
                    }
              ?></td>
          </tr>
          <tr>
            <td width="20%" align="right" valign="top"><font color="black">Nachricht</font><font color="black">&nbsp;&nbsp;</font></td>
              <td width="80%"><textarea rows="8" name="text" cols="40" tabindex="6" style="font-family:Verdana,Arial; font-size:9pt"><?php print htmlentities(strip_tags($_POST['text']));?></textarea></td></tr>

          <tr><td width="20%" align="right" valign="top"></td>
              <td width="80%"><input type="submit" value="Anfrage senden" width="80" height="31" border="0"></td></tr>
        </table>
        <?php else: ?>
Danke für Ihre Nachricht. 
<br>

        <?php endif;?>    
      </form>
    </td></tr>
</table>

</body>
<SCRIPT tpye="text/javascript">
<!--
    document.kontakt.name.focus();
-->
</script>
</html>