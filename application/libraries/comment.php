<?php

class Comment {

	var $id,$text,$author,$creationdate,$entity;
	var $CI;

	function __construct($id=0) {
		$this->CI = $CI = &get_instance();
		
		
		$u = $CI->db->where('id',$id)->get('comments')->row_array();
		
		if(empty($u)) {	
			$this->entity = 0;
			return;
		}
		else foreach(explode(" ","id text author creationdate entity") as $e) $this->{$e} = $u[$e];
		
		$this->creationdate = strtotime($this->creationdate);
		
	}
	
	function applyChanges() {
		
		$c = array();
		
		foreach(explode(" ","id text author creationdate entity") as $e) $c[$e] = $this->{$e};
		
		if($this->id == 0 || !isset($this->id)) {
			unset($c['id']);
			$this->CI->db->insert('comments',$c);
			$this->id = $this->CI->db->insert_id();
		}
		else 
			$this->CI->db->update('comments',$c);
	}

}