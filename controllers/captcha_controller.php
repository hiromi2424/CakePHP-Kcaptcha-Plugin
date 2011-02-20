<?php

class CaptchaController extends KcaptchaAppController {
	var $uses = array();
	var $components = array('Kcaptcha.Captcha' => array('autoSetAnswer' => false));

	function beforeFilter() {
		parent::beforeFilter();
		if (isset($this->Auth)) {
			$this->Auth->allow('render_captcha');
		}
	}

	function render_captcha() {
		$this->Captcha->render();
		$this->_stop();
	}
}