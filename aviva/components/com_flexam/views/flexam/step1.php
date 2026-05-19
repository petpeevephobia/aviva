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
if($this->areaExam) {
    foreach($this->areaExam as $clsEx) {
        if($clsEx->published > 0) {
            echo '<tr>
                                    <td width="95%" valign="top">
                                            <a href="#ch_test" title="'.JText::_( 'FLEXAM_GENERAL_INSTRUCTIONS' ).'">
                                            <h1><img alt="imgClassExam" src="'._IMGURL_PATH.'/components/'.basename(_IMGSERVER_PATH).'/images/thumb/'.$clsEx->img.'" border="0" style="margin-left: 5px; margin-right: 20px; vertical-align: middle;">
                                            '.$clsEx->areaName.'</h1>
                                            </a>
                                            <input type="hidden" name="deepLv" id="deepLv" value="2" />
                                            <hr />';

            if($this->subjects) {
                foreach($this->subjects as $sbj) {
                    echo '<ol style="padding-bottom:12px;" class="flexam_olList" name="ch_test">';
                    foreach($sbj as $ssbj) {
                        $availTest = $this->getElemFlExam->getExamTest($ssbj->idsubjects);

                        if($ssbj->idknowledgeArea == $clsEx->idknowledgeArea) {
                            echo "<li style=\"padding-bottom:7px;\"><a href=\"#ch_test\"onClick=\"javascript:showLayer('subject$ssbj->idsubjects');\"  title=\"".JText::_( 'FLEXAM_GENERAL_INSTRUCTIONS' )."\">$ssbj->subjects".'&nbsp;&nbsp;
                                        <img alt="showTest" src="'._IMGURL_PATH.'/components/'.basename(_IMGSERVER_PATH).'/images/subMenButton.png" style="vertical-align: middle;"></a>';

                            if($availTest) {
                                echo '<div id="subject'.$ssbj->idsubjects.'" style="padding-left:15px;display:none;"><ul class="flexam_ulList">';

                                foreach($availTest as $avTs) {
                                    echo "<li style=\"background-image: url("._IMGURL_PATH."/components/".basename(_IMGSERVER_PATH)."/images/vineta.png);\"><input id=\"chooseId\" name=\"chooseId\" type=\"radio\" value=\"$avTs->idtest\" onClick=\"javascript:submitFm('chooseTestFm')\" title=\"".JText::_( 'FLEXAM_TITLE_INSTRUCTIONS' )."\" />&nbsp;&nbsp;&nbsp;$avTs->nameTest</li>";
                                }

                                echo '</ul></div>';
                            }

                            echo "</li>";
                        }
                    }
                    echo "</ol>";
                }
            }

            echo '</td></tr>';
        }
    }
}
?>