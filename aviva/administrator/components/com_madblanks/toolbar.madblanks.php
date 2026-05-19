<?php
/**
 * Mad Blanks; a component for Joomla!
 * Copyright (C) 2006, 2007, 2008, 2009, 2010, 2011 Chris Hallett
 *
 * Use this component to write out text with blanks in it, and have
 * your website users fill in those blanks (or fill them in
 * yourself). Uses include creating custom word games, displaying
 * quotations, keeping a catalog of descriptions, and administering
 * quizzes with freeform responses. For detailed documentation,
 * see <http://www.madblanks.org/>.
 *
 * This file is part of Mad Blanks.
 *
 * Mad Blanks is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * Mad Blanks is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Mad Blanks; if not, see <http://www.gnu.org/licenses/>.
 * 
 * This file contains calls to the TOOLBAR_MadBlanksRecord class to display 
 * buttons in the upper right administration area of the backend.
 *
 * file version 1.2.0 20100106
 *
 * @package Mad_Blanks_Component
 * @author Chris Hallett <chris@madblanks.org>
 * @copyright Chris Hallett March 1, 2011
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 
 * @version 1.4.2
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * Require the toolbar html file
 */
require_once( $mainframe->getPath( 'toolbar_html' ) );

/**
 * Require the component class and support function file
 */
require_once( $mainframe->getPath( 'class' ) );


$TOOLBAR_MadBlanksRecord = new TOOLBAR_MadBlanksRecord();

switch ($task) {
// Categories section

	case "listcategories" :
		$TOOLBAR_MadBlanksRecord->listMadBlanksCategories();
		break;
		
	case "newcategory" :
		$TOOLBAR_MadBlanksRecord->editMadBlanksCategory();
		break;
	
	case "editcategory" :
		$TOOLBAR_MadBlanksRecord->editMadBlanksCategory();
		break;
		
	case "applycategory" :
		$TOOLBAR_MadBlanksRecord->editMadBlanksCategory();
		break;
	
	case "savecategory" :
		$TOOLBAR_MadBlanksRecord->editMadBlanksCategory();
		break;
	
	case "copycategory" :	
		break;
		
// Edit section

	case "saverecord" :
		$TOOLBAR_MadBlanksRecord->saveMadBlanksRecord();
		break;
	
	case "newrecord" :
		$TOOLBAR_MadBlanksRecord->newMadBlanksRecord();
		break;
	
	case "editrecord" :
		$TOOLBAR_MadBlanksRecord->editMadBlanksRecord();
		break;
		
	case "copyrecord" :	
		break;
	
	case "deleterecords" :
		break;

	case "publishrecord" :
		break;

	case "unpublishrecord" :
		break;

	case "listrecords" :
		$TOOLBAR_MadBlanksRecord->listMadBlanksRecords();
		break;
		
// Master configuration section

	case "editconfiguration" :
		$TOOLBAR_MadBlanksRecord->editMadBlanksConfiguration();
		break;
		
	case "saveconfiguration" :
		break;
		
// ScoreScripts section

	case "listscorescripts" :
		$TOOLBAR_MadBlanksRecord->listMadBlanksScoreScripts();
		break;
		
	case "newscorescript" :
		$TOOLBAR_MadBlanksRecord->editMadBlanksScoreScript();
		break;
	
	case "editscorescript" :
		$TOOLBAR_MadBlanksRecord->editMadBlanksScoreScript();
		break;
		
	case "applyscorescript" :
		$TOOLBAR_MadBlanksRecord->editMadBlanksScoreScript();
		break;
	
	case "savescorescript" :
		$TOOLBAR_MadBlanksRecord->editMadBlanksScoreScript();
		break;
	
	case "copyscorescript" :	
		break;

// Default section

	default:
		$TOOLBAR_MadBlanksRecord->MadBlanksDefaultToolbar();
		break;

} // end switch
?>
