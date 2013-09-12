<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

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

    public function stat() {
		if(isset($_GET['type']) && $_GET['type'] == 'ajax')
        {
        	$response = array(
                'error'=>false,
                'content'=>'',
                'yandexResults'=>'',
                'googleResults'=>'',
            );
            $query = isset($_GET['query']) ? $_GET['query'] : null;
            $page = isset($_GET['page']) ? (int)$_GET['page'] - 1 : 0;
            $what = isset($_GET['what']) ? $_GET['what'] : null;

            if($what == 'yandex_results' || $what == 'all')
            {
            	$this->load->model("model_yandex_search");
            	$validate = $this->model_yandex_search->validate($query);
            	$response = $this->model_yandex_search->request($query,$page);
            	echo json_encode($response);
            }    
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */