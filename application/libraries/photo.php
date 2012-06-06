<?php

class File {
	var $id,$caption,$author,$filename;
	var $CI;
	
	public function __construct($id=0) {
		$CI = &get_instance();
		$this->CI = $CI;
		
		if($CI->db->where('id',$id)->select('id')->get('files')->num_rows() == 0) return false;
		
		$u = $CI->db->where('id',$id)->select('id, caption, author, filename')->get('files')->row_array();
		
		foreach(explode(" ","id caption author filename") as $e) $this->{$e} = $u[$e];
		
	}
	
	public function renderFileBlob() {
		$b = $this->CI->db->where('id',$this->id)->select('blob')->get('files')->row_array();
		
		$ext = pathinfo($this->filename, PATHINFO_EXTENSION);
		
		header('Content-type: image/'.$ext);
		header('Content-Disposition: attachment; filename="'.$this->filename.'"');
		echo $b['blob'];
	}
	
	public function renderFile() {
		return "<a href=".base_url()."collaborate/system/file/{$this->id} >{$this->filename}</a>";
	}
	
	public function getSubType() {
	
		$ext = pathinfo($this->filename, PATHINFO_EXTENSION);
		$allowed_extensions = array('jpg', 'jpeg', 'png', 'gif','bmp');
		$is_photo = false;
		
		foreach($allowed_extensions as $e) if(strtolower($ext) == $e) $is_photo = true;
	
		if($is_photo)
				return new Photo($this->id);
		else
				return new Document($this->id);
	
	}
}


class Photo extends File {
		
	public function renderFile() {
		return "<img src=".base_url()."collaborate/system/file/{$this->id} />";
	}
}


class Document extends File {
	
	public function renderFile() {
	
		$ext = strtolower(pathinfo($this->filename, PATHINFO_EXTENSION));
		$known_extensions = array('ai', 'doc', 'docx', 'pdf','exe','mp3','wav','psd','txt','zip','xls','xlsx');
		$has_ext = false;
		foreach($known_extensions as $e) if($ext == $e) $has_ext = true;
		
		if(!$has_ext) $ext = 'any';
		
		$b = base_url();
		
		return <<<HTML

<img class=filetypeicon src={$b}media/filetypes/{$ext}.gif />
<a href="{$b}collaborate/system/file/{$this->id}" >{$this->filename}</a>
		
HTML;
	}		
	
	
}