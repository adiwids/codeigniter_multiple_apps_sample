<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
        
    private $property;

    public function __construct()
    {
            parent::__construct();
            $this->load->model("websettings_model");
            $this->load->model("users_model");
            $this->load->model("captcha_model");
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
            //$this->load->library("captchasession");
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
                $this->load->view("mainpage", $this->property);
            }
        }
    }

    public function login()
    {
            $captcha = $this->captcha_model->read(array(
                    "ipaddress"=>$_SERVER["REMOTE_ADDR"],
                    "word"=>$this->input->post("_captchacode")/*,
                    "inputtime"=>time()*/
                )
            );

            if(count($captcha) > 0)
            {
                $params = array(
                    "strictuname"=>$this->input->post('_username'),
                    "enc_password"=>md5($this->input->post('_password'))
                );
                $result = $this->users_model->read($params);
                if(count($result) > 0)
                {
                    $userlogged = $result[0];
                    $login_date = date("Y-m-d H:i:s");
                    $login = $this->users_model->update(array(
                                "userid"=>$userlogged->userid,
                                "last_login_at"=>$login_date,
                                "login_on_ip"=>$_SERVER["REMOTE_ADDR"]
                            )
                        );
                    $this->session->set_userdata(array(
                                "logged"=>($login == 1) ? true : false,
                                "sessid"=>hash("sha256", $userlogged->username."@".$_SERVER["REMOTE_ADDR"]),
                                "userid"=>$userlogged->userid,
                                "username"=>$userlogged->username,
                                "datetime"=>$login_date,
                                "host"=>$_SERVER["REMOTE_ADDR"]
                            )
                        );
                    $this->getproperty(array(
                            "userid"=>$this->session->userdata('userid')
                        )
                    );

                    $this->load->view("mainpage", $this->property);
                }
                else
                {
                    $result = $this->users_model->read(array("strictuname"=>$params['strictuname']));
                    $response = array(
                        "title"=>$this->property['title'],
                        "favicon"=>$this->property['favicon'],
                        "username"=>$this->property['username']
                    );
                    $response["type"] = "ERR_PAGE";
                    $response["module"] = "Log In";
                    $response["message"] = "Nama pengguna dan/atau password salah.";
                    if(count($result) == 0)
                    {
                        $response["type"] = "ERR_PAGE";
                        $response["module"] = "Log In";
                        $response["message"] = "Nama pengguna tidak terdaftar";
                    }
                    $this->load->view("loginpage", $response);
                }
            }
            else
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
                $response = array(
                    "title"=>$this->property['title'],
                    "favicon"=>$this->property['favicon'],
                    "username"=>$this->property['username']
                );
                $response["type"] = "ERR_PAGE";
                $response["module"] = "Log In";
                $response["message"] = "Kode captcha salah.";
                $response["captcha"] = $currentcaptcha['captcha'];
                $this->load->view("loginpage", $response);
            }
    }

    public function logout()
    {
        $logout_date = date("Y-m-d H:i:s");
        $logout = $this->users_model->update(array(
                    "userid"=>$this->session->userdata('userid'),
                    "last_login_at"=>$logout_date
                )
            );
        if($logout == 1)
        {
            $this->session->sess_destroy();
            $this->session->set_userdata(array(
                    "logged"=>false,
                    "sessid"=>null,
                    "userid"=>null,
                    "username"=>null,
                    "datetime"=>null,
                    "host"=>null
                )
            );
        }
        redirect(base_url()."backend.php/main");
    }
}

/* End of file main.php */
/* Location: ./applications/backend/controllers/main.php */
