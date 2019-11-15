<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maint extends CI_Controller {

        private $property;
        
        public function __construct()
        {
            parent::__construct();
            $this->load->model("websettings_model");
            $this->load->model("schedule_model");
        }
        
	public function index()
	{
                $pid = $this->input->get('pid');
                $this->getschedulelist($pid);
                $this->getwebsettings();
                $this->getperawatanlist();
                $this->getperbaikanlist();
                $this->getpemeliharaanlist();
		$this->load->view("schedulepage", $this->property);
	}
        
        private function getwebsettings()
        {
            $result = $this->websettings_model->read(array(
                "offset"=>0,
                "limit"=>1
                )
            );
            
            if(count($result) > 0)
            {
                foreach($result as $row)
                {
                    $this->property['webtitle'] = $row->title;
                    $this->property['favicon'] = $row->favicon_url;
                }
            }
            else
            {
                $this->property['webtitle'] = "";
                $this->property['favicon'] = "";
            }
        }
        
        public function readpost()
        {
            $pid = $this->input->get('pid');
            $result = $this->schedule_model->schedulelist(array(
                "scheduleid"=>$pid,
                "offset"=>0,
                "limit"=>1
                )
            );
            $i = 0;
            if(count($result) > 0)
            {
                foreach($result as $row)
                {
                    $this->property['schedulelist'][$i]['scheduleid'] = $row->scheduleid;
                    $this->property['schedulelist'][$i]['schedule_date'] = $row->schedule_date;
                    $this->property['schedulelist'][$i]['assetid'] = $row->assetid;
                    $this->property['schedulelist'][$i]['name'] = $row->name;
                    $this->property['schedulelist'][$i]['attachment'] = $row->attachment;
                    $this->property['schedulelist'][$i]['notes'] = $row->notes;
                    $this->property['schedulelist'][$i]['tipe'] = $row->tipe;
                    $this->property['schedulelist'][$i]['type'] = $row->type;
                    
                    if($i < count($result)){ $i++; }
                }
            }
            else
            {
                $this->property['schedulelist'][$i]['scheduleid'] = "";
                $this->property['schedulelist'][$i]['schedule_date'] = "";
                $this->property['schedulelist'][$i]['assetid'] = "";
                $this->property['schedulelist'][$i]['name'] = "";
                $this->property['schedulelist'][$i]['attachment'] = "";
                $this->property['schedulelist'][$i]['notes'] = "";
                $this->property['schedulelist'][$i]['tipe'] = "";
                $this->property['schedulelist'][$i]['type'] = "";
            }
            
            $this->getwebsettings();
            $this->getperawatanlist();
            $this->getperbaikanlist();
            $this->getpemeliharaanlist();
            $this->load->view("scheddetailpage", $this->property);
        }
        
        private function getschedulelist($type)
        {
            $result = $this->schedule_model->schedulelist(array(
                "type"=>$type
                /*"offset"=>0,
                "limit"=>9999*/
                )
            );
            $i = 0;
            if(count($result) > 0)
            {
                foreach($result as $row)
                {
                    $this->property['schedulelist'][$i]['scheduleid'] = $row->scheduleid;
                    $this->property['schedulelist'][$i]['schedule_date'] = $row->schedule_date;
                    $this->property['schedulelist'][$i]['assetid'] = $row->assetid;
                    $this->property['schedulelist'][$i]['name'] = $row->name;
                    $this->property['schedulelist'][$i]['attachment'] = $row->attachment;
                    $this->property['schedulelist'][$i]['notes'] = $row->notes;
                    $this->property['schedulelist'][$i]['tipe'] = $row->tipe;
                    $this->property['schedulelist'][$i]['type'] = $row->type;
                    
                    if($i < count($result)){ $i++; }
                }
            }
            else
            {
                $this->property['schedulelist'][$i]['scheduleid'] = "";
                $this->property['schedulelist'][$i]['schedule_date'] = "";
                $this->property['schedulelist'][$i]['assetid'] = "";
                $this->property['schedulelist'][$i]['name'] = "";
                $this->property['schedulelist'][$i]['attachment'] = "";
                $this->property['schedulelist'][$i]['notes'] = "";
                $this->property['schedulelist'][$i]['tipe'] = "";
                $this->property['schedulelist'][$i]['type'] = "";
            }
        }
        
        private function getperawatanlist()
        {
            $result = $this->schedule_model->schedulelist(array(
                "type"=>1,
                "offset"=>0,
                "limit"=>3
                )
            );
            $i = 0;
            if(count($result) > 0)
            {
                foreach($result as $row)
                {
                    $this->property['rawatlist'][$i]['scheduleid'] = $row->scheduleid;
                    $this->property['rawatlist'][$i]['schedule_date'] = $row->schedule_date;
                    $this->property['rawatlist'][$i]['assetid'] = $row->assetid;
                    $this->property['rawatlist'][$i]['name'] = $row->name;
                    $this->property['rawatlist'][$i]['attachment'] = $row->attachment;
                    $this->property['rawatlist'][$i]['notes'] = $row->notes;
                    $this->property['rawatlist'][$i]['tipe'] = $row->tipe;
                    $this->property['rawatlist'][$i]['type'] = $row->type;
                    
                    if($i < count($result)){ $i++; }
                }
            }
            else
            {
                $this->property['rawatlist'][$i]['scheduleid'] = "";
                $this->property['rawatlist'][$i]['schedule_date'] = "";
                $this->property['rawatlist'][$i]['assetid'] = "";
                $this->property['rawatlist'][$i]['name'] = "";
                $this->property['rawatlist'][$i]['attachment'] = "";
                $this->property['rawatlist'][$i]['notes'] = "";
                $this->property['rawatlist'][$i]['tipe'] = "";
                $this->property['rawatlist'][$i]['type'] = "";
            }
        }
        
        private function getperbaikanlist()
        {
            $result = $this->schedule_model->schedulelist(array(
                "type"=>0,
                "offset"=>0,
                "limit"=>3
                )
            );
            $i = 0;
            if(count($result) > 0)
            {
                foreach($result as $row)
                {
                    $this->property['baiklist'][$i]['scheduleid'] = $row->scheduleid;
                    $this->property['baiklist'][$i]['schedule_date'] = $row->schedule_date;
                    $this->property['baiklist'][$i]['assetid'] = $row->assetid;
                    $this->property['baiklist'][$i]['name'] = $row->name;
                    $this->property['baiklist'][$i]['attachment'] = $row->attachment;
                    $this->property['baiklist'][$i]['notes'] = $row->notes;
                    $this->property['baiklist'][$i]['tipe'] = $row->tipe;
                    $this->property['baiklist'][$i]['type'] = $row->type;
                    
                    if($i < count($result)){ $i++; }
                }
            }
            else
            {
                $this->property['baiklist'][$i]['scheduleid'] = "";
                $this->property['baiklist'][$i]['schedule_date'] = "";
                $this->property['baiklist'][$i]['assetid'] = "";
                $this->property['baiklist'][$i]['name'] = "";
                $this->property['baiklist'][$i]['attachment'] = "";
                $this->property['baiklist'][$i]['notes'] = "";
                $this->property['baiklist'][$i]['tipe'] = "";
                $this->property['baiklist'][$i]['type'] = "";
            }
        }
        
        private function getpemeliharaanlist()
        {
            $result = $this->schedule_model->schedulelist(array(
                "type"=>2,
                "offset"=>0,
                "limit"=>3
                )
            );
            $i = 0;
            if(count($result) > 0)
            {
                foreach($result as $row)
                {
                    $this->property['peliharalist'][$i]['scheduleid'] = $row->scheduleid;
                    $this->property['peliharalist'][$i]['schedule_date'] = $row->schedule_date;
                    $this->property['peliharalist'][$i]['assetid'] = $row->assetid;
                    $this->property['peliharalist'][$i]['name'] = $row->name;
                    $this->property['peliharalist'][$i]['attachment'] = $row->attachment;
                    $this->property['peliharalist'][$i]['notes'] = $row->notes;
                    $this->property['peliharalist'][$i]['tipe'] = $row->tipe;
                    $this->property['peliharalist'][$i]['type'] = $row->type;
                    
                    if($i < count($result)){ $i++; }
                }
            }
            else
            {
                $this->property['peliharalist'][$i]['scheduleid'] = "";
                $this->property['peliharalist'][$i]['schedule_date'] = "";
                $this->property['peliharalist'][$i]['assetid'] = "";
                $this->property['peliharalist'][$i]['name'] = "";
                $this->property['peliharalist'][$i]['attachment'] = "";
                $this->property['peliharalist'][$i]['notes'] = "";
                $this->property['peliharalist'][$i]['tipe'] = "";
                $this->property['peliharalist'][$i]['type'] = "";
            }
        }
}

/* End of file maint.php */
/* Location: ./applications/frontend/controllers/maint.php */

