<?php

App::import('Helper', 'Kcaptcha.Captcha');

class CaptchaHelperTestCase extends CakeTestCase {

	public function startTest() {
		$this->Helper = new CaptchaHelper;
	}

	public function endTest() {
		unset($this->Helper);
	}

	public function testRender() {
		$url = h(Router::url(array('controller' => 'captcha', 'action' => 'render_captcha', 'plugin' => 'kcaptcha')));
		$expected = sprintf('|src="%s"|', preg_quote($url));
		$this->assertPattern($expected, $this->Helper->render());

		$url = h(Router::url(array('controller' => 'pages', 'action' => 'display', 'home')));
		$expected = sprintf('|src="%s"|', preg_quote($url));
		$this->assertPattern($expected, $this->Helper->render($url));
	}

}