<?php
class LocationsController extends AppController {

	var $name = 'Locations';
	
	function index() {
		
	}

	function search() {
	}
	
	function list_data($id = null) {
		$locations = $this->Location->find('all', array('order' => 'Location.lft ASC'));
		$tree_data = array();
		if(count($locations) > 0) {
			$tree_data = array($this->__getTreeArray($locations[0], $locations));
		}
		$this->set('locations', $tree_data);
	}
	
	function __getTreeArray($node, $adata){
		$mynode = array();
		$mynode = array('id' => $node['Location']['id'], 'name' => $node['Location']['name'],'is_rural' => $node['Location']['is_rural'],  'location_type' => $node['LocationType']['name'], 'children' => array());
		$children = $this->__getChildNodes($node['Location']['id'], $adata);
		foreach($children as $child) {
			$mynode['children'][] = $this->__getTreeArray($child, $adata);
		}
		return $mynode;
	}
	
	function __getChildNodes($p_id, $adata) {
		$ret = array();
		foreach($adata as $ad){
			if($ad['Location']['parent_id'] == $p_id){
				$ret[] =  $ad;
			}
		}
		return $ret;
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid location', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Location->recursive = 2;
		$this->set('location', $this->Location->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Location->create();
			$this->autoRender = false;
			if ($this->Location->save($this->data)) {
				$this->Session->setFlash(__('The location has been saved', true));
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The location could not be saved. Please, try again.', true));
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$this->set('location_types', $this->Location->LocationType->find('list'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid location', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Location->save($this->data)) {
				$this->Session->setFlash(__('The location has been saved', true));
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The location could not be saved. Please, try again.', true));
				$this->render('/elements/failure');
			}
		}
		$this->set('location_types', $this->Location->LocationType->find('list'));
		$this->set('location', $this->Location->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$parentLocations = $this->Location->ParentLocation->find('list');
		$this->set(compact('parentLocations'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for location', true));
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Location->delete($i);
                }
				$this->Session->setFlash(__('Location deleted', true));
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Location was not deleted', true));
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Location->delete($id)) {
				$this->Session->setFlash(__('Location deleted', true));
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Location was not deleted', true));
				$this->render('/elements/failure');
			}
        }
	}
}
?>