<?php
defined('_JEXEC') or die;

use SpeventsHelper as HE;

class SpeventsViewEvent extends JViewLegacy
{
	protected $item;

	protected $form;

	public function display($tpl = null)
	{
		$this->item = $this->get('Item');
		$this->form = $this->get('Form');

		

		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br>',$errors));
			return false;
		}
		

		$this->addToolbar();

		return parent::display($tpl);
	}


	protected function addToolbar()
	{
		$input = JFactory::getApplication()->input;
		$input->set('hidemainmenu',true);

		$user = JFactory::getUser();
		$userId = $user->get('id');
		$isNew = $this->item->id == 0;
		$canDo = SpeventsHelper::getActions('com_spevents','component');

		JToolbarHelper::title(JText::_("COM_SPEVENTS_EVENT_" . ($isNew ? 'NEW' : 'EDIT')), 'calendar-3');
		

		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::apply('event.apply','JTOOLBAR_APPLY');
			JToolbarHelper::save('event.save','JTOOLBAR_SAVE');
			JToolbarHelper::save2new('event.save2new');
			JToolbarHelper::save2copy('event.save2copy');
		}

		JToolbarHelper::cancel('event.cancel','JTOOLBAR_CLOSE');


	}
}