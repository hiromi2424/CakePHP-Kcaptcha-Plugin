<?php

class CaptchaHelper extends AppHelper {
	var $helpers = array('Html');
	function render($url = null) {
		if ($url === null) {
			$url = array('plugin' => 'kcaptcha', 'controller' => 'captcha', 'action' => 'render_captcha');
		}
		return sprintf('<img src="%s" />', $this->Html->url($url));
	}
}
