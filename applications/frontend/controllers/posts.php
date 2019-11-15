<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends CI_Controller {

        private $property;
        
        public function __construct()
        {
            parent::__construct();
            $this->load->model("posts_model");
            $this->load->model("websettings_model");
            $this->load->model("schedule_model");
        }
        
	public function index()
	{
                $this->getwebsettings();
                $this->getpostslist();
                $this->getperawatanlist();
                $this->getperbaikanlist();
                $this->getpemeliharaanlist();
		$this->load->view("postpage", $this->property);
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
            $result = $this->posts_model->postslist(array(
                "postid"=>$pid,
                "offset"=>0,
                "limit"=>1
                )
            );
            $i = 0;
            if(count($result) > 0)
            {
                foreach($result as $row)
                {
                    $this->property['postslist'][$i]['postid'] = $row->postid;
                    $this->property['postslist'][$i]['posttitle'] = $row->posttitle;
                    $this->property['postslist'][$i]['tag'] = $row->tag;
                    $this->property['postslist'][$i]['created_by'] = $row->created_by;
                    $this->property['postslist'][$i]['last_updated_at'] = $row->last_updated_at;
                    $this->property['postslist'][$i]['postdate'] = $row->postdate;
                    $this->property['postslist'][$i]['content'] = $row->content;
                    $this->property['postslist'][$i]['attachmentid'] = $row->attachmentid;
                    $this->property['postslist'][$i]['author'] = $row->author;
                    $this->property['postslist'][$i]['caption'] = $row->caption;
                    $this->property['postslist'][$i]['attachment'] = $row->attachment;
                    $this->property['postslist'][$i]['attachmentdate'] = $row->attachmentdate;
                    if($i < count($result)){ $i++; }
                }
            }
            else
            {
                $this->property['postslist'][$i]['postid'] = "";
                $this->property['postslist'][$i]['posttitle'] = "";
                $this->property['postslist'][$i]['tag'] = "";
                $this->property['postslist'][$i]['created_by'] = "";
                $this->property['postslist'][$i]['last_updated_at'] = "";
                $this->property['postslist'][$i]['postdate'] = "";
                $this->property['postslist'][$i]['content'] = "";
                $this->property['postslist'][$i]['attachmentid'] = "";
                $this->property['postslist'][$i]['author'] = "";
                $this->property['postslist'][$i]['caption'] = "";
                $this->property['postslist'][$i]['attachment'] = "";
                $this->property['postslist'][$i]['attachmentdate'] = "";
            }
            
            $this->getwebsettings();
            $this->getperawatanlist();
            $this->getperbaikanlist();
            $this->getpemeliharaanlist();
            $this->load->view("postpage", $this->property);
        }
        
        private function getpostslist()
        {
            $result = $this->posts_model->postslist(array(
                "offset"=>0,
                "limit"=>2
                )
            );
            $i = 0;
            if(count($result) > 0)
            {
                foreach($result as $row)
                {
                    $this->property['postslist'][$i]['postid'] = $row->postid;
                    $this->property['postslist'][$i]['posttitle'] = $row->posttitle;
                    $this->property['postslist'][$i]['tag'] = $row->tag;
                    $this->property['postslist'][$i]['created_by'] = $row->created_by;
                    $this->property['postslist'][$i]['last_updated_at'] = $row->last_updated_at;
                    $this->property['postslist'][$i]['postdate'] = $row->postdate;
                    $this->property['postslist'][$i]['content'] = $row->content;
                    $this->property['postslist'][$i]['attachmentid'] = $row->attachmentid;
                    $this->property['postslist'][$i]['author'] = $row->author;
                    $this->property['postslist'][$i]['caption'] = $row->caption;
                    $this->property['postslist'][$i]['attachment'] = $row->attachment;
                    $this->property['postslist'][$i]['attachmentdate'] = $row->attachmentdate;
                    if($i < count($result)){ $i++; }
                }
            }
            else
            {
                $this->property['postslist'][$i]['postid'] = "";
                $this->property['postslist'][$i]['posttitle'] = "";
                $this->property['postslist'][$i]['tag'] = "";
                $this->property['postslist'][$i]['created_by'] = "";
                $this->property['postslist'][$i]['last_updated_at'] = "";
                $this->property['postslist'][$i]['postdate'] = "";
                $this->property['postslist'][$i]['content'] = "";
                $this->property['postslist'][$i]['attachmentid'] = "";
                $this->property['postslist'][$i]['author'] = "";
                $this->property['postslist'][$i]['caption'] = "";
                $this->property['postslist'][$i]['attachment'] = "";
                $this->property['postslist'][$i]['attachmentdate'] = "";
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

/* End of file posts.php */
/* Location: ./applications/frontend/controllers/posts.php */

