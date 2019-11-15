<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captchasession {
    
    public $currentcaptcha;
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function setcaptcha()
    {
        $this->load->helper("captcha");
        $vals = array(
            'img_path' => './assets/captcha/',
            'img_url' => base_url().'assets/captcha/',
            //'font_path' => './system/fonts/impact.ttf',
            'img_width' => '90',
            'img_height' => 40,
            'expiration' => 90,
            'word' => substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, 6)
        );
        $cap = create_captcha($vals);
        $captcha = array(
            "captchatime"=>date("Y-m-d H:i:s"),
            "ipaddress"=>$_SERVER['REMOTE_ADDR'],
            "exptime"=>time() - $vals['expiration'],
            "word"=>$cap['word'],
            "image"=>$cap['image']
        );
        
        return $captcha;
    }
}

/* End of file captchasession.php */
/* Location: ./applications/backend/libraries/captchasession.php */
