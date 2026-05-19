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

class managementUser {
    private $db;

    public function __construct(){
        $this->db =& JFactory::getDBO();
    }

    public function talkingServer (){
        $query = "SELECT * FROM #__flexam_connconfig";
        $this->db->setQuery( $query );
        $server = $this->db->loadObjectList();

        return $server;
    }

    public function checkRegisterUser($params){
        $userFL = NULL;
        $idTest = NULL;

        $query = "SELECT username FROM #__users WHERE email='$params[0]'";
        $this->db->setQuery( $query );
        $userNAME = $this->db->loadResult();
        
        if(empty($userNAME)){
            $query = 'SELECT MAX(id) + 1'
            . ' FROM #__users';

            $this->db->setQuery( $query );
            $idUser = $this->db->loadResult();

            $tmpName = explode(' ',$params[1]);
            $userNAME = substr($tmpName[0], 0, 3).substr($tmpName[1], 0, 3).$idUser;

            $query = 'SELECT MAX(id) + 1'
            . ' FROM #__core_acl_aro';

            $this->db->setQuery( $query );
            $idCore = $this->db->loadResult();

            $query = "INSERT INTO #__users (id, name, username, email, password, usertype, block, sendEmail, gid, registerDate, lastvisitDate, activation, params) VALUES ('$idUser', '$params[1]', '$userNAME', '$params[0]', '95dd08505665c92549914d6e61fcb986:MnWBl2kUVQsEvcZkE88JAsKe7CTM4JRY', 'Registered', '0', '1', '18', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', '', '')";
            $this->db->setQuery( $query );
            $this->db->query();

            $query = "INSERT INTO #__core_acl_aro (id, section_value, value, order_value, name, hidden) VALUES ('$idCore', 'users', '$idUser', '0', '$userNAME', '0')";
            $this->db->setQuery( $query );
            $this->db->query();

            $query = "INSERT INTO #__core_acl_groups_aro_map (group_id, section_value, aro_id) VALUES ('18', '', '$idCore')";
            $this->db->setQuery( $query );
            $this->db->query();
            
            $query = "SELECT IF((SELECT idtest FROM #__flexam_testDone_state WHERE numApply='$params[3]' AND idUser='$idUser' AND idState < 3) IS NULL, " .
                "(SELECT MIN(a.idtest) AS id, b.code FROM #__flexam_test AS a " .
                "INNER JOIN #__flexam_subjects AS b ON a.idsubjects = b.idsubjects " .
                "WHERE (a.idtest NOT IN (SELECT x.idtest FROM #__flexam_testDone_state AS x WHERE x.numApply='$params[3]' AND idUser='$idUser' AND idState < 3)) " .
                "GROUP BY b.idsubjects, b.code " .
                "HAVING b.code='$params[2]), NULL) AS id";

            $this->db->setQuery( $query );
            $idTest = $this->db->loadResult();

            if(empty($idTest)){
                $query = "SELECT MIN(a.idtest) AS id, b.code FROM #__flexam_test AS a " .
                    "INNER JOIN #__flexam_subjects AS b ON a.idsubjects = b.idsubjects " .
                    "WHERE (a.idtest NOT IN (SELECT x.idtest FROM #__flexam_testDone_state AS x WHERE x.numApply='$params[3]' AND idUser='$idUser' AND idState < 3)) " .
                    "GROUP BY b.idsubjects, b.code " .
                    "HAVING b.code='$params[2]'";

                $this->db->setQuery( $query );
                $idTest = $this->db->loadResult();
            }

            $query = "INSERT INTO #__flexam_testDone_state (idtest, idUser, numApply, idState) " .
                    "VALUES ('$idTest', '$idUser', '$params[3]', '3')";

            $this->db->setQuery( $query );
            $this->db->query();

            $userFL = $userNAME;
        }else{
            $query = "SELECT id FROM #__users WHERE email='$params[0]'";
            $this->db->setQuery( $query );
            $idUser = $this->db->loadResult();

            $query = "SELECT IF((SELECT idtest FROM #__flexam_testDone_state WHERE numApply='$params[3]' AND idUser='$idUser' AND idState < 3) IS NULL, " .
                "(SELECT MIN(a.idtest) AS id, b.code FROM #__flexam_test AS a " .
                "INNER JOIN #__flexam_subjects AS b ON a.idsubjects = b.idsubjects " .
                "WHERE (a.idtest NOT IN (SELECT x.idtest FROM #__flexam_testDone_state AS x WHERE x.numApply='$params[3]' AND idUser='$idUser' AND idState < 3)) " .
                "GROUP BY b.idsubjects, b.code " .
                "HAVING b.code='$params[2]), NULL) AS id";
            
            $this->db->setQuery( $query );
            $idTest = $this->db->loadResult();
            
            if(empty($idTest)){
                $query = "SELECT MIN(a.idtest) AS id, b.code FROM #__flexam_test AS a " .
                    "INNER JOIN #__flexam_subjects AS b ON a.idsubjects = b.idsubjects " .
                    "WHERE (a.idtest NOT IN (SELECT x.idtest FROM #__flexam_testDone_state AS x WHERE x.numApply='$params[3]' AND idUser='$idUser' AND idState < 3)) " .
                    "GROUP BY b.idsubjects, b.code " .
                    "HAVING b.code='$params[2]'";

                $this->db->setQuery( $query );
                $idTest = $this->db->loadResult();

                $query = "INSERT INTO #__flexam_testDone_state (idtest, idUser, numApply, idState) " .
                    "VALUES ('$idTest', '$idUser', '$params[3]', '3')";

                $this->db->setQuery( $query );
                $this->db->query();
            }
            
            $userFL = $userNAME;
        }

        JRequest::setVar('chooseId', $idTest);
        JRequest::setVar('deepLv', '2');

        $credentials['username'] = $userFL;
        $credentials['password'] = 'serverConnFlexam2.0';

        return $credentials;
    }
}
?>