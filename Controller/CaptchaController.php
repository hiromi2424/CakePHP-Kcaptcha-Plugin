<?php

class CaptchaController extends KcaptchaAppController {
	public $uses = array();
	public $components = array('Kcaptcha.Captcha' => array('autoSetAnswer' => false));

	public function beforeFilter() {
		parent::beforeFilter();
		if (isset($this->Auth)) {
			$this->Auth->allow('render_captcha');
		}
	}

	public function render_captcha() {
		$this->Captcha->render();
		$this->_stop();
	}
}