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
$idTest     = JRequest::getVar('chooseId', '', 'post');
$rqCode     = JRequest::getVar('rqCode', '', 'post');
$typeTest   = $this->getTypeTestInfo($idTest);
$dtUsTs     = $this->getUserTestInfo();
$stateAprov = NULL;

switch ($this->totalError[6]){
    case 'OK':
        $msg = $this->getConf('aprove msg');
        $stateAprov = (empty($msg)) ? JText::_('FLEXAM_TEST_APPROVAL_LONG') : $msg;
        break;

    case 'FAIL':
        $msg = $this->getConf('reprove msg');
        $stateAprov = (empty($msg)) ? JText::_('FLEXAM_TEST_FAIL_LONG') : $msg;
        break;
}

define('SHOW_RESULT' , $this->getConf('display result'));

if(defined('_FLEXAM_SERVERTRUE') && !empty($rqCode)){

?>
<tr>
    <td colspan="2"><div id="titleItem">
            <?php
                if(3 > (int)$typeTest[0][0]){
                    echo JText::_( 'FLEXAM_RESULT_TITLE' )."<br /><hr />".JText::_( 'FLEXAM_TEST_STATEAPPROVAL' ).": ".$stateAprov."<br /><br />".JText::_( 'FLEXAM_MAIL_ADVICE' ).'&nbsp;'._FLEXAM_SERVERTIMEOUT.'&nbsp;'.JText::_( 'FLEXAM_SECONDS' );
                }else{
                    echo JText::_( 'FLEXAM_RESULT_TITLE' )."<br /><hr /><br />".JText::_( 'FLEXAM_MAIL_ADVICE' );
                }
            ?>
        </div>
        <div style="text-align: center; padding: 20px;">
            <input type="button" onClick="goAway('<?php echo _FLEXAM_SERVEROUT ?>', '0');" value="<?php echo JText::_( 'FLEXAM_END' ) ?>" />
        </div>
       <script type="text/javascript">goAway('<?php echo _FLEXAM_SERVEROUT ?>', '<?php echo _FLEXAM_SERVERTIMEOUT ?>');</script>
    </td>
</tr>
<?php

}else{

echo '<a class="toolbar" onclick="javascript: document.forms[\'chooseTestFm\'].submit();" href="#">
<div title="Enviar Correo" class="mailingTest">&nbsp;
<input type="hidden" id="deepLev" name="deepLev" value="3" />
<input type="hidden" id="chooseId" name="chooseId" value="'.$idTest.'" />
<input type="hidden" id="view" name="view" value="flexam" />
<input type="hidden" id="send" name="send" value="1" />
</div>
Enviar Correo
</a>';

?>
<tr>
    <th  colspan="2"><div id="titleItem">
            <?php echo JText::_( 'FLEXAM_RESULT_TITLE' ); ?>
        </div>
    </th>
</tr>
<tr>
    <th width="300"><div id="instruct">
            <?php echo JText::_( 'FLEXAM_NAME' ).": <strong>".$dtUsTs[0]->name."</strong>"; ?>
        </div>
    </th>
    <th><div id="instruct">
            <?php echo JText::_( 'FLEXAM_MAIL' ).": <strong>".$dtUsTs[0]->email."</strong>"; ?>
        </div>
    </th>
</tr>
<tr>
    <th width="300"><div id="instruct">
            <?php echo JText::_( 'FLEXAM_RESULT_TOTAL' ).": <strong>".$this->totalError[1]."<input type=\"hidden\" id=\"bdyMsgs[]\" name=\"bdyMsgs[]\" value=\"".$this->totalError[1]."\" /></strong>"; ?>
        </div>
    </th>
    <th><div id="instruct">
            <?php echo JText::_( 'FLEXAM_TEST_DIFICULTY_TITLE' ).": <strong>".$this->totalError[2]."0%<input type=\"hidden\" id=\"bdyMsgs[]\" name=\"bdyMsgs[]\" value=\"".$this->totalError[2]."\" /></strong>"; ?>
        </div>
    </th>
</tr>
<tr>
    <th><div id="instruct">
            <?php echo JText::_( 'FLEXAM_RESULT_WRONG' ).": <strong>".$this->totalError[0]."<input type=\"hidden\" id=\"bdyMsgs[]\" name=\"bdyMsgs[]\" value=\"".$this->totalError[0]."\" /></strong>"; ?>
        </div>
    </th>
    <th><div id="instruct">
            <?php echo JText::_( 'FLEXAM_RESULT_GOOD' ).": <strong>".($this->totalError[1] - $this->totalError[0])."<input type=\"hidden\" id=\"bdyMsgs[]\" name=\"bdyMsgs[]\" value=\"".($this->totalError[1] - $this->totalError[0])."\" /></strong>"; ?>
        </div>
    </th>
</tr>
<tr>
    <th><div id="instruct">
            <?php echo JText::_( 'FLEXAM_TOTAL_POINTS' ).": <strong>".$this->totalError[3]."<input type=\"hidden\" id=\"bdyMsgs[]\" name=\"bdyMsgs[]\" value=\"".$this->totalError[3]."\" /></strong>"; ?>
        </div>
    </th>
    <th><div id="instruct">
            <?php echo JText::_( 'FLEXAM_TOTAL_POINTS_USER' ).": <strong>".$this->totalError[4]."<input type=\"hidden\" id=\"bdyMsgs[]\" name=\"bdyMsgs[]\" value=\"".$this->totalError[4]."\" /></strong>"; ?>
        </div>
    </th>
</tr>
<tr>
    <th><div id="instruct">
            <?php echo JText::_( 'FLEXAM_TEST_TOTALSCORE' ).": <strong>".$this->totalError[5]."<input type=\"hidden\" id=\"bdyMsgs[]\" name=\"bdyMsgs[]\" value=\"".$this->totalError[5]."\" /></strong>"; ?>
        </div>
    </th>
    <th><div id="instruct">
            <?php echo JText::_( 'FLEXAM_TEST_STATEAPPROVAL' ).": <strong>".$stateAprov."<input type=\"hidden\" id=\"bdyMsgs[]\" name=\"bdyMsgs[]\" value=\"".$stateAprov."\" /></strong>"; ?>
        </div>
    </th>
</tr>
</table>
<hr />
<table class="tableTest">
    <?php

    $quesTest = $this->getElemFlExam->getExamTestQuestionsResult($idTest);
    $uAnsTest = $this->getElemFlExam->getUserAnswer($idTest, $id);
    $iter = 1;

    if($quesTest && SHOW_RESULT < 1) {
        echo '<tr><th colspan="2"><div id="imgFloatDspl" style="display:none;"><div id="titleItem"><a href="#" onClick="javascript:showLayerImg(\'#\');"><img src="'.$icoPath.'close.png" /></a></div><div id="imgScreen"></div></div><div id="nameTst">'.$quesTest[0]->nameTest.'</div></th></tr>';
        echo '<tr><th colspan="2"><div id="instruct">'.$quesTest[0]->instructions.'</div></th></tr>';
        foreach($quesTest as $quest) {
            if($quest->published > 0) {
                echo '<tr><td width="80%"><div id="quest"><p>'.JText::_( 'FLEXAM_QUESTION' ).'&nbsp;'.$iter.':</p>'.str_replace('&#34;','"',$quest->question).'</div><div id="alterna">';

                echo '<div id="openAnsw"><textarea readonly="true" rows="2" cols="50" name="openAnsw'.$quest->idquestion.'" id="openAnsw'.$quest->idquestion.'" />';
                echo JText::_( 'FLEXAM_RESULT_USER' ).$uAnsTest[$quest->idquestion];
                echo '</textarea><br />';

                echo '<textarea readonly="true" rows="2" cols="50" name="openAnsw'.$quest->idquestion.'" id="openAnsw'.$quest->idquestion.'" />';
                echo JText::_( 'FLEXAM_RESULT_SYSTEM' ).$quest->response;
                echo '</textarea></div>';

                echo '</div></td>';

                $iter++;
            }
        }
        echo '<tr><th colspan="2" style="text-align: center;"><br />';
        echo '<input class="input_flexam" type="button" id="cancel" name="cancel" value="'.JText::_( 'FLEXAM_OUT' ).'" onClick="javascript:window.location=\''._IMGURL_PATH.DS.'?option=com_flexam'.'\';" />';
        echo '</th></tr>';
    } else {
        echo '<tr><th colspan="2" style="text-align: center;"><br />';
        echo '<input class="input_flexam" type="button" id="cancel" name="cancel" value="'.JText::_( 'FLEXAM_OUT' ).'" onClick="javascript:window.location=\''._IMGURL_PATH.DS.'?option=com_flexam'.'\';" />';
        echo '</th></tr>';
    }
}
?>