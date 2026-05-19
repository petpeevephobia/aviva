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

class flexamViewflanswer extends JView{
    function display($tpl = null){ 
        $document	= JFactory::getDocument();
	$document->addScript(JURI::base() . 'administrator/components/com_flexam/style/mainFunctions.js');
	$document->addStyleSheet(JURI::base() . 'administrator/components/com_flexam/style/flexam.css');

        $idsTest    = JRequest::getVar('selTest', '', 'post');
        $codeTest   = explode('&', $idsTest);
        $idTest     = $codeTest[0];

        $userTets = JFactory::getUser();
        $idU = $userTets->get('id');

        $model =& $this->getModel();

        $keys = array_keys($_POST);
        $idsQuestions = NULL;
        $idsRelTerm = NULL;
        $bool = true;

        $totError = $model->getTestResult($idTest, $idU, $codeTest[1]);
        
        $this->assignRef('totalError',$totError);
        $this->assignRef('detailTest',$model);

        parent::display($tpl);
    }

    public function sndMailTest ($idTest){
        global $mainframe;

        $db         =& JFactory::getDBO();
        $userTets   = JFactory::getUser();
        $idU        = $userTets->get('id');
        $bdyMsg     = JRequest::getVar('bdyMsg', '', 'post');
        $stateAprov = NULL;

        switch ($bdyMsg[7]) {
            case 'OK':
                $stateAprov = JText::_('FLEXAM_TEST_APPROVAL_LONG');
                break;

            case 'FAIL':
                $stateAprov = JText::_('FLEXAM_TEST_FAIL_LONG');
                break;

            default:
                $stateAprov = $bdyMsg[7];
                break;
        }
        
        $testResume = " <b>$stateAprov</b><br /><br /><b>".
                        JText::_('FLEXAM_RESULT_TOTAL').":</b> $bdyMsg[0]<br /><b>".JText::_('FLEXAM_TEST_DIFICULTY_TITLE').":</b> $bdyMsg[1]0%<br /><b>".
                        JText::_('FLEXAM_RESULT_WRONG').":</b> $bdyMsg[2]<br /><b>".JText::_('FLEXAM_RESULT_GOOD').":</b> $bdyMsg[3]<br /><b>".
                        JText::_('FLEXAM_TOTAL_POINTS').":</b> $bdyMsg[4]<br /><b>".JText::_('FLEXAM_TOTAL_POINTS_USER').":</b> $bdyMsg[5]<br /><b>".
                        JText::_('FLEXAM_TEST_TOTALSCORE').":</b> $bdyMsg[6]<br /><br /><hr />".$mainframe->getCfg('fromname');
        
        $dtToArray = $this->getUserTstInfo();
        $dtTo = array_pop($dtToArray);

        $query = 'SELECT nameTest'
                . ' FROM #__flexam_test'
                . ' WHERE idtest = '.(int) $idTest;

        $db->setQuery( $query );
        $nameTest = $db->loadResult();

        $subject        = JText::_('FLEXAM_SUBJECT_MASMAIL')." $nameTest";
        $message_body   = JText::_('FLEXAM_BODY_MASMAIL_TO').$dtTo->name.'<br /> <br />'.JText::_('FLEXAM_BODY_MASMAIL');

        $mailer =& JFactory::getMailer();

        $mailer->setSender(array($mainframe->getCfg('mailfrom'), $mainframe->getCfg('fromname')));
        $mailer->setSubject($subject);

        // Add recipients
        $mailer =& JFactory::getMailer();

        $mailer->setSender(array($mainframe->getCfg('mailfrom'), $mainframe->getCfg('fromname')));
        $mailer->setSubject($subject);

        $mailer->addRecipient($dtTo->email);
        $mailer->setBody($message_body.$testResume);
        $mailer->IsHTML(1);

        $mailer->addBCC($mainframe->getCfg('mailfrom'));
        
        $rs	= $mailer->Send();

        $mainframe->redirect( 'index.php?option=com_flexam&view=flanswer');
    }

    public function getUserTstInfo (){
        $db         =& JFactory::getDBO();
        $userTets   = JFactory::getUser();
        $idU        = $userTets->get('id');

        $query = 'SELECT name, email'
                . ' FROM #__users'
                . ' WHERE id = '.(int) $idU;

        $db->setQuery( $query );
        $usDtExam = $db->loadObjectList();

        return (!empty($usDtExam)) ? $usDtExam : false;
    }

    public function getDumUser (){
        $db         =& JFactory::getDBO();

        $query = "SELECT id FROM #__users WHERE email ='faked@faked.com'";

        $db->setQuery( $query );
        $id = $db->loadResult();

        return (!empty($id)) ? $id : false;
    }
}
?>