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

defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	JToolBarHelper::title(  JText::_( 'FLEXAM_MODULE_TITLE' ) );
	JToolBarHelper::publishList();
	JToolBarHelper::unpublishList();
	JToolBarHelper::deleteList();
	JToolBarHelper::editListX();
	JToolBarHelper::addNewX();
	JToolBarHelper::help( '../help_3', true );
?>

<form action="index.php?option=com_flexam&optCtrl=testName" method="post" name="adminForm">
<table>
	<tr>
		<td align="left" width="100%">
			<?php echo JText::_( 'Filter' ); ?>:
			<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
			<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
			<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
		</td>
		<td nowrap="nowrap">
			<?php echo $this->lists['state']; ?>
		</td>
	</tr>
</table>
<div id="tablecell">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th  class="title">
				<?php echo JHTML::_('grid.sort',   'FLEXAM_TITLE_ORDER_TEST', 'm.nameTest', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
                        <th  class="title">
				<?php echo JHTML::_('grid.sort',   'FLEXAM_TITLE_ORDER_COURSE', 'b.subjects', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
                        <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Areas', 'c.areaName', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
                        <th  class="title">
				<?php echo JHTML::_('grid.sort',   'FLEXAM_TEST_DIFICULTY', 'testDificulty', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
                        <th class="title">
                                <?php echo JHTML::_('grid.sort',   'Date', 'dateT', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
                        </th>
			<th width="5%" align="center">
				<?php echo JHTML::_('grid.sort',   'Published', 'm.published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th width="1%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'ID', 'm.idtest', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="9">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];

		$link 		= JRoute::_( 'index.php?option=com_flexam&optCtrl=testName&task=edit&cid[]='. $row->idtest );

		$checked 	= JHTML::_('grid.checkedout', $row, $i );
		$published 	= JHTML::_('grid.published', $row, $i );
	?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
			<?php
                        if (  JTable::isCheckedOut($this->user->get ('id'), $row->published )  ) {
				echo $row->nameTest;
			} else {
				?>
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'FLEXAM_TITLE_ORDER_TEST' );?>::<?php echo $row->nameTest; ?>">
				<a href="<?php echo $link  ?>">
					<?php echo $row->nameTest; ?></a></span>
				<?php
			}
			?>
			</td>
                        <td>
			<?php echo $row->subjects; ?>
			</td>
                        <td>
			<?php echo $row->areaName; ?>
			</td>
                        <td>
			<?php echo $row->testDificulty.' %'; ?>
			</td>
                        <td>
                        <?php echo $row->dateT ?>
                        </td>
			<td align="center">
				<?php echo $published;?>
			</td>
			<td align="center">
				<?php echo $row->idtest; ?>
			</td>
		</tr>
		<?php
			$k = 1 - $k;
		}
		?>
	</tbody>
	</table>
</div>

	<input type="hidden" name="option" value="com_flexam" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>