<?php
class WebFoldersController extends AppController {

	var $name = 'WebFolders';
	var $uses = array();
	
	function index() {
	}
	
	function list_data($id = null) {
		$app_dir = str_replace(':', '__c__', APP);
		$app_dir = str_replace(DS, '__d__', $app_dir);
		$web_folders = array('name' => 'app', 'id' => substr($app_dir, 0, strlen($app_dir) - 5));

		$tree_data = array();
		$tree_data = array($this->__getTreeArray($web_folders));
		$this->set('web_folders', $tree_data);
	}
	
	function __getTreeArray($node){
            $mynode = array(
                    'id' => $node['id'], 
                    'name' => $node['name'], 
                    'children' => array());
            $children = $this->__getChildNodes($node['id']);
            foreach($children as $child) {
                    $mynode['children'][] = $this->__getTreeArray($child);
            }
            return $mynode;
	}

	function __getChildNodes($p_node) {
            $ret = array();
            // Open a known directory, and proceed to read its contents
            $sub_folders = array();
            $dir = str_replace('__c__', ':', $p_node);
            $dir = str_replace('__d__', DS,$dir);

            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {
                    while (($file = readdir($dh)) !== false) {
                                    if($file != '.' && $file != '..' && filetype($dir . DS . $file) == 'dir')
                            $sub_folders[] = array('id' => $p_node . '__d__' . $file, 'name' => $file);
                    }
                    closedir($dh);
                }
            }
            return $sub_folders;
	}
	
	function upload($id) {
		$this->layout = 'add_form_layout';
		
		if(!empty($this->data)){
			$dir = str_replace('__c__', ':', $id);
			$dir = str_replace('__d__', DS, $dir);
			
			$file = $this->data['upload_file'];
            $file_name = $file['name'];
            if(move_uploaded_file($file['tmp_name'], $dir . DS . $file_name)) {
				$this->Session->setFlash(__('The file ' . $file_name . ' has been uploaded successfully', true), '');
				$this->render('/elements/success2');
			} else {
				$this->Session->setFlash(__('The file ' . $file_name . ' could not be uploaded. Please, try again.', true), '');
				$this->render('/elements/failure2');
			}
		}
		$this->set('id', $id);
	}
	
	function upload_special() {
		$this->layout = 'add_form_layout';
		
		if(!empty($this->data)){
			$dir = str_replace('__c__', ':', $this->data['in_dir']);
			$dir = str_replace('__d__', DS, $dir);
			
			$file = $this->data['upload_file'];
            $file_name = $file['name'];
            if(move_uploaded_file($file['tmp_name'], $dir . DS . $file_name)) {
				$this->Session->setFlash(__('The file ' . $file_name . ' has been uploaded successfully', true), '');
				$this->render('/elements/success2');
			} else {
				$this->Session->setFlash(__('The file ' . $file_name . ' could not be uploaded. Please, try again.', true), '');
				$this->render('/elements/failure2');
			}
		}
	}
	
	function create_dir($id) {
		if(!empty($this->data)){
			$dir = str_replace('__c__', ':', $id);
			$dir = str_replace('__d__', DS, $dir);
			
			$new_dir = $this->data['new_dir'];
			
			if(mkdir($dir . DS . $new_dir)) {
				$this->Session->setFlash(__('The directory ' . $new_dir . ' has been created successfully', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The directory ' . $new_dir . ' could not be created. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('id', $id);
	}
	
	function create_dir_special() {
		if(!empty($this->data)){
			$dir = str_replace('__c__', ':', $this->data['in_dir']);
			$dir = str_replace('__d__', DS, $dir);
			
			$new_dir = $this->data['new_dir'];
			
			if(mkdir($dir . DS . $new_dir)) {
				$this->Session->setFlash(__('The directory ' . $new_dir . ' has been created successfully', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The directory ' . $new_dir . ' could not be created. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}
	
	function web_files($id) {
		$dir = str_replace('__c__', ':', $id);
		$dir = str_replace('__d__', DS, $dir);
		
		$web_files = array();
		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if($file != "." && $file != ".." && !is_dir($dir . DS . $file))
					$web_files[] = $file;
			}
			closedir($handle);
		}
		$this->set('web_files', $web_files);
		$this->set('id', $id);
	}
}
?>