<?php

class AppController extends Controller {

    public $components = array('Auth', 'Session', 'RequestHandler');
    public $helpers = array('ExtForm', 'Html', 'Javascript', 'Session', 'Text');

    /**
     * beforeFilter
     *
     * Application hook which runs prior to each controller action
     *
     * @access public
     */
    function beforeFilter() {
        //Create a global variable for views to use to send java script snippets to the browser
        $this->set('scripts_for_view', '');
        //Override default fields used by Auth component
        $this->Auth->fields = array('username' => 'username', 'password' => 'password');
        //Set application wide actions which do not require authentication
        $this->Auth->allow('display', 'about', 'logout', 'active_containers', 'edit_profile'); //IMPORTANT for CakePHP 1.2 final release change this to $this->Auth->allow(array('display'));
        //Set the default redirect for users who logout
        $this->Auth->logoutRedirect = '/';
        //Set the default redirect for users who login
        $this->Auth->loginRedirect = '/';
        //Extend auth component to include authorization via isAuthorized action
        $this->Auth->authorize = 'controller';
        //Restrict access to only users with an active account
        $this->Auth->userScope = array('User.is_active = 1');
        //Pass auth component data over to view files
        $this->layout = 'login';

        if (!defined('FILES_DIR'))
            define('FILES_DIR', WWW_ROOT . 'files' . DS);
    }

    /**
     * isAuthorized
     *
     * Called by Auth component for establishing whether the current authenticated
     * user has authorization to access the current controller:action
     *
     * @return true if authorised / false if not authorized
     * @access public
     */
    function isAuthorized() {
        return $this->__permitted($this->name, $this->action);
    }

    function isApplicable($actionName) {
        return true;
    }

    /**
     * __permitted
     *
     * Helper function returns true if the currently authenticated user has permission
     * to access the controller:action specified by $controllerName:$actionName
     * @return
     * @param $controllerName Object
     * @param $actionName Object
     */
    function __permitted($controllerName, $actionName) {
        //Ensure checks are all made lower case
        $controllerName = strtolower(Inflector::underscore($controllerName));
        $actionName = strtolower($actionName);
        //...then build permissions array and cache it
        $permissions = array();
        //If permissions have not been cached to session...
        if (!$this->Session->check('Permissions')) {
            $thisGroups = array();
            if ($this->Session->check('Auth')) {
                //everyone gets permission to logout
                $permissions[] = 'users:logout';
                $permissions[] = 'users:welcome';
                $permissions[] = 'users:change_password';
                $permissions[] = 'back_office:*';

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

                foreach ($thisGs as $thisG) {
                    $thisGroups[] = array('id' => $thisG['Group']['id']);
                }
            }

            foreach ($thisGroups as $thisGroup) {
                $thisPermissions = $thisUser->Group->find(array('Group.id' => $thisGroup['id']));
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

    function CleanData($str = '') {
        return str_replace("'", "\\'", $str);
    }

}

?>