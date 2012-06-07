<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
		parent::__construct();
	}
	 
	public function lost() {
		
	}
	
	public function cron() {
		$this->permission('public');
		// Check IP address!
		
		$this->load->library('email');
	
		$users = $this->db->select('id')->get('users')->result_array();
	
		$u = new User(1);

		$this->email->set_newline("\r\n");
		
		/*
		
			Future Colin:
			
			Your next course of action is to develop the string specifier in the
			database which describes decendancy of STEntity objects and place the
			construction of this string in the STEntity->applyChanges() function.
			
			Then, once you have that, you'll be able to detect heredity and sort 
			recently-created entities into bins: one for each project and one for
			general events that were not descendants of projects.
			
			Additionally, you'll be able to paginate the timeline using more 
			efficient MySQL queries, and have scroll-based pagination like tumblr.		
		
		*/
		
		
		/*$this->email->from('robot@2025-labs.com','Staff Robot');
		$this->email->to($u->email);
		$this->email->subject('2025-labs.com Digest: '.date('l jS F Y'));
		
		$this->email->message($this->load->view('collaborate/digestemail'),array('user'=>$u),true);
		
		$this->email->send();
		*/
		
		$this->load->view('collaborate/digestemail',array('user'=>$u));
		
		return;
	}
	
	function upload() {
		if(!array_key_exists('pic',$_FILES) || $_FILES['pic']['error'] != 0) return;
		if(!$this->permission('user')) return;
		
		$z = file_get_contents($_FILES['pic']['tmp_name']);
		
		$file = array(
			'blob'=>$z,
			'author'=>$this->session->userdata('id'),
			'filename'=>$_FILES['pic']['name']
		);
		
		$this->db->insert('files',$file);
		
		echo $this->db->insert_id();
		
		return;
	}
	
	function uploadCaption() {
		if(!$this->permission('user')) return;
		
		$file = array(
			'caption'=>$_POST['caption']
		);
		
		$this->db->where('id',$_POST['blob_id'])->update('files',$file);
		
		$f = new File($_POST['blob_id']);
		$g = new STEntity();
		
		if(get_class($f->getSubType()) == "Photo") {
			$g->descriptor_type = "STPhotoEntity";
		} else $g->descriptor_type  = "STFileEntity";
		
		$g->descriptor_id = $_POST['blob_id'];
		
		$g->context = $_POST['context'];
		
		$g->applyChanges();
		
		echo "I did something? I don't know. {$g->id}";
		
	}
	
	function postcomment() {
		if(!$this->permission('user')) return;
		
		// Validate that shit
		
		if(trim($_POST['message']) == '') return;
		
		// Create and save a new comment.
		
		$c = new Comment();
		$c->text = $_POST['message'];
		$c->author = $this->session->userdata('id');
		$c->applyChanges();
		
		// Now create and save a new entity.
		
		$d = new STEntity();
		$d->descriptor_type = "STCommentEntity"; 
		$d->descriptor_id   = $c->id;
		$d->context 		= $_POST['context'];
		$d->applyChanges();
		
	}	
	
	public function file() {
		$this->permission('user');
		
		$i = new File($this->uri->segment(4));
		
		$i->renderFileBlob();
	}
	
	public function logout() {
		$this->permission('public');
		
		$b = array( 
			'activity'=>date('Y-m-d H:i:s',0)
		);
		
		if(isLoggedIn()) $this->db->where('id',$this->session->userdata('id'))->update('users',$b);
		
		$this->session->sess_destroy();
		redirect(base_url());
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/collaborate.php */