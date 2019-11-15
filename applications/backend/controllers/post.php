<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model("websettings_model");
                $this->load->model("users_model");
                $this->load->model("posts_model");
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
                $this->load->view("loginpage");
            }
            else
            {
                if($this->session->userdata('logged'))
                {
                    //$this->loadformdata(array("stricttag"=>"__about_me__"));
                    $this->getproperty(array(
                            "userid"=>$this->session->userdata('userid')
                        )
                    );
                    $this->load->view("postpage", $this->property);
                }
            }
	}
        
	public function savedata()
	{
            $post_date = date("Y-m-d H:i:s");
            $params = array(
                "tag"=>$this->input->post("_tag"),
                "created_at"=>$post_date,
                "last_updated_at"=>$post_date,
                "published"=>true,
                "created_by"=>$this->session->userdata('username'),
                "content"=>$this->input->post('_bio')
            );
            
            $response = array(
                "title"=>$this->property['title'],
                "favicon"=>$this->property['favicon'],
                "username"=>$this->property['username']
            );
        
            if($save > 0)
            {
                $response["type"] = "INFO_PAGE";
                $response["module"] = "Tentang Saya";
                $response["message"] = "Data berhasil disimpan.";
                $response["backlink"] = base_url()."backend.php/aboutme/";
            }
            else
            {
                $response["type"] = "ERR_PAGE";
                $response["module"] = "Tentang Saya";
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
            }
            else
            {
                foreach($result as $row)
                {
                    $this->property['postid'] = $row->postid;
                    $this->property['imgphoto'] = "";
                    $this->property['content'] = $row->content;
                }
            }
        }
}

/* End of file post.php */
/* Location: ./applications/backend/controllers/post.php */
