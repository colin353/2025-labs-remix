<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {

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
				
		if(isLoggedIn() && $this->uri->segment(2)!="lost") redirect(base_url().'collaborate/timeline');
		
	}
	 
	public function index()
	{
		$this->about();
	}
	
	public function contact() {
		$this->permission('public');
		$this->selectMenuItem('contact');
		$this->show('homepage/contact');
	}
	
	public function latest() {
		$this->permission('public');
		$this->selectMenuItem('latest');
		$this->show('homepage/latest');
	}
	
	public function event() {
		$this->permission('public');
		echo exec("C:\wamp\bin\php\php5.3.10\php.exe C:\wamp\www\notify\listen.php test");
		
		echo "test";
		
	}
	
	public function login()
	{
		$this->permission('public');
		$this->selectMenuItem('login');
		$this->show('homepage/login');
	}
	
	public function about() {
		$this->permission('public');
		$this->selectMenuItem('about 2025');
		$this->show('homepage/about');
	}	
	
	public function people() {
		$this->permission('public');
		$this->selectMenuItem('people');
		
		$users = $this->db->get('users')->result_array();
		$people = array();
		foreach($users as $u) {
			$people[] = new User($u['id']);
		}
		
		$this->show('homepage/people',array('people'=>$people));
	}
	
	public function authenticate() {
		// Gets two parameters: username and password. Redirects to another URL if they are correct.
		
		if(!$this->permission('public')) return $this->show('users/signin');
		
		// Did they actually try to sign in?
		if(isset($_POST['username'])) {
			// Yes, they tried
			$pw = md5($this->config->item('password_salt').$_POST['password']);
			$theuser = $this->db->where('username',$_POST['username'])->where('password',$pw)->get('users');
			if($theuser->num_rows() > 0 ) {
				$a = $theuser->row_array();
				$a['loggedin'] = true;
				$this->session->set_userdata($a);
				return redirect('collaborate/timeline');
			} else {
				// you have made an unforgivable mistake
				$this->session->sess_destroy();
				header_note('Login failed',false);
			}
		}
		
		$this->login();
	}
	
	public function lost() { // The 404 page for non-logged in users!	
		if(isLoggedIn()) return redirect(base_url().'collaborate/system/lost');
		$this->permission('public');
		$this->show('homepage/lost');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */