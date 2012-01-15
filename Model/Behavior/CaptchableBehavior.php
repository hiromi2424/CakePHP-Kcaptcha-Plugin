<?php

class CaptchableBehavior extends ModelBehavior {

	var $settings = array();

	var $defaultOptions = array(
		'answerProperty' => 'captchaAnswer',
		'field' => 'captcha',
		'rule' => 'captcha',
		'convertKana' => true,
		'trim' => '[\s\p{Zs}\p{Zl}\p{Zp}]',
		'required' => true,
		'setupValidation' => true,
	);

	var $answer;

	function setup(&$model, $config = array()) {
		$this->settings[$model->alias] = array_merge($this->defaultOptions, $config);
		if ($this->settings[$model->alias]['setupValidation']) {
			$this->setupCaptchaValidation($model);
		}
	}

	function setupCaptchaValidation(&$model) {
		$field = $this->settings[$model->alias]['field'];
		$rule = $this->settings[$model->alias]['rule'];

		if (!isset($model->validate[$field][$rule])) {
			$model->validate[$field][$rule] = array();
		}
		$model->validate[$field][$rule] = array_merge(array(
			'rule' => array('validCaptcha'),
			'message' => __d('kcaptcha', 'Not same as shown captcha', true),
		), $model->validate[$field][$rule]);

		$this->requireCaptcha($model, $this->settings[$model->alias]['required']);
	}

	function setCaptchaAnswer(&$model, $answer) {
		$model->{$this->settings[$model->alias]['answerProperty']} = $answer;
	}

	function requireCaptcha(&$model, $yes = true) {
		$field = $this->settings[$model->alias]['field'];
		$rule = $this->settings[$model->alias]['rule'];

		$model->validate[$field][$rule]['required'] = !!$yes;
		$model->validate[$field][$rule]['allowEmpty'] = !$yes;
	}

	function validCaptcha(&$model, $data) {
		$check = current((array)$data);
		if ($this->settings[$model->alias]['convertKana']) {
			$check = mb_convert_kana($check, 'a');
		}
		if ($this->settings[$model->alias]['trim']) {
			$check = $this->_multibyteTrim($check, $this->settings[$model->alias]['trim']);
		}

		if (empty($model->{$this->settings[$model->alias]['answerProperty']})) {
			return false;
		}
		return $check === $model->{$this->settings[$model->alias]['answerProperty']};
	}

	function _multibyteTrim($check, $space) {
		$space = $space === true ? $this->defaultOptions['trim'] : $space;
		return preg_replace("/(^$space+|$space+$)/mu", '', $check);
	}

}

