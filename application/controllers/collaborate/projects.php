<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends MY_Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$this->permission('user');
		$this->selectMenuItem('projects');
		
		$projectz = $this->db->get('projects')->result_array();
		$projects = array();
		foreach($projectz as $p) {
			$projects[] = new Project($p['id']);
		}
		$this->show('collaborate/projects',array('projects'=>$projects));
	}
	
	function add() {
		$this->permission('user');
		$this->selectMenuItem('projects');
		
		$this->show('collaborate/projects/add');
	}
	
	function create() {
		if(!$this->permission('user')) return;
		
		$name = $_POST['name'];
		$this->db->insert('projects',array(
			'name'=>$name
		));
		
		redirect(base_url()."collaborate/projects");
				
	}
}