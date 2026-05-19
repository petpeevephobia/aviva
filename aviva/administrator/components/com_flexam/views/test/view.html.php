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

class flExamViewTest extends JView{
    function display( $tpl = null ){
        global $mainframe, $option;

        $document	= JFactory::getDocument();
	$document->addScript(JURI::base() . 'components/com_flexam/style/mainFunctions.js');
	$document->addStyleSheet(JURI::base() . 'components/com_flexam/style/flexam.css');


		$db			=& JFactory::getDBO();
                $filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order_test",		'filter_order',		'm.idtest',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir_test",	'filter_order_Dir',	'',		'word' );
		$filter_state		= $mainframe->getUserStateFromRequest( "$option.filter_state_test",		'filter_state',		'',		'word' );
		$search			= $mainframe->getUserStateFromRequest( "$option.search_test",			'search',	'',		'string' );
		$search			= JString::strtolower( $search );

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		$where = array();

		if ( $filter_state )
		{
			if ( $filter_state == 'P' )
			{
				$where[] = 'm.published = 1';
			}
			else if ($filter_state == 'U' )
			{
				$where[] = 'm.published = 0';
			}
		}
		if ($search)
		{
			$where[] = 'LOWER(m.nameTest) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		}

		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
		$orderby 	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir;

		$query = 'SELECT COUNT(m.idtest)'
		. ' FROM #__flexam_test AS m'
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT m.*, b.subjects, COUNT(b.idsubjects) AS numoptions, m.checked_out, '
                . ' m.idtest AS id, c.areaName, d.pCent AS testDificulty, DATE_FORMAT(m.dateTest,"%d-%m-%Y") AS dateT '
		. ' FROM #__flexam_test AS m LEFT JOIN #__flexam_subjects AS b ON m.idsubjects=b.idsubjects '
		. ' LEFT JOIN #__flexam_knowledgeAreas AS c ON b.idknowledgeArea = c.idknowledgeArea '
                . ' LEFT JOIN #__flexam_dificulty AS d ON m.dificulty = d.idDificulty '
		. $where
		. ' GROUP BY m.idtest'
		. $orderby
		;
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();

		if ($db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}

                $query = 'SELECT idsubjects ,subjects FROM #__flexam_subjects ';

		$db->setQuery( $query );
		$subjAsocLst = $db->loadObjectList();

                $query = 'SELECT * FROM #__flexam_dificulty ';

		$db->setQuery( $query );
		$difLevel = $db->loadObjectList();
                
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
                $this->assignRef('subjAsocLst',	$subjAsocLst);
                $this->assignRef('difLevel',	$difLevel);

		parent::display($tpl);
	}

        function getIntruction($idTest){
            $db			=& JFactory::getDBO();

            $query = "SELECT a.detail  FROM #__flexam_instructions AS a " .
               "INNER JOIN #__flexam_instructions_per_test AS b ON a.idinstruction=b.idinstruction AND b.idtest='$idTest'";

            $db->setQuery( $query );
            return $db->loadResult();
        }
}