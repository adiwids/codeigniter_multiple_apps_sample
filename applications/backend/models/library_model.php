<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Library_model extends CI_Model {
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function create($data)
    {
        return $this->db->insert("libraries", $data);
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
    	$query = $this->db->get("libraries");
    	
    	return $query->result();
    }
    
    private function readbyparams($params)
    {
    	$criteria = "";
    	foreach($params as $k=>$v)
    	{
    		switch($k)
    		{
    			case "itemid":
    				$criteria .= !empty($criteria) ? " AND " : "";
    				$criteria .= " itemid = ".$v;
    				break;
    		}
    	}
    	
    	if(!empty($criteria))
    	{
    		$this->db->where($criteria, NULL, FALSE);
    		$query = $this->db->get("libraries");
    		
    		return $query->result();
    	}
    	else
    	{
    		$query = $this->db->get("libraries");
    		return $query->result();
    	}
    }
        
    public function update($data)
    {
        $this->db->where("itemid", $data['itemid']);
        
        return $this->db->update("libraries", $data);
    }
    
    public function delete($data)
    {
        $this->db->where("itemid", $data['itemid']);
        
        return $this->db->delete("libraries");
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
                    case "itemid":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " itemid = ".$v;
                        break;
                    
                }
            }
            $this->db->where($criteria, NULL, FALSE);
        }
        $this->db->from("libraries");
        
        return $this->db->count_all_results();
    }
    
    public function getrecordid($params)
    {
        $criteria = "";
    	foreach($params as $k=>$v)
    	{
    		switch($k)
    		{
    			case "url":
    				$criteria .= !empty($criteria) ? " AND " : "";
    				$criteria .= " file_url = '".$v."'";
    				break;
    		}
    	}
    	
    	if(!empty($criteria))
    	{
    		$this->db->where($criteria, NULL, FALSE);
    		$query = $this->db->get("libraries");
    		$result = $query->result();
    	}
    	else
    	{
    		$query = $this->db->get("libraries");
    		$result = $query->result();
    	}
        
        foreach($result as $row)
        {
            $id = $row->itemid;
        }
        
        return $id;
    }
}

/* End of file library_model.php */
/* Location: ./applications/backend/models/library_model.php */
