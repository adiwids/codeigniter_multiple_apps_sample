<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts_model extends CI_Model {
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function read($params = null)
    {
        if(!is_null($params) && count($params) > 0)
        {
        	return $this->readbyparams($params);
        }
        else
        {
        	return $this->readall();
        }
        
    }
    
    private function readall()
    {
    	$query = $this->db->get("posts");
    	
    	return $query->result();
    }
    
    private function readbyparams($params)
    {
    	$criteria = "";
        $uselimit = false;
    	foreach($params as $k=>$v)
    	{
    		switch($k)
    		{
    			case "postid":
    				$criteria .= !empty($criteria) ? " AND " : "";
    				$criteria .= " postid = ".$v;
    				break;
                        case "title":
                            $criteria .= !empty($criteria) ? " AND " : "";
                            $criteria .= " title LIKE '%".$v."%'";
                            break;
                        case "stricttitle":
                            $criteria .= !empty($criteria) ? " AND " : "";
                            $criteria .= " title = '".$v."'";
                            break;
                        case "tag":
                            $criteria .= !empty($criteria) ? " AND " : "";
                            $criteria .= " tag LIKE '%".$v."%'";
                            break;
                        case "stricttag":
                            $criteria .= !empty($criteria) ? " AND " : "";
                            $criteria .= " tag = '".$v."'";
                            break;
                        case "offset":
                            $criteria .= " LIMIT ".$v;
                            $uselimit = true;
                            break;
                        case "limit":
                            if($uselimit)
                            {
                                $criteria .= ", ".$v;
                                $uselimit = true;
                            }
                            break;
    		}
    	}
    	
    	if(!empty($criteria))
    	{
    		$this->db->where($criteria, NULL, FALSE);
    		$query = $this->db->get("posts");
    		
    		return $query->result();
    	}
    	else
    	{
    		$query = $this->db->get("posts");
    		return $query->result();
    	}
    }
        
    public function count($params = null)
    {
        if(!is_null($params) || count($params) > 0)
        {
            $criteria = "";
            foreach($params as $k=>$v)
            {
                switch($k)
                {
                    case "postid":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " postid = ".$v;
                        break;
                    case "title":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " title LIKE '%".$v."%'";
                        break;
                    case "stricttitle":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " title = '".$v."'";
                        break;
                    case "tag":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " tag LIKE '%".$v."%'";
                        break;
                    case "stricttag":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " tag = '".$v."'";
                        break;
                    case "offset":
                        $criteria .= " LIMIT ".$v;
                        $uselimit = true;
                        break;
                    case "limit":
                        if($uselimit)
                        {
                            $criteria .= ", ".$v;
                            $uselimit = true;
                        }
                        break;
                }
            }
            $this->db->where($criteria, NULL, FALSE);
        }
        $this->db->from("posts");
        
        return $this->db->count_all_results();
    }
    
    public function postslist($params)
    {
        $criteria = "";
        $sql = "
            SELECT p.postid,p.title as posttitle,p.tag,p.created_by,p.last_updated_at,p.created_at as postdate,p.content,p.attachmentid,
            u.username as author,l.caption,l.file_url as attachment,l.uploaded_at as attachmentdate
            FROM posts p
            INNER JOIN users u ON u.userid=p.created_by
            LEFT JOIN libraries l ON l.itemid=p.attachmentid
        ";
        if(!is_null($params))
        {
            foreach($params as $k=>$v)
            {
                switch($k)
                {
                    case "postid":
                        $criteria .= !empty($criteria) ? " AND " : " WHERE ";
                        $criteria .= " p.postid = ".$v;
                        break;
                    case "stricttag":
                        $criteria .= !empty($criteria) ? " AND " : " WHERE ";
                        $criteria .= " p.tag = '".$v."'";
                        break;
                }
            }
            $sql .= $criteria;
            $sql .= " ORDER BY p.last_updated_at DESC ";
            
            $criteria = "";
            $uselimit = false;
            foreach($params as $k=>$v)
            {
                switch($k)
                {
                    case "offset":
                        $criteria .= " LIMIT ".$v;
                        $uselimit = true;
                        break;
                    case "limit":
                        if($uselimit)
                        {
                            $criteria .= ", ".$v;
                            $uselimit = true;
                        }
                        break;
                }
            }
            $sql .= $criteria;
        }
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
}

/* End of file posts_model.php */
/* Location: ./applications/frontend/models/posts_model.php */
