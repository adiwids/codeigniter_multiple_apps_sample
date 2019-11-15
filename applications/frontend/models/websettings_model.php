<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Websettings_model extends CI_Model {
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function create($data)
    {
        return $this->db->insert("websettings", $data);
    }
    
    public function read($params = null)
    {
        if(!is_null($params) || count($params) > 0)
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
    	$query = $this->db->get("websettings");
    	
    	return $query->result();
    }
    
    private function readbyparams($params)
    {
    	$criteria = "";
    	foreach($params as $k=>$v)
    	{
    		switch($k)
    		{
    			case "userid":
    				$criteria .= !empty($criteria) ? " AND " : "";
    				$criteria .= " userid = ".$v;
    				break;
                        case "limit":
                            $criteria .= !empty($criteria) ? " LIMIT ".$v : "";
                            break;
                        case "offset":
                            $criteria .= is_numeric(strpos($criteria, "LIMIT")) ? ", ".$v : "";
                            break;
    		}
    	}
    	
    	if(!empty($criteria))
    	{
    		$this->db->where($criteria, NULL, FALSE);
    		$query = $this->db->get("websettings");
    		
    		return $query->result();
    	}
    	else
    	{
    		$query = $this->db->get("websettings");
    		return $query->result();
    	}
    }
        
    public function update($data)
    {
        $this->db->where("userid", $data['userid']);
        
        return $this->db->update("websettings", $data);
    }
    
    public function delete($data)
    {
        $this->db->where("userid", $data['userid']);
        
        return $this->db->delete("websettings");
    }
    
    public function count($params)
    {
    	if(!is_null($params) || count($params) > 0)
        {
            $criteria = "";
            foreach($params as $k=>$v)
            {
                switch($k)
                {
                    case "userid":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " userid = ".$v;
                        break;
                    /*case "title":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " title LIKE '%".$v."%'";
                        break;
                    case "stricttitle":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " title = '".$v."'";
                        break;*/
                }
            }
            $this->db->where($criteria, NULL, FALSE);
        }
        $this->db->from("websettings");
        
        return $this->db->count_all_results();
    }
}

/* End of file websettings_model.php */
/* Location: ./applications/backend/models/websettings_model.php */
