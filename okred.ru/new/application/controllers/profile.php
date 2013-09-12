<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

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
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library("ulogin");
        $this->load->model("model_global_var");
    }

    public function logout() {
    	$this->load->library('user_agent');
    	$this->session->unset_userdata('logged_in');
    	redirect($this->agent->referrer());
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */