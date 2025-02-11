<?php

class PermissionsController extends AppController {

    var $name = 'Permissions';

    function index() {
        
    }

    function search() {
        
    }

    function list_data() {
        $permissions = $this->Permission->find('all', array('order' => 'Permission.lft ASC'));
        $tree_data = array();
        if (count($permissions) > 0) {
            $tree_data = array($this->__getTreeArray($permissions[0], $permissions));
        }
        $this->set('permissions', $tree_data);
    }

    function list_data2($group_id = null) {
        $permissions = $this->Permission->find('all', array('order' => 'Permission.lft ASC'));
        $tree_data = array();
        $sps = array();
        if ($group_id) {
            $sel_permissions = $this->Permission->Group->read(null, $group_id);
            $sel_permissions = $sel_permissions['Permission'];
            foreach ($sel_permissions as $sp) {
                $sps[] = $sp['id'];
            }
        }

        if (count($permissions) > 0) {
            $tree_data = array($this->__getTreeArray2($permissions[0], $permissions));
        }
        $this->set('permissions', $tree_data);
        $this->set('sel_permissions', $sps);
    }

    function list_data3($group_id = null) {
        $sel_permissions = $this->Permission->Group->read(null, $group_id);
        $this->set('sel_permissions', $sel_permissions);
    }

    function __getTreeArray($node, $adata) {
        $mynode = array();
        $mynode = array(
            'id' => $node['Permission']['id'],
            'name' => $node['Permission']['name'],
            'description' => $node['Permission']['description'],
            'prerequisite' => ($node['Permission']['prerequisite'] > 0) ? $node['PrerequisitePermission']['name'] : ' ',
            'children' => array());
        $children = $this->__getChildNodes($node['Permission']['id'], $adata);
        foreach ($children as $child) {
            $mynode['children'][] = $this->__getTreeArray($child, $adata);
        }
        return $mynode;
    }

    function __getTreeArray2($node, $adata) {
        $mynode = array();
        $mynode = array(
            'id' => $node['Permission']['id'],
            'name' => $node['Permission']['name'],
            'description' => $node['Permission']['description'],
            'prerequisite' => $node['Permission']['prerequisite'],
            'prerequisite2' => ($node['Permission']['prerequisite'] > 0) ? $node['PrerequisitePermission']['name'] : 'None',
            'children' => array());
        $children = $this->__getChildNodes($node['Permission']['id'], $adata);
        foreach ($children as $child) {
            $mynode['children'][] = $this->__getTreeArray2($child, $adata);
        }
        return $mynode;
    }

    function __getChildNodes($p_id, $adata) {
        $ret = array();
        foreach ($adata as $ad) {
            if ($ad['Permission']['parent_id'] == $p_id) {
                $ret[] = $ad;
            }
        }
        return $ret;
    }

    function add($id = null) {
        if (!empty($this->data)) {
            if (!isset($this->data['Permission']['prerequisite']) ||
                    $this->data['Permission']['prerequisite'] == null)
                $this->data['Permission']['prerequisite'] = 0;

            $this->Permission->create();
            $this->autoRender = false;
            if ($this->Permission->save($this->data)) {
                $this->Session->setFlash(__('The permission has been saved', true));
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The permission could not be saved. Please, try again.', true));
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);

        $prerequisites = $this->Permission->find('list', array('conditions' => array('Permission.name LIKE' => '%:%'), 'order' => 'name ASC'));
        $this->set(compact('prerequisites'));
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid permission', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if (!isset($this->data['Permission']['prerequisite']) ||
                    $this->data['Permission']['prerequisite'] == null)
                $this->data['Permission']['prerequisite'] = 0;
            if ($this->Permission->save($this->data)) {
                $this->Session->setFlash(__('The permission has been saved', true));
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The permission could not be saved. Please, try again.', true));
                $this->render('/elements/failure');
            }
        }
        $this->set('permission', $this->Permission->read(null, $id));

        $prerequisites = $this->Permission->find('list', array('conditions' => array('Permission.name LIKE' => '%:%'), 'order' => 'name ASC'));
        $this->set(compact('prerequisites'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for permission', true));
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Permission->delete($i);
                }
                $this->Session->setFlash(__('Permission deleted', true));
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Permission was not deleted', true));
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Permission->delete($id)) {
                $this->Session->setFlash(__('Permission deleted', true));
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Permission was not deleted', true));
                $this->render('/elements/failure');
            }
        }
    }
}

?>