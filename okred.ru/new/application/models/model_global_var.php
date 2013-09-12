<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_global_var extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_full()
    {
        if($this->session->userdata("logged_in") != TRUE) {
            if($this->ulogin->userdata() != false) {
                //var_dump($this->ulogin->userdata());
                $user_info_data = $this->ulogin->userdata();
                $result = $this->db->where("uid",$user_info_data["uid"])->where("network",$user_info_data["network"])->get("users")->result_array();
                if(count($result) == 0) {
                    $object = array(
                        'network' => $user_info_data["network"],
                        'identity' => $user_info_data["identity"],
                        'email' => $user_info_data["email"],
                        'uid' => $user_info_data["uid"],
                        'last_name' => $user_info_data["last_name"],
                        'first_name' => $user_info_data["first_name"],
                        );
                    $this->db->insert("users",$object);
                    $newdata["user_id"] = $this->db->insert_id();
                    $newdata["last_name"] = $user_info_data["last_name"];
                    $newdata["first_name"] = $user_info_data["first_name"];
                }
                else {
                    $newdata["user_id"] = $result[0]["id"];
                    $newdata["last_name"] = $result[0]["last_name"];
                    $newdata["first_name"] = $result[0]["first_name"];
                }
                $newdata["logged_in"] = TRUE;
                $this->session->set_userdata($newdata);
            }
        }

        if($this->session->userdata("logged_in") != TRUE) {
            $auth_form_in = $this->load->view("logged_in_false",'',TRUE);
            $ulogin_get_html = $this->ulogin->get_html();
            $auth_block_text = "Авторизация";
        }
        else {
            $auth_form_in = $this->load->view("logged_in_true",'',TRUE);
            $ulogin_get_html = "";
            $auth_block_text = $this->session->userdata("first_name")." ".$this->session->userdata("last_name");
        }

        $data["auth_block_text"] = $auth_block_text;
        $data["auth_form_in"] = $auth_form_in;
        $data["ulogin_get_html"] = $ulogin_get_html;
        return $data;
        
        
    }

    public function search() {
        define('DS', DIRECTORY_SEPARATOR);
        define('BASEDIR', dirname(__FILE__));
        define('DEFAULT_ERROR_MESSAGE', 'Сервис временно недоступен.');

        include implode(DS, array(
            BASEDIR, '_php', 'swing', 'Gy.php'
        ));
        include implode(DS, array(
            BASEDIR, '_php', 'db.php'
        ));

        Gy::app(array(
            'debugMode'=>true,
            'developerMode'=>array(
                'state'=>false,
                'ipFilters'=>array(
                    '188.168.92.125',
                    '95.37.81.202',
                ),
            ),
            'charset'=>'utf-8',
            'templatesPath'=>BASEDIR. DS .'_php'. DS .'templates',
            'mainTemplate'=>'layouts'. DS .'index.php',
            'classAutoloadDirs'=>array(
                '_php.controllers',
                '_php.swing',
                '_php',
            ),
            'yandexRequestParams'=>array(
                'host'=>'http://xmlsearch.yandex.com/xmlsearch',
                'user'=>'okred666',
                'key'=>'03.220929676:082022c635db15ee106328c3ac4637ca',
            ),
            'googleRequestParams'=>array(
                'host'=>'http://ajax.googleapis.com/ajax/services/search/web',
                'key'=>'AIzaSyBRwETzaVS-EsPYjFbidXdJjmXJmLm1b2M',
            ),
        ));
    }

}
