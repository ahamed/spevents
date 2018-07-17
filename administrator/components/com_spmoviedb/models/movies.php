<?php
/**
* @package     SP Movie Database
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

defined('_JEXEC') or die('Restricted access!');

class SpmoviedbModelMovies extends FOFModel
{

  public function buildQuery($overrideLimits = false)
    {
        $db = $this->getDbo();
        $query = parent::buildQuery($overrideLimits = true);

        $status = $this->getState('status', null);

        if( $status != null  )
        {
            $query->where($db->quoteName('enabled') . ' = ' . $db->quote($status));
        }

        $filter_order = $this->getState('filter_order', 'created_on');
        $filter_order_dir = $this->getState('filter_order_Dir', 'DESC');
       
        if(empty($filter_order)) {
          $filter_order = 'created_on';
        } elseif(strtolower($filter_order) == 'id') {
            $filter_order = 'spmoviedb_movie_id';
        }
        
        $query->order($filter_order . ' ' . $filter_order_dir);

        return $query;
    }

  protected function onBeforeSave(&$data, &$table) {
    $actors = $this->input->get('actors', NULL, 'ARRAY');
    $directors = $this->input->get('directors', NULL, 'ARRAY');

    $data['directors'] = json_encode(self::addCelebrities($directors));
    $data['actors'] = json_encode(self::addCelebrities($actors));

    return true;
  }

  private static function addCelebrities($actors = array()) {
    $db = JFactory::getDbo();
    $newActors = array();
    $plainNewActors = array();
    $allActors = array();
    $i = 0;

    foreach ($actors as $actor) {
      if(strpos($actor, '#new#') !== false) {
        $title = str_replace('#new#', '', $actor);
        $newActors[$i][] = $db->quote($title);
        $newActors[$i][] = $db->quote(JFilterOutput::stringURLSafe($title));
        $plainNewActors[] = $title;
        $i++;
      } else {
        $allActors[] = $actor;
      }
    }

    // Insert New
    foreach ($newActors as $values) {

      if(!self::checkSlug($values[1])) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $columns = array('title', 'slug');
        $query
        ->insert($db->quoteName('#__spmoviedb_celebrities'))
        ->columns($db->quoteName($columns))
        ->values(implode(',', $values));

        $db->setQuery($query);
        $db->execute();

        $allActors[] = $db->insertid();
      }
    }

    return $allActors;
  }

  private static function checkSlug($slug='') {

    $db = JFactory::getDbo();
    $query = $db->getQuery(true); 
    $query->select($db->quoteName(array('slug')));
    $query->from($db->quoteName('#__spmoviedb_celebrities'));
    $query->where($db->quoteName('slug') . ' = '. $slug);
    $db->setQuery($query); 
    $results = $db->loadObjectList();

    return count($results);
  }
}