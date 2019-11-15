<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends CI_Controller {

        private $property;
    
        public function __construct()
        {
                parent::__construct();
                $this->load->model("websettings_model");
                $this->load->model("users_model");
                $this->load->model("asset_model");
                $this->load->model("captcha_model");
                $this->load->model("schedule_model");
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
                    $this->load->view("schedulepage", $this->property);
                }
            }
	}
        
	public function savedata()
	{
            $params = array(
                "scheduleid"=>$this->input->post('_schedid'),
                "schedule_date"=>$this->input->post('_scheddate'),
                "assetid"=>$this->input->post('_assetid'),
                "notes"=>$this->input->post('_notes'),
                "type"=>  intval($this->input->post('_type'))
            );
            
            // upload foto/gambar
            $upload = false;
            if(isset($_FILES))
            {
                if(!empty($_FILES['_attachment']['name']))
                {
                    $config['upload_path'] = "./assets/uploads/schedule/";
                    $config['allowed_types'] = "jpeg|jpg|png|gif|xls|xlsx";
                    $config['max_size'] = 1024*50;
                    $config['max_width'] = 1024;
                    $config['max_height'] = 768;

                    // url friendly file name
                    $name = urlencode($_FILES['_attachment']['name']);
                    $fileNameParts =  explode(".", $name);
                    $newid = $this->schedule_model->getnewid();
                    $config['file_name'] = implode("_", array(
                        $params['schedule_date'],$params['type'],$params['assetid'],$newid
                    ));
                    $filename = $config['file_name'].".".$fileNameParts[count($fileNameParts) - 1];
                    
                    $this->load->library("upload", $config);
                    if(file_exists($config['upload_path'].$filename))
                    {
                        unlink($config['upload_path'].$filename);
                    }
                    if($this->upload->do_upload("_attachment"))
                    {
                        $params['file_url'] = base_url()."assets/uploads/schedule/".$filename;
                    }
                }
            }
            /*if(isset($_FILES))
            {
                if(!empty($_FILES['_attachment']['name']))
                {
                    $config['upload_path'] = "./assets/uploads/schedule/";
                    $config['allowed_types'] = "jpeg|jpg|png|gif|xls|xlsx";
                    $config['max_size'] = 1024*5;
                    $config['max_width'] = 1024;
                    $config['max_height'] = 768;

                    $name = urlencode($_FILES['_attachment']['name']);
                    $fileNameParts =  explode(".", $name);
                    //$default_name = $fileNameParts[0];
                    $tmp_id = empty($params['scheduleid']) ? "x" : $params['scheduleid'];
                    $config['file_name'] = $tmp_id."_".$params['type']."_".$params['schedule_date'];
                    $filename = $config['file_name'].".".$fileNameParts[1];

                    $this->load->library("upload", $config);
                    if(file_exists($config['upload_path'].$filename))
                    {
                        unlink($config['upload_path'].$filename);
                    }
                    if($this->upload->do_upload("_attachment"))
                    {
                        $params['file_url'] = base_url()."assets/uploads/schedule/".$filename;
                    }
                }
            }*/
            
            $save = 0;
            if(!is_null($params['scheduleid']) && !empty($params['scheduleid']))
            {
                $save = $this->schedule_model->update($params);
            }
            else
            {
                $save = $this->schedule_model->create($params);
            }
            

            $response = array(
                "title"=>$this->property['title'],
                "favicon"=>$this->property['favicon'],
                "username"=>$this->property['username']
            );
        
            if($save > 0)
            {
                $response["type"] = "INFO_PAGE";
                $response["module"] = "Entry Jadwal";
                $response["message"] = "Data berhasil disimpan.";
                $response["backlink"] = base_url()."backend.php/schedule/";
            }
            else
            {
                $response["type"] = "ERR_PAGE";
                $response["module"] = "Entry Jadwal";
                $response["message"] = "Data gagal disimpan.";
                $response["backlink"] = "javascript:history.back()";
            }
            $this->load->view("messagepage", $response);
	}
        
        public function getgridrecords()
        {
            $html = "";
            $records = $this->schedule_model->schedulelist(array(
                        "name"=>$this->input->get("name"),
                        "notes"=>$this->input->get("name")
                    )
                );
            
            $recordno = 0;
            foreach($records as $row)
            {
                $recordno++;
                $rowcssclass = $recordno % 2 == 0 ? "gray" : "dark-gray";
                $html .= "<tr class='row-data ".$rowcssclass."' id='".$row->scheduleid."'>";
                $html .= "<td class='row-number'>".$recordno."</td>";
                $html .= "<td class='cell-data'>".$row->schedule_date."</td>";
                $html .= "<td class='cell-data'>".$row->asset."</td>";
                $html .= "<td class='cell-data'>".$row->notes."</td>";
                $html .= "<td class='cell-data'>".$row->tipe."</td>";
                $html .= "<td class='row-plugin'><input type='button' class='row-edit' value='Edit' onclick='loaddatafromgrid(".$row->scheduleid.")' /></td>";
                $html .= "</tr>";
            }
            
            if(empty($html))
            {
                $html .= "<tr class='row-data'>";
                $html .= "<td class='row-number' colspan='6'>Tidak ada record data.</td>";
                $html .= "</tr>";
            }
            
            echo $html;
        }
        
        public function getrecord()
        {
            $records = $this->schedule_model->schedulelist(array(
                        "scheduleid"=>$this->input->get("_scheduleid")
                    )
                );
            if(count($records) > 0)
            {
                foreach($records as $row)
                {
                    $data= array(
                        "_scheduleid"=>$row->scheduleid,
                        "_schedule_date"=>$row->schedule_date,
                        "_assetid"=>$row->assetid,
                        "_asset"=>$row->asset,
                        "_type"=>$row->type,
                        "_tipe"=>$row->tipe,
                        "_file_url"=>$row->file_url,
                        "_notes"=>$row->notes
                    );
                }
            }
            else
            {
                $data= array(
                        "scheduleid"=>"",
                        "schedule_date"=>"",
                        "assetid"=>"",
                        "asset"=>"",
                        "type"=>"",
                        "tipe"=>"",
                        "file_url"=>"",
                        "notes"=>""
                    );
            }
            
            echo json_encode($data);
        }
        
        public function deletedata()
        {
            $params = array(
                "scheduleid"=>$this->input->post("_scheduleid"),
                "file_url"=>$this->input->post("_attachment")
            );
            if(!is_null($params['file_url']))
            {
                $files = explode("/", $params['file_url']);
                $filename = $files[count($files) - 1];
                if(strpos($filename, "?"))
                {
                    list($filename, $timestamp) = explode("?", $filename, 2);
                }

                if(file_exists("./assets/uploads/schedule/".$filename))
                {
                    unlink("./assets/uploads/schedule/".$filename);
                }
            }
            $view = $this->schedule_model->read(array(
                    "scheduleid"=>$params['scheduleid']
                )
            );
            $delete = 0;
            if(count($view) > 0)
            {
                $delete = $this->schedule_model->delete(array(
                        "scheduleid"=>$params['scheduleid']
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
                $response["module"] = "Entry Jadwal";
                $response["message"] = "Data berhasil dihapus.";
                $response["backlink"] = base_url()."backend.php/schedule/";
            }
            else
            {
                $response["type"] = "ERR_PAGE";
                $response["module"] = "Entry Jadwal";
                $response["message"] = "Data gagal dihapus.";
                $response["backlink"] = "javascript:history.back()";
            }
            $this->load->view("insetmessagepage", $response);
        }
}

/* End of file schedule.php */
/* Location: ./applications/backend/controllers/schedule.php */
