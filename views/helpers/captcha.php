<?php

class CaptchaHelper extends AppHelper {

	function render($url = null) {
		if ($url === null) {
			$prefixes = array_flip(Router::prefixes());
			array_walk($prefixes, create_function('&$item', '$item = false;'));
			$url = array('plugin' => 'kcaptcha', 'controller' => 'captcha', 'action' => 'render_captcha') + $prefixes;
		}
		return sprintf('<img src="%s" />', $this->url($url));
	}
}
