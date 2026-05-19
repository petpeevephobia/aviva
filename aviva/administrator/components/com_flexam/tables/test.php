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

defined('_JEXEC') or die('Restricted access');

class TableTest extends JTable{
	var $idtest     		= null;
	var $idsubjects                 = null;
	var $nameTest   		= null;
	var $dificulty         		= null;
        var $published         		= null;
        var $checked_out       		= null;
        var $dateTest       		= null;
        var $aprobeScore       		= null;
        var $minScore       		= null;
        var $maxScore       		= null;

	function __construct(&$db){
		parent::__construct('#__flexam_test', 'idtest', $db );
	}
}
?>