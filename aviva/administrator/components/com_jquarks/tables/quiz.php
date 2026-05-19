<?php
/**
 * JQuarks Component Quiz Table
 * 
 * @version		$Id: quiz.php 63 2010-03-02 17:16:21Z fnaccache $
 * @author		IP-Tech Labs <labs@iptech-offshore.com> 
 * @copyright	2009-2010 IP-Tech
 * @package     JQuarks-Back-Office
 * @subpackage  Tables
 * @link		http://www.iptechinside.com/labs/projects/show/jquarks
 * @since		0.1
 * @license     GNU/GPL2
 *    
 *    This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; version 2
 *  of the License.
 *
 *    This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA. 
 *  or see <http://www.gnu.org/licenses/>
 */

defined('_JEXEC') or die('Restricted access') ;


class TableQuiz extends JTable 
{
	/**
	 * 
	 * @var int
	 */
	var $id = null ;
	
	/**
	 * 
	 * @var string
	 */
	var $title = null ;
	
	/**
	 * 
	 * @var string
	 */
	var $description = null ;
	
	/**
	 * 
	 * @var boolean
	 */
	var $published = false ;
	
	/**
	 * 
	 * @var int
	 */
	var $access_id = null ;
	
	/**
	 * 
	 * @var int
	 */
	var $time_limit = null ;
	
	/**
	 * @var boolean
	 */
	var $unique_session = false ;
	
	/**
	 * 
	 * @var int
	 */
	var $paginate = null ;
	
	/**
	 * 
	 * @var date
	 */
	var $publish_up = null ;
	
	/**
	 * 
	 * @var date
	 */
	var $publish_down = null ;

	/**
	 * 
	 * @var text
	 */
	var $notify_message = null ;

	/**
     *
     * @var boolean
     */
    var $show_results = false ;
	
	function TableQuiz(& $db){
		parent::__construct('#__jquarks_quizzes', 'id', $db) ;
	}	
    
}