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
defined('_JEXEC') or die('Restricted access');
jimport('joomla.session.session');
$session =& JFactory::getSession();
$level = JRequest::getVar('deepLev', '', 'post');
$user = JFactory::getUser();
$id = $user->get('id');

if(empty($id)){
    $id = $this->getDumUser ();

    if((int)$level < 1){
        echo "<script>alert('".  JText::_('FELXAM_WARNING_REVIEW_DONE')."');</script>";
    }
}

$idTest = JRequest::getVar('chooseId', '', 'post');
$filePath = _IMGURL_PATH.DS.'components/com_flexam/tmpFiles/';
$imgPath = _IMGURL_PATH.DS.'components/com_flexam/images/questionImg/';
$icoPath = _IMGURL_PATH.DS.'components/com_flexam/images/';
?>
<div id="editcell">
    <div id="titleFlExamUser"><?php echo (defined('_FLEXAM_NAME_COM')) ?  _FLEXAM_NAME_COM : JText::_( 'FLEXAM_FEUSER_TITLE' ); ?></div>
    <form name="showAnswersFm" id="showAnswersFm" action="index.php?option=com_flexam&view=flanswer" method="post">
        <table class="answerlist" cellpadding="0" cellspacing="1" border="0">
<?php
switch ($level){
    default:
        include(_IMGSERVER_PATH.DS."views".DS."flanswer".DS."chooseTest.php");
        break;

    case '1':
        include(_IMGSERVER_PATH.DS."views".DS."flanswer".DS."showResult.php");
        break;
}
?>
        </table>
    </form>
</div>
<div id="footFlExamUser"><?php echo JText::_('FLEXAM_COPYRIGHTS') ?></div>