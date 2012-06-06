<?php

class MY_Exceptions extends CI_Exceptions {
	
	function __construct() {
		parent::__construct();
	}
	
	function show_404($page='') {
		$this->config =& load_class('Config');		
		header('Location: '.$this->config->item('base_url')."welcome/lost");
        exit;
	}
}
