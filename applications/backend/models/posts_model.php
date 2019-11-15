<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts_model extends CI_Model {
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function create($data)
    {
        return $this->db->insert("posts", $data);
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
        
    public function update($data)
    {
        $this->db->where("postid", $data['postid']);
        
        return $this->db->update("posts", $data);
    }
    
    public function delete($data)
    {
        $this->db->where("postid", $data['postid']);
        
        return $this->db->delete("posts");
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
                }
            }
            $this->db->where($criteria, NULL, FALSE);
        }
        $this->db->from("posts");
        
        return $this->db->count_all_results();
    }
}

/* End of file posts_model.php */
/* Location: ./applications/backend/models/posts_model.php */
