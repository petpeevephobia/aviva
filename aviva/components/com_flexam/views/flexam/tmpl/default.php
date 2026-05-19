<?php
/**
* @package      com_flexam for Joomla! 1.5
* @version	$Id: flexam.php 2010-04-02 10:07:31Z Hernán Roa $
* @author       Hernán Roa Reyes
* @copyright	(C) 2010 - 2012 Hernán Roa Reyes.
* @license	GNU/GPLv3 http://www.gnu.org/copyleft/gpl.html
* See license.txt
* flexam is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined('_JEXEC') or die('Restricted access');
jimport('joomla.session.session');

if($_GET['session'] == 'false'){
    unset($_SESSION);
    $session = NULL;
} else {
    $session =& JFactory::getSession();
}

$level = JRequest::getVar('deepLv', '', 'post');
$user = JFactory::getUser();

if($_GET['id'] == 'false'){
    $id = NULL;
} else {
    $id = $user->get('id');
}

$rqCode = JRequest::getVar('cc', '', 'get');

if(empty($id) && empty($session)){
    if(!empty($rqCode)){
        $url = _FLEXAM_SERVERREQ."?id=".$rqCode;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $serverResponse = utf8_encode(curl_exec ($ch));
        $info = curl_getinfo($ch);
        curl_close ($ch);
        
        if ($serverResponse === false || $info['http_code'] != 200) {
            $serverResponse = "No cURL data returned for $url [". $info['http_code']. "]";
            if (curl_error($ch))
                $serverResponse .= "\n". curl_error($ch);
        }

?>
<form name="loginFlexamFm" id="loginFlexamFm" action="?option=com_flexam" method="post">
    <input type="hidden" name="curId" id="curId" value="" />
    <input type="hidden" name="usName" id="usName" value="" />
    <input type="hidden" name="usMail" id="usMail" value="" />
    <input type="hidden" name="rqCode" id="rqCode" value="<?php echo $rqCode; ?>" />
    <input type="hidden" name="sesstart" id="sesstart" value="1" />
</form>
<script type="text/javascript" charset="UTF-8">serverObjFound('<?php echo $serverResponse; ?>');</script>
<?php
    }
}else{
    if(isset($session) && !empty($rqCode)){
        echo "<script>window.location=\""._IMGURL_PATH.DS."index.php?option=com_flexam&cc=$rqCode&session=false&id=false\";</script>";
    }
    
    if (isset($_POST['send'])){
        $msg = JRequest::getVar('bdyMsgs', '', 'POST');
        $idTst = JRequest::getVar('chooseId', '', 'POST');

        $arrayTmp = array($msg[2],$msg[0],$msg[1],$msg[4],$msg[5],$msg[6],$msg[7]);

        $this->sndMailTests($arrayTmp, $idTst);
    }
?>
<div id="editcell">
    <div id="titleFlExamUser"><?php echo (defined('_FLEXAM_NAME_COM')) ?  _FLEXAM_NAME_COM : JText::_( 'FLEXAM_FEUSER_TITLE' ); ?></div>
    <form name="chooseTestFm" id="chooseTestFm" action="index.php?option=com_flexam&view=flexam" method="post">
        <table class="tableTest" cellspacing="8" cellpadding="10">
            <?php echo ((int)$level < 1) ? '<tr><th colspan="3"><h2>'.JText::_( 'FLEXAM_GENERAL_INSTRUCTIONS' ).'</h2></th></tr>' : NULL ?>
<?php
switch ($level){
    default:
        include(_IMGSERVER_PATH.DS."views".DS."flexam".DS."step1.php");
        break;
    
    case '2':
        include(_IMGSERVER_PATH.DS."views".DS."flexam".DS."step2.php");
        break;

    case '3':
        include(_IMGSERVER_PATH.DS."views".DS."flexam".DS."step3.php");
        break;
}
?>
</table>
</form>
</div>
<div id="footFlExamUser"><?php echo JText::_( 'FLEXAM_COPYRIGHTS' ) ?></div>
<?php 
}
?>