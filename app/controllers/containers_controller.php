<?php

/**
 * ContainersController
 * 
 * @package ucis_v5
 * @author Behailu
 * @copyright 2011
 * @version $Id$
 * @access public
 */
class ContainersController extends AppController {

	var $name = 'Containers';
	
	function index() {
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = ($_REQUEST['start'] != '') ? $_REQUEST['start'] : 0;
		$limit = ($_REQUEST['limit'] != '') ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';
        
        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('containers', $this->Container->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Container->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid container', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Container->recursive = 2;
		$this->set('container', $this->Container->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Container->create();
			$this->autoRender = false;
			if ($this->Container->save($this->data)) {
				$this->Session->setFlash(__('The container has been saved', true));
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The container could not be saved. Please, try again.', true));
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid container', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Container->save($this->data)) {
				$this->Session->setFlash(__('The container has been saved', true));
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The container could not be saved. Please, try again.', true));
				$this->render('/elements/success');
			}
		}
		$this->set('container', $this->Container->read(null, $id));	
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for container', true));
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Container->delete($i);
                }
				$this->Session->setFlash(__('Container deleted', true));
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Container was not deleted', true));
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Container->delete($id)) {
				$this->Session->setFlash(__('Container deleted', true));
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Container was not deleted', true));
				$this->render('/elements/failure');
			}
        }
	}
	
	function __permitted($controllerName, $actionName) {
        //Ensure checks are all made lower case
        $controllerName = strtolower($controllerName);
        $actionName = strtolower($actionName);
		
		//...then build permissions array and cache it
        $permissions = array();
        //If permissions have not been cached to session...
        if (!$this->Session->check('Permissions')) {
            $thisGroups = array();
			
            if($this->Session->check('Auth')){
                //everyone gets permission to logout
                $permissions[] = 'users:logout';
                $permissions[] = 'users:welcome';
                $permissions[] = 'users:change_password';
				
                //Import the User Model so we can build up the permission cache
                App::import('Model', 'User');
                $thisUser = new User;
                //Now bring in the current users full record along with groups 
                $thisGroups = $thisUser->find(array('User.id' => $this->Session->read('Auth.User.id')));
                $thisGroups = $thisGroups['Group'];
            } else {
                App::import('Model', 'Group');
                $group = new Group;
                $thisGs = $group->find('all', array('conditions' => array('Group.name' => 'Guest')));
                
                foreach($thisGs as $thisG) {
                    $thisGroups[] = array('id' => $thisG['Group']['id']);
                }
            }
            
            foreach ($thisGroups as $thisGroup) {
                App::import('Model', 'Group');
                $group = new Group;
                $thisPermissions = $group->find(array('Group.id' => $thisGroup['id']));
                $thisPermissions = $thisPermissions['Permission'];
                foreach ($thisPermissions as $thisPermission) {
                    $permissions[] = $thisPermission['name'];
                }
            }
            //write the permissions array to session
            $this->Session->write('Permissions', $permissions);
        } else {
            //...they have been cached already, so retrieve them
            $permissions = $this->Session->read('Permissions');
        }
        //Now iterate through permissions for a positive match
        foreach ($permissions as $permission) {
            if ($permission == '*') {
                return true; //Super Admin Bypass Found
            }
            if (strtolower($permission) == $controllerName . ':*') {
                return true; //Controller Wide Bypass Found
            }
            if (strtolower($permission) == $controllerName . ':' . $actionName) {
                return true; //Specific permission found
            }
        }
        return false;
    }
	
	function active_containers() {
		$permittedContainers = array();
           
		$this->loadModel('Link');
		$controllerList = Configure::listObjects('controller');
		
		$containers = $this->Container->find('all', array('order' => 'Container.list_order ASC'));

		foreach ($containers as $container) {
			$permittedContainer = array('name' => $container['Container']['name'], 'links' => array());
			$links = $this->Link->find('all',
			     array('conditions' => array('container_id' => $container['Container']['id']), 'order' => 'Link.list_order ASC'));
			foreach ($links as $link) {
				if ($this->__permitted($link['Link']['controller'],
								$link['Link']['action'])) {
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
		$this->Session->write('PermittedContainers', $permittedContainers);
	}
    
    function public_containers() {
		if($this->params['isAjax'])
			$this->layout = 'ajax';
			
		$permittedContainers = array();
            
		$this->loadModel('Link');
		$controllerList = Configure::listObjects('controller');
		
		$containers = $this->Container->find('all', array('conditions' => array('is_public' => 'true'), 'order' => 'Container.list_order ASC'));

		foreach ($containers as $container) {
			$permittedContainer = array('name' => $container['Container']['name'], 'links' => array());
			$links = $this->Link->find('all',
			     array('conditions' => array('container_id' => $container['Container']['id']), 'order' => 'Link.list_order ASC'));
			
			foreach ($links as $link) {
				$permittedContainer['links'][] = array('name' => $link['Link']['name'],
						'controller' => $link['Link']['controller'],
						'action' => $link['Link']['action'],
						'parameter' => $link['Link']['parameter']);
			}
			$permittedContainers[] = $permittedContainer;
		} 
		$this->set('permittedContainers', $permittedContainers);
		$this->Session->write('PermittedContainers', $permittedContainers);
	}
}
?>