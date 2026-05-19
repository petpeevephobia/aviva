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

jimport('joomla.application.component.controller');

/**
 * @package		Joomla
 * @subpackage          Config
 */
class flExamControllerAnswer extends JController {

    /**
     * Custom Constructor
     */
    function __construct($default = array()) {
        parent::__construct($default);
        $this->registerTask('preview', 'display');
    }

    function display() {
        switch (JRequest::getVar('task')) {
            case 'preview' : {
                    JRequest::setVar('hidemainmenu', 1);
                    JRequest::setVar('layout', 'form');
                    JRequest::setVar('view', 'answer');
                    JRequest::setVar('preview', true);
                }
                break;
        }

        if (JRequest::getVar('task') == 'remove') {
            $this->remove();
        }

        if (JRequest::getVar('task') == 'send') {
            $this->sendMail();
        }
        //Set the default view, just in case
        $view = JRequest::getCmd('view');

        if (empty($view)) {
            JRequest::setVar('view', 'answer');
        };
        //var_dump($_POST,$_GET,$_REQUEST);
        parent::display();
    }

    function remove() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');

        $db = & JFactory::getDBO();
        $cid = JRequest::getVar('cid', array(), '', 'array');

        $msg = '';

        for ($i = 0, $n = count($cid); $i < $n; $i++) {
            $dtSelected = explode('&', $cid[$i]);

            $idUser = JRequest::getVar('idUser' . $i);
            $qry = "SELECT idquestion FROM #__flexam_questions_per_test WHERE idtest='" . $dtSelected[1] . "'";
            $db->setQuery($qry);
            $idQuest = $db->loadObjectList();

            if ($idQuest) {
                foreach ($idQuest as $idQ) {
                    $qry = "DELETE FROM #__flexam_answer WHERE idquestion='" . $idQ->idquestion .
                            "' AND iduser='" . $dtSelected[0] . "' AND dateAnswerTest='" . $dtSelected[2] . "'";

                    $db->setQuery($qry);

                    if (!$db->query()) {
                        $msg .= $answ->getError() . " ";
                    }

                    $qry = "DELETE FROM #__flexam_testDone_state WHERE iduser='" . $dtSelected[0] . "' AND dateCode='" . $dtSelected[2] . "'";

                    $db->setQuery($qry);
                    $db->query();
                }
            }
        }

        $this->setRedirect('index.php?option=com_flexam&optCtrl=answerTest', $msg);
    }

    function cancel() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');

        $id = JRequest::getVar('id', 0, '', 'int');
        $db = & JFactory::getDBO();
        $row = & JTable::getInstance('answer', 'Table');

        $row->checkin($id);
        $this->setRedirect('index.php?option=com_flexam&optCtrl=answerTest');
    }

    function sendMail() {
        global $mainframe;

        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');

        $db = & JFactory::getDBO();
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $to = NULL;
        $testResume = NULL;

        if (!empty($cid[0])) {
            foreach ($cid as $id) {
                $usID = explode('&', $id);

                $bdyMsg = $this->getTestResultResume($usID[1], $usID[0], $usID[2]);

                switch ($bdyMsg[6]) {
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

                $testResume = " <b>$stateAprov</b><br /><br /><b>" .
                        JText::_('FLEXAM_RESULT_TOTAL') . ":</b> $bdyMsg[1]<br /><b>" . JText::_('FLEXAM_TEST_DIFICULTY_TITLE') . ":</b> $bdyMsg[2]0%<br /><b>" .
                        JText::_('FLEXAM_RESULT_WRONG') . ":</b> $bdyMsg[0]<br /><b>" . JText::_('FLEXAM_RESULT_GOOD') . ":</b> " . ($bdyMsg[1] - $bdyMsg[0]) . "<br /><b>" .
                        JText::_('FLEXAM_TOTAL_POINTS') . ":</b> $bdyMsg[3]<br /><b>" . JText::_('FLEXAM_TOTAL_POINTS_USER') . ":</b> $bdyMsg[4]<br /><b>" .
                        JText::_('FLEXAM_TEST_TOTALSCORE') . ":</b> $bdyMsg[5]<br /><br /><hr />" . $mainframe->getCfg('fromname');

                $query = 'SELECT email'
                        . ' FROM #__users'
                        . ' WHERE id = ' . (int) $usID[0];

                $db->setQuery($query);
                $to = $db->loadResult();

                $query = 'SELECT name'
                        . ' FROM #__users'
                        . ' WHERE id = ' . (int) $usID[0];

                $db->setQuery($query);
                $toName = $db->loadResult();

                $query = 'SELECT nameTest'
                        . ' FROM #__flexam_test'
                        . ' WHERE idtest = ' . (int) $usID[1];

                $db->setQuery($query);
                $nameTest = $db->loadResult();

                $subject = JText::_('FLEXAM_SUBJECT_MASMAIL') . " $nameTest";
                $message_body = JText::_('FLEXAM_BODY_MASMAIL_TO') . $toName . '<br /> <br />' . JText::_('FLEXAM_BODY_MASMAIL');

                $mailer = & JFactory::getMailer();

                $mailer->setSender(array($mainframe->getCfg('mailfrom'), $mainframe->getCfg('fromname')));
                $mailer->setSubject($subject);

                // Add recipients
                $mailer = & JFactory::getMailer();

                $mailer->setSender(array($mainframe->getCfg('mailfrom'), $mainframe->getCfg('fromname')));
                $mailer->setSubject($subject);

                $mailer->addRecipient($to);
                $mailer->setBody($message_body . $testResume);
                $mailer->IsHTML(1);

                $mailer->addBCC($mainframe->getCfg('mailfrom'));
                $rs = $mailer->Send();
            }
        }

        $mainframe->redirect('index.php?option=com_flexam&optCtrl=answerTest');
    }

    function getTestResultResume($idTst, $idUser, $idAnswTest) {
        $db = & JFactory::getDBO();

        $query = "SELECT a.*, b.*, c.*  ";
        $query .= "FROM  #__flexam_questions_per_test AS a INNER JOIN #__flexam_questions AS b ON a.idquestion=b.idquestion ";
        $query .= "INNER JOIN #__flexam_test AS c ON a.idtest=c.idtest ";
        $query .= "WHERE a.idtest='$idTst'";

        $db->setQuery($query);
        $idQ = $db->loadObjectList();
        $questAnsDef = NULL;
        $questAnsUse = NULL;
        $compareAnswers = NULL;
        $statApprov = NULL;
        $sumPoints = 0;
        $pointsUser = 0;
        $note = NULL;

        if (!empty($idQ)) {
            foreach ($idQ as $iQ) {
                if ($iQ->published) {
                    $questAnsDef[$iQ->idquestion] = $iQ->response;
                    $sumPoints += (int) $iQ->points;
                }

                $query = "SELECT * ";
                $query .= "FROM  #__flexam_answer ";
                $query .= "WHERE (dateAnswerTest='$idAnswTest') ";
                $query .= "AND (idquestion='$iQ->idquestion' AND iduser='$idUser') ";

                $db->setQuery($query);
                $answ = $db->loadObjectList();

                if (!empty($answ)) {
                    foreach ($answ as $nsw) {
                        $questAnsUse[$iQ->idquestion] = $nsw->answer;

                        if ($iQ->idtypeQuestions == '4') {
                            $arrResp = explode(';', $iQ->response);
                            $usAnLen = strlen($nsw->answer);

                            foreach ($arrResp as $arrRp) {
                                $tmpStr = str_replace($arrRp, '', $nsw->answer);

                                if (strlen($tmpStr) < $usAnLen) {
                                    $pointsUser += 1;
                                }
                            }
                        } else {
                            if ($iQ->response === $nsw->answer) {
                                $pointsUser += (int) $iQ->points;
                            }
                        }
                    }
                }
            }

            $minPoinApprob = round($sumPoints * ($idQ[0]->dificulty / 10));
            $mxRank = round(($idQ[0]->aprobeScore - $idQ[0]->minScore) / $minPoinApprob, 1);
            $note = array(floatval($idQ[0]->minScore));

            for ($i = 0; $i < $minPoinApprob; $i++) {
                $noteVal = round($mxRank + $note[$i], 1);
                $note[] = $noteVal;
            }

            $mxRank = round(($idQ[0]->maxScore - $idQ[0]->aprobeScore) / ($sumPoints - $minPoinApprob));

            for ($i = $minPoinApprob; $i < $sumPoints; $i++) {
                $noteVal = round($mxRank + $note[$i], 1);
                $note[] = $noteVal;
            }

            for ($i = 0; $i < count($note); $i++) {
                $note[$i] = ($i != (count($note) - 1)) ? intval(round($note[$i])) : intval($idQ[0]->maxScore);
            }

            $rankLim = array_keys($questAnsDef);
            $limInf = array_shift($rankLim);
            $limSup = array_pop($rankLim);

            for ($i = $limInf; $i <= $limSup; $i++) {
                if (isset($questAnsUse[$i])) {
                    if ($questAnsUse[$i] != $questAnsDef[$i]) {
                        $compareAnswers += 1;
                    }
                } elseif (isset($questAnsDef[$i])) {
                    $compareAnswers += 1;
                }
            }

            $statApprov = ($note[$pointsUser] >= $idQ[0]->aprobeScore) ? 'OK' : 'FAIL';
        }

        return array($compareAnswers, count($questAnsDef), $idQ[0]->dificulty, $sumPoints, $pointsUser, $note[$pointsUser], $statApprov);
    }

}