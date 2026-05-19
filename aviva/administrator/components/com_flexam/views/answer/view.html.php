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

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class flExamViewAnswer extends JView{
    function display( $tpl = null ){
        global $mainframe, $option;

        $document	= JFactory::getDocument();
	$document->addScript(JURI::base() . 'components/com_flexam/style/mainFunctions.js');
	$document->addStyleSheet(JURI::base() . 'components/com_flexam/style/flexam.css');


        $db			=& JFactory::getDBO();
        $filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order_Answer",		'filter_order',		'd.idtest',	'cmd' );
        $filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir_Answer",	'filter_order_Dir',	'',		'word' );
        $search			= $mainframe->getUserStateFromRequest( "$option.search_Answer",                      'search',		'',		'string' );
        $search			= JString::strtolower( $search );

        $limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
        $limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

        $where = array();

        if ($search){
                $where[] = 'LOWER(g.name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
        }

        $where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
        $orderby 	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir;

        $query = 'SELECT COUNT(d.idtest)  '
        . 'FROM #__flexam_answer  AS m LEFT JOIN (#__flexam_questions_per_test AS b '
        . 'INNER JOIN #__flexam_questions AS c ON b.idquestion=c.idquestion '
        . 'INNER JOIN (#__flexam_test AS d INNER JOIN (#__flexam_subjects AS e '
        . 'INNER JOIN #__flexam_knowledgeAreas AS f ON e.idknowledgeArea=f.idknowledgeArea) '
        . 'ON d.idsubjects=e.idsubjects) ON b.idtest=d.idtest) ON m.idquestion=b.idquestion '
        . 'INNER JOIN #__users AS g ON m.iduser=g.id '
        . $where
        . ' GROUP BY d.idtest, g.id, m.dateAnswerTest ';
        
        $db->setQuery( $query );
        $total = $db->loadResult();

        jimport('joomla.html.pagination');
        $pagination = new JPagination( $total, $limitstart, $limit );

        $query = 'SELECT g.name AS nameUser, d.nameTest, e.subjects AS courses, '
        . 'f.areaName AS coursesAreas, d.idtest AS checked_out, CONCAT(g.id,"&",d.idtest,"&",m.dateAnswerTest) AS id, '
        . 'g.id AS idUser, DATE_FORMAT(LEFT(m.dateAnswerTest,10),"%d-%m-%Y") AS dateAnswer  '
        . 'FROM #__flexam_answer  AS m LEFT JOIN (#__flexam_questions_per_test AS b '
        . 'INNER JOIN #__flexam_questions AS c ON b.idquestion=c.idquestion '
        . 'INNER JOIN (#__flexam_test AS d INNER JOIN (#__flexam_subjects AS e '
        . 'INNER JOIN #__flexam_knowledgeAreas AS f ON e.idknowledgeArea=f.idknowledgeArea) '
        . 'ON d.idsubjects=e.idsubjects) ON b.idtest=d.idtest) ON m.idquestion=b.idquestion '
        . 'INNER JOIN #__users AS g ON m.iduser=g.id '
        . $where
        . ' GROUP BY d.idtest, g.id, m.dateAnswerTest '
        . $orderby;

        $db->setQuery( $query, $pagination->limitstart, $pagination->limit );
        $rows = $db->loadObjectList();

        if ($db->getErrorNum())
        {
                echo $db->stderr();
                return false;
        }

        // table ordering
        $lists['order_Dir']	= $filter_order_Dir;
        $lists['order']		= $filter_order;

        // search filter
        $lists['search']= $search;

        $this->assignRef('user',		JFactory::getUser());
        $this->assignRef('lists',		$lists);
        $this->assignRef('items',		$rows);
        $this->assignRef('pagination',	$pagination);

        parent::display($tpl);
    }

    function getQuestionType($idQuestion){
        $db =& JFactory::getDBO();

        $query = "SELECT idtypeQuestions FROM  #__flexam_questions WHERE idquestion='$idQuestion'";

        $db->setQuery($query);
        $typeQ = $db->loadObjectList();

        return (!empty($typeQ)) ? $typeQ : false;
    }

    function getTestResult($idTst, $idUser, $idAnswTest){
        $db =& JFactory::getDBO();

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
                $query .= "WHERE (dateAnswerTest='$idAnswTest') ";
                $query .= "AND (idquestion='$iQ->idquestion' AND iduser='$idUser') ";
                
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

        $db =& JFactory::getDBO();

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

    function getUserAnswer($idTest,$idUser, $idAnswTest){
        $db =& JFactory::getDBO();

        $query = "SELECT * ";
        $query .= "FROM  #__flexam_answer AS a INNER JOIN #__flexam_questions_per_test AS b ON a.idquestion=b.idquestion ";
        $query .= "WHERE b.idtest='$idTest' AND a.iduser='$idUser' AND a.dateAnswerTest='$idAnswTest' ORDER BY a.idquestion ASC ";

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

    public function getUsTstInfo ($idUser){
        $db =& JFactory::getDBO();
        
        $query = 'SELECT name, email'
                . ' FROM #__users'
                . ' WHERE id = '.(int) $idUser;

        $db->setQuery( $query );
        $usDtExam = $db->loadObjectList();

        return (!empty($usDtExam)) ? $usDtExam : false;
    }
}