<?php

class CaptchaComponent extends Object {
	public $components = array('Session');
	public $sessionKey = 'Kcaptcha.answer';
	public $model = null;
	public $setupHelper = true;
	public $autoSetAnswer = true;

	public function initialize(&$controller, $settings = array()) {
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

	public function startup(&$controller) {
		if ($this->model !== null && $this->autoSetAnswer) {
			$model =& ClassRegistry::init($this->model);
			if (!$model->Behaviors->attached('Kcaptcha.Captchable')) {
				$model->Behaviors->attach('Kcaptcha.Captchable');
			}
			$model->setCaptchaAnswer($this->Session->read($this->sessionKey));
		}
	}

	public function clearSession() {
		$this->Session->delete($this->sessionKey);
	}

	public function render() { 
		if (!App::import('Vendor', 'Kcaptcha' . DS . 'Kcaptcha')) {
			App::import('Vendor', 'Kcaptcha.Kcaptcha' . DS . 'Kcaptcha');
		}
		$kcaptcha = new KCAPTCHA(); 
		$this->Session->write($this->sessionKey, $kcaptcha->getKeyString());
	} 
}