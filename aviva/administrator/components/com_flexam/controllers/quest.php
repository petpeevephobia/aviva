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
jimport('joomla.client.helper');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * @package	Joomla
 * @subpackage	Config
 */
class flExamControllerQuest extends JController {

    /**
     * Custom Constructor
     */
    function __construct($default = array()) {
        parent::__construct($default);

        $this->registerTask('edit', 'display');
        $this->registerTask('add', 'display');
        $this->registerTask('copy', 'display');
    }

    function display() {
        $actEvt = JRequest::getVar('task');

        switch ($actEvt) {
            case 'add' : {
                    JRequest::setVar('hidemainmenu', 1);
                    JRequest::setVar('layout', 'form');
                    JRequest::setVar('view', 'quest');
                    JRequest::setVar('edit', false);
                }
                break;

            case 'edit' : {
                    JRequest::setVar('hidemainmenu', 1);
                    JRequest::setVar('layout', 'form');
                    JRequest::setVar('view', 'quest');
                    JRequest::setVar('edit', true);
                }
                break;

            case 'copy' : {
                    JRequest::setVar('hidemainmenu', 1);
                    JRequest::setVar('layout', 'form');
                    JRequest::setVar('view', 'quest');
                    JRequest::setVar('edit', false);
                    JRequest::setVar('add', false);
                    JRequest::setVar('copy', true);
                }
                break;
        }

        if ($actEvt === 'save') {
            $this->save();
        }

        if ($actEvt === 'update') {
            $this->update();
        }

        if ($actEvt === 'remove') {
            $this->remove();
        }

        if ($actEvt === 'copyTest') {
            $this->copy();
        }

        //Set the default view, just in case
        $view = JRequest::getCmd('view');
        if (empty($view)) {
            JRequest::setVar('view', 'quest');
        };

        parent::display();
    }

    function save() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');

        $db = & JFactory::getDBO();

        $nTestQst = JRequest::getVar('idTest', NULL, 'POST');
        $numQst = JRequest::getVar('numQst', NULL, 'POST');

        if (!empty($numQst)) {
            for ($i = 1; $i <= (int) $numQst; $i++) {
                $published = JRequest::getVar('published' . $i, NULL, 'POST');
                $pointQst = JRequest::getVar('pointQst' . $i, NULL, 'POST');
                $answQst = JRequest::getVar('answQst' . $i, NULL, 'POST');
                $answQst = (!empty($answQst)) ? strtoupper($answQst) : NULL;
                $typeQst = JRequest::getVar('typeQst' . $i, NULL, 'POST');

                $questionText = JRequest::getVar('txtQuest' . $i, '', 'post', 'string', JREQUEST_ALLOWRAW);
                $questionText = str_replace('"', '&#34;', $questionText);
                $questionText = str_replace("'", '&#39;', $questionText);

                $qry = "INSERT INTO #__flexam_questions (question, response, published, idtypeQuestions) ";
                $qry .= "VALUES ('$questionText', '$answQst', '$published', '$typeQst')";
                
                $db->setQuery($qry);
                $db->query();

                $db->setQuery("SELECT MAX(idquestion) FROM #__flexam_questions");
                $idQ = $db->loadResult();

                $qry = "INSERT INTO #__flexam_questions_per_test (idquestion, idtest, points) ";
                $qry .= "VALUES ('$idQ', '$nTestQst', '$pointQst')";

                $db->setQuery($qry);
                $db->query();
            }
        }

        $this->setRedirect('index.php?option=com_flexam&view=quest&optCtrl=questionTest');
    }

    function update() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');

        $db = & JFactory::getDBO();

        $nTestQst = JRequest::getVar('idTest', NULL, 'POST');
        $numQst = JRequest::getVar('numQst', NULL, 'POST');

        if (!empty($numQst)) {
            for ($i = 1; $i <= (int) $numQst; $i++) {
                $published = JRequest::getVar('published' . $i, NULL, 'POST');
                $pointQst = JRequest::getVar('pointQst' . $i, NULL, 'POST');
                $answQst = JRequest::getVar('answQst' . $i, NULL, 'POST');
                $answQst = (!empty($answQst)) ? strtoupper($answQst) : NULL;
                $typeQst = JRequest::getVar('typeQst' . $i, NULL, 'POST');
                $idQuest = JRequest::getVar('idQuest' . $i, NULL, 'POST');

                $questionText = JRequest::getVar('txtQuest' . $i, '', 'post', 'string', JREQUEST_ALLOWRAW);
                $questionText = str_replace('"', '&#34;', $questionText);
                $questionText = str_replace("'", '&#39;', $questionText);

                $qry = "UPDATE #__flexam_questions SET question='$questionText', " .
                        "response='$answQst', published= '$published' ";
                if (is_numeric($typeQst)) {
                    $qry .= ", idtypeQuestions='$typeQst'";
                }

                $qry .= " WHERE idquestion='$idQuest'";

                $db->setQuery($qry);
                $db->query();

                $qry = "UPDATE #__flexam_questions_per_test SET points='$pointQst' WHERE idquestion='$idQuest'";

                $db->setQuery($qry);
                $db->query();
            }
        }

        $this->setRedirect('index.php?option=com_flexam&view=quest&optCtrl=questionTest');
    }

    function remove() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');

        $db = & JFactory::getDBO();
        $cid = JRequest::getVar('cid', array(), '', 'array');

        JArrayHelper::toInteger($cid);

        for ($i = 0, $n = count($cid); $i < $n; $i++) {
            $qry = "SELECT a.idquestion FROM #__flexam_questions_per_test AS a " .
                    "INNER JOIN #__flexam_questions AS b ON a.idquestion=b.idquestion  WHERE a.idtest = '" . $cid[$i] . "'";

            $db->setQuery($qry);
            $qst = $db->loadObjectList();

            $db->setQuery("DELETE FROM #__flexam_questions_per_test WHERE idtest = '" . $cid[$i] . "'");
            $db->query();

            if (!empty($qst)) {
                foreach ($qst as $qSt) {
                    $db->setQuery("DELETE FROM #__flexam_questions WHERE idquestion = '" . $qSt->idquestion . "'");
                    $db->query();
                }
            }
        }

        $this->setRedirect('index.php?option=com_flexam&view=quest&optCtrl=questionTest');
    }

    function copy() {
        JRequest::checkToken() or jexit('Invalid Token');

        $idOld = JRequest::getVar('idTestOld', 0, '', 'int');
        $idNew = JRequest::getVar('idTest', 0, '', 'int');

        $db = & JFactory::getDBO();

        if(!empty($idOld) && !empty($idNew)){
            $db->setQuery("SELECT * FROM #__flexam_questions_per_test WHERE idtest = '" . $idOld . "'");
            $qst = $db->loadObjectList();

            if(!empty($qst)){
                foreach ($qst as $qs) {
                    $db->setQuery("SELECT * FROM #__flexam_questions WHERE idquestion = '" . $qs->idquestion . "'");
                    $qstData = $db->loadObjectList();

                    if(!empty($qstData)){
                        foreach ($qstData AS $qDt){
                            $qry = "INSERT INTO #__flexam_questions (question, response, published, idtypeQuestions) ";
                            $qry .= "VALUES ('$qDt->question', '$qDt->response', '$qDt->published', '$qDt->idtypeQuestions')";
                            
                            $db->setQuery($qry);
                            $db->query();

                            $db->setQuery("SELECT MAX(idquestion) FROM #__flexam_questions");
                            $idC = $db->loadResult();

                            $qry = "INSERT INTO #__flexam_questions_per_test (idquestion, idtest, points) ";
                            $qry .= "VALUES ('$idC', '$idNew', '$qs->points')";
                            
                            $db->setQuery($qry);
                            $db->query();
                        }
                    }
                }
            }
        }
    }

    function cancel() {
        // Check for request forgeries
        JRequest::checkToken() or jexit('Invalid Token');
        
        $id = JRequest::getVar('id', 0, '', 'int');
        $db = & JFactory::getDBO();
        $row = & JTable::getInstance('questions', 'Table');

        $row->checkin($id);
        $this->setRedirect('index.php?option=com_flexam&view=quest&optCtrl=questionTest');
    }

}