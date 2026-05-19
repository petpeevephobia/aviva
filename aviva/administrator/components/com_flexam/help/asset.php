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

require_once ('asset/helpClass.php');
extract($_POST);
$hlp = new doHelp();
$hlp->GetLanguage();

switch ($page) {
    case 'main':
        include_once ('asset/pages/areasHelp.php');
        break;

    case 'subj':
        include_once ('asset/pages/subjectHelp.php');
        break;

    case 'test':
        include_once ('asset/pages/testHelp.php');
        break;

    case 'quest':
        include_once ('asset/pages/questionHelp.php');
        break;

    case 'answ':
        include_once ('asset/pages/answersHelp.php');
        break;

    case 'cfg':
        include_once ('asset/pages/configHelp.php');
        break;
}
?>