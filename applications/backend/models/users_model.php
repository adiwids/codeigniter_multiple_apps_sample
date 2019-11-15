<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function create($data)
    {
        return $this->db->insert("users", $data);
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
    	$query = $this->db->get("users");
    	
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
                        case "username":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " username LIKE '%".$v."%'";
                        break;
                    case "strictuname":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " username = '".$v."'";
                        break;
                    case "enc_password":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " enc_password = '".$v."'";
                        break;
    		}
    	}
    	
    	if(!empty($criteria))
    	{
    		$this->db->where($criteria, NULL, FALSE);
    		$query = $this->db->get("users");
    		
    		return $query->result();
    	}
    	else
    	{
    		$query = $this->db->get("users");
    		return $query->result();
    	}
    }
        
    public function update($data)
    {
        $this->db->where("userid", $data['userid']);
        
        return $this->db->update("users", $data);
    }
    
    public function delete($data)
    {
        $this->db->where("userid", $data['userid']);
        
        return $this->db->delete("users");
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
                    case "userid":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " userid = ".$v;
                        break;
                    case "username":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " username LIKE '%".$v."%'";
                        break;
                    case "strictuname":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " username = '".$v."'";
                        break;
                    case "enc_password":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " enc_password = '".$v."'";
                        break;
                }
            }
            $this->db->where($criteria, NULL, FALSE);
        }
        $this->db->from("users");
        
        return $this->db->count_all_results();
    }
}

/* End of file users_model.php */
/* Location: ./applications/backend/models/users_model.php */
