<?php
/**
* @package     SP Movie Database
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

defined('_JEXEC') or die('Restricted access!');

class com_spmoviedbInstallerScript {

    public function uninstall($parent) {

        $extensions = array(
            array('type'=>'module', 'name'=>'mod_sp_moviedb_trailers'),
            array('type'=>'module', 'name'=>'mod_spmoviedb_celebraties'),
            array('type'=>'module', 'name'=>'mod_spmoviedb_movie'),
            array('type'=>'module', 'name'=>'mod_spmoviedb_search'),
            array('type'=>'module', 'name'=>'mod_spmoviedb_tab'),
            array('type'=>'plugin', 'name'=>'spmoviedbupdater')
            );

        foreach ($extensions as $key => $extension) {

            $db = JFactory::getDbo();         
            $query = $db->getQuery(true);         
            $query->select($db->quoteName(array('extension_id')));
            $query->from($db->quoteName('#__extensions'));
            $query->where($db->quoteName('type') . ' = '. $db->quote($extension['type']));
            $query->where($db->quoteName('element') . ' = '. $db->quote($extension['name']));
            $db->setQuery($query); 
            $id = $db->loadResult();

            if(isset($id) && $id) {
                $installer = new JInstaller;
                $result = $installer->uninstall($extension['type'], $id);
            }
        }
    }

    function postflight($type, $parent) {
        $extensions = array(
            array('type'=>'module', 'name'=>'mod_sp_moviedb_trailers'),
            array('type'=>'module', 'name'=>'mod_spmoviedb_celebraties'),
            array('type'=>'module', 'name'=>'mod_spmoviedb_movie'),
            array('type'=>'module', 'name'=>'mod_spmoviedb_search'),
            array('type'=>'module', 'name'=>'mod_spmoviedb_tab'),
            array('type'=>'plugin', 'name'=>'spmoviedbupdater', 'group'=>'system')
            );

        foreach ($extensions as $key => $extension) {
            $ext = $parent->getParent()->getPath('source') . '/' . $extension['type'] . 's/' . $extension['name'];
            $installer = new JInstaller;
            $installer->install($ext);

            if($extension['type'] == 'plugin') {
                $db = JFactory::getDbo();
                $query = $db->getQuery(true); 
                
                $fields = array($db->quoteName('enabled') . ' = 1');
                $conditions = array(
                    $db->quoteName('type') . ' = ' . $db->quote($extension['type']), 
                    $db->quoteName('element') . ' = ' . $db->quote($extension['name']),
                    $db->quoteName('folder') . ' = ' . $db->quote($extension['group'])
                    );

                $query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions); 
                $db->setQuery($query);
                $db->execute();
            }
        }
    }
}