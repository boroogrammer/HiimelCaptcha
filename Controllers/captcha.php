<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class captcha extends HO_Admin {

    public function __construct() {
        parent::__construct(FALSE);

        //image captcha library
        $this->load->library('HiimelCaptcha', array($this), 'captcha');
    }

    public function image() {
        $this->xhr_protect();

        header("Content-type: image/jpeg");

        $arr = $this->captcha->createImage(6);
        $im = reset(array_values($arr));
        ob_start();
        imagejpeg($im);
        echo 'data:image/jpeg;base64,' . base64_encode(ob_get_clean());
    }

}
