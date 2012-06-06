<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timeline extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->library('STTimeline');
	}
	
	function display() { return $this->index(); }
	
	function index() {
		$this->permission('user');
		
		if($this->uri->segment(4) != '') $arg = $this->uri->segment(4);
		else $arg = 1;
		
		$c = new STEntity($arg);
		
		if($this->uri->segment(5) != '') $c->searchKeywords = urldecode($this->uri->segment(5));
		
		if(isset($_POST['ajax'])) $this->load->view('collaborate/timeline',array('c'=>$c,'ajax'=>true));
		else $this->show('collaborate/timeline',array('c'=>$c,'ajax'=>false));
	}
	
	
	
}