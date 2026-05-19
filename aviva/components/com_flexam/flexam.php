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
defined('_JEXEC') or die('Restricted access');
include ('sservconn.php');
error_reporting(0);
// Set the table directory
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.$option.DS.'tables');

$mosConfig_absolute_path 	= JPATH_SITE;
$mosConfig_live_site 		= $mainframe->isAdmin() ? $mainframe->getSiteURL() : JURI::base();

if(substr($mosConfig_live_site, -1)=="/") $mosConfig_live_site = substr($mosConfig_live_site, 0, -1);
// INCLUDE LANGUAGE FILES

$sectionFlexam = JRequest::getVar('view');
$totalQuestions = JRequest::getVar('totalQuestions', '', 'post');
$sesstart = JRequest::getVar('sesstart');
$extAccess = new managementUser();

$dtServerCfg = $extAccess->talkingServer();

if(!empty($dtServerCfg[2]->value)){
    define("_FLEXAM_SERVERTRUE", 1);
    define("_FLEXAM_STACKMODE", $dtServerCfg[0]->value);
    define("_FLEXAM_NAME_COM", $dtServerCfg[1]->value);
    define("_FLEXAM_SERVERREQ", $dtServerCfg[2]->value);
    define("_FLEXAM_SERVEROUT", $dtServerCfg[3]->value);
    define("_FLEXAM_SERVERTIMEOUT", $dtServerCfg[4]->value);
    define("_FLEXAM_SERVEROUTMAIL", $dtServerCfg[5]->value);
}

if(isset($sesstart)){
    $curID  = JRequest::getVar('curId');
    $usNAME = JRequest::getVar('usName');
    $usMAIL = JRequest::getVar('usMail');
    $curCode = JRequest::getVar('rqCode');

    $extAccess = new managementUser();
    $credentials = $extAccess->checkRegisterUser(array($usMAIL, $usNAME, $curID, $curCode));

    $result = $mainframe->login($credentials);
}

if($sectionFlexam == 'flanswer'){
// Require specific controller if requested
    require_once( JPATH_COMPONENT.DS.'controllers'.DS.'answers.php' );
// Create the controller
    $classname	= 'flexamControllerAnswer';
    $controller = new $classname( );

    $controllerObj = get_object_vars($controller);

    define("_IMGSERVER_PATH",$controllerObj["_basePath"]);
    define("_IMGURL_PATH",$mosConfig_live_site);
    // Register Extra tasks
    $controller->registerTask( 'results', 'display' );
    // Perform the Request task
    $controller->execute(JRequest::getCmd('task'));
    // Redirect if set by the controller
    $controller->redirect();
}else{
// Require specific controller if requested
    require_once( JPATH_COMPONENT.DS.'controllers'.DS.'controller.php' );
// Create the controller
    $classname	= 'flexamController'.$controller;
    $controller = new $classname( );

    $controllerObj = get_object_vars($controller);

    define("_IMGSERVER_PATH",$controllerObj["_basePath"]);
    define("_IMGURL_PATH",$mosConfig_live_site);
    // Register Extra tasks
    $controller->registerTask( 'results', 'display' );
    // Perform the Request task
    $controller->execute(JRequest::getCmd('task'));
    // Redirect if set by the controller
    $controller->redirect();
}
?>