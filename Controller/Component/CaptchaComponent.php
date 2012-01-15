<?php

class CaptchaComponent extends Object {
	var $components = array('Session');
	var $sessionKey = 'Kcaptcha.answer';
	var $model = null;
	var $setupHelper = true;
	var $autoSetAnswer = true;

	function initialize(&$controller, $settings = array()) {
		$this->_set($settings);
		if ($this->model === null) {
			if ($model = $controller->modelClass) {
				$this->model = $controller->modelClass;
			}
		}
		if ($this->setupHelper && !isset($controller->helpers['Kcaptcha.Captcha']) && !in_array('Kcaptcha.Captcha', $controller->helpers)) {
			$controller->helpers[] = 'Kcaptcha.Captcha';
		}
	}

	function startup(&$controller) {
		if ($this->model !== null && $this->autoSetAnswer) {
			$model =& ClassRegistry::init($this->model);
			if (!$model->Behaviors->attached('Kcaptcha.Captchable')) {
				$model->Behaviors->attach('Kcaptcha.Captchable');
			}
			$model->setCaptchaAnswer($this->Session->read($this->sessionKey));
		}
	}

	function clearSession() {
		$this->Session->delete($this->sessionKey);
	}

	function render() { 
		if (!App::import('Vendor', 'Kcaptcha' . DS . 'Kcaptcha')) {
			App::import('Vendor', 'Kcaptcha.Kcaptcha' . DS . 'Kcaptcha');
		}
		$kcaptcha = new KCAPTCHA(); 
		$this->Session->write($this->sessionKey, $kcaptcha->getKeyString());
	} 
}