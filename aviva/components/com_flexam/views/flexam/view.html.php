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
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class flexamViewflexam extends JView {
    function display($tpl = null) {
        $document	= JFactory::getDocument();
        $document->addScript(JURI::base() . 'administrator/components/com_flexam/style/mainFunctions.js');
        $document->addStyleSheet(JURI::base() . 'administrator/components/com_flexam/style/flexam.css');
        
        $model =& $this->getModel();
        $areaExam = $model->getAreaExam();
        $subjects = $model->getSubjects($areaExam);
        
        $level = JRequest::getVar('deepLv', '', 'post');
        $idTest = JRequest::getVar('chooseId', '', 'post');
        $idTestDone = JRequest::getVar('rqCode', '', 'post');
        
        if((int)$level == 3) {
            $userTets = JFactory::getUser();
            $idU = $userTets->get('id');

            if(empty($idU)){
                $idU = $this->getDumUser();
            }
            
            $keys = array_keys($_POST);
            $idsQuestions = NULL;
            $idsRelTerm = NULL;
            $bool = true;
            $rdn = rand(0, 999999);
            
            foreach($keys as $ks) {
                $tmpSQ = str_replace('userAnswer', '', $ks);

                if(is_numeric($tmpSQ)) {
                    $idsQuestions[] = $tmpSQ;
                }
            }

            foreach($idsQuestions as $idsQ) {
                $typIdQ = $model->getQuestionType($idsQ);
                $tmpRTA = NULL;
                
                $model->insertAnswers($idU, $idsQ, $_POST['userAnswer'.$idsQ], $rdn);
                
            }

            $totError = $model->getTestResult($idTest, $idU);
            
            if(!empty($idTestDone)){
                $this->updateTestDone($totError[6], $idTestDone, $rdn);
            }

            $this->sndMailTests($totError, $idTest);

            $this->assignRef('totalError',$totError);
        }

        $this->assignRef('areaExam',$areaExam);
        $this->assignRef('subjects',$subjects);
        $this->assignRef('getElemFlExam',$model);

        parent::display($tpl);
    }

    public function sndMailTests ($bdyMsg, $idTest){
        global $mainframe;
        
        $db                 =& JFactory::getDBO();
        $userTets           = JFactory::getUser();
        $idU                = $userTets->get('id');
        $typeTest           = $this->getTypeTestInfo($idTest);
        $rqCode             = JRequest::getVar('rqCode', '', 'post');
        $testResume         = NULL;
        $testResumeSuper    = NULL;
        $serverResp         = NULL;
        $stateAprov         = NULL;
        $coda               = NULL;
        
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

        $testResume = "<b>$stateAprov</b><br /><br /><b>".
                        JText::_('FLEXAM_RESULT_TOTAL').":</b> $bdyMsg[1]<br /><b>".JText::_('FLEXAM_TEST_DIFICULTY_TITLE').":</b> $bdyMsg[2]0%<br /><b>".
                        JText::_('FLEXAM_RESULT_WRONG').":</b> $bdyMsg[0]<br /><b>".JText::_('FLEXAM_RESULT_GOOD').":</b> ".($bdyMsg[1] - $bdyMsg[0])."<br /><b>".
                        JText::_('FLEXAM_TOTAL_POINTS').":</b> $bdyMsg[3]<br /><b>".JText::_('FLEXAM_TOTAL_POINTS_USER').":</b> $bdyMsg[4]<br /><b>".
                        JText::_('FLEXAM_TEST_TOTALSCORE').":</b> $bdyMsg[5]<br /><br />";
        
        
        $dtToArray = $this->getUserTestInfo();
        $dtTo = array_pop($dtToArray);
        
        $query = 'SELECT nameTest'
                . ' FROM #__flexam_test'
                . ' WHERE idtest = '.(int) $idTest;

        $db->setQuery( $query );
        $nameTest = $db->loadResult();
        
        $subject        = JText::_('FLEXAM_SUBJECT_MASMAIL')." $nameTest";
        $message_body   = JText::_('FLEXAM_BODY_MASMAIL_TO').$dtTo->name.'<br /> <br />'.JText::_('FLEXAM_BODY_MASMAIL').' ';
        $mailOutMsg     = _FLEXAM_SERVEROUTMAIL;
        
        if(!empty($mailOutMsg)){
            $urlmail = $mailOutMsg."?curso=".$rqCode;
            $chm = curl_init($urlmail);
            curl_setopt($chm, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($chm, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($chm, CURLOPT_RETURNTRANSFER,1);
            $serverResp = utf8_encode(curl_exec ($chm));
            $info = curl_getinfo($chm);
            curl_close ($chm);

            if ($serverResp === false || $info['http_code'] != 200) {
                $serverResp = false;
            }
        }

        if($serverResp){
            $testResume .= $serverResp;
        }

        $coda = "<br /><br /><hr />".$mainframe->getCfg('fromname');
        
        if(3 > (int)$typeTest[0][0]){
            $mailer =& JFactory::getMailer();
            
            $mailer->setSender(array($mainframe->getCfg('mailfrom'), $mainframe->getCfg('fromname')));
            $mailer->setSubject($subject);

            $mailer->addRecipient($dtTo->email);
            $mailer->setBody($message_body.$testResume.$coda);
            $mailer->IsHTML(1);

            $mailer->addBCC($typeTest[0][1]);
            
            $rs	= $mailer->Send();
        } else {
            unset($mailer);

            $mailer =& JFactory::getMailer();

            $mailer->setSender(array($mainframe->getCfg('mailfrom'), $mainframe->getCfg('fromname')));
            $mailer->setSubject($subject);

            $mailer->addRecipient($typeTest[0][1]);
            $mailer->setBody($message_body.$testResume.$coda);
            $mailer->IsHTML(1);

            $rs	= $mailer->Send();
        }
    }

    public function getUserTestInfo (){
        $db         =& JFactory::getDBO();
        $userTets   = JFactory::getUser();
        $idU        = $userTets->get('id');

        if(empty($idU)){
            $idU = $this->getDumUser();
        }

        $query = 'SELECT name, email'
                . ' FROM #__users'
                . ' WHERE id = '.(int) $idU;

        $db->setQuery( $query );
        $usDtExam = $db->loadObjectList();

        return (!empty($usDtExam)) ? $usDtExam : false;
    }

    public function getTypeTestInfo ($id){
        $db         =& JFactory::getDBO();

        $query = "SELECT c.idTypeSubject, b.mailManager FROM #__flexam_test AS a " .
                "INNER JOIN (#__flexam_subjects AS b INNER JOIN #__flexam_typeSubject AS c ON b.idTypeSubject=c.idTypeSubject ) ON a.idsubjects = b.idsubjects " .
                "WHERE a.idtest ='$id'";

        $db->setQuery( $query );
        $idTest = $db->loadRowList();

        return (!empty($idTest)) ? $idTest : false;
    }

    public function updateTestDone ($testVal, $idTestDone, $rdn){
        $db =& JFactory::getDBO();
        $dateCode = date("Y-m-d")."_$rdn";
        $id = NULL;

        switch($testVal){
            case 'OK':
                $id = 1;
                break;

            case 'FAIL':
                $id = 2;
                break;
        }

        $query = "UPDATE #__flexam_testDone_state SET idState='$id', dateCode='$dateCode' WHERE numApply='$idTestDone'";

        $db->setQuery( $query );
        $db->query();
    }

    public function getDumUser (){
        $db         =& JFactory::getDBO();

        $query = "SELECT id FROM #__users WHERE email ='faked@faked.com'";

        $db->setQuery( $query );
        $id = $db->loadResult();

        return (!empty($id)) ? $id : false;
    }

    public function getConf ($key=NULL) {
        $db         =& JFactory::getDBO();

        $query = "SELECT value FROM #__flexam_connconfig ";
        
        if(!empty ($key)) {
            $query .= "WHERE type ='$key'";
        }

        $db->setQuery( $query );
        $id = $db->loadResult();

        return (!empty($id)) ? $id : false;
    }
}
?>
