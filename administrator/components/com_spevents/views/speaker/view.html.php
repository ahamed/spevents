<?php
defined('_JEXEC') or die;

use SpeventsHelper as HE;

class SpeventsViewSpeaker extends JViewLegacy
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

		JToolbarHelper::title(JText::_("COM_SPEVENTS_SPEAKER_" . ($isNew ? 'NEW' : 'EDIT')), 'user');

		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::apply('speaker.apply','JTOOLBAR_APPLY');
			JToolbarHelper::save('speaker.save','JTOOLBAR_SAVE');
			JToolbarHelper::save2new('speaker.save2new');
			JToolbarHelper::save2copy('speaker.save2copy');
		}

		JToolbarHelper::cancel('speaker.cancel','JTOOLBAR_CLOSE');


	}
}