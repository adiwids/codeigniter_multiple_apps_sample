<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messagebox{
    
    private $property;
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function showmessage($params)
    {
        foreach($params as $k=>$v)
        {
            switch($k)
            {
                case "type":
                    switch($v)
                    {
                        case "INFO_PAGE":
                            $this->property['icon'] = "info.png";break;
                        case "CNFRM_PAGE":
                            $this->property['icon'] = "confirm.png";break;
                        case "ERR_PAGE":
                            $this->property['icon'] = "error.png";break;
                        case "WARN_PAGE":
                            $this->property['icon'] = "warning.png";break;
                        default:
                            $this->property['icon'] = "info.png";break;
                    }
                    break;
                case "module":
                    $this->property['module'] = $v;
                case "message":
                    $this->property['message'] = $v;
                case "backlink":
                    $this->property['backlink'] = $v;
            }
        }
        
        $this->load->view("messagepage", $this->property);
    }
}

/* End of file messagebox.php */
/* Location: ./applications/backend/libraries/messagebox.php */
