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

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `jos_flexam_connconfig`
--

CREATE TABLE IF NOT EXISTS `#__flexam_connconfig` (
  `idcgf` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) DEFAULT NULL,
  `value` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idcgf`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Volcar la base de datos para la tabla `jos_flexam_connconfig`
--

INSERT INTO `#__flexam_connconfig` (`idcgf`, `type`, `value`) VALUES
(1, 'stackMode', NULL),
(2, 'nameCom', NULL),
(3, 'external link', NULL),
(4, 'Link Redirection', NULL),
(5, 'Redirection Time', NULL),
(6, 'Mail Body', NULL),
(7, 'display result', '1'),
(8, 'aprove msg', 'Aprobado'),
(9, 'reprove msg', 'Reprobado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `#__flexam_answer`
--

CREATE TABLE IF NOT EXISTS `#__flexam_answer` (
  `idanswer` int(11) NOT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `idquestion` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `dateAnswerTest` varchar(50) NOT NULL,
  PRIMARY KEY (`idanswer`),
  KEY `fk_answer_questions1` (`idquestion`),
  KEY `fk_answer_user` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `#__flexam_dificulty`
--

CREATE TABLE IF NOT EXISTS `#__flexam_dificulty` (
  `idDificulty` int(11) NOT NULL,
  `pCent` int(11) NOT NULL,
  PRIMARY KEY (`idDificulty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `#__flexam_dificulty`
--

INSERT INTO `#__flexam_dificulty` (`idDificulty`, `pCent`) VALUES
(1, 10),
(2, 20),
(3, 30),
(4, 40),
(5, 50),
(6, 60),
(7, 70),
(8, 80),
(9, 90),
(10, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `#__flexam_instructions`
--

CREATE TABLE IF NOT EXISTS `#__flexam_instructions` (
  `idinstruction` int(11) NOT NULL AUTO_INCREMENT,
  `detail` text,
  `published` tinyint(4) DEFAULT NULL,
  `checked_out` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`idinstruction`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `#__flexam_instructions_per_test`
--

CREATE TABLE IF NOT EXISTS `#__flexam_instructions_per_test` (
  `idtest` int(11) NOT NULL,
  `idinstruction` int(11) NOT NULL,
  PRIMARY KEY (`idtest`,`idinstruction`),
  KEY `fk_test_has_instructions_test1` (`idtest`),
  KEY `fk_test_has_instructions_instructions1` (`idinstruction`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `#__flexam_knowledgeAreas`
--

CREATE TABLE IF NOT EXISTS `#__flexam_knowledgeAreas` (
  `idknowledgeArea` int(11) NOT NULL AUTO_INCREMENT,
  `areaName` varchar(150) DEFAULT NULL,
  `published` tinyint(4) DEFAULT NULL,
  `checked_out` tinyint(4) DEFAULT NULL,
  `img` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idknowledgeArea`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `#__flexam_questions`
--

CREATE TABLE IF NOT EXISTS `#__flexam_questions` (
  `idquestion` int(11) NOT NULL AUTO_INCREMENT,
  `question` text,
  `response` text,
  `published` tinyint(4) DEFAULT NULL,
  `checked_out` tinyint(4) DEFAULT NULL,
  `idtypeQuestions` int(11) NOT NULL,
  PRIMARY KEY (`idquestion`),
  KEY `fk_questions_typeQuestions1` (`idtypeQuestions`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `#__flexam_questions_per_test`
--

CREATE TABLE IF NOT EXISTS `#__flexam_questions_per_test` (
  `idquestion` int(11) NOT NULL,
  `idtest` int(11) NOT NULL,
  `points` int(11) DEFAULT NULL,
  PRIMARY KEY (`idquestion`,`idtest`),
  KEY `fk_questions_has_test_questions1` (`idquestion`),
  KEY `fk_questions_has_test_test1` (`idtest`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `#__flexam_subjects`
--

CREATE TABLE IF NOT EXISTS `#__flexam_subjects` (
  `idsubjects` int(11) NOT NULL AUTO_INCREMENT,
  `code` bigint(20) DEFAULT NULL,
  `subjects` varchar(200) DEFAULT NULL,
  `idknowledgeArea` int(11) NOT NULL,
  `published` tinyint(4) DEFAULT NULL,
  `checked_out` tinyint(4) DEFAULT NULL,
  `idTypeSubject` int(11) NOT NULL,
  `mailManager` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idsubjects`),
  KEY `fk_subjects_class_exam` (`idknowledgeArea`),
  KEY `fk_TypeSubject` (`idTypeSubject`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `#__flexam_test`
--

CREATE TABLE IF NOT EXISTS `#__flexam_test` (
  `idtest` int(11) NOT NULL AUTO_INCREMENT,
  `idsubjects` int(11) NOT NULL,
  `nameTest` varchar(150) DEFAULT NULL,
  `dificulty` int(11) DEFAULT NULL,
  `published` tinyint(4) DEFAULT NULL,
  `checked_out` tinyint(4) DEFAULT NULL,
  `dateTest` date DEFAULT NULL,
  `aprobeScore` int(11) DEFAULT NULL,
  `minScore` int(11) DEFAULT NULL,
  `maxScore` int(11) DEFAULT NULL,
  PRIMARY KEY (`idtest`),
  KEY `fk_test_subjects1` (`idsubjects`),
  KEY `fk_dificulty_test` (`dificulty`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jos_flexam_testDone_state`
--

CREATE TABLE IF NOT EXISTS `#__flexam_testDone_state` (
  `idtest` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `numApply` int(11) NOT NULL,
  `dateCode` varchar(50) NOT NULL,
  `idState` int(11) NOT NULL,
  PRIMARY KEY (`idtest`,`numApply`,`idUser`,`idState`),
  KEY `idState` (`idState`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jos_flexam_testState`
--

CREATE TABLE IF NOT EXISTS `#__flexam_testState` (
  `idTestState` int(11) NOT NULL,
  `state` varchar(50) NOT NULL,
  PRIMARY KEY (`idTestState`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `jos_flexam_testState`
--

INSERT INTO `#__flexam_testState` (`idTestState`, `state`) VALUES
(1, 'Approved'),
(2, 'Fail'),
(3, 'Pending');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `#__flexam_typeQuestions`
--

CREATE TABLE IF NOT EXISTS `#__flexam_typeQuestions` (
  `idtypeQuestions` int(11) NOT NULL,
  `type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idtypeQuestions`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `#__flexam_typeQuestions`
--

INSERT INTO `#__flexam_typeQuestions` (`idtypeQuestions`, `type`) VALUES
(1, 'Multiple Choice'),
(2, 'Related Term'),
(3, 'True or False'),
(4, 'Open Response');

--
-- Estructura de tabla para la tabla `jos_flexam_typeSubject`
--

CREATE TABLE IF NOT EXISTS `#__flexam_typeSubject` (
  `idTypeSubject` int(11) NOT NULL,
  `type` varchar(150) NOT NULL,
  PRIMARY KEY (`idTypeSubject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `jos_flexam_typeSubject`
--

INSERT INTO `#__flexam_typeSubject` (`idTypeSubject`, `type`) VALUES
(1, 'INDETERMINATE'),
(2, 'OPEN'),
(3, 'CLOSE');

-- --------------------------------------------------------
--
-- Filtros para la tabla `#__flexam_answer`
--
ALTER TABLE `#__flexam_answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`idquestion`) REFERENCES `#__flexam_questions` (`idquestion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `#__flexam_instructions_per_test`
--
ALTER TABLE `#__flexam_instructions_per_test`
  ADD CONSTRAINT `instructions_per_test_ibfk_1` FOREIGN KEY (`idtest`) REFERENCES `#__flexam_test` (`idtest`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `instructions_per_test_ibfk_2` FOREIGN KEY (`idinstruction`) REFERENCES `#__flexam_instructions` (`idinstruction`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `#__flexam_questions`
--
ALTER TABLE `#__flexam_questions`
  ADD CONSTRAINT `fk_questions_typeQuestions1` FOREIGN KEY (`idtypeQuestions`) REFERENCES `#__flexam_typeQuestions` (`idtypeQuestions`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `#__flexam_questions_per_test`
--
ALTER TABLE `#__flexam_questions_per_test`
  ADD CONSTRAINT `#__flexam_questions_per_test_ibfk_1` FOREIGN KEY (`idquestion`) REFERENCES `#__flexam_questions` (`idquestion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `#__flexam_questions_per_test_ibfk_2` FOREIGN KEY (`idtest`) REFERENCES `#__flexam_test` (`idtest`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `#__flexam_subjects`
--
ALTER TABLE `#__flexam_subjects`
  ADD CONSTRAINT `#__flexam_subjects_ibfk_1` FOREIGN KEY (`idTypeSubject`) REFERENCES `#__flexam_typeSubject` (`idTypeSubject`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`idknowledgeArea`) REFERENCES `#__flexam_knowledgeAreas` (`idknowledgeArea`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `#__flexam_test`
--
ALTER TABLE `#__flexam_test`
  ADD CONSTRAINT `#__flexam_test_ibfk_1` FOREIGN KEY (`dificulty`) REFERENCES `#__flexam_dificulty` (`idDificulty`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`idsubjects`) REFERENCES `#__flexam_subjects` (`idsubjects`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `#__flexam_testDone_state`
--
ALTER TABLE `#__flexam_testDone_state`
  ADD CONSTRAINT `#__flexam_testDone_state_ibfk_3` FOREIGN KEY (`idtest`) REFERENCES `#__flexam_test` (`idtest`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `#__flexam_testDone_state_ibfk_4` FOREIGN KEY (`idState`) REFERENCES `#__flexam_testState` (`idTestState`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Configuracion del menu
--

CREATE TABLE IF NOT EXISTS `#__flexam_tmpId` ( `id` int(11) NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `#__flexam_tmpId` (`id`) (SELECT MAX(id) + 1 FROM #__components);

UPDATE `#__components` SET `id` = (SELECT id FROM `#__flexam_tmpId`) WHERE name='Flexam';

INSERT INTO `#__components` (`name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`) VALUES
('Flexam', 'option=com_flexam', 0, 0, 'option=com_flexam', 'Flexam', 'com_flexam', 0, 'js/ThemeOffice/component.png', 0, '', 1);

UPDATE `#__flexam_tmpId` SET `id` = (SELECT id FROM `#__components` WHERE name='Flexam');

INSERT INTO `#__components` (`name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`) VALUES
('Course Categories', '', 0, (SELECT id FROM `#__flexam_tmpId`), 'option=com_flexam&optCtrl=areaCourse', 'Course Categories', 'com_flexam', 0, 'js/ThemeOffice/component.png', 0, '', 1),
('Courses', '', 0, (SELECT id FROM `#__flexam_tmpId`), 'option=com_flexam&optCtrl=courseName', 'Courses', 'com_flexam', 1, 'js/ThemeOffice/component.png', 0, '', 1),
('Test', '', 0, (SELECT id FROM `#__flexam_tmpId`), 'option=com_flexam&optCtrl=testName', 'Test Name', 'com_flexam', 2, 'js/ThemeOffice/component.png', 0, '', 1),
('Question Test', '', 0, (SELECT id FROM `#__flexam_tmpId`), 'option=com_flexam&optCtrl=questionTest', 'Question Test', 'com_flexam', 3, 'js/ThemeOffice/component.png', 0, '', 1),
('Answers Question Test', '', 0, (SELECT id FROM `#__flexam_tmpId`), 'option=com_flexam&optCtrl=answerTest', 'Answers Question Test', 'com_flexam', 4, 'js/ThemeOffice/component.png', 0, '', 1),
('Configuration', '', 0, (SELECT id FROM `#__flexam_tmpId`), 'option=com_flexam&optCtrl=mainFlCfg', 'Configuration', 'com_flexam', 5, 'js/ThemeOffice/component.png', 0, '', 1);

DROP TABLE `#__flexam_tmpId`;

--
-- Configuracion del Default User
--

INSERT INTO #__users (name, username, email, password, usertype, block, sendEmail, gid, registerDate, lastvisitDate, activation, params) VALUES ('Test FLEXAM', 'testflexam', 'faked@faked.com', '95dd08505665c92549914d6e61fcb986:MnWBl2kUVQsEvcZkE88JAsKe7CTM4JRY', 'Registered', 0, 0, 18, '2010-07-19 20:15:15', '2010-07-19 22:33:55', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n');

INSERT INTO #__core_acl_aro (section_value, value, order_value, name, hidden) VALUES ('users', (SELECT MAX(id) FROM #__users), 0, 'Test FLEXAM', 0);

INSERT INTO #__core_acl_groups_aro_map (group_id, section_value, aro_id) VALUES ('18', '', (SELECT MAX(id) FROM #__core_acl_aro));