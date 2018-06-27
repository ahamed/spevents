<?php
use SpeventsHelper as H;
defined('_JEXEC') or die;

$user = JFactory::getUser();

$listOrder = $this->escape($this->state->get('list.ordering'));

$listDirn = $this->escape($this->state->get('list.direction'));

$canOrder = $user->authorise('core.edit.state','com_spevents.category');
$saveOrder = $listOrder == 'a.ordering';

if($saveOrder) {
	$saveOrderingUrl = 'index.php?option=com_spevents&task=organizers.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'eventList','adminForm', strtolower($listDirn),$saveOrderingUrl);
}

$sortFields = $this->getSortFields();


JHtml::_('jquery.framework', false);

?>

<script type="text/javascript">
    Joomla.orderTable = function() {
        //table = document.getELementById('sortTable');
        table = document.getElementById('sortTable');
        direction = document.getElementById('directionTable');

        order = table.options[table.selectedIndex].value;

        if (order != '<?php echo $listOrder; ?>') {
            dirn = 'asc';
        } else {
            dirn = direction.options[direction.selectedIndex].value;
        }

        Joomla.tableOrdering(order, dirn, '');
    }

</script>




<form action="<?php echo JRoute::_('index.php?option=com_spevents&view=organizers'); ?>" method="post" name="adminForm" id="adminForm">

	<?php if (!empty($this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>



	<div id="j-main-container" class="span10" >
		<?php else: ?>
			<div id="j-main_container"></div>
		<?php endif; ?>

		<div id="filter-bar" class="btn-toolbar">
			<div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible">
					<?php echo JText::_('com_spevents_SEARCH_IN_TITLE'); ?>
				</label>
				<input type="text" id="filter_search" name="filter_search"
				       value="<?php echo $this->escape($this->state->get('filter.search')) ; ?>"
				       title="<?php echo JText::_('com_spevents_SEARCH_IN_TITLE'); ?>"
				       placeholder="<?php echo JText::_('com_spevents_SEARCH_IN_TITLE'); ?>">
			</div>

			<div class="btn-group pull-left">
				<button class="btn hasTooltip"
				        type="submit"
				        title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>">
					<i class="icon-search"></i>
				</button>
				<button class="btn hasTooltip"
				        type="button"
				        title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"
				        onclick="document.getElementById('filter_search').value=''; this.form.submit();"
				>
					<i class="icon-remove"></i>
				</button>
			</div>

			<div class="btn-group pull-right hidden-phone">
				<label for="limit" class="element-invisible">
					<?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?>
				</label>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>


			<div class="btn-group pull-right hidden-phone">
				<label for="directionTable" class="element-invisible">
					<?php echo JText::_('JFIELD_ORDERING_DESC'); ?>
				</label>
				<select name="directionTable"
				        onchange="Joomla.orderTable()"
				        id="directionTable" class="input-medium">
					<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></option>

					<option value="asc" <?php if($listDirn == 'asc') echo 'selected="selected"'?>>
						<?php echo JText::_('JGLOBAL_ORDER_ASCENDING'); ?>
					</option>

					<option value="desc" <?php if($listDirn == 'desc') echo 'selected="selected"' ;?>>
						<?php echo JText::_('JGLOBAL_ORDER_DESCENDING'); ?>
					</option>

				</select>
			</div>


			<div class="btn-group pull-right">
				<label for="sortTable" class="element-invisible">
					<?php echo JText::_('JGLOBAL_SORT_BY'); ?>
				</label>

				<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable();">
					<option value="">
						<?php echo JText::_('JGLOBAL_SORT_BY'); ?>
					</option>
					<?php echo JHtml::_('select.options', $sortFields, 'value','text', $listOrder); ?>
				</select>
			</div>

		</div>


		<div class="clearfix"></div>

		<table class="table table-striped" id="eventList">
			<thead>
			<tr>

				<th class="nowrap center hidden-phone" width="1%">
					<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
				</th>

				<th width="1%" class="hidden-phone">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>

				<th>
					<?php echo JHtml::_('grid.sort','JGLOBAL_TITLE','a.title',$listDirn,$listOrder); ?>
				</th>

                <th>
                    <?php echo JHtml::_('grid.sort', 'COM_SPEVENTS_PHONE_LABEL', 'a.phone', $listDirn, $listOrder); ?>
                </th>

                <th>
                    <?php echo JHtml::_('grid.sort','COM_SPEVENTS_EMAIL_LABEL','a.email', $listDirn,$listOrder); ?>
                </th>

				<th width="1%" class="nowrap center">
					<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.enabled', $listDirn, $listOrder); ?>
				</th>
				<th width="1%" class="nowrap hidden-phone">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>


			</tr>
			</thead>

			<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
			</tfoot>

			<tbody>
			<?php foreach($this->items as $i => $item): ?>

				<?php
				$canCheckin = $user->authorise('core.manage', 'com_checkin') ||
					$item->checked_out == $user->get('id') ||
					$item->checked_out == 0;

				$canChange = $user->authorise('core.edit.state', 'com_spevents') && $canCheckin;

				$canEdit = $user->authorise(
					'core.edit',
					'com_spevents.category.' . $item->catid
				);

				?>

				<tr class="row<?php echo $i % 2; ?>" sortable-group-id="1">

					<td class="order nowrap center hidden-phone">
						<?php if($canChange) :
							$disableClassName = '';
							$disabledLabel = '';
							if(!$saveOrder) :
								$disabledLabel = JText::_('JORDERINGDISABLED');
								$disableClassName = 'inactive tip-top';
							endif;
							?>

							<span
								class="sortable-handler hasTooltip <?php echo $disableClassName; ?>"
								title="<?php echo $disabledLabel; ?>">
                            <i class="icon-menu"></i>
                        </span>
							<input type="text" style="display: none;" name="order[]" size="5"
							       class="width-20 text-area-order "
							       value="<?php echo $item->ordering; ?>" >
						<?php else: ?>
							<span class="sortable-handler inactive">
                            <i class="icon-menu"></i>
                        </span>
						<?php endif; ?>

					</td>


					<td class="center hidden-phone">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>

					<td>
						<?php if ($item->checked_out) : ?>
							<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'albums.', $canCheckin); ?>
						<?php endif; ?>

						<?php if ($canEdit) : ?>
							<a class="sp-events-title" href="<?php echo JRoute::_('index.php?option=com_spevents&task=organizer.edit&id=' . $item->id);?>">
								<?php echo $this->escape($item->title); ?>
							</a>
						<?php else : ?>
							<?php echo $this->escape($item->title); ?>
						<?php endif; ?>

						<span class="small break-word">
                                    <?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias)); ?>
                                </span>
					</td>

                    <td class="hidden-phone">
                        <?php echo $this->escape($item->phone); ?>
                    </td>
                    <td>
                        <?php if ($item->email): ?>
                            <?php echo $item->email; ?>
                        <?php else: ?>
                            <?php echo "--"; ?>
                        <?php endif; ?>
                    </td>

					<td class="center">
						<?php echo JHtml::_('jgrid.published', $item->enabled, $i, 'organizers.', true,'cb');?>
					</td>
					<td class="hidden-phone center">
						<?php echo $item->id; ?>
					</td>

				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

		<input type="hidden" name="task" value="" />

		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $lilstDirn; ?>" />

		<?php echo JHtml::_('form.token'); ?>

	</div>
</form>


