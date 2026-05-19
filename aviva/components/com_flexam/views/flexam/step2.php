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

$idTest = JRequest::getVar('chooseId', '', 'post');
$rqCode = JRequest::getVar('rqCode', '', 'post');

$quesTest = $this->getElemFlExam->getExamTestQuestions($idTest);
$iter = 1;

if($quesTest && $quesTest != 'alertMsg') {
    echo '<tr><th width="50%"><div id="instruct">'.JText::_( 'FLEXAM_TEST_DIFICULTY' ).':&nbsp;'.$quesTest[0]->dificulty.'0%</div></th>';
    echo '<th><div id="instruct">'.JText::_( 'FLEXAM_TEST_APPROVALSCORE' ).':&nbsp;'.$quesTest[0]->aprobeScore.'</div></td></tr>';
    echo '<tr><th width="50%"><div id="instruct">'.JText::_( 'FLEXAM_TEST_STARTSCORE' ).':&nbsp;'.$quesTest[0]->minScore.'</div></th>';
    echo '<th><div id="instruct">'.JText::_( 'FLEXAM_TEST_ENDSCORE' ).':&nbsp;'.$quesTest[0]->maxScore.'</div></th></tr>';
    echo '<tr><td colspan="2"><div id="instruct">'.$quesTest[0]->instructions.'</div></td></tr>';
    foreach($quesTest as $quest) {
        if($quest->published > 0) {
            $quest->question = str_replace('&#34;', '"', $quest->question);

            echo '<tr><td colspan="2"><div id="quest"><p>'.$iter.'.-&nbsp;&nbsp;&nbsp;('.JText::_( 'FLEXAM_POINTS' ).':&nbsp;'.$quest->points.')</p>'.$quest->question.'</div><hr />';

            if ($quest->idtypeQuestions == '4') {
                echo '<div id="answUser"><p><b>'.JText::_( 'FLEXAM_ANSWER' ).' :</b></p><p><textarea title="'.JText::_( 'FLEXAM_ANSWER_INSTRUCTION' ).
                    '" rows="2" cols="50" name="userAnswer'.$quest->idquestion.'" id="userAnswer'.$quest->idquestion.
                    '" onBlur="javascript:checkAnswerUser(\'userAnswer'.$quest->idquestion.'\',\''.$quest->idtypeQuestions.'\',\''.JText::_( 'FLEXAM_ANSWER_JAVA_WARNING' ).'\')" /></textarea></p>';
            } else {
                echo '<div id="answUser">'.JText::_( 'FLEXAM_ANSWER' ).'&nbsp;:&nbsp;&nbsp;&nbsp;<input title="'.JText::_( 'FLEXAM_ANSWER_INSTRUCTION' ).
                    '" size="2" maxlength="1" name="userAnswer'.$quest->idquestion.'" id="userAnswer'.$quest->idquestion.
                    '" onBlur="javascript:checkAnswerUser(\'userAnswer'.$quest->idquestion.'\',\''.$quest->idtypeQuestions.'\',\''.JText::_( 'FLEXAM_ANSWER_JAVA_WARNING' ).'\')" />';
            }

            echo '</div></td></tr>';

            $iter++;
        }
    }
    echo '<tr><td colspan="2">';
    echo '<input class="input_flexam" type="button" id="ok" name="ok" value="'.JText::_( 'FLEXAM_OK' ).'" onClick="javascript:submitFm(\'chooseTestFm\')" />&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<input class="input_flexam" type="button" id="cancel" name="cancel" value="'.JText::_( 'FLEXAM_CANCEL' ).'" onClick="javascript:window.location=\''._IMGURL_PATH.DS.'?option=com_flexam'.'\';" />';
    echo '<input type="hidden" id="totalQuestions" name="totalQuestions" value="'.count($quesTest).'" />';
    echo '<input type="hidden" id="chooseId" name="chooseId" value="'.$idTest.'" />
            <input type="hidden" name="rqCode" id="rqCode" value="'.$rqCode.'" />
            <input type="hidden" name="deepLv" id="deepLv" value="3" />';
    echo '</td></tr>';
} else {
    echo "<script>alert('".JText::_( 'FELXAM_WARNING_TEST_DONE' )."'); window.location=\""._IMGURL_PATH.DS."?option=com_flexam\";</script>";
}
?>