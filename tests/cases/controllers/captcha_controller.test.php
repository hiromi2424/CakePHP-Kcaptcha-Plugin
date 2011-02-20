<?php

App::import('Controller', 'Kcaptcha.Captcha');

class TestCaptchaController extends CaptchaController {

	function header() {
	}

	function _stop() {
	}

}


class CaptchaControllerTestCase extends CakeTestCase {

	function startTest() {
		$this->Controller = new TestCaptchaController;
		$this->Controller->params['action'] = 'render_captcha';
	}

	function endTest() {
		$this->Controller->Captcha->Session->delete('Kcaptcha.answer');
		unset($this->Controller);
		ClassRegistry::flush();
	}

	function _render() {
		ob_start();
		$this->Controller->render_captcha();
		$result = ob_get_contents();
		ob_end_clean();
		header("Content-Type:");
		return $result;
	}

	function testRenderCaptcha() {
		$this->Controller->constructClasses();
		$this->Controller->Component->initialize($this->Controller);
		$this->Controller->beforeFilter();
		$this->Controller->Component->startup($this->Controller);
		$result = $this->_render();
		$this->assertFalse(empty($result));
		$sessionData = $this->Controller->Captcha->Session->read('Kcaptcha.answer');
		$this->assertFalse(empty($sessionData));
	}

	function testRenderCaptchaWithAuth() {
		$this->Controller->components[] = 'Auth';
		$this->Controller->constructClasses();
		$this->Controller->Component->initialize($this->Controller);
		$this->Controller->beforeFilter();
		$this->Controller->Component->startup($this->Controller);
		$result = $this->_render();
		$this->assertFalse(empty($result));
		$sessionData = $this->Controller->Captcha->Session->read('Kcaptcha.answer');
		$this->assertFalse(empty($sessionData));
	}

}