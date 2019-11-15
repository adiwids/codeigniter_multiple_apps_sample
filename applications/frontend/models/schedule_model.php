<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_model extends CI_Model {
    
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
    	$query = $this->db->get("schedules");
    	
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
    			case "scheduleid":
                            $criteria .= !empty($criteria) ? " AND " : "";
                            $criteria .= " scheduleid = ".$v;
                            break;
                        case "type":
                            $criteria .= !empty($criteria) ? " AND " : " ";
                            $criteria .= " type = ".$v;
                            break;
                        case "limit":
                            $criteria .= " LIMIT ".$v;
                            $uselimit = true;
                            break;
                        case "offset":
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
    		$query = $this->db->get("schedules");
    		
    		return $query->result();
    	}
    	else
    	{
    		$query = $this->db->get("schedules");
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
                    
                }
            }
            $this->db->where($criteria, NULL, FALSE);
        }
        $this->db->from("schedules");
        
        return $this->db->count_all_results();
    }
    
    public function schedulelist($params)
    {
        $criteria = "";
        $sql = "
            SELECT s.scheduleid,s.schedule_date,s.assetid,a.name,s.file_url as attachment,s.notes,
            CASE s.type WHEN 0 THEN 'Perbaikan'
            WHEN 1 THEN 'Perawatan'
            WHEN 2 THEN 'Pemeliharaan' END as tipe,
            s.type
            FROM schedules s
            INNER JOIN assets a ON a.assetid=s.assetid
        ";
        if(!is_null($params))
        {
            foreach($params as $k=>$v)
            {
                switch($k)
                {
                    case "scheduleid":
                        $criteria .= !empty($criteria) ? " AND " : " WHERE ";
                        $criteria .= " s.scheduleid = ".$v;
                        break;
                    case "type":
                        $criteria .= !empty($criteria) ? " AND " : " WHERE ";
                        $criteria .= " s.type = ".$v;
                        break;
                }
            }
            $sql .= $criteria;
            $sql .= " ORDER BY s.schedule_date DESC ";
            
            $criteria = "";
            $uselimit = false;
            foreach($params as $k=>$v)
            {
                switch($k)
                {
                    case "limit":
                        $criteria .= " LIMIT ".$v;
                        $uselimit = true;
                        break;
                    case "offset":
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

/* End of file schedule_model.php */
/* Location: ./applications/frontend/models/schedule_model.php */
