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
 * This file contains calls to display buttons in the upper right 
 * administration area of the backend.
 * 
 * file version 1.4.0 20100106
 *
 * @package Mad_Blanks_Component
 * @author Chris Hallett <chris@madblanks.org>
 * @copyright Chris Hallett March 1, 2011
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 
 * @version 1.4.2
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * @package Mad_Blanks_Component
 */
class TOOLBAR_MadBlanksRecord {

	function MadBlanksDefaultToolbar() {
	$mosMenuBar = new JToolBarHelper();
		
	JToolBarHelper::title('Mad Blanks', 'logo');
	$mosMenuBar->preferences('com_madblanks', '500', '700');
	
	}
	
	function editMadBlanksCategory() {
	$mosMenuBar = new JToolBarHelper();
	
	JToolBarHelper::title('Mad Blanks', 'logo');
	$mosMenuBar->apply('applycategory',_MBL_APPLY);
	$mosMenuBar->save('savecategory', _MBL_SAVE);
	$mosMenuBar->custom('canceleditcategory', 'cancel.png', 'cancel_f2.png', _MBL_CANCEL, false);
		
	}
	function listMadBlanksRecords() {
	$mosMenuBar = new JToolBarHelper();
	
	JToolBarHelper::title('Mad Blanks', 'logo');
	$mosMenuBar->custom('completerecord', 'apply.png', 'apply_f2.png', _MBL_COMPLETE, false);
	$mosMenuBar->custom('uncompleterecord', 'unpublish.png', 'unpublish_f2.png', _MBL_UNCOMPLETE, false);
	$mosMenuBar->custom('approverecord', 'apply.png', 'apply_f2.png', _MBL_APPROVE, false);
	$mosMenuBar->custom('unapproverecord', 'unpublish.png', 'unpublish_f2.png', _MBL_UNAPPROVE, false);
	$mosMenuBar->divider();
	$mosMenuBar->publish('publishrecord');
	$mosMenuBar->unpublish('unpublishrecord');
	$mosMenuBar->divider();
	$mosMenuBar->addNew('newrecord', _MBL_NEW);
	$mosMenuBar->editListX('editrecord', _MBL_EDIT);
	$mosMenuBar->custom('copyrecord', 'copy.png', 'copy_f2.png', _MBL_COPY, false);
	$mosMenuBar->deleteList(class_exists('JConfig') ? 'Are you sure you want to delete the selected items?' : ' ', 'deleterecords', _MBL_DELETE);
	$mosMenuBar->divider();
	$mosMenuBar->preferences('com_madblanks', '500', '700');
	
	}
	function listMadBlanksCategories() {
	$mosMenuBar = new JToolBarHelper();
	
	JToolBarHelper::title('Mad Blanks', 'logo');
	$mosMenuBar->publish('publishcategories');
	$mosMenuBar->unpublish('unpublishcategories');
	$mosMenuBar->divider();
	$mosMenuBar->addNew('newcategory', _MBL_NEW);
	$mosMenuBar->editListX('editcategory', _MBL_EDIT);
	$mosMenuBar->custom('copycategory', 'copy.png', 'copy_f2.png', _MBL_COPY, false);
	// load default delete button if using Joomla 1.5, else use the custom JavaScript enhanced version for Joomla 1.0
	if (class_exists('JConfig')) { // check for presence of Joomla 1.5 configuration class
		$mosMenuBar->deleteList('Are you sure you want to delete this category? Any records left in this category will be orphaned.', 'deletecategories', _MBL_DELETE);
	}
	else {
		MadBlanksDeleteCategoryList(' ', 'deletecategories', _MBL_DELETE);
	}	
	$mosMenuBar->divider();
	$mosMenuBar->preferences('com_madblanks', '500', '700');
	
	}
	function editMadBlanksRecord() {
	$mosMenuBar = new JToolBarHelper();
	
	JToolBarHelper::title('Mad Blanks', 'logo');
	$mosMenuBar->customX('saverecord', 'save.png', 'save_f2.png', _MBL_SAVE, false);
	$mosMenuBar->custom('canceleditrecord', 'cancel.png', 'cancel_f2.png', _MBL_CANCEL, false);
 	
	}
	function newMadBlanksRecord() {
	$mosMenuBar = new JToolBarHelper();
	
	JToolBarHelper::title('Mad Blanks', 'logo');
	$mosMenuBar->custom('listrecords', 'cancel.png', 'cancel_f2.png', _MBL_CANCEL, false);
	
	}
	function editMadBlanksConfiguration() {
	$mosMenuBar = new JToolBarHelper();
	
	JToolBarHelper::title('Mad Blanks', 'logo');
	$mosMenuBar->apply('applyconfiguration',_MBL_APPLY);
	$mosMenuBar->save('saveconfiguration',_MBL_SAVE);
	$mosMenuBar->custom('', 'cancel.png', 'cancel_f2.png', _MBL_CANCEL, false);
	
	}
	function saveMadBlanksRecord() {
	$mosMenuBar = new JToolBarHelper();
	
	JToolBarHelper::title('Mad Blanks', 'logo');
	$mosMenuBar->save('saverecordafterpreview', _MBL_SAVE);
	$mosMenuBar->customX('editrecord', 'edit.png', 'edit_f2.png', _MBL_EDIT, false);
	$mosMenuBar->custom('canceleditrecord', 'cancel.png', 'cancel_f2.png', _MBL_CANCEL, false);
	
	}
	
	// ScoreScripts section:

	function editMadBlanksScoreScript() {
	$mosMenuBar = new JToolBarHelper();
	
	JToolBarHelper::title('Mad Blanks', 'logo');
	$mosMenuBar->apply('applyscorescript',_MBL_APPLY);
	$mosMenuBar->save('savescorescript', _MBL_SAVE);
	$mosMenuBar->custom('canceleditscorescript', 'cancel.png', 'cancel_f2.png', _MBL_CANCEL, false);
		
	}

	function listMadBlanksScoreScripts() {
	$mosMenuBar = new JToolBarHelper();
	
	JToolBarHelper::title('Mad Blanks', 'logo');
	$mosMenuBar->publish('publishscorescripts');
	$mosMenuBar->unpublish('unpublishscorescripts');
	$mosMenuBar->divider();
	$mosMenuBar->addNew('newscorescript', _MBL_NEW);
	$mosMenuBar->editListX('editscorescript', _MBL_EDIT);
	$mosMenuBar->custom('copyscorescript', 'copy.png', 'copy_f2.png', _MBL_COPY, false);
	// load default delete button if using Joomla 1.5, else use the custom JavaScript enhanced version for Joomla 1.0
	//if (class_exists('JConfig')) { // check for presence of Joomla 1.5 configuration class
		$mosMenuBar->deleteList('Are you sure you want to delete the selected items?', 'deletescorescripts', _MBL_DELETE);
	//}
	//else {
	//	MadBlanksDeleteScoreScriptList(' ', 'deletescorescripts', _MBL_DELETE);
	//}	
	$mosMenuBar->divider();
	$mosMenuBar->preferences('com_madblanks', '500', '700');
	
	}
	
} // end class TOOLBAR_MadBlanksRecord
?>
