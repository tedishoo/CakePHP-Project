<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class BackOfficeController extends AppController {
    public $name = 'BackOffice';
    public $uses = array();

    public function index() {
        $this->layout = 'main';
        $permittedContainers = array();
        $this->loadModel('Link');
        $this->loadModel('Container');
        //$controllerList = Configure::listObjects('controller');
        $containers = $this->Container->find('all', array('order' => 'Container.list_order ASC'));
        foreach ($containers as $container) {
            $permittedContainer = array('name' => $container['Container']['name'], 'links' => array());
            $links = $this->Link->find('all', array('conditions' => array('container_id' => $container['Container']['id']), 'order' => 'Link.list_order ASC'));
            foreach ($links as $link) {
                if ($this->__permitted($link['Link']['controller'], $link['Link']['action'])) {
                    $permittedContainer['links'][] = array('name' => $link['Link']['name'],
                        'controller' => $link['Link']['controller'],
                        'action' => $link['Link']['action'],
                        'parameter' => $link['Link']['parameter'],
                        'function_name' => $link['Link']['function_name']);
                }
            }
            $permittedContainers[] = $permittedContainer;
        }

        $this->set('permittedContainers', $permittedContainers);
    }

}

?>
