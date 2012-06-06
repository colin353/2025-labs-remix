<?php

class Discussion {
	
	var $id,$subject,$participants,$entity;
	
	public function __construct($id=0) {
		$CI = &get_instance();
		
		if($CI->db->where('id',$id)->get('discussions')->num_rows() == 0)
		{
			return false;
		}
		
		$u = $CI->db->where('id',$id)->get('discussions')->row_array();
		
		foreach(explode(" ","id subject participants entity") as $e) $this->{$e} = $u[$e];
		
		$this->participants = json_decode($this->participants,true);
		
	}
	
	public function getParticipants() {
		$part = array();
		foreach($this->participants as $p) $part[] = new User($p);
		return $part;
	}	

}