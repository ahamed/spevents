<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');

class com_spmedicalInstallerScript {

    public function uninstall($parent) {

        $extensions = array(
            array('type'=>'module', 'name'=>'mod_spmedical_search'),
            array('type'=>'module', 'name'=>'mod_spmedical_services'),
            array('type'=>'module', 'name'=>'mod_spmedical_specialists'),
            array('type'=>'plugin', 'name'=>'spmedicalupdater')
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
            array('type'=>'module', 'name'=>'mod_spmedical_search'),
            array('type'=>'module', 'name'=>'mod_spmedical_services'),
            array('type'=>'module', 'name'=>'mod_spmedical_specialists'),
            array('type'=>'plugin', 'name'=>'spmedicalupdater', 'group'=>'system')
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
