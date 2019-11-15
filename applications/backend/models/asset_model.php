<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asset_model extends CI_Model {
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function create($data)
    {
        return $this->db->insert("assets", $data);
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
    	$query = $this->db->get("assets");
    	
    	return $query->result();
    }
    
    private function readbyparams($params)
    {
    	$criteria = "";
    	foreach($params as $k=>$v)
    	{
    		switch($k)
    		{
    			case "assetid":
    				$criteria .= !empty($criteria) ? " AND " : "";
    				$criteria .= " assetid = ".$v;
    				break;
                        case "code":
    				$criteria .= !empty($criteria) ? " AND " : "";
    				$criteria .= " code = '".$v."'";
    				break;
                        case "name":
    				$criteria .= !empty($criteria) ? " AND " : "";
    				$criteria .= " `name` LIKE '%".$v."%'";
    				break;
    		}
    	}
    	
    	if(!empty($criteria))
    	{
    		$this->db->where($criteria, NULL, FALSE);
    		$query = $this->db->get("assets");
    		
    		return $query->result();
    	}
    	else
    	{
    		$query = $this->db->get("assets");
    		return $query->result();
    	}
    }
        
    public function update($data)
    {
        $this->db->where("assetid", $data['assetid']);
        
        return $this->db->update("assets", $data);
    }
    
    public function delete($data)
    {
        $this->db->where("assetid", $data['assetid']);
        
        return $this->db->delete("assets");
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
                    case "assetid":
    				$criteria .= !empty($criteria) ? " AND " : "";
    				$criteria .= " assetid = ".$v;
    				break;
                        case "code":
    				$criteria .= !empty($criteria) ? " AND " : "";
    				$criteria .= " code = '".$v."'";
    				break;
                        case "name":
    				$criteria .= !empty($criteria) ? " AND " : "";
    				$criteria .= " `name` LIKE '%".$v."%'";
    				break;
                    
                }
            }
            $this->db->where($criteria, NULL, FALSE);
        }
        $this->db->from("assets");
        
        return $this->db->count_all_results();
    }
}

/* End of file asset_model.php */
/* Location: ./applications/backend/models/asset_model.php */
