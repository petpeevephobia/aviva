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

class flExamViewflExam extends JView{
    function display( $tpl = null ){
        global $mainframe, $option;

        $document	= JFactory::getDocument();
	$document->addScript(JURI::base() . 'components/com_flexam/style/mainFunctions.js');
	$document->addStyleSheet(JURI::base() . 'components/com_flexam/style/flexam.css');


		$db			=& JFactory::getDBO();
                $filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order_cArea",		'filter_order',		'm.idknowledgeArea',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir_cArea",	'filter_order_Dir',	'',		'word' );
		$filter_state		= $mainframe->getUserStateFromRequest( "$option.filter_state_cArea",		'filter_state',		'',		'word' );
		$search			= $mainframe->getUserStateFromRequest( "$option.search_cArea",			'search',			'',		'string' );
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
			$where[] = 'LOWER(m.areaName) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		}

		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
		$orderby 	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir;

		$query = 'SELECT COUNT(m.idknowledgeArea)'
		. ' FROM #__flexam_knowledgeAreas AS m'
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT m.*, b.subjects AS subjects, COUNT(b.idknowledgeArea) AS numoptions,m.checked_out,m.idknowledgeArea AS id '
		. ' FROM #__flexam_knowledgeAreas AS m'
		. ' LEFT JOIN #__flexam_subjects AS b ON b.idknowledgeArea = m.idknowledgeArea AND b.subjects <> ""'
		. $where
		. ' GROUP BY m.idknowledgeArea'
		. $orderby
		;
		$db->setQuery( $query, $pagination->limitstart, $pagination->limit );
		$rows = $db->loadObjectList();

		if ($db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}

		// state filter
		$lists['state']	= JHTML::_('grid.state',  $filter_state );

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
}