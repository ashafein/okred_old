<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

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


	public function index()
	{
		$data = $this->model_global_var->get_full();
		$data["content"] = $this->load->view("serach_form",'',TRUE);

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$this->parser->parse("welcome_message_blank",$data);
		}
		else {
			$this->parser->parse("welcome_message",$data);
		}
	}

	public function get_serial() {
		$s = 0;
		include "simple_html_dom.php";
		$html = file_get_html('http://kino-dom.tv/?do=archive');
		foreach($html->find('a[class=showfull]') as $element) 
       	{
     		echo "<hr><b>";
       		echo $element->href . '</b><br>';
			$html_category_link = file_get_html('http://kino-dom.tv'.$element->href);
			echo "<hr />";
			foreach($html_category_link->find('li a') as $element_serial_list) 
       		{
       			$serial_name = $element_serial_list->href;
       			if(intval($serial_name[0]) > 0) {
       				echo $serial_name.'<br />';
       				$s++;
       			}
       		}
       	}
   		echo "Сериалов:".$s;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */