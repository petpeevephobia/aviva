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
    $titleFm        = NULL;
    $acctionTask    = JRequest::getVar( 'task' );
    $pst            = JRequest::getVar( 'cid' );
    $cidVal         = explode('&',$pst[0]);
    $cid[]           = $cidVal[1];
    $idUser         = $cidVal[0];
    $idAnswTest         = $cidVal[2];
    
    JArrayHelper::toInteger($cid, array(0));

    $text = JText::_( 'preview' );

    JToolBarHelper::title(  JText::_( 'FLEXAM_MENUADMIN_QUESTIONS' ).': <small><small>[ '.$text.' ]</small></small>' );

    
    JToolBarHelper::custom('print', 'print', '', 'FLEXAM_PRINT');
    JToolBarHelper::cancel();
    
    JFilterOutput::objectHTMLSafe( $this->items, 'ENT_QUOTES' );

    $infoHead = $this->getTestResult($cid[0], $idUser, $idAnswTest);
    $dtUsTs = $this->getUsTstInfo($idUser);
    $stateAprov = NULL;

    switch ($infoHead[6]) {
        case 'OK':
            $stateAprov = JText::_('FLEXAM_TEST_APPROVAL_LONG');
            break;

        case 'FAIL':
            $stateAprov = JText::_('FLEXAM_TEST_FAIL_LONG');
            break;

        default:
            $stateAprov = $bdyMsg[6];
            break;
    }
?>

<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		} else { 
			imprSelec();
		}
	}
</script>
<form action="index.php?option=com_flexam&optCtrl=answerTest" method="post" name="adminForm">
<div id="editcell">
    <table class="tableTest" style="text-align: justify;">
            <tr>
                <th  colspan="2"><div id="titleItem">
                    <?php echo JText::_('FLEXAM_RESULT_TITLE'); ?>
                    </div>
                </th>
            </tr>
            <tr>
                <th width="300"><div id="instruct">
                        <?php echo JText::_('FLEXAM_NAME').": <strong>".$dtUsTs[0]->name."</strong>"; ?>
                    </div>
                </th>
                <th><div id="instruct">
                        <?php echo JText::_('FLEXAM_MAIL').": <strong>".$dtUsTs[0]->email."</strong>"; ?>
                    </div>
                </th>
            </tr>
            <tr>
                <th width="300"><div id="instruct">
                    <?php echo JText::_('FLEXAM_RESULT_TOTAL').": <strong>".$infoHead[1]."</strong>"; ?>
                    </div>
                </th>
                <th><div id="instruct">
                    <?php echo JText::_('FLEXAM_TEST_DIFICULTY_TITLE').": <strong>".$infoHead[2].'0%</strong>'; ?>
                    </div>
                </th>
            </tr>
            <tr>
                <th><div id="instruct">
                    <?php echo JText::_('FLEXAM_RESULT_WRONG').": <strong>".$infoHead[0]."</strong>"; ?>
                    </div>
                </th>
                <th><div id="instruct">
                    <?php echo JText::_('FLEXAM_RESULT_GOOD').": <strong>".($infoHead[1] - $infoHead[0])."</strong>"; ?>
                    </div>
                </th>
            </tr>
            <tr>
                <th><div id="instruct">
                    <?php echo JText::_('FLEXAM_TOTAL_POINTS').": <strong>".$infoHead[3].'</strong>'; ?>
                    </div>
                </th>
                <th><div id="instruct">
                    <?php echo JText::_('FLEXAM_TOTAL_POINTS_USER').": <strong>".$infoHead[4].'</strong>'; ?>
                    </div>
                </th>
            </tr>
            <tr>
                <th><div id="instruct">
                    <?php echo JText::_('FLEXAM_TEST_TOTALSCORE').": <strong>".$infoHead[5].'</strong>'; ?>
                    </div>
                </th>
                <th><div id="instruct">
                    <?php echo JText::_('FLEXAM_TEST_STATEAPPROVAL').": <strong>".$stateAprov.'</strong>'; ?>
                    </div>
                </th>
            </tr>
        </table>
        <hr />
        <table class="tableTest">
<?php
        $quesTest = $this->getExamTestQuestionsResult($cid[0]);
        $uAnsTest = $this->getUserAnswer($cid[0], $idUser, $idAnswTest);

        if($quesTest){
            echo '<tr><th colspan="2"><div id="nameTst">'.$quesTest[0]->nameTest.'</div></th></tr>';
            echo '<tr><th colspan="2"><div id="instruct" style="text-align: justify;">'.$quesTest[0]->instructions.'</div></th></tr>';
            foreach($quesTest as $quest){
                if($quest->published > 0){
                    echo '<tr><td width="80%"><div id="quest">'.str_replace('&#34;', '"', str_replace('src=&#34;','src=&#34;../',$quest->question)).'</div>';
                    
                    echo '<div id="openAnsw"><textarea readOnly="true" rows="2" cols="50" name="openAnsw'.$quest->idquestion.'" id="openAnsw'.$quest->idquestion.'" />';
                    echo JText::_('FLEXAM_RESULT_USER').$uAnsTest[$quest->idquestion];
                    echo '</textarea></div>';
                    echo '<div id="openAnsw"><textarea readOnly="true" rows="2" cols="50" name="openAnsw'.$quest->idquestion.'" id="openAnsw'.$quest->idquestion.'" />';
                    echo JText::_('FLEXAM_RESULT_SYSTEM').$quest->response;
                    echo '</textarea></div>';

                    echo '</div></td>';
                }
            }
        }
?>
</table>
</div>
<div id="footFlExamUser"><?php echo JText::_('FLEXAM_COPYRIGHTS') ?></div>
<div class="clr"></div>
        <input type="hidden" name="boxchecked" value="1" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="option" value="com_flexam" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
