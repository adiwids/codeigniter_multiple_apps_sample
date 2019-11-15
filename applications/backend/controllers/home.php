<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

        private $property;
    
        public function __construct()
        {
                parent::__construct();
                $this->load->model("websettings_model");
                $this->load->model("users_model");
                $this->load->model("posts_model");
                $this->load->model("library_model");
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
                    $this->loadformdata(array("stricttag"=>"__home__"));
                    $this->getproperty(array(
                            "userid"=>$this->session->userdata('userid')
                        )
                    );
                    $this->load->view("homepage", $this->property);
                }
            }
	}
        
	public function savedata()
	{
            $post_date = date("Y-m-d H:i:s");
            $params = array(
                "title"=>"Beranda",
                "tag"=>"__home__",
                "created_at"=>$post_date,
                "last_updated_at"=>$post_date,
                "published"=>true,
                "created_by"=>$this->session->userdata('userid'),
                "content"=>$this->input->post('_bio'),
                "attachmentid"=>$this->input->post("_attachment")
            );
            
            // upload foto/gambar
            if(isset($_FILES))
            {
                if(!empty($_FILES['_photo']['name']))
                {
                    $config['upload_path'] = "./assets/uploads/home/";
                    $config['allowed_types'] = "jpeg|jpg|png|gif";
                    $config['max_size'] = 1024*5;
                    $config['max_width'] = 1024;
                    $config['max_height'] = 768;

                    $name = urlencode($_FILES['_photo']['name']);
                    $fileNameParts =  explode(".", $name);
                    $default_name = $fileNameParts[0];
                    $config['file_name'] = $default_name;

                    $this->load->library("upload", $config);
                    if(!file_exists("./assets/uploads/home/".$name))
                    {
                        if($this->upload->do_upload("_photo"))
                        {
                            $attachment = array(
                                "itemid"=>$this->input->post("attachment"),
                                "caption"=>"",
                                "file_url"=>base_url()."assets/uploads/home/".$name,
                                "file_ext"=>$fileNameParts[1],
                                "uploaded_at"=>date("Y-m-d H:i:s")
                            );
                            
                            // save attachment (libraries)
                            if(!empty($attachment['itemid']))
                            {
                                $this->library_model->update($attachment);
                                $pars = array();
                                if(!empty($attachment["attachmentid"]))
                                {
                                    $pars = array("attachmentid"=>$attachment["attachmentid"]);
                                }
                                else
                                {
                                    $pars = array("url"=>$attachment['file_url']);
                                }
                                $params['attachmentid'] = $this->library_model->getrecordid($pars);
                            }
                            else
                            {
                                $this->library_model->create($attachment);
                                $params['attachmentid'] = $this->library_model->getrecordid(array("url"=>$attachment['file_url']));
                            }
                        }
                    }
                }
            }
            
            $view = $this->posts_model->read(array("stricttag"=>$params['tag']));
            $save = 0;
            if(count($view) > 0)
            {
                $about = $view[0];
                $params['postid'] = $about->postid;
                $save = $this->posts_model->update(array(
                        "postid"=>$params['postid'],
                        "title"=>$params['title'],
                        "last_updated_at"=>$params['last_updated_at'],
                        "created_by"=>$params['created_by'],
                        "content"=>$params['content'],
                        "attachmentid"=>$params['attachmentid']
                    )
                );
            }
            else
            {
                $save = $this->posts_model->create($params);
            }

            $response = array(
                "title"=>$this->property['title'],
                "favicon"=>$this->property['favicon'],
                "username"=>$this->property['username']
            );
        
            if($save > 0)
            {
                $response["type"] = "INFO_PAGE";
                $response["module"] = "Beranda";
                $response["message"] = "Data berhasil disimpan.";
                $response["backlink"] = base_url()."backend.php/home/";
            }
            else
            {
                $response["type"] = "ERR_PAGE";
                $response["module"] = "Beranda";
                $response["message"] = "Data gagal disimpan.";
                $response["backlink"] = "javascript:history.back()";
            }
            $this->load->view("messagepage", $response);
	}
        
        private function loadformdata($params)
        {
            $result = $this->posts_model->read($params);
            if(count($result) == 0)
            {
                $this->property['postid'] = "";
                $this->property['imgphoto'] = "";
                $this->property['content'] = "";
                $this->property['attachmentid'] = "";
            }
            else
            {
                foreach($result as $row)
                {
                    $this->property['postid'] = $row->postid;
                    $this->property['content'] = $row->content;
                    $this->property['attachmentid'] = $row->attachmentid;
                }
                $attachments = $this->library_model->read(array("itemid"=>$this->property['attachmentid']));
                if(count($attachments) > 0)
                {
                    foreach($attachments as $row)
                    {
                        $this->property['imgphoto'] = $row->file_url;
                        $this->property['caption'] = $row->caption;
                    }
                }
                else
                {
                    $this->property['imgphoto'] = "";
                    $this->property['caption'] = "";
                }
            }
        }
        
        /*private function uploadattachment($files)
        {
            $config['upload_path'] = "./assets/uploads/";
            $config['allowed_types'] = "jpeg|jpg|png|gif";
            $config['max_size'] = 1024*5;
            $config['max_width'] = 1024*999;
            $config['max_height'] = 768*999;

            $name = $files['_photo']['name'];
            $fileNameParts =  explode(".", $name);
            $default_name = $fileNameParts[0];
            $config['file_name'] = $default_name;

            $this->load->library("upload", $config);
            if(!$this->upload->do_upload("_photo"))
            {
                return $this->upload->display_errors();
            }
            else
            {
                return $config['upload_path'].$name;
            }
        }*/
}

/* End of file home.php */
/* Location: ./applications/backend/controllers/home.php */
