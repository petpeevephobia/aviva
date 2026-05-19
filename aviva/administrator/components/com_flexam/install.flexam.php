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

function com_install() {
    $out = "<div class=\"message\">\n<img alter=\"\" src=\"components/com_flexam/style/FlexamIcon.png\" align=\"left\" style=\"vertical-align:top; padding-right:10px;\" />";
    $out .= "<p style=\"vertical-align:top; text-align: justify; width:90%;\"><b>Flexible Generator Tests</b>\ncomponent by APComputaci&oacute;n.cl is now installed!</p>\n";
    $out .= "<p style=\"vertical-align:top; text-align: justify; width:90%;\">Flexible Test Generator is a Joomla component created to make and manage all kinds of tests. This tool enables the area of knowledge, the subject or course, tests for each course associated with a percentage of difficulty and rating scale, the questions associated with a score and with the ability to attach images and files, and finally listing responses displayed in tabular form sorted by user and test.</p>";
    $out .= "<p style=\"vertical-align:top; text-align: justify; width:90%;\">For more information visit our website <a href=\"http://joomla.apcomputacion.cl\">APComputacion.cl</a> or send an email to the address <a href=\"mailto:ventas@apcomputacion.cl\">ventas@apcomputacion.cl</a></p></div>";

    echo $out;
}
?>