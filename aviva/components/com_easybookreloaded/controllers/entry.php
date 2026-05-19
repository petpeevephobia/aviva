<?php
/**
 * @package   	Easybook
 * @link 		http://www.easy-joomla.org
 * @license    	GNU/GPL
 *
 * Name:			Easybook Reloaded
 * Based on: 		Easybook by http://www.easy-joomla.org
 * License:    		GNU/GPL
 * Project Page: 	http://joomla-extensions.kubik-rubik.de/ebr-easybook-reloaded
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Easybook Reloaded Component Controller
 *
 * @package    Easybook Reloaded
 */
class EasybookReloadedControllerEntry extends JController
{
	var $_access = null;
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
	}

	function _add_edit()
	{
		JRequest::setVar( 'view', 'entry' );
		JRequest::setVar( 'layout', 'form' );
		parent::display();
	}

	function add()
	{
		$this->_add_edit();
	}

	function edit()
	{
		$this->_add_edit();
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		global $mainframe;
 		$uri  =  JFactory::getURI();
		$mail =& JFactory::getMailer();
		$db   =& JFactory::getDBO();
		$params =& JComponentHelper::getParams( 'com_easybookreloaded' );
		$session = JFactory::getSession();
		jimport('joomla.utilities.simplecrypt');
		require_once(JPATH_SITE.DS.'components'.DS.'com_easybookreloaded'.DS.'helpers'.DS.'route.php');
		
		//ACL stuff
		$user =& JFactory::getUser();
		$canAdd = $user->authorize( 'com_easybookreloaded', 'add' );
		$canEdit = $user->authorize( 'com_easybookreloaded', 'edit', 'content', 'all' );
		
		//get mail addresses of all super administrators
		$query = 'SELECT email' .
				' FROM #__users' .
				' WHERE LOWER(usertype) = "Super Administrator" AND sendEmail = 1';
		$db->setQuery($query);
		$admins = $db->loadResultArray();
		
		// Zusätzliche E-Mail Adressen aus den Einstellungen holen
		if ($params->get('emailfornotification'))
		{
			$emailfornotification = explode(",", $params->get('emailfornotification'));
			foreach ($emailfornotification as $type)
			{
				$admins[] = trim($type);
			}
		}
		
		// Cache leeren
		$this->cleancache();
		
		$temp = JRequest::get('post');
		$temp['gbtext'] = JRequest::getVar('gbtext', NULL, 'post', 'none' ,JREQUEST_ALLOWRAW);
		
		if (isset($temp['id']))
		{
			$id = $temp['id'];
		} 
		else 
		{
			$id = 0;
		}
		
		$name = $temp['gbname'];
		$text = $temp['gbtext'];
		
		if (isset($temp['gbip']))
		{
			$gbip = $temp['gbip'];
		} 
		else 
		{
			$gbip = '0.0.0.0';
		}
		
		if (($id == 0 && $canAdd) || ($id != 0 && $canEdit)) 
		{
			$model = $this->getModel('entry');
	
			if ($row = $model->store()) 
			{
				if ($params->get('default_published', true)) 
				{
					$msg = JText::_('Entry Saved');
					$type = 'message';
				} 
				else 
				{
					$msg = JText::_('Entry saved but has to be approved');
					$type = 'notice';
				}
				$link = JRoute::_('index.php?option=com_easybookreloaded&view=easybookreloaded', false);
				
				// Benachrichtigungsmail an Administratoren und zusätzlicher E-Mail Adresse senden
				if ($id == 0 AND $params->get('send_mail', true)) 
				{
					// Hash für Links in der Mail generieren - Easybook Reloaded
					$hash = array();
					$hash['id'] = (int)$row->get('id');
					$hash['gbmail'] = md5($row->get('gbmail'));
					$hash['custom_secret'] = $params->get('secret_word');
					$hash['username'] = $row->get('gbname');
					$hash = serialize($hash);
					$crypt = new JSimpleCrypt();
					$hash = $crypt->encrypt($hash);
					$hash = base64_encode($hash);					

					$href = $uri->base().EasybookReloadedHelperRoute::getEasybookReloadedRoute($row->get('id'));

					// Adminlinks verschlüsseln
					$hashmail_publish = $uri->base().EasybookReloadedHelperRoute::getEasybookReloadedRouteHashPublish($row->get('id')).$hash;
					$hashmail_comment = $uri->base().EasybookReloadedHelperRoute::getEasybookReloadedRouteHashComment($row->get('id')).$hash;
					$hashmail_edit = $uri->base().EasybookReloadedHelperRoute::getEasybookReloadedRouteHashEdit($row->get('id')).$hash;
					$hashmail_delete = $uri->base().EasybookReloadedHelperRoute::getEasybookReloadedRouteHashDelete($row->get('id')).$hash;
					
					// Mailfunktion initialisieren
					$mail->setsubject(JTEXT::_('New Guestbookentry'));
					if ($params->get('send_mail_html'))
					{
						$mail->IsHTML(true);
						$mail->setbody(JTEXT::sprintf('A new guestbookentry has been written HTML', $uri->base(), $name, $text, $href, $hashmail_publish, $hashmail_comment, $hashmail_edit, $hashmail_delete));
					}
					else
					{
					$mail->setbody(JTEXT::sprintf('A new guestbookentry has been written', $uri->base(), $name, $text, $href, $hashmail_publish, $hashmail_comment, $hashmail_edit, $hashmail_delete));
					}
					$mail->addrecipient($admins);
					// ReplyTo - Daten aus übergebenem Array bei erfolgreicher Eingabe übernehmen - 2.0.7.1
					$replyto = array($row->get('gbmail'), $row->get('gbname'));
					$mail->addReplyTo($replyto);
					$mail->send();
				}
			} 
			else 
			{
				$errors_output = array();
				$errors_array = array_keys($session->get('errors', null, 'easybookreloaded'));
				
				if (in_array("easycalccheck", $errors_array)) 
				{
					$errors_output[] = JTEXT::_('ERROR EASYCALCCHECK');
				}
				else
				{
					if (in_array("name", $errors_array)) 
					{
						$errors_output[] = JTEXT::_('ERROR NAME');
					}
					if (in_array("mail", $errors_array)) 
					{
						$errors_output[] = JTEXT::_('ERROR MAIL');
					}
					if (in_array("text", $errors_array)) 
					{
						$errors_output[] = JTEXT::_('ERROR TEXT');
					}
					if (in_array("aim", $errors_array)) 
					{
						$errors_output[] = JTEXT::_('ERROR AIM');
					}
					if (in_array("icq", $errors_array)) 
					{
						$errors_output[] = JTEXT::_('ERROR ICQ');
					}					
					if (in_array("yah", $errors_array)) 
					{
						$errors_output[] = JTEXT::_('ERROR YAH');
					}					
					if (in_array("skype", $errors_array)) 
					{
						$errors_output[] = JTEXT::_('ERROR SKYPE');
					}
					if (in_array("msn", $errors_array)) 
					{
						$errors_output[] = JTEXT::_('ERROR MSN');
					}
					if (in_array("toomanylinks", $errors_array)) 
					{
						$errors_output[] = JTEXT::_('ERROR TOOMANYLINKS');
					}
				}
				
				$errors = implode(", ", $errors_output);
			
				$msg = JText::sprintf('Please validate your inputs', $errors);
				$link = JRoute::_('index.php?option=com_easybookreloaded&controller=entry&task=add&retry=true', false);
				$type = 'notice';
				
				$session->clear('errors', 'easybookreloaded');
			}
			$this->setRedirect($link, $msg, $type);
		} 
		else 
		{
			JError::raiseError(403, JText::_('ALERTNOTAUTH'));
		}
	}

	/**
	 * comment record
	 * @return void
	 */
	function comment()
	{
		// Kommentarformular laden
		JRequest::setVar('view', 'entry');
		JRequest::setVar('layout', 'commentform');
		JRequest::setVar('hidemainmenu', 1);
		parent::display();
	}

	/**
	 * remove record
	 * @return void
	 */
	function remove()
	{
		$this->cleancache();
		// Load model and delete entry - redirect afterwards
		$model = $this->getModel('entry');
		if (!$model->delete()) 
		{
			$msg = JText::_('Error: Entry could not be deleted');
			$type = 'error';
		} 
		else 
		{
			$msg = JText::_('Entry Deleted');
			$type = 'message';
		}
		$this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded', false), $msg, $type);
	}

	function publish() 
	{
		$this->cleancache();
		$model = $this->getModel('entry');
		switch($model->publish()) 
		{
			case -1: 
				$msg = JText::_('Error: Could not change publish status');
				$type = 'error';
				break;
			case 0: 
				$msg = JText::_('Entry unpublished');
				$type = 'message';
				break;
			case 1: 
				$msg = JText::_('Entry published');
				$type = 'message';
				break;
		}
		$this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded', false), $msg, $type);
	}
 
	/**
	 * save a comment
         * @return void
	*/
	function savecomment()
	{
		$this->cleancache();
		$model = $this->getModel('entry');
		if (!$row = $model->savecomment()) 
		{
		      $msg = JText::_('Error: Could not save comment');
		      $type = 'error';
		} 
		else 
		{	
		    if (isset($row['inform']) AND $row['inform'] == 1)
			{
				$data = $model->getRow($row['id']);
				$uri  =  JFactory::getURI();
				$mail =& JFactory::getMailer();
				$params =& JComponentHelper::getParams('com_easybookreloaded');
				require_once(JPATH_SITE.DS.'components'.DS.'com_easybookreloaded'.DS.'helpers'.DS.'route.php');
				
				$href = $uri->base().EasybookReloadedHelperRoute::getEasybookReloadedRoute($data->get('id'));
				$mail->setsubject(JTEXT::_('Admin Comment Subject'));
				if ($params->get('send_mail_html'))
				{
					$mail->IsHTML(true);
					$mail->setbody(JTEXT::sprintf('Admin Comment Body HTML', $data->get('gbname'), $uri->base(), $href));
				}
				else
				{
					$mail->setbody(JTEXT::sprintf('Admin Comment Body', $data->get('gbname'), $uri->base(), $href));
				}
				$mail->addrecipient($data->get('gbmail'));
				$mail->send();
				
				$msg = JText::_('Comment saved inform');
			}
			else
			{
				$msg = JText::_('Comment saved');
			}
		    $type = 'message';
		}
		$this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded', false ), $msg, $type);
	}
	
	
	// Cache der Seiten (Cache Plugin) leeren, damit Einträge sofort sichtbar sind
	function cleancache()
	{
		$cache = JFactory::getCache();
		$id = md5(JRoute::_('index.php?option=com_easybookreloaded&view=easybookreloaded', false));
		$cache->remove($id, 'page');
		$id_entry = md5(JRoute::_('index.php?option=com_easybookreloaded&controller=entry&task=add', false));
		$cache->remove($id_entry, 'page');
		$id_entry_retry = md5(JRoute::_('index.php?option=com_easybookreloaded&controller=entry&task=add&retry=true', false));
		$cache->remove($id_entry_retry, 'page');
	}
}
?>
