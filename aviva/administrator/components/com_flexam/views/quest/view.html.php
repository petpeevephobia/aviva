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

class flExamViewQuest extends JView{
    function display( $tpl = null ){
        global $mainframe, $option;

        $document	= JFactory::getDocument();
        $document->addScript(JURI::base() . 'components/com_flexam/style/mainFunctions.js');
        $document->addStyleSheet(JURI::base() . 'components/com_flexam/style/flexam.css');

        $db			=& JFactory::getDBO();
        $filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order_Quest",        'filter_order',	'm.idtest',	'cmd' );
        $filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir_Quest",    'filter_order_Dir',	'',		'word' );
        $filter_state		= $mainframe->getUserStateFromRequest( "$option.filter_state_Quest",        'filter_state',	'',		'word' );
        $search			= $mainframe->getUserStateFromRequest( "$option.search_Quest",              'search',		'',		'string' );
        $search			= JString::strtoupper( $search );

        $limit                  = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
        $limitstart             = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

        $typeQuestArray = array('FLEXAM_TITLE_TQUESTIONS_ALTER', 'FLEXAM_TITLE_TQUESTIONS_RTERM', 'FLEXAM_TITLE_TQUESTIONS_TRUFAL', 'FLEXAM_TITLE_TQUESTIONS_OPENQ');
        $tQuestName = array('Multiple Choice', 'Related Term', 'True or False', 'Open Response');

        $where = array();

        if ( $filter_state ){
            if ( $filter_state == 'P' ){
                    $where[] = 'm.published = 1';
            } else if ($filter_state == 'U' ){
                    $where[] = 'm.published = 0';
            }
        }

        if ($search){
                $where[] = 'LOWER(b.nameTest ) LIKE '.$db->Quote( '%'.$db->getEscaped( $tQuestName[array_search($search, $typeQuestArray)], true ).'%', false );
        }

        $where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
        $orderby 	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir;

        $query = 'SELECT COUNT(m.idtest)'
        . ' FROM #__flexam_test AS m'
        . $where;

        $db->setQuery( $query );
        $total = $db->loadResult();

        jimport('joomla.html.pagination');
        $pagination = new JPagination( $total, $limitstart, $limit );

        $query = 'SELECT m.*, COUNT(m.idtest) AS numQuestions, m.checked_out, m.idtest AS id, '
        . ' DATE_FORMAT(m.dateTest,"%d-%m-%Y") AS dateT, c.pCent AS testDificulty, b.subjects '
        . ' FROM (#__flexam_test AS m INNER JOIN #__flexam_questions_per_test AS d ON m.idtest=d.idtest) '
        . ' INNER JOIN #__flexam_subjects AS b ON m.idsubjects=b.idsubjects '
        . ' INNER JOIN #__flexam_dificulty AS c ON m.dificulty=c.idDificulty'
        . $where
        . ' GROUP BY m.idtest'
        . $orderby
        ;
        $db->setQuery( $query, $pagination->limitstart, $pagination->limit );
        $rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
                echo $db->stderr();
                return false;
        }

        $db	=& JFactory::getDBO();

        $query = 'SELECT idtest, nameTest FROM #__flexam_test';

        $db->setQuery( $query );
        $nTstLst = $db->loadObjectList();

        // state filter
        $lists['state']	= JHTML::_('grid.state',  $filter_state );

        // table ordering
        $lists['order_Dir']	= $filter_order_Dir;
        $lists['order']		= $filter_order;

        // search filter
        $lists['search']= $search;

        $this->assignRef('user',	JFactory::getUser());
        $this->assignRef('lists',	$lists);
        $this->assignRef('items',	$rows);
        $this->assignRef('pagination',	$pagination);
        $this->assignRef('nameTstLst',	$nTstLst);

        parent::display($tpl);
    }

    function getDataQuestions($idTest){
        $db	=& JFactory::getDBO();

        $query = 'SELECT COUNT(*) FROM `#__flexam_questions_per_test` WHERE `idtest`='."'$idTest'";

        $db->setQuery( $query );
        $out->numQuest = $db->loadResult();

        $query = 'SELECT idquestion,points FROM `#__flexam_questions_per_test` WHERE `idtest`='."'$idTest'";

        $db->setQuery( $query );
        $lstIdQst = $db->loadObjectList();

        if(!empty($lstIdQst)){
            foreach($lstIdQst AS $lIdQ){
                $query = 'SELECT * FROM `#__flexam_questions` WHERE `idquestion`='."'$lIdQ->idquestion'";

                $db->setQuery( $query );
                $lstDataQst = $db->loadObjectList();

                if(!empty($lstDataQst)){
                    foreach($lstDataQst as $lDtQ){
                        $out->id[]              = $lDtQ->idquestion;
                        $out->question[]        = $lDtQ->question;
                        $out->response[]        = $lDtQ->response;
                        $out->published[]       = $lDtQ->published;
                        $out->checked_out[]     = $lDtQ->checked_out;
                        $out->idtypeQuestions[] = $lDtQ->idtypeQuestions;
                    }
                }

                $out->points[] = $lIdQ->points;
            }
        }

        return $out;
    }

    function getSelectedType($idType){
        $typeQuestArray[] = JText::_('FLEXAM_TITLE_TQUESTIONS_ALTER');
        $typeQuestArray[] = JText::_('FLEXAM_TITLE_TQUESTIONS_RTERM');
        $typeQuestArray[] = JText::_('FLEXAM_TITLE_TQUESTIONS_TRUFAL');
        $typeQuestArray[] = JText::_('FLEXAM_TITLE_TQUESTIONS_OPENQ');
        $tQuestName = array('Multiple Choice', 'Related Term', 'True or False', 'Open Response');
        $out = NULL;

        $db	=& JFactory::getDBO();

        $query = 'SELECT * FROM `#__flexam_typeQuestions`';

        $db->setQuery( $query );
        $typQuest = $db->loadObjectList();

        if(!empty($typQuest)){
            foreach($typQuest as $typQ){
                if($typQ->idtypeQuestions == $idType){
                    $out .= $typeQuestArray[array_search($typQ->type, $tQuestName)];
                }
            }
        }

        return $out;
    }

    function getTestInfo($id){
        $db	=& JFactory::getDBO();

        $query = "SELECT nameTest FROM #__flexam_test WHERE idtest='$id'";

        $db->setQuery( $query );
        $data = $db->loadResult();

        return $data;
    }

    function addNewQ(){
        $newNumQst = JRequest::getVar( 'newNumQ', NULL, 'POST');
        $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
        $db	=& JFactory::getDBO();

        if(!empty($newNumQst)){
            for($i = 0; $i < $newNumQst; $i++){
                $query = "INSERT INTO #__flexam_questions (published, idtypeQuestions) values ('1', '1')";

                $db->setQuery( $query );
                $db->query();

                $query = "SELECT MAX(idquestion) FROM #__flexam_questions";

                $db->setQuery( $query );
                $id = $db->loadResult();

                $query = "INSERT INTO #__flexam_questions_per_test (idquestion, idtest) values ('$id', '$cid[0]')";

                $db->setQuery( $query );
                $db->query();
            }
        }
    }

    function delSelQ(){
        $delQst = JRequest::getVar( 'idToDel', array(0), 'POST');
        $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
        $db	=& JFactory::getDBO();
        
        if(!empty($delQst)){
            foreach($delQst as $dQ){
                $query = "DELETE FROM #__flexam_questions_per_test WHERE idquestion = '$dQ' AND idtest = '$cid[0]'";

                $db->setQuery( $query );
                $db->query();

                $query = "DELETE FROM #__flexam_questions WHERE idquestion = '$dQ' ";

                $db->setQuery( $query );
                $db->query();
            }
        }
    }

    function goAway($url){
        echo "<script>";
        if(!empty($msg)){
            echo "alert('$msg'); ";
        }
        echo "document.location='$url'</script>";
    }
}