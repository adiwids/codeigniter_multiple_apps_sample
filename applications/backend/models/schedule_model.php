<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_model extends CI_Model {
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function create($data)
    {
        return $this->db->insert("schedules", $data);
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
    	foreach($params as $k=>$v)
    	{
    		switch($k)
    		{
    			case "scheduleid":
    				$criteria .= !empty($criteria) ? " AND " : "";
    				$criteria .= " scheduleid = ".$v;
    				break;
                        case "schedule_date":
    				$criteria .= !empty($criteria) ? " AND " : "";
    				$criteria .= " schedule_date = '".$v."'";
    				break;
                        case "assetid":
    				$criteria .= !empty($criteria) ? " AND " : "";
    				$criteria .= " assetid = ".$v;
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
        
    public function update($data)
    {
        $this->db->where("scheduleid", $data['scheduleid']);
        
        return $this->db->update("schedules", $data);
    }
    
    public function delete($data)
    {
        $this->db->where("scheduleid", $data['scheduleid']);
        
        return $this->db->delete("schedules");
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
                    case "scheduleid":
                            $criteria .= !empty($criteria) ? " AND " : "";
                            $criteria .= " assetid = ".$v;
                            break;
                    case "date":
                            $criteria .= !empty($criteria) ? " AND " : "";
                            $criteria .= " schedule_date = '".$v."'";
                            break;
                    case "assetid":
                            $criteria .= !empty($criteria) ? " AND " : "";
                            $criteria .= " assetid = ".$v;
                            break;
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
            SELECT s.scheduleid,s.schedule_date,s.assetid,CONCAT(a.code,'-',a.name) AS asset,
            s.type,
            CASE s.type 
                WHEN 0 THEN 'Perbaikan' 
                WHEN 1 THEN 'Perawatan' 
                WHEN 2 THEN 'Pemeliharaan' END AS tipe,
            s.file_url,s.notes
            FROM schedules s
            INNER JOIN assets a ON a.assetid=s.assetid
        ";
        foreach($params as $k=>$v)
    	{
    		switch($k)
    		{
                    case "scheduleid":
                            $criteria .= !empty($criteria) ? " OR " : " WHERE ";
                            $criteria .= " s.scheduleid = ".$v;
                            break;
                    case "name":
                            $criteria .= !empty($criteria) ? " OR " : " WHERE ";
                            $criteria .= " a.name LIKE '%".$v."%' ";
                            break;
                    case "code":
                            $criteria .= !empty($criteria) ? " OR " : " WHERE ";
                            $criteria .= " a.code LIKE '%".$v."%' ";
                            break;
                    case "notes":
                            $criteria .= !empty($criteria) ? " OR " : " WHERE ";
                            $criteria .= " s.notes LIKE '%".$v."%' ";
                            break;
    		}
    	}
        if(!empty($criteria))
        {
            $sql .= $criteria;
        }
        $sql .= "
            ORDER BY s.schedule_date DESC 
        ";
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    public function getnewid() {
        $criteria = "";
        $sql = "
            SELECT scheduleid FROM schedules ORDER BY scheduleid DESC LIMIT 0,1
        ";
        $result = $this->db->query($sql);
        $id = null;
        foreach($result as $row) {
            $id = $row->scheduleid;
        }
        
        return $id;
    }
}

/* End of file schedule_model.php */
/* Location: ./applications/backend/models/schedule_model.php */
