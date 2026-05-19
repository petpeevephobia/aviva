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

class flExamViewCfg extends JView {
    function display( $tpl = null ) {
        global $mainframe, $option;

        $document	= JFactory::getDocument();
        $document->addScript(JURI::base() . 'components/com_flexam/style/mainFunctions.js');
        $document->addStyleSheet(JURI::base() . 'components/com_flexam/style/flexam.css');

        $db	=& JFactory::getDBO();

        $query = 'SELECT * FROM #__flexam_connconfig ';

        $db->setQuery( $query );
        $rows = $db->loadObjectList();


        $this->assignRef('user',	JFactory::getUser());
        $this->assignRef('items',	$rows);

        parent::display($tpl);
    }
}