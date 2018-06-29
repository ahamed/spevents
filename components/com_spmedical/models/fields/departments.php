<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

jimport('joomla.form.formfield');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class JFormFieldDepartments extends JFormField {

    protected $type = 'departments';

    protected function getInput(){

        // Get Certificates
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('a.id', 'a.title')));
        $query->from($db->quoteName('#__spmedical_departments', 'a'));
        $query->where($db->quoteName('a.published')." = 1");
        $query->order('a.ordering DESC');
        $db->setQuery($query);
        $results = $db->loadObjectList();
        $departments = $results;

        $options = array( '' => 'All' );
        foreach($departments as $department){
            $options[] = JHTML::_( 'select.option', $department->id, $department->title );
        }
        
        return JHTML::_('select.genericlist', $options, $this->name, '', 'value', 'text', $this->value);
    }
}
