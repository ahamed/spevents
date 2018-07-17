<?php

    /**
    * @author    JoomShaper http://www.joomshaper.com
    * @copyright Copyright (C) 2010 - 2013 JoomShaper
    * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2
    */

    defined('JPATH_BASE') or die;

    jimport('joomla.form.formfield');
    jimport('joomla.filesystem.folder');
    jimport('joomla.filesystem.file');
    
    class JFormFieldSpgenres extends JFormField {

        protected $type = 'spgenres';


        protected function getInput(){

            // Get Tournaments
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            // Select all records from the user profile table where key begins with "custom.".
            $query->select($db->quoteName(array('spmoviedb_genre_id', 'title', 'slug' )));
            $query->from($db->quoteName('#__spmoviedb_genres'));
            $query->where($db->quoteName('enabled')." = 1");
            $query->order('ordering DESC');

            $db->setQuery($query);  
            $results = $db->loadObjectList();
            $genres = $results;

            $options = array(''=>JText::_('COM_SPMOVIEDB_FIELD_ALL'));

            foreach($genres as $genre){
                $options[] = JHTML::_( 'select.option', $genre->spmoviedb_genre_id, $genre->title );

            }
            
            return JHTML::_('select.genericlist', $options, $this->name, '', 'value', 'text', $this->value);
        }
    }
