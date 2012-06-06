<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class People extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		
	}
	
	function index() {
		$this->permission('user');
		$this->selectMenuItem('people');
		
		$users = $this->db->get('users')->result_array();
		$people = array();
		foreach($users as $u) {
			$people[] = new User($u['id']);
		}
	
		
		$this->show('collaborate/people',array('people'=>$people));
	}
}