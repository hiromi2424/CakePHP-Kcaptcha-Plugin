<?php

class CaptchableBehavior extends ModelBehavior {
	var $answerProperty = 'captchaAnswer';
	var $field = 'captcha';
	var $rule = 'captcha';

	function setup(&$model, $config = array()) {
		$this->_set($config);
	}

	function setCaptchaAnswer(&$model, $answer) {
		$model->{$this->answerProperty} = $answer;
	}

	function requireCaptcha(&$model, $yes = true) {
		$model->validate[$this->field][$this->rule]['required'] = $yes;
		$model->validate[$this->field][$this->rule]['allowEmpty'] = !$yes;
	}

	function validCaptcha(&$model, $data) {
		$check = current($data);
		$check = mb_convert_kana($check, 'a');

		if (empty($model->{$this->answerProperty})) {
			return false;
		}
		return $check === $model->{$this->answerProperty};
	}
}

