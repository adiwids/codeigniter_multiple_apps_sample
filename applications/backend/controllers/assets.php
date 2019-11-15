<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets extends CI_Controller {

        private $property;
    
        public function __construct()
        {
                parent::__construct();
                $this->load->model("websettings_model");
                $this->load->model("users_model");
                $this->load->model("asset_model");
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
                    $this->load->view("assetpage", $this->property);
                }
            }
	}
        
	public function savedata()
	{
            $params = array(
                "assetid"=>$this->input->post("_assetid"),
                "code"=>$this->input->post("_code"),
                "name"=>$this->input->post("_name")
            );
            
            // upload foto/gambar
            $upload = false;
            if(isset($_FILES))
            {
                if(!empty($_FILES['_photo']['name']))
                {
                    $config['upload_path'] = "./assets/uploads/asset/";
                    $config['allowed_types'] = "jpeg|jpg|png|gif";
                    $config['max_size'] = 1024*5;
                    $config['max_width'] = 1024;
                    $config['max_height'] = 768;

                    $name = $_FILES['_photo']['name'];
                    $fileNameParts =  explode(".", $name);
                    //$default_name = $fileNameParts[0];
                    $config['file_name'] = $params['code'];
                    $filename = $config['file_name'].".".$fileNameParts[1];

                    $this->load->library("upload", $config);
                    if(!file_exists($config['upload_path'].$filename))
                    {
                        if($this->upload->do_upload("_photo"))
                        {
                            $params['img_url'] = base_url()."assets/uploads/asset/".$filename;
                        }
                    }
                }
            }
            
            $save = 0;
            if(!is_null($params['assetid']) && !empty($params['assetid']))
            {
                $save = $this->asset_model->update($params);
            }
            else
            {
                $save = $this->asset_model->create($params);
            }
            

            $response = array(
                "title"=>$this->property['title'],
                "favicon"=>$this->property['favicon'],
                "username"=>$this->property['username']
            );
        
            if($save > 0)
            {
                $response["type"] = "INFO_PAGE";
                $response["module"] = "Entry Mesin";
                $response["message"] = "Data berhasil disimpan.";
                $response["backlink"] = base_url()."backend.php/assets/";
            }
            else
            {
                $response["type"] = "ERR_PAGE";
                $response["module"] = "Entry Mesin";
                $response["message"] = "Data gagal disimpan.";
                $response["backlink"] = "javascript:history.back()";
            }
            $this->load->view("messagepage", $response);
	}
        
        public function getgridrecords()
        {
            $html = "";
            $records = $this->asset_model->read(array(
                "name"=>$this->input->get("name")
                    )
                );
            
            $recordno = 0;
            foreach($records as $row)
            {
                $recordno++;
                $rowcssclass = $recordno % 2 == 0 ? "gray" : "dark-gray";
                $html .= "<tr class='row-data ".$rowcssclass."' id='".$row->assetid."'>";
                $html .= "<td class='row-number'>".$recordno."</td>";
                $html .= "<td class='cell-data'>".$row->code."</td>";
                $html .= "<td class='cell-data'>".$row->name."</td>";
                $html .= "<td class='row-plugin'><input type='button' class='row-edit' value='Edit' onclick='loaddatafromgrid(".$row->assetid.")' /></td>";
                $html .= "</tr>";
            }
            
            if(empty($html))
            {
                $html .= "<tr class='row-data'>";
                $html .= "<td class='row-number' colspan='4'>Tidak ada record data.</td>";
                $html .= "</tr>";
            }
            
            echo $html;
        }
        
        public function getrecord()
        {
            $records = $this->asset_model->read(array("assetid"=>$this->input->get('_assetid')));
            if(count($records) > 0)
            {
                foreach($records as $row)
                {
                    $data= array(
                        "_assetid"=>$row->assetid,
                        "_code"=>$row->code,
                        "_name"=>$row->name,
                        "_imgphoto"=>$row->img_url,
                    );
                }
            }
            else
            {
                $data= array(
                        "_assetid"=>"",
                        "_code"=>"",
                        "_name"=>"",
                        "_imgphoto"=>"",
                    );
            }
            
            echo json_encode($data);
        }
        
        public function deletedata()
        {
            $params = array(
                "assetid"=>$this->input->post("_assetid"),
                "code"=>$this->input->post("_code"),
                "name"=>$this->input->post("_name"),
                "img_url"=>$this->input->post("_imgphoto")
            );
            $files = explode("/", $params['img_url']);
            $filename = $files[count($files) - 1];
            if(strpos($filename, "?"))
            {
                list($filename, $timestamp) = explode("?", $filename, 2);
            }
            
            if(file_exists("./assets/uploads/asset/".$filename))
            {
                unlink("./assets/uploads/asset/".$filename);
            }
            $view = $this->asset_model->read(array(
                    "assetid"=>$params['assetid'],
                    "code"=>$params['code']
                )
            );
            $delete = 0;
            if(count($view) > 0)
            {
                $delete = $this->asset_model->delete(array(
                        "assetid"=>$params['assetid']
                    )
                );
            }
            $response = array(
                "title"=>$this->property['title'],
                "favicon"=>$this->property['favicon'],
                "username"=>$this->property['username']
            );
        
            if($delete > 0)
            {
                $response["type"] = "INFO_PAGE";
                $response["module"] = "Entry Mesin";
                $response["message"] = "Data berhasil dihapus.";
                $response["backlink"] = base_url()."backend.php/assets/";
            }
            else
            {
                $response["type"] = "ERR_PAGE";
                $response["module"] = "Entry Mesin";
                $response["message"] = "Data gagal dihapus.";
                $response["backlink"] = "javascript:history.back()";
            }
            $this->load->view("insetmessagepage", $response);
        }
        
        public function getassetcombo()
        {
            $records = $this->asset_model->read(null);
            if(count($records) > 0)
            {
                $i = 0;
                foreach($records as $row)
                {
                    $data[$i]= array(
                        "_assetid"=>$row->assetid,
                        "_code"=>$row->code,
                        "_name"=>$row->name,
                        "_imgphoto"=>$row->img_url,
                    );
                    $i++;
                }
            }
            else
            {
                $data[0]= array(
                        "_assetid"=>"",
                        "_code"=>"",
                        "_name"=>"",
                        "_imgphoto"=>"",
                    );
            }
            
            echo json_encode($data);
        }
}

/* End of file assets.php */
/* Location: ./applications/backend/controllers/assets.php */
