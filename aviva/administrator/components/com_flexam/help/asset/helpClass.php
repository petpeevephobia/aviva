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
class doHelp {

    private $lang;
    private $fileLang;
    private $fileLangDefault = '../language/es-ES.com_flexam.ini';

    public function __construct() {
        $codeLang = str_replace( strstr($_SERVER['HTTP_ACCEPT_LANGUAGE'], ','), '', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $this->lang = str_replace(strstr($codeLang,'-'), strtoupper(strstr($codeLang,'-')), $codeLang);
        $this->fileLang = '../language/' . $this->lang . '.com_flexam.ini';
    }

    private function setLanguage($fLng) {
        $toVar = NULL;
        $stream = fopen($this->fileLang, "rb");

        $content = fread($stream, filesize($this->fileLang));
        fclose($stream);

        $contentArray = explode('<br />', nl2br(str_replace("\n", '&', $content)));

        for ($i = 0; $i < 12; $i++) {
            array_shift($contentArray);
        }

        foreach ($contentArray as $cA) {
            $toVar .= str_replace($cA[0], '', $cA);
        }

        $toVar = 'done=OK' . $toVar;

        parse_str($toVar, $out);

        $keys = array_keys($out);

        foreach ($keys as $key) {
            define($key, $out[$key]);
        }
    }

    public function GetLanguage() {
        if (file_exists($this->fileLang)) {
            $this->setLanguage ($this->fileLang);
        } else {
            $this->setLanguage ($this->fileLangDefault);
        }
    }

}
?>