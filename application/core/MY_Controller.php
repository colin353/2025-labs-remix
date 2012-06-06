<?php

class MY_Controller extends CI_Controller {
	public $menu;
	public $selected;
	
	public function __constructor() {
		parent::__construct();
		$this->has_permission = false;
		$this->selected = '';
		$this->menu = array();
		
		
		
	}
	
	public function permission($level) {
		$retval = false;
	
		if($level == 'public') {
			$retval = true;
		}
		else if($level == 'user') {
			if($this->session->userdata('loggedin')) $retval = true;
		} 
		else if($level == 'admin') {
			// Is this user admin?
		}
		
		return $this->has_permission = $retval;
		
	}
	
	public function menu($obj) {
		$this->menu = $obj;	
	}
	
	public function selectMenuItem($string) {
		$this->selected = $string;
	}
	
	public function renderMenu() {
		return $this->load->view('menu',array('menu'=>$this->menu,'selected'=>$this->selected),true);
	}
	
	public function show($p,$data=null) {
		
		// Register that the user has accessed a page:
		
		$b = array( 
			'activity'=>date('Y-m-d H:i:s', time())
		);
		
		if(isLoggedIn()) $this->db->where('id',$this->session->userdata('id'))->update('users',$b);
		
		// Go ahead and show the page:
		
		if(!isset($this->has_permission) || !$this->has_permission) redirect(base_url()."welcome/login");
		else {
			$this->load->view('header',array('menu'=>$this->renderMenu()));
			$data['base_url'] = $this->config->item('base_url');
			$this->load->view($p,$data);
			$this->load->view('footer');
		}
	}
}


?>