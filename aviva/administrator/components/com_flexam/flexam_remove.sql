-- @package      com_flexam for Joomla! 1.5
-- @version	$Id: flexam.php 2010-04-02 10:07:31Z Hernán Roa $
-- @author       Hernán Roa Reyes
-- @copyright	(C) 2010 - 2012 Hernán Roa Reyes.
-- @license	GNU/GPLv3 http://www.gnu.org/copyleft/gpl.html
-- See license.txt
-- flexam is free software. This version may have been modified pursuant
-- to the GNU General Public License, and as distributed it includes or
-- is derivative of works licensed under the GNU General Public License or
-- other free or open source software licenses.

DROP TABLE IF EXISTS `#__flexam_connconfig`;
DROP TABLE IF EXISTS `#__flexam_answer`;
DROP TABLE IF EXISTS `#__flexam_instructions_per_test`;
DROP TABLE IF EXISTS `#__flexam_instructions`;
DROP TABLE IF EXISTS `#__flexam_questions_per_test`;
DROP TABLE IF EXISTS `#__flexam_questions`;
DROP TABLE IF EXISTS `#__flexam_typeQuestions`;
DROP TABLE IF EXISTS `#__flexam_testDone_state`;
DROP TABLE IF EXISTS `#__flexam_testState`;
DROP TABLE IF EXISTS `#__flexam_test`;
DROP TABLE IF EXISTS `#__flexam_dificulty`;
DROP TABLE IF EXISTS `#__flexam_subjects`;
DROP TABLE IF EXISTS `#__flexam_typeSubject`;
DROP TABLE IF EXISTS `#__flexam_knowledgeAreas`;
DELETE FROM `#__core_acl_groups_aro_map` WHERE `#__core_acl_groups_aro_map`.`aro_id`=(SELECT `#__core_acl_aro`.`id` FROM `#__core_acl_aro` WHERE `#__core_acl_aro`.`name`='Test FLEXAM');
DELETE FROM `#__core_acl_aro` WHERE `name`='Test FLEXAM';
DELETE FROM `#__users` WHERE email='faked@faked.com';