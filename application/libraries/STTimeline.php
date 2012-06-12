<?php

class STTimeline {
	
	function __construct() {
		
	}
	
}

class STEntity {
	
	var $creationdate, $height,$entity,$context;
	var $id,$descriptor;
	var $descriptor_type,$descriptor_id;
	var $searchKeywords;
	var $CI;
	
	function __construct($entity=1) {
		$this->entity = $entity;
		$this->CI = $CI = &get_instance();
		$u = $CI->db->where('id',$entity)->get('entities')->row_array();
		if(empty($u)) throw new Exception("Invalid argument '$entity' provided to STEntity::__construct()");
		
		foreach(explode(" ","id descriptor context creationdate") as $e) $this->{$e} = $u[$e];
		
		$desc = explode("-",$this->descriptor);
		$this->descriptor_type = $desc[0];
		$this->descriptor_id   = $desc[1];
		
		$this->creationdate = strtotime($this->creationdate);
		
		$this->searchKeywords = '';
	}	
	
	function showContext() {
		$b = base_url();
		$c = $this->context;
	
		if($this->id != 1 && $this->context != 1) $retval = <<<HTML
	<a href="{$b}collaborate/timeline/display/{$c}>">(show context)</a>
HTML;
		else $retval = '';
		
		return $retval;
	
	}
	
	function matchKeywords($k) {
		
		
		if(!isset($k) || empty($k)) return true;
		
		if(!is_array($k)) $k = explode(" ",$k);
		$k_t = strtolower(array_shift($k));
		return preg_match("/$k_t/",strtolower($this->getSearchableText())) && $this->matchKeywords($k);
	}
	
	function getSearchableText() {
		return '';
	}
	
	function renderEntity() {
		return "";
	}
	
	function renderMinorEntity() {
		return "";
	}
	
	function getSubEntity() {
		switch($this->descriptor_type) {
			case "STCommentEntity":
				$retval = new STCommentEntity($this->entity);
				break;
			case "STRootEntity":
				$retval = new STRootEntity();
				break;
			case "STDiscussionEntity":
				$retval = new STDiscussionEntity($this->entity);
				break;
			case "STFileEntity":
				$retval = new STFileEntity($this->entity);
				break;
			case "STPhotoEntity":
				$retval = new STPhotoEntity($this->entity);
				break;
			case "STProjectEntity":
				$retval = new STProjectEntity($this->entity);
				break;
			default: 
				return $this;
		}
			// Some things must be inherited
		
		$retval->searchKeywords = $this->searchKeywords;
		
		return $retval;	
	}
	
	function getSubEntities($sort=false) {
		$ents = $this->CI->db->select('id')->where('context',$this->entity)->get('entities')->result_array();
		
		$a = array();
		
		foreach($ents as $e) {
			$e = new STEntity($e['id']);
			$e = $e->getSubEntity();
			$a[] = $e;
			$a = array_merge($a,$e->getSubEntities());
		}
		
		
		$q = array();
		foreach($a as $r=>$s) {
			if($s->matchKeywords($this->searchKeywords)) $q[$r] = $s->creationdate;
		}
		
		if($sort) arsort($q);
		
		$b = array();
		foreach($q as $r=>$s) $b[] = $a[$r];
		
		return $b;
	}	
	
	function applyChanges() {
		$c = array();
		
		if(!empty($this->descriptor_type)) {
			$this->descriptor = $this->descriptor_type .'-'. $this->descriptor_id;
		}
		
		foreach(explode(" ","id descriptor context") as $e) $c[$e] = $this->{$e};
		
		
		$q = new STEntity($this->context);
		
		$c['ancestors'] = 'd'.$this->context.'d';
		
		$count = 0;
		while($q->context != 1 && $count < 100) {
			$count++;
			$c['ancestors'].= $q->context.'d';
			$q = new STEntity($q->context);
		}
		
		if($this->id == 1 || !isset($this->id)) {
			unset($c['id']);
			$this->CI->db->insert('entities',$c);
			$this->id = $this->CI->db->insert_id();
		}
		else 
			$this->CI->db->update('entities',$c);
	}
}

class STCommentEntity extends STEntity {
	
	var $comment;
	
	function __construct($entity=0) {
		parent::__construct($entity);
		if($this->descriptor_type != 'STCommentEntity') throw new Exception('Invalid entity type provided for STCommentEntity::__construct()');
		
		$this->comment = new Comment($this->descriptor_id);
	}
	
	function renderEntity() {
		$author = new User($this->comment->author);
		
		$box = $author->renderColourBox();
		$te = explain_time($this->comment->creationdate);
		
		$retval = <<<HTML

<h2>{$this->comment->text}</h2>
<p><span class=subtext>Posted {$te} by {$box} {$author->name} <span class=subtext>{$this->showContext()}</span></span></p>

HTML;

		return $retval;
	}
	
	function renderMinorEntity() {
		$author = new User($this->comment->author);
		
		$box = $author->renderColourBox();
		
		$time = explain_time($this->comment->creationdate);
		
		$retval = <<<HTML

<p>{$this->comment->text} <span class=subtext>{$box} {$author->name} &nbsp;&nbsp;&nbsp; {$time} </span></p>

HTML;


		return $retval;
	}

	function getSearchableText() {
		$a = new User($this->comment->author);
		return $this->comment->text." ".$a->name;
	}
}

class STRootEntity extends STEntity {
	function renderEntity() {
		
		// Who is online?
		
		$people = "";
		
		foreach(getCurrentlyOnlinePeople() as $p) {
			$people .= "<span class=subtext>{$p->renderColourBox()} {$p->name}</span>";
		}
	
		$retval = <<<HTML

<h2>All site activity.</h2>
<p>Currently online: $people</p>
HTML;

		return $retval;
	}
} 

class STDiscussionEntity extends STEntity {
	
	var $descriptor_id,$discussion;
	
	function __construct($entity) {
		parent::__construct($entity);
		if($this->descriptor_type != 'STDiscussionEntity') throw new Exception('Invalid entity type provided for STDiscussionEntity::__construct()');
				
		$this->discussion = new Discussion($this->descriptor_id);
	}
	
	function getSearchableText() {
		$people = '';
		foreach($this->discussion->getParticipants() as $p) $people .= " {$p->name} ";
		return $this->discussion->subject." $people";
	}
	
	function renderEntity() {
	
		$people = "";
		foreach($this->discussion->getParticipants() as $p) $people .= "<span class=personelement >{$p->renderColourBox()} {$p->name}</span>";
	
		$retval = <<<HTML
<h2>{$this->discussion->subject} </h2>
<span class=subtext>Discussion with {$people}</span>
HTML;

		return $retval;
	}
	
	function renderMinorEntity() {
		$people = "";
		foreach($this->discussion->getParticipants() as $p) $people .= "<span class=personelement >{$p->renderColourBox()} {$p->name}</span>";
	
		$retval = <<<HTML
<p>{$this->discussion->subject} <span class=subtext>Discussion with {$people}</span></p>
HTML;

		return $retval;
	}
	
	
}

class STFileEntity extends STEntity {
	var $file;
	
	function __construct($entity) {
		parent::__construct($entity);
		if($this->descriptor_type != 'STFileEntity' && $this->descriptor_type != 'STPhotoEntity') throw new Exception('Invalid entity type provided for STFileEntity::__construct()');
				
		$this->file = new File($this->descriptor_id);
		
		$this->file = $this->file->getSubType();
		
	}
	
	function renderEntity() {
	
		$a = new User($this->file->author);
		
		$author = "{$a->renderColourBox()} {$a->name}";
		
		$file = $this->file->renderFile();
		
		$retval = <<<HTML
 
<p><div class=imgcontainer-big>{$file}
<p>{$this->file->caption} <span class=subtext>{$author} <span class=subtext>{$this->showContext()}</span></span></p>
</div></p>
HTML;

		return $retval;
	}
	
	function getSearchableText() {
		$a = new User($this->file->author);
		return $this->file->caption." ".$a->name;
	}
	
	function renderMinorEntity() {
		
		$a = new User($this->file->author);
		
		$author = "{$a->renderColourBox()} {$a->name}";
		
		$file = $this->file->renderFile();
		
		$retval = <<<HTML
<p>
<div class=imgcontainer-med>{$file}
<span class=pinline >{$this->file->caption} <span class=subtext>{$author}</span></span>
</div>
</p>
HTML;

		return $retval;
	}
}

class STPhotoEntity extends STFileEntity {
	
	function renderMinorEntity() {
		
	
		$a = new User($this->file->author);
		
		$author = "{$a->renderColourBox()} {$a->name}";
		
		$times = explain_time($this->creationdate);
		
		$file = $this->file->renderFile();
		return <<<HTML

<div class=imgcontainer-med>{$file}
<p>{$this->file->caption} <span class=subtext>{$author}</span><span class=subtext>{$times} </span></p>
</div>

HTML;
	}	
	
}

class STProjectEntity extends STEntity {
	var $project;
	
	function __construct($entity) {
		parent::__construct($entity);
		if($this->descriptor_type != 'STProjectEntity') throw new Exception('Invalid entity type provided for STProjectEntity::__construct()');
				
		$this->project = new Project($this->descriptor_id);
	}
	
	function renderEntity() {
		$desc = limitString($this->project->description,80);
	
		$retval = <<<HTML

<h2>{$this->project->name}</h2>
<span class=subtext>{$desc}</span>
HTML;

		return $retval;
	}	
	
	function getSearchableText() {
		return $this->project->name.' '.$this->project->description;
	}
	
	function renderMinorEntity() {
		$time = explain_time($this->project->creationdate);
	
		$retval = <<<HTML

<p><strong>{$this->project->name}</strong> was created <span class=subtext>$time</span></p>
HTML;
	
		return $retval;
	}
}

class STBlogEntity extends STEntity {
	
}