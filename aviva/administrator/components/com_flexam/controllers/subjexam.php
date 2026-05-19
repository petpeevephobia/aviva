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

jimport( 'joomla.application.component.controller' );

/**
 * @package		Joomla
 * @subpackage	Config
 */
class flExamControllerSubjexam extends JController {
	/**
	 * Custom Constructor
	 */
    function __construct( $default = array()){
        parent::__construct( $default );

        $this->registerTask( 'unpublish', 	'publish');
        $this->registerTask( 'preview', 	'display');
        $this->registerTask( 'edit', 	'display');
        $this->registerTask( 'add' , 	'display' );

    }

    function display( ){
        $actEvt = JRequest::getVar('task');
            //var_dump($_POST);
        switch($actEvt) {
            case 'add'     :
            {
                    JRequest::setVar( 'hidemainmenu', 1 );
                    JRequest::setVar( 'layout', 'form'  );
                    JRequest::setVar( 'view', 'subject'  );
                    JRequest::setVar( 'edit', false  );
            } break;
            case 'edit'    :
            {
                    JRequest::setVar( 'hidemainmenu', 1 );
                    JRequest::setVar( 'layout', 'form'  );
                    JRequest::setVar( 'view', 'subject'  );
                    JRequest::setVar( 'edit', true  );
            } break;

            case 'preview' :
            {
                    JRequest::setVar( 'tmpl', 'component' );
                    JRequest::setVar( 'view', 'subject'  );
            } break;
        }


        if($actEvt === 'publish' || $actEvt === 'unpublish'){
            $this->publish($actEvt);
        }

        if($actEvt === 'save'){
            $this->save();
        }

        if($actEvt === 'update'){
            $this->update();
        }

        if($actEvt === 'remove'){
            $this->remove();
        }

        //Set the default view, just in case
        $view = JRequest::getCmd('view');
        
        if(empty($view)) {
                JRequest::setVar('view', 'subject');
        };

        parent::display();
    }

    function save() {
        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $db =& JFactory::getDBO();

        // save the poll parent information
        $row	=& JTable::getInstance('subjects', 'Table');
        $post	= JRequest::get( 'post' );

        if (!$row->bind( $post )){
                JError::raiseError(500, $row->getError() );
        }

        if (!$row->check()){
                JError::raiseError(500, $row->getError() );
        }

        if (!$row->store()){
                JError::raiseError(500, $row->getError() );
        }

        $row->checkin();
        // save the poll options
        switch ($this->_task){
                case 'save':
                default:
                        $msg = JText::_( 'Saved' );
                        $link = 'index.php?option=com_flexam&optCtrl=courseName';
                        break;
        }

        $this->setRedirect($link);
    }

    function update(){
        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $db         =& JFactory::getDBO();
        $cid        = JRequest::getVar('cid');
        $post       = JRequest::get( 'post' );
        
        $obj = new stdClass();

        $obj->sbjct  = $post["subjects"];
        $obj->code    = $post["codeknowledgeArea"];
        $obj->idkA   = $post["idknowledgeArea"];
        $obj->pub    = $post["published"];
        $obj->tSub    = $post["idTypeSubject"];
        $obj->mailM    = $post["mailManager"];

        $qry = "UPDATE #__flexam_subjects SET " .
                "code='$obj->code', subjects='$obj->sbjct', published='$obj->pub', idknowledgeArea='$obj->idkA', " .
                "idTypeSubject='$obj->tSub', mailManager='$obj->mailM' WHERE idsubjects='$cid'";

        $db->setQuery($qry);
        $db->query();

        $this->setRedirect( 'index.php?option=com_flexam&optCtrl=courseName' );
    }

    function remove(){
        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $db	=& JFactory::getDBO();
        $cid	= JRequest::getVar( 'cid', array(), '', 'array' );

        JArrayHelper::toInteger($cid);
        $msg = '';

        for ($i = 0, $n = count($cid); $i < $n; $i++) {
            $subjValTabDel =& JTable::getInstance('subjects', 'Table');

            if (!$subjValTabDel->delete( $cid[$i] )) {
                    $msg .= $subj->getError();
            }
        }

        $this->setRedirect( 'index.php?option=com_flexam&optCtrl=courseName', $msg );
    }

	/**
	* Publishes or Unpublishes one or more records
	* @param array An array of unique category id numbers
	* @param integer 0 if unpublishing, 1 if publishing
	* @param string The current url option
	*/
    function publish($state){
        global $mainframe;

        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $db 	=& JFactory::getDBO();
        $user 	=& JFactory::getUser();

        $cid		= JRequest::getVar( 'cid', array(), '', 'array' );
        $publish	= ( $state == 'publish' ? 1 : 0 );

        JArrayHelper::toInteger($cid);

        if (count( $cid ) < 1) {
                $action = $publish ? 'publish' : 'unpublish';
                JError::raiseError(500, JText::_( 'Select an item to' .$action, true ) );
        }

        $cids = implode( ',', $cid );

        $query = 'UPDATE #__flexam_subjects'
        . ' SET published = ' . (int) $publish
        . ' WHERE idsubjects IN ( '. $cids .' )';

        $db->setQuery( $query );

        if (!$db->query()) {
                JError::raiseError(500, $db->getErrorMsg() );
        }

        if (count( $cid ) == 1) {
                $row =& JTable::getInstance('subjects', 'Table');
                $row->checkin( $cid[0] );
        }
        
        $mainframe->redirect( 'index.php?option=com_flexam&optCtrl=courseName' );
    }

    function cancel(){
        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $id		= JRequest::getVar( 'id', 0, '', 'int' );
        $db		=& JFactory::getDBO();
        $row            =& JTable::getInstance('subjects', 'Table');

        $row->checkin( $id );
        $this->setRedirect( 'index.php?option=com_flexam&optCtrl=courseName' );
    }
}