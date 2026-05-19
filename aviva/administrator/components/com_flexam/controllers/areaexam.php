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
jimport('joomla.client.helper');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * @package		Joomla
 * @subpackage	Config
 */
class flExamControllerAreaexam extends JController {
    /**
     * Custom Constructor
     */
    function __construct( $default = array()){
        parent::__construct( $default );

        $this->registerTask( 'unpublish',   'publish');
        $this->registerTask( 'preview',     'display');
        $this->registerTask( 'edit',        'display');
        $this->registerTask( 'add' ,        'display' );

    }

    function display( ){
        $actEvt = JRequest::getVar('task');
        
        switch($actEvt){
            case 'add'     :
            {
                    JRequest::setVar( 'hidemainmenu', 1 );
                    JRequest::setVar( 'layout', 'form'  );
                    JRequest::setVar( 'view', 'flexam'  );
                    JRequest::setVar( 'edit', false  );
            } break;
            case 'edit'    :
            {
                    JRequest::setVar( 'hidemainmenu', 1 );
                    JRequest::setVar( 'layout', 'form'  );
                    JRequest::setVar( 'view', 'flexam'  );
                    JRequest::setVar( 'edit', true  );
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
                JRequest::setVar('view', 'flexam');
        };

        parent::display();
    }

    function save(){
        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $db =& JFactory::getDBO();

        // save the poll parent information
        $row	=& JTable::getInstance('knowledgeAreas', 'Table');
        $post	= JRequest::get( 'post' );

        if (!$row->bind( $post )){
            JError::raiseError(500, $row->getError() );
        }

        $isNew = ($row->idknowledgeArea == 0);

        if (!$row->check()){
            JError::raiseError(500, $row->getError() );
        }

        if($this->existArea($row->areaName)){
            // save the File
            $row->img = $this->upload();


            if (!$row->store()){
                JError::raiseError(500, $row->getError() );
            }

            $row->checkin();

            switch ($this->_task){
                case 'save':
                default:
                    $msg = JText::_( 'Saved' );
                    $link = 'index.php?option=com_flexam';
                    break;
            }

            //$this->setRedirect($link);
        }else{
            JError::raiseNotice(100, 'Error. '.JText::_('FLEXAM_CATEGORIES_ERROR_NAME'));
        }
    }

    function update(){
        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $db         =& JFactory::getDBO();
        $cid        = JRequest::getVar('cid');
        $newfile    = JRequest::getVar( 'img', '', 'files', 'array' );
        $post       = JRequest::get( 'post' );

        $obj = new stdClass();

        if(!empty($newfile["name"])){
            $this->delImg($cid);

            $obj->name              = $post["areaName"];
            $obj->pub               = $post["published"];
            $obj->img               = $this->upload();

            $qry = "UPDATE #__flexam_knowledgeAreas SET " .
                    "areaName='$obj->name', published='$obj->pub', img='$obj->img' WHERE idknowledgeArea='$cid'";

            $db->setQuery($qry);
            $db->query();
        }else{
            $obj->name              = $post["areaName"];
            $obj->pub               = $post["published"];
            $obj->img               = $post["oldImg"];

            $qry = "UPDATE #__flexam_knowledgeAreas SET " .
                    "areaName='$obj->name', published='$obj->pub', img='$obj->img' WHERE idknowledgeArea='$cid'";

            $db->setQuery($qry);
            $db->query();
        }

        $this->setRedirect( 'index.php?option=com_flexam&view=flexam&optCtrl=areaCourse' );
    }

    function remove(){
            // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $db	=& JFactory::getDBO();
        $cid	= JRequest::getVar( 'cid', array(), '', 'array' );

        JArrayHelper::toInteger($cid);
        $msg = '';

        for ($i = 0, $n = count($cid); $i < $n; $i++){
            $area =& JTable::getInstance('knowledgeAreas', 'Table');

            $this->delImg($cid[$i]);

            if (!$area->delete( $cid[$i] )){
                $msg .= $area->getError();
            }
        }

        $this->setRedirect( 'index.php?option=com_flexam&view=flexam&optCtrl=areaCourse', $msg );
    }

    /**
    * Publishes or Unpublishes one or more records
    * @param array An array of unique category id numbers
    * @param integer 0 if unpublishing, 1 if publishing
    * @param string The current url option
    */
    function publish($state) {
        global $mainframe;

        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $db 	=& JFactory::getDBO();
        $user 	=& JFactory::getUser();

        $cid		= JRequest::getVar( 'cid', array(), '', 'array' );
        $publish	= ( $state == 'publish' ? 1 : 0 );

        JArrayHelper::toInteger($cid);

        if (count( $cid ) < 1){
                $action = $publish ? 'publish' : 'unpublish';
                JError::raiseError(500, JText::_( 'Select an item to' .$action, true ) );
        }

        $cids = implode( ',', $cid );

        $query = 'UPDATE #__flexam_knowledgeAreas'
        . ' SET published = ' . (int) $publish
        . ' WHERE idknowledgeArea IN ( '. $cids .' )';
        
        $db->setQuery( $query );

        if (!$db->query()){
                JError::raiseError(500, $db->getErrorMsg() );
        }

        if (count( $cid ) == 1){
                $row =& JTable::getInstance('knowledgeareas', 'Table');
                $row->checkin( $cid[0] );
        }
        
        $mainframe->redirect( 'index.php?option=com_flexam&view=flexam&optCtrl=areaCourse' );
    }

    function cancel(){
        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $id		= JRequest::getVar( 'id', 0, '', 'int' );
        $db		=& JFactory::getDBO();
        $row            =& JTable::getInstance('knowledgeareas', 'Table');

        $row->checkin( $id );
        $this->setRedirect( 'index.php?option=com_flexam&view=flexam&optCtrl=areaCourse' );
    }

    function upload(){
        global $mainframe;

        // Check for request forgeries
        JRequest::checkToken( 'request' ) or jexit( 'Invalid Token' );

        $file 	= JRequest::getVar( 'img', '', 'files', 'array' );
        $err	= null;

        $path	= JPATH_SITE.DS.'components'.DS.'com_flexam'.DS.'images'.DS.'thumb';// we use viewback to get right path

        if($file['size'] <= '18500'){

            // Make the filename safe
            if (isset($file['name'])) {
                $file['name']	= JFile::makeSafe($file['name']);
            }


        // All HTTP header will be overwritten with js message
            if (isset($file['name'])) {
                $filepath = $path.DS.strtolower($file['name']);

                if (JFile::exists($filepath)) {
                    JError::raiseNotice(100, 'Error. '.JText::_('FLEXAM_ERROR_FILENAME'));
                    // REDIRECT
                    return 'writing.png';
                }

                if (!JFile::upload($file['tmp_name'], $filepath)) {
                    JError::raiseWarning(100, 'Error. '.JText::_('FLEXAM_ERROR_UPLOADFILE'));
                    // REDIRECT
                    return 'writing.png';
                } else {
                    $mainframe->enqueueMessage(JText::_('FLEXAM_FILE_OKUPLOAD'));
                    // REDIRECT
                    return strtolower($file['name']);
                }
            } else {
                return 'writing.png';
            }
        }else{
            echo "<script>alert(".  JText::_('FLEXAM_FILE_MAXSIZE').");</script>";

            return 'writing.png';
        }
    }

    function delImg($idArea){
        // Check for request forgeries
        JRequest::checkToken( 'request' ) or jexit( 'Invalid Token' );

        $db	=& JFactory::getDBO();

        $query = "SELECT img FROM #__flexam_knowledgeAreas WHERE idknowledgeArea='$idArea'";

	$db->setQuery( $query );
	$file = $db->loadResult();

        $filepath = JPATH_SITE.DS.'components'.DS.'com_flexam'.DS.'images'.DS.'thumb'.DS.$file;
        
        if($file && $file != 'writing.png'){
            if (JFile::exists($filepath)) {
                JFile::delete($filepath);
                return true;
            }
        }
    }

    function existArea($nameArea){
        // Check for request forgeries
        JRequest::checkToken( 'request' ) or jexit( 'Invalid Token' );
        
        $db	=& JFactory::getDBO();

        $query = "SELECT idknowledgeArea FROM #__flexam_knowledgeAreas WHERE areaName='$nameArea'";

	$db->setQuery( $query );
	$name = $db->loadResult();

        return (empty($name)) ? true : false;
    }
}