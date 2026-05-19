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

defined( '_JEXEC' ) or die( 'Restricted access' );

// Make sure the user is authorized to view this page
$user =& JFactory::getUser();

// Set the table directory
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_flexam'.DS.'tables');

// Create the controller
$optCtrl = JRequest::getCmd('optCtrl');
$controllerFileName = 'areaexam';

switch ($optCtrl){
    default:
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_AREAS'), 'index.php?option=com_flexam&optCtrl=areaCourse', true );
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_SUBJECTS'), 'index.php?option=com_flexam&optCtrl=courseName');
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_TESTS'), 'index.php?option=com_flexam&optCtrl=testName');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_QUESTIONS'), 'index.php?option=com_flexam&optCtrl=questionTest');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_ANSWERS'), 'index.php?option=com_flexam&optCtrl=answerTest');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_CONFIG'), 'index.php?option=com_flexam&optCtrl=mainFlCfg');

        break;

    case 'areaCourse' :
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_AREAS'), 'index.php?option=com_flexam&optCtrl=areaCourse', true );
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_SUBJECTS'), 'index.php?option=com_flexam&optCtrl=courseName');
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_TESTS'), 'index.php?option=com_flexam&optCtrl=testName');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_QUESTIONS'), 'index.php?option=com_flexam&optCtrl=questionTest');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_ANSWERS'), 'index.php?option=com_flexam&optCtrl=answerTest');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_CONFIG'), 'index.php?option=com_flexam&optCtrl=mainFlCfg');

        $controllerFileName = 'areaexam';
        break;

    case 'courseName':
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_AREAS'), 'index.php?option=com_flexam&optCtrl=areaCourse');
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_SUBJECTS'), 'index.php?option=com_flexam&optCtrl=courseName', true );
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_TESTS'), 'index.php?option=com_flexam&optCtrl=testName');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_QUESTIONS'), 'index.php?option=com_flexam&optCtrl=questionTest');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_ANSWERS'), 'index.php?option=com_flexam&optCtrl=answerTest');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_CONFIG'), 'index.php?option=com_flexam&optCtrl=mainFlCfg');

        $controllerFileName = 'subjexam';
        break;

    case 'testName':
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_AREAS'), 'index.php?option=com_flexam&optCtrl=areaCourse');
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_SUBJECTS'), 'index.php?option=com_flexam&optCtrl=courseName');
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_TESTS'), 'index.php?option=com_flexam&optCtrl=testName', true);
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_QUESTIONS'), 'index.php?option=com_flexam&optCtrl=questionTest');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_ANSWERS'), 'index.php?option=com_flexam&optCtrl=answerTest');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_CONFIG'), 'index.php?option=com_flexam&optCtrl=mainFlCfg');

        $controllerFileName = 'test';
        break;

    case 'questionTest':
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_AREAS'), 'index.php?option=com_flexam&optCtrl=areaCourse');
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_SUBJECTS'), 'index.php?option=com_flexam&optCtrl=courseName');
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_TESTS'), 'index.php?option=com_flexam&optCtrl=testName');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_QUESTIONS'), 'index.php?option=com_flexam&optCtrl=questionTest', true);
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_ANSWERS'), 'index.php?option=com_flexam&optCtrl=answerTest');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_CONFIG'), 'index.php?option=com_flexam&optCtrl=mainFlCfg');

        $controllerFileName = 'quest';
        break;

    case 'answerTest':
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_AREAS'), 'index.php?option=com_flexam&optCtrl=areaCourse');
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_SUBJECTS'), 'index.php?option=com_flexam&optCtrl=courseName');
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_TESTS'), 'index.php?option=com_flexam&optCtrl=testName');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_QUESTIONS'), 'index.php?option=com_flexam&optCtrl=questionTest');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_ANSWERS'), 'index.php?option=com_flexam&optCtrl=answerTest', true);
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_CONFIG'), 'index.php?option=com_flexam&optCtrl=mainFlCfg');

        $controllerFileName = 'answer';
        break;

    case 'mainFlCfg':
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_AREAS'), 'index.php?option=com_flexam&optCtrl=areaCourse');
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_SUBJECTS'), 'index.php?option=com_flexam&optCtrl=courseName');
	JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_TESTS'), 'index.php?option=com_flexam&optCtrl=testName');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_QUESTIONS'), 'index.php?option=com_flexam&optCtrl=questionTest');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_ANSWERS'), 'index.php?option=com_flexam&optCtrl=answerTest');
        JSubMenuHelper::addEntry(JText::_('FLEXAM_MENUADMIN_CONFIG'), 'index.php?option=com_flexam&optCtrl=mainFlCfg', true);

        $controllerFileName = 'cfg';
        break;
}

require_once( JPATH_COMPONENT.DS.'controllers'.DS.$controllerFileName.'.php' );
$controllerName = 'flExamController'.$controllerFileName;

// Create the controller
$controller = new $controllerName();

// Perform the Request task
$controller->execute($controllerFileName);

// Redirect if set by the controller
$controller->redirect();
?>