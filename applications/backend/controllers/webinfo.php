<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webinfo extends CI_Controller {

    private $property;

    public function __construct()
    {
            parent::__construct();
            $this->load->model("websettings_model");
            $this->load->model("users_model");
    }

    private function getproperty($params)
    {
        $this->webproperty = $this->websettings_model->read($params);
        $this->userproperty = $this->users_model->read($params);

        foreach($this->webproperty as $row)
        {
            $this->property['title'] = $row->title;
            $this->property['favicon'] = $row->favicon_url;
            $this->property['hometext'] = $row->homescreen_text;
        }

        foreach($this->userproperty as $row)
        {
            $this->property['userid'] = $row->userid;
            $this->property['username'] = $row->username;
            $this->property['last_activity'] = $row->last_logout_at;
            $this->property['last_activity_on'] = $row->login_on_ip;
        }
    }

    public function index()
    {
        if($this->session->userdata('logged') === false)
        {
            $this->load->helper("captcha");
                $vals = array(
                    'img_path' => './assets/captcha/',
                    'img_url' => base_url().'assets/captcha/',
                    //'font_path' => './system/fonts/impact.ttf',
                    'img_width' => '200',
                    'img_height' => 40,
                    'expiration' => 3600,
                    'word' => substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, 6)
                );
                $cap = create_captcha($vals);
                $currentcaptcha = array(
                    "captchatime"=>time(),
                    "ipaddress"=>$_SERVER['REMOTE_ADDR'],
                    "exptime"=>time() + $vals['expiration'],
                    "word"=>$cap['word'],
                    "captcha"=>$cap['image']
                );
                $this->captcha_model->delete($currentcaptcha);
                $this->captcha_model->create(array(
                        "captchatime"=>$currentcaptcha['captchatime'],
                        "ipaddress"=>$currentcaptcha['ipaddress'],
                        "exptime"=>$currentcaptcha['exptime'],
                        "word"=>$currentcaptcha['word']
                    )
                );
                $this->load->view("loginpage", $currentcaptcha);
        }
        else
        {
            if($this->session->userdata('logged'))
            {
                $this->getproperty(array(
                        "userid"=>$this->session->userdata('userid')
                    )
                );
                $this->loadformdata(array("userid"=>$this->session->userdata('userid')));
                $this->load->view("webinfopage", $this->property);
            }
        }
    }

    public function savedata()
    {
        $save = 0;
        $params = array(
            "websettings"=>array(
                "userid"=>$this->input->post('_userid'),
                "title"=>$this->input->post('_title'),
                //"favicon_url"=>'',
                "homescreen_text"=>$this->input->post('_hometext')
            ),
            "users"=>array(
                "userid"=>$this->input->post('_userid'),
                "username"=>$this->input->post('_username'),
                "password"=>$this->input->post('_pass1'),
                "enc_password"=>md5($this->input->post('_pass1')),
                "email"=>$this->input->post('_email'),
            )
        );
        if(isset($_FILES))
        {
            if(!empty($_FILES['_favicon']['name']))
            {
                $config['upload_path'] = "./assets/uploads/";
                $config['allowed_types'] = "jpeg|jpg|png|gif";
                $config['max_size'] = 1024;
                $config['max_width'] = 32;
                $config['max_height'] = 32;

                $name = $_FILES['_favicon']['name'];
                $fileNameParts =  explode(".", $name);
                $default_name = $fileNameParts[0];
                $config['file_name'] = $default_name;

                if(!file_exists($config['upload_path'].$name))
                {
                    $this->load->library("upload", $config);
                    if($this->upload->do_upload("_favicon"))
                    {
                        $params['websettings']['favicon_url'] = base_url()."assets/uploads/".$name;
                    }
                }
            }
        }
        $save += $this->saveinfoweb($params['websettings']);
        $save += $this->saveinfouser($params['users']);
        
        $response = array(
                "title"=>$this->property['title'],
                "favicon"=>$this->property['favicon'],
                "username"=>$this->property['username']
            );
        
        if($save > 0)
        {
            $response["type"] = "INFO_PAGE";
            $response["module"] = "Informasi Website";
            $response["message"] = "Data berhasil disimpan.";
            $response["backlink"] = base_url()."backend.php/webinfo/";
        }
        else
        {
            $response["type"] = "ERR_PAGE";
            $response["module"] = "Informasi Website";
            $response["message"] = "Data gagal disimpan.";
            $response["backlink"] = "javascript:history.back()";
        }
        $this->load->view("messagepage", $response);
    }
    
    private function saveinfoweb($data)
    {
        $view = $this->websettings_model->read(array("userid"=>$data['userid']));
        $save = 0;
        if(count($view) > 0)
        {
            $save = $this->websettings_model->update($data);
        }
        else
        {
            $save = $this->websettings_model->create($data);
        }
        
        return $save;
    }
    
    private function saveinfouser($data)
    {
        $view = $this->users_model->read(array("userid"=>$data['userid']));
        $save = 0;
        if(count($view) > 0)
        {
            $save = $this->users_model->update($data);
        }
        else
        {
            $save = $this->users_model->create($data);
        }
        
        return $save;
    }
        
    private function loadformdata($params)
    {
        $result = $this->users_model->read($params);
        if(count($result) == 0)
        {
            $this->property['password'] = "";
            $this->property['email'] = "";
        }
        else
        {
            foreach($result as $row)
            {
                $this->property['password'] = $row->password;
                $this->property['email'] = $row->email;
            }
        }
    }
    
    /*private function uploadicon()
    {
        $config['upload_path'] = base_url()."assets/uploads/";
        $config['allowed_types'] = "jpeg|jpg|png|gif";
        $config['max_size'] = 1024;
        $config['max_width'] = 32;
        $config['max_height'] = 32;
        
        $name = $_FILES['_favicon']['name'];
        $fileNameParts =  explode(".", $name);
        $default_name = $fileNameParts[0];
        $config['file_name'] = $default_name;
        
        $this->load->library("upload", $config);
        if(!$this->upload->do_upload("_favicon"))
        {
            return null;
        }
        else
        {
            return $config['upload_path'].$name;
        }
    }*/
}

/* End of file webinfo.php */
/* Location: ./applications/backend/controllers/webinfo.php */
