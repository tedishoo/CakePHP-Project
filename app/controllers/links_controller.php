<?php

class LinksController extends AppController {

    var $name = 'Links';

    function index() {
        $containers = $this->Link->Container->find('all');
        $this->set(compact('containers'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = ($_REQUEST['start'] != '') ? $_REQUEST['start'] : 0;
        $limit = ($_REQUEST['limit'] != '') ? $_REQUEST['limit'] : 5;
        $container_id = (isset($_REQUEST['container_id'])) ? $_REQUEST['container_id'] : -1;
        if ($id)
            $container_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($container_id != -1) {
            $conditions['Link.container_id'] = $container_id;
        }

        $this->set('links', $this->Link->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->Link->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid link', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Link->recursive = 2;
        $this->set('link', $this->Link->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->Link->create();
            $this->autoRender = false;
            if ($this->Link->save($this->data)) {
                $this->Session->setFlash(__('The link has been saved', true));
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The link could not be saved. Please, try again.', true));
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $containers = $this->Link->Container->find('list');
        $this->set(compact('containers'));
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid link', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Link->save($this->data)) {
                $this->Session->setFlash(__('The link has been saved', true));
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The link could not be saved. Please, try again.', true));
                $this->render('/elements/success');
            }
        }
        $this->set('link', $this->Link->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $containers = $this->Link->Container->find('list');
        $this->set(compact('containers'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for link', true));
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Link->delete($i);
                }
                $this->Session->setFlash(__('Link deleted', true));
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Link was not deleted', true));
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Link->delete($id)) {
                $this->Session->setFlash(__('Link deleted', true));
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Link was not deleted', true));
                $this->render('/elements/failure');
            }
        }
    }

}

?>