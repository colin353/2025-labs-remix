<?php

class User {
	
	var $id,$firstname,$lastname,$email,$colour,$username,$name;
	
	public function __construct($id=0) {
		$CI = &get_instance();
		
		if($id == 0) 
			$id = $CI->session->userdata('id');
		
		if($CI->db->where('id',$id)->get('users')->num_rows() == 0)
		{
			return false;
		}
		
		$u = $CI->db->where('id',$id)->get('users')->row_array();
		
		foreach(explode(" ","id firstname lastname username email colour") as $e) $this->{$e} = $u[$e];
		
		$this->name = $this->firstname." ".$this->lastname;
		
	}
	
	public function renderColourBox() {
		return "<span class=colourbox style='background-color: #{$this->colour}'> </span>";
	}		

}

