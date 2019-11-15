<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha_model extends CI_Model {
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function create($data)
    {
        return $this->db->insert("captcha", $data);
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
    	$query = $this->db->get("captcha");
    	
    	return $query->result();
    }
    
    private function readbyparams($params)
    {
    	$criteria = "";
    	foreach($params as $k=>$v)
    	{
    		switch($k)
    		{
    			case "word":
                            $criteria .= !empty($criteria) ? " AND " : "";
                            $criteria .= " word = '".$v."'";
                            break;
                        case "ipaddress":
                            $criteria .= !empty($criteria) ? " AND " : "";
                            $criteria .= " ipaddress = '".$v."'";
                            break;
                        case "exptime":
                            $criteria .= !empty($criteria) ? " AND " : "";
                            $criteria .= " exptime < ".$v;
                            break;
                        case "inputtime":
                            $criteria .= !empty($criteria) ? " AND " : "";
                            $criteria .= " exptime > ".$v;
                            break;
    		}
    	}
    	
    	if(!empty($criteria))
    	{
    		$this->db->where($criteria, NULL, FALSE);
    		$query = $this->db->get("captcha");
    		
                return $query->result();
    	}
    	else
    	{
    		$query = $this->db->get("captcha");
    		return $query->result();
    	}
    }
        
    public function update($data)
    {
        $this->db->where("word", $data['word']);
        
        return $this->db->update("captcha", $data);
    }
    
    public function delete($data)
    {
        $this->db->where(" exptime < '".$data['exptime']."' ", NULL, FALSE);
        
        return $this->db->delete("captcha");
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
                    case "word":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " word = '".$v."'";
                        break;
                    case "ipaddress":
                        $criteria .= !empty($criteria) ? " AND " : "";
                        $criteria .= " ipaddress = '".$v."'";
                        break;
                }
            }
            $this->db->where($criteria, NULL, FALSE);
        }
        $this->db->from("captcha");
        
        return $this->db->count_all_results();
    }
}

/* End of file captcha_model.php */
/* Location: ./applications/backend/models/captcha_model.php */
