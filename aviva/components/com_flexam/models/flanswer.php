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

jimport( 'joomla.application.component.model' );

class flexamModelflanswer extends JModel{

    function getQuestionType($idQuestion){
        $db = $this->getDBO();
            
        $query = "SELECT idtypeQuestions FROM  #__flexam_questions WHERE idquestion='$idQuestion'";

        $db->setQuery($query);
        $typeQ = $db->loadObjectList();

        return (!empty($typeQ)) ? $typeQ : false;
    }

    function getTestResult($idTst, $idUser, $code){
        $db = $this->getDBO();
        $idUser = (empty($idUser)) ? $this->getDumUserAnswerModel() : $idUser;

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

        if(!empty($idQ)){
            foreach($idQ as $iQ){
                if($iQ->published){
                    $questAnsDef[$iQ->idquestion] = $iQ->response;
                    $sumPoints += (int)$iQ->points;
                }

                $query = "SELECT * ";
                $query .= "FROM  #__flexam_answer ";
                $query .= "WHERE (idquestion='$iQ->idquestion' AND iduser='$idUser') AND (dateAnswerTest='$code') ";
                
                $db->setQuery($query);
                $answ = $db->loadObjectList();

                if(!empty ($answ)){
                    foreach($answ as $nsw){
                        $questAnsUse[$iQ->idquestion] = $nsw->answer;

                        if($iQ->idtypeQuestions == '4'){
                            $arrResp = explode(';',$iQ->response);
                            $usAnLen = strlen($nsw->answer);

                            foreach($arrResp as $arrRp){
                                $tmpStr = str_replace($arrRp, '', $nsw->answer);

                                if(strlen($tmpStr) < $usAnLen){
                                    $pointsUser += 1;
                                }
                            }
                        }else{
                            if($iQ->response === $nsw->answer){
                                $pointsUser += (int)$iQ->points;
                            }
                        }
                    }
                }
            }

            $minPoinApprob = round($sumPoints * ($idQ[0]->dificulty / 10));
            $mxRank = round(($idQ[0]->aprobeScore - $idQ[0]->minScore)/$minPoinApprob, 1);
            $note = array(floatval($idQ[0]->minScore));

            for($i = 0; $i < $minPoinApprob; $i++){
                $noteVal = round($mxRank + $note[$i], 1);
                $note[] = $noteVal;
            }

            $mxRank = round(($idQ[0]->maxScore - $idQ[0]->aprobeScore)/($sumPoints - $minPoinApprob));

            for($i = $minPoinApprob; $i < $sumPoints; $i++){
                $noteVal = round($mxRank + $note[$i], 1);
                $note[] = $noteVal;
            }

            for($i = 0; $i < count($note); $i++){
                $note[$i] = ($i != (count($note) - 1)) ? intval(round($note[$i])) : intval($idQ[0]->maxScore);
            }

            $rankLim = array_keys($questAnsDef);
            $limInf = array_shift($rankLim);
            $limSup = array_pop($rankLim);

            for($i = $limInf; $i <= $limSup; $i++){
                if(isset($questAnsUse[$i])){
                    if($questAnsUse[$i] != $questAnsDef[$i]){
                        $compareAnswers += 1;
                    }
                }elseif(isset($questAnsDef[$i])){
                    $compareAnswers += 1;
                }
            }

            $statApprov = ($note[$pointsUser] >= $idQ[0]->aprobeScore) ? 'OK' : 'FAIL';
        }

        return array($compareAnswers,count($questAnsDef), $idQ[0]->dificulty, $sumPoints, $pointsUser, $note[$pointsUser], $statApprov);
    }

    function getExamTestQuestionsResult($idtest){
        $userTets = JFactory::getUser();
        $idU = $userTets->get('id');

        $db = $this->getDBO();

        $query = "SELECT a.idtest,c.idquestion,c.idtypeQuestions,e.idinstruction,a.nameTest,e.detail AS instructions,c.question,c.published,c.response ";
        $query .= "FROM #__flexam_test AS a INNER JOIN (#__flexam_questions_per_test AS b ";
        $query .= "INNER JOIN #__flexam_questions AS c ON b.idquestion=c.idquestion) ON a.idtest=b.idtest ";
        $query .= "INNER JOIN (#__flexam_instructions_per_test AS d ";
        $query .= "INNER JOIN #__flexam_instructions AS e ON d.idinstruction=e.idinstruction) ON a.idtest=d.idtest ";
        $query .= "WHERE a.idtest='$idtest' ORDER BY c.idquestion ASC ";

        $db->setQuery($query);
        $tsExam = $db->loadObjectList();

        return (!empty($tsExam)) ? $tsExam : false;

    }

    function getUserAnswer($idTest,$idUser,$codeTets){
        $db = $this->getDBO();
        $idUser = (empty($idUser)) ? $this->getDumUserAnswerModel() : $idUser;
        
        $query = "SELECT * ";
        $query .= "FROM  #__flexam_answer AS a INNER JOIN #__flexam_questions_per_test AS b ON a.idquestion=b.idquestion ";
        $query .= "WHERE b.idtest='$idTest' AND a.iduser='$idUser' AND a.dateAnswerTest='$codeTets' ORDER BY a.idquestion ASC ";
        
        $db->setQuery($query);
        $answ = $db->loadObjectList();
        $outPut = NULL;
        
        if($answ){
            foreach($answ as $ans){
                $outPut[$ans->idquestion] = $ans->answer;
            }
        }
        
        return (!empty($outPut)) ? $outPut : false;
    }

    function showTestUser( $idUser ){
        global $mainframe, $option;
        $idUser = (empty($idUser)) ? $this->getDumUserAnswerModel() : $idUser;

        $document	= JFactory::getDocument();
	$document->addScript(JURI::base() . 'components/com_flexam/style/mainFunctions.js');
	$document->addStyleSheet(JURI::base() . 'components/com_flexam/style/flexam.css');


        $db =& $this->getDBO();
        $query = 'SELECT g.name AS nameUser, d.nameTest, e.subjects AS courses, '
        . 'f.areaName AS coursesAreas, d.idtest AS checked_out, d.idtest AS id, g.id AS idUser, '
        . 'DATE_FORMAT(LEFT(m.dateAnswerTest,10),"%d-%m-%Y") AS dateAnsw, m.dateAnswerTest AS codeAnswerTest  '
        . 'FROM #__flexam_answer  AS m LEFT JOIN (#__flexam_questions_per_test AS b '
        . 'INNER JOIN #__flexam_questions AS c ON b.idquestion=c.idquestion '
        . 'INNER JOIN (#__flexam_test AS d INNER JOIN (#__flexam_subjects AS e '
        . 'INNER JOIN #__flexam_knowledgeAreas AS f ON e.idknowledgeArea=f.idknowledgeArea) '
        . 'ON d.idsubjects=e.idsubjects) ON b.idtest=d.idtest) ON m.idquestion=b.idquestion '
        . 'INNER JOIN #__users AS g ON m.iduser=g.id WHERE g.id="'.$idUser.'"'
        . ' GROUP BY d.idtest, g.id, m.dateAnswerTest ORDER BY dateAnsw DESC';

        $db->setQuery( $query );
        $rows = $db->loadObjectList();

        return (!empty($rows)) ? $rows : false;
    }

    function getDumUserAnswerModel (){
        $db = $this->getDBO();

        $query = "SELECT id FROM #__users WHERE email ='faked@faked.com'";

        $db->setQuery( $query );
        $id = $db->loadResult();

        return (!empty($id)) ? $id : false;
    }
}