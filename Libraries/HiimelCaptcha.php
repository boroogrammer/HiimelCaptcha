<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class HO_HiimelCaptcha {

    public function __construct($params) {
        $this->CI = & $params[0];
        $this->CI->load->library('session');
    }

    public function createImage($word_size) {
        /* config */
        $number_arr = array('9', '8', '7', '6', '5', '4', '3', '2', '1', '0');
        $font_file = APPPATH . 'libraries/fonts/luggerbu.ttf';
        $char_left = 8;

        /* generate word as number */
        $word = array();
        for ($i = 0; $i < $word_size; $i++) {
            $rnd = rand(0, 9);
            $word[] = $number_arr[$rnd];
        }

        /* create black image */
        $img = imagecreatetruecolor(120, 30); /* Create a black image */
        /* background color */
        $bgc = imagecolorallocate($img, 255, 255, 255);
        /* create little rectangle */
        imagefilledrectangle($img, 0, 0, 120, 30, $bgc);

        //imagestring($im, 12, 10, 2, "1 2 3 4", $tc);
        //array imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )

        /* generate captcha image by word */
        for ($i = 0; $i < $word_size; $i++) {
            $char = $word[$i];
            $size_limit = rand(11, 15);
            $x_limit = rand(1, 5);
            $y_limit = rand(9, 13);
            $c_b = rand(1, 128);
            $tc = imagecolorallocate($img, $c_b, $c_b, $c_b);
            imagettftext($img, $size_limit, 0, $char_left + $x_limit, 20 * ($y_limit / 10), $tc, $font_file, $char);
            $char_left += 16;
        }
        
        $arr = array(hash('sha512', serialize($word)) => $img);
        $this->CI->session->set_userdata(__CLASS__ . $this->CI->input->ip_address(), $arr);
        return $arr;
    }

    public function check($code) {
        if (strlen($code) < 3)
            return FALSE;
        $word = array();
        for ($i = 0; $i < strlen($code); $i++) {
            $word[] = $code[$i];
        }
        $arr = $this->CI->session->userdata(__CLASS__ . $this->CI->input->ip_address());
        if (!empty($arr)) {
            $this->CI->session->unset_userdata(__CLASS__ . $this->CI->input->ip_address());
            $key = hash('sha512', serialize($word));
            return isset($arr[$key]) ? TRUE : FALSE;
        }
        return FALSE;
    }

}
