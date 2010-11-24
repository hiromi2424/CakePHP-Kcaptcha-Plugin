<?php

class CaptchaComponent extends Object {
	var $components = array('Session');
	var $sessionKey = 'Kcaptcha.answer';
	var $model = null;
	var $autoSetAnswer = true;

	function initialize(&$controller, $settings = array()) {
		$this->_set($settings);
		if ($this->model === null) {
			if ($model = $controller->modelClass) {
				$this->model = $controller->modelClass;
			}
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


	function render() { 
		App::import('Vendor', 'Kcaptcha.Kcaptcha.Kcaptcha'); 
		$kcaptcha = new KCAPTCHA(); 
		$this->Session->write($this->sessionKey, $kcaptcha->getKeyString()); 
	} 
}