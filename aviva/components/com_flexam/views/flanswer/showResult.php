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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

$idSelTest  = JRequest::getVar('selTest', '', 'post');
$dtUsTs     = $this->getUserTstInfo();
$idDataTest = explode('&',$idSelTest);
$idTest     = $idDataTest[0];
$codeTets   = $idDataTest[1];
$stateAprov = NULL;

echo '<a class="toolbar" onclick="javascript: document.forms[\'showAnswersFm\'].submit();" href="#">
<div title="Enviar Correo" class="mailingTest">&nbsp;
<input type="hidden" id="deepLev" name="deepLev" value="1" />
<input type="hidden" id="selTest" name="selTest" value="'.$idTest.'" />
<input type="hidden" id="view" name="view" value="flanswer" />
<input type="hidden" id="send" name="send" value="1" />
</div>
Enviar Correo
</a>';

if (isset($_POST['send'])){
    $this->sndMailTest($idTest);
}

switch ($this->totalError[6]) {
    case 'OK':
        $stateAprov = JText::_('FLEXAM_TEST_APPROVAL_LONG');
        break;

    case 'FAIL':
        $stateAprov = JText::_('FLEXAM_TEST_FAIL_LONG');
        break;

    default:
        $stateAprov = $this->totalError[6];
        break;
}
?>
<tr>
    <td  colspan="2"><div id="titleItem">
            <?php echo JText::_('FLEXAM_RESULT_TITLE'); ?>
        </div>
    </td>
</tr>
<tr>
    <td width="300"><div id="instruct">
            <?php echo JText::_('FLEXAM_NAME').": <strong>".$dtUsTs[0]->name."</strong>"; ?>
        </div>
    </td>
    <td><div id="instruct">
            <?php echo JText::_('FLEXAM_MAIL').": <strong>".$dtUsTs[0]->email."</strong>"; ?>
        </div>
    </td>
</tr>
<tr>
    <td width="300"><div id="instruct">
            <?php echo JText::_('FLEXAM_RESULT_TOTAL').": <strong>".$this->totalError[1]."<input type=\"hidden\" id=\"bdyMsg[]\" name=\"bdyMsg[]\" value=\"".$this->totalError[1]."\" /></strong>"; ?>
        </div>
    </td>
    <td><div id="instruct">
            <?php echo JText::_('FLEXAM_TEST_DIFICULTY_TITLE').": <strong>".$this->totalError[2]."0%<input type=\"hidden\" id=\"bdyMsg[]\" name=\"bdyMsg[]\" value=\"".$this->totalError[2]."\" /></strong>"; ?>
        </div>
    </td>
</tr>
<tr>
    <td><div id="instruct">
            <?php echo JText::_('FLEXAM_RESULT_WRONG').": <strong>".$this->totalError[0]."<input type=\"hidden\" id=\"bdyMsg[]\" name=\"bdyMsg[]\" value=\"".$this->totalError[0]."\" /></strong>"; ?>
        </div>
    </td>
    <td><div id="instruct">
            <?php echo JText::_('FLEXAM_RESULT_GOOD').": <strong>".($this->totalError[1] - $this->totalError[0])."<input type=\"hidden\" id=\"bdyMsg[]\" name=\"bdyMsg[]\" value=\"".($this->totalError[1] - $this->totalError[0])."\" /></strong>"; ?>
        </div>
    </td>
</tr>
<tr>
    <td><div id="instruct">
            <?php echo JText::_('FLEXAM_TOTAL_POINTS').": <strong>".$this->totalError[3]."<input type=\"hidden\" id=\"bdyMsg[]\" name=\"bdyMsg[]\" value=\"".$this->totalError[3]."\" /></strong>"; ?>
        </div>
    </td>
    <td><div id="instruct">
            <?php echo JText::_('FLEXAM_TOTAL_POINTS_USER').": <strong>".$this->totalError[4]."<input type=\"hidden\" id=\"bdyMsg[]\" name=\"bdyMsg[]\" value=\"".$this->totalError[4]."\" /></strong>"; ?>
        </div>
    </td>
</tr>
<tr>
    <td><div id="instruct">
            <?php echo JText::_('FLEXAM_TEST_TOTALSCORE').": <strong>".$this->totalError[5]."<input type=\"hidden\" id=\"bdyMsg[]\" name=\"bdyMsg[]\" value=\"".$this->totalError[5]."\" /></strong>"; ?>
        </div>
    </td>
    <td><div id="instruct">
            <?php echo JText::_('FLEXAM_TEST_STATEAPPROVAL').": <strong>".$stateAprov."<input type=\"hidden\" id=\"bdyMsg[]\" name=\"bdyMsg[]\" value=\"".$this->totalError[6]."\" /></strong>"; ?>
        </div>
    </td>
</tr>
</table>
<hr />
<table class="tableTest">
    <?php 
    $quesTest = $this->detailTest->getExamTestQuestionsResult($idTest);
    $uAnsTest = $this->detailTest->getUserAnswer($idTest, $id, $codeTets);

    if($quesTest) {
        echo '<tr><th colspan="2"><div id="imgFloatDspl" style="display:none;"><div id="titleItem"><a href="#" onClick="javascript:showLayerImg(\'#\');"><img src="'.$icoPath.'close.png" /></a></div><div id="imgScreen"></div></div><div id="nameTst">'.$quesTest[0]->nameTest.'</div></th></tr>';
        echo '<tr><th colspan="2"><div id="instruct">'.$quesTest[0]->instructions.'</div></th></tr>';
        foreach($quesTest as $quest) {
            if($quest->published > 0) {
                echo '<tr><td width="80%"><div id="quest">'.str_replace('&#34;','"',$quest->question).'</div><div id="alterna">';

                
                echo '<div id="openAnsw"><textarea readOnly="true" rows="2" cols="50" name="openAnsw'.$quest->idquestion.'" id="openAnsw'.$quest->idquestion.'" />';
                echo JText::_('FLEXAM_RESULT_USER').$uAnsTest[$quest->idquestion];
                echo '</textarea></div>';

                echo '<div id="openAnsw"><textarea readOnly="true" rows="2" cols="50" name="openAnsw'.$quest->idquestion.'" id="openAnsw'.$quest->idquestion.'" />';
                echo JText::_('FLEXAM_RESULT_SYSTEM').$quest->response;
                echo '</textarea></div>';

                echo '</div></td>';
            }
        }
        echo '<tr><th colspan="2"><br />';
        echo '<input class="input_flexam" type="button" id="cancel" name="cancel" value="'.JText::_('FLEXAM_OUT').'" onClick="javascript:window.location=\''._IMGURL_PATH.DS.'?option=com_flexam&view=flexam'.'\';" />';
        echo '</th></tr>';
    }
?>