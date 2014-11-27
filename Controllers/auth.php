public function login() {
	//captcha library in codeigniter
	$this->load->library('HiimelCaptcha', array($this), 'captcha');
	$captcha_code = $this->input->post('captcha_code');

	if ($this->captcha->check($captcha_code)) {
		$posted = $this->input->post();
		....
	} else {
		....
	}
	
	$this->view('login');
}