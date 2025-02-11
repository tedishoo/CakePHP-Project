<?php

class UsersController extends AppController {

    var $name = 'Users';

    function index() {
        $people = $this->User->Person->find('all');
        $this->set(compact('people'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");

        $conditions['User.username <>'] = 'admin';

        $this->set('users', $this->User->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->User->find('count', array('conditions' => $conditions)));
    }

    function list_data3($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        $stu_stu_ids = array();
        $stu_ids = array();
        $this->loadModel('StudentInformation');
        $student_ids = $this->StudentInformation->find('all');

        foreach ($student_ids as $student_id) {
            $stu_stu_ids[] = $student_id['StudentInformation']['student_id'];
        }
        eval("\$conditions = array( " . $conditions . " );");
        if ($id) {
            $conditions['Student.college_id'] = $id;
            $conditions['NOT'] = array('Student.id' => $stu_stu_ids);
        }
        $this->loadModel('Student');
        $students = $this->Student->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));

        foreach ($students as $student) {
            $stu_ids[] = $student['Student']['user_id'];
        }
        //eval("\$conditions = array( " . $conditions . " );");
        $conditions = array('User.id' => $stu_ids);

        $this->set('users', $this->User->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->User->find('count', array('conditions' => $conditions)));
    }

    function list_data2($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;

        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($id) {
            $conditions['Group.id'] = $id;
            $users = $this->User->Group->find('first', array('conditions' => $conditions, 'recursive' => 2, 'limit' => $limit, 'offset' => $start));
            $users = $users['User'];
            $this->set('users', $users);
            $this->set('results', count($users));
        } else {
            $this->set('users', $this->User->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
            $this->set('results', $this->User->find('count', array('conditions' => $conditions)));
        }
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid user', true), '');
            $this->redirect(array('action' => 'index'));
        }
        $this->User->recursive = 2;
        $this->set('user', $this->User->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->autoRender = false;
            if (!isset($this->data['Group'])) {
                $this->Session->setFlash(__('You should select at least one group to the user.', true), '');
                $this->render('/elements/failure');
            } else {				
                $groups = $this->data['Group'];

                $this->data['Group'] = array('Group' => array());
                foreach ($groups as $key => $value) {
                    $this->data['Group']['Group'][] = $key;
                }

                // create the person record.
                $this->User->Person->create();
                if ($this->User->Person->save(array('Person' => $this->data['Person']))) {
                    // prepare the user data to include the Group HABTM associated data.
                    $user_data = array('User' => $this->data['User'], 'Group' => $this->data['Group']);
                    $user_data['User']['person_id'] = $this->User->Person->id;
                    // create the user record.
                    $this->User->create();
                    $user_data['User']['email'] = strtolower($user_data['User']['email']);
                    if ($this->User->save($user_data)) {
                        $this->Session->setFlash(__('The user has been saved', true));
                        $this->render('/elements/success');
                    } else {
						echo 'heloo';
                        $this->Session->setFlash(__('The user could not be saved. Please, try again.' . $this->User->validationErrors, true), '');
                        $this->render('/elements/failure');
                    }
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.' . $this->User->Person->validationErrors, true), '');
                    $this->render('/elements/failure');
                }
            }
        }
        $this->set('birth_locations', $this->User->Person->BirthLocation->generatetreelist(null, null, null, '---'));
        $this->set('residence_locations', $this->User->Person->ResidenceLocation->generatetreelist(null, null, null, '---'));
        $this->set('groups', $this->User->Group->find('list', array('conditions' => array(), 'order' => 'name ASC')));
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid user', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if (!isset($this->data['Group'])) {
                $this->Session->setFlash(__('You should select at least one group to the user.', true), '');
                $this->render('/elements/failure');
            } else {
                $groups = $this->data['Group'];
                $this->data['Group'] = array('Group' => array());
                foreach ($groups as $key => $value) {
                    $this->data['Group']['Group'][] = $key;
                }
                // update the person record.
                if ($this->User->Person->save(array('Person' => $this->data['Person']))) {
                    // prepare the user data to include the Group HABTM associated data.
                    if (isset($this->data['User']['new_password']) && $this->data['User']['new_password'] != '')
                        $this->data['User']['password'] = $this->Auth->password($this->data['User']['new_password']);

                    $user_data = array('User' => $this->data['User'], 'Group' => $this->data['Group']);
                    // update the user record with the related Group records.
                    if ($this->User->save($user_data)) {
                        $this->Session->setFlash(__('The user has been saved', true), '');
                        $this->render('/elements/success');
                    } else {
                        $this->Session->setFlash(__('The user could not be saved. Please, try again.', true), '');
                        $this->render('/elements/failure');
                    }
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.', true), '');
                    $this->render('/elements/failure');
                }
            }
        }

        $this->set('user', $this->User->read(null, $id));
        
        $this->set('birth_locations', $this->User->Person->BirthLocation->generatetreelist(null, null, null, '---'));
        $this->set('residence_locations', $this->User->Person->ResidenceLocation->generatetreelist(null, null, null, '---'));
        $this->set('groups', $this->User->Group->find('list', array('conditions' => array(), 'order' => 'name ASC')));
    }

    function edit_profile() {
        if (!empty($this->data)) {
            $this->autoRender = false;

            if ($this->data['User']['old_password'] != '' && $this->data['User']['new_password'] != '' &&
                    $this->data['User']['confirm_password'] != '') {
                if ($this->Session->read('Auth.User.password') != $this->Auth->password($this->data['User']['old_password'])) {
                    $this->Session->setFlash(__('Password incorrect. Please correct it and try again.', true), '');
                    $this->render('/elements/failure');
                    return;
                } elseif ($this->data['User']['new_password'] != $this->data['User']['confirm_password']) {
                    $this->Session->setFlash(__('Password confirmation mismatch. Please correct it and try again.', true), '');
                    $this->render('/elements/failure');
                    return;
                } else {
                    $this->data['User']['password'] = $this->Auth->password($this->data['User']['new_password']);
                    $this->Session->write('Auth.User.password', $this->data['User']['password']);
                }
            }
            unset($this->data['User']['old_password']);
            unset($this->data['User']['new_password']);
            unset($this->data['User']['confirm_password']);

            // update the person record.
            if ($this->User->Person->save(array('Person' => $this->data['Person']))) {
                // prepare the user data to include the Group HABTM associated data.
                $user_data = array('User' => $this->data['User']);
                // update the user record with the related Group records.
                if ($this->User->save($user_data)) {
                    $this->Session->setFlash(__('The user has been saved', true), '');
                    $this->render('/elements/success');
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.', true), '');
                    $this->render('/elements/failure');
                }
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $id = $this->Session->read('Auth.User.id');
        $this->set('user', $this->User->read(null, $id));

        $this->set('birth_locations', $this->User->Person->BirthLocation->generatetreelist(null, null, null, '---'));
        $this->set('residence_locations', $this->User->Person->ResidenceLocation->generatetreelist(null, null, null, '---'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        $this->loadModel('Person');
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for user', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Person->delete($i);
                }
                $this->Session->setFlash(__('User deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('User was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Person->delete($id)) {
                $this->Session->setFlash(__('User deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('User was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

    function login() {
        $this->autoRender = false;
        //$this->log('About to loggin');
		$user = $this->User->find('first', array('conditions' => array('User.username' => $this->data['User']['username'])));
		if(!empty($user) and $user['User']['lock'] != 'true'){
			$l = $this->User->find('count', array('conditions' => array('User.username' => $this->data['User']['username'], 'User.password' => $this->Auth->password($this->data['User']['passwd']))));
			if ($l) {
				$this->Session->destroy();
				$this->Session->write('Auth', $this->User->find('first', array('conditions' => array('User.username' => $this->data['User']['username']))));
				//$this->log(pr($this->Session->read('Auth'), true));
				$this->User->id = $user['User']['id'];					
				$this->User->saveField('lock', null);
				$this->render('/elements/success');
			} else {			
				
				if($user['User']['lock'] == 2){
					$this->User->id = $user['User']['id'];					
					$this->User->saveField('lock', 'true');
				}
				else{
					$this->User->id = $user['User']['id'];					
					$this->User->saveField('lock', $user['User']['lock']+1);
				}				
				
				$this->Session->setFlash(__('Login failed, Username or password is incorrect!', true), '');
				//$this->log(pr($l, true));
				$this->render('/elements/failure');
			}
		}
		else{
			
			$this->Session->setFlash(__('Username Locked!', true), '');
			$this->render('/elements/failure');
			
		}
			
    }

    function logout() {
        $this->autoRender = false;
        $this->Session->destroy();
        $this->Auth->logout();
        $this->render('/elements/success');
    }

    function forgot_pwd() {
        if (!empty($this->data)) {
            $this->autoRender = false;
            $l = $this->User->find('count', array('conditions' => array('User.username' => $this->data['User']['username'], 'User.security_question' => $this->data['User']['security_question'], 'User.security_answer' => $this->data['User']['security_answer'])));
            if ($l) {
                $u = $this->User->find('first', array('conditions' => array('User.username' => $this->data['User']['username'])));
                $new_pwd = substr(md5($this->data['User']['username'] . time()), 0, 10);

                $this->log('Password of user ' . $this->data['User']['username'] . ' is changed to ' . $new_pwd . '.');

                // save new password
                $this->User->read(null, $u['User']['id']);
                $this->User->set('password', $this->Auth->password($new_pwd));
                $this->User->save();

                // send the email
                @mail($u['User']['email'], 'Your NMA Account', '
				Hi ' . $u['Person']['first_name'] . ' ' . $u['Person']['last_name'] . '
				
				You have asked us to give a new password on ' . date('F, d, Y @ h:i:s A') . ' because you lost your password. 
				As per your request, we have sent this message to your email with your new password. 
				Please, change your password in your first logon.
				
				New Password: ' . $new_pwd . '
				
				------------------------------
				If you are not ' . $u['Person']['first_name'] . ' and received this message, 
				please not give attention to and not reply to the mail. Thanks
				
				------------------------------
				If you are ' . $u['Person']['first_name'] . ' and not asked for password and received this message,
				please inform your administrator in order to solve the problem.
				
				
				Best Regards
				NMA Web-master.
				
				');

                $this->Session->setFlash(__('Thanks, Your new password is sent to your email.', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Login failed, Username or password is incorrect!', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}

?>