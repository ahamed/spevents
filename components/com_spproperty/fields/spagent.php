<?php

/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class JFormFieldSpagent extends JFormField {

    protected $type = 'spagent';


    protected function getInput(){

        // Get Tournaments
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // Select all records from the user profile table where key begins with "custom.".
        $query->select($db->quoteName(array('spproperty_agent_id', 'title', 'slug' )));
        $query->from($db->quoteName('#__spproperty_agents'));
        $query->where($db->quoteName('enabled')." = 1");
        $query->order('ordering DESC');

        $db->setQuery($query);  
        $results = $db->loadObjectList();
        $agents = $results;

        $options = array(''=>JText::_('COM_SPPROPERTY_ALL'));

        foreach($agents as $agent){
            $options[] = JHTML::_( 'select.option', $agent->spproperty_agent_id, $agent->title );

        }
        
        return JHTML::_('select.genericlist', $options, $this->name, '', 'value', 'text', $this->value);
    }
}
