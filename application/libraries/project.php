<?php

class Project {
	
	var $id,$name,$creationdate,$description,$entity;
	
	public function __construct($id=0) {
		$CI = &get_instance();
		
		if($CI->db->where('id',$id)->get('projects')->num_rows() == 0)
		{
			return false;
		}
		
		$u = $CI->db->where('id',$id)->get('projects')->row_array();
		
		foreach(explode(" ","id name creationdate description entity") as $e) $this->{$e} = $u[$e];
		
		$this->creationdate = strtotime($this->creationdate);
		
	}
	
	public function renderColourBox() {
		return "<div class=colourbox style='background-color: #{$this->colour}'></div>";
	}
	
	
	
	

}

