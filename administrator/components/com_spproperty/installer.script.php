<?php
/**
* @package     SP Property
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

defined('_JEXEC') or die('Restricted access!');

class com_sppropertyInstallerScript {

    public function uninstall($parent) {

        $extensions = array(
            array('type'=>'module', 'name'=>'mod_spproperty_properties'),
            array('type'=>'module', 'name'=>'mod_spproperty_search'),
            array('type'=>'plugin', 'name'=>'sppropertyupdater')
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
            array('type'=>'module', 'name'=>'mod_spproperty_properties'),
            array('type'=>'module', 'name'=>'mod_spproperty_search'),
            array('type'=>'plugin', 'name'=>'sppropertyupdater', 'group'=>'system')
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